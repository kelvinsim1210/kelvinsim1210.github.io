<?php
    session_start();
    if (isset($_SESSION["Commodity"])) {
        $SC = $_SESSION["Commodity"];
        for ($x=0; $x<count($_POST); $x++) {
            if ($_POST[$x] != 0) {
                if (isset($SC[$x])) {
                    $SC[$x] += $_POST[$x];
                }
                else {
                    $SC[$x] = $_POST[$x];
                }
            }
        }
        $_SESSION["Commodity"] = $SC;
    }
    else {
        $_SESSION["Commodity"] = array();
        for ($x=0; $x<count($_POST); $x++) {
            if ($_POST[$x] != 0) {
                $_SESSION["Commodity"][$x] = $_POST[$x];
            }
        }
    }
    echo '{"success": "成功添加至购物车喵~"}';
    exit;
?>