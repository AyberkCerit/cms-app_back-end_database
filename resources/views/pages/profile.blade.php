@extends('layouts.app.app')

@section('content')
<h1 class="h3 mb-3"><strong>Profil</strong> Ayarları</h1>

<div class="row">
    <!-- Profil Kartı -->
    <div class="col-md-4 col-xl-3">
        <div class="card mb-3 shadow-sm border-0">
            <div class="card-header">
                <h5 class="card-title mb-0">Kullanıcı Bilgileri</h5>
            </div>
            <div class="card-body text-center">
                <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="img-fluid rounded-circle mb-2" style="width: 128px; height: 128px; object-fit: cover;" />
                <h5 class="card-title mb-0">{{ Auth::user()->name }}</h5>
                <div class="text-muted mb-2">Yönetici</div>
            </div>
            <hr class="my-0" />
            <div class="card-body">
                <h5 class="h6 card-title">İletişim & Tarih</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><i class="align-middle text-muted me-2" data-feather="mail"></i> {{ Auth::user()->email }}</li>
                    <li class="mb-2"><i class="align-middle text-muted me-2" data-feather="calendar"></i> Katılım: {{ Auth::user()->created_at ? Auth::user()->created_at->format('d.m.Y') : 'Bilinmiyor' }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Güncelleme Formu -->
    <div class="col-md-8 col-xl-9">
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <h5 class="card-title mb-0">Bilgileri Güncelle</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ad Soyad</label>
                        <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" placeholder="Ad Soyad" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">E-posta Adresi</label>
                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" placeholder="E-posta Adresi" required>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-danger">Yeni Şifre</label>
                        <input type="password" class="form-control" name="password" placeholder="Şifreyi değiştirmek istemiyorsanız boş bırakın">
                    </div>
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Değişiklikleri Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
