<?php
session_start();
session_unset(); // Verwijdert alle sessievariabelen
session_destroy(); // Vernietigt de sessie

// Stuur een JSON-reactie terug als het via fetch() wordt aangeroepen
echo json_encode(['success' => true]);
exit;
?>
