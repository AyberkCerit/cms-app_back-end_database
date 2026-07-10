<div align="center">
  <h1>🚀 Next-Gen Laravel CMS & Blog Application</h1>
  <p>
    <b>Gelişmiş Veritabanı Mimarisi, Rol Yönetimi ve Çoklu Dil Desteği Barındıran Modern İçerik Yönetim Sistemi</b>
  </p>
  <p>
    <img src="https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.4" />
    <img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
    <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
    <img src="https://img.shields.io/badge/Vite-Bundler-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite" />
  </p>
</div>

---

## 🎯 Proje Hakkında
Bu proje, modern web geliştirme standartlarına (MVC mimarisi, RESTful yapı, ORM optimizasyonları) uygun olarak geliştirilmiş tam kapsamlı bir **İçerik Yönetim Sistemi (CMS)** ve Blog platformudur. 

Bir stajyer/Junior geliştiricinin temel CRUD işlemlerinin çok ötesine geçerek; performans optimizasyonları (N+1 sorgu sorunlarının çözümü), güvenli yetkilendirme (Role-Based Access Control) ve asenkron veri yönetimi (AJAX) gibi kurumsal düzeyde aranan yetkinlikleri pratiğe dökme amacıyla inşa edilmiştir.Back-end konusunda pratik kazanmak için oluşturduğum bir projedir.

## ✨ Öne Çıkan Özellikler (Neler Başardım?)

### 🔐 Gelişmiş Güvenlik ve Yetkilendirme (Spatie Permissions)
- **Role-Based Access Control (RBAC):** `Admin` ve `Yazar` olmak üzere ayrılmış katı yetki hiyerarşisi.
- **Veri İzolasyonu:** Yazarlar yalnızca kendi blog yazılarını düzenleyip silebilirken, yöneticiler sistemdeki tüm içeriğe ve kullanıcı yönetimine (ekleme/silme/düzenleme) tam erişim sağlar.

### ⚡ Performans ve Veritabanı Optimizasyonları
- **N+1 Sorgu Optimizasyonu:** Eloquent ORM üzerinde `with()` eager loading yapıları kullanılarak veritabanına binen yük minimize edildi.
- **İndeksleme (Indexing):** Blog tablolarında sık aranan sütunlar (status, category_id) indekslenerek sorgu hızları artırıldı.
- **Önbellekleme (Caching):** Laravel Cache mekanizmaları ile anasayfa ve menü yüklemeleri optimize edildi.

### 🌍 Çoklu Dil (Multi-language) Altyapısı
- İçeriklerin (Bloglar, Kategoriler) hem Türkçe hem de İngilizce girilebilmesini sağlayan dinamik çeviri tabloları (Translation Tables) kurgulandı.
- Kullanıcı arayüzü anlık dil değiştirme yeteneğine sahiptir.

### 🖼️ Medya ve Profil Yönetimi
- Kullanıcıların kendi avatarlarını güvenle yükleyebileceği (File Upload) dosya yönetim modülü.
- Sunucu tarafı dosya boyutu, MIME type ve uzantı doğrulamaları.

### 💻 Modern Frontend ve AJAX Mimarisi
- **DataTables & AJAX:** Sayfa yenilenmeden asenkron olarak binlerce verinin filtrelenip listelenmesi.
- **Vite Entegrasyonu:** CSS ve JS dosyalarının production ortamı için optimize edilip derlenmesi.

---

## 🛠️ Kullanılan Teknolojiler

| Kategori | Teknolojiler |
| :--- | :--- |
| **Backend** | PHP 8.4, Laravel 13 |
| **Veritabanı** | MySQL, Eloquent ORM |
| **Frontend** | Blade Template Engine, Bootstrap 5 / Tailwind CSS, JavaScript (AJAX) |
| **Araçlar & Paketler** | Spatie Permission, Yajra DataTables, Vite |

---

## 🚀 Yerel Ortamda Kurulum (Local Setup)

Projeyi kendi bilgisayarınızda test etmek için aşağıdaki adımları izleyebilirsiniz:

1. **Projeyi Klonlayın:**
   ```bash
   git clone https://github.com/AyberkCerit/cms-app.git
   cd cms-app
   ```

2. **Gerekli Paketleri Yükleyin:**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Çevre Değişkenlerini Ayarlayın:**
   `.env.example` dosyasını `.env` olarak kopyalayın ve veritabanı bilgilerinizi girin.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Veritabanını Hazırlayın:**
   Migration'ları çalıştırarak tabloları oluşturun:
   ```bash
   php artisan migrate
   ```

5. **Uygulamayı Başlatın:**
   ```bash
   php artisan serve
   ```
   *Proje artık `http://localhost:8000` adresinde yayında!*

---

<div align="center">
  <i>Bu proje, temiz kod yazma prensipleri (Clean Code) ve kurumsal yazılım mimarisi standartları gözetilerek geliştirilmiştir. Kod incelemesi için kaynak dosyalarıma göz atabilirsiniz.</i>
</div>
