<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $model["title"] ?? "" ?></title>
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
	<script>
		window.print();
	</script>
</head>
<body>

	<div class="section">
	<div class="container">
	<h2>Bukti Pendaftaran</h2><br>
	<div class="container"> 
	</div>
	<h3>Data Pribadi</h3>
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
	<h3>Data Nilai Rapot</h3>
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
	</table>

	</div>
	</div>
</body>
</html>