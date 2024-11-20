<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header('Location: login.php');
  exit;
}

include('header.php');
include('db.php');
include('utils.php');

$db = db_connect();
$username = $_GET['username'];
$query = $db->query('SELECT username, name, description, image FROM users WHERE username = "' . $username . '"');

if ($query->num_rows === 0) {
  echo '<div class="container my-5"><p>No se encontraron datos para este usuario.</p></div>';
  include('footer.php');
  exit;
}

$user = $query->fetch_assoc();
?>

<div class="container my-5">
  <div class="row">
    <div class="col-md-4 text-center">
      <img src="imgs/users/<?php echo $user['image']; ?>" alt="Foto de perfil" class="img-fluid rounded">
    </div>
    <div class="col-md-8">
      <h2>Perfil público de <?php echo sanitizeInput($user['name']); ?></h2>
      <ul class="list-unstyled">
        <li><strong>Nombre de usuario:</strong> <?php echo sanitizeInput($user['username']); ?></li>
        <li><strong>Descripción:</strong> <?php echo sanitizeInput($user['description']); ?></li>
      </ul>
    </div>
  </div>
</div>

<?php
include('footer.php');
?>
