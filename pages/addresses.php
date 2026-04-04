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

// User ke saare saved addresses nikalne ka logic
$addr_query = "SELECT * FROM user_addresses WHERE user_id = '$user_id' ORDER BY id DESC";
$addresses = $conn->query($addr_query);
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

    .custom-input {
        background-color: #f8f9fa !important;
        border: 1px solid #edf1f5 !important;
        border-radius: 12px;
        padding: 15px 20px;
        font-weight: 500;
        color: #333;
        transition: all 0.3s ease;
    }
    .custom-input:focus {
        background-color: #fff !important;
        box-shadow: 0 5px 15px rgba(209, 156, 151, 0.2) !important;
        border-color: #D19C97 !important;
    }
    .btn-premium {
        border-radius: 30px;
        padding: 12px 35px;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 5px 15px rgba(209, 156, 151, 0.4);
        transition: all 0.3s ease;
    }
    .btn-premium:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(209, 156, 151, 0.6); }

    .address-card {
        background: #fcfcfc;
        border-radius: 15px;
        border: 1px solid #edf1f5;
        transition: all 0.3s ease;
    }
    .address-card:hover {
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border-color: #D19C97;
    }
</style>

<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3" style="letter-spacing: 2px;">Manage Addresses</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="../index.php" class="text-dark">Home</a></p>
            <p class="m-0 px-2 text-muted">-</p>
            <p class="m-0 text-muted">Addresses</p>
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
                    <p class="text-muted small mb-0"><i class="fas fa-calendar-alt mr-1"></i> Joined <?php echo date('M Y', strtotime($user_data['created_at'])); ?></p>
                </div>
                <div class="list-group list-group-flush px-3 pb-4 border-0">
                    <a href="profile.php" class="list-group-item list-group-item-action sidebar-link border-0 py-3">
                        <i class="fas fa-user text-primary mr-3" style="width: 20px; text-align: center;"></i> Personal Info
                    </a>
                    <a href="orders.php" class="list-group-item list-group-item-action sidebar-link border-0 py-3">
                        <i class="fas fa-box-open text-primary mr-3" style="width: 20px; text-align: center;"></i> My Orders
                    </a>
                    <a href="wishlist.php" class="list-group-item list-group-item-action sidebar-link border-0 py-3">
                        <i class="fas fa-heart text-primary mr-3" style="width: 20px; text-align: center;"></i> My Wishlist
                    </a>
                    <a href="addresses.php" class="list-group-item list-group-item-action sidebar-link active border-0 py-3">
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
                <div class="card-header bg-white border-0 p-5 pb-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="font-weight-bold m-0 text-dark">My Addresses</h3>
                        <p class="text-muted">Manage your delivery addresses.</p>
                    </div>
                    <button class="btn btn-primary btn-premium" data-toggle="modal" data-target="#addAddressModal">
                        <i class="fas fa-plus mr-2"></i> Add New Address
                    </button>
                </div>

                <div class="card-body p-5 pt-0">
                    <div class="row">
                        <?php if($addresses->num_rows > 0): ?>
                            <?php while($addr = $addresses->fetch_assoc()): ?>
                            <div class="col-12 mb-4">
                                <div class="address-card p-4">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <span class="badge px-3 py-1 mb-3" style="border-radius: 20px; font-size: 12px; background-color: rgba(209, 156, 151, 0.15); color: #D19C97; font-weight: 600;">
                                                <?php echo $addr['address_type']; ?>
                                            </span>
                                            <h5 class="font-weight-bold mb-2">
                                                <?php echo htmlspecialchars($addr['name']); ?>
                                                <span class="text-muted ml-3" style="font-size: 16px; font-weight: 500;">
                                                    <?php echo htmlspecialchars($addr['phone']); ?>
                                                </span>
                                            </h5>
                                            <p class="text-muted mb-0" style="font-size: 15px; line-height: 1.6;">
                                                <?php echo htmlspecialchars($addr['full_address']); ?>, <?php echo htmlspecialchars($addr['locality']); ?><br>
                                                <?php echo htmlspecialchars($addr['city']); ?>, <?php echo htmlspecialchars($addr['state']); ?> - <span class="font-weight-bold text-dark"><?php echo htmlspecialchars($addr['pincode']); ?></span>
                                            </p>
                                        </div>
                                        <button onclick="confirmDeleteAddress(<?php echo $addr['id']; ?>)" class="btn btn-sm" style="background: rgba(220, 53, 69, 0.1); color: #dc3545; border-radius: 8px; padding: 8px 15px;">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="col-12 text-center py-5">
                                <div class="mb-4"><i class="fas fa-map-marker-alt fa-4x text-light"></i></div>
                                <h5 class="text-muted">No Addresses Saved Yet</h5>
                                <p class="text-muted small">Add a delivery address to checkout faster.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
</div>

<div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content premium-card border-0">
      <div class="modal-header border-0 pb-0 px-4 pt-4">
        <h4 class="modal-title font-weight-bold text-dark">Add New Address</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="../api/auth/save_address.php" method="POST">
        <div class="modal-body p-4">
            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label class="font-weight-bold text-dark mb-2">Full Name</label>
                    <input type="text" class="form-control custom-input" name="name" required >
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label class="font-weight-bold text-dark mb-2">Phone Number</label>
                    <input type="text" class="form-control custom-input" name="phone" required >
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label class="font-weight-bold text-dark mb-2">Pincode</label>
                    <input type="text" class="form-control custom-input" name="pincode" required >
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label class="font-weight-bold text-dark mb-2">Locality / Village</label>
                    <input type="text" class="form-control custom-input" name="locality" required >
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label class="font-weight-bold text-dark mb-2">Full Address</label>
                    <textarea class="form-control custom-input" name="full_address" rows="3" required></textarea>
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label class="font-weight-bold text-dark mb-2">City / District</label>
                    <input type="text" class="form-control custom-input" name="city" required >
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label class="font-weight-bold text-dark mb-2">State</label>
                    <input type="text" class="form-control custom-input" name="state" required >
                </div>
                <div class="col-md-12 form-group mt-3">
                    <label class="font-weight-bold text-dark mb-3 d-block">Address Type</label>
                    <div class="custom-control custom-radio custom-control-inline mr-4">
                        <input type="radio" id="home" name="address_type" class="custom-control-input" value="Home" checked>
                        <label class="custom-control-label" for="home">Home (All day delivery)</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="work" name="address_type" class="custom-control-input" value="Work">
                        <label class="custom-control-label" for="work">Work (10 AM - 5 PM)</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer border-0 px-4 pb-4 pt-0">
          <button type="button" class="btn btn-light px-4 py-2" data-dismiss="modal" style="border-radius: 30px;">Cancel</button>
          <button type="submit" class="btn btn-primary btn-premium ml-2">Save Address</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDeleteAddress(addressId) {
    Swal.fire({
        title: 'Delete Address?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#f8f9fa',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: '<span style="color: #333;">Cancel</span>',
        customClass: { popup: 'premium-card' }
    }).then((result) => {
        if (result.isConfirmed) { window.location.href = "../api/auth/delete_address.php?id=" + addressId; }
    })
}

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

document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('status')) {
        let status = urlParams.get('status');
        let msg = '';
        if(status === 'added') msg = 'Address saved successfully!';
        if(status === 'deleted') msg = 'Address deleted successfully!';

        if(msg !== '') {
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: msg, showConfirmButton: false, timer: 3000, timerProgressBar: true });
            window.history.replaceState(null, null, window.location.pathname);
        }
    }
});
</script>

<?php include '../layouts/footer.php'; ?>