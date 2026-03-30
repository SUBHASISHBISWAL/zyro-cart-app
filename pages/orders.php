<?php
// Session Start and Authentication Check
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Base path for header/footer links
$base = '../';

// Database Connection
include '../api/config/db.php';

// Get Current Logged-in User Data for Sidebar
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
$user_data = $result->fetch_assoc();

?>

<?php include '../layouts/header.php'; ?>

<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">My Orders</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="../index.php">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><a href="profile.php">Profile</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Orders</p>
        </div>
    </div>
</div>
<div class="container-fluid pt-5">
    <div class="row px-xl-5">

        <div class="col-lg-3 col-md-4 mb-5 ">
            <div class="card border-0 shadow-sm order_card1">
                <div class="card-body text-center p-4">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px; overflow: hidden;">
                        <?php if(!empty($user_data['profile_image'])): ?>
                            <img src="../assets/img/users/<?php echo $user_data['profile_image']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <h1 class="text-white m-0"><?php echo strtoupper(substr($user_data['name'], 0, 1)); ?></h1>
                        <?php endif; ?>
                    </div>
                    <h5 class="font-weight-bold"><?php echo htmlspecialchars($user_data['name']); ?></h5>
                    <p class="text-muted small mb-0">Member since <?php echo date('d M Y', strtotime($user_data['created_at'])); ?></p>
                </div>
                <div class="list-group list-group-flush border-top">
                    <a href="profile.php" class="list-group-item list-group-item-action py-3">
                        <i class="fas fa-user text-primary mr-3"></i>Personal Information
                    </a>
                    <a href="orders.php" class="list-group-item list-group-item-action active bg-primary text-white border-0 py-3">
                        <i class="fas fa-box-open text-white mr-3"></i>My Orders
                    </a>
                    <a href="wishlist.php" class="list-group-item list-group-item-action py-3">
                        <i class="fas fa-heart text-primary mr-3"></i>My Wishlist
                    </a>
                    <a href="../api/auth/logout.php" class="list-group-item list-group-item-action text-danger py-3">
                        <i class="fas fa-sign-out-alt mr-3"></i>Logout
                    </a>
                    <a href="#" onclick="confirmDelete()" class="list-group-item list-group-item-action text-muted small py-2 mt-4 border-top">
                        <i class="fas fa-trash-alt mr-2"></i>Delete My Account
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 p-4">
                    <h4 class="font-weight-semi-bold m-0">Order History</h4>
                </div>
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <i class="fas fa-shopping-cart fa-5x text-secondary"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark mb-3">No Orders Yet!</h3>
                    <p class="text-muted mb-4">Looks like you haven't made your first purchase. Explore our collection and find something you love.</p>
                    <a href="shop.php" class="btn btn-primary px-4 py-3">Start Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    if(confirm("Warning: Are you sure you want to delete your account? This action cannot be undone.")) {
        window.location.href = "../api/auth/delete_account.php";
    }
}
</script>

<?php include '../layouts/footer.php'; ?>