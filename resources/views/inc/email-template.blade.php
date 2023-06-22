<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Template - {{ config('app.name') }}</title>
</head>
<body>
        <div style="width:50%; margin: 10px auto; 
        font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;font-weight:bold; font-size:30px; 
        ">
           <center> <img src="{{ asset('assets2/images/gtechno.png') }}" alt="gtechno" width="208" 
            style="box-shadow:3px 2px 2px 0px  rgb(11, 1, 56); border-radius:50px;"></center>
        </div>
       <div style="width:40%; margin:10px auto;
        background:rgb(248, 248, 227); color:rgb(14, 1, 36); 
       border-radius: 20px; min-height:300px; box-shadow:10px 0px 10px 0px rgba(172, 160, 160, 0.712);" >
            <h3 style="text-align:center;
             padding:4px; 
            font-weight:bolder; 
            font-family:Verdana, Geneva, Tahoma, sans-serif;
           ">
                Email Verification
            </h3>
            <div style="padding:10px; text-align:center">
                <h2>Welcome, </h2><br>
                <p><?= $body ?></p>
               
                <hr>
                &nbsp;
                <center>
                <a href="{{ $actionLink }}" style="background:goldenrod; 
                color:#fff;border-radius: 20px;
                 width:auto; height:30px;
                  padding:10px; text-decoration:none;font-weight:bold;">Verify Email</a>
                </center>
                &nbsp;
                <hr>
                <small style="color: grey">
                If you are having troubles clicking the button, please copy the link below and paste on a new browser tab</small>
                <br>
                <div href="width:auto;overflow:scroll">
                    <a href="{{ $actionLink }}" >{{ $actionLink }} </a>
                </div>
               device-verification
            </div>
        </div> 

        <footer>
            <p style="text-align: center; color:rgba(119, 114, 114, 0.966)">
                All right reserved &copy; {{ date('Y') }} - {{ config('app.name') }}

            </p>
        </footer>
</body>
</html>
