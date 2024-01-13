@extends('layouts.website')
@section('title')
    @if ($blog->meta_title == '')
        {{ $blog->title ?? 'Blogs' }}
    @else
        {{ __('Blog - ') . $blog->meta_title }}
    @endif
@endsection
@section('meta-title')
    @if ($blog->meta_title == '')
        {{ $blog->title ?? 'Blogs' }}
    @else
        {{ __('Blog - ') . $blog->meta_title }}
    @endif
@endsection
@section('meta-description')
    @if ($blog->meta_description == '')
        {!!$blog->content!!}
    @else
        {{ __('Blog - ') . $blog->meta_description }}
    @endif
@endsection
@section('content')

<div class="blog-page-wrapper blog-details-wrapper single-page-section-top-space single-page-section-bottom-space">
    <!---- Blog Grid Secction start here ---->
    <section class="blog-details-section section-top-space">
        <div class="container custom-container-01">
            <div class="row">
                <div class="col-lg-8">
                    {{-- @dd($blog) --}}
                    <div class="blog-grid-item-02 style-02 blog-details">
                        <h1 class="main-title">{{ $blog->title ?? 'Blogs' }}</h1>
                        <div class="content">
                            <ul class="post-categories style-01">
                                <li><img src="{{asset('website/img/icon/themeim.png')}}" alt="">{{ $blog->author?->name }}</li>
                                <li><img src="{{asset('website/img/icon/calander-book.png')}}" alt="">{{ Carbon\Carbon::parse($blog->author?->created_at)->format('j, F, y') }}</li>
                            </ul>
                        </div>
                        <div class="thumbnail main">
                            <img src="{{asset('../images/assets/blogs/banners/'.$blog->image)}}" alt="Group Study">
                        </div>
                    </div>
                    <div class="blog-details-content">
                        {!!$blog->content!!}
                    </div>

                    @if ($blog->author != null) 
					<hr class="my-5">
                    <!-- Author details  -->
					<div class="author-card card border-0 shadow-sm">
						<div class="card-body w-100">
							<div class="row">
								<div class="col-sm-3 col-xl-2">
                                    @if ($blog->author->profile_pic != '')
                                    <img class="author-dp mx-sm-auto mb-2" src="{{asset('images/assets/blogs/authors/'.$blog->author->profile_pic)}}" alt="Group Study">
                                    @endif
								</div>
								<div class="col-sm-9 col-xl-10">
									<div class="author-info">
										<h4 class="author-name h5 font-600">{{$blog->author->name}}</h4>
										<p class="text-muted small mb-2">{{$blog->author->designation}}</p>
										<p class="author-bio">{{$blog->author->bio}}</p>
										<ul class="author-social">
											@if ($blog->author->facebook_profile != '')<li class="author-social-list"><a href="{{$blog->author->facebook_profile}}" target="_blank" title="Facebook"><i class="bi bi-facebook" style="color:#4267B2;"></i></a></li> @endif
											@if ($blog->author->instagram_profile != '')<li class="author-social-list"><a href="{{$blog->author->instagram_profile}}" target="_blank" title="Instagram"><i class="bi bi-instagram" style="color:#3f729b;"></i></a></li>@endif
											@if ($blog->author->linkedin_profile != '')<li class="author-social-list"><a href="{{$blog->author->linkedin_profile}}" target="_blank" title="LinkedIn"><i class="bi bi-linkedin" style="color:#0e76a8;"></i></a></li>@endif
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				    @endif

                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="widget-area">
                        {{-- <div class="widget widget_search">
                            <h2 class="widget-headline">Search</h2>
                            <form class="search-form">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search" name="src" value="{{ $request->scr ?? '' }}">
                                </div>
                                <button class="submit-btn" type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div> --}}
                        @if ($setting->show_top_post)
                        <div class="widget widget_recent_posts">
                            <h4 class="widget-headline">Recent Post</h4>
                            <ul class="theme-recent-post-wrap">
                                @foreach($featuredBlog as $blog)
                                <li class="theme-recent-post-item">
                                    <div class="thumb">
                                        @if ($blog->image != null)
                                        <img src="{{asset('../images/assets/blogs/banners/thumbnails/'.$blog->image)}}" alt="recent post">
                                        @endif
                                    </div>
                                    <div class="content">
                                    <span class="time">{{\Carbon\Carbon::parse($blog->created_at)->format('j F, Y') }}</span>
                                        <h4 class="title"><a href="{{url('blogs'.'/'.$blog->slug)}}"></a>{{ $blog->title }}</h4>
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
    </section>
    <!---- Blog Grid Secction End Here ---->
</div>

@endsection