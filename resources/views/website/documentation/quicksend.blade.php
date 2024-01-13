@extends('layouts.website')
@section('title', __('Quick Send - How WAPost WhatsApp Marketing Sender Works '))
@section('meta-description', __('Quick Send - How WAPost WhatsApp Marketing Sender Works'))
@section('canonical', __('https://wapost.net/documentation/quicksend'))
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
                            <h2 id="overview" class="doc-main-page-head">Quick Send</h2>
                        </div>
                        <hr class="mt-0 mb-3">
                       
                        <div class="mb-0 pt-5">
                                                   
                            <div class="about-content">
                                <p class="paragraph">1. Send messages in a flash with just a few clicks with WhatsApp Quick Send.</p>
                                <p class="paragraph">2. WhatsApp Quick Send allows you to send a variety of messages within no time. Whether you want to send a simple text message, share a media file, send a document, or even a contact number, Quick Send has got you covered!</p>
                                <p class="paragraph">3. You can send any files, such as images, videos, documents, contact numbers, and more, by selecting what you’re looking to send and uploading it. You can also add a caption which is delivered as a text message along with your file. It’s that easy!</p>
                                <p class="paragraph">4. Moreover, Quick Send allows you to send your message to multiple contacts by separating the contact numbers through a comma (,).</p>
                                <p class="paragraph">5. To improve your experience further, Quick Send automatically verifies if your WhatsApp Account is connected to WAPost or yet to be connected.</p>
                                <p class="paragraph">6. This lets you work without any interruption and errors while also saving you time and effort by not having to verify manually.</p>
                                <p><img alt="" src="{{asset('website/img/documentation/document5.jpg')}}" style="height:612px; width:1280px" width="964.2" height="461"></p>
                                <br>
                                <p class="paragraph">7. However, if no account is connected, you can connect your account by simply clicking on the “Connect Now” button.</p>
                                <p><img alt="" src="{{asset('website/img/documentation/document51.jpg')}}" style="height:612px; width:1280px" width="964.2" height="461"></p>
                                <p class="paragraph">8. WAPost supports image files up to 5Mb in size. However, for other files, such as videos, audios, and documents, the size extends to 16 Mb.</p>
                                <p class="paragraph">9. You can send images with JPEG and PNG extensions and videos in MP4 and 3GPP format. While audio files can be sent in either MP3, OGG, or Wav extension, WAPost offers you the ability to share your documents with all kinds of extensions!</p>
                                <p class="paragraph">10. Apart from this, you can also share the contact numbers that you want to share with your desired recipients. </p>
                                
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