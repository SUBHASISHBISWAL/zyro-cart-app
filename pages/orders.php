<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$base = '../';
include '../api/config/db.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
$user_data = $result->fetch_assoc();
?>

<?php include '../layouts/header.php'; ?>

<style>
    .premium-card {
        background: #ffffff;
        border-radius: 20px !important;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04) !important;
        border: 1px solid rgba(0,0,0,0.02) !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }
    .premium-card:hover { box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08) !important; }

    .sidebar-link {
        transition: all 0.3s ease;
        border-left: 4px solid transparent !important;
        font-weight: 500;
        color: #555 !important;
        margin-bottom: 5px;
        border-radius: 10px;
    }
    .sidebar-link:hover:not(.active) {
        background-color: #f8f9fa !important;
        padding-left: 25px !important;
        color: #D19C97 !important;
        border-left: 4px solid #D19C97 !important;
    }
    .sidebar-link.active {
        background-color: #D19C97 !important;
        color: white !important;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(209, 156, 151, 0.4);
    }
    .sidebar-link.active i { color: white !important; }

    .profile-img-container {
        border: 5px solid #fff;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .profile-img-container:hover { transform: scale(1.05); }

    .btn-premium {
        border-radius: 30px;
        padding: 12px 35px;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 5px 15px rgba(209, 156, 151, 0.4);
        transition: all 0.3s ease;
    }
    .btn-premium:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(209, 156, 151, 0.6); }
</style>

<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3" style="letter-spacing: 2px;">My Orders</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="../index.php" class="text-dark">Home</a></p>
            <p class="m-0 px-2 text-muted">-</p>
            <p class="m-0"><a href="profile.php" class="text-dark">Profile</a></p>
            <p class="m-0 px-2 text-muted">-</p>
            <p class="m-0 text-muted">Orders</p>
        </div>
    </div>
</div>

<div class="container-fluid pt-5 pb-5">
    <div class="row px-xl-5">

        <div class="col-lg-3 col-md-4 mb-5">
            <div class="card premium-card h-100">
                <div class="card-body text-center p-4">
                    <div class="profile-img-container bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px; overflow: hidden;">
                        <?php if(!empty($user_data['profile_image'])): ?>
                            <img src="../assets/img/users/<?php echo $user_data['profile_image']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <h1 class="text-white m-0" style="font-size: 50px;"><?php echo strtoupper(substr($user_data['name'], 0, 1)); ?></h1>
                        <?php endif; ?>
                    </div>
                    <h5 class="font-weight-bold mb-1" style="font-size: 20px;"><?php echo htmlspecialchars($user_data['name']); ?></h5>
                    <p class="text-muted small mb-0"><i class="fas fa-calendar-alt mr-1"></i> Joined <?php echo date('d M Y', strtotime($user_data['created_at'])); ?></p>
                </div>
                <div class="list-group list-group-flush px-3 pb-4 border-0">
                    <a href="profile.php" class="list-group-item list-group-item-action sidebar-link border-0 py-3">
                        <i class="fas fa-user text-primary mr-3" style="width: 20px; text-align: center;"></i> Personal Info
                    </a>
                    <a href="orders.php" class="list-group-item list-group-item-action sidebar-link active border-0 py-3">
                        <i class="fas fa-box-open text-primary mr-3" style="width: 20px; text-align: center;"></i> My Orders
                    </a>
                    <a href="wishlist.php" class="list-group-item list-group-item-action sidebar-link border-0 py-3">
                        <i class="fas fa-heart text-primary mr-3" style="width: 20px; text-align: center;"></i> My Wishlist
                    </a>
                    <a href="addresses.php" class="list-group-item list-group-item-action sidebar-link border-0 py-3">
                        <i class="fas fa-map-marker-alt text-primary mr-3" style="width: 20px; text-align: center;"></i> Addresses
                    </a>
                    <a href="../api/auth/logout.php" class="list-group-item list-group-item-action sidebar-link border-0 py-3 text-danger mt-3">
                        <i class="fas fa-sign-out-alt text-danger mr-3" style="width: 20px; text-align: center;"></i> Logout
                    </a>
                    <a href="#" onclick="confirmDelete()" class="list-group-item list-group-item-action sidebar-link border-0 py-2 mt-2 text-muted small">
                        <i class="fas fa-trash-alt text-muted mr-3" style="width: 20px; text-align: center;"></i> Delete Account
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-8">
            <div class="card premium-card mb-4" style="min-height: 100%;">
                <div class="card-header bg-white border-0 p-5 pb-3">
                    <h3 class="font-weight-bold m-0 text-dark">Order History</h3>
                    <p class="text-muted">Track, return, or buy items again.</p>
                </div>
                <div class="card-body p-5 d-flex flex-column align-items-center justify-content-center text-center">
                    <div class="mb-4">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background: rgba(209, 156, 151, 0.1);">
                            <i class="fas fa-box-open fa-3x" style="color: #D19C97;"></i>
                        </div>
                    </div>
                    <h4 class="font-weight-bold text-dark mb-3">No Orders Yet!</h4>
                    <p class="text-muted mb-4" style="max-width: 400px;">Looks like you haven't made your first purchase. Explore our collection and find something you love.</p>
                    <a href="shop.php" class="btn btn-primary btn-premium">Start Shopping</a>
                </div>
            </div>
        </div>
        </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete() {
    Swal.fire({
        title: 'Are you sure?',
        text: "Your account and all data will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#f8f9fa',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: '<span style="color: #333;">Cancel</span>',
        customClass: { popup: 'premium-card' }
    }).then((result) => {
        if (result.isConfirmed) { window.location.href = "../api/auth/delete_account.php"; }
    })
}
</script>

<?php include '../layouts/footer.php'; ?>