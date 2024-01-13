@php
    $configData = Helper::applClasses();
@endphp
@extends('layouts/fullLayoutMaster')

@section('title', __('locale.http.500.title'))
@section('code', '500')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-misc.css')) }}">
@endsection
@section('content')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Error page-->
    <div class="misc-wrapper fourone-error">
        <div class="container">
            <div class="content-detail">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <a href="{{url('/')}}" class="logo">
                            <img src="{{asset('website/img/logo/logo-horizontal-black.svg')}}" alt="" class="main-logo">
                        </a>
                        <h1 class="global-title"><span>5</span><span>0</span><span>0</span></h1>
        
                        <h4 class="sub-title">Opps! Internal Server Error!</h4>
        
                        <p class="detail-text">Unfortunately we're having trouble loading the page you are looking for. Please come back in a while.</p> 
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
                        <div class="page-505">
                            <div class="outer">
                                <div class="middle">
                                    <div class="inner">
                                        <div class="inner-circle"><i class="fa fa-cogs"></i><span>500</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Error page-->
@endsection
