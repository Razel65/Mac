<?php
session_start();
session_destroy();
header("Location: welkom.php");
exit;
?>
