@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h2 class="index-h2">「我的借阅」</h2>
        <p class="index-h2-p mb-5 mt-3">点击下面的导航栏选择借阅类型</p>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <nav class="nav nav-tabs">
                        <a href="#" class="nav-item nav-link active">Rental requests with PENDING status</a>
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
                            <th scope="col">借书日期</th>
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
                                    <button class="btn btn-success btn-xs" id="bookdetails" data-bs-target="#bookDetailModal" data-bs-toggle="modal" data-id="{{$books['id']}}">书本</button>
                                    <button class="btn btn-success btn-xs" id="pendingdetails" data-bs-target="#pendingDetailModal" data-bs-toggle="modal" data-id="{{$results['id']}}">借阅</button>
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
                            <button class="btn btn-success" disabled>借这本书</button>
                        @endif
                    @endif
                    <button class="btn btn-primary" data-bs-dismiss="modal">确认</button>
                </div>
            </div>
        </div>
    </div>


@endsection
