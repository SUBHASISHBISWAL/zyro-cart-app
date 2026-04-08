<?php $base = '../';
include '../layouts/header.php'; ?>
<?php
include '../api/config/db.php';

// User ke saare saved addresses nikalne ka logic
$price_query = "SELECT * FROM price_ranges ORDER BY id ASC";
$price_ranges = $conn->query($price_query);

$total_pr_query = "SELECT count(*) as total_product FROM `shop_products`";
$total_products_res = $conn->query($total_pr_query);
$total_prod = $total_products_res->fetch_assoc();

//SELECT count(*) as total_product FROM `shop_products` where price BETWEEN 500 AND 1000
?>
<div class="position-relative">

    <div class="position-absolute w-100 text-center" style="top: 20px; z-index: 10;">
        <div class="d-inline-flex text-white">
            <p class="m-0"><a href="<?php echo $base; ?>index.php">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Shop</p>
        </div>
    </div>
    <!--  Your Slider -->
    <div class="carousel">
        <!-- slider images here -->
    </div>
</div>
<?php include '../components/shop-slider.php'; ?>
<!-- Page Header End -->
<!-- Shop Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-12">
            <!-- Price Start -->
            <div class="border-bottom mb-4 pb-4">
                <h5 class="font-weight-semi-bold mb-4">Filter by price</h5>
                <form>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" checked id="price-all">
                        <label class="custom-control-label" for="price-all">All Price</label>
                        <span class="badge border font-weight-normal"><?php echo $total_prod['total_product']; ?></span>
                    </div>
                    <?php if ($price_ranges->num_rows > 0): ?>
                        <?php while ($price_range = $price_ranges->fetch_assoc()): ?>

                            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input filter-price" data-min-price="<?php echo $price_range['min_price']; ?>" data-max-price="<?php echo $price_range['max_price']; ?>" value="<?php echo $price_range['id']; ?>" id="<?php echo $price_range['id']; ?>">
                                <label class="custom-control-label" for="<?php echo $price_range['id']; ?>"> <?php echo $price_range['label']; ?></label>
                                <span class="badge border font-weight-normal">

                                    <?php
                                    $start_price = $price_range['min_price'];
                                    $end_price = $price_range['max_price'];
                                    $range_wise_pr_query = "SELECT count(*) as range_wise_product_count FROM `shop_products` where price BETWEEN " . $start_price . " AND " . $end_price . "";
                                    $range_products_res = $conn->query($range_wise_pr_query);
                                    $price_range_wise_prod = $range_products_res->fetch_assoc();
                                    echo $price_range_wise_prod['range_wise_product_count'];
                                    ?>


                                </span>
                            </div>
                        <?php endwhile; ?>

                    <?php else: ?>
                        <div class="col-12 text-center py-5">

                            <p class="text-muted small">No price range</p>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
            <!-- Price End -->

            <!-- Color Start -->
            <div class="border-bottom mb-4 pb-4">
                <h5 class="font-weight-semi-bold mb-4">Filter by color</h5>
                <form>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" checked id="color-all">
                        <label class="custom-control-label" for="price-all">All Color</label>
                        <span class="badge border font-weight-normal">1000</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="color-1">
                        <label class="custom-control-label" for="color-1">Black</label>
                        <span class="badge border font-weight-normal">150</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="color-2">
                        <label class="custom-control-label" for="color-2">White</label>
                        <span class="badge border font-weight-normal">295</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="color-3">
                        <label class="custom-control-label" for="color-3">Red</label>
                        <span class="badge border font-weight-normal">246</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="color-4">
                        <label class="custom-control-label" for="color-4">Blue</label>
                        <span class="badge border font-weight-normal">145</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                        <input type="checkbox" class="custom-control-input" id="color-5">
                        <label class="custom-control-label" for="color-5">Green</label>
                        <span class="badge border font-weight-normal">168</span>
                    </div>
                </form>
            </div>
            <!-- Color End -->

            <!-- Size Start -->
            <div class="mb-5">
                <h5 class="font-weight-semi-bold mb-4">Filter by size</h5>
                <form>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" checked id="size-all">
                        <label class="custom-control-label" for="size-all">All Size</label>
                        <span class="badge border font-weight-normal">1000</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="size-1">
                        <label class="custom-control-label" for="size-1">XS</label>
                        <span class="badge border font-weight-normal">150</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="size-2">
                        <label class="custom-control-label" for="size-2">S</label>
                        <span class="badge border font-weight-normal">295</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="size-3">
                        <label class="custom-control-label" for="size-3">M</label>
                        <span class="badge border font-weight-normal">246</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="size-4">
                        <label class="custom-control-label" for="size-4">L</label>
                        <span class="badge border font-weight-normal">145</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                        <input type="checkbox" class="custom-control-input" id="size-5">
                        <label class="custom-control-label" for="size-5">XL</label>
                        <span class="badge border font-weight-normal">168</span>
                    </div>
                </form>
            </div>
            <!-- Size End -->
        </div>
  <div class="col-lg-9 col-md-12">
                    <div class="row" id="dynamic-products">
                        <!-- AJAX products -->
                    </div>
                </div>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {

        function getFilters(className) {
            let values = [];
            $(className + ':checked').each(function() {
                values.push($(this).val());
            });
            return values;
        }

        function loadShopProducts() {
            let colors = getFilters('.filter-color');
            let sizes = getFilters('.filter-size');
            let prices = getFilters('.filter-price');

            $.ajax({
                url: '../api/products/get_products.php',
                type: 'GET',
                data: { color: colors, size: sizes, price: prices },
                dataType: 'json',
                success: function(response) {
                    if (response.length === 0) {
                        $('#dynamic-products').html('<div class="col-12 text-center">No products found.</div>');
                        return;
                    }

                    let html = '';
                    response.forEach(product => {
                        let images = [];
                        try {
                            images = JSON.parse(product.image_url);
                        } catch (e) {
                            images = [];
                        }
                        let img = (images.length > 0) ? images[0] : '../assets/img/default.jpg';

                        // YAHAN ADD TO CART BUTTON KO NAYA CLASS AUR DATA-ID DIYA HAI
                        html += `
                        <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                            <div class="card product-item border-0 mb-4">
                                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100" src="${img}" alt="">
                                </div>
                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                    <h6 class="text-truncate mb-3">${product.name}</h6>
                                    <div class="d-flex justify-content-center">
                                        <h6>$${product.price}</h6><h6 class="text-muted ml-2"><del>$${product.old_price}</del></h6>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between bg-light border">
                                    <a href="<?php echo $base; ?>pages/detail.php?id=${product.id}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                    <a href="#" class="btn btn-sm text-dark p-0 add-to-cart-shop-btn" data-id="${product.id}"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                                </div>
                            </div>
                        </div>`;
                    });

                    $('#dynamic-products').html(html);
                }
            });
        }

        $(document).on('change', '.filter-color, .filter-size, .filter-price', function() {
            loadShopProducts();
        });

        loadShopProducts();

        // NAYA MAGIC: Shop page se direct Add To Cart karne ka function
        $(document).on('click', '.add-to-cart-shop-btn', function(e) {
            e.preventDefault();
            let p_id = $(this).data('id');

            $.ajax({
                url: '../api/cart/add_to_cart.php',
                type: 'POST',
                data: { product_id: p_id, qty: 1, size: '', color: '' }, // Default values from shop
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
