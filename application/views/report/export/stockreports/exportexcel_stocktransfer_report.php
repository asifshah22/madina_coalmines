<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename = Stock Transfer Report.xls");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Stock Transfer Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 

        <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js">
  </script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
<style type="text/css">

@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}

</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <div class="box box-info">
        <div class="col-md-12 col-xs-12">
          <center>
            <div class="box-header">
	      <h2 style="color:black; font-family:Georgia; font-weight:600;" class="box-title">Hilife Electronics</h2>
              <h3 style="color:green;" class="box-title">Stock Transfer Report</h3>
	      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
<div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
            </div>
          </center>
        </div>
    <br><br>

      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
      <!--  <button class="pull-right" type="button" id="SendMail" data-toggle="modal" data-target="#myModal">Send as Email</button> -->
           </div>
       <div style="height:30px;"></div>
            <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 100%" id="table-basic">
              <thead>
                <tr style="background:#205081; font-size:13px; color:#FFFFFF;">
                  <th style="">S.Id</th>
                  <th style="text-align:left;">Product Name</th>
                  <th style="text-align:left;">Colour</th>
                  <th style="text-align:left;">Location From</th>
                  <th style="text-align:left;">Location To</th>
                  <th style="text-align:left;">Transfered By</th>
                  <th style="text-align:left;">Quantity</th>
                  <th style="text-align:center;">Transfer Date</th>
                  <th style="text-align:center;">Comment</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $SNo = 0;
                $i = 0;
                foreach ($AllStockTransferRecord as $AllStockTransfer) {
                $SNo++;
                  ?>
                <tr class="gradeU" style="background-color: #fFffff">
                  <td style="text-align:center;"><?php echo $SNo; ?></td>
                  <td style="text-align:left;"><?php echo ($AllStockTransfer['ProductName'] . "-" . $AllStockTransfer['ProductGroupName'] . "-" . $AllStockTransfer['BrandName']); ?></td>
                  <td style="text-align:left;"><?php echo ($AllStockTransfer['ColourName']); ?></td>
                  <td style="text-align:left;"><?php if(!$AllStockLocationFrom[$i]['LocationName']){echo "--" ;} 
                    else{ echo $AllStockLocationFrom[$i]['LocationName']; } ?></td>
                  <td style="text-align:left;"><?php echo ($AllStockTransfer['LocationName']); ?></td>
                  <td style="text-align:left;"><?php if(!$AllStockTransfer['EmployeeName']){echo "--";}
                    else{ echo ($AllStockTransfer['EmployeeName']);} ?></td>
                  <td style="text-align:left;"><?php echo ($AllStockTransfer['Quantity']); ?></td>
                  <td style="text-align:center;"><?php echo date('M d, Y', strtotime($AllStockTransfer['InOutDate'])); ?></td>
                  <td style="text-align:left;"><?php echo ($AllStockTransfer['Comments']); ?></td>
                </tr>
                <?php
                $i++;
                }
                ?>
              </tbody>
      </table>
          </div>
        </div>
        </div>
        <?php
    //  }
      ?>

<script src="<?php echo base_url(); ?>plugins/select2/select2.min.js"></script>
<script src="<?php echo base_url(); ?>lib/js/freeze-table.js"></script>
<script>
$(document).ready(function() {

  $(".table-basic").freezeTable();

  $(".table-head-only").freezeTable({
    'freezeColumn': false,
  });


  $("#Show").click(function(){
    $("#OtherEmployee").toggle('2000');
  })


});
</script>


<script>
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>