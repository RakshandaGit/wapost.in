<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter</title>
</head>
<body>
    <table class="OL_MAILER" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#f3f6ff">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
        <tr>
            <td style="padding: 20px;font-family: 'Poppins', sans-serif;">
                <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#ffffff" style="max-width:650px; margin: auto;text-align: center;">
                    <tr>
                        <td style="padding: 20px" align="center">
                            <a href="{{url('/')}}"><img src="{{url('/').'/website/img/logo/logo-horizontal-black.png'}}" style="width: 100%;max-width: 150px;" alt="WaPost"></a>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="text-align: center;padding: 30px 0;">
                            <a href="{{url('/')}}"><img src="{{ asset('emails/images/thank-you.png') }}" style="width: 100%;max-width: 380px;" alt=""></a>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 15px;">
                            <p><strong>Thanks for subscribing to our newsletter. &#128522;</strong></p>
                            <p style="margin: 0px;font-size: 14px;">Now you will get all the important updates and notifications related to wapost.net directly. Don't worry, we won't bombard your feed!</p>
                        </td>
                    </tr>
                    <!-- <tr>
                        <td style="padding: 15px 15px 30px 15px;">
                            <a href="{{url('blogs')}}" style="display:inline-block;padding:8px 18px;background:#00249c;color:#fff;text-decoration:none;border-radius: 40px;">Checkout our latest posts!</a>
                        </td>
                    </tr> -->

                    @include('emails.email-footer')
                </table>
            </td>
        </tr>
    </table>
    
</body>
</html>