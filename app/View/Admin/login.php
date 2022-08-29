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
				Login Admin
			</div>

			<!-- box body -->
			<div class="box-body">
				
				<!-- form login -->
				<form action="/admin/login" method="POST">
					
					<div class="form-group">
						<label>Username</label>
						<input type="email" name="email" value="<?= $_POST["email"] ?? "" ?>" placeholder="Email" class="input-control">
					</div>

					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" placeholder="Password"class="input-control">
					</div>

					<input type="submit" name="submit" value="Login" class="btn">

				</form>

			</div>

			<!-- box footer -->
			<div class="box-footer text-center">
				<a href="/">Halaman Utama</a>
			</div>

		</div>

	</div>

</body>
</html>