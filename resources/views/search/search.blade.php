@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <h2 class="index-h2">「Search result」</h2>
    <p class="index-h2-p mb-5 mt-3">To create a new query, click the search button on the navigation bar</p>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <table class="table table-hover table-striped" style="width: 95%;margin: 0 auto">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Author</th>
                            <th scope="col">Date of publish</th>
                            <th scope="col">Description</th>
                            <th scope="col" class="text-center">Function</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($results as $result)
                        <tr>
                            <th scope="row">{{$result['id']}}</th>>
                            <td>{{$result['title']}}</td>
                            <td>{{$result['authors']}}</td>
                            <td>{{$result['released_at']}}</td>
                            <td>{{$result['description']}}</td>
                            <td class="text-center">
                                <button class="btn btn-success btn-xs" id="bookdetails" data-bs-target="#bookDetailModal" data-bs-toggle="modal" data-id="{{$result['id']}}">Detail</button>
                                @if(!empty(session('user')))
                                    @if(session('user')['is_librarian'] == 1)
                                        <button class="btn btn-primary btn-xs" id="editbook" data-bs-target="#editBookModal" data-bs-toggle="modal" data-id="{{$result['id']}}">Edit</button>
                                        <button class="btn btn-danger btn-xs" id="deletebook" data-bs-target="#deleteBookModal" data-bs-toggle="modal" data-id="{{$result['id']}}">Delete</button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div style="text-align: center; margin:0 auto">{{$results->links()}}</div>
            </div>
        </div>
    </div>
</div>

{{--    借书成功之后的弹窗--}}{{--Pop-up window after successful book loan--}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div class="toast align-items-center text-white bg-success border-0" id="borrowSuccess" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Rent request sent successfully!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

{{--    借书失败后的弹窗--}}{{--Pop-up window after failed book loan--}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div class="toast align-items-center text-white bg-danger border-0" id="borrowFailed" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <p id="borrowFailedMessage"></p>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

{{--    编辑图书成功之后的弹窗--}}{{--Pop-up window after successful book editing--}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div class="toast align-items-center text-white bg-success border-0" id="editBookSuccess" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Change of book information successful!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

{{--   编辑图书失败后的弹窗：ISBN号冲突--}}{{--Pop-up window after failed book edit: ISBN number conflict--}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div class="toast align-items-center text-white bg-danger border-0" id="editBookFailed" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Failed to chenge the book information! The ISBN number conflicts with other books already in the database!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

{{--    编辑图书失败后的弹窗：表单验证不通过--}}{{--Pop-up after a failed book edit: form validation not passed--}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div class="toast align-items-center text-white bg-danger border-0" id="editBookFormValidationFailed" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Change of book information failed! Please fill in the information correctly!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

{{--    删除图书成功之后的弹窗--}}{{--Pop-up window after successful book deletion--}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div class="toast align-items-center text-white bg-success border-0" id="deleteBookSuccess" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Delete successfully!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

{{--    删除图书失败后的弹窗--}}{{--Pop-up window after book deletion failed--}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div class="toast align-items-center text-white bg-danger border-0" id="deleteBookFailed" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Delete failed!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

{{--如果搜索不到结果，模态框的result值是不存在的，会报错，所以要在这里做个判断--}}
@if(isset($result))
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
                            <img id="d_image" alt="No_image" src="{{asset("image/book/No_Image.png")}}" class="rounded img-fluid">
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
                            <button class="btn btn-success borrow-submit" disabled>Borrow this book</button>
                        @endif
                    @endif
                    <button class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

{{--    <!-- 编辑书本模态框 -->Edit book modal box--}}
    <div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="was-validated" onsubmit="return false;" autocomplete="off">
                        <div class="row form-group">
                            <div class="form-group mb-3 col-sm-12">
                                <label for="e_title" class="col-form-label">Title:</label>
                                <input type="text" id="e_title" class="form-control" pattern=".{1,255}" required>
                                <div class="invalid-feedback">max. 255 characters</div>
                            </div>
                            <div class="form-group mb-3 col-sm-6">
                                <label for="e_author" class="col-form-label">Author:</label>
                                <input type="text" id="e_author" class="form-control" pattern=".{1,255}" required>
                                <div class="invalid-feedback">max. 255 characters</div>
                            </div>
                            <div class="form-group mb-3 col-sm-6">
                                <label for="e_released_at" class="col-form-label">Date of publish:</label>
                                <input type="date" id="e_released_at" class="form-control" max="" required>
                                <div class="invalid-feedback">must before now</div>
                            </div>
                            <div class="form-group mb-3 col-sm-2">
                                <label for="e_pages" class="col-form-label">Pages:</label>
                                <input type="number" id="e_pages" class="form-control" min="1" required>
                                <div class="invalid-feedback">at least 1</div>
                            </div>
                            <div class="form-group mb-3 col-sm-4">
                                <label for="e_isbn" class="col-form-label">ISBN：</label>
                                <input type="text" id="e_isbn" class="form-control" pattern="^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$" required>
                                <div class="invalid-feedback">isbn wrong</div>
                            </div>
                            <div class="form-group mb-3 col-sm-6">
                                <label for="e_in_stock" class="col-form-label">Number of this book in the library：</label>
                                <input type="number" id="e_in_stock" class="form-control" min="0" required>
                                <div class="invalid-feedback">At least 0</div>
                            </div>
                            <div class="form-group mb-3 col-sm-10">
                                <label for="e_description" class="col-form-label">Description:</label>
                                <textarea id="e_description" class="form-control" rows="1" style="height: 35px;"></textarea>
                            </div>
                            <div class="form-group mb-3 col-sm-2">
                                <label for="e_language_code" class="col-form-label">Language:</label>
                                <input type="text" id="e_language_code" class="form-control">
                            </div>
                            <div class="form-group mb-3 col-sm-6">
                                <label for="e_genre" class="col-form-label">Genre:</label>
                                <select class="form-select" id="e_genre" aria-label="e_genre" required></select>
                            </div>
                            <div class="form-group mb-3 col-sm-6">
                                <label for="e_cover_image" class="col-form-label">Book cover:</label>
                                <input name="filesToUpload" type="file" id="e_cover_image" class="form-control" accept="image/gif,image/jpeg,image/jpg,image/png,image/svg">
                                <p id="eUploadSuccess" style="color: green" >Image uploaded successfully!</p>
                                <p id="eUploadFailed" style="color: red" >Image uploaded failed!</p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary edit-book-submit">Edit</button>
                </div>
            </div>
        </div>
    </div>

{{--    <!-- 删除书本模态框 -->Delete book modal box--}}
    <div class="modal fade" id="deleteBookModal" tabindex="-1" aria-labelledby="deleteBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this book?</p>
                    <p id="del_title" style="color: red"></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger delete-book-submit">Delete</button>
                </div>
            </div>
        </div>
    </div>


@endif

<script>
    $(document).ready(function(){
        let id = 0;

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

        // 借书
        // Borrow book
        $('.borrow-submit').click(function () {
            $.post("{{url('borrow')}}", {bookid: id}, function (res) {
                if(res.code === 200)
                {
                    $("#borrowSuccess").toast("show");
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                }
                else {
                    $("#borrowFailedMessage").text(res.msg);
                    $("#borrowFailed").toast("show");
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                }
            }, 'json');
        });

        // 编辑书本界面
        // Edit book interface
        $('body').on('click', '#editbook', function (event) {
            event.preventDefault();
            $('#eUploadSuccess').hide();
            $('#eUploadFailed').hide();
            id = $(this).data('id');
            $.get('/search/' + 'detail/' + id, function (data) {
                $('#e_description').text(data.data.description);
                $('#e_released_at').val(data.data.released_at);
                $('#e_pages').val(data.data.pages);
                $('#e_language_code').val(data.data.language_code);
                $('#e_title').val(data.data.title);
                $('#e_author').val(data.data.authors);
                $('#e_isbn').val(data.data.isbn);
                $('#e_in_stock').val(data.data.in_stock);
                $.each(data.genres, function (index, genres) {
                    let option = "<option value='" + genres.id + "'>" + genres.name + " - " + genres.style +"</option>";
                    $("#e_genre").append(option);
                })
                $('#e_genre').val(data.genre.id);
            })
        })

        // 编辑书本_图片
        // Edit book's cover image
        let cover_image = "";
        $('#e_cover_image').change(function () {
            var formData = new FormData();
            formData.append('photo', $('#e_cover_image')[0].files[0]);
            $.ajax({
                url: "{{url('photo')}}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (res) {
                    $('#eUploadSuccess').show();
                    cover_image = res.imagePath;
                },
                error: function (res) {
                    $('#eUploadFailed').show();
                }
            });
        })

        // 编辑书本提交
        // Edit book submit
        $('.edit-book-submit').click(function () {
            title = $.trim($("#e_title").val());
            author = $.trim($("#e_author").val());
            released_at = $.trim($("#e_released_at").val());
            pages = $.trim($("#e_pages").val());
            isbn = $.trim($("#e_isbn").val());
            reg = /^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/i;
            description = $.trim($("#e_description").val());
            language_code = $.trim($("#e_language_code").val());
            genre_id = $("#e_genre option:selected").attr('value');
            in_stock = $.trim($("#e_in_stock").val());

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
                        $.post("{{url('editbook')}}", {id: id, title: title, author: author, released_at: released_at, pages: pages, isbn: isbn, description: description, language_code: language_code, genre_id: genre_id, in_stock: in_stock, cover_image: cover_image}, function (res) {
                            if(res.code === 200)
                            {
                                $("#editBookSuccess").toast("show");
                                setTimeout(function () {
                                    window.location.reload();
                                }, 2000);
                            }
                            else {
                                $("#editBookFailed").toast("show");
                            }
                        }, 'json');
                    }
                    else{
                        $("#editBookFormValidationFailed").toast("show");
                    }
                }
                else{
                    $("#editBookFormValidationFailed").toast("show");
                }
            }
            else{
                $("#editBookFormValidationFailed").toast("show");
            }
        });

        // 删除书本 --- 在模态框中获取书名
        // Delete book --- Get the book title in modal box
        $('body').on('click', '#deletebook', function (event) {
            event.preventDefault();
            id = $(this).data('id');
            $.get('/search/' + 'detail/' + id, function (data) {
                $('#del_title').text('The title of this book is: ' + data.data.title);
            })
        })

        // 删除书本
        // Delete book
        $('.delete-book-submit').click(function () {
            $.post('{{url('deletebook')}}', {id: id}, function (res) {
                if(res.code === 200)
                {
                    $('#deleteBookSuccess').toast('show');
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                }
                else {
                    $('#deleteBookFailed').toast('show');
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                }
            }, 'json');
        });

    })
</script>


@endsection
