<!-- How Apply Process Start-->
<div class="apply-process-area apply-bg how-it-works">
    <div class="container">
         <div class="row">
            <div class="col-lg-12">
                <div class="section-tittle white-text text-center">
                @include('homepage._partials.section_heading', ['title' => 'How It Works!'])
                </div>
            </div>
        </div>
        <div class="row how-it-works-grid">
            @foreach (App\Models\Applyprocess::whereIn('id', [1, 2, 3, 4])->orderBy('id')->get() as $process)
                <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                    <div class="single-process text-center mb-30">
                        <span class="process-step">{{ str_pad($process->id, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="process-ion">
                            <img height="70" src="{{ asset('storage/' . $process->logo) }}" alt="">
                        </div>
                        <div class="process-cap">
                            <h5>{{ $process->title }}</h5>
                            <p class="text-white">{{ $process->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
.how-it-works {
    padding: 78px 0 58px;
}
.how-it-works .section-heading {
    margin-bottom: 40px;
}

.how-it-works-grid > div {
    margin-bottom: 20px;
}
.how-it-works .single-process {
    width: 100%;
    min-height: 342px;
    height: auto;
    padding: 30px 25px 28px;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    background: #1e214e;
    border: 1px solid #1e214e;
    border-top: 4px solid #1e214e;
    box-shadow: 0 12px 28px rgba(30, 33, 78, .12);
}
.how-it-works .process-step {
    color: #8ed9f8;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1px;
    margin-bottom: 14px;
}
.how-it-works .process-ion {
    height: 78px;
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}
.how-it-works .process-ion img {
    max-width: 76px;
    object-fit: contain;
}
.how-it-works .process-cap {
    width: 100%;
}
.how-it-works .process-cap h5 {
    margin-bottom: 14px;
    color: #fff;
    font-size: 21px;
    line-height: 1.3;
}
.how-it-works .process-cap p {
    margin: 0;
    color: #fff !important;
    font-size: 15px;
    line-height: 1.75;
}
@media (max-width: 767px) {
    .how-it-works {
        padding: 58px 0 38px;
    }
    .how-it-works .single-process {
        min-height: 0;
    }
}
</style>
