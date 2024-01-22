@extends('layouts.home')

@section('lomposts')
    <div class="row">
    <div class="text-decoration-none text-dark">Отчет по ломам</div>
    <div class="col-md-2">
            <a href="{{ route('lompost.create') }}">
                <button type="button" class="btn btn-primary">Добавить</button>
            </a>
        </div>
        <div class="col-md-4">
            <form action="{{ route('lompost.export') }}" method="post">
                @csrf
                <div class="d-flex p-2" style="align-items: center;justify-content: space-between">
                    <div class="d-flex d-row">
                        <label for="from" class="form-label mb-0">from:</label>
                        <input type="date" name="from" id="from">
                    </div>
                    <div class="d-flex d-row">
                        <label for="to" class="form-label mb-0">to:</label>
                        <input type="date" name="to" id="to">
                    </div>
                    <div class="d-flex d-row m-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type_option" id="inlineRadio1" value="Президент">
                            <label class="form-check-label" for="inlineRadio1">Президент</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type_option" id="inlineRadio2" value="СВО">
                            <label class="form-check-label" for="inlineRadio2">СВО</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type_option" id="inlineRadio3" value="all">
                            <label class="form-check-label" for="inlineRadio3">Все</label>
                        </div>
                    </div>
                    <button type="sumbit" class="btn btn-success">Экспорт</button>
                </div>
            </form>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">lom_name</th>
                    <th scope="col">post_link</th>
                    <th scope="col">post_type</th>
                    <th scope="col">post_prism</th>
                    <th scope="col">post_date</th>
                </tr>
            </thead>
            <tbody>
            @foreach($lomposts as $lompost)
                <tr>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('lompost.edit', $lompost->id) }}">
                            <div class="col">
                                {{ $lompost->id }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('lompost.edit', $lompost->id) }}">
                            <div class="col">
                                {{ $lompost->lom_name }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('lompost.edit', $lompost->id) }}">
                            <div class="col">
                                {{ $lompost->post_link }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('lompost.edit', $lompost->id) }}">
                            <div class="col">
                                {{ $lompost->post_type }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('lompost.edit', $lompost->id) }}">
                            <div class="col">
                                {{ $lompost->post_prism }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <a class="text-decoration-none text-dark" href="{{ route('lompost.edit', $lompost->id) }}">
                            <div class="col">
                                {{ $lompost->post_date }}
                            </div>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
        </div>
    <div>
@endsection