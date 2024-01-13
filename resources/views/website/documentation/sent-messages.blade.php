@extends('layouts.website')
@section('title', __('Send Campaign - How WAPost WhatsApp Marketing Sender Works '))
@section('meta-description', __('Send Campaign - How WAPost WhatsApp Marketing Sender Works'))
@section('canonical', __('https://wapost.net/documentation/sent_messages'))
@section('content')

    {{--  documentation page start here  --}}
    <div class="about-page-area-wrapper single-page-section-top-space single-page-section-bottom-space">

        <div class="documentation-page">
            <div class="main-head bg-white border-bottom d-flex py-3 w-100">
                <button class="navbar-toggler mx-3" type="button" id="doc-sidebar-toggle">
                    <span class="fa fa-bars"></span>
                </button>
                <h1 class="fw-bold mb-0 ms-md-3 h4">Documentation</h1>
            </div>
        
            
            @include('website.components.document-header')
            
        
            <div class="main-content">
                <section class="section">
                    <div class="section-body">
                        <div class="section-header">
                            <h2 id="overview" class="doc-main-page-head">Send Campaign</h2>
                        </div>
                        <hr class="mt-0 mb-3">
                       
                        <div class="mb-0 pt-5">
                                                   
                            <div class="about-content">
                                <p class="paragraph">1. If you’re looking to schedule messages for one or more contact groups, according to your segmented audience, Send Campaign has got you covered.  You can schedule messages with any files attached for a date and time occurring in the future.</p>
                                <p class="paragraph">2. For your added convenience, Send Campaigns work similarly to Quick Send by verifying your connection of WhatsApp Account to WAPost.</p>
                                <p><img alt="" src="{{asset('website/img/documentation/document8.jpg')}}" style="height:612px; width:1280px" width="964.2" height="461"></p>
                                <br>
                                <p class="paragraph">3. And if you are not connected, you can connect your account with the comfort of a click. All you have to do is click the “Connect Now” button.</p>
                                <p><img alt="" src="{{asset('website/img/documentation/document81.jpg')}}" style="height:612px; width:1280px" width="964.2" height="461"></p>
                                <p class="paragraph">4. What makes it even better is that you don’t have to be logged in at the scheduled time for your scheduled message to be sent. Your message will be delivered irrespective of your login status.</p>
    
                            </div>
                        </div>                            
                    </div>
                </section>
            </div>
        </div>
    </div>
    {{-- documentation page end here   --}}

@endsection
@push('end_body')
<script>
    $(document).on('click', '#doc-sidebar-toggle', function(){
        $('.documentation-page').toggleClass('sb-active');
    });

    /* when click outside the documents page sidebar */
    $(document).mouseup(function(e){
        /* check if main container has a class "sb-active" */
        if($('.documentation-page').hasClass('sb-active')){
            var sidebar = $(".main-sidebar");
            var toggle_btn = $("#doc-sidebar-toggle");
            // if the target of the click isn't the sidebar nor a descendant of the sidebar
            if (!sidebar.is(e.target) && sidebar.has(e.target).length === 0 && !toggle_btn.is(e.target) && toggle_btn.has(e.target).length === 0) {
                /* remove the class active for collapced the sidebar */
                $('.documentation-page').removeClass('sb-active');
            }
        }
    });
</script>

@endpush