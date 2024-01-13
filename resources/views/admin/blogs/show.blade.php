@extends('layouts/contentLayoutMaster')

@section('title', __('Edit Blog'))

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

<style>
    #error {
        color: #ff0000;
    }

    #success {
        color: green;
    }

    #basic-vertical-layouts .btn-primary,
    .blog-create .card-body form .btn-primary {
        height: 36px;
        padding: 6px !important;
        line-height: 16px !important;
        font-size: 15px !important;
        font-weight: 400 !important;

    }

    #basic-vertical-layouts button.btn.btn-primary.waves-effect.waves-float.waves-light {
        width: 80%;
        margin: 0 auto;
    }
</style>

@section('content')
    <!-- Basic Vertical form layout section start -->
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-8 col-12">

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Edit Blog') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" action="{{ route('admin.blogs.update', $blog->id) }}"
                                method="post" enctype="multipart/form-data">
                                @method('PATCH')
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label required" for="title">{{ __('Title') }}</label>
                                            <input id="title" type="text"
                                                class="form-control @error('title') is-invalid @enderror" name="title"
                                                placeholder="{{ __('title') }}" value="{{ $blog->title }}" required
                                                autocomplete="title" />
                                            @error('title')
                                                <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label required" for="slug">{{ __('Slug') }}</label>
                                            <input id="slug" type="text"
                                                class="form-control @error('slug') is-invalid @enderror" name="slug"
                                                placeholder="{{ __('slug') }}" value="{{ $blog->slug }}" required
                                                autocomplete="slug" />
                                            @error('slug')
                                                <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="description"
                                                class="form-label required">{{ __('Content') }}</label>
                                            <textarea name="description" class="form-control editor description @error('description') is-invalid @enderror"
                                                id="description" required autocomplete="description">{{ $blog->content }}</textarea>
                                            @error('description')
                                                <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="image"
                                                class="form-label">{{ __('locale.labels.image') }}</label>
                                            <input type="file" name="blog_banner" class="form-control" id="image"
                                                accept="image/*" />
                                            @error('blog_banner')
                                                <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                            <p><small class="text-primary"> {{ __('locale.customer.profile_image_size') }}
                                                </small></p>
                                        </div>
                                    </div>

                                    @if ($blogInfo->image != null)
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <img id="preview_oi"
                                                    src="{{ URL::to('images/assets/blogs/banners/' . $blog->image) }}"
                                                    style="max-height:120px;" class="img-fluid" />
                                            </div>
                                        </div><br>
                                    @endif

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="meta_title">{{ __('Meta Title') }}</label>
                                            <input id="meta_title" type="text"
                                                class="form-control @error('meta_title') is-invalid @enderror"
                                                name="meta_title" placeholder="{{ __('Meta Title') }}"
                                                value="{{ $blog->meta_title }}" autocomplete="meta_title" />

                                            @error('meta_title')
                                                <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="meta_keyword">{{ __('Meta Keyword') }}</label>
                                            <input id="meta_keyword" type="text"
                                                class="form-control @error('meta_keyword') is-invalid @enderror"
                                                name="meta_keyword" placeholder="{{ __('Meta Keyword') }}"
                                                value="{{ $blog->meta_keyword }}" autocomplete="meta_keyword" />

                                            @error('meta_keyword')
                                                <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="meta_description"
                                                class="form-label">{{ __('Meta Description') }}</label>
                                            <textarea class="form-control" id="meta_description" rows="3" name="meta_description"> {{ $blog->meta_description }} </textarea>

                                            @error('meta_description')
                                                <p><small class="text-danger"> {{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4 col-12">

                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mt-1">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1"><i data-feather="save"
                                            class="align-middle me-sm-25 me-0"></i>
                                        {{ __('locale.buttons.save') }}</button>
                                </div>

                                <div class="col-12">
                                    <div class="mb-1">
                                        <label for="status" class="form-label">{{ __('locale.labels.status') }}</label>
                                        <select class="form-select" name="status" id="status">
                                            <option value="1" @if ($blog->status == 1) selected @endif>
                                                {{ __('Published') }}</option>
                                            <option value="0" @if ($blog->status == 0) selected @endif>
                                                {{ __('Draft') }} </option>
                                        </select>
                                        @error('status')
                                            <p><small class="text-danger">{{ $message }}</small></p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-1">
                                        <label for="status" class="form-label">{{ __('Is Featured') }}</label>
                                        <select class="form-select" name="featured" id="featured">
                                            <option value="1" @if ($blog->featured == 1) selected @endif>
                                                {{ __('Yes') }}</option>
                                            <option value="0" @if ($blog->featured == 0) selected @endif>
                                                {{ __('No') }} </option>
                                        </select>
                                        @error('featured')
                                            <p><small class="text-danger">{{ $message }}</small></p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-1">
                                        <label for="author" class="form-label">{{ __('Authors') }}</label>
                                        <select class="form-select" id="inlineFormCustomSelect" name="author">
                                            <option value="">Select Author</option>
                                            @foreach ($authors as $author)
                                                <option value="{{ $author->id }}"
                                                    {{ !empty($blogInfo->author_id) && $blogInfo->author_id == $author->id ? 'selected' : '' }}>
                                                    {{ $author->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('author')
                                        <p><small class="text-danger">{{ $message }}</small></p>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <div class="mb-1">
                                        <label for="author" class="form-label">{{ __('Publish Date') }}</label>
                                        <input type="date" id="updated_at" name="updated_at" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($blog->updated_at)->format('Y-m-d') }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="tag">{{ __('Add Tags') }}</label>
                                        <input id="tag" type="text"
                                            class="form-control @error('tag') is-invalid @enderror" name="tag"
                                            placeholder="{{ __('Add tags') }}" autocomplete="tag" />

                                        @error('tag')
                                            <p><small class="text-danger">{{ $message }}</small></p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-1">
                                        <input type="button" name="tag" value="Save tag" class="btn-primary"
                                            onclick="add_tags()">
                                        <span id="error"></span>
                                        <span id="success"></span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-1">
                                        <label for="tag" class="form-label">{{ __('Select Tags') }}</label>
                                        <select multiple class="select2 w-100" id="tag_listing" name="tags[]">
                                            @foreach ($all_tags as $result)
                                                <option value="{{ $result->id }}"
                                                    @foreach ($selectTags as $tag_id) @if ($result->id == $tag_id)selected="selected"@endif @endforeach>
                                                    {{ $result->tag }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('tags')
                                        <p><small class="text-danger">{{ $message }}</small></p>
                                    @enderror
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            </form>

        </div>
    </section>
    <!-- // Basic Vertical form layout section end -->


@endsection


@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset('vendors/js/ckeditor/ckeditor.js') }}"></script>
@endsection


@section('page-script')

    <script>
        if ($('textarea[name="description"]').length > 0) {
            CKEDITOR.replace('description');
        }

        let firstInvalid = $('form').find('.is-invalid').eq(0);
        let showHideInput = $('.show_hide_password input');
        let showHideIcon = $('.show_hide_password i');

        if (firstInvalid.length) {
            $('body, html').stop(true, true).animate({
                'scrollTop': firstInvalid.offset().top - 200 + 'px'
            }, 200);
        }

        // Basic Select2 select
        $(".select2").each(function() {
            let $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
                // the following code is used to disable x-scrollbar when click in select input and
                // take 100% width in responsive also
                dropdownAutoWidth: true,
                width: '100%',
                dropdownParent: $this.parent()
            });
        });
    </script>

    <script type="text/javascript">
        function add_tags() {
            var tag = $('#tag').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            if (tag != '') {
                $.ajax({
                    url: '{{ route('admin.blogs.add_tags') }}',
                    type: 'POST',
                    data: {
                        tag: tag,
                        _token: CSRF_TOKEN
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.type == "success") {
                            $('#success').html(response.message);
                            $('#error').html('');
                            $('#tag').val('');

                            if (response) {
                                $.each(response, function(key, value) {
                                    if (value.tag != null && value.id != null) {
                                        $('#tag_listing').append($("<option/>", {
                                            value: value.id,
                                            text: value.tag
                                        }));
                                    }
                                });
                            }
                        }
                    }
                });
            } else {
                $('#error').html('Tag should not be empty!');
                $('#success').html('');
            }
        }
    </script>

@endsection
