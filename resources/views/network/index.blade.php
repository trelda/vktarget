@extends('layouts.home')

@section('networks')
    <div class="row">
    <div class="text-decoration-none text-dark">Группы</div>
        <div class="col-md-1">
            <a href="{{ route('network.create') }}">
                <button type="button" class="btn btn-primary">Добавить</button>
            </a>
        </div>
        <div class="col-md-1">
            <a class="text-decoration-none text-dark" href="{{ route('network.export') }}">
                <button type="button" class="btn btn-success">Экспорт</button>
            </a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ссылка</th>
                    <th scope="col">Соц.сеть</th>
                    <th scope="col">Подписчики</th>
                    <th scope="col" class="col d-flex flex-row justify-content-center">Управление</th>
                </tr>
            </thead>
            <tbody>
            @foreach($networks as $network)
                <tr>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('network.edit', $network->id) }}">
                            <div class="col">
                                {{ $network->id }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('network.edit', $network->id) }}">
                            <div class="col">
                                {{ $network->url }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('network.edit', $network->id) }}">
                            <div class="col">
                                {{ $network->type }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('network.edit', $network->id) }}">
                            <div class="col">
                                {{ $network->delta() }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <div class="col d-flex flex-row justify-content-center">
                            <form action="{{ route('network.delete', $network->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Удалить</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
            {{ $networks->withQueryString()->links() }}
        </div>
    <div>
@endsection