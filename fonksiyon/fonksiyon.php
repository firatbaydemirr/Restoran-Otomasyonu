<?php
$db = new mysqli("localhost","root","","siparis")or die("Bağlantı kurulamadı!");
class sistem {
  private function benimsorgum($vt,$sorgu,$tercih){
    $a=$sorgu;
    $b=$vt->prepare($a);
    $b->execute();
    if ($tercih==1):
    return $c=$b->get_result();
  endif;
  }
 function benimsorgum2($vt,$sorgu,$tercih){
    $a=$sorgu;
    $b=$vt->prepare($a);
    $b->execute();
    if ($tercih==1):
    return $c=$b->get_result();
  endif;
  }
  function masacek($dv) {

    $masalar="select * from masalar";
    $sonuc=$this->benimsorgum($dv,$masalar,1);
    $bos=0;
    $dolu=0;
    while ($masason=$sonuc->fetch_assoc()):
    $siparisler='select * from anliksiparis where masaid='.$masason["id"].'';
    $this->benimsorgum($dv,$siparisler,1)->num_rows==0 ? $renk="success" : $renk="dark";
    $this->benimsorgum($dv,$siparisler,1)->num_rows==0 ? $bos++ : $dolu++;
      echo '<div id="mas" class="col-md-3 col-sm-6 mx-auto p-1 text-center  text-white">
      <a  href="masadetay.php?masaid='.$masason["id"].'">
      <div class="bg-'.$renk.'" id="masa">'.$masason["ad"].'</div></a>
      </div>';
  endwhile;
  $dol="update doluluk set bos=$bos, dolu=$dolu where id=1";
  $dolson=$dv->prepare($dol);
  $dolson->execute();
  }
  function doluluk($dv){
    $son=$this->benimsorgum($dv,"select * from doluluk",1);
    $veriler=$son->fetch_assoc();
    $toplam= $veriler["bos"] + $veriler["dolu"];
    $oran= ($veriler["dolu"] / $toplam) * 100 ;
    echo "% " .$oran=substr($oran,0,5);
  }
  //MASA TOPLAM SAYI
  function masatoplam($dv){
    echo $this->benimsorgum($dv,"select * from masalar",1)->num_rows;
  }
  //SİPARİS TOPLAM
  function siparistoplam($dv){
    echo $this->benimsorgum($dv,"select * from anliksiparis",1)->num_rows;
  }
// MASA DETAY FONKSİYONU
  function masagetir($vt,$id){
    $get="select * from masalar where id=$id";
    return $this->benimsorgum($vt,$get,1);
  }

  function urunkategori($db){

    $se="select * from kategori";
    $gelen=$this->benimsorgum($db,$se,1);
    while($son=$gelen->fetch_assoc()):
      echo '<a class="btn btn-secondary text-white" sectionId="'.$son["id"].'">'.$son["ad"].'</a><br><br>';

    endwhile;
  }
  function garsonbak($db) {
  $gelen=$this->benimsorgum($db,"select * from garson where durum=1",1)->fetch_assoc();
  if ($gelen["ad"]!="") :
  echo $gelen["ad"];
  echo '<a href="islemler.php?islem=cikis" class="m-3"><kbd class="bg-danger">ÇIK</kbd></a>';
  else:
  echo "Garson Yok";
  endif;
  }
  private function genelsorgu($dv, $sorgu) {
       $sorgum = $dv->prepare($sorgu);
       $sorgum->execute();
       return $sorguson = $sorgum->get_result();
   }
  function mutfakbilgi($db){
    $siparisler=$this->genelsorgu($db,"select * from mutfaksiparis");
    $idkontrol=array();
    while($geldiler=$siparisler->fetch_assoc()):
      $masaid=$geldiler["masaid"];
      if(!in_array($masaid,$idkontrol)):
        $idkontrol[]=$masaid;
      $siparisler2=$this->genelsorgu($db,"select * from mutfaksiparis where masaid=$masaid ");
      $masaad=$this->genelsorgu($db,"select * from masalar where id=$masaid");
      $masabilgi=$masaad->fetch_assoc();
      echo '<div class="col-md-3">
      <div class="card mt-1" style="width:25rem;">
      <div class="card-body">
      <h5 class="card-title text-center text-danger bg-light">'.$masabilgi["ad"].'</h5>
      <p class="card-text">
      <div class="row text-center">
      ';
      while($geldiler2=$siparisler2->fetch_assoc()):
        echo '
        <div class="col-md-6 mt-2 border-bottom">'.$geldiler2["urunad"].'<span class="text-danger"><br>'; $this->dakikakontrolet($geldiler2["saat"],$geldiler2["dakika"]); echo'</span> DK ÖNCE</div>
        <div class="col-md-3 mt-2 border-bottom">'.$geldiler2["adet"].' ADET</div>
        <div class="col-md-3 mt-2 border-bottom" id="hazirlink" ><a sectionId="'.$geldiler2["urunid"].'" sectionId2="'.$geldiler2["masaid"].'" class="btn btn-success float-right btn-sm p-1">HAZIR</a></div>
        ';
      endwhile;
    echo '</div>
    </p></div></div></div>';
    endif;
    endwhile;
  }
  function barbilgi($db){
    $siparisler=$this->genelsorgu($db,"select * from barsiparis");
    $idkontrol=array();
    while($geldiler=$siparisler->fetch_assoc()):
      $masaid=$geldiler["masaid"];
      if(!in_array($masaid,$idkontrol)):
        $idkontrol[]=$masaid;
      $siparisler2=$this->genelsorgu($db,"select * from barsiparis where masaid=$masaid");
      $masaad=$this->genelsorgu($db,"select * from masalar where id=$masaid");
      $masabilgi=$masaad->fetch_assoc();
      echo '<div class="col-md-3">
      <div class="card mt-1" style="width:25rem;">
      <div class="card-body">
      <h5 class="card-title text-center text-danger bg-light">'.$masabilgi["ad"].'</h5>
      <p class="card-text">
      <div class="row text-center">
      ';
      while($geldiler2=$siparisler2->fetch_assoc()):
        echo '
        <div class="col-md-6 mt-2 border-bottom">'.$geldiler2["urunad"].'<span class="text-danger"><br>'; $this->dakikakontrolet($geldiler2["saat"],$geldiler2["dakika"]); echo'</span> DK ÖNCE</div>
        <div class="col-md-3 mt-2 border-bottom">'.$geldiler2["adet"].' ADET</div>
        <div class="col-md-3 mt-2 border-bottom" id="hazirlink" ><a sectionId="'.$geldiler2["urunid"].'" sectionId2="'.$geldiler2["masaid"].'" class="btn btn-success float-right btn-sm p-1">HAZIR</a></div>
        ';
      endwhile;
    echo '</div>
    </p></div></div></div>';
    endif;
    endwhile;
  }
  function dakikakontrolet($saat, $dakika) {
        if ($saat != 0 && $dakika != 0) :
            if ($saat < date("H")) :
                $deger = (60 + date("i")) - $dakika;
                echo $deger;
            else:
                $deger = date("i") - $dakika;
                echo $deger;
            endif;
        endif;
    }
}

 ?>
