<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIE PT - Pengadilan Negeri Rantau</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/png" href="<?=base_url()?>assets_srtdash/PNRANTAU.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- <link rel="stylesheet" href="assets/css/style.css"> -->
    <style>
        .login-dark {
        height:1000px;
        background:#475d62 url(../../assets/img/star-sky.jpg);
        background-size:cover;
        position:relative;
        }

        .login-dark form {
        max-width:320px;
        width:90%;
        background-color:#1e2833;
        padding:40px;
        border-radius:4px;
        transform:translate(-50%, -20%);
        position:absolute;
        top:20%;
        left:50%;
        color:#fff;
        box-shadow:3px 3px 4px rgba(0,0,0,0.2);
        }

        .login-dark .illustration {
        text-align:center;
        padding:15px 0 20px;
        font-size:100px;
        color:#2980ef;
        }

        .login-dark form .form-control {
        background:none;
        border:none;
        border-bottom:1px solid #434a52;
        border-radius:0;
        box-shadow:none;
        outline:none;
        color:inherit;
        }

        .login-dark form .btn-primary {
        background:#214a80;
        border:none;
        border-radius:4px;
        padding:11px;
        box-shadow:none;
        margin-top:26px;
        text-shadow:none;
        outline:none;
        }

        .login-dark form .btn-primary:hover, .login-dark form .btn-primary:active {
        background:#214a80;
        outline:none;
        }

        .login-dark form .forgot {
        display:block;
        text-align:center;
        font-size:12px;
        color:#6f7a85;
        opacity:0.9;
        text-decoration:none;
        }

        .login-dark form .forgot:hover, .login-dark form .forgot:active {
        opacity:1;
        text-decoration:none;
        }

        .login-dark form .btn-primary:active {
        transform:translateY(1px);
        }


    </style>
</head>

<body>
    <div class="login-dark">
        <form method="post" action="<?=base_url()?>login/proses_login">
            <h2 class="sr-only">SIE PT - Pengadilan Negeri Rantau</h2>
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <div class="form-group"><input class="form-control" type="text" name="username" placeholder="Username"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Log In</button></div>
            <!-- <a href="#" class="forgot">Forgot your email or password?</a></form> -->
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>