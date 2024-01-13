@php
    $configData = Helper::applClasses();
@endphp
@extends('layouts/fullLayoutMaster')

@section('title', __('locale.http.419.title'))
@section('code', '419')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-misc.css')) }}">
@endsection
@section('content')
    <!-- Error page-->
    <div class="misc-wrapper fourone-error">
        <div class="container">
            <div class="content-detail">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <a href="{{url('/')}}" class="logo">
                            <img src="{{asset('website/img/logo/logo-horizontal-black.svg')}}" alt="" class="main-logo">
                        </a>
                        <h1 class="global-title"><span>4</span><span>1</span><span>9</span></h1>
                        <h4 class="sub-title">Page Expired</h4>
        
                        <p class="detail-text">Sorry, your session has expired. <br> Please refresh and try again.</p> 
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
                        <img class="img-fluid mt-3" src="{{url('/')}}/website/img/404/website-under.png" alt="Error page" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Error page-->
@endsection
