<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $this->uri->segment(2); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 

        <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js">
    $(function(){
      $('#functionName').text( $('#functionName').text().replace(/([A-Z])/g, " ") );
    })
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
        <!-- <div class="col-md-12 col-xs-12">
          <div class="col-xs-2 col-sm-2">
              <img src="<?php //echo base_url() ?>images/company-logo/<?php //echo $GetSettingInformation[0]['CompanyLogo']; ?>" alt="" width="100" class="img-circle">
          </div>
          <div class="col-xs-8 col-sm-8">
            <h2 style="color:black; font-family:Calibri; font-weight:600;margin-left: 1%; margin-top: 30px;font-size:18px;" class="box-title text-center"><?php //echo $GetSettingInformation[0]['CompanyName']; // $this->session->userdata('CompanyName'); ?></h2>
          </div>
        </div> -->
    <!-- <br> -->
    <br>
      <!-- <h3 style="color:green;text-align: center;font-size:15px;" id="functionName">
        <?php 
            //$FunctionName = $this->uri->segment(2);
            //$WithSpace = preg_replace('/(?<!\ )[A-Z]/', ' $0', $FunctionName);
            //echo $WithSpace;
          ?>
        </h3> -->
      
      <div style="padding-top:-0.1em; font-size:10px; font-weight:600; text-align:center;">as of <?php echo date('M d, Y', strtotime(date('Y-m-d'))); ?>
      </div>
        
      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
      <!--  <button class="pull-right" type="button" id="SendMail" data-toggle="modal" data-target="#myModal">Send as Email</button> -->
           </div>
	     <!-- <div style="height:30px;"></div> -->
            <div class="table-head-only" style="overflow-x: scroll;">
            <table border="1" class="table table-striped">
    <?php 
            $SNo = 0;
            $GrandQuantityTotal = 0;
            $GrandStockValueTotal = 0;
            $GrandAvgTotal = 0;
            foreach($AllProducts as $Category){ ?>
              <thead>
                <tr style="font-size:10px;border-bottom: 1px solid;">
                    <th colspan="13" style="border: 1px solid;font-family:Calibri;"><?php echo $Category['CategoryName']; ?></th>
                </tr>
                <tr style="background:#205081; font-size:10px; color:#FFFFFF;border-bottom: 1px solid;">
                    <th style="width: 5%;text-align:center;font-family:Calibri;border-bottom: 1px solid;">1-Sr.</th>
                    <th style="width: 5%;text-align:center;font-family:Calibri;border-bottom: 1px solid;">G-Sr.</th>
                    <th style="width: 10%;text-align:center;font-family:Calibri;border-bottom: 1px solid;">Product Group</th>
                    <th style="width: 10%;text-align:center;font-family:Calibri;border-bottom: 1px solid;">Brand</th>
                    <th style="width: 15%;text-align:center;font-family:Calibri;border-bottom: 1px solid;">Model no.</th>
                    <th style="width: 18%;text-align:center;font-family:Calibri;border-bottom: 1px solid;">Specification</th>
                    <th style="width: 5%;text-align:center;font-family:Calibri;border-bottom: 1px solid;">Qty</th>
                    <th style="width: 5%;text-align:center;font-family:Calibri;border-bottom: 1px solid;">Retail</th>
                    <th style="width: 5%;text-align:center;font-family:Calibri;border-bottom: 1px solid;">Policy</th>
                  <?php if($StockValue == "all"){ ?>
                    <th style="width: 5%;text-align:center;font-family:Calibri;border-bottom: 1px solid;">Avg: Price</th>
                    <th style="width: 5%;text-align:center;font-family:Calibri;border-bottom: 1px solid;">Avg: S/Value</th>
                    <th style="width: 5%;text-align:center;font-family:Calibri;border-bottom: 1px solid;">N.Price</th>
                    <th style="width: 5%;text-align:center;font-family:Calibri;border-bottom: 1px solid;">Stock Value</th>
                    <?php } ?>
                    
                </tr>
            </thead>
            <tbody>
    <?php
    $stockQuantity =0;
    $totalSAmoumt = 0;
    $avgPrice =0;
    $allStockQuantity =0;
    $allStockValue = 0;
    $productGroupName = "";
    $SrNo = 0;

    $i = 0;
    foreach($Category['Products'] as $ProductRecord) 
    { 
        $PurchaseReturnQuantity = 0;
        $SaleQuantity = 0;
        // Getting Total Purchase Return Quantity
        if(isset($AllPurchaseReturnRecord))
        {
            foreach($AllPurchaseReturnRecord as $PurchaseReturnRecord)
            { 
                if($PurchaseReturnRecord['ProductId'] == $ProductRecord['ProductId'])
                { 
                $PurchaseReturnQuantity = $PurchaseReturnRecord['Quantity'];
                }
            }
        }

        // Getting Total Sale Quantity
        if(isset($AllSaleRecord))
        {
            foreach($AllSaleRecord as $SaleRecord)
            { 
                if($SaleRecord['ProductId'] == $ProductRecord['ProductId'])
                {
            $SaleQuantity = $SaleRecord['Quantity']; 
                }
            }
        }

        $allStockQuantity     += $ProductRecord['Quantity'] - ($SaleQuantity + $PurchaseReturnQuantity);
        $allStockValue        += ($ProductRecord['Quantity'] - ($SaleQuantity + $PurchaseReturnQuantity)) * $ProductRecord['PurchasePrice'];
        $GrandQuantityTotal   += $ProductRecord['Quantity'] - ($SaleQuantity + $PurchaseReturnQuantity);
        $GrandStockValueTotal += ($ProductRecord['Quantity'] - ($SaleQuantity + $PurchaseReturnQuantity)) * $ProductRecord['PurchasePrice'];
        if($i != 0 && $productGroupName != $ProductRecord['ProductGroupName']){
            $SrNo = 1;  ?>
        <tr style="font-family:arial, sans-serif; font-size: 10px;">
            <td colspan="6" style="text-align:right;font-weight:bold;border-bottom: 1px solid;">Total Qty:</td>
            <td colspan="7" style="text-align:left;font-weight:bold;border-bottom: 1px solid;"><?php echo $stockQuantity; ?>	</td>
        </tr>
        <?php
        $stockQuantity = 0;
        }else{
            $SrNo++;
        }
        $stockQuantity += $ProductRecord['Quantity'] - ($SaleQuantity + $PurchaseReturnQuantity);
        $SNo++;
        $productGroupName = $ProductRecord['ProductGroupName'];

        // set avg price
        foreach($ProductsPrice as $avg){
          if($avg['ProductId'] == $ProductRecord['ProductId']){
            $avgPrice = ($avg['Amount'] / $avg['Quantity']);
          }
        }
        $totalSAmoumt  += $avgPrice * ($ProductRecord['Quantity'] - ($SaleQuantity + $PurchaseReturnQuantity));
        $GrandAvgTotal += $avgPrice * ($ProductRecord['Quantity'] - ($SaleQuantity + $PurchaseReturnQuantity));
        ?>
        <tr style="font-family:arial, sans-serif; font-size: 10px;border-bottom: 1px solid;">  
            <td style="text-align:center;border-bottom: 1px solid;font-family:Calibri;"><?php echo $SNo; ?>	</td>
            <td style="text-align:center;border-bottom: 1px solid;font-family:Calibri;"><?php echo $SrNo; ?>	</td>
            <td style="text-align:left;border-bottom: 1px solid;font-family:Calibri;"><?php echo $ProductRecord['ProductGroupName'] //.' - '.$ProductRecord['ProductGroupName'].' - '.$ProductRecord['BrandName']; ?></td>
            <td style="text-align:left;border-bottom: 1px solid;font-family:Calibri;"><?php echo $ProductRecord['BrandName']; ?></td>
            <td style="text-align:left;border-bottom: 1px solid;font-family:Calibri;"><?php echo $ProductRecord['ProductName']; ?></td>
            <td style="text-align:right;border-bottom: 1px solid;font-family:Calibri;"><?php echo $ProductRecord['ProductDetails']; ?></td>
            <td style="text-align:center;border-bottom: 1px solid;font-family:Calibri;"><?php echo $ProductRecord['Quantity'] - ($SaleQuantity + $PurchaseReturnQuantity); ?></td>
            <td style="text-align:right;border-bottom: 1px solid;font-family:Calibri;"><?php echo number_format($ProductRecord['FinalPrice'], 0); ?></td>
            <td style="text-align:right;border-bottom: 1px solid;font-family:Calibri;"><?php echo $ProductRecord['Policy']; ?></td>
          <?php if($StockValue == "all"){ ?> 
            <td style="text-align:right;border-bottom: 1px solid;font-family:Calibri;"><?php echo number_format($avgPrice,0); ?></td>
            <td style="text-align:right;border-bottom: 1px solid;font-family:Calibri;"><?php echo number_format($avgPrice * ($ProductRecord['Quantity'] - ($SaleQuantity + $PurchaseReturnQuantity)), 0); ?></td>
            <td style="text-align:right;border-bottom: 1px solid;font-family:Calibri;"><?php echo number_format($ProductRecord['PurchasePrice'], 0); ?></td>
            <td style="text-align:right;border-bottom: 1px solid;font-family:Calibri;"><?php echo number_format(($ProductRecord['Quantity'] - ($SaleQuantity + $PurchaseReturnQuantity)) * $ProductRecord['PurchasePrice'], 0); ?></td>
            <?php } ?>
        </tr>
    <?php
     
    $i++;
	}  
	?>
    <tr style="font-family:arial, sans-serif; font-size: 10px;border-bottom: 1px solid;">
        <td colspan="6" style="text-align:right;font-weight:bold;border-bottom: 1px solid;font-family:Calibri;">Total Qty:</td>
        <td colspan="7" style="text-align:left;font-weight:bold;border-bottom: 1px solid;font-family:Calibri;"><?php echo $stockQuantity; ?>	</td>
    </tr>
     <tr>             
        <td colspan="6" style="text-align:right; font-weight: 700; font-size: 8px;font-weight:bold;border-bottom: 1px solid;font-family:Calibri;">Category Total Qty:</td>
        <td style="text-align:right; font-weight:700;font-weight:bold;border-bottom: 1px solid;font-family:Calibri;"><?php echo $allStockQuantity; ?></td>
        <?php if($StockValue == "all"){ ?> 
          <td colspan="3" style="text-align:right; font-weight: 700; font-size: 8px;font-weight:bold;border-bottom: 1px solid;font-family:Calibri;">T.Avg S/Value:</td>
          <td style="text-align:right; font-weight:700;font-weight:bold;border-bottom: 1px solid;font-family:Calibri;"><?php echo number_format($totalSAmoumt, 0); ?></td>
          <td colspan="1" style="text-align:right; font-weight: 700; font-size: 8px;font-weight:bold;border-bottom: 1px solid;font-family:Calibri;">Stock Total Value:</td>
          <td style="text-align:right; font-weight:700;font-weight:bold;border-bottom: 1px solid;font-family:Calibri;"><?php echo number_format($allStockValue, 0); ?></td>
        <?php } ?>
        
     </tr>
<?php } ?>
    <tr>             
        <td colspan="6" style="text-align:right; font-weight: 700; font-size: 10px;font-weight:bold;border-bottom: 1px solid;font-family:Calibri;">Grand Total:</td>
        <td style="text-align:right; font-weight:700;font-weight:bold;border-bottom: 1px solid;font-family:Calibri;"><?php echo $GrandQuantityTotal; ?></td>
        <?php if($StockValue == "all"){ ?> 
          <td colspan="3" style="text-align:right; font-weight: 700; font-size: 8px;font-weight:bold;border-bottom: 1px solid;font-family:Calibri;">Grand Total:</td>
          <td style="text-align:right; font-weight:700;font-weight:bold;border-bottom: 1px solid;font-family:Calibri;"><?php echo number_format($GrandAvgTotal,0); ?></td>
          <td colspan="1" style="text-align:right; font-weight: 700; font-size: 10px;font-weight:bold;border-bottom: 1px solid;font-family:Calibri;">Grand Total:</td>
          <td style="text-align:right; font-weight:700;font-weight:bold;border-bottom: 1px solid;font-family:Calibri;"><?php echo number_format($GrandStockValueTotal, 0); ?></td>
        <?php } ?>  
     </tr>
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

  // $(".table-basic").freezeTable();

  // $(".table-head-only").freezeTable({
  //   'freezeColumn': false,
  // });


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