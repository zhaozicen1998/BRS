@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <h2 class="index-h2">「查询结果」</h2>
    <p class="index-h2-p mb-5 mt-3">要新建查询，请点击导航栏上搜索按钮</p>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <table class="table table-hover table-striped" style="width: 95%;margin: 0 auto">
                    <thead>
                        <tr>
                            <th scope="col">序号</th>
                            <th scope="col">书名</th>
                            <th scope="col">作者</th>
                            <th scope="col">日期</th>
                            <th scope="col">描述</th>
                            <th scope="col" class="text-center">功能</th>
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
                                <button class="btn btn-success btn-xs" id="bookdetails" data-bs-target="#bookDetailModal" data-bs-toggle="modal" data-id="{{$result['id']}}">详情</button>
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

{{--    借书成功之后的弹窗--}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div class="toast align-items-center text-white bg-success border-0" id="borrowSuccess" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                借阅请求发送成功！
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

{{--    借书失败后的弹窗--}}
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

{{--如果搜索不到结果，模态框的result值是不存在的，会报错，所以要在这里做个判断--}}
@if(isset($result))
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
                            <img id="d_image" src="{{asset("image/book/No_Image.png")}}" class="rounded img-fluid">
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
                            <button class="btn btn-success borrow-submit" disabled>借这本书</button>
                        @endif
                    @endif
                    <button class="btn btn-primary" data-bs-dismiss="modal">确认</button>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    $(document).ready(function(){
        let id = 0;

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

        // 借书
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
    })
</script>


@endsection
