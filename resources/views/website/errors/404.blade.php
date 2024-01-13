@php
    $configData = Helper::applClasses();
@endphp
@extends('layouts/fullLayoutMaster')

@section('title', __('locale.http.404.title'))
@section('code', '404')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-misc.css')) }}">
@endsection
@section('content')
    <!-- Error page-->
        <div class="misc-wrapper four-error">
            <div class="container-fluid">
                <div class="content-detail">
                    <h1 class="global-title"><span>4</span><span>0</span><span>4</span></h1>

                    <h4 class="sub-title">Oops!</h4>

                    <p class="detail-text">We're sorry,<br> The page you were looking for doesn't exist anymore.</p> 

                    <div class="back-btn">
                        <a class="btn btn-primary mb-2 btn-sm-block" href="{{ route('login') }}">{{__('locale.labels.back_to_home')}}</a>
                    </div>
                </div>
            </div>
            <!-- <a class="brand-logo" href="{{route('login')}}">
                <img src="{{asset(config('app.logo'))}}" alt="{{config('app.name')}}"/>
            </a>

            <div class="misc-inner p-2 p-sm-3">
                <div class="w-100 text-center">
                    <h2 class="mb-1">{{__('locale.http.404.title')}}!️</h2>
                    <p class="mb-2">{{ __($exception->getMessage() ?: __('locale.http.404.description')) }}</p>
                    <a class="btn btn-primary mb-2 btn-sm-block" href="{{ route('login') }}">{{__('locale.labels.back_to_home')}}</a>
                    @if($configData['theme'] === 'dark')
                        <img class="img-fluid" src="{{asset('images/pages/error-dark.svg')}}" alt="Error page" />
                    @else
                        <img class="img-fluid" src="{{asset('images/pages/error.svg')}}" alt="Error page" />
                    @endif
                </div>
            </div> -->
        </div>
    </div>
    <!-- / Error page-->
@endsection
