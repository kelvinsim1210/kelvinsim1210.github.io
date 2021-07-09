<?php
    session_start();
    unset($_SESSION["Commodity"]);
    header("Location: Shopping_Cart.php");
?>