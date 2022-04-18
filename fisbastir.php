<?php include("fonksiyon/fonksiyon.php"); $masam = new sistem;
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
      $('#btnn').click(function(){
        $.ajax({
          type: "POST",
          url: 'islemler.php?islem=hesap',
          data :$('#hesapform').serialize(),
          success: function(donen_veri)
          {
              $('#hesapform').trigger("reset");
              window.opener.location.reload(true);
                window.close();
          },
        })
      })
    });
  </script>
  <title>FİŞ BASTIR</title>
  <style>
  </style>
</head>
<body onload="window.print()">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2 mx-auto">
        <?php
        if ($masaid!=""):
      $son=$masam->masagetir($db,$masaid);
      $dizi=$son->fetch_assoc();
       $dizi["ad"];

       $id=htmlspecialchars($_GET["masaid"]);
             $a="select * from anliksiparis where masaid=$id";
             $d=$masam->benimsorgum2($db,$a,1);
             if ($d->num_rows==0):
                   echo "Henüz Sipariş Yok";
         else:
           echo '<table class="table">
           <tr>
             <td colspan="3" class="border-top-0 text-center"><strong>MASA :</strong>'.$dizi["ad"].'</td>
           </tr>
           <tr>
             <td colspan="3" class="border-top-0 text-left"><strong>Tarih :</strong>'.date("d.m.Y").'</td>
           </tr>
           <tr>
             <td colspan="3" class="border-top-0 text-left"><strong>Saat :</strong>'.date("h:i:s").'</td>
           </tr>
           ';

           $sontutar=0;
           while ($gelenson=$d->fetch_assoc()):
             $tutar = $gelenson["adet"] * $gelenson["urunfiyat"];

             $sontutar +=$tutar;
             $masaid=$gelenson["masaid"];
             echo '<tr>
               <td colspan="1" class="border-top-0 text-center">'.$gelenson["urunad"].'</td>
               <td colspan="1" class="border-top-0 text-center">'.$gelenson["adet"].'</td>
               <td colspan="1" class="border-top-0 text-center">'.$tutar.'</td>
             </tr>
                ';
           endwhile;
           echo '
           <tr>
             <td colspan="2" class="border-top-0  font-weight-bold"><strong>GENEL TOPLAM :</strong></td>
             <td colspan="2" class="border-top-0 text-center">'.number_format($sontutar,2,'.',',').' TL</td>
           </tr>
           </tbody></table>

           <form id="hesapform">
           <input type="hidden" name="masaid" value="'.$id.'"/>
           <input type="button" id="btnn" value="HEASABI KAPAT" class="btn btn-danger btn-block mt-3"/>
           </form>
           ';
         endif;

         ?>
      </div>
    </div>





<?php else:
        echo "hata var";
      endif;
      ?>
  </div>
</body>
</html>
