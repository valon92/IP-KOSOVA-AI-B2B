(function (window, document) {
    'use strict';

    var script = document.currentScript;
    var apiKey = script && script.getAttribute('data-api-key');
    var endpoint = (script && script.getAttribute('data-endpoint')) || '/api/v1/track';
    var pingInterval = parseInt(script && script.getAttribute('data-ping-interval'), 10) || 15000;

    if (!apiKey) {
        console.warn('[IPKO] Missing data-api-key on tracker script.');
        return;
    }

    var sessionId = getOrCreateSessionId();
    var lastPingAt = Date.now();
    var pageEnteredAt = Date.now();

    function getOrCreateSessionId() {
        var key = 'ipko_session_id';
        try {
            var existing = sessionStorage.getItem(key);
            if (existing) {
                return existing;
            }
            var id = 'ipko_' + Date.now() + '_' + Math.random().toString(36).slice(2, 11);
            sessionStorage.setItem(key, id);
            return id;
        } catch (e) {
            return 'ipko_' + Date.now() + '_' + Math.random().toString(36).slice(2, 11);
        }
    }

    function getDeviceType() {
        var ua = navigator.userAgent || '';
        if (/tablet|ipad|playbook|silk/i.test(ua)) {
            return 'tablet';
        }
        if (/mobile|iphone|ipod|android.*mobile|windows phone/i.test(ua)) {
            return 'mobile';
        }
        return 'desktop';
    }

    function getScreenResolution() {
        return (window.screen && window.screen.width && window.screen.height)
            ? window.screen.width + 'x' + window.screen.height
            : null;
    }

    function buildPayload(event, extraDuration) {
        return {
            url: window.location.href,
            referrer: document.referrer || null,
            session_id: sessionId,
            device_type: getDeviceType(),
            screen_resolution: getScreenResolution(),
            duration: extraDuration || 0,
            event: event || 'pageview',
            api_key: apiKey
        };
    }

    function send(payload) {
        var body = JSON.stringify(payload);

        if (navigator.sendBeacon && (payload.event === 'beacon' || payload.event === 'ping')) {
            try {
                var blob = new Blob([body], { type: 'application/json' });
                navigator.sendBeacon(endpoint, blob);
                return;
            } catch (e) {
                /* fall through to fetch */
            }
        }

        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Api-Key': apiKey
            },
            body: body,
            keepalive: true,
            credentials: 'omit'
        }).catch(function () {
            /* silent fail for analytics */
        });
    }

    function trackPageView() {
        pageEnteredAt = Date.now();
        send(buildPayload('pageview', 0));
    }

    function sendPing(useBeacon) {
        var now = Date.now();
        var elapsed = Math.max(0, Math.floor((now - pageEnteredAt) / 1000));
        if (elapsed <= 0) {
            return;
        }
        pageEnteredAt = now;
        lastPingAt = now;
        var payload = buildPayload(useBeacon ? 'beacon' : 'ping', elapsed);
        send(payload);
    }

    trackPageView();

    setInterval(function () {
        if (document.visibilityState === 'visible') {
            sendPing(false);
        }
    }, pingInterval);

    document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'hidden') {
            sendPing(true);
        }
    });

    window.addEventListener('pagehide', function () {
        sendPing(true);
    });

    window.IPKO = {
        track: trackPageView,
        ping: function () { sendPing(false); },
        getSessionId: function () { return sessionId; }
    };
})(window, document);
