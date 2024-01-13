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
<style>
       
    </style>
    <!-- Error page-->
    <div class="misc-wrapper fourone-error">
        <div class="container">
            <div class="content-detail">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <a href="{{url('/')}}" class="logo">
                            <img src="{{asset('website/img/logo/logo-horizontal-black.svg')}}" alt="" class="main-logo">
                        </a>
                        <h1 class="global-title"><span>4</span><span>0</span><span>4</span></h1>
                        <h4 class="sub-title">Oops!</h4>
        
                        <p class="detail-text">We're sorry,<br> The page you were looking for doesn't exist anymore.</p> 
                        <form action="https://wapost.net/search-results" method="GET">
                            <div class="form-group floating-addon floating-addon-not-append my-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search" name="keyword">
                                    <div class="input-group-append">
                                        <button class="btn-common flat-btn btn-active" type="submit">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="back-btn">
                            <a class="btn-link flat-btn btn-active" href="{{ route('login') }}">Sign out and connect with another login.</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 d-flex align-items-center">
                        <img src="{{url('/')}}/website/img/404/Fix-Error-404.png" class="shape-02" alt="mountant">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Error page-->
@endsection
