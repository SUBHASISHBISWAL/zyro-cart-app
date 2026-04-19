<?php
session_start();
$base = '../';
include '../layouts/header.php';
include '../api/config/db.php';

$cart_items_data = [];
$subtotal = 0;
$shipping = 10;

// DATA FETCH LOGIC (Login vs Guest)
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $cart_query = "SELECT c.id as cart_id, c.quantity, c.size, c.color, p.name, p.price, p.image_url
                   FROM cart c JOIN shop_products p ON c.product_id = p.id WHERE c.user_id = '$user_id'";
    $result = mysqli_query($conn, $cart_query);
    while($row = mysqli_fetch_assoc($result)) {
        $cart_items_data[] = $row;
    }
} else {
    if (isset($_SESSION['guest_cart']) && !empty($_SESSION['guest_cart'])) {
        foreach($_SESSION['guest_cart'] as $key => $item) {
            $p_id = $item['product_id'];
            $p_query = mysqli_query($conn, "SELECT name, price, image_url FROM shop_products WHERE id='$p_id'");
            if ($p_row = mysqli_fetch_assoc($p_query)) {
                $cart_items_data[] = [
                    'cart_id' => $key, // Session key as ID
                    'quantity' => $item['qty'],
                    'size' => $item['size'],
                    'color' => $item['color'],
                    'name' => $p_row['name'],
                    'price' => $p_row['price'],
                    'image_url' => $p_row['image_url']
                ];
            }
        }
    }
}
?>

<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="<?php echo $base; ?>index.php">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Shopping Cart</p>
        </div>
    </div>
</div>

<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                    <tr>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody class="align-middle" id="cart-tbody">
                    <?php if(count($cart_items_data) > 0): ?>
                        <?php foreach($cart_items_data as $row):
                            $images = json_decode($row['image_url'], true);
                            $img = (is_array($images) && count($images) > 0) ? $images[0] : '../assets/img/default.jpg';
                            $item_total = $row['price'] * $row['quantity'];
                            $subtotal += $item_total;
                        ?>
                        <tr id="cart-row-<?php echo htmlspecialchars($row['cart_id']); ?>">
                            <td class="align-middle text-left">
                                <img src="<?php echo $img; ?>" alt="" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                <?php echo htmlspecialchars($row['name']); ?>
                                <br><small class="text-muted ml-5">Size: <?php echo htmlspecialchars($row['size']); ?> | Color: <?php echo htmlspecialchars($row['color']); ?></small>
                            </td>
                            <td class="align-middle">$<span class="item-price"><?php echo $row['price']; ?></span></td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus-cart" data-id="<?php echo htmlspecialchars($row['cart_id']); ?>"><i class="fa fa-minus"></i></button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-secondary text-center qty-input" id="qty-<?php echo htmlspecialchars($row['cart_id']); ?>" value="<?php echo $row['quantity']; ?>" readonly>
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus-cart" data-id="<?php echo htmlspecialchars($row['cart_id']); ?>"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">$<span class="item-total" id="total-<?php echo htmlspecialchars($row['cart_id']); ?>"><?php echo $item_total; ?></span></td>
                            <td class="align-middle">
                                <button class="btn btn-sm btn-danger btn-remove" data-id="<?php echo htmlspecialchars($row['cart_id']); ?>"><i class="fa fa-times"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center py-4">Your cart is empty!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Subtotal</h6>
                        <h6 class="font-weight-medium">$<span id="summary-subtotal"><?php echo $subtotal; ?></span></h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium">$<span id="summary-shipping"><?php echo ($subtotal > 0) ? $shipping : 0; ?></span></h6>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Total</h5>
                        <h5 class="font-weight-bold">$<span id="summary-total"><?php echo ($subtotal > 0) ? ($subtotal + $shipping) : 0; ?></span></h5>
                    </div>

                    <?php
                        // Agar login hai toh checkout, warna login page par bhejo
                        $checkout_href = isset($_SESSION['user_id']) ? "checkout.php" : "login.php";
                    ?>
                    <a href="<?php echo $checkout_href; ?>" class="btn btn-block btn-primary my-3 py-3 <?php echo ($subtotal == 0) ? 'disabled' : ''; ?>">Proceed To Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    function updateCartTotals() {
        let subtotal = 0;
        $('.item-total').each(function() { subtotal += parseFloat($(this).text()); });
        $('#summary-subtotal').text(subtotal.toFixed(2));
        let shipping = subtotal > 0 ? 10 : 0;
        $('#summary-shipping').text(shipping.toFixed(2));
        $('#summary-total').text((subtotal + shipping).toFixed(2));
        if(subtotal === 0) { $('.btn-block').addClass('disabled'); }
    }

    function updateBackend(cart_id, qty, rowElement) {
        $.ajax({
            url: '../api/cart/update_cart.php',
            type: 'POST',
            data: { cart_id: cart_id, qty: qty },
            dataType: 'json',
            success: function(res) {
                if(res.status === 'success') {
                    let price = parseFloat(rowElement.find('.item-price').text());
                    rowElement.find('.item-total').text((price * qty).toFixed(2));
                    updateCartTotals();
                }
            }
        });
    }

    function removeCartItem(cart_id, rowElement) {
        Swal.fire({
            title: 'Remove item?',
            text: "Are you sure you want to remove this?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33', cancelButtonColor: '#3085d6', confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../api/cart/remove_cart.php',
                    type: 'POST', data: { cart_id: cart_id }, dataType: 'json',
                    success: function(res) {
                        if(res.status === 'success') {
                            rowElement.fadeOut(300, function() { $(this).remove(); updateCartTotals(); });
                            $('#cart-badge').text(res.cart_count);
                        }
                    }
                });
            } else {
                let input = rowElement.find('.qty-input');
                if(input.val() == 0) input.val(1);
            }
        });
    }

    $('.btn-plus-cart').off('click').on('click', function(e) {
        e.preventDefault();
        let cart_id = $(this).data('id');
        let input = $(this).closest('.quantity').find('.qty-input');
        let qty = parseInt(input.val()) + 1;
        input.val(qty);
        updateBackend(cart_id, qty, $(this).closest('tr'));
    });

    $('.btn-minus-cart').off('click').on('click', function(e) {
        e.preventDefault();
        let cart_id = $(this).data('id');
        let input = $(this).closest('.quantity').find('.qty-input');
        let qty = parseInt(input.val());
        if (qty > 1) {
            qty = qty - 1;
            input.val(qty);
            updateBackend(cart_id, qty, $(this).closest('tr'));
        } else if (qty === 1) {
            input.val(0);
            removeCartItem(cart_id, $(this).closest('tr'));
        }
    });

    $('.btn-remove').off('click').on('click', function(e) {
        e.preventDefault();
        removeCartItem($(this).data('id'), $(this).closest('tr'));
    });
});
</script>
<?php include '../layouts/footer.php'; ?>