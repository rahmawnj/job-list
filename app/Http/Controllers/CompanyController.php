<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Server-side DataTables: balas JSON kalau request AJAX + ada param draw.
        if ($request->ajax() && $request->has('draw')) {
            $draw   = (int) $request->input('draw');
            $start  = (int) $request->input('start', 0);
            $length = (int) $request->input('length', 10);
            $search = trim((string) $request->input('search.value', ''));

            $totalRecords = Company::count();

            $query = Company::query()
                ->withCount('jobs');

            // Global search
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('website', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            $recordsFiltered = (clone $query)->count();

            // Ordering dari DataTables
            $order = $request->input('order.0');
            if ($order && isset($order['column'], $order['dir'])) {
                $columns = ['id', 'logo', 'name', 'email', 'phone', 'jobs_count', 'action'];
                $orderColumn = $columns[(int) $order['column']] ?? 'id';
                $orderDir = $order['dir'] === 'asc' ? 'asc' : 'desc';

                switch ($orderColumn) {
                    case 'name':
                        $query->orderBy('companies.name', $orderDir);
                        break;
                    case 'email':
                        $query->orderBy('companies.email', $orderDir);
                        break;
                    case 'phone':
                        $query->orderBy('companies.phone', $orderDir);
                        break;
                    case 'jobs_count':
                        $query->orderBy('jobs_count', $orderDir);
                        break;
                    default:
                        $query->orderBy('companies.id', $orderDir);
                }
            } else {
                $query->orderBy('companies.id', 'desc');
            }

            $companies = $query->skip($start)->take($length)->get();

            $data = $companies->map(function ($company, $key) use ($start) {
                $logoUrl = $company->logo
                    ? asset('storage/' . $company->logo)
                    : asset('img/default.png');

                return [
                    'no'         => $start + $key + 1,
                    'logo'       => $logoUrl,
                    'name'       => $company->name,
                    'email'      => $company->email,
                    'phone'      => $company->phone,
                    'jobs_count' => (int) $company->jobs_count,
                    'edit_url'   => url('/dashboard/companies/' . $company->id . '/edit'),
                    'show_url'   => url('/dashboard/companies/' . $company->id),
                    'delete_url' => url('/dashboard/companies/' . $company->id),
                ];
            });

            return response()->json([
                'draw'            => $draw,
                'recordsTotal'    => $totalRecords,
                'recordsFiltered' => $recordsFiltered,
                'data'            => $data,
            ]);
        }

        // Bukan request DataTables: render halaman seperti biasa.
        return view('dashboard.companies.index', [
            'title' => 'Companies',
            'companies' => Company::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.companies.create', [
            'title' => 'Companies'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'website' => 'required',
            'show' => 'required',
            'logo' => 'image|file|max:2048'
        ]);
        $validatedData['email'] = $request->email;
        $validatedData['phone'] = $request->phone;
        $validatedData['address'] = $request->address;
        $validatedData['description'] = $request->description;
        if ($request->file('logo')) {
            $validatedData['logo'] = $request->file('logo')->store('uploads/image/companies');
        }
        Company::create($validatedData);
        return redirect('/dashboard/companies')->with('success', 'New Company has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('dashboard.companies.show', [
            'title' => 'Companies',
            'company' => $company
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('dashboard.companies.edit', [
            'title' => 'Companies',
            'company' => $company
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'website' => 'required',
            'show' => 'required',
            'logo' => 'image|file|max:2048'
        ]);
        $validatedData['email'] = $request->email;
        $validatedData['phone'] = $request->phone;
        $validatedData['address'] = $request->address;
        $validatedData['description'] = $request->description;
        if ($request->file('logo')) {
            if ($company->logo) {
                Storage::delete([$company->logo]);
            }
            $validatedData['logo'] = $request->file('logo')->store('uploads/image/companies');
        }
        Company::where('id', $company->id)->update($validatedData);
        return redirect('/dashboard/companies')->with('success', 'Company has been Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        if (count($company->jobs) == 0) {
            if ($company->logo) {
                Storage::delete([$company->logo]);
            }
            Company::destroy($company->id);
            return redirect('/dashboard/companies')->with('success', 'Company has been Deleted');
        } else {
            return redirect('/dashboard/companies')->with('error', 'Delete company failed');
        }
    }
}
