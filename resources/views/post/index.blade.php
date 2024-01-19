@extends('layouts.home')

@section('posts')
    <div class="row">
        <div class="text-dark">Посты</div>
        <table class="table table-striped" id="postsTable">
            <thead>
                <tr>
                    <th scope="col">Группа</th>
                    <th scope="col">Участников</th>
                    <th scope="col">Дата</th>
                    <th scope="col">ID поста</th>
                    <th scope="col">Текст</th>
                    <th scope="col">Просмотры</th>
                    <th scope="col">Лайки</th>
                    <th scope="col">Репосты</th>
                    <th scope="col">Пост-репост</th>
                </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>
                        <a class="text-decoration-none text-dark" target="_blank" href="https://vk.com/club{{ $post->group_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Перейти к группе">
                            <div class="col">
                                {{ $post->group_name }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <div class="col">
                            {{ $post->members }}
                        </div>
                    </td>

                    <td>
                        <div class="col">
                            {{ $post->date }}
                        </div>
                    </td>
                    <td>
                        <a class="text-decoration-none text-dark" target="_blank" href="https://vk.com/public{{ $post->group_id }}?w=wall-{{ $post->group_id }}_{{ $post->post_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Перейти к посту">
                            <div class="col">
                                {{ $post->post_id }}
                            </div>
                        </a>
                    </td>
                    <td>
                         <a class="text-decoration-none text-dark" target="_blank" href="https://vk.com/public{{ $post->group_id }}?w=wall-{{ $post->group_id }}_{{ $post->post_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Перейти к посту">
                            <div class="col">
                                {{ isset($post->text) ? substr($post->text, 0, 100) : '' }}
                                {{ isset($post->caption) ? substr($post->caption, 0, 100) : '' }}
                            </div>
                        </a>
                    </td>
                    <td>
                        <div class="col">
                            {{ $post->views }}
                        </div>

                    </td>
                    <td>
                        <div class="col">
                            {{ $post->likes }}
                        </div>
                    </td>
                    <td>
                        <div class="col">
                            {{ $post->reposts }}
                        </div>
                    </td>
                    <td>
                        <div class="col">
                            {{ $post->is_repost }}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>

        </div>
    <div>
@endsection