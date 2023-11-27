<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Spree</title>
    <style>
        .cover > img {
            width: 100%;
            height: auto;
        }

        .cover {
            height: 350px;
            overflow: hidden;
            position: relative;
        }

        .cover-overlay {
            position: absolute;
            text-align: center;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(40, 48, 64, .5);
        }

        .cover-overlay-gp {
            text-align: center;
            position: relative;
        }

        .cover-overlay-gp img {
            display: block;
        }

        .cover-overlay-gp span {
            color: #fff;
            font-size: 18px;
        }

        body {
            font-family: arial;
            color: #283040;
        }

        .voucher-code {
            padding: 20px;
            text-align: center;
            font-size: 20px;
        }

        .voucher-code b {
            color: #732A80;
        }

        .gray {
            background: #F2F2F2;
        }

        .voucher-bg {
            padding: 20px;
        }

        a {
            color: #732A80;
            text-decoration: none;
        }

        .voucher-bg > span {
            font-weight: bold;
        }

        .voucher-bg > p {
            font-size: 13px;
            opacity: .7;
        }

        ul.voucher-branches li:last-child p {
            margin-bottom: 0px !important;
        }

        ul.voucher-branches {
            margin-bottom: 0px;
        }
    </style>
</head>

<body>
<table width="640" border="0" align="center" cellpadding="0" cellspacing="0"
       style="border:0px solid; box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.12), 0 2px 5px 0 rgba(0, 0, 0, 0.16); display: block;">
    <tr>
        <td>
            <div class="cover">
                <div class="cover-overlay">
                    <div class="cover-overlay-gp">
                        <img src="{{url('front-assets/images/basic/logo.png')}}" alt="logo">
                    </div>
                </div>
                <img src="https://images.pexels.com/photos/306253/pexels-photo-306253.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260"
                     alt="cover photo">
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="voucher-code">
                <h1>Message</h1>
                {{$msg['message']}}
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="voucher-bg">
                <span>Thank you & Good luck</span>
            </div>
        </td>
    </tr>
</table>
</body>

</html>