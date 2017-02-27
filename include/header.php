<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Vinyl'Shop</title>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    
    <nav class="navbar navbar-default navbar-fixed-top">
     <div class="container">
       <div class="navbar-header">
         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
           <span class="sr-only">Toggle navigation</span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="index">Vinyl' Shop</a>
       </div>
       <div id="navbar" class="collapse navbar-collapse">
         <ul class="nav navbar-nav">
             <li class="dropdown">
                 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <?php echo $authentication->getUsername() ?> <span class="caret"></span></a>
               <ul class="dropdown-menu">
                   <?php if($authentication->isGranted()) : ?>
                   <li><a href="admin/index"><span class="glyphicon glyphicon-wrench"></span> Administration</a></li>
                   <?php endif; ?>
                   <li><a href="controllers/logout"><span class="glyphicon glyphicon-share"></span> Se déconnecter</a></li>
               </ul>
             </li>
             <li><a href="index"><span class="glyphicon glyphicon-home"></span></a></li>
             <?php foreach($categories as $category) : ?>
             <li><a href="index?cat=<?php echo $category["id"] ?>"><?php echo $category["nom"] ?></a></li>
             <?php endforeach; ?>
             <li><a href="cart">Panier <span class="badge"><?php echo $cart->productsNumber() ?></span></a></li>
         </ul>
         <form class="navbar-form navbar-left" role="search" action="">
           <div class="form-group">
               <input type="text" name="q" class="form-control input-search" placeholder="Rechercher">
           </div>
           <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
         </form>
       </div><!--/.nav-collapse -->
     </div>
   </nav>
      
    <div class="container">

    <div class="starter-template">
    <div class="row">