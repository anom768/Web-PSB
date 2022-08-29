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

	<h2>Laporan Calon Siswa</h2><br><br>
	<table class="table" border="1">
				<thead>
					<tr>
						<th>No</th>
						<th>ID Pendaftaran</th>
						<th>Nama</th>
						<th>Jurusan</th>
						<th>B. Indo</th>
						<th>B. Ing</th>
						<th>MTK</th>
						<th>Hasil</th>
						<th>Catatan</th>
					</tr>
				</thead>
				<tbody>
				<?php
						$no = 1;
						if (isset($model["formScore"])) {
						foreach ($model["formScore"] as $row) {
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
					</tr>
					<?php }} ?>
				</tbody>
			</table>
</body>
</html>