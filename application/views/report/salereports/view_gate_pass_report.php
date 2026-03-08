<?php
if(empty($SaleInvoiceReport)) die('<div style="text-align:center; font-family:Calibri;">No record found.</div>'); 
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Delivery Challan</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
<style>
  /* Reset & Base - Same as Invoice */
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }
  
  body {
    font-family: 'Calibri', Arial, sans-serif;
    color: #000;
    background: #f5f5f5;
    font-size: 10px;
    padding: 5px;
  }
  
  /* A4 Container - Single Page */
  .a4-container {
    width: 210mm;
    height: 297mm; /* Fixed A4 height */
    margin: 0 auto;
    background: white;
    padding: 5px;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
  }
  
  /* Print Button */
  .no-print {
    display: block;
  }
  
  .print-btn {
    position: fixed;
    top: 10px;
    left: 10px;
    background: #dc3545;
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 3px;
    font-weight: bold;
    font-size: 12px;
    cursor: pointer;
    z-index: 1000;
  }
  
  /* Copy Container - Half Page Each */
  .copy {
    width: 100%;
    border: 1px solid #ccc;
    padding: 8px;
    min-height: 145mm; /* Exactly half of A4 */
    height: 145mm;
    position: relative;
  }
  
  .original {
    border-bottom: none;
  }
  
  .duplicate {
    border-top: none;
  }
  
  /* Copy Label */
  .copy-label {
    font-weight: bold;
    font-size: 12px;
    margin-bottom: 5px;
    padding-bottom: 3px;
    border-bottom: 2px solid;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  
  .original .copy-label {
    color: #000;
    border-bottom-color: #000;
  }
  
  .duplicate .copy-label {
    color: #f0ad4e;
    border-bottom-color: #f0ad4e;
  }
  
  .copy-label-text {
    font-size: 14px;
    font-weight: bold;
    letter-spacing: 1px;
  }
  
  /* Top Row - Challan No & Title */
  .top-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
  }
  
  .challan-info {
    font-size: 11px;
    font-weight: bold;
  }
  
  .delivery-title {
    background: #31708f;
    color: white;
    padding: 5px 12px;
    font-weight: bold;
    font-size: 14px;
    border-radius: 3px;
    text-transform: uppercase;
  }
  
  /* Company & Customer Row */
  .company-customer-row {
    display: flex;
    gap: 10px;
    margin-bottom: 8px;
  }
  
  .company-info {
    flex: 1;
    font-size: 12px;
    line-height: 1.2;
  }
  
  .company-name {
    font-weight: bold;
    font-size: 14px;
    margin-bottom: 2px;
    color: #000;
  }
  
  .customer-box {
    flex: 1;
    border: 1px solid #000;
    border-radius: 3px;
    padding: 6px;
    background: #fff;
  }
  
  .customer-title {
    background: #28a745;
    color: white;
    display: inline-block;
    padding: 2px 8px;
    font-weight: bold;
    font-size: 10px;
    border-radius: 2px;
    margin-bottom: 5px;
  }
  
  .customer-detail {
    font-size: 9px;
    margin-bottom: 3px;
    line-height: 1.1;
  }
  
  .customer-label {
    font-weight: bold;
    min-width: 70px;
    display: inline-block;
  }
  
  /* Product Table - Fixed Column Sizes */
  .table-container {
    margin-bottom: 6px;
  }
  
  .product-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 8px;
    table-layout: fixed;
  }
  
  .product-table th {
    background: #31708f;
    color: white;
    padding: 4px 2px;
    text-align: center;
    font-weight: bold;
    border: 1px solid #ddd;
  }
  
  .product-table td {
    padding: 4px 2px;
    text-align: center;
    border: 1px solid #ddd;
    word-wrap: break-word;
  }
  
  .product-table td:nth-child(3) {
    text-align: left;
  }
  
  /* Fixed equal column widths for Delivery Challan */
  .product-table th:nth-child(1), .product-table td:nth-child(1) { width: 5%; }
  .product-table th:nth-child(2), .product-table td:nth-child(2) { width: 10%; }
  .product-table th:nth-child(3), .product-table td:nth-child(3) { width: 40%; }
  .product-table th:nth-child(4), .product-table td:nth-child(4) { width: 15%; }
  .product-table th:nth-child(5), .product-table td:nth-child(5) { width: 10%; }
  .product-table th:nth-child(6), .product-table td:nth-child(6) { width: 15%; }
  
  /* Total Row */
  .total-row td {
    background: #f8f9fa;
    font-weight: bold;
  }
  
  /* Footer Section - Fixed at bottom of each copy */
  .challan-footer {
    position: absolute;
    bottom: 8px;
    left: 8px;
    right: 8px;
    border-top: 1px solid #ddd;
    padding-top: 5px;
  }
  
  /* FBR Section in Footer */
  .fbr-section {
    border: 1px solid #ddd;
    border-radius: 3px;
    padding: 6px;
    background: #f8f9fa;
    margin-bottom: 5px;
  }
  
  .fbr-header {
    text-align: center;
    margin-bottom: 5px;
  }
  
  .fbr-main {
    font-weight: bold;
    font-size: 12px;
    color: #000;
    margin-bottom: 2px;
  }
  
  .fbr-sub {
    font-size: 10px;
    color: #3c8dbc;
    font-weight: 500;
  }
  
  .fbr-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .fbr-left {
    display: flex;
    align-items: center;
    gap: 6px;
  }
  
  .fbr-right {
    text-align: right;
  }
  
  .fbr-logo-box {
    width: 50px;
    height: 50px;
    border: 1px solid #ccc;
    padding: 2px;
    background: white;
  }
  
  .signature-box {
    text-align: center;
  }
  
  .signature-img {
    width: 120px;
    height: 45px;
    object-fit: contain;
    margin-bottom: 2px;
  }
  
  .signature-line {
    width: 100px;
    border-top: 1px solid #000;
    margin: 0 auto 2px;
  }
  
  .signature-text {
    font-size: 9px;
    font-weight: bold;
    color: #555;
  }
  
  /* Bottom Footer Info */
  .bottom-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 8px;
    color: #666;
    padding-top: 3px;
  }
  
  /* Cut Line Between Copies */
  .cut-line {
    position: absolute;
    left: 0;
    right: 0;
    top: 145mm;
    border-top: 2px dashed #dc3545;
    text-align: center;
    z-index: 100;
  }
  
  .cut-line-text {
    background: white;
    padding: 0 10px;
    color: #dc3545;
    font-size: 9px;
    font-weight: bold;
    position: relative;
    top: -7px;
  }
  
  /* Print Styles - Single Page */
  @media print {
    body {
      background: white;
      padding: 0;
      margin: 0;
    }
    
    .a4-container {
      box-shadow: none;
      padding: 0;
      width: 210mm;
      height: 297mm;
      margin: 0;
    }
    
    .no-print {
      display: none !important;
    }
    
    .copy {
      border: 1px solid #000;
      padding: 5mm;
      min-height: 145mm;
      height: 145mm;
      page-break-inside: avoid;
    }
    
    .original {
      border-bottom: 1px dashed #ccc;
    }
    
    .duplicate {
      border-top: none;
    }
    
    /* Ensure colors print */
    .delivery-title,
    .product-table th {
      background: #31708f !important;
      color: white !important;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
    
    .customer-title {
      background: #28a745 !important;
      color: white !important;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
    
    .cut-line {
      display: block !important;
      border-top: 2px dashed #000;
    }
    
    .cut-line-text {
      background: white !important;
      color: #000 !important;
    }
  }
  
  @page {
    size: A4 portrait;
    margin: 0;
  }

  /* Seller Box */
  .seller-box {
    flex: 1;
    border: 1px solid #000;
    border-radius: 3px;
    padding: 6px;
    background: #fff;
  }

  .seller-title {
    background: #31708f;
    color: white;
    display: inline-block;
    padding: 2px 8px;
    font-weight: bold;
    font-size: 10px;
    border-radius: 2px;
    margin-bottom: 5px;
  }
</style>
</head>
<body>

<button class="print-btn no-print" onclick="window.print()">🖨️ Print Challan (One Page)</button>

<div class="a4-container">
  <!-- Cut Line Between Copies -->
  <div class="cut-line no-print">
    <span class="cut-line-text">✂️ CUT HERE ✂️</span>
  </div>
  
  <!-- ORIGINAL COPY - TOP HALF -->
  <div class="copy original">
    <div class="copy-label">
      <span class="copy-label-text">COMPANY COPY</span>
    </div>
    
    <!-- Top Row: Challan No & Title -->
    <div class="top-row">
      <div class="challan-info">
        <div>Delivery Challan No: <strong><?php echo $SaleInvoiceReport->SaleId; ?></strong></div>
        <div>Date: <strong><?php echo date("d-M-Y H:i:s", strtotime($SaleInvoiceReport->SaleDate)); ?></strong></div>
        <div>P.O Number: <strong><?php echo $SaleInvoiceReport->SaleNote; ?></strong></div>
      </div>
      <div class="delivery-title">DELIVERY CHALLAN</div>
    </div>
    
    <!-- Seller & Buyer Info -->
    <div class="company-customer-row">
      <!-- Seller Info Left -->
      <div class="seller-box">
        <div class="seller-title">SELLER DETAILS</div>
        <div class="customer-detail">
          <span class="customer-label">Business Name:</span> AMAAD TRADERS
        </div>
        <div class="customer-detail">
          <span class="customer-label">Address:</span> Office# 1,Plot# .9078-9118,Block G,Ittehad Town,M.Khan Colony, Karachi
        </div>
        <div class="customer-detail">
          <span class="customer-label">Contact No:</span> 0345-2213368
        </div>
        <div class="customer-detail">
          <span class="customer-label">ST Reg No:</span> 32-77-8762-280-86
        </div>
        <div class="customer-detail">
          <span class="customer-label">NTN No:</span> 5494230-0
        </div>
      </div>
      
      <!-- Buyer Info Right -->
      <div class="customer-box">
        <div class="customer-title">BUYER DETAILS</div>
        <div class="customer-detail">
          <span class="customer-label">Business Name:</span> <?php echo $SaleInvoiceReport->CustomerName; ?>
        </div>
        <div class="customer-detail">
          <span class="customer-label">Address:</span> <?php echo $SaleInvoiceReport->fbr_customer; ?>
        </div>
        <div class="customer-detail">
          <span class="customer-label">ST Reg No:</span> <?php echo $SaleInvoiceReport->fbr_cnic; ?>
        </div>
        <div class="customer-detail">
          <span class="customer-label">NTN No:</span> <?php echo $SaleInvoiceReport->fbr_ntn; ?>
        </div>
        <div class="customer-detail">
          <span class="customer-label">Registration Type:</span> 
          <?php 
          if(!empty($SaleInvoiceReport->fbr_cnic) || !empty($SaleInvoiceReport->fbr_ntn)) {
              echo 'Unregistered';
          } else {
              echo 'Registered';
          }
          ?>
        </div>
      </div>
    </div>
    
    <!-- Product Table -->
    <div class="table-container">
      <table class="product-table">
        <thead>
          <tr>
            <th>S#</th>
            <th>Product Code</th>
            <th>Description</th>
            <th>HS CODE</th>
            <th>UOM</th>
            <th>Qty</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $totalQty = 0;
          $SNo = 1;
          
          if(isset($SaleInvoiceReportDetails)) {
              foreach($SaleInvoiceReportDetails as $row) {
                  $totalQty += $row['Quantity'];
          ?>
          <tr>
            <td><?php echo $SNo; ?></td>
            <td><?php echo isset($row['BarCode']) ? $row['BarCode'] : ''; ?></td>
            <td><?php echo $row['ProductName']; ?></td>
            <td><?php echo $row['EngineNo']; ?></td>
            <td><?php echo $row['ChassisNo']; ?></td>
            <td><?php echo number_format($row['Quantity'],2); ?></td>
          </tr>
          <?php
                  $SNo++;
              }
          }
          ?>
          <!-- Total Qty Row -->
          <tr class="total-row">
            <td colspan="5" style="text-align:right; font-weight:bold;">TOTAL QTY:</td>
            <td style="color:#008000; font-weight:bold;"><?php echo number_format($totalQty,2); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <!-- Footer Section - Fixed at bottom -->
    <div class="challan-footer">
      <!-- FBR Section -->
      <div class="fbr-section">
        <div class="fbr-header">
          <div class="fbr-main">FBR INTEGRATED INVOICE</div>
          <div class="fbr-sub">Invoice #<?php echo isset($SaleInvoiceReport->FbrNo) ? $SaleInvoiceReport->FbrNo : 'N/A'; ?></div>
        </div>
        
        <div class="fbr-content">
          <div class="fbr-left">
            <div class="fbr-logo-box">
              <img src="<?php echo base_url() ?>images/fbri.png" alt="FBR Logo" style="width:100%; height:100%; object-fit:contain;">
            </div>
          </div>
          
          <div class="fbr-right">
            <div class="signature-box">
              <?php if(isset($Settings) && !empty($Settings->signature)): ?>
                <img src="<?php echo base_url() ?>images/signature/<?php echo $Settings->signature; ?>" 
                     alt="Signature" class="signature-img">
              <?php else: ?>
                <div style="width:120px; height:45px; border:1px dashed #ccc; margin:0 auto 2px;"></div>
              <?php endif; ?>
              <div class="signature-line"></div>
              <div class="signature-text">AUTHORIZED SIGNATURE</div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Bottom Footer Info -->
      <div class="bottom-footer">
        <div>Generated: <?php echo date('d M Y H:i'); ?></div>
        <div>Powered by: <strong>ALSYED Software Solutions</strong> | ☎ 0333-9815033</div>
      </div>
    </div>
  </div>
  
  <!-- DUPLICATE COPY - BOTTOM HALF -->
  <div class="copy duplicate">
    <div class="copy-label">
      <span class="copy-label-text">CUSTOMER COPY</span>
    </div>
    
    <!-- Top Row: Challan No & Title -->
    <div class="top-row">
      <div class="challan-info">
        <div>Delivery Challan No: <strong><?php echo $SaleInvoiceReport->SaleId; ?></strong></div>
        <div>Date: <strong><?php echo date("d-M-Y H:i:s", strtotime($SaleInvoiceReport->SaleDate)); ?></strong></div>
        <div>P.O Number: <strong><?php echo $SaleInvoiceReport->SaleNote; ?></strong></div>
      </div>
      <div class="delivery-title">DELIVERY CHALLAN</div>
    </div>
    
    <!-- Seller & Buyer Info -->
    <div class="company-customer-row">
      <!-- Seller Info Left -->
      <div class="seller-box">
        <div class="seller-title">SELLER DETAILS</div>
        <div class="customer-detail">
          <span class="customer-label">Business Name:</span> AMAAD TRADERS
        </div>
        <div class="customer-detail">
          <span class="customer-label">Address:</span> Office# 1,Plot# .9078-9118,Block G,Ittehad Town,M.Khan Colony, Karachi
        </div>
        <div class="customer-detail">
          <span class="customer-label">Contact No:</span> 0345-2213368
        </div>
        <div class="customer-detail">
          <span class="customer-label">ST Reg No:</span> 32-77-8762-280-86
        </div>
        <div class="customer-detail">
          <span class="customer-label">NTN No:</span> 5494230-0
        </div>
      </div>
      
      <!-- Buyer Info Right -->
      <div class="customer-box">
        <div class="customer-title">BUYER DETAILS</div>
        <div class="customer-detail">
          <span class="customer-label">Business Name:</span> <?php echo $SaleInvoiceReport->CustomerName; ?>
        </div>
        <div class="customer-detail">
          <span class="customer-label">Address:</span> <?php echo $SaleInvoiceReport->fbr_customer; ?>
        </div>
        <div class="customer-detail">
          <span class="customer-label">ST Reg No:</span> <?php echo $SaleInvoiceReport->fbr_cnic; ?>
        </div>
        <div class="customer-detail">
          <span class="customer-label">NTN No:</span> <?php echo $SaleInvoiceReport->fbr_ntn; ?>
        </div>
        <div class="customer-detail">
          <span class="customer-label">Registration Type:</span> 
          <?php 
          if(!empty($SaleInvoiceReport->fbr_cnic) || !empty($SaleInvoiceReport->fbr_ntn)) {
              echo 'Unregistered';
          } else {
              echo 'Registered';
          }
          ?>
        </div>
      </div>
    </div>
    
    <!-- Product Table -->
    <div class="table-container">
      <table class="product-table">
        <thead>
          <tr>
            <th>S#</th>
            <th>Product Code</th>
            <th>Description</th>
            <th>HS CODE</th>
            <th>UOM</th>
            <th>Qty</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $totalQty = 0;
          $SNo = 1;
          
          if(isset($SaleInvoiceReportDetails)) {
              foreach($SaleInvoiceReportDetails as $row) {
                  $totalQty += $row['Quantity'];
          ?>
          <tr>
            <td><?php echo $SNo; ?></td>
            <td><?php echo isset($row['BarCode']) ? $row['BarCode'] : ''; ?></td>
            <td><?php echo $row['ProductName']; ?></td>
            <td><?php echo $row['EngineNo']; ?></td>
            <td><?php echo $row['ChassisNo']; ?></td>
            <td><?php echo number_format($row['Quantity'],2); ?></td>
          </tr>
          <?php
                  $SNo++;
              }
          }
          ?>
          <!-- Total Qty Row -->
          <tr class="total-row">
            <td colspan="5" style="text-align:right; font-weight:bold;">TOTAL QTY:</td>
            <td style="color:#008000; font-weight:bold;"><?php echo number_format($totalQty,2); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <!-- Footer Section - Fixed at bottom -->
    <div class="challan-footer">
      <!-- FBR Section -->
      <div class="fbr-section">
        <div class="fbr-header">
          <div class="fbr-main">FBR INTEGRATED INVOICE</div>
          <div class="fbr-sub">Invoice #<?php echo isset($SaleInvoiceReport->FbrNo) ? $SaleInvoiceReport->FbrNo : 'N/A'; ?></div>
        </div>
        
        <div class="fbr-content">
          <div class="fbr-left">
            <div class="fbr-logo-box">
              <img src="<?php echo base_url() ?>images/fbri.png" alt="FBR Logo" style="width:100%; height:100%; object-fit:contain;">
            </div>
          </div>
          
          <div class="fbr-right">
            <div class="signature-box">
              <?php if(isset($Settings) && !empty($Settings->signature)): ?>
                <img src="<?php echo base_url() ?>images/signature/<?php echo $Settings->signature; ?>" 
                     alt="Signature" class="signature-img">
              <?php else: ?>
                <div style="width:120px; height:45px; border:1px dashed #ccc; margin:0 auto 2px;"></div>
              <?php endif; ?>
              <div class="signature-line"></div>
              <div class="signature-text">AUTHORIZED SIGNATURE</div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Bottom Footer Info -->
      <div class="bottom-footer">
        <div>Generated: <?php echo date('d M Y H:i'); ?></div>
        <div>Powered by: <strong>ALSYED Software Solutions</strong> | ☎ 0333-9815033</div>
      </div>
    </div>
  </div>
</div>
</body>
</html>