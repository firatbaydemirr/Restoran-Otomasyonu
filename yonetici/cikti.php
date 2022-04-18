<?php ob_start(); include_once("fonk/yonfonk.php"); $yonclas= new yonetim;
$yonclas->cookcon($vt,false);
?>
<!DOCTYPE>
<html>
<head>
  <meta charset="utf-8">
  <script src="../dosya/jquery.js"></script>
  <link rel="stylesheet" href="../dosya/boostrap.css">
  <title>Rapor Çıktı</title>
<script>
  function cikart(){
    window.print();
    window.close();
  }

</script>

</head>
<body onload="window.print()">
  <div class="container-fluid bg-light">
    <div class="row row-fluid">
          <?php
          @$islem=$_GET["islem"];
          switch ($islem):

            case "ciktial":
            @$tarih1=$_GET["tar1"];
            @$tarih2=$_GET["tar2"];

            $veri=$yonclas->ciktiicinsorgu($vt,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
            $veri2=$yonclas->ciktiicinsorgu($vt,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");


            echo '          <table class="table text-center table-light table-bordered  mx-auto mt-4 col-md-8">
                      <thead>
                        <tr>
                        <th colspan="7">  <div class="alert alert-info text-center mx-auto mt-4">
                        Tarih Seçimi :  '.$tarih1. ' - ' .$tarih2. '
                            </div></a></th>


                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                            <th colspan="4">
                              <table class="table text-center table-bordered  table-striped  col-md-12">
                                <thead>
                                  <tr>
                                    <th colspan="4" class="table-dark">Toplam Masa  Ve Hasılat</th>
                                  </tr >
                                </thead>
                                <thead>
                                  <tr class="table-warning">
                                    <th colspan="2">Ad</th>
                                    <th colspan="1">Adet</th>
                                    <th colspan="1">Hasılat</th>
                                  </tr>
                                </thead>
                                <tbody>';
                                $kilit=$yonclas->ciktiicinsorgu($vt,"select * from gecicimasa");
                                if($kilit->num_rows==0):
                                  while ($gel=$veri->fetch_assoc()):
                                    $id=$gel["masaid"];
                                    $masaveri=$yonclas->ciktiicinsorgu($vt,"select * from masalar where id=$id")->fetch_assoc();
                                    $masaad=$masaveri["ad"];
                                    $raporbak=$yonclas->ciktiicinsorgu($vt,"select * from gecicimasa where masaid=$id");
                                    if($raporbak->num_rows==0):
                                      $has=$gel["adet"] * $gel["urunfiyat"];
                                      $adet=$gel["adet"];
                                      $yonclas->ciktiicinsorgu($vt,"insert into gecicimasa (masaid,masaad,hasilat,adet) VALUES($id,'$masaad',$has,$adet)");
                                    else:
                                      $raporson=$raporbak->fetch_assoc();
                                      $gelenadet=$raporson["adet"];
                                      $gelenhas=$raporson["hasilat"];
                                      $sonhasilat=$gelenhas + ($gel["adet"] * $gel["urunfiyat"]);
                                      $sonadet=$gelenadet + $gel["adet"];
                                      $yonclas->ciktiicinsorgu($vt,"update gecicimasa set hasilat=$sonhasilat, adet=$sonadet where masaid=$id");
                                    endif;
                                  endwhile;
                                endif;
                                $son=$yonclas->ciktiicinsorgu($vt,"select * from gecicimasa order by hasilat desc;");
                                $toplamadet=0;
                                $toplamhasilat=0;
                                while ($listele=$son->fetch_assoc()):
                                  echo ' <tr>
                                      <td colspan="2">'.$listele["masaad"].'</td>
                                      <td colspan="1">'.$listele["adet"].'</td>
                                      <td colspan="1">'.substr($listele["hasilat"],0,5).' TL</td>
                                    </tr> ';
                                    $toplamadet +=$listele["adet"];
                                    $toplamhasilat +=$listele["hasilat"];
                                endwhile;
                                echo '
                                <tr>
                                    <td colspan="2" class=" btn-dark">TOPLAM</td>
                                    <td colspan="1" class="btn-warning">'.$toplamadet.'</td>
                                    <td colspan="1" class="btn-success">'.substr($toplamhasilat,0,6).' TL</td>
                                  </tr>
                                </tbody>
                              </table>
                            </th>
                              <th  colspan="4">
                              <table class="table text-center table-bordered  table-striped  col-md-12">
                                <thead>
                                  <tr>
                                    <th colspan="4" class="table-dark">Toplam Ürün Ve Hasılat</th>
                                  </tr >
                                </thead>
                                <thead>
                                  <tr class="table-warning">
                                    <th colspan="2">Ad</th>
                                    <th colspan="1">Adet</th>
                                    <th colspan="1">Hasılat</th>
                                  </tr>
                                </thead>
                                <tbody>';
                                $kilit2=$yonclas->ciktiicinsorgu($vt,"select * from geciciurun");
                                if($kilit2->num_rows==0):
                                  while ($gel2=$veri2->fetch_assoc()):
                                    $id=$gel2["urunid"];
                                    $urunad=$gel2["urunad"];

                                    $raporbak=$yonclas->ciktiicinsorgu($vt,"select * from geciciurun where urunid=$id");
                                    if($raporbak->num_rows==0):
                                      $has=$gel2["adet"] * $gel2["urunfiyat"];
                                      $adet=$gel2["adet"];
                                      $yonclas->ciktiicinsorgu($vt,"insert into geciciurun (urunid,urunad,hasilat,adet) VALUES($id,'$urunad',$has,$adet)");
                                    else:
                                      $raporson=$raporbak->fetch_assoc();
                                      $gelenadet=$raporson["adet"];
                                      $gelenhas=$raporson["hasilat"];
                                      $sonhasilat=$gelenhas + ($gel2["adet"] * $gel2["urunfiyat"]);
                                      $sonadet=$gelenadet + $gel2["adet"];
                                      $yonclas->ciktiicinsorgu($vt,"update geciciurun set hasilat=$sonhasilat, adet=$sonadet where urunid=$id");
                                    endif;
                                  endwhile;
                                endif;
                                $son2=$yonclas->ciktiicinsorgu($vt,"select * from geciciurun order by hasilat desc;");
                                while ($listele2=$son2->fetch_assoc()):
                                  echo ' <tr>
                                      <td colspan="2">'.$listele2["urunad"].'</td>
                                      <td colspan="1">'.$listele2["adet"].'</td>
                                      <td colspan="1">'.substr($listele2["hasilat"],0,5).' TL</td>
                                    </tr> ';
                                endwhile;
                                echo '
                                </tbody>
                              </table>
                              </th>
                        </tr>
                      </tbody>
                    </table>';
            break;
          endswitch;
          ?>
    </div>
  </div>
</div>
</body>
</html>
