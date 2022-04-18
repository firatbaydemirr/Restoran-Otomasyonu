<?php include("fonksiyon/fonksiyon.php"); $sistem = new sistem;
$veri=$sistem->benimsorgum2($db,"select * from garson where durum=1",1)->num_rows;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <script src="dosya/jquery.js"></script>
  <link rel="stylesheet" href="dosya/boostrap.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <title> Restaurant Sipariş sistemi</title>
  <style>
  #rows{
    height: 50px;
    border-radius: 8px;

  }
  #masa {
    height: 80px;
    margin: 25px;
    font-size: 50px;
    border-radius: 25px;
  }
  #mas a:link, #mas a:visited {

  	color:white;

  	text-decoration:none;

  }

  </style>
  <script>
  $(document).ready(function(){
    var deger= "<?php echo $veri; ?>";
    if (deger==0) {
  	$('#girismodal').modal({
  		backdrop: 'static',
  		keyboard: false
  	})
  	$('body').on('hidden.bs.modal','.modal', function() {
  		$(this).removeData('bs.modal');
  	});
  	}
  	else {
  	$('#girismodal').modal('hide');
  	}
    $('#girisbak').click(function(){
      $.ajax({
        type: "POST",
        url: 'islemler.php?islem=kontrol',
        data :$('#garsonform').serialize(),
        success: function(donen_veri)
        {
            $('#garsonform').trigger("reset");
            $('.modalcevap').html(donen_veri);
        },
      })
    })
  });
  </script>
</head>
<body>
  <div class="container-fluid">
    <div class="row table-dark" id="rows">

      <div class="col-md-2 border-right">Toplam Sipariş : <a class="text-warning"><?php $sistem->siparistoplam($db); ?></a></div>
      <div class="col-md-2 border-right">Doluluk Oranı : <a class="text-warning"><?php $sistem->doluluk($db); ?></a></div>
      <div class="col-md-2 border-right">Toplam Masa : <a class="text-warning"><?php $sistem->masatoplam($db); ?></a></div>
      <div class="col-md-3 border-right">Aktif Garson : <a class="text-warning"><?php $sistem->garsonbak($db); ?></a></div>
      <div class="col-md-3 border-right">Tarih : <a class="text-warning"><?php echo date('d.m.Y'); ?></a></div>
    </div>
    <div class="row">
      <?php $sistem->masacek($db); ?>


    </div>
    <!-- The Modal -->
  <div class="modal fade" id="girismodal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header text-center">
          <h4 class="modal-title">Garson Girişi</h4>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
         <form id="garsonform">
         <div class="row mx-auto text-center">
         		<div class="col-md-12">Garson Ad</div>
        		 <div class="col-md-12"><select name="ad" class="form-control mt-2">
                  <option value="0">Seç</option>
                  <?php
				  $b=$sistem->benimsorgum2($db,"select * from garson",1);
				  while ($garsonlar=$b->fetch_assoc()) :
				  echo '<option value="'.$garsonlar["ad"].'">'.$garsonlar["ad"].'</option>';
				  endwhile;
				  ?>
                </select></div>
        		 <div class="col-md-12">Şifre </div>
                <div class="col-md-12">
                <input name="sifre" type="password" class="form-control  mt-2" />
                </div>
                <div class="col-md-12">
               <input type="button" id="girisbak" value="GİR" class="btn btn-info mt-4"/>
                </div>
         </div>
         </form>
        </div>
         <div class="modalcevap">
        </div>
      </div>
    </div>
  </div>

  </div>

</body>
</html>
