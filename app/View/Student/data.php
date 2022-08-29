<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $model["title"] ?></title>
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
	<div class="container">
		<h4>Data Peserta</h4>
		<div class="box">
			<form action="/students/data" method="post">
			<a href="/print/students" target="blank" class="btn-cetak">Print</a>
			<td><input type="text" name="searching" placeholder="Masukkan data disini" size="100"></td>
			<button input type="submit" name="search">Search</button></form>
			<table class="table" border="1" align='center'>
				<thead>
					<tr>
						<th>No</th>
						<th>Id Pendaftaran</th>
						<th>Nama</th>
						<th width="160px">Jurusan</th>
						<th>B. Indo</th>
						<th>B. Ing</th>
						<th>MTK</th>
						<th>Hasil</th>
						<th width="200px">Note</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no = 1;
						if (isset($model["formScore"])) {
							foreach ($model["formScore"] as $row)
							{ 
					?>
					<tr>
						<td><?= $no++ ?></td>
						<td><?= $row["id_registration"] ?></td>
						<td><?= $row['name'] ?></td>
						<td><?= $row['major'] ?></td>
						<td><?= $row['b_indo'] ?></td>
						<td><?= $row['b_ing'] ?></td>
						<td><?= $row['mtk'] ?></td>
						<td><?= $row['result'] ?></td>
						<td><?= $row['note'] ?></td>
						<td>
							<a href="/admin/update?email=<?= $row["email"] ?>" title="Edit Data" class="text-orange"><i class="fa fa-edit"></i></a> 
							<a href="/admin/delete?email=<?= $row["email"] ?>" onclick="return confirm('Yakin Hapus?')" title="Hapus Data" class="text-red"><i class="fa fa-times"></i></a>
						</td>
					</tr>
					<?php } }?>
				</tbody>
			</table>
		</div>
	</div>
	</div>
	</section>

</body>
</html>