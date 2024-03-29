@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
<!DOCTYPE html>
@php
    $configData = Helper::applClasses();
@endphp

<html class="loading {{ ($configData['theme'] === 'light') ? '' : $configData['layoutTheme']}}"
      lang="@if(Session::has('locale')){{Session::get('locale')}}@else{{config('app.locale')}}@endif"
      data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}"
      @if($configData['theme'] === 'dark') data-layout="dark-layout" @endif>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="keywords" content="{{config('app.keyword')}}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') - {{config('app.title')}}</title>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo asset(config('app.favicon')); ?>"/>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('dashboard_page/dashboard_pages.css') }}">
        {{-- Include core + vendor Styles --}}
        @include('panels/styles')

    </head>
    <!-- END: Head-->

    <!-- BEGIN: Body-->
    @isset($configData["mainLayoutType"])
        @extends((( $configData["mainLayoutType"] === 'horizontal') ? 'layouts.horizontalLayoutMaster' : 'layouts.verticalLayoutMaster' ))
    @endisset
    @if(Helper::app_config('custom_script') != '')
        {!! Helper::app_config('custom_script') !!}
    @endif
