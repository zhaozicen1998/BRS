@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h2 class="index-h2">「Genre list」</h2>
        <p class="index-h2-p mb-5 mt-3">The following genres are currently available in the system:</p>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <table class="table table-hover table-striped" style="width: 95%;margin: 0 auto">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Style</th>
                            <th scope="col" class="text-center">Functions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($results as $result)
                            <tr>
                                <th scope="row">{{$result['id']}}</th>>
                                <td>{{$result['name']}}</td>
                                <td>{{$result['style']}}</td>
                                <td class="text-center">
                                    <button class="btn btn-primary btn-xs" id="editgenre" data-bs-target="#editGenreModal" data-bs-toggle="modal" data-id="{{$result['id']}}">Edit</button>
                                    <button class="btn btn-danger btn-xs" id="deletegenre" data-bs-target="#deleteGenreModal" data-bs-toggle="modal" data-id="{{$result['id']}}">Delete</button>
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

{{--    <!-- 编辑流派模态框 -->Edit genre modal box--}}
    <div class="modal fade" id="editGenreModal" tabindex="-1" aria-labelledby="editGenreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit a genre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="was-validated" onsubmit="return false;">
                        <div class="row form-group">
                            <div class="form-group mb-3">
                                <label for="e_genre_name" class="col-form-label">Name:</label>
                                <input type="text" id="e_genre_name" class="form-control" pattern=".{3,255}" required>
                                <div class="invalid-feedback">3-255 characters</div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="e_genre_style" class="col-form-label">Style:</label>
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
                    <button class="btn btn-primary edit-genre-submit">Edit</button>
                </div>
            </div>
        </div>
    </div>

{{--    <!-- 删除流派模态框 -->Delete genre modal box--}}
    <div class="modal fade" id="deleteGenreModal" tabindex="-1" aria-labelledby="deleteGenreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this genre?</p>
                    <p id="del_name" style="color: red"></p>
                    <p id="del_style" style="color: red"></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger delete-genre-submit">Delete</button>
                </div>
            </div>
        </div>
    </div>

{{--    --}}{{--    编辑流派成功后的弹窗--}}{{--Pop-up window after successful editing the genre--}}
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-success border-0" id="editGenreSuccess" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Editing genre success!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

{{--    --}}{{--    编辑流派失败后的弹窗 - 表单验证不通过--}}{{--Pop-up window after failed genre edit - Form validation not passed--}}
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-danger border-0" id="editGenreFormValidationFailed" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Edit failed! Please fill in the information correctly!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

{{--    --}}{{--    编辑流派失败后的弹窗 - 流派已存在--}}{{--Pop-up window after failed genre edit - Genre already exists--}}
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-danger border-0" id="editGenreFailed" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Edit failed! The genre already exists!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

{{--    --}}{{--    删除流派成功后的弹窗--}}{{--Pop-up window after delete genre succeed--}}
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-success border-0" id="deleteGenreSuccess" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Deleting genre successfully!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

{{--    --}}{{--    删除流派失败后的弹窗--}}{{--Pop-up window after delete genre failed--}}
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div class="toast align-items-center text-white bg-danger border-0" id="deleteGenreFailed" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Failed to delete genre!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function () {

        let id = 0;
        // 编辑流派界面
        // Edit genre interface
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
        // Edit genre
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

        // 删除流派 --- 在模态框中获取流派名称，风格
        // Delete genre --- get genre name and style in modal box
        $('body').on('click', '#deletegenre', function (event) {
            event.preventDefault();
            id = $(this).data('id');
            $.get('/genre/' + 'edit/', {id: id}, function (data) {
                $('#del_name').text('Name of genre is:' + data.data.name);
                $('#del_style').text('Style of genre is:' + data.data.style);
            })
        })

        // 删除流派
        // Delete genre
        $('.delete-genre-submit').click(function () {
            $.post('{{url('genre/del')}}', {id: id}, function (res) {
                if(res.code === 200)
                {
                    $('#deleteGenreSuccess').toast('show');
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                }
                else {
                    $('#deleteGenreFailed').toast('show');
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                }
            }, 'json');
        });
    })


</script>


@endsection
