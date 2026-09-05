<?php

namespace App\Providers;

use App\Models\Content;
use App\Models\Job;
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

        // Inject shared SEO metadata into the existing @stack('meta') of the public layout.
        if (!app()->runningInConsole()) {
            view()->composer('homepage._layout.main', function () {
                $canonicalUrl = url('/');
                $title = 'Job Vacancies & Career Opportunities';
                $description = 'Find current job vacancies, career opportunities, and professional roles. Search openings by category, location, and employment type.';
                $ogType = 'website';
                $ogImage = asset('Logo.png');
                $robots = request()->is('jobs') && request()->query() !== []
                    ? 'noindex,follow'
                    : 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1';
                $structuredData = [
                    '@context' => 'https://schema.org',
                    '@type' => 'WebSite',
                    'name' => 'Job Opportunities',
                    'url' => url('/'),
                    'potentialAction' => [
                        '@type' => 'SearchAction',
                        'target' => url('/jobs') . '?search={search_term_string}',
                        'query-input' => 'required name=search_term_string',
                    ],
                ];

                if (request()->is('jobs')) {
                    $title = 'Job Vacancies | Search Current Openings';
                    $description = 'Browse current job vacancies and career opportunities by keyword, job category, location, and employment type.';
                    $canonicalUrl = url('/jobs');
                } elseif (request()->is('about')) {
                    $title = 'About Us | Recruitment & Career Opportunities';
                    $description = 'Learn more about our recruitment services, career opportunities, and professional talent solutions.';
                    $canonicalUrl = url('/about');
                } elseif (request()->is('contact')) {
                    $title = 'Contact | Recruitment & Job Opportunities';
                    $description = 'Get in touch for recruitment support, career opportunities, and information about current job openings.';
                    $canonicalUrl = url('/contact');
                } elseif (request()->is('job/*')) {
                    $job = Job::with(['jobcategory', 'location', 'company'])->find(request()->route('id_job'));

                    if ($job) {
                        $category = $job->jobcategory?->name;
                        $location = $job->location?->name;
                        $suffix = trim(collect([$category, $location])->filter()->implode(' - '));
                        $title = trim($job->title . ($suffix ? ' | ' . $suffix : '') . ' | Job Vacancy');
                        $descriptionText = trim(preg_replace('/\s+/', ' ', strip_tags((string) $job->description)));
                        $description = \Illuminate\Support\Str::limit($descriptionText, 155, '...');
                        $canonicalUrl = url('/job/' . $job->id);
                        $ogType = 'article';
                        if ($job->image) {
                            $ogImage = asset('storage/' . $job->image);
                        }

                        $employmentType = match ($job->type) {
                            'full_time' => 'FULL_TIME',
                            'part_time' => 'PART_TIME',
                            'freelance' => 'CONTRACTOR',
                            'remote' => 'OTHER',
                            default => strtoupper((string) $job->type),
                        };

                        $structuredData = [
                            '@context' => 'https://schema.org',
                            '@type' => 'JobPosting',
                            'title' => $job->title,
                            'description' => $descriptionText,
                            'datePosted' => optional($job->created_at)->toDateString(),
                            'employmentType' => $employmentType,
                            'url' => $canonicalUrl,
                            'directApply' => true,
                            'hiringOrganization' => [
                                '@type' => 'Organization',
                                'name' => $job->company?->name ?: 'Hiring Organization',
                            ],
                            'jobLocation' => [
                                '@type' => 'Place',
                                'address' => [
                                    '@type' => 'PostalAddress',
                                    'addressLocality' => $location ?: null,
                                ],
                            ],
                        ];
                    }
                }

                $seoHtml = implode('', [
                    '<meta name="robots" content="' . e($robots) . '">',
                    '<link rel="canonical" href="' . e($canonicalUrl) . '">',
                    '<meta property="og:type" content="' . e($ogType) . '">',
                    '<meta property="og:title" content="' . e($title) . '">',
                    '<meta property="og:description" content="' . e($description) . '">',
                    '<meta property="og:url" content="' . e($canonicalUrl) . '">',
                    '<meta property="og:image" content="' . e($ogImage) . '">',
                    '<meta property="og:site_name" content="Job Opportunities">',
                    '<meta name="twitter:card" content="summary_large_image">',
                    '<meta name="twitter:title" content="' . e($title) . '">',
                    '<meta name="twitter:description" content="' . e($description) . '">',
                    '<meta name="twitter:image" content="' . e($ogImage) . '">',
                    '<script type="application/ld+json">' . json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>',
                ]);

                view()->startPush('meta', $seoHtml);
            });
        }
    }
}
