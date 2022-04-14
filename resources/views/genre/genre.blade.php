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


@endsection
