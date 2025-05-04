<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zenek";

$error_message = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $captchaResult = $_POST['captcha'];


    if ($password !== $confirmPassword) {
        $error_message = "A jelszavak nem egyeznek meg.";
    } else {
        // Validate CAPTCHA
        if ($_SESSION['captcha'] != $captchaResult) {
            $error_message = "Helytelen biztonsági kód.";
        } else {
            if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password)) {
                $error_message = "A jelszónak legalább 8 karakter hosszúnak kell lennie és tartalmaznia kell legalább egy nagybetűt.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

                if ($conn->query($sql) === TRUE) {
                    echo "Regisztráció sikeres!";
                    header("Location: ./login.php");
                    exit();
                } else {
                    $error_message = "Hiba: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    }
}

$num1 = rand(1, 10);
$num2 = rand(1, 10);
$operator = ['+', '-', '*'][array_rand(['+', '-', '*'])];
$result = eval("return $num1 $operator $num2;");
$captchaExpression = "$num1 $operator $num2";

$_SESSION['captcha'] = $result;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reigsztrálj</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;	
            font-family: Raleway, sans-serif;
        }

        body {
            background: linear-gradient(90deg, #C7C5F4, #776BCC);		
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .screen {		
            background: linear-gradient(90deg, #5D54A4, #7C78B8);		
            position: relative;	
            height: 600px;
            width: 360px;	
            box-shadow: 0px 0px 24px #5C5696;
        }

        .screen__content {
            z-index: 1;
            position: relative;	
            height: 100%;
        }

        .screen__background {		
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
            -webkit-clip-path: inset(0 0 0 0);
            clip-path: inset(0 0 0 0);	
        }

        .screen__background__shape {
            transform: rotate(45deg);
            position: absolute;
        }

        .screen__background__shape1 {
            height: 520px;
            width: 520px;
            background: #FFF;	
            top: -50px;
            right: 120px;	
            border-radius: 0 72px 0 0;
        }

        .screen__background__shape2 {
            height: 220px;
            width: 220px;
            background: #6C63AC;	
            top: -172px;
            right: 0;	
            border-radius: 32px;
        }

        .screen__background__shape3 {
            height: 540px;
            width: 190px;
            background: linear-gradient(270deg, #5D54A4, #6A679E);
            top: -24px;
            right: 0;	
            border-radius: 32px;
        }

        .screen__background__shape4 {
            height: 400px;
            width: 200px;
            background: #7E7BB9;	
            top: 420px;
            right: 50px;	
            border-radius: 60px;
        }

        .login {
            width: 320px;
            padding: 30px;
            padding-top: 156px;
        }

        .login__field {
            padding: 20px 0px;	
            position: relative;	
        }

        .login__icon {
            position: absolute;
            top: 30px;
            color: #7875B5;
        }

        .login__input {
            border: none;
            border-bottom: 2px solid #D1D1D4;
            background: none;
            padding: 10px;
            padding-left: 24px;
            font-weight: 700;
            width: 75%;
            transition: .2s;
        }

        .login__input:active,
        .login__input:focus,
        .login__input:hover {
            outline: none;
            border-bottom-color: #6A679E;
        }

        .login__submit {
            background: #fff;
            font-size: 14px;
            margin-top: 30px;
            padding: 16px 20px;
            border-radius: 26px;
            border: 1px solid #D4D3E8;
            text-transform: uppercase;
            font-weight: 700;
            display: flex;
            align-items: center;
            width: 100%;
            color: #4C489D;
            box-shadow: 0px 2px 2px #5C5696;
            cursor: pointer;
            transition: .2s;
        }

        .login__submit:active,
        .login__submit:focus,
        .login__submit:hover {
            border-color: #6A679E;
            outline: none;
        }

        .button__icon {
            font-size: 24px;
            margin-left: auto;
            color: #7875B5;
        }

    .captcha__field {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .captcha__expression {
        margin-right: 10px;
        font-weight: bold;
        color: #7875B5;
    }

    .captcha__label {
        font-weight: bold;
        color: #7875B5;
    }

    .captcha__input {
        border: none;
        border-bottom: 2px solid #D1D1D4;
        background: none;
        padding: 10px;
        padding-left: 24px;
        font-weight: 700;
        width: 75%;
        transition: .2s;
    }

    .captcha__input::placeholder {
        color: black; 
    }

    .error-message {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(255, 0, 0, 0.5);
        padding: 10px 20px;
        border-radius: 10px;
        color: #fff;
    }

    </style>
</head>
<body>
<div class="container">
        <div class="screen">
            <div class="screen__content">
                <form class="login" action="register.php" method="POST">
                    <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
                        <input type="text" class="login__input" name="username" placeholder="Felhasználónév" required><br>
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-lock"></i>
                        <input type="password" class="login__input" name="password" id="password" placeholder="Jelszó" required>
                        <input type="checkbox" onchange="togglePassword()">👁<br>
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-lock"></i>
                        <input type="password" class="login__input" name="confirm_password" id="confirm_password" placeholder="Jelszó mégegyszer" required>
                    </div>
                   

                    <div class="captcha__field">
    <div class="captcha__expression"><?= $captchaExpression ?></div>
    <label class="captcha__label">=</label>
    <input type="text" class="captcha__input" name="captcha" id="captcha" required>
</div>
                    <button class="button login__submit" type="submit" name="register">
                        <span class="button__text">Regisztrálj!</span>
                        <i class="button__icon fas fa-chevron-right"></i>
                    </button>
                </form>
            </div>
            <div class="screen__background">
                <span class="screen__background__shape screen__background__shape4"></span>
                <span class="screen__background__shape screen__background__shape3"></span>
                <span class="screen__background__shape screen__background__shape2"></span>
                <span class="screen__background__shape screen__background__shape1"></span>
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</body>
</html>
