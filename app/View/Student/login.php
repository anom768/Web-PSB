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
			<h4 class="title">Login Siswa</h4>
			</div>

			<!-- box body -->
			<div class="box-body">
				
				<!-- form login -->
				<form action="/students/login" method="POST">
					
					<div class="form-group">
						<label>Email</label>
						<input type="text" value="<?= $_POST["email"] ?? "" ?>" name="email" placeholder="Email" class="input-control">
					</div>

					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" placeholder="Password" class="input-control">
						<a>Belum punya akun?<a href="/students/register"> Klik disini</a>
					</div>
					
					<input type="submit" name="submit" value="Login" class="btn">

				</form>
		</div>
		<div class="box-footer text-center">
				<a href="/">Halaman Utama</a>
			</div>
	</div>

</body>
</html>