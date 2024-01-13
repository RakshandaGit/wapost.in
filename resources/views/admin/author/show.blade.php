@extends('layouts/contentLayoutMaster')
@section('title', __('Edit Author'))
@section('vendor-style') 

<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset('vendors/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/cropper.css') }}">

<style>
    
    .input-group-addon {
        padding: .75rem;
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.25;
        color: #495057;
        text-align: center;
        background-color: #e9ecef;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: .25rem;
        border-top-left-radius:unset;
        border-bottom-left-radius:unset;
    }
   
    label span{
        color: red;
    }
    .missing-info{
        margin-bottom: 15px;
        font-style: italic;   
    }
    .capitalize input{
        text-transform: capitalize;
    }

    .success { color:green; }
    .error { color:green; }


    .important{
        position: relative;
        width: 100%;
        padding: 20px 15px 8px 15px;
        border: 1px solid var(--danger);
        border-radius: 4px;
        margin-bottom: 20px;
    }
    /* .important p:last-child{
        margin-bottom: 0px;
    } */
    .important::before{
        content: "Important";
        padding: 3px 10px;
        background-color: #ffffff;
        color: var(--danger);
        position:absolute;
        top:0;
        left: 15px;
        transform: translateY(-50%);
        font-size: 12px;
        font-weight: 500;
    }
    
</style>
@endsection

@section('content')


<section class="section">

    <div class="section-body">
        <form method="post" class="ProfileForm basicSettingform" action="{{ route('admin.author.update',$author->id) }}">
        @method('PUT')
        <div class="row">

            <div class="col-lg-6">
                <!-- profile details -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-user mr-3"></i>
                        <h4>{{__('Details')}}</h4>
                    </div>
                    <div class="card-body">
                        
                        @csrf
                            <div class="custom-form">
                                <div class="form-group">
                                    <div class="d-md-flex">
                                        <div class="logo-priview mb-3 mb-md-0" style="width: 20%;">
                                            <div class="logo-wrap crop-again">
                                                <img id="preview_oi" src="{{ asset('images/assets/blogs/authors/'.$author->profile_pic) }}" class="img-fluid logo_path" alt="{{ asset('images/assets/blogs/authors/'.$author->profile_pic) }}" style="display:{{(empty($author->profile_pic))?'none':'block'}};">
                                            </div>
                                            <i class="fa fa-times remove-business-logo" style="display: none;" id="removeLogo" aria-hidden="true" data-toggle="tooltip" title="Remove Logo"></i>
                                        </div>
                                        
                                        <div>
                                            <div class="form-group mb-0 pl-md-4">
                                                <label for="bl" class="text-primary mb-0 lh-1">Select Logo<small> ({{__('Optional')}})</small></label>
                                                <div class="small mb-2 lh-1">Select <span class="text-danger">PNG</span>, <span class="text-danger">JPG</span>, and <span class="text-danger">JPEG</span> image, Max file size <span class="text-danger">1MB</span>, and Max image width <span class="text-danger">512px</span>.</div>
                                                <input type="file" name="author_logo" accept="image/png, image/jpeg" id="bl" placeholder="Select your business logo"
                                                    class="form-control img-preview-oi cropperjs_input" 
                                                    data-function-name="author_logo_preview" 
                                                    data-cancel-function="cancel_author_logo_selection($(this));"
                                                    data-exts="jpeg|jpg|png"
                                                />

                                                <input type="hidden" name="imagestring" id="imagestring" value="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-form-label">{{__('Name')}} <span>*</span></label>
                                    <input type="text" name="name" id="name" class="form-control char-and-spcs-validation" value="{{$author->name}}" required placeholder="Enter User's  Name" > 
                                    @error('name')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-form-label">{{__('Email ID')}} </label>
                                    <input type="email" name="email" id="email" class="form-control check-email-input" value="{{$author->email}}"> 
                                    @error('email')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="joined_date" class="col-form-label">{{__('Designation')}}</label>
                                    <input type="text" name="designation" id="designation" class="form-control char-and-spcs-validation" value="{{$author->designation}}"> 
                                </div>

                            </div>
                    </div>
                </div>
            </div>
            <!-- profile details End -->
            
            <div class="col-lg-6">
                <!-- Password change -->
                <div class="card">
                    
                    <div class="card-body">
                        
                            <div class="custom-form">
                                <div class="form-group">
                                    <label for="joined_date" class="col-form-label">{{__('Bio')}}</label>
                                    <textarea name="bio" id="bio" maxlength = "500" class="form-control" style="height: 116px;">{{$author->bio}}</textarea>                                    
                                </div>
                                <div class="form-group">
                                    <label for="facebook" class="col-form-label">{{ __('Facebook Profile') }}</label>
                                    <div class="input-group">
                                        <input type="text" name="facebook" id="facebook" class="form-control" placeholder="Enter Facebook Profile" value="{{$author->facebook_profile}}" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="instagram" class="col-form-label">{{ __('Instagram Profile') }}</label>
                                    <div class="input-group">
                                        <input type="text" name="instagram" id="instagram" class="form-control" placeholder="Enter Instagram Profile" value="{{$author->instagram_profile}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="linkedin" class="col-form-label">{{ __('Linkedin Profile') }}</label>
                                    <div class="input-group">
                                        <input type="text" name="linkedin" id="linkedin" class="form-control" placeholder="Enter Linkedin Profile" value="{{$author->linkedin_profile}}">
                                    </div>
                                </div>
                                <!-- <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-info px-4 basicbtn" name="Change">{{ __('Save') }}</button>
                                </div> -->
                            </div>
                        
                    </div>
                </div>
                <!-- password End -->
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- profile details -->
                <div class="card">
                    <div class="card-header">
                        <div class="custom-form">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-info px-4 basicbtn" name="Change">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
        </form>
    </div>
</section>

{{-- Include Cropper-Js component --}}
@include('admin.author.cropperjs')

@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset('vendors/js/cropper.js') }}"></script>
@endsection

@section('page-script')
    


@endsection