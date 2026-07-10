<!DOCTYPE html>
<html lang="tr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

	<title>Ayberk Cerit - CMS | SIGN IN</title>

	<link href="/template/static/css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
	<main class="d-flex w-100">
		@yield('auth_content')
	</main>
@vite(['resources/js/plugins.js'])

@vite(['resources/js/app.js'])
	<script src="/template/static/js/app.js"></script>

</body>

</html>