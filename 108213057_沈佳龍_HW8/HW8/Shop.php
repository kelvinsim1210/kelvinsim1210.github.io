<!DOCTYPE html>
<?php
    session_start();
    if ($_SESSION["Admin"] != true) {  // 非法入侵不允许喵！
        header("Location: Main.html");
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
</head>

<style>
    * {  /* 消除所有间距喵 */
        padding: 0;
        margin: 0;
    }
    html, body {  /* 设置满屏喵 */
        width: 100%;
        height: 100%;
    }
    body {  /* 设置背景喵 */
        background-image: url(./img/Shop/Shop_BackGround1.png);
        background-size: cover;
        background-repeat: none;
        overflow: hidden;
    }
    #User, #LogOut {  /* 设置用户信息和登出喵 */
        width: 30%;
        background-color: rgba(0, 0, 0, 0.9);
        font-size: 20px;
        color: white;
        border-radius: 0 0 500px 0;
    }
    #LogOut {  /* 设置登出按钮喵 */
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 50px;
        text-align: center;
        font-size: 30px;
        border-radius: 0 0 0 500px;
    }
    #Shop_Owner1 {  /* 设置看板娘喵喵喵 */
        position: absolute;
        transform: translate(-100px, -50px);
        height: 120%;
    }
    #Talk {  /* 设置对话款喵 */
        display: none;
        position: absolute;
        top: 50%;
        left: 5%;
        width: 30%;
        background-color: rgba(0, 0, 0, 0.7);
        border: 3px solid black;
        border-radius: 10px;
        font-size: 20px;
        color: white;
    }
    #Commodity {  /* 设置商品展示区喵 */
        position: absolute;
        right: 100px;
        top: 15%;
        width: 50%;
        height: 80%;
        background-color: rgba(0, 0, 0, 0.7);
        border: 3px solid black;
        border-radius: 10px;
        /* text-align: center; */
        overflow: scroll;
    }
    #Commodity::-webkit-scrollbar {  /* 滚动条隐藏喵 */
        display: none;
    }
    .Commodity_Show {  /* 每个商品的盒子喵 */
        margin: 5% 5% 0;
        width: 90%;
        height: 100px;
        font-size: 30px;
        background-color: pink;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    div[class^="Commodity_Img"] {  /* 商品图片喵 */
        display: inline-block;
        margin-right: 20px;
        width: 100px;
        height: 100px;
        background-size: cover;
        background-repeat: no-repeat;
        vertical-align: middle;
    }
    .Commodity_Num {  /* 购买数量的盒子喵 */
        margin: 0 5%;
        height: 30px;
        background-color: yellowgreen;
        text-align: center;
    }
    .Commodity_Num div {  /* 设置+-的盒子喵 */
        display: inline-block;
        width: 30%;
        height: 100%;
        font-size: 20px;
    }
    .Commodity_Num input {  /* 设置购买数量输入框喵 */
        display: inline-block;
        width: 30%;
        height: 80%;
        font-size: 20px;
    }
    #Sub {  /* 添加至购物车的按钮喵 */
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        margin: 5%;
        width: 40%;
        height: 50px;
        font-size: 30px;
    }
    #Shopping_Cart {  /* 前往购物车的按钮喵 */
        position: fixed;
        bottom: 30px;
        left: 30px;
        width: 100px;
        height: 100px;
        background-color: black;
        border-radius: 50%;
        border: 3px solid yellowgreen;
        background-image: url(./img/Shop/Sign1.jpg);
        background-size: cover;
        background-repeat: no-repeat;
    }
</style>

<body>
    <!-- <audio src="./img/Shop/Shop_Owner_MP3/S1.mp3" autoplay ></audio> -->
    <div id="User"></div>  <!-- 用户信息喵 -->
    <div id="LogOut" onclick="LogOut()">LogOut</div>  <!-- 登出按钮喵 -->
    <img src="./img/Shop/Shop_Owner.png" alt="看板娘喵" id="Shop_Owner1" onclick="PlayMP3(3)">  <!-- 看板娘喵 -->
    <div id="Talk"></div>  <!-- 对话框喵 -->
    <form id="Commodity"></form>  <!-- 商品展示区喵 -->
    <div id="Shopping_Cart" onclick="Shopping_Cart()"></div>  <!-- 查看购物车喵 -->

    <!-- php -->
    <?php
        $File = fopen("./data/Commodity.txt", "r");  // 导入商品数据喵
        $Data = array();
        while(! feof($File)) {
            $Data[] = preg_split("/,/", str_replace(" ", "", fgets($File)));
        }
    ?>

    <!-- js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  <!-- 导入ajax喵 -->
    <script>
        var Commodity = <?php echo json_encode($Data)?>;  // 商品数据喵

        window.onload = function() {
            PlayMP3(1);
            // 设置用户信息喵
            document.getElementById("User").innerHTML = "用户：<?php echo session_id()?> <br/> 会员："+<?php echo json_encode($_SESSION["Level"])?>;
            
            var Text = "";  // 设置商品展示区内容喵
            for (var x=0; x<Commodity.length; x++) {
                Text += "<div Class=\"Commodity_Show\">  <div class=\"Commodity_Img"+x+"\" onclick=\"Talk(this)\"></div>"+ Commodity[x][0] +"</div>";
                Text += "<div class=\"Commodity_Num\">  <div class=\"Num_Add\" onclick=\"ChangeNum(-1, this)\">+</div>  <input type=\"text\" name=\""+x+"\">  <div class=\"Num_Less\" onclick=\"ChangeNum(1, this)\">-</div>  </div>";
            }
            Text += "<input type='submit' value='添加至购物车' onclick='PlayMP3(2)' id='Sub'>";
            document.getElementById("Commodity").innerHTML = Text;

            for (var x=0; x<Commodity.length; x++) {  // 设置商品样式喵
                document.getElementsByClassName("Commodity_Img"+x)[0].style.backgroundImage = `url(./img/Shop/Commodity/Commodity${x+1}.png)`;
                document.getElementsByClassName("Commodity_Num")[x].children[1].value = 0;
            }
        }

        function PlayMP3(Now) {  // 喵喵想和你说话喵
            var Word = ["欢迎光临喵！你是来探望看板娘明石的喵？", "呼喵？看中了哪个商品喵？请拿好购物券直接到收银台结账喵~", "喵！我可是非卖品喵！"];
            const audio = document.createElement("audio");  // 创建音档喵
            var src = "./img/Shop/Shop_Owner_MP3/S";
            audio.src = src+Now+".mp3";
            audio.play();
            var TK = document.getElementById("Talk");
            TK.innerHTML = Word[Now-1];
            TK.style.display = "block";
            setTimeout(function() {
                TK.style.display = "none";
            }, 7000);
        }

        function ChangeNum(Set, Now) {  // 改变商品购买数量喵
            var See = Now.parentNode.children[1];
            if (See.value-Set >= 0) {
                See.value = See.value-Set;
            }
        }

        function Talk(Now) {  // 商品详细讯息喵
            var Num = Now.className;
            var See = document.getElementById("Talk");
            See.innerHTML = Commodity[Num[Num.length-1]][2];
            See.style.display = "block";
            setTimeout(function() {
                See.style.display = "none";
            }, 3000);
        }

        function LogOut() {  // 登出喵
            window.location.href = "LogOut.php";
        }

        function ResetNum() {  // 每次添加商品区购物车都要重置数量喵
            for (var x=0; x<Commodity.length; x++) {
                document.getElementsByClassName("Commodity_Num")[x].children[1].value = 0;
            }
        }

        $('form').on('submit', function(){  // 添加商品区购物车喵
            $.ajax({
                url: 'Add_Commodity.php',  //要傳送的頁面喵
                method: 'POST',  //使用 POST 方法傳送請求喵
                dataType: 'json',  //回傳資料會是 json 格式
                data: $('form').serialize(),  //將表單資料用打包起來送出去喵
                success: function(res){
                    alert(res.success);  // 确认已添加至购物车喵
                },
            });
            return false;  // 阻止瀏覽器跳轉喵，因為已經用 ajax 送出去了喵
            ResetNum();
        });

        function Shopping_Cart() {  // 查看购物车喵
            window.location.href = "Shopping_Cart.php";
        }
    </script>
</body>
</html>