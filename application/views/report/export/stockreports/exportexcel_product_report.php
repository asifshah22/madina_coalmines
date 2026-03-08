<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename = Product Report.xls");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Product Report </title>
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
              <h3 style="color:green;" class="box-title"> Product Report</h3>
	      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
            </div>
          </center>
        </div>
    <br><br>

      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
      <!--  <button class="pull-right" type="button" id="SendMail" data-toggle="modal" data-target="#myModal">Send as Email</button> -->
           </div>
       <div style="height:30px;"></div>
  <table class="table table-bordered table-basic">
    <thead>
	<?php 
//    	if($GetProductReport) {
	?>
	<tr style="background:#205081; color:#fff;">
	<th style="padding:5px;">S. #</th>
	<th style="text-align:left; padding:5px;">Category</th>
	<th style="text-align:left; padding:5px;">Brand</th>
	<th style="text-align:left; padding:5px;">Product Group</th>
	<th style="text-align:left; padding:5px;">Product Name</th>
	<th style="text-align:left; padding:5px;">Barcode. #</th>
	<th style="text-align:left; padding:5px;">Purchase Price</th>
	<th style="text-align:center; padding:5px;">Sale Price</th>
	<th style="text-align:center; padding:5px;">Minimum Stock</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $TotalPurchasesQuantity = 0;
    $TotalAmount = 0;
	 $SNo = 1;
	foreach($GetProductReport as $AllRecord)
	{
    ?>
	<tr class="gradeU" style="background-color: #fFffff"> 
	<td style="text-align:center;"><?php echo $SNo; ?></td>
	<td style="text-align:left;"><?php echo ($AllRecord['CategoryName']); ?></td>
	<td style="text-align:left;"><?php echo ($AllRecord['BrandName']); ?></td>
	<td style="text-align:left;"><?php echo ($AllRecord['ProductGroupName']); ?></td>
	<td style="text-align:left;"><?php echo ($AllRecord['ProductName']); ?></td>
	<td style="text-align:right;"><?php echo ($AllRecord['ProductBarCode']); ?></td>
	<td style="text-align:right;"><?php echo ($AllRecord['PurchasePrice']); ?></td>
  <td style="text-align:right;"><?php echo ($AllRecord['SellPrice']); ?></td>
  <td style="text-align:right;"><?php echo ($AllRecord['OpeningStock']); ?></td>
        </tr>
	<?php
  $SNo++;
	} 
	?>

   </tbody>
   </table>
  </div>
</body>
</html>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Email</h4>
        <p id="msg" style="text-align: center;">
          <img id="loader" src="<?php echo base_url(); ?>lib/img/loader.gif" style="display: none;" />
        </p>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="Password" class="col-sm-3 control-label"><b>From:</b></label>
          <div class="col-sm-8">
              <span class=""><?php echo $this->session->userdata('EmployeeName') . " ( " . $this->session->userdata('UserName') . " ) " ; ?></span>
          </div>
        </div> <br><br>

        <div class="form-group">
          <label for="Password" class="col-sm-3 control-label"><b>Receipent:</b></label>
          <div class="col-sm-8">
            <select name="EmployeeId[]" id="EmployeeId" class="form-control js-example-basic-multiple" multiple="multiple" style="width: 100%">
              <option value="">Select Recipient</option>
               <?php foreach ($AllEmployees as $row) { ?>
               <option value="<?php  echo $row['EmailAddress']; ?>"><?php echo $row['EmailAddress']; ?></option>
               <?php } ?>
               <option value="sarmadsoomro94@gmail.com">sarmadsoomro94@gmail.com</option>
              </select><span>If not in the list click here. &nbsp; &nbsp;<i class="fa fa-plus" style="cursor: pointer;" id="Show"></i></span>
          </div>
        </div> <br /><br />
        <div class="form-group">
          <label for="OtherEmployee" class="col-sm-3 control-label"><b></b></label>
          <div class="col-sm-8">
                <input type="email" name="OtherEmployee" id="OtherEmployee" class="form-control" required="required" placeholder="Enter new email here" style="display: none;" >
          </div>
        </div> <br /><br />
        <input type="hidden" name="StartDate" id="StartDate" value="<?php echo $this->input->get('StartDate'); ?>">
        <input type="hidden" name="EndDate" id="EndDate" value="<?php echo $this->input->get('EndDate'); ?>">
<div class="form-group">
          <label for="Subject" class="col-sm-3 control-label"><b>Subject:</b></label>
          <div class="col-sm-8">
                <input type="text" name="Subject" id="Subject" class="form-control" required="required" value="Sale Report from: <?php echo date('M d, Y', strtotime($this->input->get('StartDate')));?> To <?php echo date('M d, Y', strtotime($this->input->get('EndDate')));?> ">
          </div>
        </div> <br /><br />

                <div class="form-group">
                <label for="Comments" class="col-sm-3 control-label"><b>Comments:</b></label>
                <div class="col-sm-8">
                <textarea name="Comments" id="Comments" class="form-control" rows="4" cols="45"></textarea>
                </div>
              </div> <br> <br>

      </div><br /><br><br>
      <div class="modal-footer">
        <button type="button" id="Submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

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
  $(function(){
    $("#Submit").on('click', function(){
      var EmployeeId = $("#EmployeeId").val();
      var OtherEmployee = $("#OtherEmployee").val();
      var Subject = $("#Subject").val();
      var Comments = $("#Comments").val();
      var Message = $("#Message").val();
      var StartDate = $("#StartDate").val();
      var EndDate = $("#EndDate").val();

      $.ajax({
        url: '<?php echo base_url(); ?>SendEmail/SendSaleDetailReport',
        data: {EmployeeId:EmployeeId,OtherEmployee:OtherEmployee,Subject:Subject,Comments:Comments,Message:Message,StartDate:StartDate,EndDate:EndDate},
        type: 'post',
        dataType: 'html',

        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
      success:function(data){
        $("#loader").css('display', 'none');
        $('input').val('');
        $('textarea').val('');
        $("#msg").html(data)
        }
      })
    })
  })
</script>

<script>
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>