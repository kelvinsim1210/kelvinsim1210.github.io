<?php
    session_start();
    $_SESSION["Admin"] = false;
    header("Location: Main.html")
?>