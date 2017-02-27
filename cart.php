<?php
require_once 'autoloader.php';
$db = new Database();
$messages = new Messages();
$cart = new Cart($db, $messages);
$authentication = new Authentication($db);
if(!$authentication->isLogged() || $authentication->sessionTimeIsOver()) {
    header("Location: login");
}
$categories = $db->getCategories();
//On récupère le contenu du panier
$cartProducts = $cart->getCart();
include 'include/header.php';
?>
              <h3>Votre panier</h3>          
              <?php $messages->show() ?>
              <?php if(!empty($cartProducts)) : ?>
              <table class="table table-responsive table-striped table-condensed">
                  <thead>
                      <tr>
                          <th></th>
                          <th>Nom</th>
                          <th>Prix</th>
                          <th>Quantité</th>
                          <th>Sous-total</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($cartProducts as $reference => $cartProduct) : ?>
                          <form action="controllers/updateCart" method="post">
                              <tr>
                                  <td><img class="thumb" src="img/<?php echo $cartProducts[$reference]["image"] ?>.jpg"></td>
                                  <td><?php echo $cartProducts[$reference]["name"] ?></td>
                                  <td><?php echo $cartProducts[$reference]["price"] ?> €</td>
                                  <td><input type="number" min="1" class="quantity" name="quantity" value="<?php echo $cartProducts[$reference]["quantity"] ?>"></td>
                                  <td><?php echo $cartProducts[$reference]["subtotal"] ?> €</td>
                                  <td>
                                      <input type="hidden" name="id" value="<?php echo $cartProducts[$reference]["id"] ?>">
                                      <input type="hidden" name="index" value="<?php echo $cartProducts[$reference]["name"] ?>">
                                      <input type="hidden" name="name" value="<?php echo $cartProducts[$reference]["name"] ?>">
                                      <input type="hidden" name="price" value="<?php echo $cartProducts[$reference]["price"] ?>">
                                      <button type="submit" class="btn btn-primary" name="submit"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                                      <button type="submit" class="btn btn-danger" name="submit" formaction="controllers/deleteFromCart"><span class="glyphicon glyphicon-remove"></span> Supprimer</button>
                                  </td>
                              </tr>
                          </form>
                     <?php endforeach; ?>
                  </tbody>
              </table>
              <div class="panel panel-primary">
                  <div class="panel-heading">
                      <h4>Récapitulatif</h4>
                  </div>
                    <div class="panel-body">
                        <h4>Prix total : <?php echo $cart->totalPrice() ?> €</h4>
                        <h4>Nombre total de produits : <?php echo $cart->productsNumber() ?></h4>
                        <h3><a href="controllers/emptyCart" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>  Vider le panier</a>  <a href="controllers/cartCheckout" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span>  Valider le panier</a></h3>
                    </div>
              </div>
             
              <?php else : ?>
              <div class="alert alert-info" role="alert">
                  <i class="fa fa-shopping-basket"></i>
                  Votre panier est vide. <br>
                  Cherchez votre vieux tourne-disques...<br>
                  <a href="index?cat=<?php echo rand(1, 6) ?>" class="btn btn-primary">...et c'est parti !</a>
              </div>
              <?php endif; ?>
 
<?php
include 'include/footer.php';

