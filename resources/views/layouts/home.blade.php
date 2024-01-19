@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
            @guest
            <div class="col-md-8">
                <div class="row">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('Требуется авторизация') }}
            @else
                <div class="row">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.edit', Auth::user()->id) }}">Профиль</a>
                            </li>
                            @can('view', Auth::user())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.index') }}">Пользователи</a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('network.index') }}">Группы</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('lom.index') }}">ЛОМы</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('post.index') }}">Посты</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('lompost.index') }}">Отчет</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                @yield('users')
                @yield('networks')
                @yield('loms')
                @yield('posts')
                @yield('lomposts')
            </div>
            @endguest
        </div>
    </div>
</div>
@endsection