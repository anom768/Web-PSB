<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $model["title"] ?? "" ?></title>
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body>

	<!-- bagian header -->
	<header>
		<div class="container">
		<h1>SMKN 7 Yonaprama Banglitafi</h1>
		<ul>
			<li class="active"><a>Dashboard</a></li>
			<li ><a href="/students/registration">Pendaftaran</a></li>
			<li><a href="/students/logout">Logout</a></li>
		</ul>
		</div>
	</header>

	<!-- label -->
    <section class="label">
        <div class="container">
            <p>Home / Panduan</p>
        </div>
    </section>

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
	</div>
	
			<div class="section">
			<div class="container">
				<h3>PANDUAN PENDAFTARAN</h3>
			<div class="box">
				<p>Pendaftaran akan dibuka untuk tahun ajaran 2022-2023.</p> <br>
				<p>Jurusan : </p> 
				<p>	-	Multimedia</p> 
				<p>	- 	Teknik Komputer Jaringan</p>
				<p>	- 	Teknik Kendaraan Ringan</p>
				<p>	- 	Teknik Permesinan.</p> <br>

				<p>Berkas yang harus disiapkan adalah : </p>
				<p>	-	Data Pribadi</p>
				<p>	-	Data Orangtua</p>
				<p>	-	Nilai Rapor</p> <br>

				<p>	->	Langkah pertama mendaftar adalah klik tombol Daftar, jika belum memiliki akun, harap Daftar terlebih dahulu.</p>
				<p>	->	Jika Anda sudah mempunyai akun, langkah selanjutnya silahkan klik tombol Login dan isi Data diri dan berkas-berkas yang ada.</p>
			</div>
			</div>
		</div>

		<!-- footer -->
		<footer>
			<div class="container">
				<small>Copyright &copy; 2022 - SMKN 7 Yonaprama Banglitafi . All Rigths Reserved</small>
			</div>
		</footer>
	
</body>
</html>