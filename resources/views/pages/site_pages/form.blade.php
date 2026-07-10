@extends('layouts.app.app')

@section('content')
<h1 class="h3 mb-3">{{ $page ? 'Sayfayı Düzenle' : 'Yeni Sayfa Ekle' }}</h1>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Sayfa Bilgileri</h5>
        <a href="{{ route('pages.index') }}" class="btn btn-secondary">Geri</a>
    </div>
    <div class="card-body">
        <form action="{{ route('pages.save') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $page ? $page->id : '' }}">
            
            <ul class="nav nav-tabs mb-3" id="pageTabs" role="tablist">
                @foreach($languages as $index => $lang)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $index == 0 ? 'active' : '' }}" id="tab-{{ $lang->code }}" data-bs-toggle="tab" data-bs-target="#content-{{ $lang->code }}" type="button" role="tab">
                        {{ $lang->name }} ({{ strtoupper($lang->code) }})
                    </button>
                </li>
                @endforeach
            </ul>

            <div class="tab-content mb-4" id="pageTabsContent">
                @foreach($languages as $index => $lang)
                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="content-{{ $lang->code }}" role="tabpanel">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sayfa Başlığı ({{ strtoupper($lang->code) }})</label>
                        <input type="text" name="title[{{ $lang->code }}]" class="form-control" value="{{ $page ? ($page->translations->where('locale', $lang->code)->first()?->title ?? '') : '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">İçerik ({{ strtoupper($lang->code) }})</label>
                        <textarea name="content[{{ $lang->code }}]" class="form-control" rows="10">{{ $page ? ($page->translations->where('locale', $lang->code)->first()?->content ?? '') : '' }}</textarea>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Durum</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $page && $page->status == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ $page && $page->status == 0 ? 'selected' : '' }}>Pasif</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg mt-3">Kaydet</button>
        </form>
    </div>
</div>
@endsection
