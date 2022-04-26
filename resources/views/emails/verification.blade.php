<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title Here</title>
</head>
<body>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap');

        body {
            background: #f3f3f3;
        }

        html,
        body,
        table,
        h1,
        tr,
        td {
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
        }
    </style>
    <table style="width: 74%;border-collapse: collapse;margin:0 auto;background: #ff9f00;text-align: center;color: #fff;margin-top: 4%;letter-spacing: 1px;">
        <tr>
            <td>
                <img style="width: 15%;margin-top: 50px;" src="https://is1-ssl.mzstatic.com/image/thumb/Purple124/v4/92/9c/09/929c091f-97c0-0d6c-01b0-c4600a7404b2/source/512x512bb.jpg" alt="logo">
            </td>
        </tr>
        <tr>
            <td>
                <h1 style="text-transform: uppercase;margin-top: 60px;margin-bottom: 40px;font-size: 40px;font-family: google-sans-BOLD;"><b>account validation</b></h1>
            </td>
        </tr>
        <tr>
            <td>
                <p style="width: 60%;margin: auto;font-size: 22px;margin-bottom: 70px;font-family: GOOGLESANS-MEDIUM;line-height: 35px;">Hi <a href="#" style="color: #fff;">{{$user_det['username']}}</a>, you received this email for we received a request to verify your email</p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="font-size: 80px;margin-bottom: 120px;font-family: google-sans-BOLD;"><b>{{$user_det['verification_code']}} </b></p>
            </td>
        </tr>
        <tr style="background: #fff;color: #f94f50;">
            <td>
                <p style="margin-top: 20px;margin-bottom: 20px;font-size: 22px;width:80%;margin-left:auto;margin-right: auto;font-family: GOOGLESANS-MEDIUM;">If you did not request this verification you can disregard this email.</p>
            </td>
        </tr>
    </table>

    <!-- <table style="width: 30%; margin: 0 auto;">
        <tr>
            <td>
                <img style="width: 70px;" src="https://is1-ssl.mzstatic.com/image/thumb/Purple124/v4/92/9c/09/929c091f-97c0-0d6c-01b0-c4600a7404b2/source/512x512bb.jpg" >
            </td>
        </tr>
    </table>
    <table style="width: 30%; margin: 0 auto; background: #ffff; box-shadow: 0px 1px 20px 0px #efecec; padding-bottom: 50px;">

        <tr>
            <td style="text-align: center;text-transform: capitalize;"><h1>{{$user_det['verification_code']}}</h1></td>
        </tr>

        <tr>
            <td tyle="text-align: center; ">
                <p style="text-align: center; padding: 0 10px; font-size: 12px;">
                    Hi {{$user_det['username']}} you're almost ready to start enjoying Brocante.<br>
                    Simply copy the Code above to verify your <br>
                    email address.
                </p>
            </td>
        </tr>
    </table>

    <table style="width: 30%; margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <p style="font-family: 'Indie Flower', cursive; font-size: 30px;">Stay in touch</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <p style="font-size: 9px; margin: 0; margin-top: -20px;">
                    Email sent by Brocante App <br>
                    Copyright &copy; <span id="year">2021</span> Samar Brocante, All rights reserved.
                </p>
            </td>
        </tr>
    </table> -->



<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script>
        var yr = new Date();
        var updatedyr = yr.getFullYear();
        $('#year').html(updatedyr);
    </script>

</body>
</html>
