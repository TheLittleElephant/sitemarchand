<?php
require_once '../autoloader.php';
$db = new Database();
$authentication = new Authentication($db);
$messages = new Messages();
if(!$authentication->isGranted() || $authentication->sessionTimeIsOver()) {
    $authentication->logout();
    header("Location: ../login");
}
$dashboard = new Dashboard($db, $messages);
$categories = $db->getCategories();
//On récupère la position de la première ligne grâce au numéro de page ($_GET) passé en paramètre : "page"
$limit = $dashboard->paginator("page");
//On récupère les produits
$products = $db->getProductsWithLimit($limit);
//On récupère les utilisateurs
$users = $db->getUsers();
//On récupère les rôles possibles 
$roles = $db->getUsersRoles();
//On récupère le nom de toutes les images
$images = $dashboard->getImagesFilenames();
//On vérifie s'il n'y a pas de produits épuiséset si c'est le cas on prévient l'utilisateur
$dashboard->checkProductsWithEmptyStock($messages);
include 'include/header.php';
$messages->show(); 
if(isset($_GET["q"]) && !empty($_GET["q"])) {
    $keywords = htmlspecialchars($_GET["q"]);
    $products = $dashboard->search($keywords);
}
?>

<div>
  
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#updateProduct" aria-controls="updateProduct" role="tab" data-toggle="tab">Produits</a></li>
    <li role="presentation"><a href="#addProduct" aria-controls="addProduct" role="tab" data-toggle="tab">Ajouter un produit</a></li>
    <li role="presentation"><a href="#updateCategories" aria-controls="updateCategories" role="tab" data-toggle="tab">Catégories</a></li>
    <li role="presentation"><a href="#updateUsers" aria-controls="addUsers" role="tab" data-toggle="tab">Utilisateurs</a></li>
  </ul>

  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="updateProduct">
        <br>
         <table class="table table-responsive table-striped table-condensed">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Image</th>
                          <th>Nom</th>
                          <th>Famille</th>
                          <th>Description</th>
                          <th>Prix</th>
                          <th>Stock</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($products as $product) : ?>
                      <form action="controllers/updateProduct" method="post">
                              <tr class="<?php echo ($product["stock"] == 0) ? "danger" : "" ?>">
                                  <td><?php echo $product["id"] ?></td>
                                  <td>
                                      <select name="image" class="form-control">
                                      <?php for($i = 0; $i < count($images); $i++) : ?>
                                        <option value="<?php echo $images[$i] ?>" <?php echo ($images[$i] == $product["image"]) ? "selected" : '' ?>><?php echo $images[$i] ?></option>
                                      <?php endfor; ?>
                                      </select> 
                                  </td>
                                  <td><input type="text" name="name" value="<?php echo $product["nom"] ?>"></td>
                                  <td>
                                      <select name="category" class="form-control">
                                      <?php foreach($categories as $categorie) : ?>
                                        <option value="<?php echo $categorie["id"] ?>" <?php echo ($categorie["nom"] == $product["nomFamille"]) ? "selected" : '' ?>><?php echo $categorie["nom"] ?></option>
                                      <?php endforeach; ?>
                                      </select> 
                                  </td>
                                  <td><textarea rows="1" cols="10" name="description"><?php echo $product["description"] ?></textarea></td>
                                  <td><input type="text" name="price" value="<?php echo $product["prix"] ?>"> €</td>
                                  <td><input type="number" name="stock" min="1" max="100" class="form-control" value="<?php echo $product["stock"] ?>"></td>
                                  <td>
                                      <input type="hidden" name="id" value="<?php echo $product["id"] ?>">
                                      <button type="submit" class="btn btn-primary" name="submit"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                                      <button type="submit" class="btn btn-danger" name="submit" formaction="controllers/deleteProduct"><span class="glyphicon glyphicon-remove"></span> Supprimer</button>
                              </tr>
                          </form>
                     <?php endforeach; ?>
                  </tbody>
              </table>
              <nav>
                  <ul class="pagination">
                      <li>
                          <a href="index?page=1" aria-label="Précédent">
                              <span aria-hidden="true">&laquo;</span>
                          </a>
                      </li>
                      <?php for($i = 1; $i <= $dashboard->getPaginatorPagesNumber($db); $i++) : ?>
                      <li><a href="index?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                      <?php endfor; ?>
                      <li>
                          <a href="index?page=<?php echo $dashboard->getPaginatorPagesNumber($db) ?>" aria-label="Suivant">
                              <span aria-hidden="true">&raquo;</span>
                          </a>
                      </li>
                  </ul>
              </nav>
    </div>
    <div role="tabpanel" class="tab-pane" id="addProduct">
         <br>
         <form class="form-horizontal add-product-form" action="controllers/addProduct" method="post">
                  <div class="form-group">
                      <label for="image">Image du produit</label>
                      <div class="input-group">
                          <select id="image" class="form-control" name="image">
                              <?php for ($i = 0; $i < count($images); $i++) : ?>
                                  <option value="<?php echo $images[$i] ?>"><?php echo $images[$i] ?></option>
                              <?php endfor; ?>
                          </select>
                          <div class="input-group-addon">.jpg</div>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="name">Nom du produit</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Nom du produit">
                  </div>
                  <div class="form-group">
                   <label for="category">Famille du produit</label>
                   <select name="category" id="category" class="form-control">
                        <?php foreach($categories as $categorie) : ?>
                          <option value="<?php echo $categorie["id"] ?>"><?php echo $categorie["nom"] ?></option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                    <div class="form-group">
                      <label for="description">Description du produit</label>
                      <textarea rows="4" cols="8" class="form-control" id="description" name="description" placeholder="Description du produit"></textarea>
                  </div>  
                  <div class="form-group">
                      <label for="price">Prix du produit</label>
                      <div class="input-group">
                          <input type="text" class="form-control" id="price" placeholder="Prix du produit" name="price">
                          <div class="input-group-addon">€</div>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="stock">Stock</label>
                      <input type="number" min="1" max="100" value="1" class="form-control" id="stock" name="stock">
                  </div>
                  
                  <button type="submit" name="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span>  Valider</button>
              </form>
    </div>
    <div role="tabpanel" class="tab-pane" id="updateCategories">
        <br>
        <form class="form-inline" action="controllers/addCategory" method="post">
            <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom de la catégorie">
            </div>
            <button type="submit" name="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span>   Ajouter</button>
        </form>
         <table class="table table-responsive table-striped table-condensed">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Intitulé</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($categories as $category) : ?>
                  <form action="controllers/updateCategory" method="post">
                              <tr>
                                  <td><?php echo $category["id"] ?></td>
                                  <td>
                                      <input type="text" name="name" value="<?php echo $category["nom"] ?>">
                                      <input type="hidden" name="id" value="<?php echo $category["id"] ?>">
                                      <button type="submit" class="btn btn-primary" name="submit"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                                      <button type="submit" class="btn btn-danger" name="submit" formaction="controllers/deleteCategory"><span class="glyphicon glyphicon-remove"></span> Supprimer</button>
                                  </td>
                              </tr>
                          </form>
                     <?php endforeach; ?>
                  </tbody>
              </table>
    </div>
      <div role="tabpanel" class="tab-pane" id="updateUsers">
          <br>
          <form class="form-inline" action="controllers/addUser" method="post">
            <div class="form-group">
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Nom">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="fname" name="fname" placeholder="Prénom">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="username" name="username" placeholder="Nom d'utilisateur">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="password" name="password" placeholder="Mot de passe">
            </div>
             <div class="form-group">
                <select name="role" class="form-control" id="role">
                <?php foreach($roles as $role) : ?>
                  <option value="<?php echo $role["role"] ?>"><?php echo $role["role"] ?></option>
                <?php endforeach; ?>
                </select> 
             </div>
            <button type="submit" name="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span>   Ajouter</button>
        </form>
        <br>
         <table class="table table-responsive table-striped table-condensed">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Nom</th>
                          <th>Prénom</th>
                          <th>Nom d'utilisateur</th>
                          <th>Mot de passe</th>
                          <th>Rôle</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($users as $user) : ?>
                      <form action="controllers/updateUser" method="post">
                              <tr>
                                  <td><?php echo $user["id"] ?></td>
                                  <td><input type="text" name="lname" value="<?php echo $user["nom"] ?>"></td>
                                  <td><input type="text" name="fname" value="<?php echo $user["prenom"] ?>"></td>
                                  <td><input type="text" name="username" value="<?php echo $user["login"] ?>"></td>
                                  <td><input type="text" name="password" value="<?php echo $user["mdp"] ?>"></td>
                                  <td>
                                      <select name="role" class="form-control">
                                      <?php foreach($roles as $role) : ?>
                                        <option value="<?php echo $role["role"] ?>" <?php echo ($user["role"] == $role["role"]) ? "selected" : '' ?>><?php echo $role["role"] ?></option>
                                      <?php endforeach; ?>
                                      </select> 
                                  </td>
                                  <td>
                                      <input type="hidden" name="id" value="<?php echo $user["id"] ?>">
                                      <button type="submit" class="btn btn-primary" name="submit"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                                      <button type="submit" class="btn btn-danger" name="submit" formaction="controllers/deleteProduct"><span class="glyphicon glyphicon-remove"></span> Supprimer</button>
                              </tr>
                          </form>
                     <?php endforeach; ?>
                  </tbody>
              </table>
      </div>
  </div>

</div>

<?php
include 'include/footer.php';