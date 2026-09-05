<div class="section-heading text-center">
    <h3 style="color: {{ $color ?? '#1e214e' }};">{{ $title }}</h3>
</div>

<style>
.section-heading {
    margin-bottom: 32px;
}
.section-heading h3 {
    display: inline-block;
    margin: 0;
    font-weight: 600;
    line-height: 1.1;
    letter-spacing: -0.04em;
    font-size: 40px;
    position: relative;
}
@media (max-width: 767px) {
    .section-heading {
        margin-bottom: 24px;
    }
    .section-heading h3 {
        font-size:40px;
    }
}
</style>