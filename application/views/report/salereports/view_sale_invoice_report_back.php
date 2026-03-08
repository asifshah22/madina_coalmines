<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sales Invoice Detail Report</title>
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
<style>
@media print {
    body{
        width: 21cm;
        height: 29.7cm;
        margin: 0px 1000mm 5000mm 10mm; 
        /* change the margins as you want them to be. */
   } 
}
</style>
<body>
<?php

// print_r($SaleInvoiceReport);

if(empty($SaleInvoiceReport)) die('<div style="text-align:center;">No record found.</div>'); 


$SaleType = '';

if($SaleInvoiceReport->SaleType == 1) {
    $SaleType = 'Cash';
}
if($SaleInvoiceReport->SaleType == 2) {
    $SaleType = 'Credit';
}
if($SaleInvoiceReport->SaleType == 3) {
    $SaleType = 'Online';
}


/*if($SaleInvoiceReportDetails[0]['InvoiceDate'])
$sInvoiceDate = date('M d, Y',strtotime($SaleInvoiceReportDetails[0]['InvoiceDate']));
else
$sInvoiceDate = '_____/_____/_________';*/
?>
 
    
 <div class="wrapper">
 <!-- Main content --> 
 <div style="page-break-after:always"></div> 
 
 <section class="invoice">

 <div class="box-header">
      <span class="pull-right" style="font-size:13px; font-family: Arial, Helvetica, sans-serif;"><a href="#" class="" id="SendMail" data-toggle="modal" data-target="#myModal" style="color:green">Email</a> &nbsp; &nbsp;<a href="#" style="color:green" onclick="window.print();">Print</a> &nbsp; &nbsp;</span>

  </div>

  <div class="col-xs-12 col-sm-12">
      <img src="<?php echo base_url() ?>images/company-logo/<?php echo $GetSettingInformation[0]['CompanyLogo']; ?>" alt="" width="100" class="img-fluid">
      <div class="col-sm-3 pull-right">
        <p style="text-align:center; font-size: 26px; font-weight:bold;">SALES INVOICE</p>
        <address>
         <p style="font-size:16px;">Invoice No:  <label style="font-weight: 600">  <?php echo $SaleInvoiceReport->SaleId; ?></label>
          <span class="pull-right" style="font-size:16px;">User ID: <span style="font-size:16px; font-weight:600;"><?php echo $GetSettingInformation[0]['ContactPerson']; ?></span></span>
         </p>
         <p style="font-size:16px;">Date: <span style="font-size:16px; font-weight:600;"><?php echo date("M d, Y H:i:s",strtotime($SaleInvoiceReport->SaleDate)); ?></span>
         </p>
         <p style="font-size:16px;">Customer Name:<span style="font-size:16px; font-weight:600;"> <?php echo $SaleInvoiceReport->CustomerName; ?></span>
         </p>
         <!-- <div style="height: 3px;"></div>
         <p style="font-size:16px;">Payment Type: <span style="font-size:16px; font-weight:600;"><?php //echo $SaleType; ?></span></p> -->
         <?php // // } ?>
        </address>
      </div>
  <div class="box-header">
     
      <p style="font-weight: 600; margin-right: 2%;"> <?php echo $GetSettingInformation[0]['Address']."- Phone no. ".$GetSettingInformation[0]['ContactNumber']; ?></p>

  </div> 
  
  </div>
    <!-- /.row -->
    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table border="0" class="table table-striped">
          <thead>
            <tr style="background:#3c8dbc; font-size:14px; color:#FFFFFF;">
            <th style="font-size:14px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid;width:1%">S#</th>
            <th style="font-size:14px; font-weight:600; text-align:left; border-bottom:1px solid; border-top:1px solid; width:16%;">PRODUCT DETAILS</th>
            <th style="font-size:14px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:8%;">Packing</th> 
            <th style="font-size:14px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:8%">Qty</th> 
            <th style="font-size:14px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:8%">RATE</th> 
            <th style="font-size:14px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:8%">AMOUNT</th> 
            <th style="font-size:14px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:8%">DISCOUNT</th>
            <th style="font-size:14px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:8%">NET AMOUNT</th>
           </tr>
          </thead>
          <tbody>
          <?php //
          $TotalQuantity = 0;
          $TotalAmount = 0;
          $TotalDiscount = 0;
          $TotalNetAmount = 0;
	  $SNo=1;
	  if(isset($SaleInvoiceReportDetails)) {
        $grossAmount = 0;
        $invoiceDiscount = 0;
        $k = 0;
          foreach($SaleInvoiceReportDetails as $row) {
            $grossAmount += $row['NetAmount'];
            $invoiceDiscount = $row['TotalDiscount'];
           
          $Particulars = $row['CategoryName'].' - '.$row['BrandName'].' - '.$row['ProductName'];
	  ?>
          <tr>
            <td style="font-size:13px; font-weight:600; text-align:center;"><?php echo $SNo; ?></td>
            <td style="font-size:13px; font-weight:600; text-align:left;"><?php echo $Particulars; ?></td>
            <td style="font-size:13px; font-weight:600; text-align:center;"><?php echo $row['ProductGroupName']; ?></td>
            <td style="font-size:13px; font-weight:600; text-align:center;"><?php echo number_format($row['Quantity'],2); ?></td>
            <td style="font-size:13px; font-weight:600; text-align:center;"><?php echo number_format($row['Rate'],2); ?></td>
            <td style="font-size:13px; font-weight:600; text-align:center;"><?php echo number_format($row['Amount'],2); ?></td>
             <td style="font-size:13px; font-weight:600; text-align:center;"><?php echo ($row['DiscountAmount'] + $row['TaxAmount']); ?></td>
             <td style="font-size:13px; font-weight:600; text-align:center;"><?php echo number_format(($row['NetAmount']),2); ?></td>
           </tr>
           <?php $SNo++;
           $TotalQuantity += $row['Quantity'];
           $TotalAmount += $row['Amount'];
           $TotalDiscount += ($row['DiscountAmount'] + $row['TaxAmount']);
           $TotalNetAmount += $row['NetAmount'];
           $convertArray   = ($ReceivedCashAmount != null) ? (array) $ReceivedCashAmount['GeneralJournalEntries'] : null;
           $cashRecieved   =  ($convertArray != null) ? $convertArray[0]['Credit'] : 0;
           $ar             = ($SaleInvoices) ? $LastBalance : 0;
           
           $currentBalance = ($ar + ($grossAmount - $invoiceDiscount)) - $cashRecieved;
         
           } 
           ?>
           <tr>
	    <td></td>
            <td style="font-size:12px; font-weight:bold;">Previous Balance</td>
            <td style="text-align:center; font-size:12px; font-weight:bold; border-bottom:1px solid; border-top:1px solid;">
            <?php echo number_format($ar, 2); ?>
            </td>
            <td colspan="3"></td>
            <td style="font-size:12px; font-weight:bold;">Gross Amount</td>
            <td style="text-align:center; font-size:12px; font-weight:bold; border-bottom:1px solid; border-top:1px solid;"><?php echo number_format($grossAmount,2); ?></td>
           </tr>
           <tr>
	    <td></td>
            <td style="font-size:12px; font-weight:bold;">Current Inv Amount</td>
            <td style="text-align:center; font-size:12px; font-weight:bold;"><?php echo number_format(($grossAmount - $invoiceDiscount), 2); ?></td>
            
	    <td colspan="3"></td>
            <td style="font-size:12px; font-weight:bold;">Invoice Discount</td>
            <td style="text-align:center; font-size:12px; font-weight:bold;"><?php echo number_format($invoiceDiscount, 2); ?></td>
           </tr>
	   <tr>
	    <td></td>
            <td style="font-size:12px; font-weight:bold;">Received Cash</td>
            <td style="text-align:center; font-size:12px; font-weight:bold; border-top:1px solid;">
            <?php echo number_format($cashRecieved, 2); ?></td>
            <td colspan="3"></td>
            <td style="font-size:12px; font-weight:bold;background-color: #3c8dbc;color:white;">Net Amount</td>
            <td style="background-color: #3c8dbc;text-align:center; font-size:12px; font-weight:bold;color:white;"><?php echo number_format(($grossAmount - $invoiceDiscount), 2); ?></td>
           </tr>
           <tr style="background-color: #3c8dbc;">
            <td></td>
	    <td style="font-size:12px; font-weight:bold; color:white;">Current Balance</td>
            <td style="text-align:center; font-size:12px; font-weight:bold;color:white;"><?php echo number_format($currentBalance, 2); ?></td>
	    
           </tr>
      
           <tr style="margin-top:100px;">
            <td style="text-align:right; font-size:12px; font-weight:bold;"></td>
           </tr>
          </tbody>
        </table>
        <?php } ?>
      </div>
      <!-- /.col -->
    </div>
    <div class="box-header">
      <span class="pull-right" style="font-size:13px; font-family: Arial, Helvetica, sans-serif;font-weight:bold;margin-top: 10px;">AUTHORIZED SIGNATURE</span>

    </div>
    <!-- /.row -->
    <div style="height:52px;"></div>
    <?php // if($CompanyWarranty=='true') { ?>  
    <!-- <div class="row">
      <div class="col-xs-8">
        <p style="font-size:16px; font-weight:600; ">NOTE:</p>
        <p style="margin-top: 10px; font-size: 14px;">
         <?php //echo $SaleInvoiceReport->SaleNote ?>
        </p>
      </div> -->
      <!-- /.col -->
    <!-- </div> -->
    <!-- /.row -->
    <?php // } ?>
    <!-- <div style="height:50px;"></div> -->

 <div class="row">
      <div class="col-xs-12">
        <div style="height:5px; "></div>
        <table border="0" class="table table-striped">
         <thead>
         <tr>
           <td colspan="6" style="text-align:center; font-size: 12px; font-weight:bold;">Software Developed By: AL-SYED Accountancy & Software Solution <br> Contact No. 0343-3000301</td>
         </tr>
        
         </thead>
        </table>   
      </div>
    </div>    

 </section>
 </div>
 
 <?php // if($sDCReport == "true") { ?>
 <!-- Page Break code -->
 <div style="page-break-after:always"></div>
  
 
</body>
</html>