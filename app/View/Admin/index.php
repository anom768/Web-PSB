<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $model["title"] ?? "" ?></title>
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body>

	<!-- bagia header -->
	<header>
		<div class="container">
		<h1>SMKN 7 Yonaprama Banglitafi</h1>
		<ul>
			<li class="active"><a>Home</a></li>
			<li ><a href="/students/data">Data Siswa</a></li>
			<li><a href="/admin/logout">Logout</a></li>
		</ul>
		</div>
	</header>

	<!-- bagian content -->
	<div class="section">
		<div class="container">
		<h4>Home</h4>
		<div class="box">
			<h4>Selamat datang <?= $model["email"] ?? "" ?> ^-^</h4>
		</div>
		</div>
	<!-- banner -->
	<div class="banner">
		<div class="banner-text">
			<div class="container">
				<h3>Selamat Datang di SMKN 7 Yonaprama Banglitafi</h3>
				<p>Sekolah Menengah Kejuruan dengan berbagai jurusan yang dapat Anda pilih sesuai minat dan bakat Anda.</p>
			</div>
		</div>
	</div> <br> <br> <br> <br> <br> <br> <br> <br> <br>
	<!-- footer -->
	<footer>
		<div class="container">
			<small>Copyright &copy; 2022 - SMKN 7 Yonaprama Banglitafi . All Rigths Reserved</small>
		</div>
	</footer>
</body>
</html>