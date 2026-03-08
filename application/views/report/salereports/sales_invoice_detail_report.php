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
<body>
<?php

if(empty($SalesInvoiceDetailReport)) die('<div style="text-align:center;">Please enter Invoice No</div>'); 

// Report Checkboxes Values
$CompanyWarranty = $this->input->get('CompanyWarranty');
$InvoiceDate = $this->input->get('InvoiceDate');
$sProductName = $this->input->get('ProductName');
$sBatch = $this->input->get('Batch');
$sMfgDate = $this->input->get('MfgDate');
$sExpiryDate = $this->input->get('ExpiryDate');
$sDCReport = $this->input->get('DCReport');
$sMfgName = $this->input->get('MfgName');
    
if($SalesInvoiceDetailReport[0]['InvoiceDate'])
$sInvoiceDate = date('M d, Y',strtotime($SalesInvoiceDetailReport[0]['InvoiceDate']));
else
$sInvoiceDate = '_____/_____/_________';
?>
 
    
 <div class="wrapper">
 <!-- Main content --> 
 <div style="page-break-after:always"></div> 
 
 <section class="invoice">
  <!-- title row -->
  <div class="box-header">
    <center>      
      <h3 style="color:black; font-family:Georgia; font-weight:600;" class="box-title">Sunny Paper Mills
      </h3>
<!--       <span class="pull-right" style="font-size:13px; font-family: Arial, Helvetica, sans-serif;"><a href="#" class="" id="SendMail" data-toggle="modal" data-target="#myModal" style="color:green">Email</a> &nbsp; &nbsp;<a href="#" style="color:green" onclick="window.print();">Print</a> &nbsp; &nbsp;</span> -->
      <p style="font-weight: 600; margin-right: 2%;"> PLOT # E/28 SITE AREA HYDERABAD</p>
    </center>
           </div> 
   
    <div class="row">
      <div class="col-xs-12">
        <div style="height:10px; "></div>
        <table border="0" class="table table-striped">
         <thead>
         <tr>
           <td colspan="2" style="text-align:center; font-size: 26px; font-weight:bold;">SALES TAX INVOICE</td>
         </tr>
          <tr>
           <td style="text-align:right; font-size: 16px; font-weight:600;">NTN #: <?php echo "1547769-0"; // $SalesInvoiceDetailReport[0]['NTN']; ?></td>
         </tr>
         </thead>
        </table>   
      </div>
    </div>
    <!-- info row -->
    
    <div class="row invoice-info">
      <div class="col-sm-12">
        <address>
         <p style="font-size:16px;">Customer Name:<span style="font-size:16px; font-weight:600;"> <?php echo $SalesInvoiceDetailReport[0]['CustomerName']; ?></span>
          <span class="pull-right" style="font-size:16px;">INV #: <label style="font-weight: 600"> <?php echo $SalesInvoiceDetailReport[0]['InvoiceNumber']; ?></label></span>
         </p>
         <p style="font-size:16px;">Address: <span style="font-size:16px; font-weight:600;"><?php echo $SalesInvoiceDetailReport[0]['Address']; ?></span>
          <span class="pull-right" style="font-size:16px;">Date:  <label style="font-weight: 600">  <?php echo $SalesInvoiceDetailReport[0]['InvoiceDate']; ?></label></span>
         </p>
         <div style="height: 30px;"></div>
         <p style="font-size:16px;">NTN No: <span style="font-size:16px; font-weight:600;"><?php echo $SalesInvoiceDetailReport[0]['NTN']; ?></span></p>
         <?php // } ?>
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
           <tr>
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid;">S#</th>
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:auto;">Description of Goods</th>
            <?php if($sBatch=="true") { ?> 
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:auto;">BATCH NO</th> 
            <?php } if($sMfgDate=="true") { ?> 
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:auto;">MFG: DATE</th> 
            <?php } if($sExpiryDate=="true") { ?> 
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:auto;">EXPIRY DATE</th> 
            <?php } if($sMfgName=="true") { ?>
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:auto;">MFG:</th>
            <?php } ?>            
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:auto;">QTY (KG)</th>
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:auto;">RATE </th>
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:auto;">VALUE (Exc Tax)</th>
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:auto;">GST %</th>
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:auto;">GST (Rs)</th>
            <th style="font-size:15px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid; width:auto;">VALUE (Inc Tax)</th>
           </tr>
          </thead>
          <tbody>
          <?php
          $TotalAmount = 0;
          $TotalWeight = 0;
          $TotalExcTax = 0;
          $TotalIncTax = 0;
          $GrandTotal = 0;
	  $SNo=1;
	  if(isset($SalesInvoiceDetailReport)) {
          foreach($SalesInvoiceDetailReport as $row) {
           
          $Particulars = $row['ProductName'].' - '.$row['ProductQuality'];
	  ?>
          <tr>
            <td style="font-size:14px; font-weight:600; text-align:center;"><?php echo $SNo; ?></td>
            <td style="font-size:14px; font-weight:600; text-align:left;"><?php echo $Particulars; ?></td>
            <td style="font-size:14px; font-weight:600; text-align:center;"><?php echo number_format($row['Weight'],2); ?></td>
            <td style="font-size:14px; font-weight:600; text-align:center;"><?php echo number_format($row['Rate'],2); ?></td>
            <td style="font-size:14px; font-weight:600; text-align:center;"><?php if($row['Weight'] != 0) { 
             echo $ExcTax = ($row['Weight'] * $row['Rate']); } else{ echo $ExcTax = $row['Rate']; } ?></td>
            <td style="font-size:14px; font-weight:600; text-align:center;"><?php echo number_format($row['GST'],2); ?></td>
             <td style="font-size:14px; font-weight:600; text-align:center;"><?php if($row['GST'] != 0) {
             echo $IncTax = ($ExcTax % $row['GST']); } else{ echo $IncTax = $ExcTax; } ?></td>
             <td style="font-size:14px; font-weight:600; text-align:center;"><?php  echo number_format(($ExcTax + $IncTax),2); ?></td>
           </tr>
           <?php $SNo++;
           $TotalWeight += $row['Weight'];
           $TotalExcTax += $ExcTax;
           $TotalIncTax += $IncTax;
           $GrandTotal += ($ExcTax + $IncTax);
           } ?>
           <tr style="">
             <td style="text-align:right; font-size:14px; font-weight:bold; border-bottom:1px solid; border-top:1px solid;"></td>
             <td style="text-align:left; font-size:14px; font-weight:bold; text-align:right; border-bottom:1px solid; border-top:1px solid;">Total Rs.</td>
             <td style="text-align:left; font-size:14px; font-weight:bold; text-align:center; border-bottom:1px solid; border-top:1px solid;"><?php echo number_format($TotalWeight,2); ?></td>
             <td style="text-align:right; font-size:14px; font-weight:bold; border-bottom:1px solid; border-top:1px solid;"></td>
             <td style="text-align:center; font-size:14px; font-weight:bold; border-bottom:1px solid; border-top:1px solid;"><?php echo number_format($TotalExcTax,2); ?></td>
             <td style="text-align:right; font-size:14px; font-weight:bold; border-bottom:1px solid; border-top:1px solid;"></td>
             <td style="text-align:center; font-size:14px; font-weight:bold; border-bottom:1px solid; border-top:1px solid;"><?php echo number_format($TotalIncTax,2); ?></td>
             <td style="text-align:center; font-size:14px; font-weight:bold; border-bottom:1px solid; border-top:1px solid;"><?php echo number_format($GrandTotal,2); ?></td>
           </tr>
          </tbody>
        </table>
        <?php } ?>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <div style="height:52px;"></div>
    <?php if($CompanyWarranty=='true') { ?>  
    <div class="row">
      <div class="col-xs-8">
        <p style="font-size:16px; font-weight:600; ">WARRANTY UNDER SECTION 23 OF THE DRUG ACT 1976:</p>
        <p style="margin-top: 10px; font-size: 14px;">
         <?php echo $SalesInvoiceDetailReport[0]['TermsCondition']; ?>
        </p>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <?php } ?>
    <div style="height:5px;"></div>
    
<!--     <div style=" text-align:center; border:0px solid;" class="col-xs-8">
    <div class="row">
      <div style="text-decoration: overline; border:0px solid;" class="col-xs-8">
        <p style="font-size:16px; font-weight:600; "></p>
      </div>
    </div>
    </div> -->
      <!-- /.col -->
    <!-- /.row -->
    
    <div style="border:0px solid;" class="col-xs-4">
    <div class="row">
        <div style="text-decoration: overline; border:0px solid;" class="col-xs-12">
        <p style="font-size:16px; font-weight:600; ">Authorized Signature</p>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
 </section>
 </div>
 
 <?php if($sDCReport == "true") { ?>
 <!-- Page Break code -->
 <div style="page-break-after:always"></div>
  
 <div class="wrapper">
 <section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
         <div style="height:150px; "></div>  
         <table border="0" class="table table-striped">
          <thead>
          <tr>
            <td style="text-align:left; font-size: 16px; font-weight:600;">Delivery Challan <?php echo $SalesInvoiceDetailReport[0]['InvoiceNumber']; ?></td>
            <td style="text-align:right; font-size: 16px; font-weight:600;">DC Date: <?php echo $sInvoiceDate; ?></td>
          </tr>
          <tr>
            <td colspan="2" style="text-align:center; font-size: 26px; font-weight:bold;">Delivery Challan</td>
          </tr>
          </thead>
        </table>
        </div>
    </div>
    <!-- info row -->    
    <div class="row invoice-info">
      <div class="col-sm-12">
        <address>
          <p style="font-size:16px;">Customer Name: <span style="font-size:16px; font-weight:600;"><?php echo $SalesInvoiceDetailReport[0]['CustomerName']; ?></span></p>
          <p style="font-size:16px;">Order No: <span style="font-size:16px; font-weight:600;"><?php echo $SalesInvoiceDetailReport[0]['CustomerOrderNo']; ?></span></p>
          <p style="font-size:16px;">Order Date: <span style="font-size:16px; font-weight:600;"><?php echo date('M d, Y', strtotime($SalesInvoiceDetailReport[0]['OrderDate'])); ?></span></p>
          <?php if($SalesInvoiceDetailReport[0]['ShipTo'] != '') { ?>
          <p style="font-size:16px;">Delivered To: <span style="font-size:16px; font-weight:600;"><?php echo $SalesInvoiceDetailReport[0]['ShipTo']; ?></span></p>
          <?php } ?>
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
           <tr>
            <th style="font-size:16px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid;">S#</th>
            <th style="font-size:16px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid;">PARTICULARS</th>
            <?php if($sBatch=="true") { ?> 
            <th style="font-size:16px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid;">BATCH NO</th> 
            <?php } if($sMfgDate=="true") { ?> 
            <th style="font-size:16px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid;">MFG: DATE</th> 
            <?php } if($sExpiryDate=="true") { ?> 
            <th style="font-size:16px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid;">EXPIRY DATE</th> 
            <?php } if($sMfgName=="true") { ?>
            <th style="font-size:16px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid;">MFG:</th>
            <?php } ?>
            <th style="font-size:16px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid;">QTY</th>
            <th style="font-size:16px; font-weight:600; text-align:center; border-bottom:1px solid; border-top:1px solid;">REMARKS</th>
           </tr>
          </thead>
          <tbody>
          <?php
          $TotalAmount = 0;
	  $SNo=1;
	  if(isset($SalesInvoiceDetailReport)) {
          foreach($SalesInvoiceDetailReport as $row) {
           
          if($sProductName == "true")
          $Particulars = $row['ProductGroupName'].' - '.$row['BrandName'];
          else
          $Particulars = $row['ProductGroupName'];         
	  ?>
          <tr>
            <td style="font-size:14px; font-weight:600; text-align:center;"><?php echo $SNo; ?></td>
            <td style="font-size:14px; font-weight:600; text-align:left;"><?php echo $Particulars; ?></td>
            <?php if($sBatch=="true") { ?>
            <td style="font-size:14px; font-weight:600; text-align:center;"><?php echo $row['BatchNumber']; ?></td>
            <?php } if($sMfgDate=="true") { ?> 
            <td style="font-size:14px; font-weight:600; text-align:center;"><?php echo $row['ManufactureDate']; ?></td>
            <?php } if($sExpiryDate=="true") { ?>
            <td style="font-size:14px; font-weight:600; text-align:center;"><?php echo $row['ExpireDate']; ?></td>
            <?php } if($sMfgName=="true") { ?>
            <td style="font-size:14px; font-weight:600; text-align:center;"><?php echo $MfgName = $row['ManufactureName'] != '' ? $row['ManufactureName'] : ''; ?></td>
            <?php } ?>            
            <td style="font-size:14px; font-weight:600; text-align:center;"><?php echo $row['UoM'] != 0 ? $row['Quantity'] / $row['UoM'].' (PKTS)' : $row['Quantity']; ?></td>
            <td style="font-size:14px; font-weight:600; text-align:center;">&nbsp;</td>
           </tr>
           <?php $SNo++; $TotalAmount += $row['Amount']; } ?>
          </tbody>
        </table>
        <?php } ?>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <div style="height:190px;"></div>
    
    <div style=" text-align:center;" class="col-xs-6">
    <div class="row">
      <div style="text-decoration: overline;" class="col-xs-8">
        <p style="font-size:16px; font-weight:600; ">Customer 's Signature</p>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    
    <div style="text-align: right;" class="col-xs-6">
    <div class="row">
      <div style="text-decoration: overline;" class="col-xs-8">
        <p style="font-size:16px; font-weight:600; ">Authorized Signature</p>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
 <?php } ?>
</body>
</html>