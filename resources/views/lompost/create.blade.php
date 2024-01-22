@extends('layouts.home')

@section('lomposts')
    <div class="row">
        <form action="{{ route('lompost.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="lom_name" class="form-label">Имя</label>
                <select name="lom_name" class="form-control" id="lom_name" required>
                <option selected disabled>Выберите</option>
                @foreach($lomposts as $lompost)
                    <option value="{{ $lompost->follower_name }}">{{ $lompost->follower_name }}</option>
                @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="post_link" class="form-label">Ссылка на пост</label>
                <input type="text" name="post_link" class="form-control" id="post_link" required>
            </div>
            <div class="mb-3">
                <label for="post_type" class="form-label">Президент/СВО</label>
                <select name="post_type" class="form-control" id="post_type" required>
                    <option selected disabled>Выберите</option>
                    <option value="Президент">Президент</option>
                    <option value="СВО">СВО</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="post_prism" class="form-label">Занесено в Посев: </label>
                <input type="checkbox" name="post_prism" class="form-check-input" id="post_prism" required>
            </div>
            <div class="mb-3">
                <label for="post_date" class="form-label">Дата выхода поста</label>
                <input class="form-control" name="post_date" id="post_date" required type="date">
            </div>
            <div class="mt-5">
                <a href="{{ route('lompost.index') }}"  style="text-decoration: none;">
                    <div class="btn btn-info">Назад</div>
                </a>
                <button type="submit" class="btn btn-primary">Добавить</button>
            </div>
        </form>
    <div>
@endsection