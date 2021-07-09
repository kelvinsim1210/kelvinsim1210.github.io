<?php
    if ((isset($_POST["UserName"])) && (isset($_POST["Password"]))) {  // 有好好登录就进来喵
        if (($_POST["UserName"] == "") || ($_POST["Password"] == "")) {  // 回去填写完整喵！
            echo '{"success": "请输入完整信息喵！"}';
            exit;
        }
        else {  // 有好好填写信息喵~
            $File = fopen("./data/User.txt", "r");  // 读取用户资料喵
            $Data = array();  // 储存用户资料喵
            while(! feof($File)) {  // 历遍资料喵
                $Data = preg_split("/,/", str_replace(" ", "", fgets($File)));  // 整理好资料格式喵
                if (($Data[0] == $_POST["UserName"]) && ($Data[1] == $_POST["Password"])) {  // 资料都正确喵
                    echo '{"success": true}';
                    session_id($Data[0]);  // 确认用户喵
                    session_start();
                    $_SESSION["Admin"] = true;  // 登录许可喵
                    $_SESSION["Level"] = $Data[2];  // 确认用户会员等级
                    exit;  // 回去登录喵
                }
            }
            echo '{"success": "账号或密码错误喵！"}';
        }
    }
    else {
        header("Location: Main.html");  // 回去好好登录喵！
    }
?>