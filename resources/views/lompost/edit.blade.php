@extends('layouts.home')

@section('loms')
    <div class="row">
        <form action="{{ route('lom.update', $lom->id) }}" method="post">
            @csrf
            @method('patch')
            <div class="mb-3">
                <label for="url" class="form-label">url</label>
                <input type="text" name="url" class="form-control" id="url" required value="{{ $lom->url }}">
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">type</label>
                <input class="form-control" name="type" id="type" required value="vk.com">
            </div>
            <div class="mt-5">
                <a href="{{ route('lom.index') }}"  style="text-decoration: none;">
                    <div class="btn btn-info">Назад</div>
                </a>
                <button type="submit" class="btn btn-primary">Обновить</button>
            </div>
        </form>
    <div>
@endsection