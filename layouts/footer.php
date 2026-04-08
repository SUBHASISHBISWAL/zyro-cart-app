<div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <div class="col-md-3">
                    <h3 class="fw-bold">
                        <span class="text-primary">●</span>.ZyroCart
                    </h3>
                </div>

                <p>ZyroCart is your one-stop destination for premium products at reasonable prices. We are dedicated to providing the best shopping experience with quality and trust.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Bhubaneswar, Odisha, India</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>support@zyrocart.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+91 98765 43210</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="<?php echo $base; ?>index.php"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="<?php echo $base; ?>pages/shop.php"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-dark mb-2" href="<?php echo $base; ?>pages/detail.php"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-dark mb-2" href="<?php echo $base; ?>pages/cart.php"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-dark mb-2" href="<?php echo $base; ?>pages/checkout.php"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-dark" href="<?php echo $base; ?>pages/contact.php"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Help & Support</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="<?php echo $base; ?>pages/faqs.php"><i class="fa fa-angle-right mr-2"></i>FAQs</a>
                            <a class="text-dark mb-2" href="<?php echo $base; ?>pages/help.php"><i class="fa fa-angle-right mr-2"></i>Help Center</a>
                            <a class="text-dark mb-2" href="<?php echo $base; ?>pages/support.php"><i class="fa fa-angle-right mr-2"></i>Support</a>
                            <a class="text-dark mb-2" href="<?php echo $base; ?>pages/contact.php"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Newsletter</h5>
                        <form action="">
                            <div class="form-group">
                                <input type="text" class="form-control border-0 py-4" placeholder="Your Name" required="required" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control border-0 py-4" placeholder="Your Email"
                                    required="required" />
                            </div>
                            <div>
                                <button class="btn btn-primary btn-block border-0 py-3" type="submit">Subscribe Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy; <a class="text-dark font-weight-semi-bold" href="#">ZyroCart</a>. All Rights Reserved.<br>
                    Developed with <i class="fa fa-heart text-primary"></i> by <strong>Ashique, Subashis & Suchismita</strong><br>
                    <span class="text-muted small">Under the guidance of <strong>Prasenjit Sir</strong></span>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="<?php echo $base; ?>assets/img/payments.png" alt="Payments">
            </div>
        </div>
    </div>
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $base; ?>assets/lib/easing/easing.min.js"></script>
    <script src="<?php echo $base; ?>assets/lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="<?php echo $base; ?>assets/mail/jqBootstrapValidation.min.js"></script>
    <script src="<?php echo $base; ?>assets/mail/contact.js"></script>

    <script src="<?php echo $base; ?>assets/js/main.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function getFilterProduct(inputKeyword){
        console.log(inputKeyword,'::::::::::inputKeyword')
if(inputKeyword.length > 2){
        
            $.ajax({
                url: '../api/products/filter_products.php',
                type: 'GET',
                data: { inputKeyword: inputKeyword},
                dataType: 'json',
                success: function(response) {
                    if (response.length === 0) {
                        $('#filter-products').html('<li">No products found.</li>');
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
                         <li><a href="<?php echo $base; ?>pages/detail.php?id=${product.id}"><span><img src="${img}"></span><span class="search-text">${product.name}</span></a></li>
                      `;
                    });

                    $('#filter-products').html(html);
                }
            });
}else{
     $('#filter-products').html('');
}
    }
    </script>
</body>