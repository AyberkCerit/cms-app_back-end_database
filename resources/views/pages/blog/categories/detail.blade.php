@extends('layouts.app.app')
@section('content')
<h4>Blog Kategorileri</h4>
<hr>
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{ $category == null ? 'Yeni Kategori Ekle' : 'Kategoriyi Düzenle' }}</h5>
        <div>
            <a href="{{route('blog-categories')}}"><button class="btn btn-secondary min-btn me-2" type="button">Geri</button></a>
            <button class="btn btn-success min-btn saveCategoryBtn" type="button">
                <span class="spinner-border spinner-border-sm d-none me-1" id="saveSpinner" role="status" aria-hidden="true"></span>
                Kaydet
            </button>
        </div>
    </div>
    <div class="card-body">
        <form id="categoriesForm">

            <div class="row mb-3">
                <div class="col-12">
                    <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                        @foreach($languages as $index => $lang)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $index == 0 ? 'active' : '' }}" id="{{ $lang->code }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $lang->code }}" type="button" role="tab" aria-controls="{{ $lang->code }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                {{ $lang->name }} ({{ strtoupper($lang->code) }})
                            </button>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content pt-3" id="languageTabsContent">
                        @foreach($languages as $index => $lang)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="{{ $lang->code }}" role="tabpanel" aria-labelledby="{{ $lang->code }}-tab">
                            <div class="form-floating mb-3">
                                <input type="text" name="name[{{ $lang->code }}]" id="name_{{ $lang->code }}" class="form-control name-input" placeholder="Kategori Adı" value="{{ $category != null ? ($category->translations->where('locale', $lang->code)->first()?->name ?? '') : '' }}" data-lang="{{ $lang->code }}">
                                <label for="name_{{ $lang->code }}">Kategori Adı ({{ strtoupper($lang->code) }})*</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                    <div class="form-floating">
                        <select name="status" id="status" class="form-control status" required>
                            <option value="">Durum Seçiniz</option>
                            <option value="active" {{($category==null ? 'selected':($category->status==1 ?'selected':''))}}>Aktif</option>
                            <option value="inactive" {{($category==null ? '':($category->status==0 ?'selected':''))}}>Pasif</option>
                        </select>
                        <label for="status">Durum</label>
                    </div>
                </div>
            </div>

            <input type="hidden" value="{{($category==null ? null: $category->id)}}" class="category_id"/>
        </form>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    var checkInterval=setInterval(() => {
        if (app.loader!==undefined&&app.loader!==null){
            app.loader.setModule('BlogCategories');
            clearInterval(checkInterval);
        }
    }, 500);
</script>
@endsection
