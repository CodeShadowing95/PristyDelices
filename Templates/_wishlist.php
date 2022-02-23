<!-- Wishlist section starts -->
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['delete_btn'])) {
            $deleted = $cart->deleteProduct($_POST['id_produit'], 'envies');
        }

        if(isset($_POST['addToCart_btn'])) {
            $cart->moveToWishlist($_POST['id_produit'], 'panier', 'envies');
        }
    }
?>
<section id="wishlist" class="py-3">
    <div class="container-fluid w-75">
        <h5 class="font-baloo font-size-20">Mes envies&nbsp;&nbsp;<a href="#" class="text-dark font-size-16" data-toggle="modal" data-target="#hint"><i class="fas fa-exclamation-circle"></i></a></h5>

        <!-- Wishlist item starts -->
        <div class="row">
            <div class="col-sm-9">
                <?php
                // Get all the items in the table 'envies'
                // Check whether the table of products is empty or not
                if(count($product->getProducts('envies')) != 0) {
                    // Access to each row of the table
                    foreach($product->getProducts('envies') as $item) {
                        // Get the id
                        $id = $item['id_produit'];
                        // Get the product associated with the id_produit in table 'envies'
                        $inWishlist = $product->getProduct($id);
                        // Display the datas through array_map
                        array_map(function ($item) use ($activeCategories, $id, $product){
                            ?>
                            <!-- cart item starts -->
                            <div class="row border-top py-3 mt-3">
                                <div class="col-sm-3">
                                    <img src="<?php echo isset($item['imageProduit']) ? "images/products/".$item['imageProduit'] : "images/default.png"; ?>" style="height: 150px;" alt="In my wishlist" class="img-fluid">
                                </div>
                                <div class="col-sm-7">
                                    <h5 class="font-baloo font-size-20"><?php echo isset($item['nomProduit']) ? $item['nomProduit'] : "Mon envie"; ?></h5>
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
                                        <a href="#" class="px-2 font-raleway font-size-14"><?php echo $product->getAllLikes($id) != null ? count($product->getAllLikes($id)) : 0 ?> Likes</a>
                                    </div>
                                    <!-- Product rating ends -->
                
                                    <!-- Product quantity starts -->
                                    <div class="qty d-flex pt-2">
                                        <form method="post">
                                            <input type="hidden" name="id_produit" value="<?php echo $id; ?>">
                                            <button type="submit" name="delete_btn" class="btn font-baloo bg-danger text-white px-3 border-right mr-3">Supprimer</button>
                                        </form>

                                        <form method="post">
                                            <input type="hidden" name="id_produit" value="<?php echo $id; ?>">
                                            <button type="submit" name="addToCart_btn" class="btn font-baloo bg-warning text-dark">Ajouter dans "Mon Panier"</button>
                                        </form>
                                    </div>
                                    <!-- Product quantity ends -->
                                </div>

                                <div class="col-sm-2 text-right">
                                    <div class="font-baloo font-size-20 text-danger">
                                        XAF<span class="product_price"> 0</span>
                                    </div>
                                </div>
                            </div>
                            <!-- cart item ends -->
                            <?php
                        }, $inWishlist);
                    }
                } else {
                    ?>
                    <div class="row border-top py-3 mt-3">
                        <div class="col-sm-12 text-center">
                            <img src="./images/empty-wishlist.png" alt="empty-wishlist" class="img-fluid" style="height: 200px;">
                            <p class="font-baloo font-size-20 text-danger">Votre liste d'envies est vide</p>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

        <!-- Hint message modal -->
        <div class="modal fade" id="hint" tabindex="-1" role="dialog" aria-labelledby="labelHint" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="labelHint">Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <label for="hint">
                    La section "<span class="font-weight-bold">Mes envies</span>" sert juste à enregistrer les 
                    produits que vous souhaiteriez acheter plus tard. Tous les produits que vous mettrez ici 
                    n'impacterons pas sur les produits dans votre panier. Pour ajouter le produit de vos envies
                    dans le panier, cliquez juste sur le bouton "<span class="font-weight-bold">Ajouter au panier</span>".
                </label>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">OK</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Wishlist item ends -->
    </div>
</section>
<!-- Wishlist section ends -->