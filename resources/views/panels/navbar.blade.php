@if ($configData['mainLayoutType'] == 'horizontal' && isset($configData['mainLayoutType']))
    <nav class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center {{ $configData['navbarColor'] }}"
        data-nav="brand-center">
        <div class="navbar-header d-xl-block d-none">
            <ul class="nav navbar-nav">
                @if (Auth::user()->active_portal == 'customer' &&
                        Auth::user()->is_customer == 1 &&
                        Auth::user()->customer->activeSubscription())
                    <li class="nav-item"><a class="navbar-brand" href="{{ route('user.home') }}">
                            <span class="brand-logo"><img src="{{ asset(config('app.logo')) }}" alt="app logo" /></span>
                        </a>
                    </li>
                @else
                    <li class="nav-item"><a class="navbar-brand" href="{{ route('admin.home') }}">
                            <span class="brand-logo"><img src="{{ asset(config('app.logo')) }}" alt="app logo" /></span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    @else
        <nav
            class="header-navbar navbar navbar-expand-lg align-items-center {{ $configData['navbarClass'] }} navbar-light navbar-shadow {{ $configData['navbarColor'] }} {{ $configData['layoutWidth'] === 'boxed' && $configData['verticalMenuNavbarType'] === 'navbar-floating' ? 'container-xxl' : '' }}">
@endif


<div class="navbar-container d-flex content">
    <div class="bookmark-wrapper d-flex align-items-center">
        <ul class="nav navbar-nav d-xl-none">
            <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon"
                        data-feather="menu"></i></a></li>
        </ul>
        <ul class="nav navbar-nav">
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pe-0 my-0 me-2" data-toggle="collapse">
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4 text-primary" data-feather="disc" data-ticon="disc"></i>
                </a>
            </li>
            <li>
                @if(Auth::user()->is_enterprise == 1)
                    <div style="display:{{(Auth::user()->isAdmin() || (in_array(request()->segment(1), ['partner']))) ? 'none' : 'block';}}"><a href="{{ URL::to('/partner/users') }}" class="prtnbtndash"><img width="16" height="16" src="https://img.icons8.com/material-outlined/24/000000/handshake--v1.png" alt="handshake--v1"/><span>Partner</span></a></div> 
                @endif
                @if(Auth::user()->is_enterprise == 1)
                    <div style="display:{{(in_array(request()->segment(1), ['partner'])) ? 'block' : 'none';}}"><a href="{{ route('user.home') }}" class="prtnbtndash"><img width="16" height="16" src="https://img.icons8.com/material-rounded/24/arrow-pointing-left.png" alt="arrow-pointing-left"/><span>   Dashboard</span></a></div> 
                @endif
            </li>
        </ul>
    </div>

    
    <ul class="nav navbar-nav align-items-center ms-auto">
        @php
            $totalConnection = \App\Models\Connection::where('user_id', Auth::user()->id)->where('status', 1)->get();
        @endphp
        <div class="connectionbtn" style="display:{{(Auth::user()->isAdmin() || (in_array(request()->segment(1), ['partner']))) ? 'none' : 'block';}}">
            @if(count($totalConnection) > 0)
                <div class="d-md-block">
                        <p class="mb-0 constate"><i class="fa fa-wifi mr-2 mt-1"></i> <span class="badge badge-success py-1">{{count($totalConnection) > 1 ? count($totalConnection).' Connections' : '1 Connection'}}</span></p>
                </div>
            @else
                <div><a href="{{ route('customer.connection') }}" class="connectionbtndash">Connect Now</a></div>
            @endempty
        </div>
        {{-- Language Dropdown --}}
        {{-- <li class="nav-item dropdown dropdown-language">
                            <a class="nav-link dropdown-toggle" id="dropdown-flag" href="#" data-bs-toggle="dropdown" aria-haspopup="true">
                                    <i class="flag-icon flag-icon-us"></i>
                                    <span class="selected-language">English</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
                                @foreach (\App\Helpers\Helper::languages() as $lang)
                                    <a class="dropdown-item" href="{{url('lang/'.$lang['code'])}}" data-language="{{$lang['code']}}">
                                        <i class="flag-icon flag-icon-{{$lang['iso_code']}}"></i> {{ $lang['name'] }}
                                    </a>
                                @endforeach

                            </div>
                        </li> --}}

        {{-- Dark and light option. It will be theme manager option --}}
        {{--                        <li class="nav-item d-none d-lg-block"> --}}
        {{--                            <a class="nav-link nav-link-style"><i class="ficon" data-feather="{{ $configData['theme'] === 'dark' ? 'sun' : 'moon' }}"></i></a> --}}
        {{--                        </li> --}}

        {{-- Notification dropdown --}}
        
        <li class="nav-item dropdown dropdown-notification me-25">
            <a class="nav-link" href="javascript:void(0);" data-bs-toggle="dropdown">
                <i class="ficon" data-feather="bell"></i>
                @php
                    $count = \App\Models\Notifications::where('user_id', Auth::user()->id)
                        ->where('mark_read', 0)
                        ->count();
                @endphp
                @if ($count)
                    <span class="badge rounded-pill bg-danger badge-up">{{ $count }}</span>
                @endif

            </a>
            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
                <li class="dropdown-menu-header">
                    <div class="dropdown-header d-flex">
                        <h4 class="notification-title mb-0 me-auto">{{ __('locale.labels.notifications') }}</h4>
                        <div class="badge rounded-pill badge-light-primary">{{ $count }}
                            {{ __('locale.labels.new') }}</div>
                    </div>
                </li>
                <li class="scrollable-container media-list">

                    @foreach (\App\Models\Notifications::where('user_id', Auth::user()->id)->where('mark_read', 0)->latest()->take('10')->cursor() as $value)
                        <a class="d-flex" href="{{ route('user.account', ['tab' => 'notification']) }}">
                            <div class="list-item d-flex align-items-start">
                                @switch($value->notification_type)
                                    @case('user')
                                        <div class="me-1">
                                            <div class="avatar bg-light-primary">
                                                <div class="avatar-content"><i class="avatar-icon" data-feather="user"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="list-item-body flex-grow-1">
                                            <p class="media-heading"><span
                                                    class="fw-bolder">{{ __('locale.labels.you_have_new_user') }}</p>
                                            <small class="notification-text"> {{ str_limit($value->message, 30) }}</small>
                                        </div>
                                    @break

                                    @case('plan')
                                        <div class="me-1">
                                            <div class="avatar bg-light-success">
                                                <div class="avatar-content"><i class="avatar-icon"
                                                        data-feather="shopping-cart"></i></div>
                                            </div>
                                        </div>

                                        <div class="list-item-body flex-grow-1">
                                            <p class="media-heading"><span
                                                    class="fw-bolder">{{ __('locale.labels.you_have_new_subscription') }}</p>
                                            <small class="notification-text"> {{ str_limit($value->message, 30) }}</small>
                                        </div>
                                    @break

                                    @case('senderid')
                                        <div class="me-1">
                                            <div class="avatar bg-light-danger">
                                                <div class="avatar-content"><i class="avatar-icon"
                                                        data-feather="user-check"></i></div>
                                            </div>
                                        </div>

                                        <div class="list-item-body flex-grow-1">
                                            <p class="media-heading"><span
                                                    class="fw-bolder">{{ __('locale.labels.new_sender_id_notification') }}</p>
                                            <small class="notification-text"> {{ str_limit($value->message, 30) }}</small>
                                        </div>
                                    @break

                                    @case('number')
                                        <div class="me-1">
                                            <div class="avatar bg-light-info">
                                                <div class="avatar-content"><i class="avatar-icon" data-feather="phone"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="list-item-body flex-grow-1">
                                            <p class="media-heading"><span class="fw-bolder">New Number sales</span></p>
                                            <small class="notification-text"> {{ str_limit($value->message, 30) }}</small>
                                        </div>
                                    @break

                                    @case('keyword')
                                        <div class="me-1">
                                            <div class="avatar bg-light-warning">
                                                <div class="avatar-content"><i class="avatar-icon" data-feather="clipboard"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="list-item-body flex-grow-1">
                                            <p class="media-heading"><span class="fw-bolder">New Keyword sales</span></p>
                                            <small class="notification-text"> {{ str_limit($value->message, 30) }}</small>
                                        </div>
                                    @break

                                    @case('chatbox')
                                        <div class="me-1">
                                            <div class="avatar bg-light-danger">
                                                <div class="avatar-content"><i class="avatar-icon"
                                                        data-feather="message-square"></i></div>
                                            </div>
                                        </div>

                                        <div class="list-item-body flex-grow-1">
                                            <p class="media-heading"><span class="fw-bolder">New Inbox Message</span></p>
                                            <small class="notification-text"> {{ str_limit($value->message, 30) }}</small>
                                        </div>
                                    @break

                                    @case('subscription')
                                        <div class="me-1">
                                            <div class="avatar bg-light-danger">
                                                <div class="avatar-content"><i class="avatar-icon"
                                                        data-feather="shopping-cart"></i></div>
                                            </div>
                                        </div>

                                        <div class="list-item-body flex-grow-1">
                                            <p class="media-heading"><span class="fw-bolder">Subscription Expired!</span></p>
                                            <small class="notification-text"> {{ str_limit($value->message, 60) }}</small>
                                        </div>
                                    @break

                                    @case('smsunit')
                                        <div class="me-1">
                                            <div class="avatar bg-light-danger">
                                                <div class="avatar-content"><i class="avatar-icon"
                                                        data-feather="message-square"></i></div>
                                            </div>
                                        </div>

                                        <div class="list-item-body flex-grow-1">
                                            <p class="media-heading"><span class="fw-bolder">SMS Unit Running Low!</span></p>
                                            <small class="notification-text"> {{ str_limit($value->message, 60) }}</small>
                                        </div>
                                    @break

                                    {{--            
                                                    @case('topup')
                                                    <div class="me-1">
                                                        <div class="avatar bg-light-danger">
                                                            <div class="avatar-content"><i class="avatar-icon" data-feather="shopping-cart"></i></div>
                                                        </div>
                                                    </div>

                                                    <div class="list-item-body flex-grow-1">
                                                        <p class="media-heading"><span class="fw-bolder">Offline Topup Payment!</span></p>
                                                        <small class="notification-text">{{ str_limit($value->message, 60) }}</small>
                                                    </div>
                                                    @break
                                                    --}}
                                @endswitch
                                <small>
                                    <time
                                        class="media-meta">{{ \App\Library\Tool::formatHumanTime($value->created_at) }}</time>
                                </small>

                            </div>
                        </a>
                    @endforeach
                </li>
                <li class="dropdown-menu-footer">
                    <a class="btn btn-primary w-100"
                        href="{{ route('user.account', ['tab' => 'notification']) }}">{{ __('locale.labels.read_all_notifications') }}</a>
                </li>
            </ul>
        </li>


        @if (Auth::user()->active_portal == 'customer' &&
                Auth::user()->is_customer == 1 &&
                Auth::user()->customer->activeSubscription())
            {{-- <li class="nav-item balance-top-up">
                                <div class="show-balance">
                                    <span class="show-balance-text">{{ __('locale.labels.balance') }}</span>
                                    <span class="show-balance-unit">{{ Auth::user()->sms_unit == '-1' ? __('locale.labels.unlimited') : Auth::user()->sms_unit  }}</span>
                                </div>
                                <a class="nav-link top-up-url d-sm-block" href="{{ route('user.account.top_up') }}">
                                    <button type="button" class="btn btn-sm btn-outline-success">
                                        <span class="font-weight-bold" style="font-size: 12px">{{ __('locale.labels.top_up') }}</span>
                                    </button>
                                </a>
                            </li> --}}
        @endif


        <li class="dropdown dropdown-user nav-item">
            <a class="dropdown-toggle nav-link dropdown-user-link" id="dropdown-user" href="javascript:void(0);"
                data-bs-toggle="dropdown" aria-haspopup="true">
                <div class="user-nav d-sm-flex d-none">
                    <span class="user-name fw-bolder">
                        @if (Auth::check())
                            {{ Auth::user()->displayName() }}
                        @else
                            {{ config('app.name') }}
                        @endif
                    </span>
                    <span class="user-status">{{ __('locale.labels.available') }}</span>
                </div>
                <span class="avatar">
                    {{-- {{dd(route('user.avatar', Auth::user()->uid))}} --}}
                    <img class="round" src="{{ route('user.avatar', Auth::user()->uid) }}"
                        alt="{{ config('app.name') }}" height="40" width="40" />
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                @if (Auth::user()->active_portal == 'admin' && Auth::user()->is_customer == 1)
                    <a class="dropdown-item" href="{{ route('user.switch_view', ['portal' => 'customer']) }}"><i
                            class="me-50" data-feather="log-in"></i>{{ __('locale.labels.switch_view') }}</a>
                    <div class="dropdown-divider"></div>
                @endif

                @if (Auth::user()->active_portal == 'customer' && Auth::user()->is_admin == 1)
                    <a class="dropdown-item" href="{{ route('user.switch_view', ['portal' => 'admin']) }}"><i
                            class="me-50" data-feather="log-in"></i>{{ __('locale.labels.switch_view') }}</a>
                    <div class="dropdown-divider"></div>
                @endif

                <h6 class="dropdown-header">{{ __('locale.labels.manage_profile') }}</h6>
                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="{{ route('user.account') }}"><i class="me-50"
                        data-feather="user"></i>{{ __('locale.labels.profile') }}</a>

                @if (Auth::user()->active_portal == 'customer' && Auth::user()->is_customer == 1)
                    <a class="dropdown-item" href="{{ route('customer.subscriptions.index') }}">
                        <i class="me-50" data-feather="shopping-cart"></i>
                        {{ __('locale.labels.billing') }}
                    </a>
                @endif

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                        class="me-50" data-feather="power"></i> {{ __('locale.menu.Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>
    </ul>
    
</div>
</nav>
<!-- END: Header-->
<!-- Coded by a designer™ -->
@if(!Auth::user()->is_enterprise == 1)
    @if(
        auth()->user()->customer && auth()->user()->customer->subscription &&
        (auth()->user()->customer->subscription->plan->price == 0 || auth()->user()->customer->subscription->plan->name == 'Free') &&
        URL::to('subscriptions/'.Auth::user()->customer->subscription->uid.'/change-plan') != url()->current()
    )
    <div class="reacherbanner container">
        <div class="banner">
            <div class="content">
                <div class="content-wrapper">
                    <div class="headline">
                        <p>Send unlimited and unrestricted messages without the 10 minutes wait.</p>
                    </div>
                    <a href="{{URL::to('subscriptions/'.Auth::user()->customer->subscription->uid.'/change-plan')}}" class="button">Buy now</a>
                </div>
            </div>
        </div>
    </div>
    @endif
@endif