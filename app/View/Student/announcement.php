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
			<li ><a href="/">Dashboard</a></li>
			<li class="active"><a href="/students/registration">Pendaftaran</a></li>
			<li><a href="/students/logout">Logout</a></li>
		</ul>
		</div>
	</header>

	<!-- label -->
    <section class="label">
        <div class="container">
            <p>Home / Pengumuman</p>
        </div>
    </section>
	<!-- content -->
	<div class="section">
		<div class="container">
			<div class="box">
				<h2>PENGUMUMAN</h2>
				<br>
				<h3><?= $model["note"] ?? "" ?></h3> <br>
				<h5><?= "Admin : " . $model["admin"] ?? "" ?></h5>
			</div>
	
</body>
</html>