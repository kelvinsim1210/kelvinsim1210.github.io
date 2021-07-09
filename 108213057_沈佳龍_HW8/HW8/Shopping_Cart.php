<!DOCTYPE html>

<?php
    session_start();
    if ($_SESSION["Admin"] == false) {  // 非法侵入者，逮捕喵！
        header("Location: Main.html");
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        * {  /* 清除所有间距喵 */
            padding: 0;
            margin: 0;
        }
        body {  /* 缓和心痛的背景喵 */
            background-color: pink;
        }
        #Back {
            position: absolute;
            right: 0;
            width: 200px;
            height: 50px;
            font-size: 30px;
            color: white;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.9);
            border-radius: 0 0 0 500px;
        }
        table {  /* 设置购买商品的详情喵 */
            position: absolute;
            /* top: 50%; */
            left: 50%;
            transform: translate(-50%, 100px);
            width: 50%;
            text-align: right;
            font-size: 30px;
            border-collapse: collapse;
            /* background-color: red; */
        }
        table tr {  /* 设置每一行的分割线喵 */
            border: 2px solid black;
        }
        #Top {  /* 标题设置喵 */
            background-color: black;
            color: white;
        }
        #Sum {  /* 总额设置喵 */
            background-color: yellow;
        }
        button {  /* 开心付款按钮喵 */
            position: absolute;
            right: 30px;
            bottom: 30px;
            width: 200px;
            height: 200px;
            font-size: 30px;
            border-radius: 50%;
            background: linear-gradient(to bottom right, yellow, green);
        }
    </style>

</head>
<body>
    <div id="Back" onclick="Back()">返回</div>
    <table id="Table">
        <tr id="Top">
            <td style='text-align: left;'>商品名称</td>
            <td>单价</td>
            <td>数量</td>
            <td>总额</td>
        </tr>
        <?php
            if (isset($_SESSION["Commodity"])) {  // 如果有商品在购物车的话喵
                $SC = $_SESSION["Commodity"];  // 将用户购买的商品导出喵
                $File = fopen("./data/Commodity.txt", "r");  // 读取用户购买商品资料喵
                $Data = array();  // 储存资料喵
                while(! feof($File)) {  // 历遍资料喵
                    $Data[] = preg_split("/,/", str_replace(" ", "", fgets($File)));  // 整理好资料格式喵
                }
                $All = 0;  // 计算总额喵
                for ($x=0; $x<count($Data); $x++) {
                    if (isset($SC[$x])) {  // 将用户有购买的商品列出来喵
                        echo "<tr class='TR'><td style='text-align: left;'>";
                        echo $Data[$x][0]."<td>".$Data[$x][1]."<td>".$SC[$x]."<td>".$Data[$x][1]*$SC[$x]."</tr>";
                        $All += $Data[$x][1]*$SC[$x];  // 计算总额喵
                    }
                }
                fclose($File);  

                $File = fopen("./data/Discount.txt", "r");  // 读取用户折扣喵
                $Data = array();  // 储存用户资料喵
                while(! feof($File)) {  // 历遍资料喵
                    $Data = preg_split("/,/", str_replace(" ", "", fgets($File)));  // 整理好资料格式喵
                    // echo $_SESSION["Level"], $Data[0];
                    if (strpos($_SESSION["Level"], $Data[0]) !== false) {  // 找到符合当前用户的会员等级喵
                        $DC = 0-$All*(1-$Data[1]);  // 折扣价格喵
                        echo "<tr>  <td style='text-align: left;'>会员折扣<td><td><td>".$DC."</tr>";
                    }
                }
                $All += $DC;  // 减去折扣喵
                echo "<tr id='Sum'> <td style='text-align: left;'>总额<td><td><td>".$All."</tr>";
            }
            else {  // 快去买些什么喵
                echo "<tr>  <td>——购物车空空如也——  </tr>";
            }
        ?>
    </table>
    <button onclick="Pay()">支付所有</button>  <!-- 快乐支付按钮喵 -->

    <!-- js -->
    <script>
        function Pay() {  // 快乐支付喵
            window.location.href = "Pay.php";
        }

        function Back() {
            window.location.href = "Shop.php";
        }
    </script>
</body>
</html>