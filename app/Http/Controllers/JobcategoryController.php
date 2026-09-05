<?php

namespace App\Http\Controllers;

use App\Models\Jobcategory;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Storage;

class JobcategoryController extends Controller
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

            $totalRecords = Jobcategory::count();

            $query = Jobcategory::query()
                ->withCount('jobs');

            // Global search
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('slug', 'like', "%{$search}%");
                });
            }

            $recordsFiltered = (clone $query)->count();

            // Ordering dari DataTables
            $order = $request->input('order.0');
            if ($order && isset($order['column'], $order['dir'])) {
                $columns = ['id', 'name', 'slug', 'is_top_category', 'jobs_count', 'action'];
                $orderColumn = $columns[(int) $order['column']] ?? 'id';
                $orderDir = $order['dir'] === 'asc' ? 'asc' : 'desc';

                switch ($orderColumn) {
                    case 'name':
                        $query->orderBy('jobcategories.name', $orderDir);
                        break;
                    case 'slug':
                        $query->orderBy('jobcategories.slug', $orderDir);
                        break;
                    case 'jobs_count':
                        $query->orderBy('jobs_count', $orderDir);
                        break;
                    default:
                        $query->orderBy('jobcategories.id', $orderDir);
                }
            } else {
                $query->orderBy('jobcategories.id', 'desc');
            }

            $jobcategories = $query->skip($start)->take($length)->get();

            $data = $jobcategories->map(function ($jobcategory, $key) use ($start) {
                return [
                    'no'         => $start + $key + 1,
                    'name'       => $jobcategory->name,
                    'slug'       => $jobcategory->slug,
                    'is_top_category' => $jobcategory->is_top_category,
                    'logo_url'   => $jobcategory->logo ? asset('storage/' . $jobcategory->logo) : null,
                    'jobs_count' => (int) $jobcategory->jobs_count,
                    'edit_url'   => url('/dashboard/jobcategories/' . $jobcategory->id . '/edit'),
                    'delete_url' => url('/dashboard/jobcategories/' . $jobcategory->id),
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
        return view('dashboard.jobcategories.index', [
            'title' => 'Job Categories',
            'jobcategories' => Jobcategory::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.jobcategories.create', [
            'title' => 'Job Categories'
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
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:jobcategories',
            'logo' => 'nullable|image|file|max:2048',
        ]);

        Jobcategory::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'is_top_category' => $request->boolean('is_top_category'),
            'logo' => $request->file('logo')?->store('uploads/image/jobcategories', 'public'),
        ]);
        return redirect('/dashboard/jobcategories')->with('success', 'New Job Category has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jobcategory  $jobcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Jobcategory $jobcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jobcategory  $jobcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Jobcategory $jobcategory)
    {
        return view('dashboard.jobcategories.edit', [
            'title' => 'Job Categories',
            'jobcategory' => $jobcategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jobcategory  $jobcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jobcategory $jobcategory)
    {
        if($request->slug == $jobcategory->slug){
            $rules_slug = 'required';
        } else {
            $rules_slug = 'required|unique:jobcategories';
        }
        $request->validate([
            'name' => 'required',
            'slug' => $rules_slug,
            'logo' => 'nullable|image|file|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'is_top_category' => $request->boolean('is_top_category'),
        ];
        if ($request->hasFile('logo')) {
            if ($jobcategory->logo) {
                Storage::disk('public')->delete($jobcategory->logo);
            }
            $data['logo'] = $request->file('logo')->store('uploads/image/jobcategories', 'public');
        }
        $jobcategory->update($data);
        return redirect('/dashboard/jobcategories')->with('success', 'Job Category has been Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jobcategory  $jobcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jobcategory $jobcategory)
    {
        if (count($jobcategory->jobs) == 0) {
            Jobcategory::destroy($jobcategory->id);
            return redirect('/dashboard/jobcategories')->with('success', 'Job Category has been Deleted');
        } else {
            return redirect('/dashboard/jobcategories')->with('error', 'Delete Job Category failed');
        }
    }

    public function slug(Request $request)
    {
        $slug = SlugService::createSlug(Jobcategory::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
