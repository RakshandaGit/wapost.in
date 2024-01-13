@extends('layouts.website')
@section('title', __('Documentation - How WAPost Bulk WhatsApp Sender Works '))
@section('meta-title', __('Documentation - How WAPost Bulk WhatsApp Sender Works '))
@section('meta-description', __('WAPost - Check out the complete documentation on how WAPost bulk whatsapp sender works.'))
@section('canonical', __('https://wapost.net/documentation/dashboard'))
{{-- @section('meta-keywords', __('')) --}}
@section('content')

    {{--  documentation page start here  --}}
    <div class="document-page-area-wrapper single-page-section-top-space single-page-section-bottom-space">

        <div class="documentation-page">
            <div class="main-head bg-white border-bottom d-flex py-3 w-100">
                <button class="navbar-toggler mx-3" type="button" id="doc-sidebar-toggle">
                    <span class="fa fa-bars"></span>
                </button>
                <h1 class="fw-bold mb-0 ms-md-3 h4">WhatsApp Marketing Sender Documentation</h1>
            </div>
        
            
            @include('website.components.document-header')
            
        
            <div class="main-content">
                <section class="section">
                    <div class="section-body">
                        <div class="section-header">
                            <h2 id="overview" class="doc-main-page-head">Dashboard</h2>
                        </div>
                        <hr class="mt-0 mb-3">
                       
                        <div class="mb-0 pt-5">
                                                   
                            <div class="about-content">
                                <p class="paragraph">1. You can easily track and analyse your data, including contact groups, contacts, and blacklist management in your dashboard.</p>
                                <p><img alt="" src="{{asset('website/img/documentation/document11.png')}}" style="height:612px; width:1280px" width="964.2" height="461"></p>
                                <p class="paragraph">2. You can also create unlimited contact groups where you can segment your audience and target them with personalised messages that truly resonate with them for effective marketing. </p>
                                <p class="paragraph">3. While you can only register one number per WhatsApp Account, you can connect multiple accounts to WAPost. You can view all the WhatsApp Accounts that you have linked to WAPost in the dashboard itself.</p>
                                <p class="paragraph">4. Other than that, you can also view your current plan within your dashboard for your ease of access.</p>
    
                                <p><img alt="" src="{{asset('website/img/documentation/document1.png')}}" style="height:612px; width:1280px" width="964.2" height="461"></p>
    
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

<script>
    $(document).on('click', '.page_content_sidebar', function(e) {
        e.preventDefault();
        // target element id
        var id = $(this).attr('href');
        // target element
        var $id = $(id);
        if ($id.length === 0) {
            return;
        }
        var pos = $id.offset().top;
        $('body, html').animate({
            scrollTop: pos
        });
    });
</script>
@endpush