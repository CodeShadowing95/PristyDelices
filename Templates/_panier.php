<!-- Shopping cart section starts -->
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['delete_btn'])) {
            $deleted = $cart->deleteProduct($_POST['id_produit']);
        }

        if(isset($_POST['wishlist_btn'])) {
            // $cart->addToWishlist(1, $_POST['id_produit']);
            // $cart->deleteProduct($_POST['id_produit']);
            $cart->moveToWishlist($_POST['id_produit']);
        }
    }
?>

<section id="cart" class="py-3">
    <div class="container-fluid w-75">
        <h5 class="font-baloo font-size-20">Mon Panier</h5>

        <!-- Shopping cart item starts -->
        <div class="row">
            <div class="col-sm-9">
                <?php
                    // Get all the items in the table 'panier'
                    // Check whether the table of products is empty or not
                    if(count($product->getProducts('panier', $_SESSION['user'])) != 0){
                        // Access to each row of the table
                        foreach($product->getProducts('panier', $_SESSION['user']) as $item){
                            // Get each product by its id
                            $inCart = $product->getProduct($item['id_produit']);
                            // Display the datas through array_map
                            // array_prices will only get the price of each item
                            $array_prices[] = array_map(function ($item) use ($activeCategories, $product) {
                                ?>
                                <!-- cart item starts -->
                                <div class="row border-top py-3 mt-3">
                                    <div class="col-sm-3">
                                        <img src="<?php echo isset($item['imageProduit']) ? "images/products/".$item['imageProduit'] : "images/default.png"; ?>" style="height: 150px;" alt="In my cart" class="img-fluid">
                                    </div>
                                    <div class="col-sm-7">
                                        <h5 class="font-baloo font-size-20"><?php echo isset($item['nomProduit']) ? $item['nomProduit'] : "Mon choix"; ?></h5>
                                        <?php
                                            foreach($activeCategories as $categorie) {
                                                if($categorie['id'] == $item['idCategorie']) {
                                                    ?>
                                                    <small>Catégorie: <?php echo $categorie['nom']; ?></small>
                                                    <?php
                                                }
                                            }
                                        ?>
                                        <!-- Product rating starts -->
                                        <div class="d-flex mt-2">
                                            <div class="rating text-warning font-size-12">
                                            <span><i class="fas fa-star"></i></span>
                                            <span><i class="fas fa-star"></i></span>
                                            <span><i class="fas fa-star"></i></span>
                                            <span><i class="fas fa-star"></i></span>
                                            <span><i class="far fa-star"></i></span>
                                            </div>
                                            <a href="#" class="px-2 font-raleway font-size-14"><?php echo $product->getAllLikes($item['idProduit']) != null ? count($product->getAllLikes($item['idProduit'])) : 0 ?> Likes</a>
                                        </div>
                                        <!-- Product rating ends -->
            
                                        <!-- Product quantity starts -->
                                        <div class="qty d-flex pt-2">
                                            <div class="d-flex font-raleway w-25 mr-3">
                                                <button class="qty-up border bg-light" data-id="<?php echo $item['idProduit']; ?>"><i class="fas fa-angle-up"></i></button>
                                                <input type="text" data-id="<?php echo $item['idProduit']; ?>" name="qty" class="qty_input border px-2 w-100 bg-light" disabled value="1" placeholder="1">
                                                <button class="qty-down border bg-light" data-id="<?php echo $item['idProduit']; ?>"><i class="fas fa-angle-down"></i></button>
                                            </div>
                                            <form method="post">
                                                <input type="hidden" name="id_produit" value="<?php echo $item['idProduit']; ?>" />
                                                <button type="submit" name="delete_btn" class="btn font-baloo bg-danger text-white px-3 border-right mr-3">Supprimer</button>
                                            </form>

                                            <form method="post">
                                                <input type="hidden" name="id_produit" value="<?php echo $item['idProduit']; ?>" />
                                                <button type="submit" name="wishlist_btn" class="btn font-baloo bg-dark text-white">Enregistrer dans "Mes envies"</button>
                                            </form>
                                        </div>
                                        <!-- Product quantity ends -->
                                    </div>

                                    <div class="col-sm-2 text-right">
                                        <div class="font-baloo font-size-20 text-danger">
                                            XAF <span class="product_price" data-id="<?php echo $item['idProduit']; ?>"><?php echo isset($item['prix']) ? $item['prix'] : 0; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- cart item ends -->
                                <?php
                                return $item['prix'];
                            }, $inCart);
                        }
                    } else {
                        ?>
                        <div class="row border-top py-3 mt-3">
                            <div class="col-sm-12 text-center">
                                <img src="images/empty-cart.png" alt="empty-cart" class="img-fluid" style="height: 200px;">
                                <p class="font-baloo font-size-20 text-danger">Votre panier est vide.</p>
                            </div>
                        </div>
                        <?php
                    }
                ?>
            </div>
            <!-- Total section starts-->
            <div class="col-sm-3">
                <div class="sub-total text-center border mt-2">
                    <h6 class="font-size-12 font-raleway text-success py-3 px-3 font-weight-bold"><i class="fas fa-exclamation-triangle"></i>&nbsp;après confirmation, payez ensuite par OM ou MoMo auprès d'un stand d'envoi & retrait OM/MOMO; sans quoi la commande sera annulée après 1 heure.</h6>
                    <div class="border-top py-4">
                        <h5 class="font-baloo font-size-20">Total: <span class="text-danger">XAF <span id="deal-price"><?php echo isset($array_prices) ? $cart->getSum($array_prices) : 0;?></span></h5>
                        <button type="submit" class="btn btn-primary mt-3">Confirmer ma commande</button>
                    </div>
                </div>
            </div>
            <!-- Total section ends-->
        </div>
        <!-- Shopping cart item ends -->
    </div>
</section>
<!-- Shopping cart section ends -->
