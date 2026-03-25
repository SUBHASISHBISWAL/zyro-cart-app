
<?php session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZyroCart</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/css/login.css">
    
</head>

<body>
    <div class="container <?php if (isset($_GET['tab'])) {
                                echo $_GET['tab'] == 'signup' ? 'active' : '';
                            } ?>">
        <div class="form-box login">
         
            <form action="../api/auth/login.php" method="post">
           
                <h1>Sign in</h1>
                        <?php
            if (isset($_SESSION['message'])) {
                echo "<div class='alert alert-danger'>" . $_SESSION['message'] . "</div>";

                // Remove message after showing (important)
                unset($_SESSION['message']);
            }
            ?>
                <div class="input-box">
                    <input type="E-mail" placeholder="E-mail" name="email" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="password" name="password" required>
                    <i class="bx bxs-lock-alt"></i>
                </div>
                <div class="forgot-link">
                    <a href="#">Forgot Password</a>
                </div>
                <button type="submit" class="btn">Login</button>
                <P>or login with social platforms</P>
                <div class="social-icons">
                    <a href="#"><i class='bx bxl-google'></i></a>
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-github'></i></a>
                    <a href="#"><i class='bx bxl-linkedin'></i></a>

                </div>
            </form>
        </div>
        <div class="form-box register">
            <form action="../api/auth/register.php" method="post">
                <h1>Sign Up</h1>
                <div class="input-box">
                    <input type="text" placeholder="Username" name="name" required>
                    <i class="bx bxs-user"></i>
                </div>
                <div class="input-box">
                    <input type="Email" placeholder="E mail" name="email" required>
                    <i class='bx bx-envelope'></i>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="password" name="password" required>
                    <i class="bx bxs-lock-alt"></i>
                </div>
                <button type="submit" class="btn">sign up</button>
                <P>sign up with social platforms</P>
                <div class="social-icons">
                    <a href="#"><i class='bx bxl-google'></i></a>
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-github'></i></a>
                    <a href="#"><i class='bx bxl-linkedin'></i></a>

                </div>
            </form>
        </div>
        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Hello, Welcome!!</h1>
                <p>Already have an account</p>
                <button class="btn register-btn">Sign Up</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1>Welcome back!..</h1>
                <p>Don't have an account?</p>
                <button class="btn login-btn">Sign in</button>
            </div>
        </div>
    </div>



</html>