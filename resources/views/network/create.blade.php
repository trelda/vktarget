@extends('layouts.home')

@section('networks')
    <div class="row">
        <form action="{{ route('network.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="url" class="form-label">url</label>
                <input type="text" name="url" class="form-control" id="url" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">type</label>
                <input class="form-control" name="type" id="type" required value="vk.com">
            </div>
            <div class="mt-5">
                <a href="{{ route('network.index') }}"  style="text-decoration: none;">
                    <div class="btn btn-info">Назад</div>
                </a>
                <button type="submit" class="btn btn-primary">Обновить</button>
            </div>
        </form>
    <div>
@endsection