<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  header('Location: /');
  exit;
}

include('utils.php');
include("db.php");
include("serde.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = sanitizeInput($_POST['username']);
  $password = sanitizeInput($_POST['password']);

  $conn = db_connect();
  $sql = "SELECT id, pass, is_admin, weather FROM users WHERE username='$username'";
  $result = $conn->query($sql);

  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if (md5($password) === $row['pass']) {
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $username;

      /* $serinfo = ser($username, $row['is_admin'], $row['weather']); */
      /* setcookie("user_info", $serinfo, time() + 36000, "/"); */
      create_cookie($username);
      header('Location: /');
      exit();
    }
  } else {
    $error = 'Usuario o contraseña incorrectos';
  }
}

include('header.php');
?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h2 class="text-center mb-4">Iniciar Sesión</h2>
      <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $error; ?>
        </div>
      <?php endif; ?>
      <form action="" method="post">
        <div class="form-group">
          <label for="username">Usuario</label>
          <input type="text" class="form-control" id="username" name="username" required autocomplete="off">
        </div>
        <div class="form-group">
          <label for="password">Contraseña</label>
          <input type="password" class="form-control" id="password" name="password" required autocomplete="off">
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-send">Iniciar Sesión</button>
      </form>
    </div>
  </div>
  <div class="container mt-4 text-center">
    <p>¿No tienes una cuenta? <a href="register.php">Crea tu perfil aquí</a></p>
  </div>

</div>

<?php include('footer.php'); ?>
