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

<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Manage Addresses</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="../index.php">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Addresses</p>
        </div>
    </div>
</div>

<div class="container-fluid pt-5">
    <div class="row px-xl-5">

        <div class="col-lg-3 col-md-4 mb-5" style="box-shadow: -5px 0px 8px 0px #4100ffbd !important; border-radius: 15px !important; height: 570px !important;">
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
                </div>
                <div class="list-group list-group-flush border-top">
                    <a href="profile.php" class="list-group-item list-group-item-action py-3">
                        <i class="fas fa-user text-primary mr-3"></i>Personal Information
                    </a>
                    <a href="orders.php" class="list-group-item list-group-item-action py-3">
                        <i class="fas fa-box-open text-primary mr-3"></i>My Orders
                    </a>
                    <a href="wishlist.php" class="list-group-item list-group-item-action py-3">
                        <i class="fas fa-heart text-primary mr-3"></i>My Wishlist
                    </a>
                    <a href="addresses.php" class="list-group-item list-group-item-action active bg-primary text-white border-0 py-3">
                        <i class="fas fa-map-marker-alt text-white mr-3"></i>Manage Addresses
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
        <div class="col-lg-9 col-md-8" style="box-shadow: 5px 0px 8px 0px #4100ffbd !important; border-radius: 15px !important; height: 570px !important;">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="font-weight-semi-bold m-0">My Addresses</h4>
                <button class="btn btn-primary" data-toggle="modal" data-target="#addAddressModal">
                    <i class="fas fa-plus mr-2"></i>Add New Address
                </button>
            </div>

            <div class="row">
                <?php if($addresses->num_rows > 0): ?>
                    <?php while($addr = $addresses->fetch_assoc()): ?>

                    <div class="col-12 mb-3">
                        <div class="card border border-light shadow-sm" style="border-radius: 10px; padding: 20px; background-color: #fcfcfc;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="badge badge-secondary px-3 py-1 mb-3" style="border-radius: 20px; font-size: 12px; background-color: #e0e0e0; color: #333;">
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
                                <button onclick="confirmDeleteAddress(<?php echo $addr['id']; ?>)" class="btn btn-outline-danger btn-sm" style="border-radius: 5px; padding: 5px 15px;">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <h5 class="text-muted mt-3">No Addresses Saved Yet</h5>
                        <p class="text-muted small">Add a delivery address to checkout faster.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        </div>
</div>

<div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content rounded-0 border-0 shadow">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white">Add New Address</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="../api/auth/save_address.php" method="POST">
        <div class="modal-body p-4">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-control" name="name" required >
                </div>
                <div class="col-md-6 form-group">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" name="phone" required >
                </div>
                <div class="col-md-6 form-group">
                    <label>Pincode</label>
                    <input type="text" class="form-control" name="pincode" required >
                </div>
                <div class="col-md-6 form-group">
                    <label>Locality / Village</label>
                    <input type="text" class="form-control" name="locality" required >
                </div>
                <div class="col-md-12 form-group">
                    <label>Full Address (House No, Building, Street)</label>
                    <textarea class="form-control" name="full_address" rows="3" required></textarea>
                </div>
                <div class="col-md-6 form-group">
                    <label>City / District</label>
                    <input type="text" class="form-control" name="city" required >
                </div>
                <div class="col-md-6 form-group">
                    <label>State</label>
                    <input type="text" class="form-control" name="state" required >
                </div>
                <div class="col-md-12 form-group mt-2">
                    <label class="d-block">Address Type</label>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="home" name="address_type" class="custom-control-input" value="Home" checked>
                        <label class="custom-control-label" for="home">Home (All day delivery)</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="work" name="address_type" class="custom-control-input" value="Work">
                        <label class="custom-control-label" for="work">Work (Delivery between 10 AM - 5 PM)</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer border-0 p-4">
          <button type="button" class="btn btn-secondary px-4 py-2" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary px-4 py-2">Save Address</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Address Delete ka Popup
function confirmDeleteAddress(addressId) {
    Swal.fire({
        title: 'Delete Address?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "../api/auth/delete_address.php?id=" + addressId;
        }
    })
}

// Account Delete ka Popup (Fix)
function confirmDelete() {
    Swal.fire({
        title: 'Are you sure?',
        text: "Your account and all data will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "../api/auth/delete_account.php";
        }
    })
}

// Success Popup
document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('status')) {
        let status = urlParams.get('status');
        let msg = '';

        if(status === 'added') msg = 'Address saved successfully!';
        if(status === 'deleted') msg = 'Address deleted successfully!';

        if(msg !== '') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: msg,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            window.history.replaceState(null, null, window.location.pathname);
        }
    }
});
</script>

<?php include '../layouts/footer.php'; ?>