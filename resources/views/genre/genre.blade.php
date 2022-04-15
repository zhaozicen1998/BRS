@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h2 class="index-h2">「流派列表」</h2>
        <p class="index-h2-p mb-5 mt-3">当前系统中有如下流派：</p>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <table class="table table-hover table-striped" style="width: 95%;margin: 0 auto">
                        <thead>
                        <tr>
                            <th scope="col">序号</th>
                            <th scope="col">名称</th>
                            <th scope="col">风格</th>
                            <th scope="col" class="text-center">功能</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($results as $result)
                            <tr>
                                <th scope="row">{{$result['id']}}</th>>
                                <td>{{$result['name']}}</td>
                                <td>{{$result['style']}}</td>
                                <td class="text-center">
                                    <button class="btn btn-primary btn-xs" id="editgenre" data-bs-target="#editGenreModal" data-bs-toggle="modal" data-id="{{$result['id']}}">编辑</button>
                                    <button class="btn btn-danger btn-xs" id="deletegenre" data-bs-target="#deleteGenreModal" data-bs-toggle="modal" data-id="{{$result['id']}}">删除</button>
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

    <!-- 编辑流派模态框 -->
    <div class="modal fade" id="editGenreModal" tabindex="-1" aria-labelledby="editGenreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">编辑流派</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="was-validated" onsubmit="return false;">
                        <div class="row form-group">
                            <div class="form-group mb-3">
                                <label for="e_genre_name" class="col-form-label">名称：</label>
                                <input type="text" id="e_genre_name" class="form-control" pattern=".{3,255}" required>
                                <div class="invalid-feedback">3-255 characters</div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="e_genre_style" class="col-form-label">风格：</label>
                                <select class="form-select" id="e_genre_style" aria-label="e_genre_style" required>
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
                    <button class="btn btn-primary edit-genre-submit">修改</button>
                </div>
            </div>
        </div>
    </div>

    {{--    编辑流派成功后的弹窗--}}
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-success border-0" id="editGenreSuccess" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    编辑流派成功！
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    {{--    编辑流派失败后的弹窗 - 表单验证不通过--}}
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-danger border-0" id="editGenreFormValidationFailed" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    编辑失败！请正确填写信息！
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    {{--    编辑流派失败后的弹窗 - 流派已存在--}}
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-danger border-0" id="editGenreFailed" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    编辑失败！该流派已存在！
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function () {

        let id = 0;
        // 编辑流派界面
        $('body').on('click', '#editgenre', function (event) {
            event.preventDefault();
            id = $(this).data('id');
            $.get('/genre/' + 'edit/', {id: id}, function (data) {
                $('#e_genre_name').val(data.data.name);
                $("#e_genre_style option").each(function(i,n){
                    if($(n).text() === data.data.style)
                    {
                        $(n).attr("selected",true);
                    }
                })
            })
        })

        // 编辑流派
        $('.edit-genre-submit').click(function () {
            gname = $.trim($("#e_genre_name").val());
            gstyle = $("#e_genre_style option:selected").text();

            if(gname.length >= 3 && gname.length <= 255)
            {
                $.post("{{url('genre/edit/edit')}}", {id: id, name: gname, style: gstyle}, function (res) {
                    if(res.code === 200)
                    {
                        $("#editGenreSuccess").toast("show");
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }
                    else {
                        $("#editGenreFailed").toast("show");
                    }
                }, 'json');
            }
            else {
                $("#editGenreFormValidationFailed").toast("show");
            }
        })
    })


</script>


@endsection
