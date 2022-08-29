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
			<li><a href="/">Home</a></li>
			<li class="active"><a>Data Siswa</a></li>
			<li><a href="/admin/logout">Logout</a></li>
		</ul>
		</div>
	</header>

	<!-- bagian content -->
	<div class="section">
	<section class="container">
		<h4><b>A. DATA PRIBADI</b></h4>
		<div class="box">
		<table class="table-data" border="0">
		<tr>
			<td>Kode Pendaftaran<td>:	<?= $model["id_registration"] ?? "" ?></td>
		</tr>
		<tr>
			<td>Tahun Ajaran<td>:	<?= $model["school_year"] ?? "" ?></td>
		</tr>
		<tr>
			<td>Jurusan<td>:	<?= $model["major"] ?? "" ?></td>
		</tr>
		</tr>
			<td>Nama Lengkap<td>:	<?= $model["name"] ?? "" ?></td>
		</tr>
		<tr>
			<td>Tempat, Tanggal Lahir<td>:	<?php echo $model["place_ob"] .",". $model["date_ob"] ?></td>
		</tr>
		<tr>
			<td>Jenis Kelamin<td>:	<?= $model["gender"] ?? "" ?></td>
		</tr>
		<tr>
			<td>Agama<td>:	<?= $model["religion"] ?? "" ?></td>
		</tr>
		<tr>
			<td>NoHP<td>:	<?= $model["phone"] ?? "" ?></td>
		</tr>
		<tr>
			<td>Alamat<td>:	<?= $model["address"] ?? "" ?></td>
		</tr>
		
	</table>
	<br>
	</section>
	<div class="section">
	<section class="container">
		<form action="/admin/save?email=<?= $model["email"] ?>" method="post">
		<h4><b>D. DATA NILAI</b></h4>
		<div class="box">
			<table class="table-data" border="0">
		<tr>
			<td>Bahasa Indonesia<td>:	<?= $model["b_indo"] ?? "" ?></td>
		</tr>
		<tr>
			<td>Bahasa Inggris<td>:	<?= $model["b_ing"] ?? "" ?></td>
		</tr>
		<tr>
			<td>Matematika<td>:	<?= $model["mtk"] ?? "" ?></td>
		</tr>
		<tr>
					<td>Hasil</td>
					<td>:</td>
					<td>
						<select class="input-control" name="result" required>
							<option value="Lulus">LULUS</option>
							<option value="Tidak Lulus">TIDAK LULUS</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Note</td>
					<td>:</td>
					<td>
					<input type="text" value="<?= $model["note"] ?? "" ?>" name="note" class="input-control">
						<button type="button" class="btn" onclick="window.location = '/students/data'">Back</button> 
						<button type="submit" class="btn btn-primary" name="btn-simpan">Save</button>
					</td>
				</tr>
	</table>
		</div>
	</div>
	</form>	
	</section>
</body>
</html>