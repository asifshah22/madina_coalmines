<?php
if(empty($SaleInvoiceReport)) die('<div style="text-align:center; font-family:Calibri;">No record found.</div>'); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sales Tax Invoice</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <style>
    @media print {
      body {
        width: 100%;
        margin: 0;
        padding: 0.5cm;
        font-family: 'Calibri', Arial, sans-serif;
        color: #333;
      }
      .container {
        width: 100%;
        padding: 0;
      }
    }
    body {
      font-family: 'Calibri', Arial, sans-serif;
      padding: 10px;
    }
    .invoice-header {
      margin-bottom: 15px;
    }
    .invoice-title-box {
      background-color: #d9edf7;
      padding: 8px 12px;
      display: inline-block;
      border-radius: 4px;
      margin-top: 5px;
    }
    .invoice-title {
      font-size: 24px;
      font-weight: bold;
      color: #31708f;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin: 0;
      white-space: nowrap;
    }
    .detail-section {
      margin-bottom: 15px;
      padding: 10px;
      border: 1px solid #eee;
      border-radius: 4px;
      font-size: 13px;
    }
    .section-title {
      font-size: 15px;
      font-weight: bold;
      color: #31708f;
      border-bottom: 1px solid #eee;
      padding-bottom: 5px;
      margin-bottom: 8px;
    }
    .company-logo {
      max-height: 100px;
      max-width: 120px;
    }
    .invoice-info p {
      margin-bottom: 3px;
      font-size: 13px;
    }
    .detail-section p {
      margin-bottom: 5px;
      font-size: 13px;
    }
    .detail-section strong {
      color: #555;
      min-width: 120px;
      display: inline-block;
    }
    .row {
      margin-left: -5px;
      margin-right: -5px;
    }
    .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6,
    .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
      padding-left: 5px;
      padding-right: 5px;
    }
  </style>
</head>
<body>
<div class="wrapper">
  <section class="invoice">
    <!-- Header Section -->
    <div class="row invoice-header">
      <div class="col-xs-2">
        <img src="<?php echo base_url() ?>images/company-logo/<?php echo $GetSettingInformation[0]['CompanyLogo']; ?>" 
             alt="Company Logo" class="company-logo">
      </div>
      <div class="col-xs-5 invoice-info">
        <p><strong>Delivery Challan No:</strong> <?php echo $SaleInvoiceReport->SaleId; ?></p>
        <p><strong>Date:</strong> <?php echo date("d M, Y",strtotime($SaleInvoiceReport->SaleDate)); ?></p>
        <p><strong>Vehicle No:</strong> <?php echo $SaleInvoiceReport->SaleNote; ?></p>
       
        <p><strong>Transportation Name: </strong> <?php echo $SaleInvoiceReport->FullName; ?></p>
        
      </div>
<div class="col-xs-5 text-right">
    <div class="invoice-title-box" style="padding: 12px 20px;">
        <h2 class="invoice-title" style="font-size: 32px;">DELIVERY CHALLAN </h2>
    </div>
</div>

<style>
    @media print {
        .invoice-title-box {
            background-color: #333 !important;
            color: #fff !important;
            border: 2px solid #000 !important;
        }
        .invoice-title {
            color: #fff !important;
        }
    }
    .invoice-title-box {
        background-color: #d9eaf7;
        padding: 12px 20px;
        display: inline-block;
        border-radius: 6px;
        margin-top: 10px;
        border: 2px solid #31708f;
    }
    .invoice-title {
        font-size: 32px;
        font-weight: bold;
        color: #31708f;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin: 0;
        white-space: nowrap;
        text-shadow: 1px 1px 1px rgba(0,0,0,0.1);
    }
</style>
      </div>
    </div>

    <!-- Seller and Buyer Details -->
    <div class="row">
      <!-- Seller Details -->
      <div class="col-xs-6 detail-section">
        <div class="section-title">Seller Details</div>
        <p><strong>Business Name:</strong> AMAAD TRADERS</p>
        <p><strong>Address:</strong> Ofc# 1,P# 9078-9118 Block G,Ittehad Town,M.Khan Colony, KHI</p>
        <p><strong>Contact No:</strong> 0345-2213368</p>
        <p><strong>ST Registration No:</strong> 32-77-8762-280-86</p>
        <p><strong>NTN No:</strong> 5494230-0</p>
      </div>
      
      <!-- Buyer Details -->
<div class="col-xs-6 detail-section">
    <div class="section-title">Buyer Details</div>
    <p><strong>Business Name:</strong> <?php echo $SaleInvoiceReport->CustomerName; ?></span>
    <p><strong>Address:</strong><?php echo $SaleInvoiceReport->customerAddress; ?>
    <p><strong>ST Registration No:</strong> -----</p> 
    <p><strong>NTN No:</strong> -----</p>
    <p><strong>Registration Type:</strong> 
        <?php 
        if(!empty($AllSalesRecord['fbr_cnic']) || !empty($AllSalesRecord['fbr_ntn'])) {
            echo 'Unregistered';
        } else {
            echo 'Registered';
        }
        ?>
    </p>
</div>
  </section>
</div>
</body>
</html>
    <!-- Product Details Table -->
    <div class="row">
      <div class="col-xs-12">
        <table class="table table-striped" style="width:100%; border-collapse: collapse; margin-bottom: 15px; font-size:13px;">
          <thead>
            <tr style="background:#3c8dbc; color:#FFFFFF;">
              <th style="padding:8px; text-align:center; border:1px solid #ddd; font-weight:600; width:8%;">S#</th>
              <th style="padding:8px; text-align:left; border:1px solid #ddd; font-weight:600; width:40%;">P.O NO:</th>
              <th style="padding:8px; text-align:left; border:1px solid #ddd; font-weight:600; width:40%;">PRODUCT DETAILS</th>
              <th style="padding:8px; text-align:center; border:1px solid #ddd; font-weight:600; width:15%;">UOM</th>
              <th style="padding:8px; text-align:center; border:1px solid #ddd; font-weight:600; width:12%;">Qty</th>
              <!-- Rate, Amount, Discount, Net Amount columns are hidden as requested -->
            </tr>
          </thead>
          <tbody>
            <?php
            $TotalQuantity = 0;
            $TotalAmount = 0;
            $TotalDiscount = 0;
            $TotalNetAmount = 0;
            $SNo = 1;
            
            if(isset($SaleInvoiceReportDetails)) {
              $grossAmount = 0;
              $invoiceDiscount = 0;
              $k = 0;
              
              foreach($SaleInvoiceReportDetails as $row) {
                $grossAmount += $row['NetAmount'];
                $Particulars = $row['CategoryName'].' - '.$row['BrandName'].' - '.$row['ProductName'];
            ?>
            <tr>
              <td style="padding:8px; text-align:center; border:1px solid #ddd; font-weight:600;"><?php echo $SNo; ?></td>
              <td style="padding:8px; text-align:left; border:1px solid #ddd; font-weight:600;"><?php echo $row['BarCode']; ?></td>
              <td style="padding:8px; text-align:left; border:1px solid #ddd; font-weight:600;"><?php echo $Particulars; ?></td>
              <td style="padding:8px; text-align:center; border:1px solid #ddd; font-weight:600;"><?php echo $row['ProductGroupName']; ?></td>
              <td style="padding:8px; text-align:center; border:1px solid #ddd; font-weight:600;"><?php echo number_format($row['Quantity'],2); ?></td>
              <!-- Hidden columns: Rate, Amount, Discount, Net Amount -->
            </tr>
            <?php 
                $SNo++;
                $TotalQuantity += $row['Quantity'];
                $TotalAmount += $row['Amount'];
                $TotalDiscount += ($row['DiscountAmount'] + $row['TaxAmount']);
                $TotalNetAmount += $row['NetAmount'];
              }
            ?>
            <!-- Total Quantity Row -->
            <tr style="background:#f5f5f5; font-weight:bold;">
              <td colspan="4" style="padding:8px; text-align:right; border:1px solid #ddd;">TOTAL QTY:</td>
              <td style="padding:8px; text-align:center; border:1px solid #ddd;"><?php echo number_format($TotalQuantity,2); ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

<!-- Right Side: Authorized Signature -->
<div style="flex: 1; text-align: right;">
    <div style="display: inline-block; text-align: center;">
        <?php
            $signature_file = 'Handwritten_2025-09-10_121721.jpg'; // manually set your file name
            $signature_url  = base_url('images/signature/' . $signature_file);
        ?>
        <img src="<?php echo $signature_url; ?>"
             alt="Authorized Signature"
             style="width:180px; height:80px; object-fit:contain; margin-bottom:5px;">
        <div style="width:150px; border-top:1px solid #ddd; margin:0 auto;"></div>
        <p style="font-size:12px; color:#555; margin-top:5px; font-weight:600;">
            AUTHORIZED SIGNATURE
        </p>
    </div>
</div>

      
      <!-- Software By -->
      <div style="border-top: 1px dashed #ddd; padding-top: 10px;">
        <div style="font-size: 11px; color: #7f8c8d; text-align: center;">
           <span style="font-weight: 600; color: #2c3e50;"></span>
        </div>
      </div>
    </div>

  </section>
</div>

<!-- Page Break code -->
<div style="page-break-after:always"></div>

</body>
</html>