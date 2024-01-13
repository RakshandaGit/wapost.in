<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Roboto:wght@700&display=swap');
            .admin-contact-email {
                background:rgb(243,243,243);
                padding: 40px;
                max-width:650px;
                margin:30px auto;
            }

            .admin-contact-email .text-warpper {
                background:white;
                padding: 40px;
                max-width:600px;
                margin:10px auto;
            }
            .contact-font {
                font-style: italic;
                text-align: center;
                color: rgb(111,111,111);
                margin: 10px 0 20px;
                font-weight: 400;
                font-size: 20px;
            }
            .footer-box{
                text-align: center;
            }
            header, .logo{
                -webkit-transition: all 1s;
                    transition: all 1s; 
            }
            .logo-box img{
                width: 100%;
                max-width: 180px;
            }
            .footer-logo img{
                width: 100%;
                max-width: 120px;
            }
            .admin-contact-email hr{
                border: 1px dashed #887f7f;
                margin-top:40px;
            }
            .text-warpper p {
                font-family: 'Poppins', sans-serif;
                font-weight: 500;
                font-size: 15px;
            }
            .text-warpper h1 {
                font-family: 'Poppins', sans-serif;
                font-weight: 900;
                font-size: 28px;
                color: #08828c;
            }
            /* Button */
            .social-buttons {
                margin: auto;
                font-size: 0;
                text-align: center;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
            }
            .social-button {
                display: inline-block;
                background-color: #fff;
                width: 45px;
                height: 45px;
                line-height: 50px;
                margin: 0 10px;
                text-align: center;
                position: relative;
                overflow: hidden;
                opacity: .99;
                border-radius: 50%;
                box-shadow: 0 0 30px 0 rgba(0, 0, 0, 0.05);
                -webkit-transition: all 0.35s cubic-bezier(0.31, -0.105, 0.43, 1.59);
                transition: all 0.35s cubic-bezier(0.31, -0.105, 0.43, 1.59);
            }
            .social-button:before {
                content: '';
                background-color: #000;
                width: 120%;
                height: 120%;
                position: absolute;
                top: 90%;
                left: -110%;
                -webkit-transform: rotate(45deg);
                        transform: rotate(45deg);
                -webkit-transition: all 0.35s cubic-bezier(0.31, -0.105, 0.43, 1.59);
                transition: all 0.35s cubic-bezier(0.31, -0.105, 0.43, 1.59);
            }
            .social-button .fa {
                font-size: 32px;
                padding: 6px;
                vertical-align: middle;
                -webkit-transform: scale(0.8);
                        transform: scale(0.8);
                -webkit-transition: all 0.35s cubic-bezier(0.31, -0.105, 0.43, 1.59);
                transition: all 0.35s cubic-bezier(0.31, -0.105, 0.43, 1.59);
            }
                
            .social-button.facebook:before {
                background-color: #3B5998;
            }
            .social-button.facebook .fa {
                color: #3B5998;
            }
            .social-button.instagram:before {
                background-color: #cc2366;
            }
            .social-button.instagram .fa {
                color: #cc2366;
            }
            /* //Twitter */
            .social-button.twitter:before {
                background-color: #55acee;
            }
            .social-button.twitter .fa {
                color: #55acee;
            }

            .social-button:focus:before, .social-button:hover:before {
                top: -10%;
                left: -10%;
            }
            .social-button:focus .fa, .social-button:hover .fa {
                color: #fff;
            }
            .admin-contact-email .img-box img{
                width: 70%;
            }
            .btn-box a{
                display:inline-block;
                padding:.5rem 1rem;
                border: 1px solid #08828c;
                background-color: #08828c;
                color:#FFF;
                text-decoration: none;
                border-radius: 6px;
                font-weight: bold;
                margin-bottom: 10px;
            } 
            .btn-box a:hover{
                background-color:#ffffff;
                color:#08828c;
            }  
            .link-para a{
                color: #08828c; 
                text-decoration: none;
            }
            @media (max-width:556px){
                .admin-contact-email .text-warpper,.admin-contact-email{
                    padding: 20px;
                    max-width: 100%;
                }
            }
        </style>
    </head>

    <body style="background-color: rgba(100, 181, 192, 0.484)">
        <div class="WA_MAILER">
            <div class="container">
                <div class="admin-contact-email" style="background:rgb(243,243,243);padding: 40px; max-width:650px;margin:30px auto;text-align:center;">
                    <div class="logo-box text-center mb-5">
                        <a href="{{'/'}}"><img src="{{ asset('website/img/logo/logo-horizontal-black.png') }}" alt="wapost.net"></a>        
                    </div>
                
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-12 col-md-12 col-12 align-items-center text-center img-box mb-5">
                            <img src="{{ asset('website/img/emails/WelcomeEmail.png') }}" alt="contact-admin">
                        </div>
                        <div class="col-lg-12 col-md-12 col-12 align-items-center text-center">
                            <div class="text-warpper" style="background:white;padding: 40px; max-width:600px; margin:10px auto;">
                                <div class="inner-box">
                                    <p><b></b></p>
                                    <p>{!! $content !!}</p>
                                    <div class="btn-box my-3">
                                        <a href="{{$url}}" target="_blank">Login Now</a>
                                    </div>
                                </div>
                                <hr>
                                <p class="link-para"><b>If you have any questions, please feel free to drop us a line on <a href="mailto:care@wapost.net">care@wapost.net</a> </b></p>

                            </div>
                        </div>
                    </div>
        
                    <div class="footer-box mt-5" style="text-align: center;">
                        <h3 class="contact-font" style="font-style: italic; text-align: center;color: rgb(111,111,111); margin: 10px 0 20px;font-weight: 400; font-size: 20px;">Stay in touch<h3>
                       
                        <div class="social-buttons" style="margin: auto; font-size: 0; text-align: center; top: 0;bottom: 0;left: 0;right: 0;">
                            <a class="social-button facebook" href="#"  style="display: inline-block;background-color: #fff;width: 45px;height: 45px;line-height: 66px;
                            margin: 0 10px; text-align: center; position: relative; overflow: hidden;opacity: .99;border-radius: 50%;
                            box-shadow: 0 0 30px 0 rgba(0, 0, 0, 0.05); -webkit-transition: all 0.35s cubic-bezier(0.31, -0.105, 0.43, 1.59); transition: all 0.35s cubic-bezier(0.31, -0.105, 0.43, 1.59);">
                                <img src="{{asset('website/img/emails/facebook.png')}}" style="width: 23px;line-height:23px;" alt="facebook">
                            </a>
                            
                            <a class="social-button instagram" href="#"  style="display: inline-block;background-color: #fff;width: 45px;height: 45px;line-height: 66px;
                            margin: 0 10px; text-align: center; position: relative; overflow: hidden;opacity: .99;border-radius: 50%;
                            box-shadow: 0 0 30px 0 rgba(0, 0, 0, 0.05); -webkit-transition: all 0.35s cubic-bezier(0.31, -0.105, 0.43, 1.59); transition: all 0.35s cubic-bezier(0.31, -0.105, 0.43, 1.59);">
                                <img src="{{asset('website/img/emails/instagram.png')}}" style="width: 23px;line-height:23px;" alt="facebook">
                            </a>
                            <a class="social-button twitter" href="#"  style="display: inline-block;background-color: #fff;width: 45px;height: 45px;line-height: 66px;
                            margin: 0 10px; text-align: center; position: relative; overflow: hidden;opacity: .99;border-radius: 50%;
                            box-shadow: 0 0 30px 0 rgba(0, 0, 0, 0.05); -webkit-transition: all 0.35s cubic-bezier(0.31, -0.105, 0.43, 1.59); transition: all 0.35s cubic-bezier(0.31, -0.105, 0.43, 1.59);">
                                <img src="{{asset('website/img/emails/twitter.png')}}" style="width: 23px;line-height:23px;" alt="facebook">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>
</html>
{{-- @component('mail::message')
{!! $content !!}
@component('mail::button', ['url' => $url])
    {{ __('locale.auth.login') }}
@endcomponent

{{ __('locale.labels.thanks') }},<br>
{{ config('app.name') }}
@endcomponent --}}
