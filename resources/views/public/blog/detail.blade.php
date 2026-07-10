@extends('layouts.blog.app')
@section('title', $post->title_translated)

@section('content')
<div class="row">
    <div class="col-12 col-lg-10 mx-auto">
        
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Anasayfa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index', ['category' => $post->category->slug]) }}">{{ $post->category->name_translated }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $post->title_translated }}</li>
            </ol>
        </nav>

        <div class="card">
            @if($post->image)
            <img class="card-img-top" src="{{ $post->image }}" alt="{{ $post->title_translated }}" style="max-height: 400px; object-fit: cover;">
            @endif
            <div class="card-body p-5">
                <div class="mb-4 text-center">
                    <span class="badge bg-primary mb-2">{{ $post->category->name_translated }}</span>
                    <h1 class="card-title mb-3" style="font-size: 2.5rem; font-weight: 700;">{{ $post->title_translated }}</h1>
                    <div class="text-muted">
                        <i class="align-middle me-1" data-feather="user"></i> {{ $post->author->name }} &nbsp;|&nbsp;
                        <i class="align-middle me-1" data-feather="calendar"></i> {{ $post->created_at->format('d F Y') }} &nbsp;|&nbsp;
                        <i class="align-middle me-1" data-feather="eye"></i> {{ $post->view_count }} Görüntülenme
                    </div>
                </div>

                @if($post->summary_translated)
                <div class="lead mb-4 text-muted fst-italic text-center">
                    {{ $post->summary_translated }}
                </div>
                <hr class="mb-4">
                @endif

                <div class="post-content mt-4" style="line-height: 1.8; font-size: 1.1rem;">
                    {!! nl2br(e($post->content_translated)) !!}
                </div>
            </div>
            <div class="card-footer bg-light p-4 text-center">
                <h5 class="mb-3">Bu yazıyı beğendiniz mi? Paylaşın!</h5>
                <button class="btn btn-outline-secondary me-2"><i class="align-middle" data-feather="twitter"></i> Twitter</button>
                <button class="btn btn-outline-primary"><i class="align-middle" data-feather="facebook"></i> Facebook</button>
            </div>
        </div>
    </div>
</div>
@endsection
