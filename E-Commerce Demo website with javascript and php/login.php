<?php
session_start();
try {
  $pdo = new PDO("mysql:host=localhost;dbname=eCommerce_auth", "root", "");
  $users = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
  echo '<pre>';
  print_r($users);
  echo '</pre>';
} catch (PDOException $e) {
  die("Erreur de connexion : " . $e->getMessage());
}

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['motdepasse'];

  $stmt = "SELECT * FROM users WHERE email = '$email'";
  $result = $pdo->query($stmt);
  echo '<pre>';
  print_r($result);
  echo '</pre>';


  if ($result && $result->rowCount() > 0) {
    $user = $result->fetch(PDO::FETCH_ASSOC);

    if ($password === $user["password"]) {
      $_SESSION["email"] = $user["email"];
      $_SESSION["name"] = $user["full_name"];

      // Créer un cookie
      setcookie("nom_utilisateur", $user["full_name"], time() + 86400);

      header("Location: index.php");
      exit;
    } else {
      $erreur = "Mot de passe incorrect.";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>login</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>

  <!-- Formulaire HTML -->
  <form method="post">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="motdepasse" placeholder="Mot de passe" required>
    <button type="submit" name="login">Se connecter</button>
    <a href="signup.php">S'inscrire</a>
  </form>

  <?php if (isset($erreur)) echo "<p style='color:red;'>$erreur</p>"; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>