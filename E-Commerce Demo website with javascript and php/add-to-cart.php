<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$id = $_POST['id'];
$title = $_POST['title'];
$price = $_POST['price'];


$found = false;
foreach ($_SESSION['cart'] as &$item) {
    if ($item['id'] == $id) {
        $item['quantity'] += 1;
        $found = true;
        break;
    }
}

if (!$found) {
    $_SESSION['cart'][] = [
        'id' => $id,
        'title' => $title,
        'price' => $price,
        'quantity' => 1
    ];
}

echo "Produit Ajoute au panier!";
