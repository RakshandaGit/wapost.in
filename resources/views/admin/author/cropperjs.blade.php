<div class="modal ol-modal popin" id="cropperjsModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-primary">Crop Image</h6>
                <button type="button" class="close" id="cj_cancel">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        {{-- Croper Canvas --}}
                        <div class="canvas_cj">
                            <img id="canvas_img_cj" class="w-100" src=""/>
                        </div>
                        <input type="hidden" name="last_image" id="last_image" value="" />
                    </div>
                    <div class="col-md-5">
                        <div class="d-flex flex-column justify-content-between w-100 h-100">
                            <div class="action_btns order-2 order-md-1">
                                
                                <div class="mb-2 d-none d-md-block">
                                    <div class="preview-cj" id="cj_preview"></div>
                                </div>

                                {{-- Zoom --}}
                                <div class="mb-2">
                                    <p class="mb-0 small text-muted">Zoom In / Out:</p>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-info cj-zoom" data-method="zoom" data-option="0.1">
                                            <span data-toggle="tooltip" title="Zoom In"> <span class="fa fa-search-plus"></span> </span>
                                        </button>
                                        <button type="button" class="btn btn-outline-info cj-zoom" data-method="zoom" data-option="-0.1">
                                            <span data-toggle="tooltip" title="Zoom Out"> <span class="fa fa-search-minus"></span> </span>
                                        </button>
                                    </div>
                                </div>
    
                                {{-- Ratio --}}
                                <div class="mb-2">
                                    <p class="mb-0 small text-muted">Crop by ratio:</p>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-outline-info mb-0 cj-ratio" data-input="ar16x9">
                                            <input type="radio" class="sr-only" id="ar16x9" name="cj_crop_ratio" value="1.7777777777777777">
                                            <span>16:9</span>
                                        </label>
                                        <label class="btn btn-outline-info mb-0 cj-ratio" data-input="ar4x3">
                                            <input type="radio" class="sr-only" id="ar4x3" name="cj_crop_ratio" value="1.3333333333333333">
                                            <span>4:3</span>
                                        </label>
                                        <label class="btn btn-outline-info mb-0 cj-ratio" data-input="ar1x1">
                                            <input type="radio" class="sr-only" id="ar1x1" name="cj_crop_ratio" value="1">
                                            <span>1:1</span>
                                        </label>
                                        <label class="btn btn-outline-info mb-0 cj-ratio" data-input="ar2x3">
                                            <input type="radio" class="sr-only" id="ar2x3" name="cj_crop_ratio" value="0.6666666666666666">
                                            <span>2:3</span>
                                        </label>
                                        <label class="btn btn-outline-info mb-0 cj-ratio active" data-input="arFree">
                                            <input type="radio" class="sr-only" id="arFree" name="cj_crop_ratio" value="NaN">
                                            <span>Free</span>
                                        </label>
                                    </div>
                                </div>
                                
                                {{-- Rotate and Flip --}}
                                <div class="mb-3">
                                    <p class="mb-0 small text-muted">Rotate and Flips:</p>
                                    <div class="btn-group mr-1">
                                        <button type="button" class="btn btn-outline-info cj-ratate" data-method="rotate" data-option="-45">
                                            <span data-toggle="tooltip" title="Rotate Left"><span class="fa fa-undo-alt"></span></span>
                                        </button>
                                        <button type="button" class="btn btn-outline-info cj-ratate" data-method="rotate" data-option="45">
                                            <span data-toggle="tooltip" title="Rotate Right"><span class="fa fa-redo-alt"></span></span>
                                        </button>
                                    </div>
                        
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-info cj-flip" data-method="scaleX" data-option="-1">
                                            <span data-toggle="tooltip" title="Flip Horizontal"><span class="fa fa-arrows-alt-h"></span></span>
                                        </button>
                                        <button type="button" class="btn btn-outline-info cj-flip" data-method="scaleY" data-option="-1">
                                            <span data-toggle="tooltip" title="Flip Vertical"><span class="fa fa-arrows-alt-v"></span></span>
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <button class="btn btn-outline-danger px-3 btn-sm" data-toggle="tooltip" title="Reset Edit" id="cj_reset">Reset</button>
                                </div>
                            </div>{{-- Action btn end --}}

                            <div class="w-100 d-flex justify-content-between my-3 mt-md-4 order-1 order-md-2">
                                {{-- <button class="btn btn-outline-danger px-3" id="cj_cancel" type="button">Cancel</button> --}}
                                {{-- <button class="btn btn-outline-primary mr-sm-2 px-sm-3" id="cj_select_full" type="button">Select Full Image</button> --}}
                                <button class="btn btn-success px-sm-3" id="cj_crop_select" type="button">Crop & Select</button>
                            </div>
                        </div>
                    </div> {{-- Col end --}}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 
How to use?

1) Input Example:
    <input type="file" name="input_name"
        class="cropperjs_input"
        data-exts="jpeg|jpg|png"
        data-function-name="logo_preview" 
        data-cancel-function="click_canceled($(this));"
    />
2) Include cropper file:
    @include('components.cropperjs')

3) Create function with same name of [data-function-name] in input attribute:
    Example:
    function logo_preview(immage){
        /* code here,
        this function exicute after click [crop & select] */
    }

4) Create function with same name of [data-cancel-function] in input attribute:
    Example:
    function click_canceled(element){
        element is selected input
        /* code here,
        this function exicute when user clicl on cancel btn from select file of cropper js popup */
    }
--}}

@section('page-script')
<script>
$(document).ready(function() {

    var $cropperJS, extention, function_after_crop, img_selector;
    var $cjInput = $("input.cropperjs_input");
    var $cjModal = $('#cropperjsModal');
    var canvas_img = document.getElementById('canvas_img_cj');

    $cjModal.on('shown.bs.modal', function () {
        $cropperJS = new Cropper(canvas_img, {
            aspectRatio: NaN,
            preview: '#cj_preview',
            dragMode: 'move',
            autoCropArea: 0.90,
            cropBoxMovable: true,
            toggleDragModeOnDblclick: false,
        });
    }).on('hidden.bs.modal', function () {
       $cropperJS.destroy();
    //    $cropperJS = null;
    });

    $("input.cropperjs_input").on('click', function(event){
        $cjInput = $(this);
        $cjInput.val('');
        var cancel_func = $cjInput.data('cancel-function');
        /* When click cancel on image selection, then fire below code */
        document.body.onfocus = (event) => {
            var selected_length = $cjInput.get(0).files.length;
            if (selected_length < 1) {
                if(cancel_func != undefined && cancel_func != ''){
                    eval(cancel_func);
                }
            }
            document.body.onfocus = null;
        };
    });

    /* On change image input */
    $("input.cropperjs_input").on('change', function(e) {

        canvas_img.src="";

        var last_image = $(this).attr('name');
        img_selector = $(this).data('id');
        $('#last_image').val(last_image);

        $cjInput = $(this);

        var file = $(this).get(0).files[0];
        var fname = file.name;
        extention = fname.split('.').pop();
        extention = extention.toLowerCase();

        var validate = validate_image_file(file, extention);
        if (validate) {

            function_after_crop = $(this).data('function-name');

            var done = function (img_url) {
                canvas_img.src = img_url;
                $cjModal.modal('show');
            }
            var reader, file, url;
            if(file){
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function (e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        }else{
            $cjInput.val('');
        }
    });


    /* Cancel */
    $('#cj_cancel').click(function(event) {
        event.preventDefault();

       var check = $cjInput.val('');
       console.log(check, "check ok done");
        var cancel_func = $cjInput.data('cancel-function');
        console.log(cancel_func, "ok done");
        if(cancel_func != undefined && cancel_func != ''){
            eval(cancel_func);
        }

        $cjModal.modal('hide');
    });

    /* Change AspectRatio */
    $(".cj-ratio").click(function(event){
        event.preventDefault();

        var input_selector = $(this).data('input');
        var ratio = $('#' + input_selector).val();

        $cropperJS.setAspectRatio(Number(ratio));
    });

    /* Rotate */
    $(".cj-ratate").click(function(event){
        event.preventDefault();

        var option = $(this).data('option');
        $cropperJS.rotate(option);
    });

    /* flip */
    $(".cj-flip").click(function(event){
        event.preventDefault();

        var method = $(this).data('method');
        var option = $(this).data('option');

        eval('cj_' + method + '(' + option + ')');

        if(option == 1){
            $(this).data('option', -1);
        }else{
            $(this).data('option', 1);
        }
    });

    /* Zoom */
    $(".cj-zoom").click(function(event){
        event.preventDefault();

        var method = $(this).data('method');
        var option = $(this).data('option');
        eval('cj_' + method + '(' + option + ')');
    });

    /* Reset */
    $('#cj_reset').click(function(event){
        event.preventDefault();
        $cropperJS.reset();
    });

    /* select full image */
    $('#cj_select_full').click(function(event){
        event.preventDefault();
    });

    /* Crop & Select */
    $('#cj_crop_select').click(function(event) {
        event.preventDefault();

        var canvas_width = 991; /* Default canvas width set */
        if(img_selector){
            /* if ID is exist in img_selector */
            let main_width = 991;
            let main_width_indevice = $("#template-full-container").width();
            let image_width_indevice = $("#" + img_selector).width();
            let image_width_acurate = '';

            /* calculate width of element where image will place */
            var percent = image_width_indevice / main_width_indevice * 100;
            image_width_acurate = main_width / 100 * percent;
            
            canvas_width = parseInt(image_width_acurate) + 100; /* set calculated value in canvas width */
        }
        
        canvas = $cropperJS.getCroppedCanvas({
            width: canvas_width,
            /* height: 500, */
        });
        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob); 
            reader.onloadend = function() { 
                if(extention == ''){
                    extention = 'jpg';
                }
                var croped_image = canvas.toDataURL('image/' + extention, 1.0);

                /* Exicute function (name define in input attr: data-function-name="[FUN]") */
                if (function_after_crop != undefined && function_after_crop != '') {
                    eval(function_after_crop + '("' + croped_image + '")');
                }

                // canvas_img.src = '';

                $cjModal.modal('hide');
            }
        });

    });

    /* functions */
    function validate_image_file(file, extention) {
        var $return = false;

        /* Check extention */
        var ext_given = $cjInput.data('exts');
        if(ext_given != undefined){
            var extArray = ext_given.split('|');
            if($.inArray(extention, extArray) != -1){
                $return = true;
            }else{
                Sweet('error', 'Image format is not supported. Please Upload ' + extArray.join(', ') + ' image.');
            }
        }else{
            $return = true;
        }

        /* check file size */
        /*if(file.size > 1048576){ 
            $return = false;
            Sweet('error', 'Image size must be smaller than or equals to 1MB.');
        }*/
        if(file.size > 2097152){ 
            $return = false;
            Sweet('error', 'Image size must be smaller than or equals to 2MB.');
        }
        return $return;
    }
    function cj_scaleX(value) {
        $cropperJS.scaleX(value);
    }
    function cj_scaleY(value) {
        $cropperJS.scaleY(value);
    }
    function cj_zoom(value) {
        $cropperJS.zoom(value);
    }
});
</script>
{{-- Show and create page script --}}
<script>
    /* when clicked cancel to image select or popup */
    function cancel_author_logo_selection(input) {
        var img_pre = $('#preview_oi');
        var image = img_pre.attr('alt');
        img_pre.attr('src', image);
    }
    /* when select and crop clicked from cropperjs popup */
    function author_logo_preview(image) {
        // $('.remove-business-logo').show();
        $("#preview_oi").attr("src", image);
        $("#preview_oi").css("display", "block");
        $("#imagestring").val(image);
    }

    $(document).ready(function() {

        $("#removeLogo").click(function() {
            swal.fire({
                    title: 'Are you sure?',
                    text: 'Once deleted, you will not be able to recover this logo file!',
                    type: 'question',
                    icon: 'warning',
                    animation: true,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes Delete',
                    cancelButtonText: 'Cancel',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: true,
                    focusConfirm: true
                })
                .then(function(data) {
                    /*console.log(data.value);*/
                    if (data.value == true) {
                        $("#overlay").fadeIn(300);

                        $.ajax({
                            type: 'POST',
                            url: "{{-- route('business.deleteAuthorLogo') --}}",
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            dataType: 'JSON',
                            success: function(res) {

                                $("#overlay").fadeOut(300);

                                if (res.status == true) {
                                    Swal.fire(
                                        'Deleted!',
                                        res.message,
                                        'success'
                                    )

                                    //$('.logo-wrap').empty();
                                    $("input.img-preview-oi").val('');
                                    $('.remove-business-logo').hide();
                                    $("#preview_oi").removeAttr("src");
                                    $("#cropImage").removeAttr("src");
                                    $("#preview_oi").attr("alt", '');
                                    $("#preview_oi").css("display", 'none');
                                    $("#imagestring").val("");
                                    $('.sidebar-logo-round').remove();

                                } else {
                                    Swal.fire(
                                        'Deleted!',
                                        res.message,
                                        'success'
                                    )
                                    $("#preview_oi").css("display", 'none');
                                    $('.sidebar-logo-round').remove();
                                }
                            }
                        });

                    } else {
                        Sweet('success', 'Your logo file is safe!');
                    }
                });
        });
    });
</script>

<script>
    @if (session()->has('success'))
        showSweet('{{ session()->get('success') }}');
    @endif
    function showSweet(msg) {
        Sweet('success', msg);
    }
</script>
@endsection