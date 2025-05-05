<?php
//signup
session_start();
try {
    $pdo = new PDO("mysql:host=localhost;dbname=eCommerce_auth", "root", "");
   
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if (isset($_POST['signup'])) {
    $email = $_POST['email'];
    $password = $_POST['motdepasse'];
    $full_name = $_POST['full_name'];

    // Vérifier si l'utilisateur existe déjà
    $stmt = "SELECT * FROM users WHERE email = '$email'";
    $result = $pdo->query($stmt);

    if ($result && $result->rowCount() > 0) {
        $erreur = "Cet utilisateur existe déjà.";
    } else {
        // Insérer l'utilisateur dans la base de données
        $stmt = "INSERT INTO users (email, password, full_name) VALUES ('$email', '$password', '$full_name')";
        if ($pdo->exec($stmt)) {
            header("Location: login.php");
            exit;
        } else {
            $erreur = "Erreur lors de l'inscription.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup</title>
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>
        <?php if (isset($erreur)) { echo "<p style='color:red;'>$erreur</p>"; } ?>
        <form method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="motdepasse" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="motdepasse" name="motdepasse" required>
            </div>
            <div class="mb-3">
                <label for="full_name" class="form-label">Nom complet</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required>
            </div>
            <button type="submit" name="signup" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-+oP4x2j6z5v
    5+oP4x2j6z5v5+oP4x2j6z5v5+oP4x2j6z5v5+oP4x2j6z5v" crossorigin="anonymous"></script>
    
</body>
</html>