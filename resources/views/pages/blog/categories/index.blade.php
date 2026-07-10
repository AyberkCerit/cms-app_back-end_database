@extends('layouts.app.app')
@section('content')
<h4>Blog Kategorileri</h4>
<hr>
<div class="card">
    <div class="card-header">
<a href="{{route('blog-categories.new')}}"><button type="button" class="btn btn-success min-btn">Yeni Ekle</button></a>
<button type="button" class="btn btn-primary min-btn editCategoryBtn">Düzenle</button>
<button type="button" class="btn btn-danger min-btn deleteCategoryBtn">Sil</button>

    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered" id="categoriesTable">
        <thead>
            <tr>
                <th>Adı</th>
                <th>Slug</th>
                <th>Durum</th>
                <th width="135">İşlemler</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        </table>
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
