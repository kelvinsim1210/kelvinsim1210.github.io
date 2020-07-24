alert("請以電腦觀看以獲最佳體驗！");

window.onload = function() {
    var hour = document.getElementsByClassName("clock_hour")[0];
    var min = document.getElementsByClassName("clock_min")[0];
    var sec = document.getElementsByClassName("clock_sec")[0];

    setInterval(function() {
        var time = new Date() ;
        var y = time.getFullYear();
        var h = time.getHours();
        var m = time.getMinutes() ;
        var s = time.getSeconds();
        hour.style.transform = `translate(-50%, -50%) rotate(${h*30 + (m/60)*30 + (s/60/60)*30}deg)` ;
        min.style.transform = `translate(-50%, -50%) rotate(${m*6 + (s/60)*6}deg)` ;
        sec.style.transform = `translate(-50%, -50%) rotate(${s*6}deg)` ;

        document.getElementById("text_year").innerHTML = y + "年" ;
        if (h<10) {
            document.getElementById("text_hour").innerHTML = "0" + h ;
        }
        else {
            document.getElementById("text_hour").innerHTML = h ;
        }
        if (m<10) {
            document.getElementById("text_min").innerHTML = "0" + m + "時" ;
        }
        else {
            document.getElementById("text_min").innerHTML = m + "時";
        }
    } , 1000) ;
}