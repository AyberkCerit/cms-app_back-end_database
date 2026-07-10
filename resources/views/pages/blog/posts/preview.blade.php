@extends('layouts.app.app')

@section('content')
<div class="mb-3">
    <a href="{{ url()->previous() }}" class="btn btn-secondary">
        <i class="align-middle" data-feather="arrow-left"></i> Geri Dön
    </a>
</div>

<div class="card shadow-sm border-0">
    @if($post->image)
        <img src="{{ $post->image }}" class="card-img-top" alt="{{ $post->title_translated }}" style="max-height: 400px; object-fit: cover;">
    @endif
    <div class="card-body p-4">
        <h1 class="card-title h2 mb-3">{{ $post->title_translated }}</h1>
        <div class="text-muted mb-4 border-bottom pb-3">
            <span class="me-3"><i class="align-middle" data-feather="folder"></i> {{ $post->category ? $post->category->name_translated : 'Kategori Yok' }}</span>
            <span class="me-3"><i class="align-middle" data-feather="calendar"></i> {{ $post->created_at->format('d.m.Y H:i') }}</span>
        </div>
        
        <div class="blog-content" style="font-size: 1.1rem; line-height: 1.8;">
            {!! $post->content_translated !!}
        </div>
    </div>
</div>
@endsection
