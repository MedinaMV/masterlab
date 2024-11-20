<?php session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header('Location: login.php');
  exit;
}

include('header.php');
include('db.php'); ?>

<div class="container my-5">
  <div class="row">
    <?php
    $db = db_connect();
    $id = $_GET['id'];
    $coche = $db->query('SELECT * FROM coches WHERE id = ' . $id)->fetch_array();


    if ($coche) {
      echo '<div class="col-md-6 col-12 mb-4">
                <img src="imgs/' . $coche['foto'] . '" class="img-fluid car-image" alt="' . $coche['marca'] . '">
                <div class="mt-3">
                  <h4>Usuarios que han dado "me gusta"</h4>';

      $likesQuery = $db->query('SELECT u.username FROM likes l JOIN users u ON l.user_id = u.id WHERE l.car_id = ' . $id);
      while ($like = $likesQuery->fetch_assoc()) {
        echo '<a href="public_profile.php?username=' . $like['username'] . '" class="badge bg-primary me-1 mb-1">' . $like['username'] . '</a>';
      }

      echo '</div>';

      $hasLikedQuery = $db->query('SELECT * FROM likes WHERE user_id = (SELECT id FROM users WHERE username = "' . $_SESSION['username'] . '") AND car_id = ' . $id);
      $hasLiked = $hasLikedQuery->num_rows > 0;

      echo '<form action="like_action.php" method="post" class="mt-3">
              <input type="hidden" name="car_id" value="' . $id . '">
              <input type="hidden" name="username" value="' . $_SESSION["username"] . '">
              <button type="submit" class="btn btn-' . ($hasLiked ? 'danger' : 'success') . '">' .
        ($hasLiked ? 'Ya no me gusta' : 'Me gusta') . '</button>
            </form>';

      echo '</div>';

      echo '<div class="col-md-6 col-12 d-flex flex-column">
                <div class="info-box mb-3 p-3 bg-light">
                  <h3>' . $coche['marca'] . '</h3>
                  <p><strong>Año:</strong> ' . $coche['anio'] . '</p>
                  <p><strong>Modelo:</strong> <div id="carmodel">' . $coche['modelo'] . '.txt</div></p>
                  <p><strong>Precio:</strong> €' . $coche['precio'] . '</p>
                </div>
                <div class="desc-box p-3 bg-light">
                  <h4>Descripción</h4>
                <div id="car-description"></div>';
      echo '  </div>
              </div>';

      echo '<div class="mt-3">
              <button onclick="window.location.href=\'index.php\'" class="btn btn-secondary">Volver</button>
            </div>';
    } else {
      echo '<p>Coche no encontrado.</p>';
    }
    ?>
  </div>
</div>

<style>
</style>

<script src="js/cardetails.js"></script>

<?php include 'footer.php'; ?>
