@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h2 class="index-h2">「借阅管理」</h2>
        <p class="index-h2-p mb-5 mt-3">点击下面的导航栏选择借阅类型</p>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <ul class="nav nav-pills justify-content-center rentalMenu">
                        <li class="nav-item">
                            <a href="{{url('/rental/pending')}}" class="nav-link active" data-id="pending">Rental requests with PENDING status</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/rental/accepted')}}" class="nav-link" data-id="accepted">Accepted and in-time rentals</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/rental/late')}}" class="nav-link" data-id="late">Accepted late rentals</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/rental/rejected')}}" class="nav-link" data-id="rejected">Rejected rental requests</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/rental/returned')}}" class="nav-link" data-id="returned">Returned rentals</a>
                        </li>
                    </ul>
                    <div id="table-content">
                        <table class="table table-hover table-striped" style="width: 95%;margin: 0 auto">
                            <thead>
                            <tr>
                                <th scope="col">序号</th>
                                <th scope="col">书名</th>
                                <th scope="col">作者</th>
                                <th scope="col">操作日期</th>
                                <th scope="col">借阅者</th>
                                <th scope="col">deadline</th>
                                <th scope="col" class="text-center">功能</th>
                            </tr>
                            </thead>
                            <tbody>
                            @for($x = 0; $x < count($results); $x++)
                                <tr>
                                    <th scope="row">{{$results[$x]['id']}}</th>>
                                    <td>{{$books[$x]->get()->pluck('title')->first()}}</td>
                                    <td>{{$books[$x]->get()->pluck('authors')->first()}}</td>
                                    <td>{{$results[$x]['created_at']}}</td>
                                    <td>{{$users[$x]->get()->pluck('name')->first()}}</td>
                                    <td>{{$results[$x]['deadline']}}</td>
                                    <td class="text-center">
                                        <button class="btn btn-primary btn-xs" id="bookdetails" data-bs-target="#bookDetailModal" data-bs-toggle="modal" data-id="{{$books[$x]->get()->pluck('id')->first()}}">书本详情</button>
                                        <button class="btn btn-warning btn-xs" id="rentaldetails" data-bs-target="#rentalDetailModal" data-bs-toggle="modal" data-id="{{$results[$x]['id']}}">借阅详情</button>
                                        <button class="btn btn-success btn-xs" id="acceptrental" data-bs-target="#acceptRentalModal" data-bs-toggle="modal" data-id="{{$results[$x]['id']}} ">接受</button>
                                        <button class="btn btn-danger btn-xs" id="rejectrental" data-bs-target="#rejectRentalModal" data-bs-toggle="modal" data-id="{{$results[$x]['id']}}">拒绝</button>
                                        <button class="btn btn-success btn-xs" id="returnbook" data-bs-target="#returnBookModal" data-bs-toggle="modal" data-id="{{$results[$x]['id']}}">还书</button>
                                    </td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 书本详情模态框 -->
    <div class="modal fade" id="bookDetailModal" tabindex="-1" aria-labelledby="bookDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">书籍详情</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="row modal-body">
                    <div class="form-group col-lg-6">
                        <div style="height: 360px" class="mt-3">
                            <img id="d_image" alt="image" src="{{asset("image/book/No_Image.png")}}" class="rounded img-fluid">
                            <p id="d_description"></p>
                        </div>
                        <div class="form-group mb-3 col-lg-12">
                            <label for="d_date_of_publish" class="col-form-label">出版日期：</label>
                            <textarea id="d_date_of_publish" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                        </div>
                        <div class="form-group mb-3 col-lg-6">
                            <label for="d_number_of_pages" class="col-form-label">页数：</label>
                            <textarea id="d_number_of_pages" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                        </div>
                        <div class="form-group mb-3 col-lg-6">
                            <label for="d_language" class="col-form-label">语言：</label>
                            <textarea id="d_language" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <form onsubmit="return false;">
                            <div class="form-group">
                                <div class="form-group mb-3">
                                    <label for="d_title" class="col-form-label">标题：</label>
                                    <textarea id="d_title" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="d_author" class="col-form-label">作者：</label>
                                    <textarea id="d_author" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="d_genre" class="col-form-label">类型：</label>
                                    <select class="form-select" aria-label="d_genre_name" disabled>
                                        <option id="d_genre_name" selected></option>
                                    </select>
                                    <select class="form-select" aria-label="d_genre_style" disabled>
                                        <option id="d_genre_style" selected></option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="d_isbn" class="col-form-label">ISBN：</label>
                                    <textarea id="d_isbn" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="d_in_stock" class="col-form-label">Number of this book in the library：</label>
                                    <textarea id="d_in_stock" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="d_not_borrowed" class="col-form-label">Number of available books：</label>
                                    <textarea id="d_not_borrowed" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    @if(!empty(session('user')))
                        @if(session('user')['is_librarian'] == 0)
                            <button class="btn btn-success" disabled>借这本书</button>
                        @endif
                    @endif
                    <button class="btn btn-primary" data-bs-dismiss="modal">确认</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 借阅详情模态框 -->
    <div class="modal fade" id="rentalDetailModal" tabindex="-1" aria-labelledby="rentalDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>借阅详情</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false;">
                        <div class="row form-group">
                            <div class="form-group col-sm-6 mb-3">
                                <label for="r_name" class="col-form-label">借阅者姓名：</label>
                                <textarea id="r_name" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                            </div>
                            <div class="form-group col-sm-6 mb-3">
                                <label for="r_created_at" class="col-form-label">租借请求日期：</label>
                                <textarea id="r_created_at" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                            </div>
                            <div class="form-group col-sm-12 mb-3">
                                <label for="r_status" class="col-form-label">状态：</label>
                                <textarea id="r_status" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                            </div>
                            <div class="form-group col-sm-6 mb-3" id="r_processed_at_div">
                                <label for="r_processed_at" class="col-form-label">处理日期：</label>
                                <textarea id="r_processed_at" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                            </div>
                            <div class="form-group col-sm-6 mb-3" id="r_request_managed_by_div">
                                <label for="r_request_managed_by" class="col-form-label">操作员：</label>
                                <textarea id="r_request_managed_by" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                            </div>
                            <div class="form-group col-sm-12 mb-3" id="r_deadline_div">
                                <label for="r_deadline" class="col-form-label">deadline：</label>
                                <textarea id="r_deadline" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                            </div>
                            <div class="form-group col-sm-6 mb-3" id="r_returned_at_div">
                                <label for="r_returned_at" class="col-form-label">还书日期：</label>
                                <textarea id="r_returned_at" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                            </div>
                            <div class="form-group col-sm-6 mb-3" id="r_return_managed_by_div">
                                <label for="r_return_managed_by" class="col-form-label">操作员：</label>
                                <textarea id="r_return_managed_by" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                            </div>
                            <div class="form-group col-sm-12 mb-3" id="r_late_return_div">
                                <p id="r_late_return" style="color: red">该图书借阅已经超期！</p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-dismiss="modal">确认</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 接受借阅申请模态框 -->
    <div class="modal fade" id="acceptRentalModal" tabindex="-1" aria-labelledby="acceptRentalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">接受</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>您确定要接受此借阅请求吗？</p>
                    <form class="was-validated" onsubmit="return false;">
                        <div class="form-group mb-3">
                            <label for="ac_deadline" class="col-form-label">设置deadline：</label>
                            <input type="datetime-local" id="ac_deadline" class="form-control" required>
                            <div class="invalid-feedback">No earlier than the current time</div>
                        </div>
                    </form>
                    <p id="ac_username" style="color: red"></p>
                    <p id="ac_bookname" style="color: red"></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button class="btn btn-success accept-rental-submit">接受</button>
                </div>
            </div>
        </div>
    </div>

    <!-- pending->accepted success -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-success border-0" id="pendingToAcceptedSuccess" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    借阅接受成功！
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- pending->accepted failed(表单验证不通过) -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-danger border-0" id="pendingToAcceptedFormValidationFailed" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    借阅接受失败！请正确填写deadline！
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- pending->accepted failed -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-danger border-0" id="pendingToAcceptedFailed" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    借阅接受失败！
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            let id = 0;
            let rentid = 0;

            // 书本详情
            $('body').on('click', '#bookdetails', function (event) {
                event.preventDefault();
                id = $(this).data('id');
                // 发送此get时关闭ajax异步，否则后面的一个按钮判断会因为数据获取错误而失败
                $.ajaxSettings.async = false;
                $.get('/search/' + 'detail/' + id, function (data) {
                    if(data.data.cover_image !== null) {
                        $('#d_image').attr('src',data.data.cover_image);
                    }
                    else{
                        $('#d_image').attr('src','image/book/No_Image.png');
                    }
                    $('#d_description').text(data.data.description);
                    $('#d_date_of_publish').val(data.data.released_at);
                    $('#d_number_of_pages').val(data.data.pages);
                    $('#d_language').val(data.data.language_code);
                    $('#d_title').val(data.data.title);
                    $('#d_author').val(data.data.authors);
                    $('#d_genre_name').text(data.genre.name);
                    $('#d_genre_style').text(data.genre.style);
                    $('#d_isbn').val(data.data.isbn);
                    $('#d_in_stock').val(data.data.in_stock);
                    $('#d_not_borrowed').val(data.notborrowed);
                })
                $.ajaxSettings.async = true;
                // 没有库存时禁用借书按钮
                $('.borrow-submit').attr("disabled", true);
                // 若前面没有关闭异步，则这里会有bug
                d_not_borrowed = $.trim($("#d_not_borrowed").val());
                if(Number(d_not_borrowed) > 0)
                {
                    $(".borrow-submit").attr("disabled", false);
                }
            });

            // 借阅详情
            $('body').on('click', '#rentaldetails', function (event) {
                event.preventDefault();
                rentid = $(this).data('id');
                $("#r_processed_at_div").show();
                $('#r_request_managed_by_div').show();
                $('#r_deadline_div').show();
                $('#r_returned_at_div').show();
                $('#r_return_managed_by_div').show();
                $('#r_late_return_div').show();
                $.get('/myrental/' + 'detail/' + rentid, function (data) {
                    $('#r_name').text(data.user.name);
                    $('#r_created_at').text(data.data.created_at);
                    $('#r_status').text(data.data.status);
                    $('#r_processed_at').text(data.data.request_processed_at);
                    $('#r_request_managed_by').text(data.data.request_managed_by);
                    $('#r_deadline').text(data.data.deadline);
                    $('#r_returned_at').text(data.data.returned_at);
                    $('#r_return_managed_by').text(data.data.return_managed_by);
                    if(data.data.status === 'PENDING')
                    {
                        $("#r_processed_at_div").hide();
                        $('#r_request_managed_by_div').hide();
                        $('#r_deadline_div').hide();
                        $('#r_returned_at_div').hide();
                        $('#r_return_managed_by_div').hide();
                        $('#r_late_return_div').hide();
                    }
                    else if(data.data.status === 'REJECTED')
                    {
                        $('#r_deadline_div').hide();
                        $('#r_returned_at_div').hide();
                        $('#r_return_managed_by_div').hide();
                        $('#r_late_return_div').hide();
                    }
                    else if(data.data.status === 'ACCEPTED')
                    {
                        $('#r_returned_at_div').hide();
                        $('#r_return_managed_by_div').hide();
                        let now = new Date();
                        now = now.toLocaleString();
                        let deadline = data.data.deadline;
                        deadline = new Date(deadline.replace("-", "/").replace("-", "/"));
                        now = new Date(now.replace("-", "/").replace("-", "/"));
                        if(deadline >= now)
                        {
                            $('#r_late_return_div').hide();
                        }
                    }
                    else
                    {
                        $('#r_late_return_div').hide();
                    }
                })
            })

            // 接受借阅模态框需要的值
            $('body').on('click', '#acceptrental', function (event) {
                event.preventDefault();
                rentid = $(this).data('id');
                let now = new Date();
                let year = now.getFullYear();
                let month = now.getMonth()+1 < 10 ? "0"+(now.getMonth()+1) : (now.getMonth()+1);
                let date = now.getDate() < 10 ? "0"+now.getDate() : now.getDate();
                let hour = now.getHours()< 10 ? "0" + now.getHours() : now.getHours();
                let minute = now.getMinutes()< 10 ? "0" + now.getMinutes() : now.getMinutes();
                $('#ac_deadline').attr('min', year+"-"+month+"-"+date+"T"+hour+":"+minute);

                $.get('/rental/' + 'find/', {id: rentid}, function (data) {
                    $('#ac_username').text('用户名：' + data.user.name);
                    $('#ac_bookname').text('书名：' + data.book.title);
                })
            })

            // 接受借阅
            $('.accept-rental-submit').click(function () {

                deadline = $.trim($("#ac_deadline").val());
                deadline = deadline.replace(/T/g, ' ').replace(/.[\d]{3}Z/, ' ');
                let now = new Date();
                now = now.toLocaleDateString().replace('/','-').replace('/','-');
                now_Date = new Date(now);
                deadline_Date = new Date(deadline);
                if(deadline_Date >= now_Date)
                {
                    $.post('{{url('rental/pending/toaccept')}}', {id: rentid, request_processed_at: now}, function (res) {
                        if(res.code === 200)
                        {
                            $('#pendingToAcceptedSuccess').toast('show');
                            setTimeout(function () {
                                window.location.reload();
                            }, 2000);
                        }
                        else {
                            $('#pendingToAcceptedFailed').toast('show');
                            setTimeout(function () {
                                window.location.reload();
                            }, 2000);
                        }
                    }, 'json');
                }
                else{
                    $('#pendingToAcceptedFormValidationFailed').toast('show');
                }
            });

            // 点击导航栏按钮
            $('.rentalMenu').on('click', 'a', function(e) {
                e.preventDefault(); // 阻止链接跳转
                var url = this.href; // 保存点击的地址

                $('a.active').removeClass('active');
                $(this).addClass('active');

                $('#table-content').load(url + ' #table-content').fadeIn('slow');
            });
        })
    </script>

@endsection
