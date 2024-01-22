@extends('layouts.home')

@section('lomposts')
    <div class="row">
        <form action="{{ route('lompost.update', $lompost->id) }}" method="post">
            @csrf
            @method('patch')
            <div class="mb-3">
                <label for="follower_name" class="form-label">Имя</label>
                    <div>
                        {{ $lompost->lom_name }}
                    </div>
                </div>
            <div class="mb-3">
                <label for="post_link" class="form-label">Ссылка на пост</label>
                <input type="text" name="post_link" class="form-control" id="post_link" required value="{{ $lompost->post_link }}">
            </div>
            <div class="mb-3">
                <label for="post_type" class="form-label">Президент/СВО</label>
                <select name="post_type" class="form-control" id="post_type" required>
                    @if ( $lompost->post_type == 'Президент') 
                        <option selected value="Президент">Президент</option>
                        <option value="СВО">СВО</option>
                    @else
                        <option value="Президент">Президент</option>
                        <option selected value="СВО">СВО</option>
                    @endif
                </select>
            </div>
            <div class="mb-3">
                <label for="post_prism" class="form-label">Занесено в Посев: </label>
                <input type="checkbox" name="post_prism" class="form-check-input" id="post_prism" {{ $lompost->post_prism }}>
            </div>
            <div class="mb-3">
                <label for="post_date" class="form-label">Дата выхода поста</label>
                <input class="form-control" name="post_date" id="post_date" required type="date" value="{{ $lompost->post_date }}">
            </div>
            <div class="mt-5">
                <a href="{{ route('lompost.index') }}"  style="text-decoration: none;">
                    <div class="btn btn-info">Назад</div>
                </a>
                <button type="submit" class="btn btn-primary">Обновить</button>
            </div>
        </form>
    <div>
@endsection