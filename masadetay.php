<?php include("fonksiyon/fonksiyon.php"); $masam = new sistem;
$veri=$masam->benimsorgum2($db,"select * from garson where durum=1",1)->num_rows;
if ($veri==0):
  header("location:index.php");
endif;
  @$masaid=$_GET["masaid"];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <script src="dosya/jquery.js"></script>
  <link rel="stylesheet" href="dosya/boostrap.css">
  <link rel="stylesheet" href="dosya/stil.css">
  <script>
    $(document).ready(function(){
      var id="<?php echo $masaid; ?>";
      $("#veri").load("islemler.php?islem=goster&id="+id);
      $('#btn').click(function(){
        $.ajax({
          type: "POST",
          url: 'islemler.php?islem=ekle',
          data :$('#formum').serialize(),
          success: function(donen_veri)
          {
              $("#veri").load("islemler.php?islem=goster&id="+id);
              $('#formum').trigger("reset");
              $("#cevap").html(donen_veri).slideUp(2800);
          },
        })
      })
      $('#urunler a').click(function(){
        var sectionId=$(this).attr('sectionId');
        $("#sonuc").load("islemler.php?islem=urun&katid=" + sectionId).fadeIn();
      })
    });
  </script>
  <title> Restaurant Sipariş sistemi</title>
  <style>
  </style>
</head>
<body>
  <div class="container-fluid">
    <?php
    if ($masaid!=""):
  $son=$masam->masagetir($db,$masaid);
  $dizi=$son->fetch_assoc();
  @$deger=$_GET["deger"];
  switch ($deger){
    case "1":
    $masam->siparisler($db,$dizi["id"]);
    break;
  }
     ?>
  <div class="row bg-warning" id="div1" >
    <div class="col-md-4 bg-dark" id="div2">
        <div class="row">
          <div class="col-md-12 border-bottom border-dark bg-danger text-white mx-auto p-3 text-center " id="div3"><a href="index.php"
            class="btn btn-dark">ANA SAYFAYA DÖN</a><br><?php echo $dizi["ad"]; ?></div>
            <div  id="veri"></div>
            <div class="col-md-10" id="cevap"></div>
        </div>
    </div>
    <div class="col-md-6 bg-light">
      <div class="row"><form id="formum">
        <div class="col-md-12" id="sonuc" style="min-height:680px;"></div>
      </div>
      <div class="row" id="div4">
        <div class="col-md-12 ">
          <div class="row">
            <div class="col-md-6">
              <input type="hidden" name="masaid" value="<?php echo $dizi["id"]; ?>" />
              <input type="button" id="btn" value="EKLE" class="btn btn-dark btn-block mt-4" />
            </div>
            <div class="col-md-6">
              <?php
              for ($i=1; $i<=8; $i++):
                echo '<label class="btn btn-danger m-2"><input name="adet" type="radio" value="'.$i.'"/>'.$i.'</label>';
              endfor;
              ?>
            </form>
            </div>
          </div>
        </div>

      </div>
    </div>
              <!--kategoriler-->
    <div class="col-md-2 bg-dark"  id="urunler">
      <?php $masam->urunkategori($db);  ?>
    </div>

  </div>
<?php else:
        echo "hata var";
      endif;
      ?>
  </div>
</body>
</html>
