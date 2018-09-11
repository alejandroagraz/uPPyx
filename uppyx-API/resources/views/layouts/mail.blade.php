<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Email Resposive Template</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            min-width: 100% !important;
        }

        img {
            height: auto;
        }

        .content {
            width: 100%;
            max-width: 600px;
        }

        .header {
            padding: 40px 30px 20px 30px;
        }

        .bodycopy {
            font-size: 16px;
            line-height: 22px;
        }

        .button a {
            color: #ffffff;
            text-decoration: none;
        }

        .footercopy a {
            color: #ffffff;
            text-decoration: underline;
        }

        @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
            body[yahoo] .hide {
                display: none !important;
            }

            body[yahoo] .buttonwrapper {
                background-color: transparent !important;
            }

            body[yahoo] .button {
                padding: 0px !important;
            }

            body[yahoo] .button a {
                background-color: #e05443;
                padding: 15px 15px 13px !important;
            }

            body[yahoo] .unsubscribe {
                display: block;
                margin-top: 20px;
                padding: 10px 50px;
                background: #2f3942;
                border-radius: 5px;
                text-decoration: none !important;
                font-weight: bold;
            }
        }
    </style>
</head>
<body yahoo="" bgcolor="#00102D" style="margin: 0;padding: 0;min-width: 100% !important;">
<table width="100%" bgcolor="#00102D" border="0" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td style="height: auto;">
            <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
            <![endif]-->
            <table bgcolor="#f2f2f2" class="content" align="center" cellpadding="0" cellspacing="0" border="0"
                   style="margin: auto;width: 100%;max-width: 600px;">
                <tbody>
                <tr>
                    <td bgcolor="#00102D" class="header" style="padding: 40px 30px 20px 30px;">
                        <!--[if (gte mso 9)|(IE)]>
                        <table width="425" align="left" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                        <![endif]-->
                        <table class="col425" align="left" border="0" cellpadding="0" cellspacing="0"
                               style="width: 100%;">
                            <tbody>
                            <tr>
                                <td height="70">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                        <tr>
                                            <td style="padding: 5px 0 0 0; text-align: center !important;">
                                                <img src="{{ env('APP_URL').'/images/logo_mail.png' }}" alt="uPPyx"
                                                     style="vertical-align: middle;border: 0;height: auto;">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <!--[if (gte mso 9)|(IE)]>
                        </td>
                        </tr>
                        </table>
                        <![endif]-->
                    </td>
                </tr>
                <tr>
                    <td>
{{--                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td class="bodycopy"style="color: #153643;font-family: sans-serif;font-size: 16px;line-height: 22px;">--}}
                                    @yield('contentMail')
                                {{--</td>
                            </tr>
                            </tbody>
                        </table>--}}
                    </td>
                </tr>
                </tbody>
            </table>
            <table bgcolor="#00102d" class="col425" align="left" border="0" cellpadding="0" cellspacing="0"
                   style="width: 100%; min-width: 100% !important">
                <tbody>
                <tr>
                    <td height="70">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td style="width:100%; padding: 5px 0 0 0; text-align: center !important;">
                                    <p style="width:100%; font-weight: normal; text-align: center; font-size: 12px; color: #a7afb3;">
                                        Copyright © 2017 uPPyx, All rights reserved. 8400 NW 36th Street, Suite 450,
                                        Miami FL 33166.
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>

            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>