<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: sample.html");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <!--<link rel="stylesheet" href="Login Page.css">-->
    <style>
        
body, html {
height: 100%;
font-family: 'Poppins', sans-serif;
}

* {
box-sizing: border-box;
}

.Login-Box {
background-image: url("Login BG.jpg");
min-height: 780px;
background-position: center;
background-repeat: no-repeat;
background-size: cover;
position: relative;
}

.Login-Box h1 {
    padding-left: 80px;
}

.container {
position: absolute;
top: 43%;
left: 40%;
margin: 20px;
max-width: 300px;
padding: 16px;
background-color: white;
border-radius: 10px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}


input[type=text], input[type=password] {
width: 100%;
padding: 15px;
margin: 5px 0 22px 0;
border: none;
background: #f1f1f1;
border-radius: 10px;
}

input[type=text]:focus, input[type=password]:focus {
background-color: #ddd;
outline: none;
border-radius: 10px;
}

.btn {
background-color: #007BFF;
color: white;
padding: 16px 20px;
border: none;
cursor: pointer;
width: 100%;
opacity: 0.9;
border-radius: 10px;
}

.btn:hover {
opacity: 1;
}

#Forgot {
    font-size: 13px;
    text-decoration: none;
    margin-left: 30%;
    color: #888282;
}
        </style>
        
</head>
<body>
<div class="Login-Box">
</div>
<div class="container">
<p style="background-image: url('Login BG.jpg');">
    <h1>Pictale - Login</h1>
    
    <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?> 
    <form method="post">
        <label for="email">email</label>
        <input type="text" name="email" id="email"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
        
        <br> <label for="password">Password</label>
        <input type="text" name="password" id="password">
        <button>Log in </button>
    </form>
    <a href="forgot-password.php">Forgot password?</a>
    </div>
</body>
</html> 





