<div align="center">
  <p>
    <a href="README.md">English</a> | <a href="README.tr.md">Türkçe</a>
  </p>
  <h1>Next-Gen Laravel CMS & Blog Application</h1>
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

## Proje Hakkında

Bu proje, modern web geliştirme standartlarına (MVC mimarisi, RESTful yapı, ORM optimizasyonları) uygun olarak geliştirilmiş tam kapsamlı bir **İçerik Yönetim Sistemi (CMS)** ve Blog platformudur. 

Bir stajyer/Junior geliştiricinin temel CRUD işlemlerinin çok ötesine geçerek; performans optimizasyonları (N+1 sorgu sorunlarının çözümü), güvenli yetkilendirme (Role-Based Access Control) ve asenkron veri yönetimi (AJAX) gibi kurumsal düzeyde aranan yetkinlikleri pratiğe dökme amacıyla inşa edilmiştir. Back-end konusunda pratik kazanmak için oluşturduğum bir projedir.

## Temel Özellikler

### Güvenlik ve Yetkilendirme
- **Role-Based Access Control (RBAC):** Spatie Permissions kullanılarak `Admin` ve `Yazar` olmak üzere ayrılmış katı yetki hiyerarşisi.
- **Veri İzolasyonu:** Yazarlar yalnızca kendi blog yazılarını düzenleyip silebilirken, yöneticiler sistemdeki tüm içeriğe ve kullanıcı yönetimine tam erişim sağlar.

### Performans ve Veritabanı Optimizasyonu
- **Sorgu Optimizasyonu:** Eloquent ORM üzerinde `with()` eager loading yapıları kullanılarak veritabanına binen yük minimize edilmiş ve N+1 sorgu sorunları giderilmiştir.
- **İndeksleme (Indexing):** Blog tablolarında sık aranan sütunlar (`status`, `category_id`) indekslenerek sorgu yanıt süreleri optimize edilmiştir.
- **Önbellekleme (Caching):** Laravel Cache mekanizmaları kullanılarak anasayfa ve menü yüklemeleri hızlandırılmıştır.

### Çoklu Dil Altyapısı
- İçeriklerin (Bloglar ve Kategoriler) hem Türkçe hem de İngilizce yönetilebilmesini sağlayan dinamik çeviri (Translation) tabloları kurgulanmıştır.
- Kullanıcı arayüzünde anlık dil değiştirme yeteneği bulunmaktadır.

### Medya ve Profil Yönetimi
- Kullanıcı avatarları için güvenli dosya yükleme (File Upload) modülü.
- Sunucu tarafında dosya boyutu, MIME type ve uzantı doğrulamaları ile güvenlik önlemleri alınmıştır.

### Modern Frontend ve AJAX Mimarisi
- **DataTables & AJAX:** Sayfa yenilenmeden asenkron olarak büyük veri setlerinin filtrelenip listelenmesi.
- **Vite Entegrasyonu:** CSS ve JS dosyalarının production ortamı için optimize edilip derlenmesi.

---

## Kullanılan Teknolojiler

| Katman | Teknolojiler |
| :--- | :--- |
| **Backend** | PHP 8.4, Laravel 13 |
| **Veritabanı** | MySQL, Eloquent ORM |
| **Frontend** | Blade Template Engine, Bootstrap 5 / Tailwind CSS, JavaScript (AJAX) |
| **Paketler** | Spatie Permission, Yajra DataTables, Vite |

---

## Yerel Kurulum

Projeyi kendi geliştirme ortamınızda çalıştırmak için aşağıdaki adımları izleyebilirsiniz:

1. **Projeyi Klonlayın:**
   ```bash
   git clone https://github.com/AyberkCerit/cms-app.git
   cd cms-app
   ```

2. **Bağımlılıkları Yükleyin:**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Çevre Değişkenlerini Yapılandırın:**
   Örnek yapılandırma dosyasını kopyalayın ve veritabanı bilgilerinizi girin.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Veritabanını Hazırlayın:**
   Migration işlemlerini çalıştırarak veritabanı şemasını oluşturun:
   ```bash
   php artisan migrate
   ```

5. **Uygulamayı Başlatın:**
   ```bash
   php artisan serve
   ```
   *Uygulama `http://localhost:8000` adresinde çalışmaya başlayacaktır.*

---

<div align="center">
  <i>Bu proje, Temiz Kod (Clean Code) prensipleri ve kurumsal yazılım mimarisi standartları gözetilerek geliştirilmiştir. Kod incelemesi için kaynak dosyalarına göz atabilirsiniz.</i>
</div>
