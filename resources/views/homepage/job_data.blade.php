@once
<style>
/* Styling untuk area daftar pekerjaan */
.job-count {
    display: block;
    margin: 12px 0 22px;
    color: #475569;
    font-size: 18px;
    font-weight: 500;
}

.job-category-listing {
    background: #fff;
    border: 1px solid rgba(148, 163, 184, 0.18);
    border-radius: 22px;
    box-shadow: 0 16px 30px rgba(15, 23, 42, 0.04);
    padding: 24px;
    margin-top: 10px;
}

.job-category-listing .select-categories span,
.job-category-listing h3,
.job-category-listing .filter-tittle {
    font-size: 18px;
    font-weight: 700;
    color: #1e214e;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.job-category-listing .single-select-box,
.job-category-listing .select-form,
.job-category-listing .small-section-tittle,
.job-category-listing .listing-form {
    margin-bottom: 20px !important;
}

.job-category-listing .single-select-box:last-child,
.job-category-listing .listing-form:last-child {
    margin-bottom: 0 !important;
}

.job-category-listing input[type="text"],
.job-category-listing .form-control {
    width: 100%;
    padding: 12px 16px;
    border-radius: 12px;
    border: 1px solid rgba(148, 163, 184, 0.25);
    background-color: #f8fafc;
    font-size: 14px;
    color: #334155;
    margin-bottom: 20px;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.job-category-listing input[type="text"]:focus {
    border-color: #2a93d5;
    background-color: #fff;
    box-shadow: 0 0 0 3px rgba(42, 147, 213, 0.15);
    outline: none;
}

.job-category-listing select,
.job-category-listing .selectric,
.job-category-listing .nice-select {
    width: 100%;
    padding: 10px 14px;
    border-radius: 12px;
    border: 1px solid rgba(148, 163, 184, 0.25);
    background-color: #f8fafc;
    font-size: 14px;
    color: #334155;
    height: auto;
    margin-bottom: 16px;
    box-sizing: border-box;
}

.job-category-listing .checkbox-form,
.job-category-listing .switch-wrap {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 8px;
}

.job-category-listing label,
.job-category-listing .contact-form {
    cursor: pointer;
    font-size: 14px;
    color: #475569;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 0;
}

.job-category-listing input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #2a93d5;
    border-radius: 4px;
    cursor: pointer;
}

.single-job-items {
    display: flex;
    flex-direction: column;
    gap: 14px;
    background: #fff;
    border: 1px solid rgba(148, 163, 184, 0.18);
    border-radius: 22px;
    box-shadow: 0 16px 30px rgba(15, 23, 42, 0.04);
    padding: 18px 20px;
    transition: all 0.25s ease;
    text-align: left;
    width: 100%;
    max-width: 100%;
    min-width: 0;
    box-sizing: border-box;
    overflow: hidden;
}

.single-job-items:hover {
    transform: translateY(-2px);
    box-shadow: 0 22px 38px rgba(15, 23, 42, 0.08);
    transition: all 0.25s ease;
}

.job-items {
    display: flex !important;
    flex-direction: row !important;
    align-items: center;
    width: 100%;
    max-width: 100%;
    min-width: 0;
    box-sizing: border-box;
}

.company-img {
    width: 72px;
    min-width: 72px;
    height: 72px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 16px;
    background: linear-gradient(135deg, #edf7ff 0%, #e8f0ff 100%);
    border: 1px solid rgba(42, 147, 213, 0.12);
    overflow: hidden;
    position: relative;
    flex-shrink: 0;
    box-sizing: border-box;
}

.company-img a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    position: relative;
}

.company-img img {
    width: 52px;
    height: 52px;
    object-fit: cover;
    border-radius: 12px;
    display: block;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    object-position: center;
}

.job-tittle {
    flex: 1 1 auto;
    padding-left: 15px;
    display: flex !important;
    flex-direction: column !important;
    justify-content: center;
    align-items: flex-start;
    text-align: left;
    min-width: 0;
    max-width: 100%;
    overflow: hidden;
}

.job-tittle h4 {
    margin: 0 0 6px;
    font-size: clamp(16px, 2vw, 22px);
    font-weight: 700;
    color: #1e214e;
    line-height: 1.2;
    letter-spacing: -0.03em;
    text-align: left;
    max-width: 100%;
    overflow-wrap: anywhere;
    word-break: break-word;
}

.job-tittle h4,
.job-tittle a {
    max-width: 100%;
}

.job-tittle ul {
    display: flex !important;
    align-items: flex-start;
    flex-wrap: wrap !important;
    gap: 4px 12px;
    padding: 0;
    margin: 0;
    list-style: none;
    color: #667085;
    font-size: 14px;
    justify-content: flex-start;
    width: 100%;
    max-width: 100%;
    min-width: 0;
    box-sizing: border-box;
}

.job-tittle ul li {
    display: inline-flex !important;
    align-items: flex-start;
    gap: 5px;
    text-align: left;
    flex: 0 1 auto;
    min-width: 0;
    max-width: 100%;
    overflow-wrap: anywhere;
    word-break: break-word;
}

.job-tittle ul li i {
    color: #94a3b8;
    font-size: 13px;
    flex-shrink: 0;
}

.job-meta-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-top: 2px;
    padding-bottom: 8px;
    flex-wrap: nowrap;
    text-align: left;
    width: 100%;
    max-width: 100%;
    min-width: 0;
    box-sizing: border-box;
}

.job-meta-footer .job-time {
    font-size: 14px;
    color: #7a7f8a;
    margin: 0;
    line-height: 1.3;
    text-align: left;
    white-space: nowrap;
    min-width: 0;
}

.job-meta-footer .items-link2 {
    margin-left: auto;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 42px;
    flex-shrink: 0;
}

.job-meta-footer .btn {
    min-width: 100px;
    max-width: 100%;
    border-radius: 5px;
    font-size: 13px;
    font-weight: 700;
    padding: 10px 18px;
    line-height: 1.2;
    background-color: #2a93d5;
    color: #fff;
    border: none;
    box-shadow: none;
    text-align: center;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 42px;
    box-sizing: border-box;
}

.job-meta-footer .btn:hover {
    background-color: #1f82c4;
    color: #fff;
}

.job-data-empty {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 220px;
    padding: 32px 24px;
    border: 1px solid rgba(148, 163, 184, 0.18);
    border-radius: 22px;
    background: rgba(255, 255, 255, 0.78);
    box-shadow: 0 16px 30px rgba(15, 23, 42, 0.04);
    text-align: center;
}

.job-data-empty-inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}

.job-data-empty-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(42, 147, 213, 0.1);
    color: #2a93d5;
    font-size: 28px;
    font-weight: 700;
}

.job-data-empty-title {
    margin: 0;
    color: #1e214e;
    font-size: 28px;
    font-weight: 700;
}

.job-data-empty-text {
    margin: 0;
    color: #64748b;
    font-size: 16px;
    line-height: 1.6;
}

@media (max-width: 767px) {
    .job-category-listing {
        margin-top: 15px;
        padding: 16px;
        margin-bottom: 20px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .single-job-items {
        padding: 12px 14px;
        gap: 10px;
        border-radius: 16px;
    }

    .company-img {
        width: 50px;
        min-width: 50px;
        height: 50px;
        border-radius: 11px;
    }

    .company-img img {
        width: 34px;
        height: 34px;
        border-radius: 9px;
    }

    .job-tittle {
        padding-left: 10px;
    }

    .job-tittle h4 {
        font-size: 14px;
        margin-bottom: 5px;
        line-height: 1.25;
        letter-spacing: -0.015em;
    }

    .job-tittle ul {
        gap: 2px 8px;
        font-size: 11px;
        line-height: 1.35;
    }

    .job-tittle ul li {
        max-width: 100%;
    }

    .job-tittle ul li:last-child {
        flex-basis: 100%;
    }

    .job-tittle ul li i {
        font-size: 11px;
        margin-top: 1px;
    }

    .job-meta-footer {
        gap: 8px;
        align-items: center;
    }

    .job-meta-footer .job-time {
        font-size: 11px;
        white-space: normal;
        overflow-wrap: anywhere;
        line-height: 1.25;
    }

    .job-meta-footer .btn {
        padding: 5px 10px;
        font-size: 10px;
        min-width: 76px;
        min-height: 34px;
    }

    .job-data-empty-title {
        font-size: 22px;
    }

    .job-data-empty-text {
        font-size: 14px;
    }
}

@media (max-width: 360px) {
    .single-job-items {
        padding: 11px 12px;
        gap: 8px;
    }

    .company-img {
        width: 46px;
        min-width: 46px;
        height: 46px;
    }

    .company-img img {
        width: 31px;
        height: 31px;
    }

    .job-tittle {
        padding-left: 8px;
    }

    .job-tittle h4 {
        font-size: 13px;
    }

    .job-tittle ul {
        font-size: 10px;
        gap: 2px 6px;
    }

    .job-meta-footer .job-time {
        font-size: 10px;
    }

    .job-meta-footer .btn {
        min-width: 70px;
        padding: 4px 8px;
        font-size: 9px;
        min-height: 32px;
    }
}

/* Responsive header untuk halaman /jobs */
@media (max-width: 767px) {
    .job-list-topbar {
        display: flex !important;
        flex-direction: column !important;
        align-items: stretch !important;
        justify-content: flex-start !important;
        gap: 10px !important;
        width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    .job-results-count {
        flex: none !important;
        width: 100%;
        min-width: 0;
        font-size: 15px !important;
        line-height: 1.3;
    }

    .count-job .select-job-items {
        width: 100%;
        margin-left: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: flex-start !important;
        gap: 8px !important;
        min-width: 0;
    }

    .count-job .select-job-items span {
        flex: 0 0 auto;
        font-size: 12px !important;
    }

    .count-job .select-job-items select {
        flex: 1 1 auto;
        width: auto !important;
        min-width: 0 !important;
        max-width: 100%;
        height: 38px !important;
        font-size: 12px !important;
        padding: 0 32px 0 10px !important;
        box-sizing: border-box;
    }
}

@media (max-width: 360px) {
    .count-job {
        margin-bottom: 14px;
    }

    .job-results-count {
        font-size: 14px !important;
    }

    .count-job .select-job-items span {
        font-size: 11px !important;
    }

    .count-job .select-job-items select {
        height: 36px !important;
        font-size: 11px !important;
        padding-right: 28px !important;
    }
}
</style>
@endonce

@if ($jobs->isEmpty())
    <div class="job-data-empty" data-empty="true">
        <div class="job-data-empty-inner">
            <div class="job-data-empty-icon">!</div>
            <h4 class="job-data-empty-title">No jobs found</h4>
            <p class="job-data-empty-text">Try changing the filters or search keyword to find another opportunity.</p>
        </div>
    </div>
@else
    @foreach ($jobs as $job)
    <div class="single-job-items mb-20" style="border: none !important;">
        <div class="job-items align-items-center">
            <div class="company-img">
                <a href="/job/{{$job->id}}">
                    <img class="shadow-sm rounded" style="border: none !important; object-fit: cover;" src="{{asset('storage/' . $job->image)}}" alt="Company Logo">
                </a>
            </div>
            <div class="job-tittle job-tittle2">
                <a href="/job/{{$job->id}}" class="text-decoration-none">
                    <h4 class="font-weight-bold text-dark">{{$job->title}}</h4>
                </a>
                <ul>
                    <li>{{\App\Models\Jobcategory::where('id', $job->jobcategory_id)->first()->name ?? ''}}</li>
                    <li><i class="fas fa-map-marker-alt"></i> {{\App\Models\Location::where('id', $job->location_id)->first()->name ?? ''}}</li>
                    <li>{{$job->salary}}</li>
                </ul>
            </div>
        </div>

        <div class="job-meta-footer">
            @php
                $jobTime = $job->updated_at > $job->created_at
                    ? \Carbon\Carbon::parse($job->updated_at)->diffForHumans()
                    : \Carbon\Carbon::parse($job->created_at)->diffForHumans();
            @endphp

            <p class="job-time">{{ $jobTime }}</p>

            <div class="items-link items-link2 f-right">
                <a href="/job/{{$job->id}}" class="btn btn-primary font-weight-bold shadow-sm px-3 py-1" style="border: none !important; background-color: #2a93d5; color: #fff;">
                    {{ucwords(str_replace("_", " ", $job->type))}}
                </a>
            </div>
        </div>
    </div>
    @endforeach
@endif

<div class="job-data-meta" data-total="{{ $jobs->total() ?? 0 }}" data-empty="{{ $jobs->isEmpty() ? 'true' : 'false' }}" style="display:none;"></div>

<div class="pagination-area pb-50 text-center">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="single-wrap d-flex justify-content-center">
                    <nav aria-label="Page navigation example">
                        @if ($jobs->hasPages())
                        <ul class="pagination" role="navigation">
                            @if ($jobs->onFirstPage())
                                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $jobs->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                                </li>
                            @endif

                            <?php
                                $start = $jobs->currentPage();
                                $end = $jobs->currentPage();
                                if ($start < 1) {
                                    $start = 1;
                                    $end += 1;
                                }
                                if ($end >= $jobs->lastPage()) $end = $jobs->lastPage();
                            ?>

                            @if($start > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $jobs->url(1) }}">{{1}}</a>
                                </li>
                                @if($jobs->currentPage() - 1 != 1)
                                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                                @endif
                            @endif

                            @for ($i = $start; $i <= $end; $i++)
                                <li class="page-item {{ ($jobs->currentPage() == $i) ? ' active' : '' }}">
                                    <a class="page-link" href="{{ $jobs->url($i) }}">{{$i}}</a>
                                </li>
                            @endfor

                            @if($end < $jobs->lastPage())
                                @if($jobs->currentPage() + 1 != $jobs->lastPage())
                                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link" href="{{ $jobs->url($jobs->lastPage()) }}">{{$jobs->lastPage()}}</a>
                                </li>
                            @endif

                            @if ($jobs->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $jobs->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                                </li>
                            @endif
                        </ul>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>