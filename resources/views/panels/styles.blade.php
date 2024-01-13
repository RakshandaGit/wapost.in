<!-- BEGIN: Vendor CSS-->
@if ($configData['direction'] === 'rtl' && isset($configData['direction']))
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors-rtl.min.css')) }}"/>
@else
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors.min.css')) }}"/>
@endif
<link rel="stylesheet" href="{{ asset('vendors/css/jquery.datetimepicker.min.css') }}"/>
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.min.css" /> --}}

@yield('vendor-style')
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" href="{{ asset(mix('css/core.css')) }}"/>
<link rel="stylesheet" href="{{ asset(mix('css/base/themes/dark-layout.css')) }}"/>
<link rel="stylesheet" href="{{ asset(mix('css/base/themes/bordered-layout.css')) }}"/>
<link rel="stylesheet" href="{{ asset(mix('css/base/themes/semi-dark-layout.css')) }}"/>
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">


@php $configData = Helper::applClasses(); @endphp

<!-- BEGIN: Page CSS-->
@if ($configData['mainLayoutType'] === 'horizontal')
    <link rel="stylesheet" href="{{ asset(mix('css/base/core/menu/menu-types/horizontal-menu.css')) }}"/>
@else
    <link rel="stylesheet" href="{{ asset(mix('css/base/core/menu/menu-types/vertical-menu.css')) }}"/>
@endif

{{-- Page Styles --}}
@yield('page-style')

<!-- laravel style -->
<link rel="stylesheet" href="{{ asset(mix('css/overrides.css')) }}"/>
<link rel="stylesheet" href="{{ asset('dashboard_page/dashboard_pages.css') }}">

<link rel="stylesheet" href="{{ asset('vendors/wa-editors/quill/quill.snow.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/wa-editors/quill/quill.emoji.css') }}">
<!-- BEGIN: Custom CSS-->

@if ($configData['direction'] === 'rtl' && isset($configData['direction']))
    <link rel="stylesheet" href="{{ asset(mix('css-rtl/custom-rtl.css')) }}"/>
    <link rel="stylesheet" href="{{ asset(mix('css-rtl/style-rtl.css')) }}"/>

@else
    {{-- user custom styles --}}
    <link rel="stylesheet" href="{{ asset(mix('css/style.css')) }}"/>
@endif
<style>
    .alert.alert-danger button.close,.alert.alert-success button.close {
        float: right;
        border: 0;
        font-size: 20px;
        font-weight: 800;
        background: transparent;
        line-height: 20px;
    }
    .alert.alert-danger,.alert.alert-success {
        display: none;
    }
</style>