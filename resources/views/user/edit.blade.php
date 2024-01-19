@extends('layouts.home')

@section('users')
    <div class="row">
        <form action="{{ route('user.update', $user->id) }}" method="post">
            @csrf
            @method('patch')
            <div class="mb-3">
                <label for="name" class="form-label">Login</label>
                <input value="{{ $user->name }}" type="text" name="name" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input class="form-control" name="email" id="email" required value="{{ $user->email }}">
            </div>
            <div class="mb-3 d-none">
                <label for="role" class="form-label">Роль</label>
                <input value="{{ $user->role }}" type="text" class="form-control" name="role" id="role" required>
            </div>
            <label for="token" class="form-label">VK_token</label>
                <input value="{{ $user->token }}" type="text" class="form-control" name="token" id="token" required>
            </div>
            <a href="https://oauth.vk.com/authorize?client_id=51465346&scope=notify,friends,photos,audio,video,stories,pages,status,notes,wall,ads,offline,docs,groups,notifications,stats,email&response_type=token" target="_blank"><div>Получить ВК токен</div></a>
            <div class="mt-5">
                <a href="{{ route('user.index') }}"  style="text-decoration: none;">
                    <div class="btn btn-info">Назад</div>
                </a>
                <button type="submit" class="btn btn-primary">Обновить</button>
            </div>
        </form>
    <div>
@endsection