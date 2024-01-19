@extends('layouts.home')

@section('users')
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">name</th>
                    <th scope="col">email</th>
                    <th scope="col">role</th>
                    <th scope="col" class="col d-flex flex-row justify-content-center">Управление</th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('user.edit', $user->id) }}">
                            <div class="col">
                                {{ $user->id }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('user.edit', $user->id) }}">
                            <div class="col">
                                {{ $user->name }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('user.edit', $user->id) }}">
                            <div class="col">
                                {{ $user->email }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('user.edit', $user->id) }}">
                            <div class="col">
                                {{ $user->role }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <div class="col d-flex flex-row justify-content-center">
                            <form action="{{ route('user.delete', $user->id) }}" method="post">
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
        {{ $users->withQueryString()->links() }}
        </div>
        <div class="col-md-1">
            <a href="#">
                <button type="button" class="btn btn-primary">Добавить</button>
            </a>
        </div>
    <div>
@endsection