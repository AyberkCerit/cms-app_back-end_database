@extends('layouts.app.app')

@section('content')
<h1 class="h3 mb-3"><strong>Dashboard</strong></h1>

<div class="row">
    <!-- Hızlı İşlemler -->
    <div class="col-12 col-lg-6 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Hızlı İşlemler</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('blog-posts.new') }}" class="btn btn-outline-primary">Yeni Yazı Ekle</a>
                    <a href="{{ route('blog-categories.new') }}" class="btn btn-outline-success">Yeni Kategori Ekle</a>
                    <a href="{{ route('languages') }}" class="btn btn-outline-info text-dark">Dil Ayarları</a>
                </div>
            </div>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="col-12 col-lg-6 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Güncel Özetiniz</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush mt-2">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Toplam Yazı Sayısı
                        <span class="badge bg-primary rounded-pill" style="font-size: 14px;">{{ $postCount }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Toplam Kategori Sayısı
                        <span class="badge bg-success rounded-pill" style="font-size: 14px;">{{ $categoryCount }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Toplam Kullanıcı
                        <span class="badge bg-warning rounded-pill text-dark" style="font-size: 14px;">{{ $userCount }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<h1 class="h4 mb-3 mt-4"><strong>Son Eklenen Bloglar</strong></h1>
<div class="row">
    @forelse($recentPosts->take(3) as $post)
    <div class="col-12 col-md-4 d-flex">
        <div class="card flex-fill">
            <!-- Görselleri senin ekleyeceğin alan -->
            <img src="{{ $loop->index % 2 == 0 ? asset('template/src/img/photos/Ai.webp') : asset('template/src/img/photos/ML.webp') }}" class="card-img-top" alt="Blog Görseli" style="height: 200px; object-fit: cover;">
            
            <div class="card-body">
                <h5 class="card-title">{{ $post->title_translated }}</h5>
                <p class="card-text text-muted">{{ $post->summary_translated ?: 'Açıklama bulunmuyor...' }}</p>
            </div>
            
            <div class="card-footer d-flex justify-content-between align-items-center">
                <small class="text-muted">{{ $post->created_at->format('d.m.Y') }}</small>
                <div>
                    <a href="{{ route('blog-posts.preview', $post->id) }}" class="btn btn-outline-secondary btn-sm px-2 me-1" title="İçeriği Gör">Gözat</a>
                    <a href="{{ route('blog-posts.edit', $post->id) }}" class="btn btn-primary btn-sm">Düzenle</a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-secondary" role="alert">
            Henüz blog yazısı bulunmamaktadır.
        </div>
    </div>
    @endforelse
</div>
@endsection