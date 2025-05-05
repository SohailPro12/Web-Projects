<?php
session_start();
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<h3>Votre panier est vide.</h3>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
     <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">E-Commerce Demo</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <br><a href="logout.php">Se déconnecter</a>
      </div>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Produits</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cart.php">Panier</a>
          </li>
        </ul>
    </div>
  </nav>

<h3>Votre panier :</h3>
<table border="1" cellpadding="10">
  <tr>
    <th>Produit</th>
    <th>Prix</th>
    <th>Quantité</th>
    <th>Total</th>
  </tr>
  <?php
  $total = 0;
  foreach ($_SESSION['cart'] as $item) {
    $subtotal = $item['price'] * $item['quantity'];
    $total += $subtotal;
    echo "<tr>
            <td>{$item['title']}</td>
            <td>{$item['price']} €</td>
            <td>{$item['quantity']}</td>
            <td>{$subtotal} €</td>
          </tr>";
  }
  echo "<tr><td colspan='3'><strong>Total</strong></td><td><strong>{$total} €</strong></td></tr>";
  ?>
</table>
<a href="index.php" class="btn btn-primary mt-3">Continuer vos achats</a>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
