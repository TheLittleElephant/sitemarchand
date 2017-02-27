<?php foreach($products as $product) : ?>
<div class="col-sm-6 col-md-4">
    <form action="controllers/addToCart" method="post">
    <div class="thumbnail">
        <?php echo ($product["stock"] == 0) ? '<div class="ribbon"><span>ÉPUISÉ</span></div>' : "" ?>
        <img src="img/<?php echo $product["image"] ?>.jpg" alt="...">
        <div class="caption">
            <h3><?php echo $product["nom"] ?></h3>
            <p><?php echo $product["description"] ?></p>
            <p class="price"><?php echo $product["prix"] ?> € </p>
            <p>Quantité :  <input class="quantity" type="number" min="1" name="quantity" value="1"></p>
            <p class="<?php echo ($product["stock"] == 0) ?  "red" : "green" ?>"><?php echo ($product["stock"] == 0)  ? "ÉPUISÉ" : $product["stock"]." EN STOCK" ?></p>
            <p>
                <input type="hidden" name="id" value="<?php echo $product["id"] ?>">
                <input type="hidden" name="index" value="<?php echo $product["nom"] ?>">
                <input type="hidden" name="name" value="<?php echo $product["nom"] ?>">
                <input type="hidden" name="price" value="<?php echo $product["prix"] ?>">
                <button type="submit" class="btn btn-primary" name="submit"><span class="glyphicon glyphicon-shopping-cart"></span> Ajouter au panier</button> 
                <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-info-sign"></span> Détails</button>
        </div>
    </div>
    </form>
</div>
<?php endforeach; 

