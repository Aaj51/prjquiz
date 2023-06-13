<?php
include "connection.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $email = $_POST['username'];
        $password = $_POST['password'];

        // Server-side validation
        $email = mysqli_real_escape_string($con, $email);
        $password = mysqli_real_escape_string($con, $password);

        if (empty($email)) {
            echo "<script>alert('Please enter an email.');</script>";
        } elseif (empty($password)) {
            echo "<script>alert('Please enter a password.');</script>";
        } else {
            $str = "SELECT * FROM user WHERE email='$email' OR userName='$email'";
            $result = mysqli_query($con, $str);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if (password_verify($password, $row['password'])) { // Compare the entered password with the hashed password
                    $_SESSION["username"] = $_POST['username'];
                    $_SESSION["userid"]=$row["user_id"];
                    header('Location: userDashboard.php');
                    exit();
                } else {
                    echo "<script>alert('Wrong email or password.');</script>";
                }
            } else {
                echo "<script>alert('Wrong email or password.');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        .password-toggle {
            position: relative;
        }

        .password-toggle i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            margin-top: 20px;
            text-align: center;
        }
    </style>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var toggleIcon = document.getElementById("toggle-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.className = "fas fa-eye-slash";
            } else {
                passwordInput.type = "password";
                toggleIcon.className = "fas fa-eye";
            }
        }
    </script> 
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <form action="" method="post" name="loginForm" onsubmit="return validateForm()">
        <h1>LOGIN</h1>
        <hr>
        <div>
            <label for="email">Username:</label>
            <input type="text" name="username" id="username">
        </div>
        <div class="password-toggle">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
            <i id="toggle-icon" class="fas fa-eye" onclick="togglePasswordVisibility()"></i>
        </div>
        <input type="submit" value="Login" name="submit">
        <p>Don't have an account? <a href="userRegister.php">Signup</a></p>
    </form>
</body>
</html>

 