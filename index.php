<!DOCTYPE html>
<html>
<?php
include "configuration/config_include.php";
include "configuration/config_alltotal.php";
include "configuration/config_connect.php";
encryption();
session();
connect();
head();
body();
timing();
//pagination();
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <!-- ./col -->

        <!-- SETTING START-->

        <?php
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $halaman = "index"; // halaman
        $dataapa = "Dashboard"; // data
        $tabeldatabase = "index"; // tabel database
        $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
        $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
        $search = $_POST['search'];
        ?>

        <!-- SETTING STOP -->


        <!-- BREADCRUMB -->
        <div class="col-lg-12">
          <ol class="breadcrumb ">
            <li><a href="#">Dashboard</a></li>
          </ol>
        </div>

        <!-- BREADCRUMB -->




        <!-- /.box-body -->

        <!-- ./col -->

      </div>

      <?php if ($_SESSION['jabatan'] != 'admin') {
      } else { ?>
        <div class="row">

          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?php echo $datax1; ?></h3>
                <p>Karyawan</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="admin" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3><?php echo $datax2; ?></h3>
                <p>Transaksi Barang Masuk bulan ini</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="report_trxbeli" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3><?php echo $datax3; ?></h3>
                <p>Transaksi Barang Keluar bulan ini</p>
              </div>
              <div class="icon">
                <i class="glyphicon glyphicon-blackboard"></i>
              </div>
              <a href="report_trxjual" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?php echo $datax4; ?></h3>
                <p>Barang</p>
              </div>
              <div class="icon">
                <i class="glyphicon glyphicon-folder-close"></i>
              </div>
              <a href="barang" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>


        </div>

      <?php } ?>

      <!-- Awal Chart  -->

      <div class="row">

        <div class="col-lg-6 col-xs-12 col-sm 12 ">
          <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Data Stok Barang</h3>
            </div>
            <div class="box-body">
              <div style="overflow-y: auto; height:300px; ">
                <table class="table">
                  <thead>
                    <th>Barang</th>
        
                    <th>Stok</th>
                  </thead>
                  <tbody>
                    <?php
                    $barang = mysqli_query($conn, "SELECT nama,sisa,stokmin FROM barang WHERE sisa<stokmin order by sisa desc");

                    while ($row = mysqli_fetch_assoc($barang)) {
                      echo '<tr>';
                      echo '<td>' . $row['nama'] . '</td>';
                      echo '<td>' . $row['sisa'] . '</td>';
                     
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-xs-12 col-sm 12 ">
          <div class="box box-danger box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Barang Dibawah Stok Minimal</h3>
            </div>
            <div class="box-body">
              <div style="overflow-y: auto; height:300px; ">
                <table class="table">
                  <thead>
                    <th>Barang</th>
                    <th>Stok Minimal</th>
                    <th>Stok</th>
                  </thead>
                  <tbody>
                    <?php
                    $barang = mysqli_query($conn, "SELECT nama,sisa,stokmin FROM barang WHERE sisa<stokmin order by sisa desc");

                    while ($row = mysqli_fetch_assoc($barang)) {
                      echo '<tr>';
                      echo '<td>' . $row['nama'] . '</td>';
                      echo '<td>' . $row['stokmin'] . '</td>';
                      if ($row['sisa'] == 0) {
                        echo '<td style=background-color:#FF4040;>' . $row['sisa'] . '</td>';
                      }
                      if ($row['sisa'] > 0) {
                        echo '<td style=background-color:#E6A91D; color: white>' . $row['sisa'] . '</td>';
                      }

                      echo '</tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-xs-12 col-sm 12">
          <div class="box box-solid box-success">
            <?php




            $stok = mysqli_query($conn, "SELECT sisa FROM barang WHERE sisa>'0' order by kode asc");


            $barang1      = mysqli_query($conn, "SELECT nama FROM barang WHERE terjual>'0' order by terjual desc");
            $stok1 = mysqli_query($conn, "SELECT terjual FROM barang WHERE terjual>'0' order by terjual desc");
            ?>


            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
            <style type="text/css">

            </style>
            <script src="libs/chart.bundle.js"></script>



            <div class="chart-container">
              <canvas class="my-4 chartjs-render-monitor" id="myChart1" width="543" height="229" style="display: block; width: 543px; height: 229px;"></canvas>
              <center>
                <h2>Barang Keluar</h2>
              </center>
            </div>
            <script>
              var ctx = document.getElementById("myChart1");
              var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                  labels: [<?php while ($b = mysqli_fetch_array($barang1)) {
                              echo '"' . $b['nama'] . '",';
                            } ?>],
                  datasets: [{
                    label: '# stok',
                    data: [<?php while ($p = mysqli_fetch_array($stok1)) {
                              echo '"' . $p['terjual'] . '",';
                            } ?>],
                    backgroundColor: [
                      'rgba(255, 99, 132, 0.9)',
                      'rgba(54, 162, 235, 0.7)',
                      'rgba(255, 206, 86, 0.8)',
                      'rgba(75, 192, 192, 0.3)',
                      'rgba(153, 102, 255, 0.7)',
                      'rgba(255, 159, 64, 0.3)',
                      'rgba(255, 99, 132, 0.8)',
                      'rgba(54, 162, 235, 0.6)',
                      'rgba(255, 206, 86, 0.8)',
                      'rgba(75, 192, 192, 0.6)',
                      'rgba(153, 102, 255, 0.4)',
                      'rgba(255, 159, 64, 0.7)'
                    ],
                    borderColor: [
                      'rgba(255,99,132,1)',
                      'rgba(54, 162, 235, 1)',
                      'rgba(255, 206, 86, 1)',
                      'rgba(75, 192, 192, 1)',
                      'rgba(153, 102, 255, 1)',
                      'rgba(255, 159, 64, 1)',
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(255, 206, 86, 0.2)',
                      'rgba(75, 192, 192, 0.2)',
                      'rgba(153, 102, 255, 0.2)',
                      'rgba(255, 159, 64, 0.2)'
                    ],
                    borderWidth: 1
                  }]
                },
                options: {
                  scales: {


                  }
                }
              });
            </script>

          </div>
        </div>
      </div>

      <!-- akhir chart -->
      <div class="row">
        <?php if ($_SESSION['jabatan'] != 'admin') {
        } else { ?>
          <div class="col-lg-6">
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">Berita Informasi</h3>
              </div>
              <!-- /.box-header -->

              <div class="box-body">
                <div class="table-responsive">
                  <!----------------KONTEN------------------->
                  <?php
                  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

                  $nama = $avatar = $tanggal = $isi = "";
                  if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $nama = $_SESSION['nama'];
                    $avatar = $_SESSION['avatar'];
                    $tanggal = date('Y-m-d');
                    $isi = $_POST["isi"];
                  }

                  $sql = "select * from info";
                  $hasil2 = mysqli_query($conn, $sql);


                  while ($fill = mysqli_fetch_assoc($hasil2)) {

                    $nama = $fill["nama"];
                    $avatar = $fill["avatar"];
                    $tanggal = $fill["tanggal"];
                    $isi = $fill["isi"];
                  }
                  ?>
                  <div id="main">

                    <div class="container-fluid">


                      <form method="post">


                        <div class="form-group">
                          <textarea class="textarea" name="isi" placeholder="<?php echo $isi; ?>" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" value="<?php echo $ketentuane; ?>"></textarea>

                        </div>

                    </div>

                    <div class="col-sm-6">
                      <br />
                    </div>
                    <div class="col-sm-12" align="left">
                      <button type="submit" class="btn btn-default btn-flat" name="simpan"><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</button>
                      <br />
                    </div>




                    </form>
                  </div>
                  <?php
                  if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $id = 1;
                    $nama =  $_SESSION['nama'];
                    $avatar = $_SESSION['avatar'];
                    $tanggal = date('Y-m-d');
                    $isi = $_POST["isi"];

                    if (isset($_POST['simpan'])) {

                      $sql = "select * from info";
                      $result = mysqli_query($conn, $sql);

                      if (mysqli_num_rows($result) > 0) {

                        $sql1 = "update info set nama='$nama', avatar='$avatar',tanggal='$tanggal', isi='$isi' where id='1'";
                        $result = mysqli_query($conn, $sql1);
                      } else {
                        $sql1 = "insert into info values('$nama','$tanggal','$isi','$avatar','$id')";
                        $result = mysqli_query($conn, $sql1);
                      }
                    }
                  }


                  ?>



                  <!-- KONTEN BODY AKHIR -->

                </div>
              </div>

              <!-- TIMER -->
              <div id="counter" style="display: none;">3</div>
              <script type="text/javascript">
                function countdown() {
                  var i = document.getElementById('counter');
                  if (parseInt(i.innerHTML) <= 0) {
                    $('#loading').hide();
                    clearInterval(counter);
                    resetEverything();
                    recognition.stop();
                  }
                  i.innerHTML = parseInt(i.innerHTML) - 1;

                }
                setInterval(function() {
                  countdown();
                }, 1000);
              </script>
              <!-- /.TIMER -->
              <!-- /.box-body -->

              <div class="overlay" id="loading"> <i class="fa fa-refresh fa-spin"></i></div>

            </div>
          </div>

        <?php } ?>
        <?php if ($_SESSION['jabatan'] != 'admin') { ?>
          <div class="col-md-12">
            <?php
            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

            $nama = $avatar = $tanggal = $isi = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $nama = $_SESSION['nama'];
              $avatar = $_SESSION['avatar'];
              $tanggal = date('Y-m-d');
              $isi = $_POST["isi"];
            }

            $sql = "select * from info";
            $hasil2 = mysqli_query($conn, $sql);


            while ($fill = mysqli_fetch_assoc($hasil2)) {

              $nama = $fill["nama"];
              $avatar = $fill["avatar"];
              $tanggal = $fill["tanggal"];
              $isi = $fill["isi"];
            }
            ?>
          <?php
        } else { ?>
            <div class="col-md-6">

            <?php } ?>
            <!-- Box Comment -->
            <div class="box box-widget">
              <div class="box-header with-border">
                <div class="user-block">
                  <img class="img-circle" src="<?php echo $avatar; ?>" alt="User Image">
                  <span class="username"><?php echo $nama; ?></span>
                  <span class="description"><?php echo $tanggal; ?></span>
                </div>
                <!-- /.user-block -->
                <div class="box-tools">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <!-- post text -->
                <?php echo $isi; ?>

              </div>
              <!-- /.box-body -->

            </div>
            <!-- /.box -->
            </div>


          </div>


          <!-- /.box-body -->
      </div>

      <!-- BATAS -->
  </div>
  <!-- /.row -->
  <!-- Main row -->
  <div class="row">
  </div>
  <!-- /.row (main row) -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php footer(); ?>
<div class="control-sidebar-bg"></div>
</div>
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
<script src="dist/js/pages/dashboard.js"></script>
<script src="dist/js/demo.js"></script>
<script src="dist/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="dist/plugins/fastclick/fastclick.js"></script>

</body>

</html>