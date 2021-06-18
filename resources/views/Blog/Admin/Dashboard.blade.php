@extends('layouts.admin_layout')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Адмін панель</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"></li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Категорії</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('blog.admin.categories.index')}}">Деталі</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Статті</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{route('blog.admin.posts.index')}}">Деталі</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Відвідувачі</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">Деталі</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Сьогодні</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">Деталі</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
   </div>

    <div class="row">

        <div class="col-sm-6">
            <h3 class="list-group-item"> Останні додані категорії</h3>
            @foreach($categories as $category)
                <a class="list-group-item" href="{{route('blog.admin.categories.edit', $category->id)}}">
                    <h4 class="list-group-item-heading"> {{$category->title}}</h4>
                    <p class="list-group-item-text">
                        Кількість матеріалів - {{$category->post()->count()}}
                    </p>
                </a>

            @endforeach

        </div>

         <div class="col-sm-6">
             <h3 class="list-group-item"> Останні додані статті</h3>
             @foreach($posts as $post)
            <a class="list-group-item" href="{{route('blog.admin.posts.edit', $post->id)}}">
                <h4 class="list-group-item-heading"> {{$post->title}}</h4>
                <p class="list-group-item-text">
                    Категорія - {{$post->category->title}}
                </p>
            </a>

             @endforeach
        </div>

    </div>
</div>
@endsection
