<?php
session_start();

if (!isset($_SESSION["email"])) {
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Commerce Demo</title>
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
            <a class="nav-link active" aria-current="page" href="#">Produits</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cart.php">Panier</a>
          </li>
        </ul>
    </div>
  </nav>


  <div class="container mt-4">
    <h2>Bienvenue, <?php echo $_SESSION["name"]; ?></h2>
    <p>Voici les produits disponibles :</p>
  </div>

  <!-- Main content wrapper -->
  <div class="container-fluid mt-4">
    <div class="row">

      <!-- Sidebar -->
      <div class="col-md-3">
        <div class="card p-3">
          <h5>Filtres</h5>
          <button class="btn btn-danger mb-3" id="reset-btn">Réinitialiser</button>

          <div class="mb-3">
            <label for="sort" class="form-label">Trier par</label>
            <select class="form-select" id="sort">
              <option selected> Titre (A-Z)</option>
              <option>Prix (Croissant)</option>
              <option>Prix (Décroissant)</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="search" class="form-label">Rechercher</label>
            <input type="text" class="form-control" id="search" placeholder="Rechercher un produit">
          </div>

        </div>
      </div>

      <!-- products -->
      <div class="col-md-9">
        <div class="row" id="product-container">


          <!-- Pagination Controls -->

        </div>
        <div class="d-flex justify-content-center mt-4">
          <button class="btn btn-outline-primary" id="prev-page">Précédent</button>
          <button class="btn btn-outline-primary" id="next-page">Suivant</button>
        </div>

      </div>
    </div>





  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => handleLoad());
    let currentPage = 1; // Start at page 1
    const productsPerPage = 20; // We want 20 products per page
    function handleLoad(sortOption = 'Titre (A-Z)', productName = '') {
      productContainer = document.getElementById('product-container');
      const url = 'https://api.daaif.net/products?limit=200&delay=3000';


      const xhr = new XMLHttpRequest()
      xhr.open('GET', url)
      xhr.onload = () => {
        if (xhr.status == 200) {
          const response = JSON.parse(xhr.responseText)
          products = response.products

          if (productName) {
            products = products.filter(product => product.title.toLowerCase().includes(productName));
          }

          if (sortOption == 'Prix (Croissant)') {
            products.sort((a, b) => a.price - b.price);
          } else if (sortOption == 'Prix (Décroissant)') {
            products.sort((a, b) => b.price - a.price);
          } else if (sortOption == 'Titre (A-Z)') {
            products.sort((a, b) => a.title.localeCompare(b.title));
          }

          // Pagination logic: Slice the products array to show only the current page's products
          const start = (currentPage - 1) * productsPerPage;
          const end = currentPage * productsPerPage;
          const productsToDisplay = products.slice(start, end);

          afficher(productsToDisplay); // Display the products for the current page

          // Enable or disable the pagination buttons
          document.getElementById('prev-page').disabled = currentPage === 1;
          document.getElementById('next-page').disabled = currentPage * productsPerPage >= products.length
        } else {
          console.error('Erreur lors de la récupération des produits:', xhr.statusText);
        }
      }
      xhr.send()
    }


    function afficher(products) {
      productContainer.innerHTML = '';
      products.forEach(product => {
        const productCard = document.createElement('div');
        productCard.classList.add('col-md-4', 'mb-4');

        productCard.innerHTML = `
                  <div class="card">
                      <img src="${product.thumbnail}" class="card-img-top" alt="${product.title}">
                      <div class="card-body">
                          <h5 class="card-title">${product.title}</h5>
                          <p class="card-text">${product.description.substring(0, 80)}...</p>
                          <p class="card-text text-primary fw-bold">${product.price}€</p>
                         <button class="btn btn-primary add-to-cart-btn"
        data-id="${product.id}"
        data-title="${product.title}"
        data-price="${product.price}">
  Ajouter au panier
</button>
                          </div>
                  </div>
              `;

        productContainer.appendChild(productCard);
      })
    
    
    
      document.querySelectorAll('.add-to-cart-btn').forEach(button => {
  button.addEventListener('click', (e) => {
    const id = e.target.getAttribute('data-id');
    const title = e.target.getAttribute('data-title');
    const price = e.target.getAttribute('data-price');

    // Envoi au serveur via fetch
    fetch('add-to-cart.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id=${id}&title=${encodeURIComponent(title)}&price=${price}`
    })
    .then(response => response.text())
    .then(result => {
      alert(result);  // Exemple : "Produit ajouté au panier !"
    });
  });
});

    }






    document.getElementById('reset-btn').addEventListener('click', () => reinitialiser());

    function reinitialiser() {
      document.getElementById('sort').value = 'Titre (A-Z)';
      document.getElementById('search').value = '';

      handleLoad();
    }


    document.getElementById('sort').addEventListener('change', (event) => sort(event));

    function sort(event) {
      const selectedsort = event.target.value;
      handleLoad(selectedsort);
    }


    document.getElementById('search').addEventListener('input', (event) => search(event));

    function search(event) {
      const productName = event.target.value.toLowerCase();
      handleLoad(undefined, productName);
    }

    document.getElementById('prev-page').addEventListener('click', () => {
      if (currentPage > 1) {
        currentPage--;
        handleLoad();
      }
    });

    document.getElementById('next-page').addEventListener('click', () => {
      currentPage++;
      handleLoad();
    });



  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>