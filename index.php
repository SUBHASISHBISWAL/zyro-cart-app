<?php $base = ''; include 'layouts/header.php' ?>
<?php include 'components/slider.php' ?>
<?php include 'components/featured.php' ?>
<?php include 'components/categories.php' ?>
<?php include 'components/offer.php' ?>
<?php include 'components/trending-products.php' ?>
<?php include 'components/subscribe.php' ?>
<?php include 'components/new-arrival.php' ?>
<?php include 'components/vendor.php' ?>
<?php include 'layouts/footer.php' ?>
<?php if(isset($_GET['deleted']) && $_GET['deleted'] == 'success'): ?>
<script>
    // Thoda delay dekar popup dikhayenge taaki page load ho jaye
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: 'Account Deleted!',
            text: 'Your account has been deleted successfully. We will miss you!',
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });

        // URL se ?deleted=success hata denge taaki refresh karne par wapas na aaye
        window.history.replaceState(null, null, window.location.pathname);
    });
</script>
<?php endif; ?>
