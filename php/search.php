<?php
include('header.php');
include('utils.php');

// $searchQuery = $_GET['q']; <-- Antes
$searchQuery = sanitizeInput($_GET['q']);
?>

<div class="container my-5">
  <h2>Resultados de la búsqueda</h2>
  <p>Su búsqueda de <strong><?php echo $searchQuery; ?></strong> no ha tenido resultados.</p>
</div>

<?php
include('footer.php');
?>
