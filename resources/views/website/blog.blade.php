@extends('layouts.website')
@section('title')
    @if ($setting->meta_title == '')
        {{ $setting->title ?? 'Blogs & Articles on WhatsApp Marketing | WAPost' }}
    @else
        {{ __('Blog - ') . $setting->meta_title }}
    @endif
@endsection
@section('meta-title')
    @if ($setting->meta_title == '')
        {{ $setting->title ?? 'Blogs & Articles on WhatsApp Marketing | WAPost' }}
    @else
        {{ __('Blog - ') . $setting->meta_title }}
    @endif
@endsection
@section('meta-description')
    @if ($setting->meta_description == '')
        {!! $setting->description ?? 'Learn how to optimize your messaging, increase customer engagement, and grow your
        business using WhatsApp Marketing sender' !!}
    @else
        {{ __('Blog - ') . $setting->meta_description }}
    @endif
@endsection
@section('title', __('Blogs & Articles on WhatsApp Marketing | WAPost'))
@section('meta-title', __('Blogs & Articles on WhatsApp Marketing | WAPost'))
@section('meta-description',
    __('Learn how to optimize your messaging, increase customer engagement, and grow your
    business using WhatsApp Marketing sender'))
    {{-- @section('meta-keywords', __('')) --}}

@section('content')

    <!------ Blog Page strat here ------>
    <div class="blog-page-wrapper single-page-section-top-space single-page-section-bottom-space">
        <div class="breadcrumb-wrap section-top-space style-01">
            <div class="container custom-container-01">
                <div class="row">
                    <div class="col-lg-12">
                        {{-- @dd($setting) --}}
                        <div class="breadcrumb-content">
                            <h3 class="title">{{ $setting->title ?? 'Blogs' }}</h3>
                            <p class="details">{!! $setting->description ?? 'wapost.net' !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="blog-grid-sectin">
            <div class="container custom-container-01">
                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        <div class="blog-items-wrap">
                            <div class="row">
                                {{-- @dd($blog); --}}
                                @foreach ($letestBlog as $blog)
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="blog-grid-item-02">
                                            <div class="thumbnail">
                                                @if ($blog->image != '')
                                                    <img src="{{ asset('../images/assets/blogs/banners/' . $blog->image) }}"
                                                        alt="">
                                                @endif
                                            </div>
                                            <div class="content">
                                                <ul class="post-categories">
                                                    @if ($blog->author?->name != '')
                                                    <li><img src="{{ asset('website/img/icon/themeim.png') }}"
                                                            alt="">{{ $blog->author?->name }}</li>
                                                    @endif
                                                    @if ($blog->author?->created_at != '')
                                                    <li><img src="{{ asset('website/img/icon/calander-book.png') }}"
                                                            alt="">{{ \Carbon\Carbon::parse($blog->author?->created_at)->format('j F, Y') }}
                                                    </li>
                                                    @endif
                                                </ul>
                                                <h2 class="title"> <a
                                                        href="{{ url('blogs' . '/' . $blog->slug) }}">{{ $blog->title }}</a>
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {!! $letestBlog->links('pagination::bootstrap-4') !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <div class="widget-area">
                            {{-- <div class="widget widget_search">
                                <h2 class="widget-headline">Search</h2>
                                <form class="search-form">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Search" name="src"
                                            value="{{ $request->src ?? '' }}">
                                    </div>
                                    <button class="submit-btn" type="submit"><i class="fa fa-search"></i></button>
                                </form>
                            </div> --}}
                            @if ($setting->show_top_post)
                                <div class="widget widget_recent_posts">
                                    <h4 class="widget-headline">Recent Post</h4>
                                    <ul class="theme-recent-post-wrap">
                                        @foreach ($featuredBlog as $blog)
                                            <li class="theme-recent-post-item">
                                                <div class="thumb">
                                                    @if ($blog->image != null)
                                                        <img src="{{ asset('../images/assets/blogs/banners/thumbnails/' . $blog->image) }}"
                                                            alt="recent post">
                                                    @endif
                                                </div>
                                                <div class="content">
                                                    <span
                                                        class="time">{{ \Carbon\Carbon::parse($blog->created_at)->format('j F, Y') }}</span>
                                                    <h4 class="title"><a
                                                            href="{{ url('blogs' . '/' . $blog->slug) }}">{{ $blog->title }}
                                                            ></a>
                                                    </h4>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if ($setting->show_subscription)
                                <div class="widget widget_recent_posts">
                                    <h4 class="widget-headline">More Update!</h4>
                                    <p>Join our mailing list and keep up with <span class="brandname">wapost.net</span>

                                    <div class="">
                                        <div class="">
                                            <div class="">
                                                {{-- <form class="form form-vertical" method="POST" action="{{ route('blog.subscribe') }}" enctype="multipart/form-data">
                                                    @csrf --}}
                                                <input type="email" name="email" class=""
                                                    placeholder="Your Email ID" id="blogEmail" required>
                                                <button type="button" class="btn waves-button-input" onclick="onclickSend()">Send</button>
                                                <p class="text-message-success text-success" id="success-message"></p>
                                                <p class="text-message-error text-danger" id="error-message"></p>
                                                {{-- </form> --}}
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="error-message-sec">
                                        <p class="text-message-success" id="success-message"></p>
                                        <p class="text-message-error" id="error-message"></p>
                                    </div> --}}

                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
<script>
    function onclickSend() {
        const email = $('#blogEmail').val();

        var basicbtn = $('.waves-button-input');
        var originalText = basicbtn.html();
        basicbtn.html('Please Wait...');

        $.get("{{ route('blog.subscribe') }}", {
            email: email
        }, function(response) {
            if (response.status == true) {
                $("#success-message").text(response.message);
                setTimeout(function() {
                    $("#success-message").remove();
                    location.reload();
                }, 1000);
            } else {
                // Handle the error case here
                $("#error-message").text(response.message);
            }
        }).fail(function() {
            // Handle AJAX failure (e.g., network error)
            $("#error-message").text("Email can not be empty.");
        }).always(function() {
            basicbtn.html(originalText);
        });
    }
</script>

@endsection
