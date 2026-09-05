<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function form(Request $request)
    {
        if ($request->query('tab') === 'setting') {
            $milestoneSteps = Content::firstOrCreate(
                ['name' => 'MILESTONE_STEPS'],
                ['description' => '']
            );

            $milestoneStatuses = Content::firstOrCreate(
                ['name' => 'MILESTONE_STATUSES'],
                ['description' => '']
            );

            // Remove the old hard-coded defaults from earlier versions.
            if ($milestoneSteps->description === 'send_resume,interview_1,interview_2,mcu,offering,joint') {
                $milestoneSteps->update(['description' => '']);
            }

            if ($milestoneStatuses->description === 'pending,active,completed') {
                $milestoneStatuses->update(['description' => '']);
            }

            return view('dashboard.settings.index', [
                'title' => 'Setting',
                'milestoneSteps' => $milestoneSteps->fresh(),
                'milestoneStatuses' => $milestoneStatuses->fresh(),
            ]);
        }

        return view('dashboard.content.index', [
            'title' => 'Content',
            'content' => Content::all()
        ]);
    }

    public function store(Request $request)
    {
        if ($request->input('section') === 'setting') {
            $validatedData = $request->validate([
                'milestone_steps' => ['nullable', 'string'],
                'milestone_statuses' => ['nullable', 'string'],
            ]);

            $normalize = function ($value) {
                return collect(explode(',', $value ?? ''))
                    ->map(fn ($item) => trim($item))
                    ->filter()
                    ->unique()
                    ->values()
                    ->implode(',');
            };

            Content::updateOrCreate(
                ['name' => 'MILESTONE_STEPS'],
                ['description' => $normalize($validatedData['milestone_steps'] ?? '')]
            );

            Content::updateOrCreate(
                ['name' => 'MILESTONE_STATUSES'],
                ['description' => $normalize($validatedData['milestone_statuses'] ?? '')]
            );

            return redirect('/dashboard/content?tab=setting')->with('success', 'Settings have been updated');
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'hero_description' => 'required',
            'hero_caption_description' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'email_apply' => 'required',
            'address' => 'required',
            'about' => 'required',
            'title_jobs_hero' => 'required',
            'title_about_hero' => 'required',
            'title_contact_hero' => 'required',
            'map_location' => 'required',
            'logo_footer' => 'image|file',
            'logo_header' => 'image|file',
            'hero_image' => 'image|file',
            'slider_background' => 'image|file',
            'about_image' => 'image|file',
        ]);

        $logo_header = Content::find($request->id_logo_header);
        if ($request->file('logo_header')) {
            if ($logo_header->description) {
                Storage::delete([$logo_header->description]);
            }
            $validatedData['logo_header'] = $request->file('logo_header')->store('uploads/image/contents');
            Content::where('id', $request->id_logo_header)->update(['description' => $validatedData['logo_header']]);
        }

        $hero_image = Content::find($request->id_hero_image);
        if ($request->file('hero_image')) {
            if ($hero_image->description) {
                Storage::delete([$hero_image->description]);
            }
            $validatedData['hero_image'] = $request->file('hero_image')->store('uploads/image/contents');
            Content::where('id', $request->id_hero_image)->update(['description' => $validatedData['hero_image']]);
        }

        $logo_footer = Content::find($request->id_logo_footer);
        if ($request->file('logo_footer')) {
            if ($logo_footer->description) {
                Storage::delete([$logo_footer->description]);
            }
            $validatedData['logo_footer'] = $request->file('logo_footer')->store('uploads/image/contents');
            Content::where('id', $request->id_logo_footer)->update(['description' => $validatedData['logo_footer']]);
        }

        $slider_background = Content::find($request->id_slider_background);
        if ($request->file('slider_background')) {
            if ($slider_background->description) {
                Storage::delete([$slider_background->description]);
            }
            $validatedData['slider_background'] = $request->file('slider_background')->store('uploads/image/contents');
            Content::where('id', $request->id_slider_background)->update(['description' => $validatedData['slider_background']]);
        }

        $about_image = Content::find($request->id_about_image);
        if ($request->file('about_image')) {
            if ($about_image->description) {
                Storage::delete([$about_image->description]);
            }
            $validatedData['about_image'] = $request->file('about_image')->store('uploads/image/contents');
            Content::where('id', $request->id_about_image)->update(['description' => $validatedData['about_image']]);
        }

        Content::where('id', $request->id_title_jobs_hero)->update(['description' => $validatedData['title_jobs_hero']]);
        Content::where('id', $request->id_title_about_hero)->update(['description' => $validatedData['title_about_hero']]);
        Content::where('id', $request->id_title_contact_hero)->update(['description' => $validatedData['title_contact_hero']]);
        Content::where('id', $request->id_map_location)->update(['description' => $validatedData['map_location']]);
        Content::where('id', $request->id_name)->update(['description' => $validatedData['name']]);
        Content::where('id', $request->id_hero_description)->update(['description' => $validatedData['hero_description']]);
        Content::where('id', $request->id_hero_caption_description)->update(['description' => $validatedData['hero_caption_description']]);
        Content::where('id', $request->id_phone)->update(['description' => $validatedData['phone']]);
        Content::where('id', $request->id_email)->update(['description' => $validatedData['email']]);
        Content::where('id', $request->id_email_apply)->update(['description' => $validatedData['email_apply']]);
        Content::where('id', $request->id_about)->update(['description' => $validatedData['about']]);
        Content::where('id', $request->id_address)->update(['description' => $validatedData['address']]);

        return redirect('dashboard/content')->with('success', 'Content has been Updated');
    }
}
