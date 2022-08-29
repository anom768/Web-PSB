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
	<!-- page login -->
	<div class="page-login">
	
		<!-- box -->
		<div class="boxx box-login">
			
			<!-- box header -->
			<div class="box-header text-center">
				<h4 class="title">Daftar Siswa Baru</h4>
			</div>

			<!-- box body -->
			<div class="box-body">
				
				<!-- form login -->
				<form action="/students/register" method="POST">
					
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="email" placeholder="Email" class="input-control" autofocus
                        value="<?= $_POST["email"] ?? "" ?>">
					</div>

					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" placeholder="Password"class="input-control">
						<a>Sudah punya akun?<a href="/students/login"> Login disini</a>
					</div>
					<button type="submit" class="btn btn-primary" name="btn-daftar">Daftar</button>
				</form>			
			</div>
			<div class="box-footer text-center">
				<a href="/">Halaman Utama</a>
			</div>
		</div>
	</div>

</body>
</html>