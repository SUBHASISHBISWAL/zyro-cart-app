<?php
session_start();
session_unset();
session_destroy();

// Logout hone ke baad user ko wapas Home Page par bhej dega
header("Location: ../../index.php");

exit();
?>