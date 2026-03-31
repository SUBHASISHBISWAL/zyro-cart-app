<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZyroCart</title>

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>

<!-- ✅ Toast Message (TOP RIGHT) -->
<body>

<?php if (isset($_SESSION['message'])): ?>
    <div id="toast" class="toast <?php echo $_SESSION['type'] ?? 'error'; ?>">
        <?php 
            echo $_SESSION['message']; 
            unset($_SESSION['message']); 
            unset($_SESSION['type']);
        ?>
    </div>
<?php endif; ?>

<!-- NOW container -->

<!-- added condition for signup and signin tab active functionality  -->
<div class="container <?php if(isset($_GET['tab'])) { echo  $_GET['tab']=='signup' ? 'active':''; } ?>">

    <!-- LOGIN -->
    <div class="form-box login">
        <form action="../api/auth/login.php" method="POST">

            <h1>Sign in</h1>

            <div class="input-box">
                <input type="email" placeholder="E-mail" name="email" required>
                <i class='bx bxs-envelope'></i>
            </div>

            <div class="input-box">
                <input type="password" placeholder="Password" name="password" required>
                <i class="bx bxs-lock-alt"></i>
            </div>

            <div class="forgot-link">
                <a href="#">Forgot Password</a>
            </div>

            <button type="submit" class="btn">Login</button>

            <p>or login with social platforms</p>

            <div class="social-icons">
                <a href="#"><i class='bx bxl-google'></i></a>
                <a href="#"><i class='bx bxl-facebook'></i></a>
                <a href="#"><i class='bx bxl-github'></i></a>
                <a href="#"><i class='bx bxl-linkedin'></i></a>
            </div>

        </form>
    </div>

    <!-- REGISTER -->
    <div class="form-box register">
        <form action="../api/auth/register.php" method="POST">

            <h1>Sign Up</h1>

            <div class="input-box">
                <input type="text" placeholder="Username" name="name" required>
                <i class="bx bxs-user"></i>
            </div>

            <div class="input-box">
                <input type="email" placeholder="Email" name="email" required>
                <i class='bx bx-envelope'></i>
            </div>

            <div class="input-box">
                <input type="password" placeholder="Password" name="password" required>
                <i class="bx bxs-lock-alt"></i>
            </div>

            <button type="submit" class="btn">Sign Up</button>

            <p>sign up with social platforms</p>

            <div class="social-icons">
                <a href="#"><i class='bx bxl-google'></i></a>
                <a href="#"><i class='bx bxl-facebook'></i></a>
                <a href="#"><i class='bx bxl-github'></i></a>
                <a href="#"><i class='bx bxl-linkedin'></i></a>
            </div>

        </form>
    </div>

    <!-- TOGGLE PANEL -->
    <div class="toggle-box">
        <div class="toggle-panel toggle-left">
            <h1>Hello, Welcome!!</h1>
            <p>Already have an account</p>
            <button type="button" class="btn register-btn">Sign Up</button>
        </div>

        <div class="toggle-panel toggle-right">
            <h1>Welcome back!..</h1>
            <p>Don't have an account?</p>
            <button type="button" class="btn login-btn">Sign in</button>
        </div>
    </div>

</div>

<!-- JS -->
<script src="../assets/js/login.js"></script>

<!-- ✅ Auto hide toast -->
<script>
setTimeout(() => {
    const toast = document.getElementById('toast');
    if (toast) toast.remove();
}, 3000);
</script>

</body>
</html>