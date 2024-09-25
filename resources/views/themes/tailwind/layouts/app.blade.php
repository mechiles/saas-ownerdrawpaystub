<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    @if(isset($seo->title))
        <title>{{ $seo->title }}</title>
    @else
        <title>{{ setting('site.title', 'Laravel Wave') . ' - ' . setting('site.description', 'The Software as a Service Starter Kit built on Laravel & Voyager') }}</title>
    @endif

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge"> <!-- † -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url" content="{{ url('/') }}">
    <meta name="description" content="{{ setting('site.description') }}">


    <link rel="icon" href="{{ setting('site.favicon', '/wave/favicon.png') }}" type="image/x-icon">

    <meta property="og:image" content="https://www.ownerdrawpaystub.com/storage/themes/July2024/0bhQZCxwFuxVg2qMWslN.jpg">
    <meta property="og:title" content="{{ setting('site.title') }}">
    <meta property="og:url" content="{{ Request::url() }}">
    <meta property="og:description" content="Owner Draw Pay Stub is the paystub software for business owners. We make it fast and simple to create owner draw pay stubs.">
    <meta property="og:site_name" content="{{ setting('site.title') }}">
    <meta property="og:type" content="website">

    <meta itemprop="name" content="{{ setting('site.title') }}">
    <meta itemprop="description" content="{{ setting('site.description') }}">
    <meta itemprop="image" content="/storage/{{ setting('site.og_image') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@ownerdrawpay">
    <meta name="twitter:creator" content="@markechiles">
    <meta name="twitter:title" content="{{ setting('site.title') }}">
    <meta name="twitter:description" content="Owner Draw Pay Stub is the paystub software for business owners. We make it fast and simple to create owner draw pay stubs.">
    <meta name="twitter:image" content="https://www.ownerdrawpaystub.com/storage/themes/July2024/0bhQZCxwFuxVg2qMWslN.jpg">

    {{-- Social Share Open Graph Meta Tags --}}
    @if(isset($seo->title) && isset($seo->description) && isset($seo->image))
        <meta property="og:title" content="{{ $seo->title }}">
        <meta property="og:url" content="{{ Request::url() }}">
        <meta property="og:image" content="{{ $seo->image }}">
        <meta property="og:type" content="@if(isset($seo->type)){{ $seo->type }}@else{{ 'article' }}@endif">
        <meta property="og:description" content="{{ $seo->description }}">
        <meta property="og:site_name" content="{{ setting('site.title') }}">

        <meta itemprop="name" content="{{ $seo->title }}">
        <meta itemprop="description" content="{{ $seo->description }}">
        <meta itemprop="image" content="{{ $seo->image }}">



        @if(isset($seo->image_w) && isset($seo->image_h))
            <meta property="og:image:width" content="{{ $seo->image_w }}">
            <meta property="og:image:height" content="{{ $seo->image_h }}">
        @endif
    @endif

    <meta name="robots" content="index,follow">
    <meta name="googlebot" content="index,follow">


    <!-- Styles -->
    <link href="{{ asset('themes/' . $theme->folder . '/css/app.css') }}" rel="stylesheet">
    <!-- @include('googletagmanager::head') -->
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NWW3L68K');</script>
    <!-- End Google Tag Manager -->
    <!-- Rudderstack -->
     <script type="text/javascript">
        !function(){"use strict";window.RudderSnippetVersion="3.0.25";var e="rudderanalytics";window[e]||(window[e]=[])
        ;var rudderanalytics=window[e];if(Array.isArray(rudderanalytics)){
        if(true===rudderanalytics.snippetExecuted&&window.console&&console.error){
        console.error("RudderStack JavaScript SDK snippet included more than once.")}else{rudderanalytics.snippetExecuted=true,
        window.rudderAnalyticsBuildType="legacy";var sdkBaseUrl="https://cdn.rudderlabs.com/v3";var sdkName="rsa.min.js"
        ;var scriptLoadingMode="async"
        ;var n=["setDefaultInstanceKey","load","ready","page","track","identify","alias","group","reset","setAnonymousId","startSession","endSession","consent"]
        ;for(var r=0;r<n.length;r++){var t=n[r];rudderanalytics[t]=function(n){return function(){var r
        ;Array.isArray(window[e])?rudderanalytics.push([n].concat(Array.prototype.slice.call(arguments))):null===(r=window[e][n])||void 0===r||r.apply(window[e],arguments)
        }}(t)}try{new Function('return import("")'),window.rudderAnalyticsBuildType="modern"}catch(o){}
        var d=document.head||document.getElementsByTagName("head")[0]
        ;var i=document.body||document.getElementsByTagName("body")[0];window.rudderAnalyticsAddScript=function(e,n,r){
        var t=document.createElement("script");t.src=e,t.setAttribute("data-loader","RS_JS_SDK"),n&&r&&t.setAttribute(n,r),
        "async"===scriptLoadingMode?t.async=true:"defer"===scriptLoadingMode&&(t.defer=true),
        d?d.insertBefore(t,d.firstChild):i.insertBefore(t,i.firstChild)},window.rudderAnalyticsMount=function(){!function(){
        if("undefined"==typeof globalThis){var e;var n=function getGlobal(){
        return"undefined"!=typeof self?self:"undefined"!=typeof window?window:null}();n&&Object.defineProperty(n,"globalThis",{
        value:n,configurable:true})}
        }(),window.rudderAnalyticsAddScript("".concat(sdkBaseUrl,"/").concat(window.rudderAnalyticsBuildType,"/").concat(sdkName),"data-rsa-write-key","2mIsdfOD0UHjwc1S0qjpki7WFc8")
        },
        "undefined"==typeof Promise||"undefined"==typeof globalThis?window.rudderAnalyticsAddScript("https://polyfill-fastly.io/v3/polyfill.min.js?version=3.111.0&features=Symbol%2CPromise&callback=rudderAnalyticsMount"):window.rudderAnalyticsMount()
        ;var loadOptions={}
        ;rudderanalytics.load("2mIsdfOD0UHjwc1S0qjpki7WFc8","https://overwritemfny.dataplane.rudderstack.com",loadOptions)}}
        }();
        </script>
        
        <script type="text/javascript">
            // Laravel Auth::user() injected into the JavaScript
            rudderanalytics.identify("{{ Auth::user()->id }}", {
                email: "{{ Auth::user()->email }}",
                name: "{{ Auth::user()->name }}"
                username: "{{ Auth::user()->username }}"
            });

            // RudderStack page tracking
            rudderanalytics.page();
        </script>
        
</head>
<body class="flex flex-col min-h-screen bg-white">
 <!-- @if(Request::is('/')){{ 'bg-white' }}@else{{ 'bg-gray-50' }}@endif @if(config('wave.dev_bar')){{ 'pb-10' }}@endif"> -->
    @include('googletagmanager::body')
    <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NWW3L68K"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    @if(config('wave.demo') && Request::is('/'))
        @include('theme::partials.demo-header')
    @endif

    @include('theme::partials.header')

    <main class="flex-grow overflow-x-hidden">
        @yield('content')
    </main>



    @include('theme::partials.footer')

    @if(config('wave.dev_bar'))
        @include('theme::partials.dev_bar')
    @endif

    <!-- Full Screen Loader -->
    <div id="fullscreenLoader" class="fixed inset-0 top-0 left-0 z-50 flex flex-col items-center justify-center hidden w-full h-full bg-gray-900 opacity-50">
        <svg class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p id="fullscreenLoaderMessage" class="mt-4 text-sm font-medium text-white uppercase"></p>
    </div>
    <!-- End Full Loader -->


    @include('theme::partials.toast')
    @if(session('message'))
        <script>setTimeout(function(){ popToast("{{ session('message_type') }}", "{{ session('message') }}"); }, 10);</script>
    @endif
    @waveCheckout

</body>
</html>
