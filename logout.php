<?php
// Destroy the session and redirect to login or home page if any
session_start();
session_destroy();
header("Location: index.php");
exit();
?>
