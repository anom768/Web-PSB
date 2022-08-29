<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $model["title"] ?? "" ?></title>
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body>
<header>
		<div class="container">
		<h1>SMKN 7 Yonaprama Banglitafi</h1>
		<ul>
			<li><a href="/">Dashboard</a></li>
			<li class="active"><a href="/students/registration">Pendaftaran</a></li>
			<li><a href="/students/logout">Logout</a></li>
		</ul>
		</div>
	</header>

	<!-- label -->
    <section class="label">
        <div class="container">
            <p>Home / Pendaftaran</p>
        </div>
    </section>

<section class="box-formulir">
    
				<form action='/students/registration/card' target="blank" method="POST">
					<div class="box" align='center'>
					<h3>Thanks <?= $model["email"] ?? "" ?> ^-^</h3> <br>
					<p>Anda Sudah Melakukan Pendaftaran</p></br>
				</form>
				<button type="submit" class="btn btn-primary">Cetak Bukti Pendaftaran</button> 
				<form action='/students/announcement' method="POST"><div align='center'>
				</form>
				<button type="submit" class="btn btn-primary">Lihat Hasil Pengumuman</button>
	
	</section>

    </body>
</html>