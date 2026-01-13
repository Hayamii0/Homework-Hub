<?php
require_once 'config.php';
checkLogin();

// Redirect to home page (dashboard is now integrated into index.php)
header('Location: index.php');
exit();
?>