<?php

namespace App\Providers;

use App\Models\Content;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        // Milestone steps/statuses are managed from the Setting page.
        // Keep config values in sync for every web request so the
        // Recruitment Process page and its validation use database settings.
        if (!app()->runningInConsole()) {
            try {
                $steps = Content::where('name', 'MILESTONE_STEPS')->value('description');
                $statuses = Content::where('name', 'MILESTONE_STATUSES')->value('description');

                config([
                    'milestones.steps' => array_values(array_filter(array_map('trim', explode(',', (string) $steps)))),
                    'milestones.statuses' => array_values(array_filter(array_map('trim', explode(',', (string) $statuses)))),
                ]);
            } catch (\Throwable $e) {
                // Do not break application boot when the contents table is unavailable.
            }
        }
    }
}
