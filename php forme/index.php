<?php

$pdo = new PDO(
    "mysql: host=localhost;dbname=enset-2025",
    "root",
    ""
);
$stmt = $pdo->query("SELECT * FROM users");

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Create
if (isset($_POST['ajouter'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $role = $_POST['role'];
    $sql = "INSERT INTO users(`email`, `password`, `role`) VALUES('$email', '$pass', '$role')";
    $stmt = $pdo->query($sql);
    header('Location:index.php');
}
// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    print_r('id = ' . $id);
    $sql = "DELETE FROM users WHERE id = $id";
    $stmt = $pdo->query($sql);
    header('Location: index.php');
}
// edit
$editUser = null;
$editMode = false;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM users WHERE id = $id";
    $stmt = $pdo->query($sql);
    $editUser = $stmt->fetch(PDO::FETCH_ASSOC);
    $editMode = true;
}
// Update
if (isset($_POST['update'])) {
    $id = $_POST['idd'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $role = $_POST['role'];
    $sql = "UPDATE  users SET email='$email', password='$pass', role='$role' WHERE id=$id";
    $stmt = $pdo->query($sql);
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users list</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/darkly/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Users List</h1>
        <?php $editUser ?>
        <form action="index.php" method="post">
    <input type="hidden" name="idd" value="<?= $editUser['id'] ?? '' ?>">
    <input type="text" name="email" placeholder="Email" class="form-control mb-3" value="<?= $editUser['email'] ?? '' ?>">
    <input type="password" placeholder="Password" name="pass" class="form-control mb-3" value="<?= $editUser['password'] ?? '' ?>">
    <select name="role" class="form-select mb-3">
        <option value="guest" <?= isset($editUser) && $editUser['role'] == 'guest' ? 'selected' : '' ?>>Guest</option>
        <option value="author" <?= isset($editUser) && $editUser['role'] == 'author' ? 'selected' : '' ?>>Author</option>
        <option value="admin" <?= isset($editUser) && $editUser['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
    </select>
    <button class="btn btn-<?= $editMode ? 'warning' : 'success' ?>" name="<?= $editMode ? 'update' : 'ajouter' ?>">
        <?= $editMode ? 'Update' : 'Ajouter' ?>
    </button>
</form>

        <hr>
        <table class="table table-dark">
            <tr>
                <th>ID</th>
                <th>EMAIL</th>
                <th>PASSWORD</th>
                <th>ROLE</th>
                <th colspan="2" class="text-center">Actions</th>

            </tr>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['password'] ?></td>
                    <td><?= $user['role'] ?></td>
                    <td class="text-center">
                        <a onclick="f(event)" href="?delete=<?= $user['id'] ?>" class="btn btn-danger">X</a>
                    </td>
                    <td class="text-center">
                        <a href="?edit=<?= $user['id'] ?>" class="btn btn-primary">E</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
        <hr>
        <pre>
            <?php print_r($users); ?>
        </pre>
    </div>















    <script>
        function f(e) {
            e.preventDefault()
            if (confirm('Etes-cous sur de vouloir supprimer')) {
                location.href = e.target.href
            }
        }
    </script>
</body>

</html>