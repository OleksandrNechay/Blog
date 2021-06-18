@extends('layouts.blog_layout')

@section('content')
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">
            <!-- Post preview-->
            @foreach($posts as $post)
            <div class="post-preview">
                <a href="{{route('show', $post->id)}}">
                    <h2 class="post-title">{{$post->title}}</h2>
                    <h3 class="post-subtitle">{{$post->exerpt}}</h3>
                </a>
                <p class="post-meta">
                    Posted by
                    <a href="#!">{{$post->user->name}}</a>
                    on {{$post->published_at}}
                </p>
            </div>
            @endforeach

            <!-- Divider-->
            <hr class="my-4" />
            <!-- Pager-->
            <div class="d-flex justify-content-end mb-4">
                @if($posts->total() > $posts->count())

                     {{$posts->links()  }}
                @endif
            </div>
        </div>
    </div>


@endsection
