<section id="clients" class="center" aria-labelledby="clients-title">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @include('homepage._partials.section_heading', ['title' => 'Our Clients'])
            </div>
        </div>
        <div class="row no-gutters clients-wrap clearfix" style="visibility:visible;">
            <div class="client-marquee" id="homepage-clients-marquee" aria-live="polite">
                <div class="client-loading" role="status">
                    <span class="client-loading-dot"></span>
                    <span>Loading our clients...</span>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    #clients { padding:60px 0 70px; background-color:#f8fbff; }
    #clients .section-tittle h2, #clients .section-heading h2 {
        color:#1e214e!important; font-size:clamp(3rem,5vw,6rem);
        letter-spacing:-.05em; margin-bottom:28px;
    }
    #clients .clients-wrap { width:100%; max-width:none; margin:0; padding:0; overflow:hidden; position:relative; }
    #clients .client-marquee { display:flex; flex-direction:column; gap:18px; width:100%; overflow:hidden; padding:0; min-height:120px; }
    #clients .client-track { display:flex; width:max-content; align-items:center; gap:18px; will-change:transform; padding:0 8px; transform:translate3d(0,0,0); }
    #clients .client-track.track-right { animation:client-marquee-right 72s linear infinite; }
    #clients .client-track.track-left { animation:client-marquee-left 80s linear infinite; }
    #clients .client-track.track-right-slow { animation:client-marquee-right 88s linear infinite; }
    #clients .client-track:hover { animation-play-state:paused; }
    #clients .client-logo { flex:0 0 auto; width:240px; height:120px; padding:18px 12px; display:flex; justify-content:center; align-items:center; overflow:hidden; background:#fff; border:1px solid rgba(30,33,78,.08); border-radius:12px; box-shadow:0 8px 18px rgba(30,33,78,.06); }
    #clients .client-logo img { max-height:60px; width:auto; max-width:100%; object-fit:contain; }
    #clients .client-loading { min-height:120px; display:flex; align-items:center; justify-content:center; gap:10px; color:#64748b; font-size:14px; }
    #clients .client-loading-dot { width:8px; height:8px; border-radius:50%; background:#2a93d5; box-shadow:14px 0 #b7dff5, -14px 0 #b7dff5; animation:client-loading-pulse 1s ease-in-out infinite; }
    #clients .client-empty { text-align:center; padding:28px 16px; color:#64748b; }
    @keyframes client-loading-pulse { 50% { opacity:.45; } }
    @keyframes client-marquee-right { from { transform:translateX(0); } to { transform:translateX(-50%); } }
    @keyframes client-marquee-left { from { transform:translateX(-50%); } to { transform:translateX(0); } }
    @media (max-width:767px) { #clients { padding:50px 0 60px; } #clients .client-logo { width:170px; height:90px; } #clients .client-marquee { gap:12px; } }
    @media (prefers-reduced-motion:reduce) { #clients .client-track, #clients .client-loading-dot { animation:none!important; } }
</style>

<script>
(function () {
    var marquee = document.getElementById('homepage-clients-marquee');
    if (!marquee || marquee.dataset.loaded === 'true') return;
    marquee.dataset.loaded = 'true';

    function escapeHtml(value) {
        return String(value == null ? '' : value).replace(/[&<>"']/g, function (char) {
            return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[char];
        });
    }

    function makeTrack(clients, className, reverse) {
        var track = document.createElement('div');
        track.className = 'client-track ' + className;
        var ordered = reverse ? clients.slice().reverse() : clients.slice();
        // Duplicate the sequence so the marquee loops without a visible gap.
        var repeated = ordered.concat(ordered);
        track.innerHTML = repeated.map(function (client) {
            return '<div class="client-logo"><img src="' + escapeHtml(client.logo_url) +
                '" alt="' + escapeHtml(client.name || 'Client logo') +
                '" loading="lazy" decoding="async"></div>';
        }).join('');
        return track;
    }

    function showClients(clients) {
        marquee.replaceChildren();
        if (!clients.length) {
            marquee.innerHTML = '<p class="client-empty">Our client logos will appear here soon.</p>';
            return;
        }
        var shift = Math.max(1, Math.floor(clients.length / 3));
        var rowTwo = clients.slice(shift).concat(clients.slice(0, shift));
        var rowThree = clients.slice(shift * 2).concat(clients.slice(0, shift * 2));
        marquee.appendChild(makeTrack(clients, 'track-right', false));
        marquee.appendChild(makeTrack(rowTwo.length ? rowTwo : clients, 'track-left', true));
        marquee.appendChild(makeTrack(rowThree.length ? rowThree : clients, 'track-right-slow', false));
    }

    function loadClients() {
        var controller = typeof AbortController !== 'undefined' ? new AbortController() : null;
        var options = { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' };
        if (controller) options.signal = controller.signal;
        fetch('/api/clients', options)
            .then(function (response) {
                if (!response.ok) throw new Error('Could not load clients: ' + response.status);
                return response.json();
            })
            .then(function (payload) {
                showClients(Array.isArray(payload.data) ? payload.data : []);
            })
            .catch(function (error) {
                console.error('Homepage clients API error:', error);
                marquee.innerHTML = '<p class="client-empty">Client logos are temporarily unavailable.</p>';
                marquee.dataset.loaded = 'false';
            });
    }

    if ('requestIdleCallback' in window) {
        window.requestIdleCallback(loadClients, { timeout: 1200 });
    } else {
        window.setTimeout(loadClients, 120);
    }
})();
</script>
