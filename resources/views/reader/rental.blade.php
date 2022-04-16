@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h2 class="index-h2">「My rentals」</h2>
        <p class="index-h2-p mb-5 mt-3">Click on the navigation bar below to select the type of rental</p>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <ul class="nav nav-pills justify-content-center rentalMenu">
                        <li class="nav-item">
                            <a href="{{url('/myrental/pending')}}" class="nav-link active" data-id="pending">Rental requests with PENDING status</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/myrental/accepted')}}" class="nav-link" data-id="accepted">Accepted and in-time rentals</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/myrental/late')}}" class="nav-link" data-id="late">Accepted late rentals</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/myrental/rejected')}}" class="nav-link" data-id="rejected">Rejected rental requests</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/myrental/returned')}}" class="nav-link" data-id="returned">Returned rentals</a>
                        </li>
                    </ul>
                    <div id="table-content">
                        <table class="table table-hover table-striped" style="width: 95%;margin: 0 auto">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Date of rental request</th>
                                <th scope="col">Deadline</th>
                                <th scope="col" class="text-center">Details</th>
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
                                        <button class="btn btn-success btn-xs" id="bookdetails" data-bs-target="#bookDetailModal" data-bs-toggle="modal" data-id="{{$books[$x]['id']}}">Book</button>
                                        <button class="btn btn-warning btn-xs" id="rentaldetails" data-bs-target="#rentalDetailModal" data-bs-toggle="modal" data-id="{{$results[$x]['id']}}">Rental</button>
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

{{--    <!-- 书本详情模态框 -->Book Details Modal Box--}}
    <div class="modal fade" id="bookDetailModal" tabindex="-1" aria-labelledby="bookDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Book details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="row modal-body">
                    <div class="form-group col-lg-6">
                        <div style="height: 360px" class="mt-3">
                            <img id="d_image" alt="image" src="{{asset("image/book/No_Image.png")}}" class="rounded img-fluid">
                            <p id="d_description"></p>
                        </div>
                        <div class="form-group mb-3 col-lg-12">
                            <label for="d_date_of_publish" class="col-form-label">Date of publish:</label>
                            <textarea id="d_date_of_publish" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                        </div>
                        <div class="form-group mb-3 col-lg-6">
                            <label for="d_number_of_pages" class="col-form-label">Pages:</label>
                            <textarea id="d_number_of_pages" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                        </div>
                        <div class="form-group mb-3 col-lg-6">
                            <label for="d_language" class="col-form-label">Language:</label>
                            <textarea id="d_language" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <form onsubmit="return false;">
                            <div class="form-group">
                                <div class="form-group mb-3">
                                    <label for="d_title" class="col-form-label">Title:</label>
                                    <textarea id="d_title" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="d_author" class="col-form-label">Author:</label>
                                    <textarea id="d_author" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="d_genre" class="col-form-label">Genre:</label>
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
                            <button class="btn btn-success" disabled>Borrow this book</button>
                        @endif
                    @endif
                    <button class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

{{--    <!-- 借阅详情模态框 -->Rental details modal box--}}
    <div class="modal fade" id="rentalDetailModal" tabindex="-1" aria-labelledby="rentalDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Rental details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false;">
                        <div class="row form-group">
                            <div class="form-group col-sm-6 mb-3">
                                <label for="r_name" class="col-form-label">Name of the borrower reader:</label>
                                <textarea id="r_name" class="form-control" rows="1" style="height: 35px;" readonly>{{session('user')['username']}}</textarea>
                            </div>
                            <div class="form-group col-sm-6 mb-3">
                                <label for="r_created_at" class="col-form-label">Date of rental request:</label>
                                <textarea id="r_created_at" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                            </div>
                            <div class="form-group col-sm-12 mb-3">
                                <label for="r_status" class="col-form-label">Status:</label>
                                <textarea id="r_status" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                            </div>
                            <div class="form-group col-sm-6 mb-3" id="r_processed_at_div">
                                <label for="r_processed_at" class="col-form-label">Date of procession:</label>
                                <textarea id="r_processed_at" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                            </div>
                            <div class="form-group col-sm-6 mb-3" id="r_request_managed_by_div">
                                <label for="r_request_managed_by" class="col-form-label">Librarian's name:</label>
                                <textarea id="r_request_managed_by" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                            </div>
                            <div class="form-group col-sm-12 mb-3" id="r_deadline_div">
                                <label for="r_deadline" class="col-form-label">deadline：</label>
                                <textarea id="r_deadline" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                            </div>
                            <div class="form-group col-sm-6 mb-3" id="r_returned_at_div">
                                <label for="r_returned_at" class="col-form-label">Date of return:</label>
                                <textarea id="r_returned_at" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                            </div>
                            <div class="form-group col-sm-6 mb-3" id="r_return_managed_by_div">
                                <label for="r_return_managed_by" class="col-form-label">Librarian's name:</label>
                                <textarea id="r_return_managed_by" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                            </div>
                            <div class="form-group col-sm-12 mb-3" id="r_late_return_div">
                                <p id="r_late_return" style="color: red">The rental is late</p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function(){
            let id = 0;
            let rentid = 0;

            // 书本详情
            // Book details
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
            // Rent details
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
                    $('#r_created_at').text(data.data.created_at);
                    $('#r_status').text(data.data.status);
                    $('#r_processed_at').text(data.data.request_processed_at);
                    // $('#r_request_managed_by').text(data.requestedManager.name);
                    // $('#r_deadline').text(data.data.deadline);
                    // $('#r_returned_at').text(data.data.returned_at);
                    // $('#r_return_managed_by').text(data.returnedManager.name);
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
                        $('#r_request_managed_by').text(data.requestedManager.name);
                        $('#r_deadline_div').hide();
                        $('#r_returned_at_div').hide();
                        $('#r_return_managed_by_div').hide();
                        $('#r_late_return_div').hide();
                    }
                    else if(data.data.status === 'ACCEPTED')
                    {
                        $('#r_request_managed_by').text(data.requestedManager.name);
                        $('#r_deadline').text(data.data.deadline);
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
                        $('#r_request_managed_by').text(data.requestedManager.name);
                        $('#r_deadline').text(data.data.deadline);
                        $('#r_returned_at').text(data.data.returned_at);
                        $('#r_return_managed_by').text(data.returnedManager.name);
                        $('#r_late_return_div').hide();
                    }
                })
            })

            // 点击导航栏按钮
            // AJAX
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
