<div class="widget-area style-01">
    <style>
        .theme-recent-post-wrap li.theme-recent-post-item .content .title{
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
    </style>
    {{-- <div class="widget widget_search">
        <h2 class="widget-headline">Search</h2>
        <form action="blog.html" class="search-form">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search">
            </div>
            <button class="submit-btn" type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div> --}}

    @isset($featuredBlog)
    <div class="widget widget_recent_posts">
        <h4 class="widget-headline">Featured Blogs</h4>
        <ul class="theme-recent-post-wrap">

            @foreach ($featuredBlog as $blog)
            <li class="theme-recent-post-item">
                <div class="thumb">
                    <img src="{{asset('website/img/sections/blog/blog-side-01.png')}}" alt="recent post">
                </div>
                <div class="content">
                <span class="time">{{\Carbon\Carbon::parse($blog->updated_at)->format('M d, Y')}}</span>
                    <h4 class="title"><a href="{{url('blogs'.'/'.$blog->slug)}}">{{$blog->title}}</h4>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    @endisset

    <!-- <div class="widget widget_category">
        <h3 class="widget-headline">category</h3>
        <ul>
            <li><a href="#">Online Course<span>(04)</span></a></li>
            <li><a href="#">Online Education<span>(13)</span></a></li>
            <li><a href="#">Study in Abroad<span>(25)</span></a></li>
            <li><a href="#">Student Consultanc<span>(9)</span></a></li>
            <li><a href="#">Online Education<span>(7)</span></a></li>
        </ul>
    </div> -->

    @if($setting->show_subscription)
    <div class="">
        <h5 class="font-h1 ">More Update!</h5>
        <p>Join our mailing list and keep up with <span class="brandname">wapost.net</span></p>
        <div class="subscriber">
          <div class="subscribe_form">
              <div class="subs_row">
                  <input type="email" class="subscribe_input" required placeholder="Your Email ID" id="subscriber">
                  <button type="submit" class="subs_btn" id="subscribeEmail">Send</button>
              </div>
          </div>
        </div>
        <div class="error-message-sec">
            <p class="text-message-success"></p>
            <p class="text-message-error"></p>
        </div>
    </div>

    <hr class="my-4">
    @endif
    
</div>