<?php $base = '../';
include '../layouts/header.php';
include '../api/config/db.php';

$product_id = isset($_GET['id']) ? $_GET['id'] : '';
$query = "SELECT * FROM shop_products WHERE id='$product_id'";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);
?>

<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Product Detail</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="<?php echo $base; ?>index.php">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Product Detail</p>
        </div>
    </div>
</div>

<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 pb-5">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner border">
                    <?php if ($product['image_url'] != '') {
                        $images = json_decode($product['image_url'], true);
                        for ($i = 0; $i < count($images); $i++) {
                    ?>
                            <div class="carousel-item <?php if ($i == 0) echo "active"; ?>">
                                <img class="w-100 h-100" src="<?php echo $images[$i]; ?>" alt="Image">
                            </div>
                    <?php } } ?>
                </div>
                <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold"><?php echo $product['name']; ?></h3>
            <div class="d-flex mb-3">
                <?php
                $rating = $product['rating'];
                $fullStars = floor($rating);
                $halfStar  = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                $emptyStars = 5 - ($fullStars + $halfStar);
                ?>
                <div class="text-primary mr-2">
                    <?php for ($i = 0; $i < $fullStars; $i++): ?><small class="fas fa-star"></small><?php endfor; ?>
                    <?php if ($halfStar): ?><small class="fas fa-star-half-alt"></small><?php endif; ?>
                    <?php for ($i = 0; $i < $emptyStars; $i++): ?><small class="far fa-star"></small><?php endfor; ?>
                </div>
                <small class="pt-1">(<?php echo $product['reviews']; ?> Reviews)</small>
            </div>
            <h3 class="font-weight-semi-bold mb-4">$<?php echo $product['price']; ?></h3>
            <p class="mb-4"><?php echo $product['description']; ?></p>

            <div class="d-flex mb-3">
                <p class="text-dark font-weight-medium mb-0 mr-3">Sizes:</p>
                <form>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="size-1" name="size" value="XS" checked>
                        <label class="custom-control-label" for="size-1">XS</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="size-2" name="size" value="S">
                        <label class="custom-control-label" for="size-2">S</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="size-3" name="size" value="M">
                        <label class="custom-control-label" for="size-3">M</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="size-4" name="size" value="L">
                        <label class="custom-control-label" for="size-4">L</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="size-5" name="size" value="XL">
                        <label class="custom-control-label" for="size-5">XL</label>
                    </div>
                </form>
            </div>
            <div class="d-flex mb-4">
                <p class="text-dark font-weight-medium mb-0 mr-3">Colors:</p>
                <form>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="color-1" name="color" value="Black" checked>
                        <label class="custom-control-label" for="color-1">Black</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="color-2" name="color" value="White">
                        <label class="custom-control-label" for="color-2">White</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="color-3" name="color" value="Red">
                        <label class="custom-control-label" for="color-3">Red</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="color-4" name="color" value="Blue">
                        <label class="custom-control-label" for="color-4">Blue</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="color-5" name="color" value="Green">
                        <label class="custom-control-label" for="color-5">Green</label>
                    </div>
                </form>
            </div>
            <div class="d-flex align-items-center mb-4 pt-2">
                <div class="input-group quantity mr-3" style="width: 130px;">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-minus"><i class="fa fa-minus"></i></button>
                    </div>
                    <input type="text" class="form-control bg-secondary text-center" id="product-qty" value="1">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-plus"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <button class="btn btn-primary px-3" id="add-to-cart-btn" data-id="<?php echo $product['id']; ?>"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
            </div>

            <div class="d-flex pt-2">
                <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                <div class="d-inline-flex">
                    <a class="text-dark px-2" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="text-dark px-2" href=""><i class="fab fa-twitter"></i></a>
                    <a class="text-dark px-2" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="text-dark px-2" href=""><i class="fab fa-pinterest"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('#add-to-cart-btn').click(function(e) {
        e.preventDefault();

        let p_id = $(this).data('id');
        let qty = $('#product-qty').val();
        let size = $('input[name="size"]:checked').val();
        let color = $('input[name="color"]:checked').val();

        $.ajax({
            url: '../api/cart/add_to_cart.php',
            type: 'POST',
            data: { product_id: p_id, qty: qty, size: size, color: color },
            dataType: 'json',
            success: function(res) {
                if(res.status === 'success') {
                    $('#cart-badge').text(res.cart_count); // Badge live update
                    Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: res.message, showConfirmButton: false, timer: 3000, timerProgressBar: true });
                } else {
                    Swal.fire({ icon: 'warning', title: 'Wait!', text: res.message, confirmButtonText: 'Go to Login' }).then((result) => {
                        if(result.isConfirmed){ window.location.href = 'login.php'; }
                    });
                }
            }
        });
    });
});
</script>
<?php include '../layouts/footer.php' ?>