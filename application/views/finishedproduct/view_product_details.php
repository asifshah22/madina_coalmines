<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Finished Product Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 
          <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper" style="background: #ffffff">
      <div class="box box-info">
        <div class="col-md-12 col-xs-12">
          <center>
           <div class="box-header">
	    <h3 style="color:green; margin-right: 8%;" class="box-title">Finished Product Details</h3>
           </div> 
	    <div style="height:30px;"></div>
              <div class="table-head-only" style="overflow-x: scroll;">
	      <table class="table table-bordered" style="width:80%" id="table-basic">
              <thead>
                <tr style="background:#3c8dbc; font-size:13px; color:#FFFFFF;">
                 <th style="text-align:center; width:5%;">S.#</th>
                 <th style="text-align:left;">Product</th>
                 <th style="text-align:left;">Product Quality</th>
                 <th style="text-align:left;">Reel Size</th>
                 <th style="text-align:center;">Weight (KG)</th>
                 <th style="text-align:center;">Quantity</th>
                 <th style="text-align:center;">Action</th>
                </tr>
              </thead>
              <tbody>
                <input type="hidden" name="SerialNo" id="SerialNo" value="<?php echo $SerialNo; ?>">
          	<?php
            $SNo=1;
/*            echo $ReelSize;
            die;*/
		          if(!empty($GetFinishedProductsById) ) {
                foreach($GetFinishedProductsById as $row) {
		          ?>
                <tr style="font-size:13px;">
                 <td style="text-align:center;"><?php echo $SNo;?></td>
		             <td style="text-align:right;"><?php echo $row['ProductName']; ?></td>
                 <td style="text-align:right;"><?php echo $row['ProductQuality']; ?></td>
                 <td style="text-align:right;"><?php echo number_format($row['ReelSize'],0); ?></td>
                 <td style="text-align:right;"><?php echo number_format($row['Weight'],0); ?></td>
                 <td style="text-align:right;"><?php echo number_format($row['Quantity'],2); ?></td>
                 <td style="align-items: center;"><input type="radio" name="AddWeight" id="AddWeight" value="<?php echo $row['Weight']; ?>"></td>
                </tr>
		          <?php	
              $SNo++;
		          }
                }
                else{
                  ?>
                  <tr style="font-size:13px; font-weight: 600;">
                  <td style="text-align:center;" colspan="7">
                  <?php echo "<p style='font-size:13px;'>No product with Reel Size $ReelSize is available in finished products </p>";
                  ?>
                </td>
              </tr>
                  <?php
                }
                ?>
              </tbody>
              </table>
              </div>
	    </center>
         </div>
       </div>
    </div>
  </body>
</html>

<script>
$(document).ready(function() {

//    $("#Submit").on('click', function(){
//      var AddWeight = $("input[id^=AddWeight").val();
//      $("#table-basic").append('<tr><td>Hello </td>');
//    });
    $("input[id^=AddWeight").on('click', function(){
/*      alert($(this).val());
      return;*/
//      $("#myModal").hide();
      var Weight = ($(this).val());
      var SNo = $("#SerialNo").val();
    $("#Weight_"+SNo).val(Weight);
      
    })

});
</script>


<script>
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>