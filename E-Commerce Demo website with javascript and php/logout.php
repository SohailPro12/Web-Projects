<?php
session_start();
session_unset();
session_destroy();

// Supprimer le cookie
setcookie("nom_utilisateur", "", time() - 3600);

header("Location: login.php");
exit;
