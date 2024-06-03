<?php
session_start();
session_destroy();
header("Location: /stock/index.php");
exit();
?>