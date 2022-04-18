<?php ob_start(); include_once("fonk/yonfonk.php"); $yonclas= new yonetim;
$yonclas->cookcon($vt,false);
?>
<!DOCTYPE>
<html>
<head>
  <meta charset="utf-8">
  <script src="../dosya/jquery.js"></script>
  <link rel="stylesheet" href="../dosya/boostrap.css">
  <title>Kontrol Sistemi</title>
  <style>
  body{
    height: 100%;
    width: 100%;
    position: absolute;
  }
  .container-fluid,
  .row-fluid{
    height: inherit;

  }
  #lk:link, #lk:visited {
    color: #888;
    text-decoration: none;
  }
  #lk:hover{
    color: #000;
  }
  #div2{
    min-height: 100%;
    background-color: #EEE;
  }
  #div1{
    background-color: #fff;
    border:1px solid #000000;
    border-radius: 10px;
  }
  </style>
  <script language="javascript">
  var popupWindow=null;
  function ortasayfa(url,winName,w,h,scroll){
    LeftPosition = (screen.width) ? (screen.width-w)/2: 0;
    TopPosition = (screen.height) ? (screen.height-h)/2: 0;
    settings='height='+h+', width='+w+', top='+TopPosition+', left='+LeftPosition+', scrollbars='+scroll+', resizable'
    popupWindow=window.open(url,winName,settings)
  }
  </script>
</head>
<body>
  <div class="container-fluid bg-light">
    <div class="row row-fluid">
    <div class="col-md-3 border-right bg-dark">

      <div class="row">
        <div class="col-md-12 btn-dark p-4 mx-auto text-center font-weight-bold">
          <h3><?php echo $yonclas->kulad($vt); ?></h3>
        </div>
      </div>

      <div class="row bg-warning">
        <div class="col-md-12 bg-light p-2 pl-3 border-bottom border-top text-white">
          <a href="control.php?islem=masayon" id="lk">Masa Yönetimi</a>
        </div>

        <div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
          <a href="control.php?islem=urunyon" id="lk">Ürün Yönetimi</a>
        </div>

        <div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
          <a href="control.php?islem=katyon" id="lk">Kategori Yönetimi</a>
        </div>
        <div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
          <a href="control.php?islem=garsonyon" id="lk">Garson Yönetimi</a>
        </div>

        <div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
          <a href="control.php?islem=raporyon" id="lk">Rapor Yönetimi</a>
        </div>

        <div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
          <a href="control.php?islem=yonayar" id="lk">Yönetici Ayarları</a>
        </div>

        <div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
          <a href="control.php?islem=sifdeg" id="lk">Şifre Değiştir</a>
        </div>

        <div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
          <a href="control.php?islem=cikis" id="lk">Çıkış</a>
        </div>

        <table class="table text-center table-dark table-bordered  table-striped">
        <thead>
          <tr class="bg-warning">
            <th scope="col" colspan="4">ANLIK DURUM</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              <th scope="col" colspan="3">Toplam Sipariş</th>
                <th scope="col" colspan="1" class="text-danger"><?php $yonclas->topurunadet($vt); ?></th>
          </tr>
          <tr>
              <th scope="col" colspan="3">Doluluk Oranı</th>
                <th scope="col" colspan="1" class="text-danger"><?php $yonclas->doluluk($vt); ?></th>
          </tr>
          <tr>
              <th scope="col" colspan="3">Toplam Masa</th>
                <th scope="col" colspan="1" class="text-danger"><?php $yonclas->toplammasa($vt); ?></th>
          </tr>
          <tr>
              <th scope="col" colspan="3">Toplam Kategori</th>
                <th scope="col" colspan="1" class="text-danger"><?php $yonclas->toplamkat($vt); ?></th>
          </tr>
          <tr>
              <th scope="col" colspan="3">Toplam Ürün</th>
                <th scope="col" colspan="1" class="text-danger"><?php $yonclas->toplamurun($vt); ?></th>
          </tr>

        </tbody>
        </table>

      </div>

    </div>
    <div class="col-md-9">
      <div class="row bg-dark" id="div2">
        <div class="col-md-12 mt-4" id="div1">




          <?php
          @$islem=$_GET["islem"];
          switch ($islem):
      //------------------------------------
            case "masayon":
              $yonclas->masayon($vt);
            break;
            case "masasil":
              $yonclas->masasil($vt);
            break;
            case "masaguncel":
              $yonclas->masaguncel($vt);
            break;
            case "masaekle":
              $yonclas->masaekle($vt);
            break;
      //-------------------------------------
            case "urunyon":
              $yonclas->urunyon($vt,0);
            break;
            case "urunsil":
              $yonclas->urunsil($vt);
            break;
            case "urunguncel":
              $yonclas->urunguncel($vt);
            break;
            case "urunekle":
              $yonclas->urunekle($vt);
            break;
            case "katgore":
              $yonclas->urunyon($vt,2);
            break;
            case "aramasonuc":
              $yonclas->urunyon($vt,1);
            break;
      //-------------------------------------
            case "katyon":
            $yonclas->kategoriyon($vt);
            break;
            case "katekle":
            $yonclas->katekle($vt);
            break;
            case "katguncel":
            $yonclas->katguncel($vt);
            break;
            case "katsil":
            $yonclas->katsil($vt);
            break;
      //----------------------------------------
      //-------------------------------------
            case "yonayar":
            $yonclas->yoneticiayar($vt);
            break;
            case "yonekle":
            $yonclas->yoneticiekle($vt);
            break;
            case "yonguncel":
            $yonclas->yoneticiguncel($vt);
            break;
            case "yonsil":
            $yonclas->yoneticisil($vt);
            break;
      //----------------------------------------
            case "garsonyon":
            $yonclas->garsonyon($vt);
            break;
            case "garsonekle":
            $yonclas->garsonekle($vt);
            break;
            case "garsonguncel":
            $yonclas->garsonguncel($vt);
            break;
            case "garsonsil":
            $yonclas->garsonsil($vt);
            break;
      //--------------------------------------
            case "raporyon":
              $yonclas->rapor($vt);
            break;
            case "sifdeg":
              $yonclas->sifredegis($vt);
            break;
            case "cikis":
            $yonclas->cikis($vt,$yonclas->kulad($vt));
            break;
            default;
            $yonclas->urunyon($vt,0);
          endswitch;

          ?>
        </div>
      </div>


    </div>
  </div>
</div>
</body>
</html>
