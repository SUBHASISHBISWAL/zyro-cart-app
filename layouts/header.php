<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base = isset($base) ? $base : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ZyroCart</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <link href="<?php echo $base; ?>assets/img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo $base; ?>assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo $base; ?>assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark" href="<?php echo $base; ?>pages/faqs.php">FAQs</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="<?php echo $base; ?>pages/help.php">Help</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="<?php echo $base; ?>pages/support.php">Support</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark px-2" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="text-dark px-2" href=""><i class="fab fa-twitter"></i></a>
                    <a class="text-dark px-2" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="text-dark px-2" href=""><i class="fab fa-instagram"></i></a>
                    <a class="text-dark pl-2" href=""><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <div class="col-md-3">
                    <h3 class="fw-bold"><span class="text-primary">●</span>.ZyroCart</h3>
                </div>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products" onkeyup="getFilterProduct(this.value)">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </form>
                <ul class="list-unstyled seach-product-ul" id="filter-products">

                </ul>
            </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge">0</span>
                </a>

                <?php
                    $cart_count = 0;
                    $cart_link = $base . "pages/login.php"; // Default link login page rahega (bina login walo ke liye)

                    // Database Connection Check
                    if(!isset($conn)) {
                        $db_path = file_exists('api/config/db.php') ? 'api/config/db.php' : '../api/config/db.php';
                        if(file_exists($db_path)) include_once $db_path;
                    }

                    // CONDITION 1: User Logged In Hai
                    if(isset($_SESSION['user_id']) && isset($conn)){
                        $cart_link = $base . "pages/cart.php"; // Link change karke asali cart ka kar diya
                        $uid = $_SESSION['user_id'];
                        $cart_q = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id='$uid'");
                        if($cart_q) {
                            $cart_res = mysqli_fetch_assoc($cart_q);
                            $cart_count = $cart_res['total'] ? $cart_res['total'] : 0;
                        }
                    }
                    // CONDITION 2: Guest User (Bina login wale)
                    else {
                        if (isset($_SESSION['guest_cart'])) {
                            foreach ($_SESSION['guest_cart'] as $item) {
                                $cart_count += $item['qty'];
                            }
                        }
                    }
                ?>
                <a href="<?php echo $cart_link; ?>" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge" id="cart-badge"><?php echo $cart_count; ?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100 collapsed" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;" aria-expanded="false">
                    <h6 class="m-0 text-white">Categories</h6>
                    <i class="fa fa-angle-down text-white"></i>
                </a>
                <nav class="position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light collapse" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1111;">
                    <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link" data-toggle="dropdown">Dresses <i class="fa fa-angle-down float-right mt-1"></i></a>
                            <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                                <a href="" class="dropdown-item">Men's Dresses</a>
                                <a href="" class="dropdown-item">Women's Dresses</a>
                                <a href="" class="dropdown-item">Baby's Dresses</a>
                            </div>
                        </div>
                        <a href="" class="nav-item nav-link">Shirts</a>
                        <a href="" class="nav-item nav-link">Jeans</a>
                        <a href="" class="nav-item nav-link">Swimwear</a>
                        <a href="" class="nav-item nav-link">Sleepwear</a>
                        <a href="" class="nav-item nav-link">Sportswear</a>
                        <a href="" class="nav-item nav-link">Jumpsuits</a>
                        <a href="" class="nav-item nav-link">Blazers</a>
                        <a href="" class="nav-item nav-link">Jackets</a>
                        <a href="" class="nav-item nav-link">Shoes</a>
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="w-100 navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <?php $current_page = basename($_SERVER['SCRIPT_NAME']); ?>
                            <a href="<?php echo $base; ?>index.php" class="nav-item nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a>
                            <a href="<?php echo $base; ?>pages/shop.php" class="nav-item nav-link <?php echo ($current_page == 'shop.php') ? 'active' : ''; ?>">Shop</a>

                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="<?php echo $base; ?>pages/cart.php" class="dropdown-item">Shopping Cart</a>
                                    <a href="<?php echo $base; ?>pages/checkout.php" class="dropdown-item">Checkout</a>
                                </div>
                            </div>
                            <a href="<?php echo $base; ?>pages/contact.php" class="nav-item nav-link">Contact</a>
                        </div>

                        <div class="navbar-nav ml-auto py-0">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown" style="padding-top: 12px; padding-bottom: 12px;">
                                        <?php
                                            $header_img = "";
                                            if(isset($conn) && $conn) {
                                                $h_id = $_SESSION['user_id'];
                                                $h_query = mysqli_query($conn, "SELECT profile_image FROM users WHERE id='$h_id'");
                                                if($h_query && mysqli_num_rows($h_query) > 0) {
                                                    $h_data = mysqli_fetch_assoc($h_query);
                                                    $header_img = $h_data['profile_image'];
                                                }
                                            }
                                        ?>
                                        <?php if(!empty($header_img)): ?>
                                            <img src="<?php echo $base; ?>assets/img/users/<?php echo $header_img; ?>" alt="User" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 8px; border: 2px solid #D19C97;">
                                        <?php else: ?>
                                            <i class="fas fa-user-circle fa-2x text-primary" style="margin-right: 8px;"></i>
                                        <?php endif; ?>
                                        <span style="font-size: 16px; font-weight: 600;">
                                            <?php if(isset($_SESSION['user_name'])) { echo $_SESSION['user_name'];}?>
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right rounded-0 m-0">
                                        <a href="<?php echo $base; ?>pages/profile.php" class="dropdown-item">My Profile</a>
                                        <a href="<?php echo $base; ?>pages/orders.php" class="dropdown-item">My Orders</a>
                                        <a href="<?php echo $base; ?>pages/wishlist.php" class="dropdown-item">My Wishlist</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="<?php echo $base; ?>api/auth/logout.php" class="dropdown-item text-danger">Logout</a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <a href="<?php echo $base; ?>pages/login.php" class="nav-item nav-link">Login</a>
                                <a href="<?php echo $base; ?>pages/login.php?tab=signup" class="nav-item nav-link">Register</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>