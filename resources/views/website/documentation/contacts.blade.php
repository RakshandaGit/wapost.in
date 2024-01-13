@extends('layouts.website')
@section('title', __('Contacts - How WAPost WhatsApp Marketing Sender Works '))
@section('meta-description', __('Contacts - How WAPost WhatsApp Marketing Sender Works'))
@section('canonical', __('https://wapost.net/documentation/contacts'))
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
                            <h2 id="overview" class="doc-main-page-head">Contacts</h2>
                        </div>
                        <hr class="mt-0 mb-3">
                       
                        <div class="mb-0 pt-5">
                                                   
                            <div class="about-content">
                                <p class="paragraph">1. Contacts allow for comfortable access to view all your contacts for any WhatsApp account that you have connected to WAPost. It also makes everything easy as you can add new contacts and groups, and also export them.</p>
                                <p class="paragraph">2. Additionally, you can fetch groups from your connected WhatsApp account. And, if in case you have connected multiple accounts, you can select the account from which you’d like the group to be fetched. </p>
                                <p class="paragraph">3. Moreover, with just a single click, you can enable or disable your contact groups in seconds. Simply click on the slider and watch as your contact group status changes seamlessly.</p>
                                <p class="paragraph">4. Added to that, you can also import your existing contacts from a CSV file or an Excel sheet. However, while importing through such files, you need to ensure that your files stick to the format provided in the sample file for a smooth data transfer. The sample file can be downloaded and used for reference.</p>
    
                                <p><img alt="" src="{{asset('website/img/documentation/document3.jpg')}}" style="height:612px; width:1280px" width="964.2" height="461"></p>
    
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