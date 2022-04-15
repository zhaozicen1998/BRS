@extends('layouts.app')

@section('content')

{{--    欢迎框--}}
    <div class="container mb-4">
        @if(empty(session('user')))
            <h2 class="index-h2">「Welcome, visitor!」</h2>
            <p class="index-h2-p mb-5 mt-3">Click the Register button to become our member! Please login if you already have an account!</p>
        @else
            <h2 class="index-h2">「Welcome, {{session('user')['username']}}！」</h2>
            <p class="index-h2-p mb-5 mt-3">You can use the functions by clicking the following buttons. You can also click the buttons on the navigation bar</p>
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
                        <button class="btn btn-outline-dark my-2 my-sm-3" data-bs-target="#searchModal" data-bs-toggle="modal">Search books</button>
                        <p class="mb-2">Search book by title or author's name</p>
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
                        <button class="btn btn-outline-dark my-2 my-sm-3" data-bs-target="#genresModal" data-bs-toggle="modal">List by genre</button>
                        <p class="mb-2">Display all our books by genre</p>
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
                            <button class="btn btn-outline-dark my-2 my-sm-3">More features</button>
                            <p class="mb-2">Please login to view~</p>
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
                            <a class="btn btn-outline-dark my-2 my-sm-3" href="{{url('myrental')}}">My rentals</a>
                            <p class="mb-2">Manage my rental details</p>
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
                            <button class="btn btn-outline-dark my-2 my-sm-3" data-bs-target="#addBooksModal" data-bs-toggle="modal">Add new book</button>
                            <p class="mb-2">Add new books to the system</p>
                        </div>
                    </div>
                </div>
                {{--流派列表--}}
                <div class="col-lg-4 mb-4 mt-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="{{asset('image/tab-5.png')}}" alt="tab-5">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <a class="btn btn-outline-dark my-2 my-sm-3" href="{{url('genre/list')}}">Genre list</a>
                            <p class="mb-2">Manage all genres in the system</p>
                        </div>
                    </div>
                </div>
                {{--添加流派--}}
                <div class="col-lg-4 mb-4 mt-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="{{asset('image/tab-6.png')}}" alt="tab-5">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <button class="btn btn-outline-dark my-2 my-sm-3" data-bs-target="#addGenresModal" data-bs-toggle="modal">Add new genre</button>
                            <p class="mb-2">Add new genres to the system</p>
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
                            <a class="btn btn-outline-dark my-2 my-sm-3" href="{{url('rental')}}">Rental list</a>
                            <p class="mb-2">Manage all rental information in the system</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{--    页脚--}}
    <footer class="footer bg-dark p-5 text-light text-center">
        <p class="m-1">Number of users in the system: {{$usersCount}}，Number of books: {{$booksCount}}，Number of genres: {{$genresCount}}</p>
        <p class="m-1">Number of active book rentals: {{$acceptCount}}</p>
    </footer>
@endsection
