
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
error_reporting(0);
include "configuration/config_include.php";
etc();session();connect();
?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="dist/plugins/print/one.css">
        <!-- <title>Cetak</title> -->

        <?php
        $decimal ="0";
        $a_decimal =",";
        $thousand =".";
        ?>

        <?php
        $nota = $_GET["nota"];

        $sql1="SELECT * FROM data";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $nama=$row['nama'];
        $alamat=$row['alamat'];
        $notelp=$row['notelp'];
        $tagline=$row['tagline'];
        $signature=$row['signature'];
        $avatar=$row['avatar'];

        $sql1="SELECT * FROM bayar where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $tglbayar=$row['tglbayar'];
        $bayar=$row['bayar'];
        $total=$row['total'];
        $kembali=$row['kembali'];
        $kasir=$row['kasir'];
         $cus=$row['customer'];


        $sql1="SELECT SUM(jumlah) as data FROM transaksimasuk where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $totalqty=$row['data'];

        ?>
        <table  class="table-header center-block">

<tr> <td colspan="1" rowspan="5" style="border-bottom:double 4px #000"><img src="<?php echo $avatar; ?>" style="width:50px;height:50px;"></td>  </tr>
  <tr>
    <td colspan="4" style=" text-align:left; font-size:14px;  font-weight:bold; width:240px"><?php echo $nama;?></td>
  </tr>
    <tr>
    <td colspan="4" style="text-align:left; font-style:italic; width:240px;  "><?php echo $tagline;?></td>
      </tr>
  <tr>
    <td colspan="4" align="left" style=" text-align:left; width:240px;"><?php echo $alamat;?></td>
  </tr>
  <tr>
    <td colspan="4" style=" text-align:left; border-bottom:double 4px #000; padding-bottom:5px;width:240px;"><?php echo $notelp;?></td>
  </tr>
</table>
        </table>

        <table class="table-print">
       <tr class="spa">
        <td width="20%" style="width:48px;">&nbsp;</td>
        <td width="15%" style="width:28.8px;">&nbsp;</td>
        <td width="20%"  style="width:43.2px;">&nbsp;</td>
        <td width="18%"  style="width:48px;">&nbsp;</td>
        <td width="18%"  style="width:60px;">&nbsp;</td>
        <td width="8%"  style="width:12px;">&nbsp;</td>
        </tr>
        <tr>
        </tr>

         <tr >
           <td style="width:192px;" colspan="6" align="left">No.Nota - <?php echo $nota;?> / <?php echo date('d-m-Y',strtotime($tglbayar));?></td>
           
        </tr>
        <tr >
           <td style="width:192px;" colspan="6" align="left"><?php echo $cus;?></td>
        </tr>

     

           <tr class="siv solid">
            <td colspan="6" style="width:240px;">
          <div class="solid-border" ></div>
        </td>
          </tr>

           <?php

          $query1="SELECT * FROM transaksimasuk where nota ='$nota' order by no";
          $hasil = mysqli_query($conn,$query1);
          while ($fill = mysqli_fetch_assoc($hasil)){
            ?>

            <tr>
              <td colspan="6" style="width:240px;"><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
              </tr>

              <tr>

              <td colspan="2" style="width:76.8px;">Qty : <?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?> x</td>
              <td style="width:43.2px;"><?php  echo number_format(($fill['harga']), $decimal, $a_decimal, $thousand).',-'; ?></td>
              <td style="width:48px;" align="right"><?php  echo number_format(($fill['harga']*$fill['jumlah']), $decimal, $a_decimal, $thousand).',-'; ?></td>
              <td style="width:72px;" colspan="2" align="right"></td>
              </tr>

             
             
            <tr class="siv">
              <td colspan="5" style="width:228px;">
            <div class="dotted-border"></div> </td>
            <td style="width:12px;">(+) </td>
            </tr>

            <?php
            ;
          }

           ?>


      

          <tr>
          <td colspan="3" style="width:120px;">SubTotal</td>
          <td style="width:48px;" align="right"><b><?php echo number_format($total, $decimal, $a_decimal, $thousand).',-';?></b></td> 
          <td style="width:72px;" colspan="2" ></td>
          </tr>

           <tr>
          <td colspan="3" style="width:120px;">Bayar</td>
          <td style="width:48px;" align="right"><?php echo number_format($bayar, $decimal, $a_decimal, $thousand).',-';?></td>
          <td style="width:72px;" colspan="2" ></td>
          </tr>


        <tr class="siv">
          <td colspan="5" style="width:228px;">
        <div class="dotted-border"></div> </td>
        <td style="width:12px;">(-) </td>
        </tr>

        <tr>
          <td colspan="3" style="width:116px;">Kembali</td>
          <td style="width:52px;" align="right"><?php echo number_format($kembali, $decimal, $a_decimal, $thousand).',-';?></td>
          <td style="width:72px;" colspan="2" ></td>
          </tr>

           <tr class="siv solid">
            <td colspan="6" style="width:240px;">
          <div class="solid-border" ></div>
        </td>
          </tr>

        <tr>
          <td style="width:200px;" colspan="6" align="center"><?php echo $kasir;?></td>
          </tr>

           <tr class="siv solid">
            <td colspan="6" style="width:240px;">
          <div class="solid-border" ></div>
        </td>
          </tr>

       <tr>
          <td style="width:200px;" colspan="4"><pre  style="white-space: pre-line;">
<center><?php echo $signature;?></center>
          <pre></td>
          </tr>
          <tr class="terakhir">
          <td style="width:200px;" colspan="6"></td>
          </tr>
        </table>


<?php 

if(isset($printhandler)){} else {?>
        <script>

          setTimeout(function(){window.print()}, 2000);
           </script>
<?php } ?>