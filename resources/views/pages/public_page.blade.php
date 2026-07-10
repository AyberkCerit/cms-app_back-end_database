<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title_translated }} | {{ setting('site_title', 'Benim Sitem') }}</title>
    <!-- Bootstrap CSS for simple UI -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fa; color: #333; }
        .hero { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 4rem 0; text-align: center; }
        .content-card { background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 3rem; margin-top: -3rem; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">{{ setting('site_title', 'My CMS') }}</a>
        </div>
    </nav>

    <div class="hero">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">{{ $page->title_translated }}</h1>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="content-card">
                    {!! $page->content_translated !!}
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} {{ setting('site_title', 'My CMS') }}. Tüm hakları saklıdır.</p>
        </div>
    </footer>
</body>
</html>
