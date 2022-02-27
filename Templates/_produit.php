<!-- product starts -->

<!-- Display all the details about the selected product -->
<?php

    // Get the selected item through the url
    if(isset($_GET['item_id']) && isset($_GET['categorie_id'])) {
        $item_id = $_GET['item_id'];
        $categorie_id = $_GET['categorie_id'];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['addToCart_btn'])) {
            echo $cart->addToCart($_POST['customerID'], $_POST['productID']);
        }

        if(isset($_POST['like_submit'])) {
            echo $product->addLike($_POST['customerID'], $_POST['productID']);
        }

        if(isset($_POST['saveforLater_btn'])) {
            echo $cart->addToWishlist($_POST['customerID'], $_POST['productID']);
        }
    }

    if(isset($_SESSION['user'])) {
        // Get all the ids of the items in the table panier
        $in_cart = $cart->getCart_product_ids($product->getProducts('panier', $_SESSION['user']));

        // Get all the ids of the items in the table envies
        $in_wishlist = $cart->getWishlist_product_ids($product->getProducts('envies', $_SESSION['user']));

        // Get all the ids of the items in the table jaime
        $likeUsers = $product->getLikesUser($product->getProducts('jaime', $_SESSION['user']));
    } else {
        $in_cart = $cart->getCart_product_ids($product->getProducts('panier'));

        // Get all the ids of the items in the table envies
        $in_wishlist = $cart->getWishlist_product_ids($product->getProducts('envies'));

        // Get all the ids of the items in the table jaime
        $likeUsers = $product->getLikesUser($product->getProducts('jaime'));
    }



    foreach($product->getProducts() as $item) {
        if($item['idProduit'] == $item_id) {
            ?>
            <section id="product" class="py-3">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <img src="<?php echo isset($item['imageProduit']) ? "images/products/".$item['imageProduit'] : "images/default.png"; ?>" alt="Produit" class="img-fluid">
                            <?php
                            
                            if(isset($_SESSION['user'])) {
                                ?>
                                <div class="form-row pt-4 font-size-16 font-baloo">
                                    <div class="col">
                                        <form method="post">
                                            <input type="hidden" name="productID" value="<?php echo isset($item['idProduit']) ? $item['idProduit'] : 1; ?>">
                                            <input type="hidden" name="customerID" value="<?php echo $_SESSION['user']; ?>">
                                            <a href="orderProduct.php?produitID=<?php echo $item['idProduit']; ?>" class="btn btn-primary form-control"><img src="./images/shopping-cart.png" alt="">&nbsp;&nbsp;Commande express</a>
                                        </form>
                                    </div>
                                    <div class="col">
                                        <form method="post">
                                            <input type="hidden" name="productID" value="<?php echo isset($item['idProduit']) ? $item['idProduit'] : 1; ?>">
                                            <input type="hidden" name="customerID" value="<?php echo $_SESSION['user']; ?>">
                                            <?php
                                            if(count($in_cart) == 0 && count($in_wishlist) == 0) {
                                              ?>
                                              <button type="submit" name="addToCart_btn" class="btn btn-warning form-control"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Ajouter au panier</button>
                                              <?php
                                            } else {
                                                // If the cart is not empty and the product is found in the cart, change the button
                                                if (count($in_cart) != 0 && in_array($item['idProduit'], $in_cart)) {
                                                  ?>
                                                  <button type="submit" class="btn btn-success form-control" disabled><i class="fas fa-check-double"></i>&nbsp;&nbsp;Dans mon panier</button>
                                                  <?php
                                                } else {
                                                  // If the wishlist is not empty and the product is found in the wishlist, change the button
                                                  if(count($in_wishlist) != 0 && in_array($item['idProduit'], $in_wishlist)) {
                                                    ?>
                                                    <button type="submit" class="btn btn-success form-control" disabled><i class="fas fa-check-double"></i>&nbsp;&nbsp;Dans mes envies</button>
                                                    <?php
                                                  } else {
                                                    // Else let the standard button
                                                    ?>
                                                    <button type="submit" name="addToCart_btn" class="btn btn-warning form-control"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Ajouter au panier</button>
                                                    <?php
                                                  }
                                                }
                                            }
                                            ?>
                                        </form>
                                    </div>
                                    <div class="col">
                                        <form method="post">
                                            <input type="hidden" name="productID" value="<?php echo isset($item['idProduit']) ? $item['idProduit'] : 1; ?>">
                                            <input type="hidden" name="customerID" value="<?php echo $_SESSION['user']; ?>">
                                            <?php
                                            if($likeUsers != null) {
                                                if(in_array($item['idProduit'], $likeUsers)) {
                                                ?>
                                                <button type="button" class="btn btn-danger form-control"><i class="fas fa-heart"></i>&nbsp;&nbsp;J'ai aimé</a>
                                                <?php
                                                } else {
                                                ?>
                                                <button type="submit" name="like_submit" class="btn btn-light text-danger border-danger form-control"><i class="fas fa-heart"></i>&nbsp;&nbsp;J'aime</button>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <button type="submit" name="like_submit" class="btn btn-light text-danger border-danger form-control"><i class="fas fa-heart"></i>&nbsp;&nbsp;J'aime</button>
                                                <?php
                                            }
                                            ?>
                                        </form>
                                    </div>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="form-row pt-4 font-size-16 font-baloo">
                                    <div class="col">
                                        <a href="orderProduct.php?produitID=<?php echo $item['idProduit']; ?>" class="btn btn-info form-control font-size-20">Commandez maintenant</a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col-sm-6 py-5">
                            <h5 class="font-baloo font-size-20"><?php echo isset($item['nomProduit']) ? $item['nomProduit'] : "Produit"; ?></h5>
                            <?php
                                foreach($activeCategories as $categorie) {
                                    if($categorie['id'] == $categorie_id) {
                                        ?>
                                        <small>Catégorie: <?php echo $categorie['nom']; ?></small>
                                        <?php
                                    }
                                }
                            ?>
                            <div class="d-flex mt-2">
                                <div class="rating text-warning font-size-12">
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="far fa-star"></i></span>
                                </div>
                                <a href="#" class="px-2 font-raleway font-size-14"><?php echo $product->getAllLikes($item_id) != null ? count($product->getAllLikes($item_id)) : 0 ?> Like(s)</a>
                            </div>
                            <hr class="m-0">

                            <!-- Product price starts -->
                            <table class="my-3">
                                <tr class="font-raleway font-size-14">
                                    <!-- Fonctionnalité pour les périodes de Noël -->
                                    <!-- <td>M.R.P.</td> -->
                                    <!-- <td><s>XAF 0.00</s></td> -->
                                </tr>
                                <tr class="font-raleway font-size-14">
                                    <td>Prix unitaire: </td>
                                    <td class="font-size-20 text-danger">XAF <span><?php echo isset($item['prix']) ? $item['prix'] : 0.00; ?></span></td><!-- <small class="text-dark font-size-12">&nbsp;&nbsp;inclusive of all taxes</small> --></td>
                                </tr>
                                <!-- Fonctionnalité utie pour les réductions -->
                                <!-- <tr class="font-raleway font-size-14">
                                    <td>you saved: </td>
                                    <td><span class="font-size-16 text-success">$10.00</span></td>
                                </tr> -->
                            </table>
                            <!-- Product price ends -->

                            <!-- Policy starts -->
                            <div id="policy">
                                <div class="d-flex">
                                    <div class="return text-center mr-5">
                                        <div class="font-size-20 my-2 color-secondary">
                                            <span class="fas fa-shopping-cart border p-3 rounded-circle"></span>
                                        </div>
                                        <a href="#" class="font-raleway font-size-12">Passer<br>une commande</a>
                                    </div>
                                    <div class="return text-center mr-5">
                                        <div class="font-size-20 my-2 color-secondary">
                                            <span class="fas fa-money-bill border p-3 rounded-circle"></span>
                                        </div>
                                        <a href="#" class="font-raleway font-size-12">Paiement<br>OM ou MoMo</a>
                                    </div>
                                    <div class="return text-center mr-5">
                                        <div class="font-size-20 my-2 color-secondary">
                                            <span class="fas fa-truck border p-3 rounded-circle"></span>
                                        </div>
                                        <a href="#" class="font-raleway font-size-12">Livraison<br>à domicile</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Policy ends -->

                        </div>

                        <div class="col-12 mt-5">
                            <h6 class="font-rubik">description du produit</h6>
                            <hr>
                            <p class="font-raleway font-size-14"><?php echo isset($item['descriptionProduit']) ? $item['descriptionProduit'] : "Aucune description"; ?></p>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        }
    }
?>
<!-- product ends -->