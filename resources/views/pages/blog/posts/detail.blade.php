@extends('layouts.app.app')
@section('content')
<h4>Blog Yazıları</h4>
<hr>
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{ $post == null ? 'Yeni Yazı Ekle' : 'Yazıyı Düzenle' }}</h5>
        <div>
            <a href="{{route('blog-posts')}}"><button class="btn btn-secondary min-btn me-2" type="button">Geri</button></a>
            <button class="btn btn-success min-btn savePostBtn" type="button">
                <span class="spinner-border spinner-border-sm d-none me-1" id="saveSpinner" role="status" aria-hidden="true"></span>
                Kaydet
            </button>
        </div>
    </div>
    <div class="card-body">
        <form id="postsForm">

            <div class="row mb-3">
                <div class="col-12">
                    <ul class="nav nav-tabs" id="postLanguageTabs" role="tablist">
                        @foreach($languages as $index => $lang)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $index == 0 ? 'active' : '' }}" id="{{ $lang->code }}-post-tab" data-bs-toggle="tab" data-bs-target="#post-{{ $lang->code }}" type="button" role="tab" aria-controls="post-{{ $lang->code }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                {{ $lang->name }} ({{ strtoupper($lang->code) }})
                            </button>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content pt-3" id="postLanguageTabsContent">
                        @foreach($languages as $index => $lang)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="post-{{ $lang->code }}" role="tabpanel" aria-labelledby="{{ $lang->code }}-post-tab">
                            
                            <div class="form-floating mb-3">
                                <input type="text" name="title[{{ $lang->code }}]" id="title_{{ $lang->code }}" class="form-control title-input" placeholder="Yazı Başlığı" value="{{ $post != null ? ($post->translations->where('locale', $lang->code)->first()?->title ?? '') : '' }}" data-lang="{{ $lang->code }}">
                                <label for="title_{{ $lang->code }}">Yazı Başlığı ({{ strtoupper($lang->code) }})*</label>
                            </div>

                            <div class="form-floating mb-3">
                                <textarea name="summary[{{ $lang->code }}]" id="summary_{{ $lang->code }}" class="form-control summary-input" placeholder="Özet" style="height: 100px" data-lang="{{ $lang->code }}">{{ $post != null ? ($post->translations->where('locale', $lang->code)->first()?->summary ?? '') : '' }}</textarea>
                                <label for="summary_{{ $lang->code }}">Kısa Özet ({{ strtoupper($lang->code) }})</label>
                            </div>

                            <div class="mb-3">
                                <label for="content_{{ $lang->code }}" class="form-label">İçerik ({{ strtoupper($lang->code) }})*</label>
                                <textarea name="content[{{ $lang->code }}]" id="content_{{ $lang->code }}" class="form-control content-input" rows="10" data-lang="{{ $lang->code }}">{{ $post != null ? ($post->translations->where('locale', $lang->code)->first()?->content ?? '') : '' }}</textarea>
                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <div class="form-floating">
                        <select name="category_id" id="category_id" class="form-control category_id" required>
                            <option value="">Kategori Seçiniz*</option>
                            @foreach($categories as $cat)
                                <option value="{{$cat->id}}" {{($post!=null && $post->category_id==$cat->id) ? 'selected':''}}>{{$cat->name_translated}}</option>
                            @endforeach
                        </select>
                        <label for="category_id">Kategori*</label>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <label class="form-label" for="image">Kapak Görseli</label>
                    <div class="input-group">
                        <input type="text" name="image" id="image" class="form-control image" placeholder="Görsel Yolu Veya URL" value="{{($post==null ? null : $post->image)}}">
                        <button class="btn btn-outline-secondary" type="button" id="openMediaModalBtn" data-bs-toggle="modal" data-bs-target="#mediaSelectModal">Medya Seç</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="form-floating">
                        <select name="status" id="status" class="form-control status" required>
                            <option value="">Durum Seçiniz</option>
                            <option value="active" {{($post==null ? 'selected':($post->status==1 ?'selected':''))}}>Aktif</option>
                            <option value="inactive" {{($post==null ? '':($post->status==0 ?'selected':''))}}>Pasif</option>
                        </select>
                        <label for="status">Durum</label>
                    </div>
                </div>
            </div>

            <input type="hidden" value="{{($post==null ? null: $post->id)}}" class="post_id"/>
        </form>
    </div>
        </form>
    </div>
</div>

<!-- Media Select Modal -->
<div class="modal fade" id="mediaSelectModal" tabindex="-1" aria-labelledby="mediaSelectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mediaSelectModalLabel">Görsel Seç</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row" id="media-modal-gallery">
            <div class="col-12 text-center py-5">Yükleniyor...</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
      </div>
    </div>
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

    // Medya Modalı açıldığında resimleri yükle
    $('#mediaSelectModal').on('show.bs.modal', function (e) {
        $.ajax({
            url: "{{ route('media.list') }}",
            type: 'GET',
            success: function(res) {
                var html = '';
                if(res.media && res.media.length > 0) {
                    res.media.forEach(function(item) {
                        html += `
                        <div class="col-4 col-md-3 col-lg-2 mb-3">
                            <div class="card h-100 border media-selectable" data-url="${item.file_path}" style="cursor: pointer;">
                                <img src="${item.file_path}" class="card-img-top p-1" style="height: 100px; object-fit: contain;">
                            </div>
                        </div>`;
                    });
                } else {
                    html = '<div class="col-12 text-center py-5">Medya bulunamadı. Lütfen Medya Kütüphanesinden yükleme yapın.</div>';
                }
                $('#media-modal-gallery').html(html);
            }
        });
    });

    $(document).on('click', '.media-selectable', function() {
        var url = $(this).data('url');
        $('#image').val(url);
        $('#mediaSelectModal').modal('hide');
    });
</script>
@endsection
