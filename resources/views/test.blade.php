<!doctype html>
<html lang="en">
<head>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.0.js') }}"></script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
<div style="width: 80%; margin: auto;">
    <center><h2>用户注册</h2> </center>
    <form class="form-horizontal" role="register" action="user?act=selectUser" method="post" style="width: 80%; margin: auto;">
        <div class="form-group">
            <label  class="col-sm-2 control-label">用户名：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="user.uname" required="required"
                       placeholder="请输入用户名 ">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label">密&nbsp;&nbsp;&nbsp;&nbsp;码：</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="user.upassword" required="required"
                       placeholder="请输入密码" id="ipwd">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label">确认密码：</label>
            <div class="col-sm-10">
                <input type="password" class="form-control"  required="required"
                       placeholder="请输入密码" id="i2pwd">
            </div>
        </div>

        <p id="msg_pwd" style="margin-left: 150px"></p>
        <div class="form-group">
            <label  class="col-sm-2 control-label">邮&nbsp;&nbsp;&nbsp;&nbsp;箱：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="user.email" required="required"
                       placeholder="请输入邮箱">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label">住&nbsp;&nbsp;&nbsp;&nbsp;址：</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="user.address" required="required"
                       placeholder="请输入住址">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                已有账号？点击<a href="login.jsp">登录！</a>
                <button type="submit" class="btn btn-success"  style="float: right" id="btn_register">注册</button>
            </div>
        </div>
    </form>
</div>
</body>

<script>
    $(document).ready(function(){
        $('#ipwd').on('input propertychange', function() {
            //input propertychange即实时监控键盘输入包括粘贴
            var pwd = $.trim($(this).val());
            //获取this，即ipwd的val()值，trim函数的作用是去除空格
            var rpwd = $.trim($("#i2pwd").val());
            if(rpwd!=""){
                if(pwd==""&&rpwd==""){
                    //若都为空，则提示密码不能为空，为了用户体验（在界面上用required同时做了处理）
                    $("#msg_pwd").html("<font color='red'>密码不能为空</font>");
                }
                else{
                    if(pwd==rpwd){                                 //相同则提示密码匹配
                        $("#msg_pwd").html("<font color='green'>两次密码匹配通过</font>");
                        $("#btn_register").attr("disabled",false); //使按钮无法点击
                    }else{                                          //不相同则提示密码匹配
                        $("#msg_pwd").html("<font color='red'>两次密码不匹配</font>");
                        $("#btn_register").attr("disabled",true);
                    }
                }}
        })
    })

    //由于是两个输入框，所以进行两个输入框的几乎相同的判断
    $(document).ready(function(){
        $('#i2pwd').on('input propertychange', function() {
            var pwd = $.trim($(this).val());
            var rpwd = $.trim($("#ipwd").val());
            if(pwd==""&&rpwd==""){
                $("#msg_pwd").html("<font color='red'>密码不能为空</font>");
            }
            else{
                if(pwd==rpwd){
                    $("#msg_pwd").html("<font color='green'>两次密码匹配通过</font>");
                    $("#btn_register").attr("disabled",false);
                }else{
                    $("#msg_pwd").html("<font color='red'>两次密码不匹配</font>");
                    $("#btn_register").attr("disabled",true);
                }
            }
        })
    })
</script>

</html>
