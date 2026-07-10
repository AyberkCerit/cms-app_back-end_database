@extends('layouts.app.app')
@section('content')
<h4>Blog Yazıları</h4>
<hr>
<div class="card">
    <div class="card-header">
<a href="{{route('blog-posts.new')}}"><button type="button" class="btn btn-success min-btn">Yeni Ekle</button></a>
<button type="button" class="btn btn-primary min-btn editPostBtn">Düzenle</button>
<button type="button" class="btn btn-danger min-btn deletePostBtn">Sil</button>

    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered" id="postsTable">
        <thead>
            <tr>
                <th>Başlık</th>
                <th>Kategori</th>
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
            app.loader.setModule('BlogPosts');
            clearInterval(checkInterval);
        }
    }, 500);
</script>
@endsection
