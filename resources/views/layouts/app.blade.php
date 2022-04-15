<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <title>BRS</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.0.js') }}"></script>

    <!-- 移动设备优先 -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- csrf -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>

{{--导航栏--}}
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mt-2" id="navbarSupportedContent">
                <a href="{{url('/')}}" class="navbar-brand">
                    <img src="{{ asset('image/logo.svg') }}" width="30" height="30" class="d-inline-block align-text-top" alt="">
                    BRS
                </a>
                <div class="navbar-nav">
                    <a class="nav-item nav-link active" href="{{url('/')}}"><span class="glyphicon glyphicon-home"></span>Home</a>
                    <a class="nav-item nav-link" href="#" data-bs-target="#searchModal" data-bs-toggle="modal">Search</a>
                    <a class="nav-item nav-link" href="#" data-bs-target="#genresModal" data-bs-toggle="modal">List by genre</a>
                    @if(!empty(session('user')))
                        @if(session('user')['is_librarian'] == 0)
                            <a class="nav-item nav-link myRental" href="{{url('myrental')}}" >My rentals</a>
                        @elseif(session('user')['is_librarian'] == 1)
                            <a class="nav-item nav-link" href="#" id="addBook" data-bs-target="#addBooksModal" data-bs-toggle="modal">Add new book</a>
                            <a class="nav-item nav-link" href="{{url('genre/list')}}" id="genreList">Genre list</a>
                            <a class="nav-item nav-link" href="#" data-bs-target="#addGenresModal" data-bs-toggle="modal">Add new genre</a>
                            <a class="nav-item nav-link rentalManage" href="{{url('rental')}}">Rental list</a>
                        @endif
                    @endif
                </div>
            </div>
            @if(empty(session('user')))
                <button class="btn btn-outline-light my-2 my-sm-0" style="margin-left: 10px" data-bs-target="#registerModal" data-bs-toggle="modal">Register</button>
                <button class="btn btn-outline-light my-2 my-sm-0" style="margin-left: 10px" data-bs-target="#loginModal" data-bs-toggle="modal">Login</button>
            @else
                <a class="nav-item nav-link active" href="#" style="color: whitesmoke">{{session('user')['username']}}</a>
                <button class="btn btn-outline-light log-out my-2 my-sm-0" style="margin-left: 10px">Logout</button>
            @endif

        </div>
    </nav>

{{--    注册成功后的弹窗--}}
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-success border-0" id="registerSuccess" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    注册成功！
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

{{--    注册失败后的弹窗--}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div class="toast align-items-center text-white bg-danger border-0" id="registerFailed" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                注册失败！该邮箱已被注册！
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

{{--    登出成功之后的弹窗--}}
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-success border-0" id="logoutSuccess" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    登出成功！
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

{{--    登陆成功之后的弹窗--}}
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-success border-0" id="loginSuccess" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    登陆成功！
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

{{--    登陆失败之后的弹窗--}}
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-danger border-0" id="loginFailed" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    用户名或密码错误！
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

{{--    添加新书成功之后的弹窗--}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div class="toast align-items-center text-white bg-success border-0" id="addBookSuccess" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                添加新书成功！
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

{{--    添加新书失败之后的弹窗：ISBN号已存在--}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div class="toast align-items-center text-white bg-danger border-0" id="addBookFailed" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                添加新书失败！ISBN号已经存在！
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

{{--    添加新书失败之后的弹窗：表单验证不通过--}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div class="toast align-items-center text-white bg-danger border-0" id="addBookFormValidationFailed" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                添加新书失败！请正确填写信息！
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

{{--    添加新流派成功之后的弹窗--}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div class="toast align-items-center text-white bg-success border-0" id="addGenresSuccess" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                添加新流派成功！
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

{{--    添加新书失败之后的弹窗：流派号已存在--}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div class="toast align-items-center text-white bg-danger border-0" id="addGenresFailed" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                添加新流派失败！流派已经存在！
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

{{--    添加新流派失败之后的弹窗：表单验证不通过--}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div class="toast align-items-center text-white bg-danger border-0" id="addGenresFormValidationFailed" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                添加新流派失败！请正确填写信息！
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

    @yield("content")

    <!-- 搜索模态框 -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">搜索</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false;">
                        <div class="form-group">
                            <div class="form-group mb-3">
                                <label for="searchWays" class="col-form-label">请选择查询方式：</label>
                                <select name="" id="searchWays" class="form-select ">
                                    <option value="1">按书名</option>
                                    <option value="2">按作者</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="searchKeyword" class="col-form-label">请输入关键字：</label>
                                <input type="text" id="searchKeyword" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary search-submit">查询</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 按类索引模态框 -->
    <div class="modal fade" id="genresModal" tabindex="-1" aria-labelledby="genresModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">按书籍类型索引</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false;">
                        <div class="form-group">
                            <div class="form-group mb-3">
                                <label for="genreName" class="col-form-label">请输入体裁名称：</label>
                                <input type="text" id="genreName" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="genreStyle" class="col-form-label">请选择体裁风格：</label>
                                <select name="" id="genreStyle" class="form-select ">
                                    <option value="">---</option>
                                    <option value="primary">primary</option>
                                    <option value="secondary">secondary</option>
                                    <option value="success">success</option>
                                    <option value="danger">danger</option>
                                    <option value="warning">warning</option>
                                    <option value="info">info</option>
                                    <option value="light">light</option>
                                    <option value="dark">dark</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary genres-list-submit">索引</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Login模态框 -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">登陆</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false;">
                        <div class="form-group">
                            <div class="form-group mb-3">
                                <label for="email" class="col-form-label">请输入登陆邮箱：</label>
                                <input type="email" id="lemail" class="form-control" placeholder="name@example.com" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="col-form-label">请输入密码：</label>
                                <input type="password" id="lpassword" class="form-control" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary login-submit">登陆</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Register模态框 -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">注册新用户</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false;">
                        <div class="form-group">
                            <div class="form-group mb-3">
                                <label for="username" class="col-form-label">请输入用户名：</label>
                                <input type="text" id="rusername" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email" class="col-form-label">请输入邮箱：</label>
                                <input type="email" id="remail" class="form-control" placeholder="name@example.com" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="col-form-label">请输入密码：</label>
                                <input type="password" id="rpassword" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="pwdconfirm" class="col-form-label">请再次输入密码：</label>
                                <input type="password" id="rpwdconfirm" class="form-control" required>
                                <p id="msg_pwd" style="color: red"></p>

                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" id="rcheck" class="form-check-input" required>
                                <label for="check">同意用户协议</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary register-submit" disabled>注册</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 添加新书模态框 -->
    <div class="modal fade" id="addBooksModal" tabindex="-1" aria-labelledby="addBooksModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">添加新书</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="was-validated" onsubmit="return false;">
                        <div class="row form-group">
                            <div class="form-group mb-3 col-sm-12">
                                <label for="a_title" class="col-form-label">标题：</label>
                                <input type="text" id="a_title" class="form-control" pattern=".{1,255}" required>
                                <div class="invalid-feedback">max. 255 characters</div>
                            </div>
                            <div class="form-group mb-3 col-sm-6">
                                <label for="a_author" class="col-form-label">作者：</label>
                                <input type="text" id="a_author" class="form-control" pattern=".{1,255}" required>
                                <div class="invalid-feedback">max. 255 characters</div>
                            </div>
                            <div class="form-group mb-3 col-sm-6">
                                <label for="a_released_at" class="col-form-label">发行于：</label>
                                <input type="date" id="a_released_at" class="form-control" max="" required>
                                <div class="invalid-feedback">must before now</div>
                            </div>
                            <div class="form-group mb-3 col-sm-2">
                                <label for="a_pages" class="col-form-label">页数：</label>
                                <input type="number" id="a_pages" class="form-control" min="1" required>
                                <div class="invalid-feedback">at least 1</div>
                            </div>
                            <div class="form-group mb-3 col-sm-4">
                                <label for="a_isbn" class="col-form-label">ISBN：</label>
                                <input type="text" id="a_isbn" class="form-control" pattern="^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$" required>
                                <div class="invalid-feedback">isbn wrong</div>
                            </div>
                            <div class="form-group mb-3 col-sm-6">
                                <label for="a_in_stock" class="col-form-label">Number of this book in the library：</label>
                                <input type="number" id="a_in_stock" class="form-control" min="0" required>
                                <div class="invalid-feedback">At least 0</div>
                            </div>
                            <div class="form-group mb-3 col-sm-10">
                                <label for="a_description" class="col-form-label">描述：</label>
                                <textarea id="a_description" class="form-control" rows="1" style="height: 35px;"></textarea>
                            </div>
                            <div class="form-group mb-3 col-sm-2">
                                <label for="a_language_code" class="col-form-label">语言：</label>
                                <input type="text" id="a_language_code" class="form-control">
                            </div>
{{--                            <div class="form-group mb-3 col-sm-6">--}}
{{--                                <label for="a_genre" class="col-form-label">类型：</label>--}}
{{--                                <select class="form-select" id="a_genre_name" aria-label="a_genre_name"></select>--}}
{{--                                <select class="form-select" id="a_genre_style" aria-label="a_genre_style" required></select>--}}
{{--                            </div>--}}
                            <div class="form-group mb-3 col-sm-6">
                                <label for="a_genre" class="col-form-label">类型：</label>
                                <select class="form-select" id="a_genre" aria-label="a_genre" required></select>
                            </div>
                            <div class="form-group mb-3 col-sm-6">
                                <label for="a_cover_image" class="col-form-label">书籍封面：</label>
                                <input name="filesToUpload" type="file" id="a_cover_image" class="form-control" accept="image/gif,image/jpeg,image/jpg,image/png,image/svg">
                                <p id="uploadSuccess" style="color: green" >图片上传成功！</p>
                                <p id="uploadFailed" style="color: red" >图片上传失败！</p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary add-book-submit">添加</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 添加新流派模态框 -->
    <div class="modal fade" id="addGenresModal" tabindex="-1" aria-labelledby="addGenresModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">添加新流派</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="was-validated" onsubmit="return false;">
                        <div class="form-group">
                            <div class="form-group mb-3">
                                <label for="a_genre_name" class="col-form-label">请输入流派名称：</label>
                                <input type="text" id="a_genre_name" class="form-control" pattern=".{3,255}" required>
                                <div class="invalid-feedback">3-255 characters</div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="a_genre_style" class="col-form-label">请选择流派风格：</label>
                                <select class="form-select" id="a_genre_style" aria-label="a_genre_style" required>
                                    <option value="1">primary</option>
                                    <option value="2">secondary</option>
                                    <option value="3">success</option>
                                    <option value="4">danger</option>
                                    <option value="5">warning</option>
                                    <option value="6">info</option>
                                    <option value="7">light</option>
                                    <option value="8">dark</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary add-genres-submit">添加</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {

            // X-CSRF-TOKEN
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Search
            $('.search-submit').click(function () {
                searchWays = $('#searchWays').val();
                searchKeyword = $.trim($("#searchKeyword").val());

                $.get('{{url('search')}}', {searchWays: searchWays, searchKeyword: searchKeyword}, function () {
                    newloc = "{{url('search')}}" + "?searchWays=" + searchWays + "&searchKeyword=" + searchKeyword;
                    window.location.href = newloc;
                });
            })

            // Genres
            $('.genres-list-submit').click(function () {
                genreStyle = $('#genreStyle').val();
                genreName = $.trim($("#genreName").val());

                $.get('{{url('genre')}}', {genreStyle: genreStyle, genreName: genreName}, function () {
                    newloc = "{{url('genre')}}" + "?genreName=" + genreName + "&genreStyle=" + genreStyle;
                    window.location.href = newloc;
                });
            })

            // MyRental
            $('.myRental').click(function () {
                $.get('{{url('myrental')}}')
            })

            // Login
            $('.login-submit').click(function () {
                lemail = $('#lemail').val();
                lpassword = $('#lpassword').val();

                $.post("{{url('login')}}", {email: lemail, password: lpassword}, function (res) {
                    if(res.code === 200)
                    {
                        $("#loginSuccess").toast("show");
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }
                    else {
                        $("#loginFailed").toast("show");
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }
                }, 'json');
            });

            // Register
            $(".register-submit").attr("disabled", true);

            $('#rusername').on('input propertychange', function () {
                username = $.trim($(this).val());
                email = $.trim($("#remail").val());
                password = $.trim($("#rpassword").val());
                pwdconfirm = $.trim($("#rpwdconfirm").val());
                check = $("#rcheck").is(':checked');
                if (username === "" || email === "" || password === "" || pwdconfirm === "" || check === false)
                {
                    $(".register-submit").attr("disabled", true);
                }
                else{
                    $(".register-submit").attr("disabled", false);
                }
            });

            $('#remail').on('input propertychange', function () {
                username = $.trim($("#rusername").val());
                email = $.trim($(this).val());
                password = $.trim($("#rpassword").val());
                pwdconfirm = $.trim($("#rpwdconfirm").val());
                check = $("#rcheck").is(':checked');
                reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
                if (email === "" || !reg.test(email) || username === "" || password === "" || pwdconfirm === "" || check === false)
                {
                    $(".register-submit").attr("disabled", true);
                }
                else{
                    $(".register-submit").attr("disabled", false);
                }
            });

            $('#rpwdconfirm').on('input propertychange', function () {
                //input propertychange即实时监控键盘输入包括粘贴
                username = $.trim($("#rusername").val());
                email = $.trim($("#remail").val());
                pwd = $.trim($("#rpassword").val());
                rpwd = $.trim($(this).val());
                check = $("#rcheck").is(':checked');
                if (pwd !== "") {
                    if (pwd === rpwd && username !== "" && email !== "") {
                        $("#msg_pwd").html("");
                        $(".register-submit").attr("disabled", false);
                    }
                    else if (pwd !== rpwd && username !== "" && email !== "" && check !== "off")
                    {
                        $("#msg_pwd").html("两次密码不匹配！");
                        $(".register-submit").attr("disabled", true);
                    }
                    else{
                        $(".register-submit").attr("disabled", false);
                    }
                }
            });

            $('#rcheck').click(function () {
                username = $.trim($("#rusername").val());
                email = $.trim($("#remail").val());
                password = $.trim($("#rpassword").val());
                pwdconfirm = $.trim($("#rpwdconfirm").val());
                check = $("#rcheck").is(':checked');
                if (username === "" || email === "" || password === "" || pwdconfirm === "" || check === false)
                {
                    $(".register-submit").attr("disabled", true);
                }
                else{
                    $(".register-submit").attr("disabled", false);
                }
            });

            $('.register-submit').click(function () {
                rusername = $('#rusername').val();
                remail = $('#remail').val();
                rpassword = $('#rpassword').val();

                $.post("{{url('register')}}", {name: rusername, email: remail, password: rpassword}, function (res) {
                    // console.log(res);
                    if(res.code === 200)
                    {
                        $("#registerSuccess").toast("show");
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }
                    else {
                        $("#registerFailed").toast("show");
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }
                }, 'json');
            });

            // Logout
            $('.log-out').click(function () {
                $.getJSON("{{url('logout')}}", {}, function (res) {
                    $("#logoutSuccess").toast("show");
                    setTimeout(function () {
                        window.location.href = '{{url('/')}}';
                    }, 1000);
                });
            });

            // Add new book
            $('#addBook').click(function (event) {
                event.preventDefault();
                $('#uploadSuccess').hide();
                $('#uploadFailed').hide();
                // 日期不大于当前日期的判断
                let now = new Date();
                let year = now.getFullYear();
                let month = now.getMonth()+1 < 10 ? "0"+(now.getMonth()+1) : (now.getMonth()+1);
                let date = now.getDate() < 10 ? "0"+now.getDate() : now.getDate();
                $('#a_released_at').attr('max', year+"-"+month+"-"+date);

                $.get('/addbook', function (data) {
                    // 遍历获得的数据，添加至下拉菜单
                    $.each(data.genres, function (index, genres) {
                        let option = "<option value='" + genres.id + "'>" + genres.name + " - " + genres.style +"</option>";
                        $("#a_genre").append(option);
                    })
                    // $.each(data.genreStyles, function (index, genreStyles) {
                    //     let option = "<option value='" + genreStyles + "'>" + genreStyles + "</option>";
                    //     $("#a_genre_style").append(option);
                    // })
                })
            })

            let cover_image = "";
            $('#a_cover_image').change(function () {
                var formData = new FormData();
                formData.append('photo', $('#a_cover_image')[0].files[0]);
                $.ajax({
                    url: "{{url('photo')}}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        $('#uploadSuccess').show();
                        cover_image = res.imagePath;
                    },
                    error: function (res) {
                        $('#uploadFailed').show();
                    }
                });
            })

            $('.add-book-submit').click(function () {
                title = $.trim($("#a_title").val());
                author = $.trim($("#a_author").val());
                released_at = $.trim($("#a_released_at").val());
                pages = $.trim($("#a_pages").val());
                isbn = $.trim($("#a_isbn").val());
                reg = /^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/i;
                description = $.trim($("#a_description").val());
                language_code = $.trim($("#a_language_code").val());
                genre_id = $("#a_genre option:selected").attr('value');
                in_stock = $.trim($("#a_in_stock").val());

                let now = new Date();
                now = now.toLocaleDateString().replace('/','-').replace('/','-');
                now = new Date(now);
                released = new Date(released_at);

                if (title !== "" && author !== "" && released_at !== "" && pages !== "" && isbn !== "" && genre_id !== "" && in_stock !== "")
                {
                    if(title.length <= 255 && author.length <= 255 && now >= released && parseInt(pages) >= 1 && parseInt(in_stock) >= 0)
                    {
                        if(reg.test(isbn))
                        {
                            $.post("{{url('addbook/add')}}", {title: title, author: author, released_at: released_at, pages: pages, isbn: isbn, description: description, language_code: language_code, genre_id: genre_id, in_stock: in_stock, cover_image: cover_image}, function (res) {
                                if(res.code === 200)
                                {
                                    $("#addBookSuccess").toast("show");
                                    setTimeout(function () {
                                        window.location.reload();
                                    }, 2000);
                                }
                                else {
                                    $("#addBookFailed").toast("show");
                                }
                            }, 'json');
                        }
                        else{
                            $("#addBookFormValidationFailed").toast("show");
                        }
                    }
                    else{
                        $("#addBookFormValidationFailed").toast("show");
                    }
                }
                else{
                    $("#addBookFormValidationFailed").toast("show");
                }
            });

            // Add new genre
            $('.add-genres-submit').click(function () {
                gname = $.trim($("#a_genre_name").val());
                gstyle = $("#a_genre_style option:selected").text();
                if(gname !== "" && gstyle !== "")
                {
                    if(gname.length >= 3 && gname.length <= 255)
                    {
                        $.post("{{url('genre/add')}}", {name: gname, style: gstyle}, function (res) {
                            if(res.code === 200)
                            {
                                $("#addGenresSuccess").toast("show");
                                setTimeout(function () {
                                    window.location.href = '{{url('genre/list')}}';
                                }, 2000);
                            }
                            else {
                                $("#addGenresFailed").toast("show");
                                setTimeout(function () {
                                    window.location.reload();
                                }, 2000);
                            }
                        })
                    }
                    else{
                        $("#addGenresFormValidationFailed").toast("show");
                    }
                }
                else{
                    $("#addGenresFormValidationFailed").toast("show");
                }
            })

        })
    </script>

</body>
</html>>
