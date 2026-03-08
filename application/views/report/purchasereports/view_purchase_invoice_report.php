<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Purchase Invoice Detail Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/AdminLTE.min.css">
</head>
<body>
<?php

// print_r($PurchaseInvoiceReport);

if(empty($PurchaseInvoiceReport)) die('<div style="text-align:center;">No record found.</div>'); 


$PurchaseType = '';

if($PurchaseInvoiceReport->PurchaseType == 1) {
    $PurchaseType = 'Cash';
}
if($PurchaseInvoiceReport->PurchaseType == 2) {
    $PurchaseType = 'Credit';
}
if($PurchaseInvoiceReport->PurchaseType == 3) {
    $PurchaseType = 'Online';
}


/*if($PurchaseInvoiceReportDetails[0]['InvoiceDate'])
$sInvoiceDate = date('M d, Y',strtotime($PurchaseInvoiceReportDetails[0]['InvoiceDate']));
else
$sInvoiceDate = '_____/_____/_________';*/
?>
 
    
 <div class="wrapper">
 <!-- Main content --> 
 <div style="page-break-after:always"></div> 
 
 <section class="invoice">


          <div class="col-xs-12 col-sm-12">
              <img src="<?php echo base_url() ?>images/company-logo/<?php echo $GetSettingInformation[0]['CompanyLogo']; ?>" alt="" width="100" class="img-circle">
          </div>

  <div class="box-header">
      <span class="pull-right" style="font-size:13px; font-family: Arial, Helvetica, sans-serif;"><a href="#" class="" id="SendMail" data-toggle="modal" data-target="#myModal" style="color:green">Email</a> &nbsp; &nbsp;<a href="#" style="color:green" onclick="window.print();">Print</a> &nbsp; &nbsp;</span>
<!--       <p style="font-weight: 600; margin-right: 2%;"> BEST ELECTRONICS WHOLEPurchaseR</p> -->
      <p style="font-weight: 600; margin-right: 2%;"> <?php echo $GetSettingInformation[0]['Address']; ?></p>

           </div> 
   
    <div class="row">
      <div class="col-xs-12">
        <div style="height:10px; "></div>
        <table border="0" class="table table-striped">
         <thead>
         <tr>
<!--            <td colspan="2" style="text-align:center; font-size: 26px; font-weight:bold;">INVOICE</td> -->
         </tr>
        
         </thead>
        </table>   
      </div>
    </div>
    <!-- info row -->
    
    <div class="row invoice-info">
      <div class="col-sm-6 pull-right">
                   <p style="text-align:center; font-size: 26px; font-weight:bold;">INVOICE</p>
        <address>
         <p style="font-size:16px;">Date: <span style="font-size:16px; font-weight:600;"><?php echo date("M d, Y",strtotime($PurchaseInvoiceReport->PurchaseDate)); ?></span>
          <span class="pull-right" style="font-size:16px;">Invoice No:  <label style="font-weight: 600">  <?php echo $PurchaseInvoiceReport->PurchaseId; ?></label></span>
         </p>
         <p style="font-size:16px;">Vendor Name / ID:<span style="font-size:16px; font-weight:600;"> <?php echo $PurchaseInvoiceReport->VendorName . ' / V# ' . $PurchaseInvoiceReport->VendorId; ?></span>
         </p>
         <div style="height: 3px;"></div>
         <p style="font-size:16px;">Payment Type: <span style="font-size:16px; font-weight:600;"><?php echo $PurchaseType; ?></span></p>
         <?php // // } ?>
        </address>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table border="0" class="table table-striped">
          <thead>
            <tr style="background:#3c8dbc; font-size:14px; color:#FFFFFF;">
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid;">S#</th>
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:auto;">PRODUCT DETAILS</th>
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:auto;">QUANTITY</th> 
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:auto;">RATE</th> 
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:auto;">AMOUNT</th> 
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:auto;">DISCOUNT / TAX</th>
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:auto;">NET AMOUNT</th>
           </tr>
          </thead>
          <tbody>
          <?php //
          $TotalQuantity = 0;
          $TotalAmount = 0;
          $TotalDiscount = 0;
          $TotalNetAmount = 0;
	  $SNo=1;
	  if(isset($PurchaseInvoiceReportDetails)) {
          foreach($PurchaseInvoiceReportDetails as $row) {
           
          $Particulars = $row['ProductGroupName'].' - '.$row['BrandName'].' - '.$row['ProductName'];
	  ?>
          <tr>
            <td style="font-size:14px; font-weight:600; text-align:center;"><?php echo $SNo; ?></td>
            <td style="font-size:14px; font-weight:600; text-align:left;"><?php echo $Particulars; ?></td>
            <td style="font-size:14px; font-weight:600; text-align:center;"><?php echo number_format($row['Quantity'],2); ?></td>
            <td style="font-size:14px; font-weight:600; text-align:center;"><?php echo number_format($row['Rate'],2); ?></td>
            <td style="font-size:14px; font-weight:600; text-align:center;"><?php echo number_format($row['Amount'],2); ?></td>
             <td style="font-size:14px; font-weight:600; text-align:center;"><?php echo ($row['DiscountAmount'] + $row['TaxAmount']); ?></td>
             <td style="font-size:14px; font-weight:600; text-align:center;"><?php echo number_format(($row['NetAmount']),2); ?></td>
           </tr>
           <?php $SNo++;
           $TotalQuantity += $row['Quantity'];
           $TotalAmount += $row['Amount'];
           $TotalDiscount += ($row['DiscountAmount'] + $row['TaxAmount']);
           $TotalNetAmount += $row['NetAmount'];
           } 
           ?>
           <tr style="">
             <td style="text-align:right; font-size:14px; font-weight:bold; border-bottom:1px solid; border-top:1px solid;"></td>
             <td style="text-align:left; font-size:14px; font-weight:bold; text-align:right; border-bottom:1px solid; border-top:1px solid;">Total Rs.</td>
             <td style="text-align:left; font-size:14px; font-weight:bold; text-align:center; border-bottom:1px solid; border-top:1px solid;"><?php echo number_format($TotalQuantity,2); ?></td>
             <td style="text-align:right; font-size:14px; font-weight:bold; border-bottom:1px solid; border-top:1px solid;"></td>
             <td style="text-align:center; font-size:14px; font-weight:bold; border-bottom:1px solid; border-top:1px solid;"><?php echo number_format($TotalAmount,2); ?></td>
             <td style="text-align:center; font-size:14px; font-weight:bold; border-bottom:1px solid; border-top:1px solid;"><?php echo number_format($TotalDiscount,2); ?></td>
             <td style="text-align:center; font-size:14px; font-weight:bold; border-bottom:1px solid; border-top:1px solid;"><?php  echo number_format($TotalNetAmount,2); ?></td>
             
           </tr>
          </tbody>
        </table>
        <?php } ?>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <div style="height:52px;"></div>
    <?php // if($CompanyWarranty=='true') { ?>  
    <div class="row">
      <div class="col-xs-8">
        <p style="font-size:16px; font-weight:600; ">NOTE:</p>
        <p style="margin-top: 10px; font-size: 14px;">
         <?php echo $PurchaseInvoiceReport->PurchaseNote ?>
        </p>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <?php // } ?>
    <div style="height:50px;"></div>

 <div class="row">
      <div class="col-xs-12">
        <div style="height:10px; "></div>
        <table border="0" class="table table-striped">
         <thead>
         <tr>
           <td colspan="6" style="text-align:center; font-size: 12px; font-weight:bold;">Software Developed By: AL-SYED Accountancy & Software Solution <br> Contact No. 0343-3000301</td>
         </tr>
        
         </thead>
        </table>   
      </div>
    </div>    
<!--     <div style=" text-align:center; border:0px solid;" class="col-xs-8">
    <div class="row">
      <div style="text-decoration: overline; border:0px solid;" class="col-xs-8">
        <p style="font-size:16px; font-weight:600; "></p>
      </div>
    </div>
    </div> -->
      <!-- /.col -->
    <!-- /.row -->
    
<!--     <div style="border:0px solid;" class="col-xs-4">
    <div class="row">
        <div style="text-decoration: overline; border:0px solid;" class="col-xs-12">
        <p style="font-size:16px; font-weight:600; ">Authorized Signature</p>
      </div>
    </div>
    </div> -->
 </section>
 </div>
 
 <?php // if($sDCReport == "true") { ?>
 <!-- Page Break code -->
 <div style="page-break-after:always"></div>
  
 
</body>
</html>