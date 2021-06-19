@extends('layouts.admin_layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('Blog.Admin.Posts.includes.result_messages')
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Автор</th>
                                <th>Категорія</th>
                                <th>Заголовок</th>
                                <th>Дата публікації</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                @php /** @var \App\Models\Post $post */ @endphp
                                <tr @if(!$post->is_published) style="background-color:#ccc;" @endif>
                                    <td> {{$post->id}}  </td>
                                    <td> {{$post-> user->name}}</td>
                                    <td> {{$post-> category->title}}</td>
                                    <td>
                                        <a href="{{route('blog.admin.posts.edit', $post->id)}}">{{$post->title}}</a>
                                    </td>
                                    <td> {{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)
											->format('d.M H:i'):'' }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if($posts->total() > $posts->count())
            <br>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            {{$posts->links()  }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>



@endsection
