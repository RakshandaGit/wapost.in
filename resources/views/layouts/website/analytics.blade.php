@php
    /* Get the Marketing tool data like Google Analytics, Google Tag Manager, Facebook Pixel */
    $marketing_tools = DB::table('options')->where('key', 'marketing_tool')->first();
    $mt_data = json_decode($marketing_tools->value);
@endphp

{{-- /* Checking if the google tag manager is on and if the container id is not empty. If both are true, it will print the script. */ --}}
@if (isset($mt_data->google_tag_manager_status) && $mt_data->google_tag_manager_status === "on")
@if (isset($mt_data->gtm_container_id) && !empty($mt_data->gtm_container_id))
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer', '{{$mt_data->gtm_container_id}}');</script>
    <!-- End Google Tag Manager -->
@endif
@endif

{{-- /* If the Google Analytics status is on, and the measurement ID is not empty, then add the Google Analytics code to the page. */ --}}
@if (isset($mt_data->google_status) && $mt_data->google_status === "on")
@if (isset($mt_data->ga_measurement_id) && !empty($mt_data->ga_measurement_id))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{$mt_data->ga_measurement_id}}"></script>
    <script>window.dataLayer = window.dataLayer || [];function gtag(){window.dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '{{$mt_data->ga_measurement_id}}');</script>
@endif
@endif

{{-- /* If the Facebook Pixel status is on, and the Facebook Pixel ID is not empty, then add the Facebook Pixel code to the page. */ --}}
@if (isset($mt_data->fb_pixel_status) && $mt_data->fb_pixel_status === "on")
@if (isset($mt_data->fb_pixel) && !empty($mt_data->fb_pixel))
    <!-- Facebook Pixel Code -->
    <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init', {{$mt_data->fb_pixel}});fbq('track', 'PageView');</script>
    <!-- End Facebook Pixel Code -->
@endif
@endif