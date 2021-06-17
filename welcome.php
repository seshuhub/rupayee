<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.html");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    
    <meta http-equiv="refresh" content="1;url= http://localhost/my%20project%20files/Login%20Tutorial%20Republic/Procedural/admin.html" />
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <p>
        <!--    <a href="reset-password-oo-format.php" class="btn btn-warning">Reset Your Password</a>  
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a> -->
        Please wait you will be redirected to the website in a while Thank you
    </p>
</body>
</html>