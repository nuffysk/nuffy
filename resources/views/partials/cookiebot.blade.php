{{--
    Cookiebot consent banner. Renders only when COOKIEBOT_CBID is configured,
    so local/dev without an ID is unaffected. Must be the FIRST script in <head>
    so consent is resolved before any other scripts run. data-blockingmode="auto"
    automatically blocks cookies/trackers until the user consents.
--}}
@if (config('services.cookiebot.cbid'))
    <script
        id="Cookiebot"
        src="https://consent.cookiebot.com/uc.js"
        data-cbid="{{ config('services.cookiebot.cbid') }}"
        data-blockingmode="auto"
        data-culture="SK"
        type="text/javascript"></script>
@endif
