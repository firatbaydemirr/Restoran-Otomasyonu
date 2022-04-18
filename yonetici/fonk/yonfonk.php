<?php
$vt = new mysqli("localhost","root","","siparis") or die ("Bağlantı kurulamadı !");
$vt->set_charset("utf8");
class yonetim {
  // genel uyarılar
  private function uyari($tip,$metin,$sayfa){
    echo '<div class="alert alert-'.$tip.' mt-5">'.$metin.'</div>';
    header('refresh:2,url='.$sayfa.'');
  }

  private function genelsorgu($dv,$sorgu){
    $sorgum=$dv->prepare($sorgu);
    $sorgum->execute();
    return $sorguson=$sorgum->get_result();
  }
  function ciktiicinsorgu($dv,$sorgu){
    $sorgum=$dv->prepare($sorgu);
    $sorgum->execute();
    return $sorguson=$sorgum->get_result();
  }
  //-----------------------------------
  // yönetici panel kısım
  function doluluk($dv){
    $veriler=$this->genelsorgu($dv,"select * from doluluk")->fetch_assoc();
    $toplam= $veriler["bos"] + $veriler["dolu"];
    $oran= ($veriler["dolu"] / $toplam) * 100 ;
    echo "% " .$oran=substr($oran,0,5);
  }
  function topurunadet($vt){
    $geldi=$this->genelsorgu($vt,"select SUM(adet) from anliksiparis")->fetch_assoc();
    echo $geldi['SUM(adet)'];
  }
  function toplammasa($vt){
    echo $this->genelsorgu($vt,"select * from masalar")->num_rows;
  }
  function toplamkat($vt){
    echo $this->genelsorgu($vt,"select * from kategori")->num_rows;
  }
  function toplamurun($vt){
    echo $this->genelsorgu($vt,"select * from urunler")->num_rows;
  }

//--------------------------------------
// ürün yönetimi
  function urunyon($vt,$tercih){
    if ($tercih==1):
      $aramabuton=$_POST["aramabuton"];
      $urun=$_POST["urun"];
      if ($aramabuton):
        $so=$this->genelsorgu($vt,"select * from urunler where ad LIKE '%$urun%'");
      endif;
    elseif ($tercih==2):
      $arama=$_POST["arama"];
      $katid=$_POST["katid"];
      if ($arama):
        $so=$this->genelsorgu($vt,"select * from urunler where katid=$katid");
      endif;
    elseif ($tercih==0):
        $so=$this->genelsorgu($vt,"select * from urunler");
    endif;
    echo '<table class="table text-center table-striped table-bordered mx-auto col-md-6  table-dark">
      <thead>
        <tr>
          <form action="control.php?islem=aramasonuc" method="post">
          <th><input type="search" name="urun" class="form-control" placeholder="Aranacak Ürün"/></th>
          <th><input type="submit" name="aramabuton" value="ARA" class="btn btn-warning" /></form></th>
          <th>
          <form action="control.php?islem=katgore" method="post">
          <select name="katid"  class="form-control">';
          $d=$this->genelsorgu($vt,"select * from kategori");
          while ($katson=$d->fetch_assoc()):
            echo '
            <option value="'.$katson["id"].'">'.$katson["ad"].'</option>';
          endwhile;
          echo '</select></th>
          <th><input type="submit" name="arama" value="GETİR" class="btn btn-warning" /></form></th>
        </tr>
      </thead>
    </table>';

      echo '<table class="table text-center table-striped table-bordered mx-auto col-md-8">
        <thead>
          <tr>
            <th scope="col">Ürün Adı</th>
            <th scope="col">Stok Adeti</th>
            <th scope="col">Ürün Fiyat</th>
            <th scope="col"><a href="control.php?islem=urunekle" class="btn btn-success">Ürün Ekle</a></th>
            <th scope="col">Sil</th>
          </tr>
        </thead>
        <tbody>';
      while($sonuc=$so->fetch_assoc()):
        echo '
        <tr>
        <td>'.$sonuc["ad"].'</td>
        <td>';
        $bitti=0;
        if($sonuc["stok"] <= $bitti):
          echo '<font class="text-danger">YOK</font>';
        else:
          echo '<font class="text-success">'.$sonuc["stok"].'</font>';
        endif;
        echo'</td>
        <td>'.$sonuc["fiyat"].'</td>
        <td><a href="control.php?islem=urunguncel&urunid='.$sonuc["id"].'" class="btn btn-warning">Güncelle</a></td>
        <td><a href="control.php?islem=urunsil&urunid='.$sonuc["id"].'" class="btn btn-danger">Sil</a></td>
        </tr>
        ';
      endwhile;
      echo '</tbody>
    </table>';
    }
    // ürün silme
  function urunsil($vt){
      $urunid=$_GET["urunid"];
      if($urunid!="" && is_numeric($urunid)):
        $satir=$this->genelsorgu($vt,"select * from anliksiparis where urunid=$urunid");

          if($satir->num_rows !=0):
              echo '<div class="alert alert-danger">
              Bu Ürün Şu Masalarda Mevcut;<br>';
            while($masabilgi=$satir->fetch_assoc()):
              $masaid=$masabilgi["masaid"];
              $masasonuc=$this->genelsorgu($vt,"select * from masalar where id=$masaid")->fetch_assoc();

              echo ">> ".$masasonuc["ad"]."<br>";
            endwhile;
            echo '</div>';

          else:
            $this->genelsorgu($vt,"delete from urunler where id=$urunid");
            $this->uyari("success","Ürün Silindi","control.php?islem=urunyon");
          endif;
      else:
        $this->uyari("danger","Ürün Silinmedi","control.php?islem=urunyon");
      endif;
    }
    // ürün güncelleme
  function urunguncel($vt){
      @$buton=$_POST["buton"];
      echo '<div class="col-md-3  text-center mx-auto mt-5 table-bordered">';
      if ($buton):
          @$urunad=htmlspecialchars($_POST["urunad"]);
          @$urunid=htmlspecialchars($_POST["urunid"]);
          @$fiyat=htmlspecialchars($_POST["fiyat"]);
          @$stok=htmlspecialchars($_POST["stok"]);
          @$katid=htmlspecialchars($_POST["katid"]);
          if ($urunad=="" || $urunid=="" || $katid=="" || $fiyat=="" || $stok==""):
            $this->uyari("danger","Bilgiler boş olamaz","control.php?islem=urunyon");
          else:
            $this->genelsorgu($vt,"update urunler set ad='$urunad', fiyat=$fiyat, katid=$katid, stok=$stok where id=$urunid");
            $this->uyari("success","Güncelleme Başarılı","control.php?islem=urunyon");
          endif;
      else:
        $urunid=$_GET["urunid"];
        $aktar=$this->genelsorgu($vt,"select * from urunler where id=$urunid")->fetch_assoc();
        ?>
          <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <?php
          echo '  <div class="col-md-12 table-light mt-2 border-bottom"><h4>Ürün Güncelle</h4></div>
            <div class="col-md-12 table-light mt-2"><input type="text" name="urunad" class="form-control" value="'.$aktar["ad"].'"/></div>
            <div class="col-md-12 table-light mt-2"><input type="text" name="fiyat" class="form-control" value="'.$aktar["fiyat"].'"/></div>
            <div class="col-md-12 table-light mt-2">';
            $katid=$aktar["katid"];
            $katcek=$this->genelsorgu($vt,"select * from kategori");
            echo '<select name="katid">';
            while ($katson=$katcek->fetch_assoc()):
              if ($katson["id"]==$katid):
                echo   '<option value="'.$katson["id"].'" selected="selected">'.$katson["ad"].'</option>';
                else :
                  echo   '<option value="'.$katson["id"].'">'.$katson["ad"].'</option>';
              endif;


            endwhile;
            echo '</select>';
          echo '  </div>
          <div class="col-md-12 table-light mt-2 text-success">Ürün Stok Adedi<input type="text" name="stok" class="form-control" value="'.$aktar["stok"].'"/></div>
            <div class="col-md-12 table-light mt-2"><input name="buton" type="submit" value="Güncelle" class="btn btn-success"</div>
            <input type="hidden" name="urunid" value="'.$urunid.'"/>
          </form>
        ';
      endif;
      echo '</div>';

    }
    // ürün ekleme
  function urunekle($vt){
        @$buton=$_POST["buton"];
        echo '<div class="col-md-3  text-center mx-auto mt-5 table-bordered">';
        if ($buton):
            @$urunad=htmlspecialchars($_POST["urunad"]);
            @$fiyat=htmlspecialchars($_POST["fiyat"]);
            @$katid=htmlspecialchars($_POST["katid"]);
            @$stok=htmlspecialchars($_POST["stok"]);
            if ($urunad==""|| $katid=="" || $fiyat=="" || $stok==""):
              $this->uyari("danger","Bilgiler boş olamaz","control.php?islem=urunyon");
            else:
              $this->genelsorgu($vt,"insert into urunler (ad,fiyat,katid,stok) VALUES ('$urunad',$fiyat,$katid,$stok) ");
              $this->uyari("success","Eklendi","control.php?islem=urunyon");
            endif;
        else:
          ?>
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
              <?php
            echo '  <div class="col-md-12 table-light mt-2 border-bottom"><h4>Ürün Ekleme</h4></div>
              <div class="col-md-12 table-light mt-2">Ürün Adı<input type="text" name="urunad" class="form-control"/></div>
              <div class="col-md-12 table-light mt-2">Ürün Fiyatı<input type="text" name="fiyat" class="form-control" /></div>
              <div class="col-md-12 table-light mt-2">';
              $katcek=$this->genelsorgu($vt,"select * from kategori");
              echo '<select name="katid">';
              while ($katson=$katcek->fetch_assoc()):
                    echo   '<option value="'.$katson["id"].'">'.$katson["ad"].'</option>';
              endwhile;
              echo '</select>';
            echo '  </div>
            <div class="col-md-12 table-light mt-2">Ürün Stok Adeti<input type="text" name="stok" class="form-control" /></div>
              <div class="col-md-12 table-light mt-2"><input name="buton" type="submit" value="Ekle" class="btn btn-success"</div>
            </form>
          ';
        endif;
        echo '</div>';

      }
//-----------------------------------------
// masa yönetimi
  function masayon($vt){
      $so=$this->genelsorgu($vt,"select * from masalar");
      echo '<table class="table text-center table-striped table-bordered mx-auto col-md-6 mt-1">
        <thead>
          <tr>
            <th scope="col">Masa Adı</th>
            <th scope="col"><a href="control.php?islem=masaekle" class="btn btn-success">Masa Ekle</a></th>
            <th scope="col">Sil</th>
          </tr>
        </thead>
        <tbody>';
      while($sonuc=$so->fetch_assoc()):
        echo '
        <tr>
        <td>'.$sonuc["ad"].'</td>
        <td><a href="control.php?islem=masaguncel&masaid='.$sonuc["id"].'" class="btn btn-warning">Güncelle</a></td>
        <td><a href="control.php?islem=masasil&masaid='.$sonuc["id"].'" class="btn btn-danger">Sil</a></td>
        </tr>
        ';
      endwhile;
      echo '</tbody>
    </table>';
    }
    // masa silme
  function masasil($vt){
      $masaid=$_GET["masaid"];
      if($masaid!="" && is_numeric($masaid)):
        $this->genelsorgu($vt,"delete from masalar where id=$masaid");
        $this->uyari("success","Masa Silindi","control.php?islem=masayon");
      else:
        $this->uyari("danger","Masa Silinmedi","control.php?islem=masayon");
      endif;
    }
    // masa güncelleme
  function masaguncel($vt){
    @$buton=$_POST["buton"];
    echo '<div class="col-md-3  text-center mx-auto mt-5 table-bordered">';
    if ($buton):
        @$masaad=htmlspecialchars($_POST["masaad"]);
        @$masaid=htmlspecialchars($_POST["masaid"]);
        if ($masaad=="" || $masaid==""):
          $this->uyari("danger","Bilgiler boş olamaz","control.php?islem=masayon");
        else:
          $this->genelsorgu($vt,"update masalar set ad='$masaad' where id=$masaid");
          $this->uyari("success","Güncelleme Başarılı","control.php?islem=masayon");
        endif;
    else:
      $masaid=$_GET["masaid"];
      $aktar=$this->genelsorgu($vt,"select * from masalar where id=$masaid")->fetch_assoc();
      echo '
        <form action="" method="post">
          <div class="col-md-12 table-light mt-2 border-bottom"><h4>Masa Güncelle</h4></div>
          <div class="col-md-12 table-light mt-2"><input type="text" name="masaad" class="form-control" value="'.$aktar["ad"].'"/></div>
          <div class="col-md-12 table-light mt-2"><input name="buton" type="submit" value="Güncelle" class="btn btn-success"</div>
          <input type="hidden" name="masaid" value="'.$aktar["id"].'"/>
        </form>
      ';
    endif;
    echo '</div>';

  }
  // masa ekleme
  function masaekle($vt){
    @$buton=$_POST["buton"];
    echo '<div class="col-md-3  text-center mx-auto mt-5 table-bordered">';
    if ($buton):
        @$masaad=htmlspecialchars($_POST["masaad"]);
        if ($masaad==""):
          $this->uyari("danger","Bilgiler boş olamaz","control.php?islem=masayon");
        else:
          $this->genelsorgu($vt,"insert into masalar (ad) VALUES('$masaad')");
          $this->uyari("success","Ekleme Başarılı","control.php?islem=masayon");
        endif;
    else:
      echo '
        <form action="" method="post">
          <div class="col-md-12 table-light mt-2 border-bottom"><h4>Masa Ekle</h4></div>
          <div class="col-md-12 table-light mt-2"><input type="text" name="masaad" class="form-control"/></div>
          <div class="col-md-12 table-light mt-2"><input name="buton" type="submit" value="Ekle" class="btn btn-success"</div>
        </form>
      ';
    endif;
    echo '</div>';

  }
//---------------------------------------------
//kategori genel
  function kategoriyon($vt){
      $so=$this->genelsorgu($vt,"select * from kategori");
      echo '<table class="table text-center table-striped table-bordered mx-auto col-md-6 mt-1">
        <thead>
          <tr>
            <th scope="col">Kategori Adı</th>
            <th scope="col"><a href="control.php?islem=katekle" class="btn btn-success">Kategori Ekle</a></th>
            <th scope="col">Sil</th>
          </tr>
        </thead>
        <tbody>';
      while($sonuc=$so->fetch_assoc()):
        echo '
        <tr>
        <td>'.$sonuc["ad"].'</td>
        <td><a href="control.php?islem=katguncel&katid='.$sonuc["id"].'" class="btn btn-warning">Güncelle</a></td>
        <td><a href="control.php?islem=katsil&katid='.$sonuc["id"].'" class="btn btn-danger">Sil</a></td>
        </tr>
        ';
      endwhile;
      echo '</tbody>
    </table>';
  }
   //kategori silme
  function katsil($vt){
        $katid=$_GET["katid"];
        if($katid!="" && is_numeric($katid)):
          $this->genelsorgu($vt,"delete from kategori where id=$katid");
          $this->uyari("success","Kategori Silindi","control.php?islem=katyon");
        else:
          $this->uyari("danger","Kategori Silinmedi","control.php?islem=katyon");
        endif;
      }
   //kategori Güncelleme
  function katguncel($vt){
        @$buton=$_POST["buton"];
        echo '<div class="col-md-3  text-center mx-auto mt-5 table-bordered">';
        if ($buton):
            @$katad=htmlspecialchars($_POST["katad"]);
            @$katid=htmlspecialchars($_POST["katid"]);
            @$durum=htmlspecialchars($_POST["durum"]);
            if ($katad=="" || $katid=="" || $durum==""):
              $this->uyari("danger","Bilgiler boş olamaz","control.php?islem=katyon");
            else:
              $this->genelsorgu($vt,"update kategori set ad='$katad',durum=$durum where id=$katid");
              $this->uyari("success","Güncelleme Başarılı","control.php?islem=katyon");
            endif;
        else:
          $katid=$_GET["katid"];
          $aktar=$this->genelsorgu($vt,"select * from kategori where id=$katid")->fetch_assoc();
          echo '
            <form action="" method="post">
              <div class="col-md-12 table-light mt-2 border-bottom"><h4>Kategori Güncelle</h4></div>
              <div class="col-md-12 table-light mt-2"><input type="text" name="katad" class="form-control" value="'.$aktar["ad"].'"/></div>
              <div class="col-md-12 table-light mt-2">
              <select name="durum" class="form-control mt-3">';
              if($aktar["durum"]==0):
                echo '<option value="0" selected="selected">MUTFAK</option>
                <option value="1">BAR</option>';
              else:
                echo '<option value="1" selected="selected">BAR</option>
                <option value="0">MUTFAK</option>';
              endif;
              echo '</select>
              </div>
              <div class="col-md-12 table-light mt-2"><input name="buton" type="submit" value="Güncelle" class="btn btn-success"</div>
              <input type="hidden" name="katid" value="'.$aktar["id"].'"/>
            </form>
          ';
        endif;
        echo '</div>';

      }
       //kategori ekleme
  function katekle($vt){
        @$buton=$_POST["buton"];
        echo '<div class="col-md-3  text-center mx-auto mt-5 table-bordered">';
        if ($buton):
            @$katad=htmlspecialchars($_POST["katad"]);
              @$durum=htmlspecialchars($_POST["durum"]);
            if ($katad=="" || $durum==""):
              $this->uyari("danger","Bilgiler boş olamaz","control.php?islem=katyon");
            else:
              $this->genelsorgu($vt,"insert into kategori (ad,durum) VALUES('$katad',$durum)");
              $this->uyari("success","Ekleme Başarılı","control.php?islem=katyon");
            endif;
        else:
          ?>
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
              <?php
              echo '  <div class="col-md-12 table-light mt-2 border-bottom"><h4>Kategori Ekle</h4></div>
              <div class="col-md-12 table-light mt-2"><input type="text" name="katad" class="form-control mt-3" placeholder="Kategori Adı"/></div>
              <div class="col-md-12">
              <select name="durum" class="form-control mt-3">
              <option value="0">MUTFAK</option>
              <option value="1">BAR</option>
              </select>
              </div>
              <div class="col-md-12 table-light mt-2"><input name="buton" type="submit" value="Ekle" class="btn btn-success"</div>
            </form>
          ';
        endif;
        echo '</div>';

      }
//-----------------------------------------------
//---------------------------------------------
//garson genel
  function garsonyon($vt){
      $so=$this->genelsorgu($vt,"select * from garson");
      echo '<table class="table text-center table-striped table-bordered mx-auto col-md-6 mt-1">
        <thead>
          <tr>
            <th scope="col">Garson Adı</th>
            <th scope="col"><a href="control.php?islem=garsonekle" class="btn btn-success">Garson Ekle</a></th>
            <th scope="col">Sil</th>
          </tr>
        </thead>
        <tbody>';
      while($sonuc=$so->fetch_assoc()):
        echo '
        <tr>
        <td>'.$sonuc["ad"].'</td>
        <td><a href="control.php?islem=garsonguncel&garsonid='.$sonuc["id"].'" class="btn btn-warning">Güncelle</a></td>
        <td><a href="control.php?islem=garsonsil&garsonid='.$sonuc["id"].'" class="btn btn-danger">Sil</a></td>
        </tr>
        ';
      endwhile;
      echo '</tbody>
    </table>';
  }
   //garson silme
  function garsonsil($vt){
        $garsonid=$_GET["garsonid"];
        if($garsonid!="" && is_numeric($garsonid)):
          $this->genelsorgu($vt,"delete from garson where id=$garsonid");
          $this->uyari("success","Garson Silindi","control.php?islem=garsonyon");
        else:
          $this->uyari("danger","Garson Silinmedi","control.php?islem=garsonyon");
        endif;
      }
   //garson Güncelleme
  function garsonguncel($vt){
        @$buton=$_POST["buton"];
        echo '<div class="col-md-3  text-center mx-auto mt-5 table-bordered">';
        if ($buton):
            @$garsonad=htmlspecialchars($_POST["garsonad"]);
            @$garsonsifre=htmlspecialchars($_POST["garsonsifre"]);
            @$garsonid=htmlspecialchars($_POST["garsonid"]);
            if ($garsonad=="" || $garsonsifre==""):
              $this->uyari("danger","Bilgiler boş olamaz","control.php?islem=garsonyon");
            else:
              $this->genelsorgu($vt,"update garson set ad='$garsonad', sifre='$garsonsifre' where id=$garsonid");
              $this->uyari("success","Güncelleme Başarılı","control.php?islem=garsonyon");
            endif;
        else:
          $garsonid=$_GET["garsonid"];
          $aktar=$this->genelsorgu($vt,"select * from garson where id=$garsonid")->fetch_assoc();
          echo '
            <form action="" method="post">
              <div class="col-md-12 table-light mt-2 border-bottom"><h4>Garson Güncelle</h4></div>
              <div class="col-md-12 table-light mt-2">Garson Adı<input type="text" name="garsonad" class="form-control" value="'.$aktar["ad"].'"/></div>
              <div class="col-md-12 table-light mt-2">Şifresi<input type="text" name="garsonsifre" class="form-control" value="'.$aktar["sifre"].'"/></div>
              <div class="col-md-12 table-light mt-2"><input name="buton" type="submit" value="Güncelle" class="btn btn-success"</div>
              <input type="hidden" name="garsonid" value="'.$aktar["id"].'"/>
            </form>
          ';
        endif;
        echo '</div>';

      }
       //garson ekleme
  function Garsonekle($vt){
        @$buton=$_POST["buton"];
        echo '<div class="col-md-3  text-center mx-auto mt-5 table-bordered">';
        if ($buton):
            @$garsonad=htmlspecialchars($_POST["garsonad"]);
            @$garsonsifre=htmlspecialchars($_POST["garsonsifre"]);
            if ($garsonad=="" || $garsonsifre==""):
              $this->uyari("danger","Bilgiler boş olamaz","control.php?islem=garsonyon");
            else:
              $this->genelsorgu($vt,"insert into garson (ad,sifre) VALUES('$garsonad','$garsonsifre')");
              $this->uyari("success","Ekleme Başarılı","control.php?islem=garsonyon");
            endif;
        else:
          ?>
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
              <?php
              echo '  <div class="col-md-12 table-light mt-2 border-bottom"><h4>Garson Ekle</h4></div>
              <div class="col-md-12 table-light mt-2"><input type="text" name="garsonad" class="form-control" placeholder="Garson Adı"/></div>
              <div class="col-md-12 table-light mt-2"><input type="password" name="garsonsifre" class="form-control" placeholder="Garson Şifre"/></div>
              <div class="col-md-12 table-light mt-2"><input name="buton" type="submit" value="Ekle" class="btn btn-success"</div>
            </form>
          ';
        endif;
        echo '</div>';

      }
//---------------------------------------------------
#####################################################
//------------------------------------------------------
// yönetici giriş kontrolleri
  public function giriskont($r,$k,$s){
    $sonhal=md5(sha1(md5($s)));
    $sorgu="select * from yonetim where kulad='$k' and sifre='$sonhal'";
    $sor=$r->prepare($sorgu);
    $sor->execute();
    $sonbilgi=$sor->get_result();
    $veri=$sonbilgi->fetch_assoc();
    if($sonbilgi->num_rows==0):
    $this->uyari("danger","Bilgiler Hatalı","index.php");
    else:
      $sorgu="update yonetim set aktif=1 where kulad='$k' and sifre='$sonhal'";
      $sor=$r->prepare($sorgu);
      $sor->execute();
      $this->uyari("success","Giriş Yapılıyor","control.php");
      $kulson=md5(sha1(md5($k)));
      setcookie("kul",$kulson, time() + 60*60*24);
      setcookie("id",$veri["id"], time() + 60*60*24);
    endif;
  }
  //------------------------------------
    function kulad($db){
      $id=$_COOKIE["id"];
      $sorgu="select * from yonetim where id=$id";
      $gelensonuc=$this->genelsorgu($db,$sorgu);
      $b=$gelensonuc->fetch_assoc();
      return $b["kulad"];

    }
    function cikis ($r,$deger){
      $id=$_COOKIE["id"];
      $sorgu="update yonetim set aktif=0 where id=$id";
      $sor=$r->prepare($sorgu);
      $sor->execute();
      $deger=md5(sha1(md5($deger)));
      setcookie("kul",$deger, time() - 10);
      setcookie("id",$id, time() - 10);
      $this->uyari("success","Çıkış Yapılıyor","index.php");
    }
  //-------------------------------------
  // sifre değiştirme
  function sifredegis($vt){
        @$buton=$_POST["buton"];
        echo '<div class="col-md-3  text-center mx-auto mt-5 table-bordered">';
        if ($buton):
            @$eskisif=htmlspecialchars($_POST["eskisif"]);
            @$yen1=htmlspecialchars($_POST["yen1"]);
            @$yen2=htmlspecialchars($_POST["yen2"]);
            if ($eskisif=="" || $yen1=="" || $yen2==""):
              $this->uyari("danger","Bilgiler boş olamaz","control.php?islem=sifdeg");
            else:
              $eskisifson=md5(sha1(md5($eskisif)));

              if(  $this->genelsorgu($vt,"select * from yonetim where sifre='$eskisifson'")->num_rows==0):
                $this->uyari("danger","Eski Şİfre Hatalı","control.php?islem=sifdeg");
              elseif($yen1 !=$yen2):
                $this->uyari("danger","Şifreler Eşleşmiyor","control.php?islem=sifdeg");
              else:
                $yenisifre=md5(sha1(md5($yen1)));
                $id=$_COOKIE["id"];
                $this->genelsorgu($vt,"update yonetim set sifre='$yenisifre' where id=$id");
                $this->uyari("success","Şİfre Güncellendi","control.php?islem=sifdeg");
              endif;
            endif;
        else:
          ?>
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
              <?php
              echo '  <div class="col-md-12 table-light mt-2 border-bottom"><h4>Şifre Değiştir Ekle</h4></div>
              <div class="col-md-12 table-light mt-2"><input type="password" name="eskisif" class="form-control" placeholder="Eski Şİfre"/></div>
              <div class="col-md-12 table-light mt-2"><input type="password" name="yen1" class="form-control" placeholder="Yeni Şİfre"/></div>
                <div class="col-md-12 table-light mt-2"><input type="password" name="yen2" class="form-control" placeholder="Yeni Şİfre Tekrar"/></div>
              <div class="col-md-12 table-light mt-2"><input name="buton" type="submit" value="Değiştir" class="btn btn-success"</div>
            </form>
          ';
        endif;
        echo '</div>';

      }
  // cookie işlemleri
  public function cookcon($d,$durum=false){
    if (isset($_COOKIE["kul"],$_COOKIE["id"])):
      $deger=$_COOKIE["kul"];
      $id=$_COOKIE["id"];
      $sorgu="select * from yonetim where id=$id";
      $sor=$d->prepare($sorgu);
      $sor->execute();
      $sonbilgi=$sor->get_result();
      $veri=$sonbilgi->fetch_assoc();
      $sonhal=md5(sha1(md5($veri["kulad"])));
      if($sonhal != $_COOKIE["kul"]):
        setcookie("kul",$deger, time() - 10);
        header("location:index.php");
      else:
        if ($durum==true): header("location:control.php"); endif;
      endif;
      else :
        if ($durum==false): header("location:index.php"); endif;
    endif;
  }
  //yönetici genel
    function yoneticiayar($vt){
        $so=$this->genelsorgu($vt,"select * from yonetim");
        echo '<table class="table text-center table-striped table-bordered mx-auto col-md-6 mt-1">
          <thead>
            <tr>
              <th scope="col">Yönetici Adı</th>
              <th scope="col"><a href="control.php?islem=yonekle" class="btn btn-success">Yönetici Ekle</a></th>
              <th scope="col">Sil</th>
            </tr>
          </thead>
          <tbody>';
        while($sonuc=$so->fetch_assoc()):
          echo '
          <tr>
          <td>'.$sonuc["kulad"].'</td>
          <td><a href="control.php?islem=yonguncel&yonid='.$sonuc["id"].'" class="btn btn-warning ">Güncelle</a></td>';
          $sonuc["yetki"]==1 ? $durum="disabled" : $durum="";
          echo '<td><a href="control.php?islem=yonsil&yonid='.$sonuc["id"].'" class="btn btn-danger '.$durum.'">Sil</a></td>
          </tr>
          ';
        endwhile;
        echo '</tbody>
      </table>';
    }
     //yönetici silme
    function yoneticisil($vt){
          $yonid=$_GET["yonid"];
          if($yonid!="" && is_numeric($yonid)):
            $this->genelsorgu($vt,"delete from yonetim where id=$yonid");
            $this->uyari("success","Yönetici Silindi","control.php?islem=yonayar");
          else:
            $this->uyari("danger","Yönetici Silinmedi","control.php?islem=yonayar");
          endif;
        }
     //yönetici Güncelleme
    function yoneticiguncel($vt){
          @$buton=$_POST["buton"];
          echo '<div class="col-md-3  text-center mx-auto mt-5 table-bordered">';
          if ($buton):
              @$yonad=htmlspecialchars($_POST["yonad"]);
              @$yonid=htmlspecialchars($_POST["yonid"]);
              if ($yonad=="" || $yonid==""):
                $this->uyari("danger","Bilgiler boş olamaz","control.php?islem=yonayar");
              else:
                $this->genelsorgu($vt,"update yonetim set kulad='$yonad'  where id=$yonid");
                $this->uyari("success","Güncelleme Başarılı","control.php?islem=yonayar");
              endif;
          else:
            $yonid=$_GET["yonid"];
            $aktar=$this->genelsorgu($vt,"select * from yonetim where id=$yonid")->fetch_assoc();
            echo '
              <form action="" method="post">
                <div class="col-md-12 table-light mt-2 border-bottom"><h4>Yönetici Güncelle</h4></div>
                <div class="col-md-12 table-light mt-2">Yönetici Adı<input type="text" name="yonad" class="form-control" value="'.$aktar["kulad"].'"/></div>
                <div class="col-md-12 table-light mt-2"><input name="buton" type="submit" value="Güncelle" class="btn btn-success"</div>
                <input type="hidden" name="yonid" value="'.$yonid.'"/>
              </form>
            ';
          endif;
          echo '</div>';

        }
         //yönetici ekleme
    function yoneticiekle($vt){
          @$buton=$_POST["buton"];
          echo '<div class="col-md-3  text-center mx-auto mt-5 table-bordered">';
          if ($buton):
              @$yonad=htmlspecialchars($_POST["yonad"]);
              @$yonsifre=htmlspecialchars($_POST["yonsifre"]);
              $yonsifre=md5(sha1(md5($yonsifre)));
              if ($yonad=="" || $yonsifre==""):
                $this->uyari("danger","Bilgiler boş olamaz","control.php?islem=yonayar");
              else:
                $this->genelsorgu($vt,"insert into yonetim (kulad,sifre) VALUES('$yonad','$yonsifre')");
                $this->uyari("success","Ekleme Başarılı","control.php?islem=yonayar");
              endif;
          else:
            ?>
              <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                <?php
                echo '  <div class="col-md-12 table-light mt-2 border-bottom"><h4>Yönetici Ekle</h4></div>
                <div class="col-md-12 table-light mt-2"><input type="text" name="yonad" class="form-control" placeholder="Yönetici Adı"/></div>
                <div class="col-md-12 table-light mt-2"><input type="password" name="yonsifre" class="form-control" placeholder="Yönetici Şifresi"/></div>
                <div class="col-md-12 table-light mt-2"><input name="buton" type="submit" value="Ekle" class="btn btn-success"</div>
              </form>
            ';
          endif;
          echo '</div>';

        }
  //-----------------------------------------------
  //---------------------------------------------
  //-----------------------------------------------------------------------
  //----------RAPORLAMA MODÜLÜ--------------------------
  function rapor($vt){

    @$tercih=$_GET["tar"];
    switch ($tercih):
      case "bugun":
      $this->genelsorgu($vt,"Truncate gecicimasa");
      $this->genelsorgu($vt,"Truncate geciciurun");
      $veri=$this->genelsorgu($vt,"select * from rapor where tarih=CURDATE()");
      $veri2=$this->genelsorgu($vt,"select * from rapor where tarih=CURDATE()");
      break;
      case "dun":
      $this->genelsorgu($vt,"Truncate gecicimasa");
      $this->genelsorgu($vt,"Truncate geciciurun");
      $veri=$this->genelsorgu($vt,"select * from rapor where tarih= DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
      $veri2=$this->genelsorgu($vt,"select * from rapor where tarih= DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
      break;
      case "hafta":
      $this->genelsorgu($vt,"Truncate gecicimasa");
      $this->genelsorgu($vt,"Truncate geciciurun");
      $veri=$this->genelsorgu($vt,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
      $veri2=$this->genelsorgu($vt,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
      break;
      case "ay":
      $this->genelsorgu($vt,"Truncate gecicimasa");
      $this->genelsorgu($vt,"Truncate geciciurun");
      $veri=$this->genelsorgu($vt,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
      $veri2=$this->genelsorgu($vt,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
      break;
      case "tum":
      $this->genelsorgu($vt,"Truncate gecicimasa");
      $this->genelsorgu($vt,"Truncate geciciurun");
      $veri=$this->genelsorgu($vt,"select * from rapor");
      $veri2=$this->genelsorgu($vt,"select * from rapor");
      break;
      case "tarih":
      $this->genelsorgu($vt,"Truncate gecicimasa");
      $this->genelsorgu($vt,"Truncate geciciurun");
      $tarih1=$_POST["tarih1"];
      $tarih2=$_POST["tarih2"];
      echo '<div class="alert alert-info text-center mx-auto mt-4">
      '.$tarih1. ' - ' .$tarih2. '
        ..TARİHLERİ</div>';
      $veri=$this->genelsorgu($vt,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
      $veri2=$this->genelsorgu($vt,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
      break;
      default;
      $this->genelsorgu($vt,"Truncate gecicimasa");
      $this->genelsorgu($vt,"Truncate geciciurun");
      $veri=$this->genelsorgu($vt,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
      $veri2=$this->genelsorgu($vt,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
    endswitch;
    echo '          <table class="table text-center table-light table-bordered  mx-auto mt-4 col-md-8">
              <thead>
                <tr>
                  <th ><a href="control.php?islem=raporyon&tar=bugun">Bugün</a></th>
                  <th ><a href="control.php?islem=raporyon&tar=dun">Dün</a></th>
                  <th ><a href="control.php?islem=raporyon&tar=hafta">Bu Hafta</a></th>
                  <th ><a href="control.php?islem=raporyon&tar=ay">Bu Ay</a></th>
                  <th ><a href="control.php?islem=raporyon&tar=tum">Tüm Zamanlar</a></th>
                  <th colspan="2"><form action="control.php?islem=raporyon&tar=tarih" method="post">
                  <input type="date" name="tarih1" class="form-control col-md-10">
                  <input type="date" name="tarih2" class="form-control col-md-10">
                  </th>
                  <th >';
                  if (@$tarih1!="" || @$tarih2!=""):
                    echo '<p><a href="cikti.php?islem=ciktial&tar1='.$tarih1.'&tar2='.$tarih2.'" onclick="ortasayfa(this.href,\'mywindow\',\'900\',\'800\',\'yes\');return false">ÇIKTI AL</a></p>';

                  endif;
                  echo '<input name="buton" type="submit" class="btn btn-danger" value="LİSTELE VEYA YAZDIR" ></form></th>
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
                        $kilit=$this->genelsorgu($vt,"select * from gecicimasa");
                        if($kilit->num_rows==0):
                          while ($gel=$veri->fetch_assoc()):
                            $id=$gel["masaid"];
                            $masaveri=$this->genelsorgu($vt,"select * from masalar where id=$id")->fetch_assoc();
                            $masaad=$masaveri["ad"];
                            $raporbak=$this->genelsorgu($vt,"select * from gecicimasa where masaid=$id");
                            if($raporbak->num_rows==0):
                              $has=$gel["adet"] * $gel["urunfiyat"];
                              $adet=$gel["adet"];
                              $this->genelsorgu($vt,"insert into gecicimasa (masaid,masaad,hasilat,adet) VALUES($id,'$masaad',$has,$adet)");
                            else:
                              $raporson=$raporbak->fetch_assoc();
                              $gelenadet=$raporson["adet"];
                              $gelenhas=$raporson["hasilat"];
                              $sonhasilat=$gelenhas + ($gel["adet"] * $gel["urunfiyat"]);
                              $sonadet=$gelenadet + $gel["adet"];
                              $this->genelsorgu($vt,"update gecicimasa set hasilat=$sonhasilat, adet=$sonadet where masaid=$id");
                            endif;
                          endwhile;
                        endif;
                        $son=$this->genelsorgu($vt,"select * from gecicimasa order by hasilat desc;");
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
                        $kilit2=$this->genelsorgu($vt,"select * from geciciurun");
                        if($kilit2->num_rows==0):
                          while ($gel2=$veri2->fetch_assoc()):
                            $id=$gel2["urunid"];
                            $urunad=$gel2["urunad"];

                            $raporbak=$this->genelsorgu($vt,"select * from geciciurun where urunid=$id");
                            if($raporbak->num_rows==0):
                              $has=$gel2["adet"] * $gel2["urunfiyat"];
                              $adet=$gel2["adet"];
                              $this->genelsorgu($vt,"insert into geciciurun (urunid,urunad,hasilat,adet) VALUES($id,'$urunad',$has,$adet)");
                            else:
                              $raporson=$raporbak->fetch_assoc();
                              $gelenadet=$raporson["adet"];
                              $gelenhas=$raporson["hasilat"];
                              $sonhasilat=$gelenhas + ($gel2["adet"] * $gel2["urunfiyat"]);
                              $sonadet=$gelenadet + $gel2["adet"];
                              $this->genelsorgu($vt,"update geciciurun set hasilat=$sonhasilat, adet=$sonadet where urunid=$id");
                            endif;
                          endwhile;
                        endif;
                        $son2=$this->genelsorgu($vt,"select * from geciciurun order by hasilat desc;");
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
  }
}
 ?>
