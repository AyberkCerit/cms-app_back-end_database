@extends('layouts.app.app')

@section('content')
<h1 class="h3 mb-3"><strong>Medya</strong> Kütüphanesi</h1>

<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Tüm Dosyalar</h5>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <i class="align-middle" data-feather="upload"></i> Yeni Dosya Yükle
        </button>
    </div>
    <div class="card-body">
        <div class="row" id="media-gallery">
            @forelse($mediaFiles as $media)
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-4" id="media-card-{{ $media->id }}">
                    <div class="card h-100 border">
                        <img src="{{ $media->file_path }}" class="card-img-top p-2" alt="{{ $media->file_name }}" style="height: 150px; object-fit: contain;">
                        <div class="card-body p-2 text-center">
                            <small class="d-block text-truncate mb-2" title="{{ $media->file_name }}">{{ $media->file_name }}</small>
                            <button class="btn btn-sm btn-outline-danger delete-media-btn" data-id="{{ $media->id }}">
                                <i class="align-middle" data-feather="trash-2"></i> Sil
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5" id="no-media-alert">
                    <i data-feather="image" style="width: 64px; height: 64px; opacity: 0.5"></i>
                    <p class="mt-3">Henüz medya yüklenmemiş.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form id="uploadForm" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Görsel Yükle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="mediaFile" class="form-label">Dosya Seç (JPG, PNG, WEBP - Max 5MB)</label>
                    <input class="form-control" type="file" id="mediaFile" name="file" required accept="image/*">
                </div>
                <div class="progress d-none" id="uploadProgressContainer">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" id="uploadProgressBar" role="progressbar" style="width: 0%;">0%</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <button type="submit" class="btn btn-primary" id="uploadBtn">Yükle</button>
            </div>
        </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('#uploadForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#uploadBtn').prop('disabled', true);
        $('#uploadProgressContainer').removeClass('d-none');
        
        $.ajax({
            url: "{{ route('media.upload') }}",
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                        $('#uploadProgressBar').width(percentComplete + '%').text(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                if(response.success) {
                    Swal.fire('Başarılı', 'Görsel başarıyla yüklendi', 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Hata', response.message, 'error');
                }
            },
            error: function(xhr) {
                Swal.fire('Hata', 'Dosya yüklenirken bir hata oluştu', 'error');
            },
            complete: function() {
                $('#uploadBtn').prop('disabled', false);
                $('#uploadProgressBar').width('0%').text('0%');
                $('#uploadProgressContainer').addClass('d-none');
                $('#uploadModal').modal('hide');
                $('#uploadForm')[0].reset();
            }
        });
    });

    $('.delete-media-btn').on('click', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Bu görseli kalıcı olarak silmek istiyor musunuz?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Evet, Sil!',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('media.delete') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(response) {
                        if(response.success) {
                            $('#media-card-' + id).fadeOut(300, function() { $(this).remove(); });
                            Swal.fire('Silindi!', 'Görsel başarıyla silindi.', 'success');
                        } else {
                            Swal.fire('Hata', 'Silme işlemi başarısız', 'error');
                        }
                    }
                });
            }
        });
    });
});
</script>
@endsection
