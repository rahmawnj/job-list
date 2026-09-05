<?php

use App\Models\Job;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SEO Routes
|--------------------------------------------------------------------------
*/

Route::get('/robots.txt', function () {
    $robots = implode("\n", [
        'User-agent: *',
        'Allow: /',
        'Disallow: /dashboard/',
        'Disallow: /auth/',
        'Disallow: /login',
        'Disallow: /profile',
        'Disallow: /mail',
        'Disallow: /send',
        'Sitemap: ' . url('/sitemap.xml'),
    ]) . "\n";

    return response($robots, 200)
        ->header('Content-Type', 'text/plain; charset=UTF-8')
        ->header('Cache-Control', 'public, max-age=86400');
})->name('seo.robots');

Route::get('/sitemap.xml', function () {
    $urls = [
        [url('/'), now()->toDateString(), 'daily', '1.0'],
        [url('/jobs'), now()->toDateString(), 'daily', '0.9'],
        [url('/about'), now()->toDateString(), 'monthly', '0.5'],
        [url('/contact'), now()->toDateString(), 'monthly', '0.5'],
    ];

    Job::where('status', 'active')
        ->orderByDesc('updated_at')
        ->orderByDesc('id')
        ->get(['id', 'updated_at'])
        ->each(function ($job) use (&$urls) {
            $urls[] = [
                url('/job/' . $job->id),
                optional($job->updated_at)->toDateString() ?: now()->toDateString(),
                'weekly',
                '0.8',
            ];
        });

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    foreach ($urls as [$loc, $lastmod, $changefreq, $priority]) {
        $xml .= "  <url>\n";
        $xml .= '    <loc>' . htmlspecialchars($loc, ENT_XML1 | ENT_COMPAT, 'UTF-8') . '</loc>' . "\n";
        $xml .= '    <lastmod>' . htmlspecialchars($lastmod, ENT_XML1 | ENT_COMPAT, 'UTF-8') . '</lastmod>' . "\n";
        $xml .= '    <changefreq>' . $changefreq . '</changefreq>' . "\n";
        $xml .= '    <priority>' . $priority . '</priority>' . "\n";
        $xml .= "  </url>\n";
    }

    $xml .= '</urlset>';

    return response($xml, 200)
        ->header('Content-Type', 'application/xml; charset=UTF-8')
        ->header('Cache-Control', 'public, max-age=3600');
})->name('seo.sitemap');
