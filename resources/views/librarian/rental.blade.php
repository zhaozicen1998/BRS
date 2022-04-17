@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h2 class="index-h2">「Rental list」</h2>
        <p class="index-h2-p mb-5 mt-3">Click on the navigation bar below to select the type of rental</p>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <ul class="nav nav-pills justify-content-center rentalMenu">
                        <li class="nav-item">
                            <a href="{{url('/rental/pending')}}" class="nav-link active" id="pending" data-id="pending">Rental requests with PENDING status</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/rental/accepted')}}" class="nav-link" id="accepted" data-id="accepted">Accepted and in-time rentals</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/rental/late')}}" class="nav-link" id="late" data-id="late">Accepted late rentals</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/rental/rejected')}}" class="nav-link" id="rejected" data-id="rejected">Rejected rental requests</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/rental/returned')}}" class="nav-link" id="returned" data-id="returned">Returned rentals</a>
                        </li>
                    </ul>
                    <div id="table-content">
                        <table class="table table-hover table-striped" style="width: 95%;margin: 0 auto">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Book title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Date of rental</th>
                                <th scope="col">Renter</th>
                                <th scope="col">deadline</th>
                                <th scope="col" class="text-center">Functions</th>
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
                                        <button class="btn btn-primary btn-xs" id="bookdetails" data-bs-target="#bookDetailModal" data-bs-toggle="modal" data-id="{{$books[$x]->get()->pluck('id')->first()}}">Book Details</button>
                                        <button class="btn btn-warning btn-xs" id="rentaldetails" data-bs-target="#rentalDetailModal" data-bs-toggle="modal" data-id="{{$results[$x]['id']}}">Rent Details</button>
                                        @if($results[$x]['status'] === "PENDING")
                                            <button class="btn btn-success btn-xs" id="acceptrental" data-bs-target="#acceptRentalModal" data-bs-toggle="modal" data-id="{{$results[$x]['id']}}">Accept</button>
                                            <button class="btn btn-danger btn-xs" id="rejectrental" data-bs-target="#rejectRentalModal" data-bs-toggle="modal" data-id="{{$results[$x]['id']}}">Reject</button>
                                        @elseif($results[$x]['status'] === "ACCEPTED")
                                            <button class="btn btn-success btn-xs" id="returnbook" data-bs-target="#returnBookModal" data-bs-toggle="modal" data-id="{{$results[$x]['id']}}">Return</button>
                                        @endif
                                    </td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                        <div style="text-align: center; margin:0 auto">{{$books->links()}}</div>
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
                                <label for="r_name" class="col-form-label">Renter's name:</label>
                                <textarea id="r_name" class="form-control" rows="1" style="height: 35px;" readonly></textarea>
                            </div>
                            <div class="form-group col-sm-6 mb-3">
                                <label for="r_created_at" class="col-form-label">Date of rental:</label>
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
                                <p id="r_late_return" style="color: red">The rental is late!</p>
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

{{--    <!-- 接受借阅申请模态框 -->Accepting rental requests modal box--}}
    <div class="modal fade" id="acceptRentalModal" tabindex="-1" aria-labelledby="acceptRentalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Accept</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to accept this rental request?</p>
                    <form class="was-validated" onsubmit="return false;">
                        <div class="form-group mb-3">
                            <label for="ac_deadline" class="col-form-label">Set deadline：</label>
                            <input type="datetime-local" id="ac_deadline" class="form-control" required>
                            <div class="invalid-feedback">No earlier than the current time</div>
                        </div>
                    </form>
                    <p id="ac_username" style="color: red"></p>
                    <p id="ac_bookname" style="color: red"></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-success accept-rental-submit">Accept</button>
                </div>
            </div>
        </div>
    </div>

{{--    <!-- 拒绝借阅申请模态框 -->Reject of rental request modal box--}}
    <div class="modal fade" id="rejectRentalModal" tabindex="-1" aria-labelledby="rejectRentalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to reject this rental request?</p>
                    <p id="rj_username" style="color: red"></p>
                    <p id="rj_bookname" style="color: red"></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger reject-rental-submit">Reject</button>
                </div>
            </div>
        </div>
    </div>

{{--    <!-- 还书模态框 -->Book return modal box--}}
    <div class="modal fade" id="returnBookModal" tabindex="-1" aria-labelledby="returnBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Return book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure the book has been returned?</p>
                    <p id="rt_username" style="color: red"></p>
                    <p id="rt_bookname" style="color: red"></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-success return-book-submit">Return</button>
                </div>
            </div>
        </div>
    </div>

    <!-- pending->accepted success -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-success border-0" id="pendingToAcceptedSuccess" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Rental accepted successfully!
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
                    Rental acceptance failed! Please fill the deadline correct!
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
                    Rental acceptance failed!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- pending->rejected success -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-success border-0" id="pendingToRejectedSuccess" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Rental reject success!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- pending->rejected failed -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-danger border-0" id="pendingToRejectedFailed" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Rental reject failed!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- accepted->returned success -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-success border-0" id="acceptedToReturnedSuccess" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Book return success!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- accepted->returned failed -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-danger border-0" id="acceptedToReturnedFailed" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Book return failed！
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            let id = 0;
            let rentid = 0;
            let url = window.location.href;
            if(url.indexOf("accepted") >= 0)
            {
                $('#accepted').addClass("active");
                $('#pending').removeClass("active");
            }
            else if(url.indexOf("late") >= 0)
            {
                $('#late').addClass("active");
                $('#pending').removeClass("active");
            }
            else if(url.indexOf("rejected") >= 0)
            {
                $('#rejected').addClass("active");
                $('#pending').removeClass("active");
            }
            else if(url.indexOf("returned") >= 0)
            {
                $('#returned').addClass("active");
                $('#pending').removeClass("active");
            }

            // 书本详情
            // Book detatils
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
                // Disable the borrow button if there are no books in stock
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
                    $('#r_name').text(data.user.name);
                    $('#r_created_at').text(data.data.created_at);
                    $('#r_status').text(data.data.status);
                    $('#r_processed_at').text(data.data.request_processed_at);
                    // $('#r_request_managed_by').text(data.requestedManager.name);
                    // $('#r_deadline').text(data.data.deadline);
                    // $('#r_returned_at').text(data.returnedManager.name);
                    // $('#r_return_managed_by').text(data.data.return_managed_by);
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

            // 接受借阅模态框需要的值
            // the value which 'accept rental' modal box need
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
                    $('#ac_username').text('Username: ' + data.user.name);
                    $('#ac_bookname').text('Book title: ' + data.book.title);
                })
            })

            // 接受借阅
            // Accept rental
            $('.accept-rental-submit').click(function () {

                deadline = $.trim($("#ac_deadline").val());
                deadline = deadline.replace(/T/g, ' ').replace(/.[\d]{3}Z/, ' ');
                let now = new Date();
                now = now.toLocaleDateString().replace('/','-').replace('/','-');
                now_Date = new Date(now);
                deadline_Date = new Date(deadline);
                deadline = deadline + ':00';
                if(deadline_Date >= now_Date)
                {
                    $.post('{{url('rental/pending/toaccept')}}', {id: rentid, deadline: deadline}, function (res) {
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

            // 拒绝借阅模态框需要的值
            // the value which 'reject rental' modal box need
            $('body').on('click', '#rejectrental', function (event) {
                event.preventDefault();
                rentid = $(this).data('id');
                $.get('/rental/' + 'find/', {id: rentid}, function (data) {
                    $('#rj_username').text('Username: ' + data.user.name);
                    $('#rj_bookname').text('Bookname: ' + data.book.title);
                })
            })

            // 拒绝借阅
            // reject rental
            $('.reject-rental-submit').click(function () {

                $.post('{{url('rental/pending/toreject')}}', {id: rentid}, function (res) {
                    if(res.code === 200)
                    {
                        $('#pendingToRejectedSuccess').toast('show');
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }
                    else {
                        $('#pendingToRejectedFailed').toast('show');
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }
                }, 'json');
            });

            // 还书模态框需要的值
            // the value which 'return book' modal box need
            $('body').on('click', '#returnbook', function (event) {
                event.preventDefault();
                rentid = $(this).data('id');
                $.get('/rental/' + 'find/', {id: rentid}, function (data) {
                    $('#rt_username').text('Username: ' + data.user.name);
                    $('#rt_bookname').text('Bookname: ' + data.book.title);
                })
            })

            // 还书
            // Return book
            $('.return-book-submit').click(function () {

                $.post('{{url('rental/returnbook')}}', {id: rentid}, function (res) {
                    if(res.code === 200)
                    {
                        $('#acceptedToReturnedSuccess').toast('show');
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }
                    else {
                        $('#acceptedToReturnedFailed').toast('show');
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }
                }, 'json');
            });

            // 点击导航栏按钮
            // AJAX
            $('.rentalMenu').on('click', 'a', function(e) {
                e.preventDefault(); // 阻止链接跳转
                var url = this.href; // 保存点击的地址

                $('a.active').removeClass('active');
                $(this).addClass('active');

                $('#table-content').load(url + ' #table-content').fadeIn('slow');
            });

            // 分页ajax
            $('body').on('click', '.pagination a', function(e){
                e.preventDefault();
                var url = this.href;

                $('#table-content').load(url + ' #table-content').fadeIn('slow');
            });
        })
    </script>

@endsection
