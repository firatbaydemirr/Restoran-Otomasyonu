<?php include("fonksiyon/fonksiyon.php");
@$masaid=$_GET["masaid"];
?>
<html>
<head>
  <meta charset="utf-8">
  <script src="dosya/jquery.js"></script>
  <link rel="stylesheet" href="dosya/boostrap.css">
  <link rel="stylesheet" href="dosya/stil.css">
  <script>
    $(document).ready(function(){
      $('#degistirform').hide();
      $('#birlestirform').hide();

      $('#degistir a').click(function() {
      $('#birlestirform').slideDown();
      $('#degistirform').slideDown();
      });
      $('#birlestir a').click(function() {
      $('#degistirform').slideUp();
      $('#birlestirform').slideDown();
      });
      $('#degistirbtn').click(function(){
        $.ajax({
          type: "POST",
          url: 'islemler.php?islem=masaislem',
          data :$('#degistirformveri').serialize(),
          success: function(donen_veri)
          {
              $('#degistirformveri').trigger("reset");
                window.location.reload();
          },
        })
      });

      $('#birlestirbtn').click(function(){
        $.ajax({
          type: "POST",
          url: 'islemler.php?islem=masaislem',
          data :$('#birlestirformveri').serialize(),
          success: function(donen_veri)
          {
              $('#birlestirformveri').trigger("reset");
                window.location.reload();
          },
        })
      });

      $('#btnn').click(function(){
        $.ajax({
          type: "POST",
          url: 'islemler.php?islem=hesap',
          data :$('#hesapform').serialize(),
          success: function(donen_veri)
          {
              $('#hesapform').trigger("reset");
                window.location.reload();
          },
        })
      })

      $('#yakala a').click(function(){
        var sectionId =$(this).attr('sectionId');
        var sectionId2 =$(this).attr('sectionId2');
        $.post("islemler.php?islem=sil",{"urunid":sectionId,"masaid":sectionId2},function(post_veri){
        $(".sonuc2").html(post_veri);
        window.location.reload();
        })
      })

    });
    var popupWindow=null;
    function ortasayfa(url,winName,w,h,scroll){
      LeftPosition = (screen.width) ? (screen.width-w)/2: 0;
      TopPosition = (screen.height) ? (screen.height-h)/2: 0;
      settings='height='+h+', width='+w+', top='+TopPosition+', left='+LeftPosition+', scrollbars='+scroll+', resizable'
      popupWindow=window.open(url,winName,settings)
    }
  </script>
  <title>Restaurant Sipariş sistemi</title>
</head>
<body>
  <?php
function benimsorgum2($vt,$sorgu,$tercih){
  $a=$sorgu;
  $b=$vt->prepare($a);
  $b->execute();
  if ($tercih==1):
  return $c=$b->get_result();
endif;
}
function formgetir($masaid,$db,$baslik,$durum,$btnvalue,$btnid,$formvalue){
  echo '<div class="card border-success mt-3" style="max-width:18rem;">
  <div class="card-header">'.$baslik.'</div><div class="card-body text-success">
  <form id="'.$formvalue.'">
  <input type="hidden" name="mevcutmasaid" value="'.$masaid.'"/>
  <select name="hedefmasa" class="form-control">';
  $masadeg=benimsorgum2($db,"select * from masalar where durum=$durum",1);
  while ($son=$masadeg->fetch_assoc()):

    if($masaid!=$son["id"]):
      echo '<option value="'.$son["id"].'">'.$son["ad"].'</option>';
    endif;
  endwhile;
  echo '</select><input type="button" id="'.$btnid.'" value="'.$btnvalue.'" class="btn btn-success btn-block mt-3"/>
  </form>
  </div>
  ';
}

@$islem=$_GET["islem"];
switch ($islem):

  case "masaislem":
  $mevcutmasaid=$_POST["mevcutmasaid"];
  $hedefmasa=$_POST["hedefmasa"];
  benimsorgum2($db,"update anliksiparis set masaid=$hedefmasa where masaid=$mevcutmasaid",1);
  $ekleson2=$db->prepare("update masalar set durum=0 where id=$mevcutmasaid");
  $ekleson2->execute();
  $ekleson2=$db->prepare("update masalar set durum=1 where id=$hedefmasa");
  $ekleson2->execute();
  break;

  case "hesap":
  if (!$_POST):
    echo "Postan gelmiyosun";
  else:
      $masaid=htmlspecialchars($_POST["masaid"]);
      $sorgu="select * from anliksiparis where masaid=$masaid";
      $verilericek=benimsorgum2($db,$sorgu,1);
      while($don=$verilericek->fetch_assoc()):
        $a=$don["masaid"];
        $b=$don["urunid"];
        $c=$don["urunad"];
        $d=$don["urunfiyat"];
        $e=$don["adet"];
        $bugun=date("Y-m-d");
    $raporekle="insert into rapor (masaid,urunid,urunad,urunfiyat,adet,tarih) VALUES($a,$b,'$c',$d,$e,'$bugun')";
    $raporekles=$db->prepare($raporekle);
    $raporekles  ->execute();
    $urunebak=benimsorgum2($db,"select stok from urunler where id=$b",1);
    $urunbilgi=$urunebak->fetch_assoc();
    if($urunbilgi["stok"]!=0):
      $urunStokSon=$urunbilgi["stok"] - $e;
      $raporekles=$db->prepare("update urunler set stok=$urunStokSon where id=$b");
      $raporekles->execute();
    endif;
  endwhile;
  $sorgu="delete from anliksiparis where masaid=$masaid";
  $silme=$db->prepare($sorgu);
  $silme->execute();
  endif;
  break;
  case "sil":
    if (!$_POST):
      echo "Postan gelmiyosun";
    else:
      $gelenid=htmlspecialchars($_POST["urunid"]);
      $masaid=htmlspecialchars($_POST["masaid"]);
      $sorgu="delete from anliksiparis where urunid=$gelenid and masaid=$masaid";
      $silme=$db->prepare($sorgu);
      $silme->execute();

      $sorgu2="delete from mutfaksiparis where urunid=$gelenid and masaid=$masaid";
      $silme2=$db->prepare($sorgu2);
      $silme2->execute();

      $sorgu3="delete from barsiparis where urunid=$gelenid and masaid=$masaid";
      $silme3=$db->prepare($sorgu3);
      $silme3->execute();

      $ekleson2=$db->prepare("update masalar set durum=0 where id=$masaid");
      $ekleson2->execute();
    endif;
  break;
  case "goster":
  $id=htmlspecialchars($_GET["id"]);
        $a="select * from anliksiparis where masaid=$id";
        $d=benimsorgum2($db,$a,1);
        if ($d->num_rows==0):
              echo '<div class="alert alert-info mt-3">Henüz Sipariş Yok</div>';
              $ekleson2=$db->prepare("update masalar set durum=0 where id=$id");
              $ekleson2->execute();
    else:
      echo '<table class="table table-bordered table-stripet text-center bg-light">
      <thead>
      <tr class="btn-dark">
      <th scope="col">Ürün Adı</th>
      <th scope="col">Adet</th>
      <th scope="col">Ürün Fiyatı</th>
      <th scope="col">Tutar</th>
      <th scope="col">Ürün Sil</th>
      </tr>
      </thead>
      <tbody>
      ';
      $adet=0;
      $sontutar=0;
      while ($gelenson=$d->fetch_assoc()):
        $tutar = $gelenson["adet"] * $gelenson["urunfiyat"];
        $adet +=$gelenson["adet"];
        $sontutar +=$tutar;
        $masaid=$gelenson["masaid"];
        echo '<tr>
            <td>'.$gelenson["urunad"].'</td>
            <td>'.$gelenson["adet"].'</td>
            <td>'.$gelenson["urunfiyat"].'</td>
            <td>'.number_format($tutar,2,'.',',').'</td>
            <td id="yakala"><a class="btn btn-danger mt-2 text-white" sectionId="'.$gelenson["urunid"].'" sectionId2="'.$id.'">SİL</a></td>
        </tr>';
      endwhile;
      echo '
      <tr class="btn-dark">
          <td>TOPLAM</td>
          <td>'.$adet.'</td>
          <td>ÜCRET</td>
          <td class="bg-danger">'.number_format($sontutar,2,'.',',').'<td>TL</td></td>
      </tr>
      </tbody></table>
      <div class="row">
        <div class="col-md-12">
          <div class="row">
          <div class="col-md-10" id="degistir"><a class="btn btn-success btn-block mt-1" style="height:40px;"><i class="fas fa-exchange-alt mt-1">MASA DEĞİŞTİR & BİRLEŞTİR</i></a></div>
          <div class="col-md-2" id="birlestir"><a class="btn btn-danger  mt-1" style="height:40px;"><i class="fas fa-stream-alt mt-1">x</i></a></div>
          </div>
          <div class="row">
            <div class="col-md-12" id="degistirform">'; formgetir($id,$db,"MASA Değiştir",0,"Değiştir","degistirbtn","degistirformveri"); echo ' </div>
            <div class="col-md-12" id="birlestirform">'; formgetir($id,$db,"MASA Birleştir",1,"Birleştir","birlestirbtn","birlestirformveri"); echo ' </div>
          </div>
        </div>
      <div class="col-md-12">
      <form id="hesapform">
      <input type="hidden" name="masaid" value="'.$masaid.'"/>
      <input type="button" id="btnn" value="HEASABI KAPAT" class="btn btn-danger btn-block mt-3"/>
      </form>
      <p><a href="fisbastir.php?masaid='.$masaid.'" onclick="ortasayfa(this.href,\'mywindow\',\'350\',\'400\',\'yes\');return false" class="btn btn-warning btn-block mt-3">HEASABI YAZDIR</a></p>
      </div>
      </div>';
    endif;
  break;
  case "ekle":
  if ($_POST) :
    @$masaid=htmlspecialchars($_POST["masaid"]);
    @$urunid=htmlspecialchars($_POST["urunid"]);
    @$adet=htmlspecialchars($_POST["adet"]);

      if ($masaid=="" ||   $urunid=="" || $adet=="" ):
        echo '<div class="alert alert-danger ">ÜRÜN VEYA ADET GİRMEYİ UNUTTUNUZ !!</div>';
      else:

          $varmi="select * from anliksiparis where urunid=$urunid and masaid=$masaid";
          $var=benimsorgum2($db,$varmi,1);
          if ($var->num_rows!=0) :
            $urundizi=$var->fetch_assoc();
            $sonadet=$adet + $urundizi["adet"];
            $islemid=$urundizi["id"];
            $guncel="UPDATE anliksiparis set adet=$sonadet where id=$islemid";
            $guncelson=$db->prepare($guncel);
            $guncelson->execute();
            echo  '<div class="alert alert-success ">Ürün Güncellendi</div>';
          else:
            $saat=date("H");
            $dakika=date("i");
            $a="select * from urunler where id=$urunid";
            $d=benimsorgum2($db,$a,1);
            $son=$d->fetch_assoc();
            $urunad=$son["ad"];
            $katid=$son["katid"];
            $urunfiyat=$son["fiyat"];
            $ekle="insert into anliksiparis (masaid,urunid,urunad,urunfiyat,adet) VALUES ($masaid,$urunid,'$urunad','$urunfiyat',$adet)";
            $ekleson=$db->prepare($ekle);
            $ekleson->execute();
            $ekleson2=$db->prepare("update masalar set durum=1 where id=$masaid");
            $ekleson2->execute();
            $durumba=benimsorgum2($db,"select * from kategori where id=$katid",1);
            $durumbak=$durumba->fetch_assoc();
            if($durumbak["durum"]==0):
            benimsorgum2($db,"insert into mutfaksiparis (masaid,urunid,urunad,adet,saat,dakika) VALUES ($masaid,$urunid,'$urunad',$adet,$saat,$dakika)",0);
            elseif($durumbak["durum"]==1):
              benimsorgum2($db,"insert into barsiparis (masaid,urunid,urunad,adet,saat,dakika) VALUES ($masaid,$urunid,'$urunad',$adet,$saat,$dakika)",0);
            endif;
            echo '<div class="alert alert-success mt-4 text-align">Eklendi</div>';
          endif;
        endif;
  else:
    echo '<div class="alert alert-danger ">HATA VAR !</div>';
  endif;
  break;

  case "mutfaksip":
    if (!$_POST):
      echo "Postan gelmiyosun";
    else:
      $gelenid=htmlspecialchars($_POST["urunid"]);
      $masaid=htmlspecialchars($_POST["masaid"]);
      $sorgu="delete from mutfaksiparis where urunid=$gelenid and masaid=$masaid";
      $silme=$db->prepare($sorgu);
      $silme->execute();
    endif;
  break;

  case "barsip":
    if (!$_POST):
      echo "Postan gelmiyosun";
    else:
      $gelenid=htmlspecialchars($_POST["urunid"]);
      $masaid=htmlspecialchars($_POST["masaid"]);
      $sorgu="delete from barsiparis where urunid=$gelenid and masaid=$masaid";
      $silme=$db->prepare($sorgu);
      $silme->execute();
    endif;
  break;

  case "urun":
  $katid=htmlspecialchars($_GET["katid"]);
  $a="select * from urunler where katid=$katid";
  $d=benimsorgum2($db,$a,1);
  while ($sonuc=$d->fetch_assoc()) :
      echo '<label class="btn btn-dark m-2">
      <input name="urunid" type="radio" value="'.$sonuc["id"].'"/>'.$sonuc["ad"].'</label>';

  endwhile;

  break;
  case "kontrol":
		$ad=htmlspecialchars($_POST["ad"]);
		$sifre=htmlspecialchars($_POST["sifre"]);
		if (@$ad!="" && @$sifre!="") :
				$var=benimsorgum2($db,"select * from garson where ad='$ad'  and sifre='$sifre'",1);
					if ($var->num_rows==0) :
						echo '<div class="alert alert-danger text-center">Bilgiler uyuşmuyor</div>';
					else:
					$garson=$var->fetch_assoc();
					$garsonid=$garson["id"];
					benimsorgum2($db,"update garson set durum=1 where id=$garsonid",1);
					?>
           <script>window.location.reload();</script>
           <?php
					endif;
		else:
		echo '<div class="alert alert-danger text-center">Boş alan bırakma</div>';
		endif;
		break;
    case "cikis":
		benimsorgum2($db,"update garson set durum=0",1);
		header("Location:index.php");
		break;

endswitch;

 ?>
</body>
</html>
