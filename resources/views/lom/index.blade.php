@extends('layouts.home')

@section('loms')
    <div class="row">
    <div class="text-decoration-none text-dark">Лидеры общественного мнения</div>
    <div class="col-md-1">
            <a href="{{ route('lom.create') }}">
                <button type="button" class="btn btn-primary">Добавить</button>
            </a>
        </div>
        <div class="col-md-1">
            <a class="text-decoration-none text-dark" href="{{ route('lom.export') }}">
                <button type="button" class="btn btn-success">Экспорт</button>
            </a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ссылка</th>
                    <th scope="col">Имя</th>
                    <th scope="col">Должность</th>
                    <th scope="col">Друзья</th>
                    <th scope="col">Подписчики</th>
                    <th scope="col" class="col d-flex flex-row justify-content-center">Управление</th>
                </tr>
            </thead>
            <tbody>
            @foreach($loms as $lom)
                <tr>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('loms.edit', $lom->id) }}">
                            <div class="col">
                                {{ $lom->id }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('loms.edit', $lom->id) }}">
                            <div class="col">
                                {{ $lom->url }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('loms.edit', $lom->id) }}">
                            <div class="col">
                                {{ $lom->follower_name }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('loms.edit', $lom->id) }}">
                            <div class="col">
                                {{ $lom->follower_job }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('loms.edit', $lom->id) }}">
                            <div class="col">
                                {{ $lom->friends }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('loms.edit', $lom->id) }}">
                            <div class="col">
                                {{ $lom->followers }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <div class="col d-flex flex-row justify-content-center">
                            <form action="{{ route('loms.delete', $lom->id) }}" method="post">
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
            {{ $loms->withQueryString()->links() }}
        </div>
    <div>
@endsection