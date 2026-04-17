  <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <?php
            include './api/config/db.php';
             $cat_query = "SELECT * FROM `categories` ORDER by name DESC limit 0,6";
             $cat_result = $conn->query($cat_query);
        
         if ($cat_result->num_rows > 0) {
            while ($row = $cat_result->fetch_assoc()) { ?>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                     <?php
                                  
                                    $cat_id = $row['id'];
                                     $image = isset($row['image']) ? $row['image'] : null;
                                    $cat_wise_pr_query = "SELECT count(*) as product_count FROM `shop_products` where category_id =".$cat_id ."";
                                    $cat_products_res = $conn->query($cat_wise_pr_query);
                                    $cat_wise_prod = $cat_products_res->fetch_assoc();
                                    
                                    ?>
                    <p class="text-right"><?php echo $cat_wise_prod['product_count'];?> Products</p>
                    <a href="<?php echo $base; ?>pages/shop.php?cat_id=<?php echo $cat_id;?>" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="<?php echo ($image !=null) ? $image : "assets/img/no-image.jpg" ?>" alt="">
                    </a>
                    <h5 class="font-weight-semi-bold m-0"><?php echo $row['name'];?></h5>
                </div>
            </div>
          <?php } } ?>
        </div>
    </div>