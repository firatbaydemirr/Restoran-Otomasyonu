<?php include_once("fonk/yonfonk.php"); $clas= new yonetim;
 $clas->cookcon($vt,true); ?>
<!DOCTYPE>
<html>
<head>
  <meta charset="utf-8">
  <script src="../dosya/jquery.js"></script>
  <link rel="stylesheet" href="../dosya/boostrap.css">
  <title> Yönetici Giriş</title>
  <style>
  #log {
    margin-top:17%;
    min-height:270px;
    background-color: #FEFEFE;
    border-radius: 20px;
    border: 2px solid #B7B7B7;
  }
  </style>
</head>
<body style="background-color:#EEE;">
<div class="container text-center">
<div class="row mx-auto">
		<div class="col-md-4"></div>
        <div class="col-md-4  mx-auto text-center" id="log">
        <?php
		@$buton=htmlspecialchars(strip_tags($_POST["buton"]));
		if (!$buton) :
		?>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="col-md-12 border-bottom p-2"><h3>Yönetici Giriş</h3></div>
        <div class="col-md-12"><input type="text" name="kulad" class="form-control mt-2" required="required" placeholder="Yönetici Adınız" autofocus="autofocus" /></div>
        <div class="col-md-12"><input type="password" name="sifre" class="form-control mt-2" required="required" placeholder="Şifreniz" /></div>
  <div class="col-md-12"><input type="submit" name="buton" class="btn btn-warning btn-block mt-2" value="GİRİŞ" /></div>
        </form>
        <?php
	//echo md5(sha1(md5("123")));
		else:
		@$sifre=htmlspecialchars(strip_tags($_POST["sifre"]));
		@$kulad=htmlspecialchars(strip_tags($_POST["kulad"]));
			if ($sifre=="" ||  $kulad=="") :
			echo "Bilgiler boş olamaz";
			header("refresh:2,url=index.php");
			else:
         $clas->giriskont($vt,$kulad,$sifre);
			endif;
		endif;
        ?>
        </div>
        <div class="col-md-4"></div>
</div>
</div>
</body>
</html>
