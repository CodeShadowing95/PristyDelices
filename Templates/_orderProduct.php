<?php
    if(isset($_GET['produitID'])) {
        $produitID = $_GET['produitID'];
    }
?>


<section id="order" class="py-5">
    <div class="container">
        <div class="row text-center">
            <?php
              foreach ($products as $item) {
                if($item['idProduit'] == $produitID) {
                  ?>
                  <div class="col-sm-5">
                    <img src="<?php echo isset($item['imageProduit']) ? "images/products/".$item['imageProduit'] : "images/default.png"; ?>" alt="produit" width="400px">
                  </div>

                  <div class="col-sm-7">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Produit:</label>
                          <div class="col-sm-9">
                            <p class="form-control"><?php echo $item['nomProduit']; ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Quantité:<sup class="text-danger font-weight-bold">*</sup></label>
                          <div class="qty col-sm-9">
                              <div class="px-4 d-flex font-raleway">
                                <button class="qtyUp border bg-light" data-id="<?php echo $item['idProduit']; ?>"><i class="fas fa-angle-up"></i></button>
                                <input class="qty-input border px-2 w-50 bg-light form-control" data-id="<?php echo $item['idProduit']; ?>" type="text" disabled value="1" placeholder="1">
                                <button class="qtyDown border bg-light" data-id="<?php echo $item['idProduit']; ?>"><i class="fas fa-angle-down"></i></button>
                              </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">P.U.:</label>
                          <div class="col-sm-9">
                            <p class="form-control">XAF <span class="cost" data-id="<?php echo $item['idProduit']; ?>"><?php echo $item['prix']; ?></span></p>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Total:</label>
                          <div class="col-sm-9">
                              <p class="form-control">XAF <span id="total-price"><?php echo $item['prix']; ?></span></p>
                          </div>
                        </div>
                      </div>
                  </div>
                  <hr class="pb-4">
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Nom:<sup class="text-danger font-weight-bold">*</sup></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required />
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Prénom:</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" />
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Email:</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" />
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Téléphone:<sup class="text-danger font-weight-bold">*</sup></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" required />
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group row">
                        <label class="col-sm-1 col-form-label" for="exampleTextarea1">Détails:</label>
                        <div class="col-sm-11">
                          <textarea class="form-control" id="exampleTextarea1" rows="4" placeholder="Détails supplémentaires concernant votre commande ou sa livraison"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <form action="" method="post">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check-double"></i>&nbsp;&nbsp;Valider ma commande</button>
                      </form>
                    </div>
                  </div>
                  </div>
                <?php
                }
              }
            ?>
        </div>
    </div>
</section>