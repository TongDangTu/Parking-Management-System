<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="/DoAnWeb/login/assets/main.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<!-- test -->

<body>
    <style>
        body {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            background: #000;
            color: #fff;
        }
        
        #login {
            position: absolute;
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 800px;
            height: 330px;
            background-color: black;
            top: 25%;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            border: 5px;
            color: #fff;
        }
        
        .bor::before,
        .bor::after {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            background: linear-gradient(45deg, #FFAE46, #FFF050, #FFAE46, #FFF050, #FFAE46, #FFF050);
            background-size: 400%;
            width: calc(100% + 6px);
            height: calc(100% + 6px);
            z-index: -1;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            animation: animate 20s linear infinite;
            -webkit-animation: animate 20s linear infinite;
        }
        
        @keyframes animate {
            0% {
                background-position: 0 0;
            }
            50% {
                background-position: 900% 0;
            }
            100% {
                background-position: 0 0;
            }
        }
        
        .bor::after {
            filter: blur(40px);
            -webkit-filter: blur(40px);
            opacity: 0.5;
        }
        
        .img-login {
            float: left;
            width: calc(100%/2);
            height: 100%;
            display: flex;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
        }
        
        .name-login {
            display: flex;
            justify-content: center;
            font-size: 30px;
            background: linear-gradient(to top, #FFAE46, #FFF050);
            text-transform: uppercase;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .input-login {
            height: 40px;
            outline: none;
            border: 2px solid rgb(226, 147, 0);
            padding: 5px 10px;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            font-size: 20px;
        }
        
        .text-login {
            margin-left: 465px;
            margin-bottom: 5px;
        }
        
        .text-pass-login {
            margin-left: 465px;
            margin-bottom: 5px;
        }
        
        .input-text {
            margin-left: 65px;
        }
        
        .input-pass {
            margin-left: 65px;
            margin-bottom: 20px;
        }
        
        .button {
            cursor: pointer;
            width: 100px;
            color: #fff;
            background-color: rgb(226, 147, 0);
            font-size: 20px;
            outline: none;
            border: 2px solid white;
            height: 40px;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            align-self: flex-end;
            margin-left: 65px;
        }
        
        i {
            position: absolute;
            padding: 15px;
            cursor: pointer;
            margin-left: 355px;
        }
        
        i:hover {
            height: 15px;
            width: 15px;
            background-color: rgb(226, 147, 0);
            border-top-right-radius: 4px;
        }
    </style>
    <div id="login">
        <form action="login_be.php" class="login-name bor" method="post">
            <img src="/DoAnWeb/img/smol logo.png" alt="duy" class="img-login">
            <i style="color: brown;" class="fa fa-xmark"></i>
            <h1 class="name-login">ĐĂNG NHẬP</h1>
            <div class="user-login">
                <p class="text-login">Tên đăng nhập:</p>
                <input type="text" class="input-text input-login" name="txtuser" placeholder="Username">
            </div>
            <div class="pass-login">
                <p class="text-pass-login">Mật khẩu:</p>
                <input type="password" class="input-pass input-login" name="txtpass" placeholder="Password">
            </div>
                <button class="button">LOGIN</button>
                <div class="error_login" style="margin-top:20px;"><center><font color="red"><b><?php    if(!isset($_SESSION['error_login']))
                                                                    {
                                                                        unset($_SESSION['error_login']);
                                                                    }
                                                                    else
                                                                        echo $_SESSION['error_login'];
                                                                    ?>
                                    </b></font></center>
                </div>
        </form>
    </div>

</body>

</html>