@extends('layouts.app.app')

@section('content')
<h1 class="h3 mb-3"><strong>Genel</strong> Ayarlar</h1>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<form action="{{ route('settings.save') }}" method="POST">
    @csrf
    <div class="row">
        <!-- Genel Bilgiler -->
        <div class="col-12 col-xl-8">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="card-title">Site Bilgileri</h5>
                    <h6 class="card-subtitle text-muted">Web sitenizin global verileri.</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Site Başlığı</label>
                        <input type="text" class="form-control" name="site_title" value="{{ setting('site_title') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Site Açıklaması (Description)</label>
                        <textarea class="form-control" rows="3" name="site_description">{{ setting('site_description') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Anahtar Kelimeler (Keywords)</label>
                        <input type="text" class="form-control" name="site_keywords" value="{{ setting('site_keywords') }}">
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label fw-bold">İletişim E-posta</label>
                        <input type="email" class="form-control" name="contact_email" value="{{ setting('contact_email') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Telefon</label>
                        <input type="text" class="form-control" name="contact_phone" value="{{ setting('contact_phone') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Görsel ve Sosyal Medya -->
        <div class="col-12 col-xl-4">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="card-title">Görsel ve Sosyal</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Logo URL</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="site_logo" id="site_logo" value="{{ setting('site_logo') }}">
                            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#mediaSelectModal">Seç</button>
                        </div>
                        @if(setting('site_logo'))
                        <div class="mt-2 text-center">
                            <img src="{{ setting('site_logo') }}" alt="Logo" style="max-height:80px; object-fit:contain;">
                        </div>
                        @endif
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Facebook URL</label>
                        <input type="text" class="form-control" name="social_facebook" value="{{ setting('social_facebook') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Twitter/X URL</label>
                        <input type="text" class="form-control" name="social_twitter" value="{{ setting('social_twitter') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Instagram URL</label>
                        <input type="text" class="form-control" name="social_instagram" value="{{ setting('social_instagram') }}">
                    </div>
                    
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Ayarları Kaydet</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Media Select Modal -->
<div class="modal fade" id="mediaSelectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Görsel Seç</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row" id="media-modal-gallery">
            <div class="col-12 text-center py-5">Yükleniyor...</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
    $('#mediaSelectModal').on('show.bs.modal', function () {
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
                    html = '<div class="col-12 text-center py-5">Medya bulunamadı.</div>';
                }
                $('#media-modal-gallery').html(html);
            }
        });
    });

    $(document).on('click', '.media-selectable', function() {
        $('#site_logo').val($(this).data('url'));
        $('#mediaSelectModal').modal('hide');
    });
</script>
@endsection
