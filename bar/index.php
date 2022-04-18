<?php include("../fonksiyon/fonksiyon.php"); $sistem = new sistem;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <script src="../dosya/jquery.js"></script>
  <link rel="stylesheet" href="../dosya/boostrap.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <title> Restaurant Bar sistemi</title>
  <script>
  $(document).ready(function(){
    setInterval(function(){
      window.location.reload();
    },1000);
    $('#hazirlink a').click(function(){
      var urunid =$(this).attr('sectionId');
      var masaid =$(this).attr('sectionId2');
      $.post("../islemler.php?islem=barsip",{"urunid":urunid,"masaid":masaid},function(post_veri){
      $(".sonuc2").html(post_veri);
      window.location.reload();
      })
    })
  });
  </script>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <?php $sistem->barbilgi($db); ?>
    </div>
  </div>

</body>
</html>
