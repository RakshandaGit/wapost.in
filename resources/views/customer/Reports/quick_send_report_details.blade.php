@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu.Quick Send Details'))

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
@endsection

@section('page-style')

    <style>
        table.data-active td {
            display: block;
            font-size: 1.2rem;
            font-family: inherit;
            font-weight: 500;
            color: #08828c;
            padding: 10px 15px 10px 15px;
            line-height: 1.3;
        }

        table.data-active td span {
            color: #4b4b4b;
            font-weight: 400;
            padding: 10px;
        }

        .whatsapp-preview {
            background-image: url(../../../website/img/shapes/whatsup-preview-img.png);
            border-radius: 10px;
        }

        #preview_allfile p {
            word-wrap: break-word;
            word-break: break-word;
        }

        div#preview_allfile .preview-collect img.file-extensionimg {
            width: 80px;
        }
    </style>

@endsection

@section('content')
    {{-- {{ return redirect()->back()->with('tab', 'Quick Send Reports') }} --}}
    <div class="col-md-2 col-12 text-end">
        <a href="#!" class="back-dashbordbtn" onclick="window.history.go(-1); return false;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-skip-back">
                <polygon points="19 20 9 12 19 4 19 20"></polygon>
                <line x1="5" y1="19" x2="5" y2="5"></line>
            </svg>
            Back
        </a>
    </div>
    <!-- Basic Vertical form layout section start -->
    <section>
        <div class="section quicksendDetails">

            <div class="row">
                <div class="col-12 col-sm-12 col-md-8">
                    <div class="card">
                        <div class="card-body">
                            {{-- <h2 class="text-primary mt-1 mb-3">Campaign Name : <span>Campaign One</span></h2> --}}
                            <table class="data-active my-3">
                                <tr>
                                    <td>Sender ID : <span>{{ $report->from }}</span></td>
                                    <td>Receiver ID : <span>{{ $report->to }}</span></td>
                                    <td>Date : <span>{{ date('Y-m-d', strtotime($report->created_at)) }}</span></td>
                                    <td>Time : <span>{{ date('h:i A', strtotime($report->created_at)) }}</span></td>
                                </tr>
                                <tr>
                                    <td>Status : <span>{{ $report->status }}</span></td>
                                    <td>Media Type : <span>{{ $report->sub_type }}</span></td>
                                    {{-- <td>Message : <span>{{$report->message}}</span></td> --}}
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 whatsapp-preview">
                    <div class="preview-box">
                        <h3 class="fw-bolder my-2">Message</h3>
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">

                                    @if ($report->sub_type == 'text')
                                        <p id="messaage-quick">
                                            {!! nl2br(json_decode($report->requested_message)->message) ?? null !!}</p>
                                    @elseif(
                                        $report->sub_type == 'image' ||
                                            $report->sub_type == 'video' ||
                                            $report->sub_type == 'audio' ||
                                            $report->sub_type == 'doc')
                                        @if ($report->sub_type == 'image')
                                            <div class="spacifed-img">
                                                <img src="{{ json_decode($report->requested_message)->filePath ?? null }}"
                                                    alt="" width="100px" id="spacified-img">
                                            </div>
                                            
                                            <p class="img-cap" id="quick-img-cap">
                                                {!! nl2br(json_decode($report->requested_message)->message) ?? null !!}</p>
                                        @endif
                                        @if ($report->sub_type == 'video')
                                            <div id="divVideo">
                                                <video width="320" height="240" controls>
                                                    <source
                                                        src="{{ json_decode($report->requested_message)->filePath ?? null }}"
                                                        type="video/mp4">
                                                    <source
                                                        src="{{ json_decode($report->requested_message)->filePath ?? null }}"
                                                        type="video/ogg">
                                                </video>
                                                <p class="img-cap" id="quick-video-cap">
                                                    {!! nl2br(json_decode($report->requested_message)->message) ?? null !!}</p>
                                            </div>
                                        @endif
                                        @if ($report->sub_type == 'audio')
                                            <div id="divaudio" runat="server">
                                                <audio controls>
                                                    <source
                                                        src="{{ json_decode($report->requested_message)->filePath ?? null }}"
                                                        type="audio/ogg">
                                                    <source
                                                        src="{{ json_decode($report->requested_message)->filePath ?? null }}"
                                                        type="audio/mpeg">
                                                </audio>
                                            </div>
                                        @endif
                                        @if ($report->sub_type == 'doc')
                                            @php
                                                $extension = substr(json_decode($report->requested_message)->filePath ?? null, strrpos(json_decode($report->requested_message)->filePath ?? null, '.') + 1);
                                                // dd($extension);
                                                $allowed = ['audio/mpeg', 'audio/x-mpeg', 'audio/mpeg3', 'audio/x-mpeg-3', 'audio/aiff', 'audio/mid', 'audio/x-aiff', 'audio/x-mpequrl', 'audio/midi', 'audio/x-mid', 'audio/x-midi', 'audio/wav', 'audio/x-wav', 'audio/xm', 'audio/x-aac', 'audio/basic', 'audio/flac', 'audio/mp4', 'audio/x-matroska', 'audio/ogg', 'audio/s3m', 'audio/x-ms-wax', 'audio/xm'];
                                                $videoJS = ['video/mp4', 'video/ogg', 'video/webm'];
                                            @endphp

                                            <div id="preview_allfile">
                                                <div class="preview-collect">
                                                    @if ($extension == 'png')
                                                        <img src="{{ asset('website/img/fileicons/png-file.png') }}"
                                                            class="file-extensionimg" />
                                                    @elseif($extension == $allowed)
                                                        <img src="{{ asset('website/img/fileicons/music-file.png') }}"
                                                            class="file-extensionimg" />
                                                    @elseif($extension == $videoJS)
                                                        <img src="{{ asset('website/img/fileicons/png-file.png') }}"
                                                            class="file-extensionimg" />
                                                    @elseif($extension == 'pdf')
                                                        <img src="{{ asset('website/img/fileicons/pdf-file.png') }}"
                                                            class="file-extensionimg" />
                                                    @else
                                                        <img src="{{ asset('website/img/fileicons/Doc-file.png') }}"
                                                            class="file-extensionimg" />
                                                    @endif

                                                    <a href="{{ json_decode($report->requested_message)->filePath ?? null }}"
                                                        target="_blank" download><img
                                                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAABqklEQVR4nO1XwUrDQBB9EVNooak2oDnYH2gOerBij7LRmxU9WEvy/98hA29hCHUzWVZQ6IOF0LydedmZnZkCJ/wzFABqAA2AHYAvLnl2fCec5CjptDMu4S5TOD4DsFGGPwE8Arjhl55zyfMKwJYcz5e9WazzCYBnGpJjvgWQG/YJ5w7AQZ2G2Br95Q0NfDAEY3EJ4J02XmjTjI1yPkU8prQhtu6tm0p17EOJ5GMdwpLhaK2J2dCoxBwJBIA50fGqBlGobM8TCsjV7ZiHiDVJctWQUAB4RYW7DpEcSatfELCyhOHNckyRAnx4pWz/iD1Jx+J/DaAyCKjI7SMndx8jYKEaTxUQUCneIkbAjqRjHe1B1YfqiIArvuuYcFlMCFwgCTOVyV6EF1ANODcnYa2MwCDCCxhybr6GhaEQaRF6hZybC5EuxVI+YRQRcj6qFIMNo2MDWRpEDDkvVTOSFj26Hc8GRIScz2LaMWg05UDiYkaziRJxYBxjRjIXM5J5ZDy6Vt2OLe/00FDacm/0UKpxAeBpxFjuUo3lfcxZSFzvj8krf1uP6KQn/A18A0v3SQzv01iCAAAAAElFTkSuQmCC"></a>
                                                </div>
                                            </div>
                                            <p class="file-caption mt-1" id="quick-file-cap">
                                                {!! nl2br(json_decode($report->requested_message)->message) ?? null !!}</p>

                                        @endif
                                    @else
                                        <div class="contact-dataview">
                                            <p id="fullname_pre">
                                                <span id="full_name">
                                                    <img
                                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAACXBIWXMAAAsTAAALEwEAmpwYAAAFRklEQVR4nO1ay28bRRjfE3AojzuIZwV/BVA4cIATiDOIcgOJChAQROHe/wHCBQSVirgViTZJlcT22t6H1961E8dex03smfVMZpK2icqjHTSbOHWqZF8zu5uifNInrfyYb36/+R4z36yinMiJnEia0uv1HqEInCEITBEEpykCRYKgSxAkBIG/d5U/Q3fvu2n/t6Phq6zdflh5EAVj/BjF4CxB4ArFcIdiyBLqDkHgT4rBB3xM5bjLFlp/yV9lMdABZMAfuA3luMkmhM8TBC8SBO6kAPyA7tn4hVLwXN64FR6jBMPzKa14uEdg+E1ueYJS8CxBUM0B+EGPwMDY9LzT2YLHw3cpBjfyBr+vCGxR7L2TCXiCwMdZxHpsT0DgLt2An6ULHsPv8gYaHhLwfDrg0fAj0cmNwBpz201WN8tMLy+wUmHOV/7MP3NXmgyBNRkknJMe80TA7RFcY62GwUqLs6y4MBOis8y2qmw0TE7E3lzflgJ+0/NO7yaZZJO53msztTAXAfhB5f9ZW10R8ARwU3jTxPw6D4ykk+i2HX9F44Kf9IZuuykSCjpj9kOJCSAYfiuy8mLg75Eg4gkEg6+TgSfDZyiGtxLFPFhP5PZB4cDzSEISdhJtmwmCF5Oy3mzo0sCPtWkbIvng5wSnOnAnaamLlu3jKR+Te1aiMEDg363R6MU4qz+dlG2etGSDHyvfJyTOBQh+H6OZAbeTGrLMSmoE1I2yQBjAbYTQo6EEUAw+FDDCNHUhNQL4jlFkbgQP34/g/uCKiBGZ2f+waiAyN4rAH6EbHyrY3EgjAU4mQiECMNwObKBQBF4TNMAqpfnUCKio86IEMDIavBzk/lOiBo5xEhyHwZcBBMAfRQ10lp3UCOi0bXEPCCqHFIGiqIE0N0J8bAkesBBAAOwLG8CQ2ZYmnQCnrouD3/UANygENmQY4QcXtXhNGni1cC3xNvgQAlAQAX/JMHLvOCyHgL7bljInnwAMb2dCAN1viIiB5z1EmXMKI2BDpjGufXc5cUtM5spHCgGK4Ko8Q4Ct9zt+gzNJVeD/sYyyTwIfSyIBbqplkCDA3E5T6o6Qj+V2WnKICCqDRHAjxFdcKy9KL4GTp8H1fje9jdAmAl8lXfX2UkNSEzRclxyTbST1BgS+CAqBM3EHxHDATK2YCfBJ5TaxN5B7GGIxj8MIrjO9Wsgc/Fi1ymLcq7Tg4zCX3XdyIoD3Bql2fyKToC74XhjN/eFlJUwoBmejxHxNV3MHvx8OuhopJxDsvSelKdpqGLmDvl9b4fcGtzzPOxVKQFhbfHDdzR3sURpUIiO3xcc3wvwy4TDXT7POiyqf22GhEPtihAtB8NcsLz3SvTwBPylxhZDB05OXo3z1q2p6DU+ZjdP7tszb/I222ARw2XsH0B+o7y7lDi6q8hPoxMJNKYIvQup8IP4OT97AomrdrOyVPagJvSDBZdPzXkDeYCvNCw/Zqi7OMjwa3Iyd+I6S7krr86wOOnLUf7XmU0Wm2Gb1Uv7Aoqldq/yupCENszKTN7gwbdSqV5U0xTbLvx3blbeql5QspGUbF9TF2bt5Ax4rn0uzblxQshTbrr2uqfPbeYPXyvM77WbjDSUP8by5U3WzMpNHieQ267XqVT4HJW9xHP2VmqauZlMqZ1lNK606jnZ0aysvadbNtyxdXU7rdrhuqMtO3XhTOe5iWdZTjqVNm1oBiZDB/2tWisixjGnTNJ9UHkTpdrXHHcf4pFGrXrYMdUUvF25USvP/lApz+1WEP/PP+Hempnb4b52Gca7Xm3si7/mfyIko/2/5D2dXONgNbiCWAAAAAElFTkSuQmCC">
                                                    {{ json_decode($report->requested_message)->fullname ?? null }}

                                                </span>
                                            </p>
                                            <p><b>Display Name : </b><span
                                                    id="displayname-demo">{{ json_decode($report->requested_message)->displayname ?? null }}
                                                </span></p>
                                            <p><b>Organization : </b><span
                                                    id="displayname-demo">{{ json_decode($report->requested_message)->organization ?? null }}
                                                </span></p>
                                            <p><b>Phone Number : </b><span
                                                    id="displayname-demo">{{ json_decode($report->requested_message)->phonenumber ?? null }}
                                                </span></p>
                                        </div>

                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- // Basic Vertical form layout section end -->

@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection

@section('page-script')
    <script>
        function wrap(str) {
            if (str) {
                return str
                    .replace(/(?:\*)([^*]*)(?:\*)/gm, "<strong>$1</strong>").replace(/(?:_)([^_]*)(?:_)/gm, "<i>$1</i>")
                    .replace(/(?:~)([^~]*)(?:~)/gm, "<strike>$1</strike>").replace(/(?:```)([^```]*)(?:```)/gm,
                        "<tt>$1</tt>");
            } else {
                return str;
            }
        }
        let str = "{{ json_decode($report->requested_message)->message ?? null }}";

        var htmlStr = wrap(str);
        //  console.log(htmlStr);
        $("#messaage-quick").html(htmlStr);
        $("#quick-img-cap").html(htmlStr);
        $("#quick-video-cap").html(htmlStr);
        $("#quick-file-cap").html(htmlStr);
    </script>
@endsection
