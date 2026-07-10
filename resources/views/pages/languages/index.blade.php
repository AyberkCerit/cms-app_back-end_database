@extends('layouts.app.app')
@section('content')
<h4>Diller (Languages)</h4>
<hr>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Aktif Diller</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered" id="languagesTable">
                    <thead>
                        <tr>
                            <th>Dil Adı</th>
                            <th>Kodu</th>
                            <th>Durum</th>
                            <th width="100">İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($languages as $lang)
                        <tr>
                            <td>{{ $lang->name }}</td>
                            <td>{{ $lang->code }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input toggle-status" type="checkbox" data-id="{{ $lang->id }}" {{ $lang->status == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $lang->status == 1 ? 'Aktif' : 'Pasif' }}</label>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm deleteLanguageBtn" data-id="{{ $lang->id }}">Sil</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Yeni Dil Ekle</h5>
            </div>
            <div class="card-body">
                <form id="addLanguageForm">
                    <div class="mb-3">
                        <label class="form-label">Dil Adı (Örn: Türkçe)</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dil Kodu (Örn: tr)</label>
                        <input type="text" name="code" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Ekle</button>
                </form>
            </div>
        </div>
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
