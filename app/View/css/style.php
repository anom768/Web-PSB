
<style>
	* {
	padding: 0;
	margin: 0;
	font-family: 'Quicksand', sans-serif; 
}
body {
	background-color: #f8f8f8;
}
.box-formulir {
	width: 85%;
	margin: 10px auto;
}
.box {
	background-color: white;
	border: 1px solid #ccc;
	padding: 15px;
	box-sizing: border-box;
	margin: 10px 0 25px 0;
}

.table-form {
	width: 100%;
}
.table-form tr td:nth-child(1) {
	width: 30%;
}
.input-control {
	padding: 10px;
	font-size: 16px;
	margin: 5px 0;
	width: 100%;
	box-sizing: border-box;
}
.btn-next {
	padding: 10px 17px;
	background-color: #4A99D7;
	color: white;
	border: none;
	font-size: 16px;
}
.btn-next:hover {
	cursor: pointer;
	background-color: #4881AE;
}
.btn-cetak {
	display: inline-block;
	padding: 10px 17px;
	color: white;
	background-color: #4BA2FF;
	margin-top: 5px;
	margin-bottom: 10px;
}
.btn-cetak:hover {
	cursor: pointer;
	background-color: #ddd;
	color: #4BA2FF;
}
.table-data {
	width: 100%;
	margin-top: 10px;
}
.table-data tr {
	height: 35px;
}
.table-data tr td:nth-child(1) {
	width: 30%;
}
.table-nilai {
	width: 45px;
	margin-top: 10px;
}
.table-nilai tr {
	height: 35px;
}
header {
	background-color: #4BA2FF;
}
header:after {
	content: '';
	display: block;
	clear: both;
}
header h1 {
	padding: 12px 0;
	display: inline-block;
	/* float: left; */
	color: white;
	
}

header ul {
	float: right;
}
header li {
	display: inline-block;
}
a {
	text-decoration: none;
	color: inherit;

}
header ul li {
	display: inline-block;
	color: white;

}
header ul li a {
	padding:25px 20px;
	display: inline-block;
}
header ul li a:hover {
	background-color: white;
	color: #4BA2FF;
}
.active {
	background-color: white;
	color: #4BA2FF;
}
.container {
	width: 85%;
	margin: 0 auto;
}
.container:after {
	content: '';
	display: block;	
	clear: both;
}
.content {
	width: 90%;
	padding: 10px;
	box-sizing: border-box;
	margin: 50px auto;
}
.table {
	width: 100%;
	border-collapse: collapse;
	border: 1px solid #ddd ;
}
.table-data {
	text-align: left;
}
.table tr {
	height: 30px;
}
.table tr td {
	padding: 5px 10px;
	text-align: center;
}
.table tr td:nth-child(1){
	text-align: center;
}
.page-login{
	width: 100%;
	height: 100vh;
	background-color: #2E8BC0;
	display: flex;
	justify-content: center;
	align-items: center;
}
.boxx {
	background-color: white;
	border: 1px solid #ddd;
}
.box-header{
	padding: 16px;
	border-bottom: 1px solid #ddd ;
	background-color: #f2f2f2;
}
.box-body {
	padding: 16px;
}
.box-footer {
	background-color: #f2f2f2;
	padding: 16px;
	border-bottom: 1px solid #ddd ;
}
form {
	margin: 15px 0;
}
.form-group {
	margin-bottom: 15px;
}
.form-group label {
	display: block;
	margin-bottom: 8px;
}
.form-group .input-control {
	padding:10px 16px;
	width: 100%;
	box-sizing: border-box;
	font-size: 16px;
	border: 1px solid #ddd;
}
.box-login {
	width: 350px;
}
.btn {
	border: 1px solid #ddd;
	padding: 10px 16px;
	font-size: 16px;
}
.btn:hover {
	cursor: pointer;
	background-color: #2E8BC0;
	color: white;

}
.text-center {
	text-align: center !important;
}
.alert {
	padding: 10px 16px;
	border: 1px solid;
}
.alert-error {
	background-color: #FABEC0;
	border: 1px solid #E43D40;
	color: #E43D40;
}
.section {
	padding: 25px 0;
}
.label {
	background-color: white;
	color: #4BA2FF;
	padding: 10px 0;
}
/*banner*/
	.banner {
		height: 60vh;
		/* background-image: url('../img/school.jpg'); */
		background-size: cover;
		position: relative;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.banner:after {
		content:'';
		display: block;
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: rgba(57, 153, 255, .5);
	}
	.banner h2 {
		color: #fff;
		z-index: 1;
		padding: 20px 25px;
		border:3px solid #fff;
	}
.footer {
	padding:30px 0;
	background-color: #333;
	color: #fff;
	text-align: center;
}

footer {
	padding:30px 0;
	background-color: #333;
	color: #fff;
	text-align: center;
}
</style>