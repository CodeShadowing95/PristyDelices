<!-- Special price starts -->
<?php
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['addToCart_submit'])) {
      $cart->addToCart($_POST['customerID'], $_POST['productID']);
    }

    if(isset($_POST['like_submit'])) {
      echo $product->addLike($_POST['customerID'], $_POST['productID']);
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
  
?>

<?php
  foreach ($activeCategories as $categorie) {
    ?>
    <section class="special-prices" id="<?php echo str_replace(' ', '', $categorie['nom']); ?>">
      <div class="container py-5">
        <h4 class="font-rubik mb-3 font-weight-bold text-uppercase" style="font-size: 30px"><?php echo $categorie['nom']; ?></h4>
        <div class="grid">
          <?php
            $catProd = $product->getProductCategory($categorie['id']);
            // Randomize the products
            shuffle($catProd);
            // As array_map(...) does not allow to use external variables in it,
            // we must use the function "use ()" to add these variables in the function array_map(...)
            array_map(function ($item) use ($in_cart, $in_wishlist, $likeUsers) {
              ?>
              <div class="grid-item border mr-4 my-2">
                <div class="item py-2 px-2" style="width: 250px;">
                  <div class="product font-raleway">
                    <a href="<?php echo "produit.php?item_id=".$item['idProduit']."&categorie_id=".$item['idCategorie']; ?>"><img src="<?php echo ($item['imageProduit'] != '') ? "./images/products/".$item['imageProduit'] : "./images/default.png"; ?>" style="width: 500px; height: 250px;" alt="Produit" class="img-fluid" /></a>
                    <div class="text-center pt-2">
                        <h6 class="font-size-20" style="font-weight:800;"><?php echo isset($item['nomProduit']) ? $item['nomProduit'] : "Produit"; ?></h6>
                        <div class="rating text-warning font-size-12">
                          <span><i class="fas fa-star"></i></span>
                          <span><i class="fas fa-star"></i></span>
                          <span><i class="fas fa-star"></i></span>
                          <span><i class="fas fa-star"></i></span>
                          <span><i class="far fa-star"></i></span>
                        </div>
                        <div class="price py-2">
                          <span>XAF <?php echo isset($item['prix']) ? $item['prix'] : 0.00; ?>/-</span>
                        </div>
                        <?php
                        if(isset($_SESSION['user'])) {
                          ?>
                          <form method="post">
                            <input type="hidden" name="productID" value="<?php echo isset($item['idProduit']) ? $item['idProduit'] : 1; ?>">
                            <input type="hidden" name="customerID" value="<?php echo $_SESSION['user']; ?>">
                            <!-- Change the button "Ajouter au panier" to "Dans votre panier" when it is clicked -->
                            <?php
                              if(count($in_cart) == 0 && count($in_wishlist) == 0) {
                                ?>
                                <button type="submit" name="addToCart_submit" class="btn btn-warning font-size-12"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Ajouter au panier</button>
                                <?php
                              } else {
                                // If the cart is not empty and the product is found in the cart, change the button
                                if (count($in_cart) != 0 && in_array($item['idProduit'], $in_cart)) {
                                  ?>
                                  <button type="submit" class="btn btn-success font-size-12" disabled><i class="fas fa-check-double"></i>&nbsp;&nbsp;Dans mon panier</button>
                                  <?php
                                } else {
                                  // If the wishlist is not empty and the product is found in the wishlist, change the button
                                  if(count($in_wishlist) != 0 && in_array($item['idProduit'], $in_wishlist)) {
                                    ?>
                                    <button type="submit" class="btn btn-success font-size-12" disabled><i class="fas fa-check-double"></i>&nbsp;&nbsp;Dans mes envies</button>
                                    <?php
                                  } else {
                                    // Else let the standard button
                                    ?>
                                    <button type="submit" name="addToCart_submit" class="btn btn-warning font-size-12"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Ajouter au panier</button>
                                    <?php
                                  }
                                }
                              }
                            ?>
                            <a href="<?php echo "produit.php?item_id=".$item['idProduit']."&categorie_id=".$item['idCategorie']; ?>" class="btn btn-info font-size-12"><i class="fas fa-eye"></i></a>
                            <?php
                              if($likeUsers != null) {
                                if(in_array($item['idProduit'], $likeUsers)) {
                                  ?>
                                  <button type="button" class="btn btn-danger font-size-12" data-toggle="tooltip" data-placement="top" title="J'ai aimé"><i class="fas fa-heart"></i></button>
                                  <?php
                                } else {
                                  ?>
                                  <button type="submit" name="like_submit" class="btn btn-light text-danger border-danger font-size-12" data-toggle="tooltip" data-placement="top" title="J'aime"><i class="fas fa-heart"></i></button>
                                  <?php
                                }
                              } else {
                                ?>
                                <button type="submit" name="like_submit" class="btn btn-light text-danger border-danger font-size-12" data-toggle="tooltip" data-placement="top" title="J'aime"><i class="fas fa-heart"></i></button>
                                <?php
                              }
                            ?>
                          </form>
                          <?php
                        } else {
                          ?>
                          <a href="orderProduct.php?produitID=<?php echo isset($item['idProduit']) ? $item['idProduit'] : 1; ?>" class="btn btn-info font-size-12"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Commander</a>
                          <?php
                        }
                        ?>
                    </div>
                  </div>
                </div>
              </div>
              <?php
            }, $catProd);
          ?>
        </div>
      </div>
    </section>
    <?php
  }
?>
  
<!-- Special price ends -->