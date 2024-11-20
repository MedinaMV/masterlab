<?php 

function sanitizeInput($data) {
  return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

?>