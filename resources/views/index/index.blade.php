@extends('layouts.app')

@section('content')

{{--    欢迎框--}}
    <div class="container mb-4">
        @if(empty(session('user')))
            <h2 class="index-h2">「欢迎您，游客！」</h2>
            <p class="index-h2-p mb-5 mt-3">点击注册按钮，成为我们的会员！已有账号请登录！</p>
        @else
            <h2 class="index-h2">「欢迎您，{{session('user')['username']}}！」</h2>
            <p class="index-h2-p mb-5 mt-3">您可以点击下列按钮使用功能，也可以点击导航栏上的按钮</p>
        @endif

{{--     功能框--}}
        <div class="row index-content ms-auto" style="width: 100%">
{{--            搜索书籍--}}
            <div class="col-lg-4 mb-4 mt-4">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <img src="{{asset('image/tab-1.png')}}" alt="tab-1">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <button class="btn btn-outline-dark my-2 my-sm-3" data-target="#searchModal" data-toggle="modal">搜索书籍</button>
                        <p class="mb-2">通过书名，作者名进行搜索</p>
                    </div>
                </div>
            </div>
{{--      按分类展示--}}
            <div class="col-lg-4 mb-4 mt-4">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <img src="{{asset('image/tab-2.png')}}" alt="tab-2">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <button class="btn btn-outline-dark my-2 my-sm-3" data-target="#genresModal" data-toggle="modal">按类索引</button>
                        <p class="mb-2">依分类展示本馆所有书籍</p>
                    </div>
                </div>
            </div>
{{--根据用户是否登陆，用户类型判断显示的功能按钮--}}
            @if(empty(session('user')))
                <div class="col-lg-4 mb-4 mt-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="{{asset('image/tab-3.png')}}" alt="tab-3">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <button class="btn btn-outline-dark my-2 my-sm-3">更多功能</button>
                            <p class="mb-2">请登录后查看~</p>
                        </div>
                    </div>
                </div>
            @elseif(session('user')['is_librarian'] == 0)
                {{--我的借阅--}}
                <div class="col-lg-4 mb-4 mt-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="{{asset('image/tab-3.png')}}" alt="tab-3">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <button class="btn btn-outline-dark my-2 my-sm-3" data-target="#myRentalModal" data-toggle="modal">我的借阅</button>
                            <p class="mb-2">管理我的借阅详细信息</p>
                        </div>
                    </div>
                </div>
            @else
                {{--添加新书--}}
                <div class="col-lg-4 mb-4 mt-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="{{asset('image/tab-4.png')}}" alt="tab-4">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <button class="btn btn-outline-dark my-2 my-sm-3" data-target="#addBooksModal" data-toggle="modal">添加新书</button>
                            <p class="mb-2">向系统中添加新的书</p>
                        </div>
                    </div>
                </div>
                {{--管理流派--}}
                <div class="col-lg-4 mb-4 mt-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="{{asset('image/tab-5.png')}}" alt="tab-5">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <button class="btn btn-outline-dark my-2 my-sm-3" data-target="#genresManageModal" data-toggle="modal">流派列表</button>
                            <p class="mb-2">管理系统中所有的流派</p>
                        </div>
                    </div>
                </div>
                {{--管理所有借阅--}}
                <div class="col-lg-4 mb-4 mt-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="{{asset('image/tab-3.png')}}" alt="tab-3">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <button class="btn btn-outline-dark my-2 my-sm-3" data-target="#borrowManageModal" data-toggle="modal">借阅管理</button>
                            <p class="mb-2">管理系统中所有的借阅</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{--    页脚--}}
    <footer class="footer bg-dark p-5 text-light text-center">
        <p class="m-1">现有用户数量：{{$usersCount}}，现有书籍数量：{{$booksCount}}，现有的体裁数量：{{$genresCount}}</p>
        <p class="m-1">活跃的图书租赁数量：{{$acceptCount}}</p>
    </footer>
@endsection
