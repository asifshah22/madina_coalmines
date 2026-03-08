<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename = Product Sale Detail Report.xls");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Product Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
    <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
      <div class="box box-info">
         <div class="col-md-12 col-xs-12">
            <h2 style="color:black; font-family:Georgia; font-weight:600;text-align: center; margin-top: 10px;" class="box-title">Sunny Paper Mills</h2>
          </div>
    <br><br>
      <h3 style="color:green;text-align: center;">Product Sale Detail</h3>
      
      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
       <div style="height:30px;"></div>
            <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 100%" id="table-basic">
              <thead>
                <tr style="background:#3c8dbc; font-size:14px; color:#FFFFFF;">
                 <th>S.#</th>
                 <th>Product Name</th>
                 <th>Weight</th>
                 <th>Amount</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $SNo=1; 
                $Weight = 0;
                $Total = 0;
                if(isset($SalesOrderProductDetailReport)) {
                foreach($SalesOrderProductDetailReport as $row) {
            ?>
                <tr style="font-size:13px;">
        <td style="padding-left:10px; padding-top:10px;"><?php echo $SNo; ?></td>
                 <td><?php echo $row['ProductName']?></td>
                 <td><?php echo $row['Weight']?></td>
                 <td><?php echo number_format($row['NetAmount'],0);?></td>
                </tr>
                <?php
                $Weight += $row['Weight'];
                $Total += $row['NetAmount'];
                $SNo++; } }
                ?>
              <tr>
                <td colspan="2" style="text-align: right;"><b> Total: </b> </td>
                <td><?php echo "<b>" . number_format($Weight,0) . "</b>"; ?></td>
                <td><?php echo "<b>" . number_format($Total,0) . "</b>"; ?></td>
              </tr>  
              </tbody>
              </table>
            </div>
         </div>   
       </div>
    </div>
  </body>
</html>
<script src="<?php echo base_url(); ?>lib/js/freeze-table.js"></script>
<script>
$(document).ready(function() {

  $(".table-basic").freezeTable();

  $(".table-head-only").freezeTable({
    'freezeColumn': false,
  });

});
</script>