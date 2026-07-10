@extends('layouts.blog.app')
@section('title', 'Blog Yazıları')

@section('content')
<h1 class="h3 mb-3">Blog</h1>

<div class="row">
    @forelse($posts as $post)
    <div class="col-12 col-md-6 col-lg-4 d-flex">
        <div class="card flex-fill">
            <img class="card-img-top blog-card-img" src="{{ $post->image ? $post->image : 'https://via.placeholder.com/600x400?text=Blog+Resmi' }}" alt="{{ $post->title_translated }}">
            <div class="card-header">
                <span class="badge bg-primary mb-2">{{ $post->category->name_translated }}</span>
                <h5 class="card-title mb-0">{{ $post->title_translated }}</h5>
            </div>
            <div class="card-body mt-0 pt-0">
                <p class="card-text text-muted" style="min-height: 50px;">
                    {{ \Illuminate\Support\Str::limit($post->summary_translated, 100) }}
                </p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted"><i class="align-middle" data-feather="calendar"></i> {{ $post->created_at->format('d M Y') }}</small>
                    <a href="{{ route('blog.detail', $post->slug) }}" class="btn btn-sm btn-outline-primary">Devamını Oku</a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-secondary text-center" role="alert">
            <h4 class="alert-heading">Henüz İçerik Yok!</h4>
            <p>Bu kategoride veya genel olarak henüz bir blog yazısı bulunmuyor.</p>
        </div>
    </div>
    @endforelse
</div>

<div class="row">
    <div class="col-12 d-flex justify-content-center">
        {{ $posts->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
