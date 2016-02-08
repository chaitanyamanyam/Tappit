
<?php
    include('login.php'); // Includes Login Script
    session_start();

// Check, if user is already login, then jump to secured page
    // Checking the entire directory
if (isset($_SESSION['sess_username'])) {
header('Location: dialogHome.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Are U Ready to TAPPIT</title>
        <link href="css/login.css" rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700' rel='stylesheet' type='text/css'>
        <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/sticky-footer.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">

            <div class="page-header">
                <h1>TappIt <span class="glyphicon glyphicon-book" aria-hidden="true"></span></h1>
                <!-- <a href="/main.html">
                    <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                    Home
                </a>
                <a href="#">
                    <span class="glyphicon glyphicon-download" aria-hidden="true"></span>
                    Download report
                </a>
                <a href="/report.html">
                    <span class="glyphicon glyphicon glyphicon-signal" aria-hidden="true"></span>
                    View report
                </a>
                <a href="/login.html">
                    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    Logout
                </a> -->
            </div>

            <div class="table">
                <div class="cell">
                    <div class="wrapper">
                        <div class="right">
                            <span class="title">Are U Ready 2 TAPPIT</span>
                            <span class="register">
                                Not a user yet?
                                <a href="register.php">Signup</a>
                            </span>
                        </div>
                        <div class="left">
                            <span class="title">Log In</span>
                            <form method="get">
                                <input id="name" name="username" type="text" autocomplete="off" class="txt uname" placeholder="Username">
                                <input id="password" name="password" type="password" autocomplete="off" class="txt upass" placeholder="Password">
                                <input name="submit" type="submit" value="Login" class="btn">
                            </form>
                            <span class="error"><?php echo $error; ?></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="footer">
            <p class="muted credit"><p>©TappIt. Improving your performance 2014</p></p>
        </div>
    </body>
</html>