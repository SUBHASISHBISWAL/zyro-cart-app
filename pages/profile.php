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

<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">My Profile</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="../index.php">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Profile</p>
        </div>
    </div>
</div>
<div class="container-fluid pt-5">
    <div class="row px-xl-5">

        <div class="col-lg-3 col-md-4 mb-5" style="box-shadow: -5px 0px 8px 0px #4100ffbd !important; border-radius: 15px !important; height: 505px !important;">
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
                    <a href="profile.php" class="list-group-item list-group-item-action active bg-primary text-white border-0 py-3">
                        <i class="fas fa-user text-white mr-3"></i>Personal Information
                    </a>
                    <a href="orders.php" class="list-group-item list-group-item-action py-3">
                        <i class="fas fa-box-open text-primary mr-3"></i>My Orders
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

        <div class="col-lg-9 col-md-8"style="box-shadow: 5px 0px 8px 0px #0007ffbd !important; border-radius: 15px !important; height: 505px !important;">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 p-4">
                    <h4 class="font-weight-semi-bold m-0">Personal Information</h4>
                </div>
                <div class="card-body p-4 bgedt1">
                    <form>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Full Name</label>
                                <input class="form-control bg-light" type="text" value="<?php echo htmlspecialchars($user_data['name']); ?>" readonly>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Email Address</label>
                                <input class="form-control bg-light" type="text" value="<?php echo htmlspecialchars($user_data['email']); ?>" readonly>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Phone Number</label>
                                <input class="form-control bg-light" type="text" value="<?php echo isset($user_data['phone']) ? htmlspecialchars($user_data['phone']) : 'Not Added'; ?>" readonly>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-right">
                <button class="btn btn-primary px-4 py-2" data-toggle="modal" data-target="#editProfileModal">Edit Profile</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-0 border-0 shadow">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white">Edit Profile</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="../api/auth/update_profile.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body p-4">
            <div class="form-group mb-4">
                <label class="font-weight-bold">Profile Image</label>
                <input type="file" class="form-control-file border p-2" name="profile_image" accept="image/*">
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Full Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user_data['name']); ?>" required>
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Phone Number</label>
                <input type="text" class="form-control" name="phone" value="<?php echo isset($user_data['phone']) ? htmlspecialchars($user_data['phone']) : ''; ?>">
            </div>
        </div>
        <div class="modal-footer border-0 p-4">
          <button type="button" class="btn btn-secondary px-4 py-2" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary px-4 py-2">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function confirmDelete() {
    Swal.fire({
        title: 'Are you sure?',
        text: "Your account and all data will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33', // Red color for delete
        cancelButtonColor: '#3085d6', // Blue color for cancel
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Agar user Yes par click karega toh ye file call hogi
            window.location.href = "../api/auth/delete_account.php";
        }
    })
}
</script>

<?php include '../layouts/footer.php'; ?>