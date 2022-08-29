<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $model["title"] ?? "" ?></title>
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body>
<?php if(isset($model["error"])) { ?>
        <div class="row">
        <div class="alert alert-danger" role="alert">
            <?= $model["error"] ?>
        </div>
    </div>
    <?php } ?>
	<!-- bagian header -->
	<header>
		<div class="container">
		<h1>SMKN 7 Yonaprama Banglitafi</h1>
		<ul>
			<li><a href="/">Dashboard</a></li>
			<li class="active"><a>Pendaftaran</a></li>
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

	<div class="section">
		<h2 align="center"><b>Formulir Penerimaan Siswa Baru</b></h2>
		<div class="container">
	</div>
	</div>


	<!-- bagian box formulir -->
	<section class="box-formulir">
		<div class="box">
				<h4>Hello <?= $model["email"] ?? "" ?> ^-^ Harap isikan formulir dengan benar, karena data tidak bisa diubah ketika sudah mendaftar</h4>
		</div>
	</section>
	
		<section class="box-formulir">
		<form action="/students/registration" method="post">
			<div class="box">
				<table border="0" class="table-form">
					<tr>
						<td>Tahun Ajaran</td>
						<td>:</td>
						<td>
							<input type="text" name="school_year" class="input-control" value="2022/2023" readonly>
						</td>
					</tr>
					<tr>
						<td>Jurusan</td>
						<td>:</td>
						<td>
							<select class="input-control" name="major">
								<option value="Teknik Kendaraan Ringan">Teknik Kendaraan Ringan</option>
								<option value="Teknik Mesin">Teknik Mesin</option>
								<option value="Teknik Komputer Jaringan">Teknik Komputer Jaringan</option>
								<option value="Multimedia">Multimedia</option>
							</select>
						</td>
					</tr>
				</table>
			</div>

			<h3>Data Pribadi</h3>
			<div class="box">
				<table border="0" class="table-form">
					<tr>
						<td>Nama Lengkap</td>
						<td>:</td>
						<td>
							<input type="text" value="<?= $_POST["name"] ?? "" ?>" name="name" class="input-control">
						</td>
					</tr>
					<tr>
						<td>Tempat Lahir</td>
						<td>:</td>
						<td>
							<input type="text" value="<?= $_POST["place_ob"] ?? "" ?>" name="place_ob" class="input-control">
						</td>
					</tr>
					<tr>
						<td>Tanggal Lahir</td>
						<td>:</td>
						<td>
							<input type="date" name="date_ob" class="input-control">
						</td>
					</tr>
					<tr>
						<td>Jenis Kelamin</td>
						<td>:</td>
						<td>
							<select class="input-control" name="gender">
								<option value="Laki-Laki">Laki-Laki</option>
								<option value="Perempuan">Perempuan</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Agama</td>
						<td>:</td>
						<td>
							<select class="input-control" name="religion">
								<option value="Islam">Islam</option>
								<option value="Kristen">Kristen</option>
								<option value="Hindu">Hindu</option>
								<option value="Budha">Buddha</option>
								<option value="Katolik">Katolik</option>
								<option value="Lainnya">Lainnya</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Alamat Lengkap</td>
						<td>:</td>
						<td>
							<textarea class="input-control" value="<?= $_POST["address"] ?? "" ?>" name="address"></textarea>
						</td>
					</tr>
					<tr>
						<td>NoHP</td>
						<td>:</td>
						<td>
							<input type="number" value="<?= $_POST["phone"] ?? "" ?>" name="phone" class="input-control">
						</td>
					</tr>
				</table>
			</div>

		<!-- bagian box formulir -->
		<h3>Nilai Rapot</h3>
		<div class="box">
				<table border="0" class="table-form">
					<tr>
						<td>Bahasa Indonesia</td>
						<td>:</td>
						<td>
							<input type="number" value="<?= $_POST["b_indo"] ?? "" ?>" name="b_indo" class="input-control" required>
						</td>
					</tr>
					<tr>
						<td>Bahasa Inggris</td>
						<td>:</td>
						<td>
							<input type="number" value="<?= $_POST["b_ing"] ?? "" ?>" name="b_ing" class="input-control" required>
						</td>
					</tr>
					<tr>
						<td>Matematika</td>
						<td>:</td>
						<td>
							<input type="number" value="<?= $_POST["mtk"] ?? "" ?>" name="mtk" class="input-control" required>
						</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td>
					
							<button type="submit" class="btn btn-primary" name="btn-daftar">Daftar Sekarang</button>
						</td>
					</tr>
 			</div>
			</form>
	</section>
</body>
</html>