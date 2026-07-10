@extends('layouts.app.app')
@section('content')
<h4>Diller</h4>
<hr>
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{ $language == null ? 'Yeni Dil Ekle' : 'Dili Düzenle' }}</h5>
        <div>
            <a href="{{route('languages')}}"><button class="btn btn-secondary min-btn me-2" type="button">Geri</button></a>
            <button class="btn btn-success min-btn saveLanguageBtn" type="button">
                <span class="spinner-border spinner-border-sm d-none me-1" id="saveSpinner" role="status" aria-hidden="true"></span>
                Kaydet
            </button>
        </div>
    </div>
    <div class="card-body">
        <form id="languagesForm">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <div class="form-floating">
                        <input type="text" name="name" id="name" class="form-control name" placeholder="Dil Adı"  value="{{($language==null ? null : $language->name)}}">
                        <label for="name">Dil Adı (Örn: English)*</label>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 mb-3">
                    <div class="form-floating">
                        <input type="text" name="code" id="code" class="form-control code" placeholder="Kodu"  value="{{($language==null ? null : $language->code)}}">
                        <label for="code">Kodu (Örn: en)*</label>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 mb-3">
                    <div class="form-floating">
                        <select name="status" id="status" class="form-control status" required>
                            <option value="">Durum Seçiniz</option>
                            <option value="active" {{($language==null ? 'selected':($language->status==1 ?'selected':''))}}>Aktif</option>
                            <option value="inactive" {{($language==null ? '':($language->status==0 ?'selected':''))}}>Pasif</option>
                        </select>
                        <label for="status">Durum</label>
                    </div>
                </div>
            </div>

            <input type="hidden" value="{{($language==null ? null: $language->id)}}" class="language_id"/>
        </form>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    var checkInterval=setInterval(() => {
        if (app.loader!==undefined&&app.loader!==null){
            app.loader.setModule('Languages');
            clearInterval(checkInterval);
        }
    }, 500);
</script>
@endsection
