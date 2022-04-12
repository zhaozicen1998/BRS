@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h2 class="index-h2">「我的借阅」</h2>
        <p class="index-h2-p mb-5 mt-3">点击下面的导航栏选择借阅类型</p>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <nav class="nav nav-tabs">
                        <a href="#" class="nav-item nav-link">Rental requests with PENDING status</a>
                        <a href="#" class="nav-item nav-link">Accepted and in-time rentals</a>
                        <a href="#" class="nav-item nav-link">Accepted late rentals</a>
                        <a href="#" class="nav-item nav-link">Rejected rental requests</a>
                        <a href="#" class="nav-item nav-link">Returned rentals</a>
                    </nav>
                    <table class="table table-hover table-striped" style="width: 95%;margin: 0 auto">
                        <thead>
                        <tr>
                            <th scope="col">序号</th>
                            <th scope="col">书名</th>
                            <th scope="col">作者</th>
                            <th scope="col">操作日期</th>
                            <th scope="col">deadline</th>
                            <th scope="col" class="text-center">详情</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($x = 0; $x < count($results); $x++)
                            <tr>
                                <th scope="row">{{$results[$x]['id']}}</th>>
                                    <td>{{$books[$x]['title']}}</td>
                                    <td>{{$books[$x]['authors']}}</td>
                                <td>{{$results[$x]['created_at']}}</td>
                                <td>{{$results[$x]['deadline']}}</td>
                                <td class="text-center">
                                    <button class="btn btn-success btn-xs" id="bookdetails" data-bs-target="#bookDetailModal" data-bs-toggle="modal" data-id="{{$books[$x]['id']}}">书本</button>
                                    <button class="btn btn-success btn-xs" id="rentaldetails" data-bs-target="#rentalDetailModal" data-bs-toggle="modal" data-id="{{$results[$x]['id']}}">借阅</button>
                                </td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
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
                                <textarea id="r_name" class="form-control" rows="1" style="height: 35px;" readonly>{{session('user')['username']}}</textarea>
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
                $.get('search/' + 'detail/' + id, function (data) {
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
                $.get('myrental/' + 'detail/' + rentid, function (data) {
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
        })
    </script>

@endsection
