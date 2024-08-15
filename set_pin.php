<!DOCTYPE html>
<html>
<?php
include "configuration/config_include.php";
etc();encryption();session();connect();head();body();timing();
//alltotal();
pagination();
?>

<?php
if (!login_check()) {
?>
<meta http-equiv="refresh" content="0; url=logout" />
<?php
exit(0);
}
?>
        <div class="wrapper">
<?php
theader();
menu();
?>


<!-- SETTING START-->

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "configuration/config_chmod.php";
$halaman = "set_pin"; // halaman
$dataapa = "PIN"; // data
$tabeldatabase = "pin"; // tabel database
$chmod = $chmenu10; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];
$insert = $_POST['insert'];

function autoNumber(){
  include "configuration/config_connect.php";
  global $forward;
  $query = "SELECT MAX(RIGHT(kode, 4)) as max_id FROM $forward ORDER BY kode";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result);
  $id_max = $data['max_id'];
  $sort_num = (int) substr($id_max, 1, 4);
  $sort_num++;
  $new_code = sprintf("%04s", $sort_num);
  return $new_code;
  }
?>


<!-- SETTING STOP -->

            <div class="content-wrapper">
                <section class="content-header">
</section>
                <!-- Main content -->
                <section class="content">

                  <div class="row">
<div class="col-lg-12">

  <!-- BREADCRUMB -->

  <ol class="breadcrumb ">
  <li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard </a></li>
  <li><a href="<?php echo $halaman;?>"><?php echo $dataapa ?></a></li>
  <?php

  if ($search != null || $search != "") {
  ?>
   <li> <a href="<?php echo $halaman;?>">Data <?php echo $dataapa ?></a></li>
    <li class="active"><?php
      echo $search;
  ?></li>
    <?php
  } else {
  ?>
   <li class="active">Data <?php echo $dataapa ?></li>
    <?php
  }
  ?>
  </ol>

  <!-- BREADCRUMB -->
</div>
                  </div>
                    <div class="row">
            <div class="col-lg-6">
                        <!-- ./col -->



<!-- BOX INSERT BERHASIL -->

         <script>
 window.setTimeout(function() {
    $("#myAlert").fadeTo(500, 0).slideUp(1000, function(){
        $(this).remove();
    });
}, 5000);
</script>


       <!-- BOX INFORMASI -->
    <?php
if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') {
  ?>

    <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));


   

         $sql="select * from pin ";
                  $hasil2 = mysqli_query($conn,$sql);


                  $fill = mysqli_fetch_assoc($hasil2);
         
          $ubah = $fill["ubah"];

    ?>


  <!-- KONTEN BODY AWAL -->
                            <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Data <?php echo $dataapa;?></h3> | Jumlah perubahan PIN: <?php echo $ubah;?>x
            </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                <div class="table-responsive">
    <!----------------KONTEN------------------->
    
  <div id="main">
   <div class="container-fluid">

          <form class="form-horizontal" method="post" action="<?php echo $halaman; ?>" id="Myform">
              <div class="box-body">

                <div class="row">
                        <div class="form-group col-md-6 col-xs-12" >
                          <label for="kode" class="col-sm-4 control-label">PIN Lama:</label>
                          <div class="col-sm-8">
                           
                     <input type="password" class="form-control" id="password" name="password"  maxlength="6" required >
                      <input type="checkbox" onclick="myFunction()">tampilkan
                 
                  </div>
                        </div>
                </div>

                <input type="hidden" value="<?php echo $ubah;?>" name="ubah">

        <div class="row">
           <div class="form-group col-md-6 col-xs-12" >
                  <label for="nama" class="col-sm-4 control-label">PIN BARU:</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control" id="pin" name="pin" placeholder="Masukan PIN baru" maxlength="6" required="">
                    <input type="checkbox" onclick="myFunction2()">tampilkan
                  </div>
                </div>
        </div>

         <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class=" control-label">PIN Dipakai ketika anda lupa password atau tidak bisa login menggunakan akun Admin</label>
                  
                  
                </div>
        </div>


              </div>
              <!-- /.box-body -->
              <div class="box-footer" >
                <button type="submit" class="btn btn-default pull-left btn-flat" name="simpan" onclick="document.getElementById('Myform').submit();" ><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</button>
                &nbsp;&nbsp;&nbsp;PIN STANDARD: 123456
              </div>
              <!-- /.box-footer -->


 </form>
</div>
<?php

      if(isset($_POST['simpan'])){
   if($_SERVER["REQUEST_METHOD"] == "POST"){




    

          $oldpin = mysqli_real_escape_string($conn, $_POST["password"]);
          
          $pin = mysqli_real_escape_string($conn, $_POST["pin"]);
         
           $ubah = mysqli_real_escape_string($conn, $_POST["ubah"]);

           $ch = $ubah + 1;
          
if ( (strlen($pin)!=6) && (!is_numeric($pin)) ){
echo "<script type='text/javascript'>  alert('PIN harus 6 Digit Angka!'); </script>";

} else {
            $oldpina= sha1(MD5($oldpin));
             $pina=sha1(MD5($pin));

             $sql="select * from pin where pin='$oldpina'";
        $result=mysqli_query($conn,$sql);
          if(mysqli_num_rows($result)>0){
              $sql ="UPDATE pin SET pin='$pina', ubah='$ch' WHERE pin='$oldpina' ";
              $up =mysqli_query($conn, $sql);
              echo "<script type='text/javascript'>  alert('Berhasil, Data PIN diganti!'); </script>";
                  echo "<script type='text/javascript'>window.location = 'set_pin';</script>";
          } else {
                  echo "<script type='text/javascript'>  alert('GAGAL, PIN yang anda masukan Salah!'); </script>";

          }

}
             
} }

         ?>

<script>
function myFunction() {
    document.getElementById("Myform").submit();
}
</script>



  <script>
function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>


  <script>
function myFunction2() {
  var x = document.getElementById("pin");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>


    <!-- KONTEN BODY AKHIR -->

                                </div>
                </div>

                                <!-- /.box-body -->
                            </div>
                        </div>

<?php
} else {
?>
   <div class="callout callout-danger">
    <h4>Info</h4>
    <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa;?> ini .</b>
    </div>
    <?php
}
?>

                        <!-- ./col -->
                    </div>

                    
                           <!-- /.box-body -->
                       </div>
                    </div>

                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <!-- /.Left col -->
                    </div>
                    <!-- /.row (main row) -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php  footer(); ?>
            <div class="control-sidebar-bg"></div>
        </div>
          <!-- ./wrapper -->
<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
        <script src="dist/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="dist/plugins/morris/morris.min.js"></script>
        <script src="dist/plugins/sparkline/jquery.sparkline.min.js"></script>
        <script src="dist/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="dist/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <script src="dist/plugins/knob/jquery.knob.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="dist/plugins/daterangepicker/daterangepicker.js"></script>
        <script src="dist/plugins/datepicker/bootstrap-datepicker.js"></script>
        <script src="dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="dist/plugins/fastclick/fastclick.js"></script>
        <script src="dist/js/app.min.js"></script>
        <script src="dist/js/demo.js"></script>
    <script src="dist/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="dist/plugins/fastclick/fastclick.js"></script>
    <script src="dist/plugins/select2/select2.full.min.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script src="dist/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="dist/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("yyyy-mm-dd", {"placeholder": "yyyy/mm/dd"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("yyyy-mm-dd", {"placeholder": "yyyy/mm/dd"});
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'YYYY/MM/DD h:mm A'});
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Hari Ini': [moment(), moment()],
            'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Akhir 7 Hari': [moment().subtract(6, 'days'), moment()],
            'Akhir 30 Hari': [moment().subtract(29, 'days'), moment()],
            'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
            'Akhir Bulan': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

   $('.datepicker').datepicker({
    dateFormat: 'yyyy-mm-dd'
 });

   //Date picker 2
   $('#datepicker2').datepicker('update', new Date());

    $('#datepicker2').datepicker({
      autoclose: true
    });

   $('.datepicker2').datepicker({
    dateFormat: 'yyyy-mm-dd'
 });


    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
</script>
</body>
</html>
