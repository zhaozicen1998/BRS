<!DOCTYPE html>
<html lang="en">
<head>
    <title>个人中心</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.0.js') }}"></script>
</head>
<body>
<div class="userWrap">
    <ul class="userMenu">
        <li class="current" data-id="center">用户中心</li>
        <li data-id="account">账户信息</li>
        <li data-id="trade">交易记录</li>
        <li data-id="info">消息中心</li>
    </ul>
    <div id="content"></div>
</div>
</body>
</html>


<script>
    $(function(){
        $(".userMenu").on("click", "li", function(){
            var sId = $(this).data("id"); //获取data-id的值
            window.location.hash = sId; //设置锚点
            loadInner(sId);
        });
        function loadInner(sId){
            var sId = window.location.hash;
            var pathn, i;
            switch(sId){
                case "#center": pathn = "user_center.html"; i = 0; break;
                case "#account": pathn = "user_account.html"; i = 1; break;
                case "#trade": pathn = "user_trade.html"; i = 2; break;
                case "#info": pathn = "user_info.html"; i = 3; break;
                default: pathn = "user_center.html"; i = 0; break;
            }
            $("#content").load(pathn); //加载相对应的内容
            $(".userMenu li").eq(i).addClass("current").siblings().removeClass("current"); //当前列表高亮
        }
        var sId = window.location.hash;
        loadInner(sId);
    });
</script>
