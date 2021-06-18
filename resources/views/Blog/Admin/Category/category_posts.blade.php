@extends('layouts.admin_layout')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Пости категорії:  </h1>
        <ol class="breadcrumb mb-4">
            <div class="col-sm-6">

                @foreach($posts as $post)
                    <a class="list-group-item" href="{{route('blog.admin.posts.edit', $post->id)}}">
                        <h4 class="list-group-item-heading"> {{$post->id}}. {{$post->title}}</h4>

                    </a>

                @endforeach

            </div>
        </ol>

        <div style="height: 100vh"></div>
        <div class="card mb-4"><div class="card-body">When scrolling, the navigation stays at the top of the page. This is the end of the static navigation demo.</div></div>
    </div>


@endsection
