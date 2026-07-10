@extends('layouts.app.app')

@section('content')
<h1 class="h3 mb-3">Sayfa <strong>Yönetimi</strong></h1>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Tüm Sayfalar</h5>
        <a href="{{ route('pages.form') }}" class="btn btn-primary"><i class="align-middle" data-feather="plus"></i> Yeni Sayfa</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlık</th>
                        <th>URL Slug</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                    <tr>
                        <td>{{ $page->id }}</td>
                        <td>{{ $page->title_translated }}</td>
                        <td><a href="{{ route('page.show', $page->slug) }}" target="_blank">/page/{{ $page->slug }}</a></td>
                        <td>
                            @if($page->status == 1)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Pasif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pages.form', $page->id) }}" class="btn btn-sm btn-info">Düzenle</a>
                            <a href="{{ route('pages.delete', $page->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Emin misiniz?')">Sil</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Henüz sayfa oluşturulmamış.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
