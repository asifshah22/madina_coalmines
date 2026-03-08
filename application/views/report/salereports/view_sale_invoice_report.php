<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Sales Tax Invoice</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
<style>
  /* Reset & Base */
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
  
  /* Top Row - Invoice No & Title */
  .top-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
  }
  
  .invoice-info {
    font-size: 11px;
    font-weight: bold;
  }
  
  .sales-tax-title {
    background: #000;
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
    font-size: 14px; /* Increased font size */
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
    background: #000;
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
  
  .product-table td:nth-child(2) {
    text-align: left;
  }
  
  /* Fixed equal column widths */
  .product-table th:nth-child(1), .product-table td:nth-child(1) { width: 4%; }
  .product-table th:nth-child(2), .product-table td:nth-child(2) { width: 24%; }
  .product-table th:nth-child(3), .product-table td:nth-child(3) { width: 8%; }
  .product-table th:nth-child(4), .product-table td:nth-child(4) { width: 6%; }
  .product-table th:nth-child(5), .product-table td:nth-child(5) { width: 7%; }
  .product-table th:nth-child(6), .product-table td:nth-child(6) { width: 6%; }
  .product-table th:nth-child(7), .product-table td:nth-child(7) { width: 5%; } /* QTY fixed */
  .product-table th:nth-child(8), .product-table td:nth-child(8) { width: 8%; }
  .product-table th:nth-child(9), .product-table td:nth-child(9) { width: 7%; }
  .product-table th:nth-child(10), .product-table td:nth-child(10) { width: 7%; }
  .product-table th:nth-child(11), .product-table td:nth-child(11) { width: 7%; }
  .product-table th:nth-child(12), .product-table td:nth-child(12) { width: 11%; }
  
  /* Total Row */
  .total-row td {
    background: #f8f9fa;
    font-weight: bold;
  }
  
  /* Amount in Words */
  .amount-words {
    padding: 5px;
    background: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 2px;
    font-size: 9px;
    margin-bottom: 6px;
    line-height: 1.2;
    min-height: 25px;
  }
  
  /* Footer Section - Fixed at bottom of each copy */
  .invoice-footer {
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
  
  .qrcode-box, .fbr-logo-box {
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
    .sales-tax-title,
    .product-table th {
      background: #000 !important;
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
</style>
</head>
<body>

<button class="print-btn no-print" onclick="window.print()">🖨️ Print Invoice (One Page)</button>

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
    
    <!-- Top Row: Invoice No & Title -->
    <div class="top-row">
      <div class="invoice-info">
        <div>Invoice No: <strong><?php echo $SaleInvoiceReport->SaleId; ?></strong></div>
        <div>Date: <strong><?php echo date("d-M-Y", strtotime($SaleInvoiceReport->SaleDate)); ?></strong></div>
      </div>
      <div class="sales-tax-title">SALES TAX INVOICE</div>
    </div>
    
    <!-- Company & Customer Info -->
    <div class="company-customer-row">
      <!-- Company Info Left -->
      <div class="company-info">
        <h2 style="font-weight: bold; margin:0; padding:0; font-size: 32px; font-family: Calibri;">
    MADINA COAL MINES
</h2>
        PLOT NO.121, NEAR BANK AL HABIB, NEW TRUCK STAND, HALA NAKA ROAD,<br>
        Hyderabad<br>
        
        <span style="
        background:#000;
        color:#fff;
        padding:2px 6px;
        font-weight:bold;
        border-radius:3px;
        display:inline-block;
        margin-top:2px;
    ">
      NTN: B304069-4 | STRN: 3277876341783
    </span>

  </div>
      
      <!-- Customer Info Right -->
      <div class="customer-box">
        <div class="customer-title">CUSTOMER INFORMATION</div>
        <div class="customer-detail">
          <span class="customer-label">Name:</span> <?php echo $SaleInvoiceReport->CustomerName; ?>
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
          <span class="customer-label">Type:</span> <?php echo $SaleInvoiceReport->AreaId; ?>
        </div>
      </div>
    </div>
    
<!-- Product Table -->
<div class="table-container">
  <table class="product-table">
    <thead>
      <tr>
        <th>S#</th>
        <th>Description</th>
        <th>TON</th>
        <th>T/Rate</th>

        <th style="display:none;">Rate</th> <!-- HIDDEN -->

        <th>GST %</th>

        <th style="display:none;">Qty</th>  <!-- HIDDEN -->

        <th>Value Ex. ST</th>
        <th>GST Amt</th>
        <th>F.Tax %</th>
        <th>F.Tax Amt</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>

          <?php
          $grandTotal = 0;
          $totalEngineNo = 0;
          $totalValueExST = 0;
          $totalTaxPercentageAmount = 0;
          $totalFurtherTaxAmt = 0;
          $SNo = 1;
          
          if(isset($SaleInvoiceReportDetails)) {
            foreach($SaleInvoiceReportDetails as $row) {
              $lineTotal = $row['NetAmount'];
              $valueExST = $row['Rate'] * $row['Quantity'];
              $grandTotal += $lineTotal;
              $totalTaxPercentageAmount += $row['TaxPercentage'];
              $totalEngineNo += $row['EngineNo'];
              $totalValueExST += $valueExST;
              $totalFurtherTaxAmt += $row['FurtherTaxAmt'];
          ?>
          <tr>
    <td><?php echo $SNo; ?></td>
    <td>
    <strong><?php echo $row['ProductName']; ?></strong>
    <br>
    <span style="font-size:10px; color:#555;">
        HS CODE: <?php echo $row['OpeningStock']; ?> |
        UOM: <?php echo $row['ProductGroupName']; ?>
    </span>
</td>

    <td><?php echo $row['EngineNo']; ?></td>
    <td><?php echo $row['ChassisNo']; ?></td>

    <td style="display:none;"><?php echo number_format($row['Rate'], 2); ?></td> <!-- HIDDEN -->

    <td><?php echo $row['DiscountAmount']; ?>%</td>

    <td style="display:none;"><?php echo number_format($row['Quantity'],2); ?></td> <!-- HIDDEN -->

    <td><?php echo number_format($valueExST, 2); ?></td>
    <td><?php echo number_format($row['TaxPercentage'],2); ?></td>
    <td><?php echo number_format($row['FurtherTaxRate'],2); ?>%</td>
    <td><?php echo number_format($row['FurtherTaxAmt'],2); ?></td>
    <td><?php echo number_format($lineTotal,2); ?></td>
</tr>

          <?php
              $SNo++;
            }
          }
          ?>
          <tr class="total-row">
            <td colspan="4" style="text-align:right; font-weight:bold;">TOTAL:</td>
            <td><strong><?php echo number_format($totalEngineNo, 2) . ' TON'; ?></strong></td>
            <td><?php echo number_format($totalValueExST,2); ?></td>
            <td><?php echo number_format($totalTaxPercentageAmount,2); ?></td>
            <td>-</td>
            <td><?php echo number_format($totalFurtherTaxAmt,2); ?></td>
            <td style="color:#008000; font-weight:bold;"><?php echo number_format($grandTotal,2); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <!-- Amount in Words -->
    <div class="amount-words">
      <strong>Amount in Words:</strong> 
      <?php
      function numberToWords($number) {
        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $dictionary = array(
          0 => 'Zero', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
          6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
          11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen',
          15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
          19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty',
          50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty',
          90 => 'Ninety', 100 => 'Hundred', 1000 => 'Thousand',
          1000000 => 'Million', 1000000000 => 'Billion'
        );
        
        if (!is_numeric($number)) return '';
        
        $string = '';
        
        if (strpos($number, '.') !== false) {
          list($number, $fraction) = explode('.', $number);
        }
        
        switch (true) {
          case $number < 21:
            $string = $dictionary[$number];
            break;
          case $number < 100:
            $tens = ((int)($number/10))*10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) $string .= $hyphen . $dictionary[$units];
            break;
          case $number < 1000:
            $hundreds = $number/100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) $string .= $conjunction . numberToWords($remainder);
            break;
          default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int)($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = numberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
              $string .= $remainder < 100 ? $conjunction : $separator;
              $string .= numberToWords($remainder);
            }
            break;
        }
        
        return $string;
      }
      
      echo ucfirst(numberToWords($grandTotal)) . " Rupees Only";
      ?>
    </div>
    
    <!-- Footer Section - Fixed at bottom -->
    <div class="invoice-footer">
      <!-- FBR Section -->
      <div class="fbr-section">
        <div class="fbr-header">
          <div class="fbr-main">FBR INTEGRATED INVOICE</div>
          <div class="fbr-sub">Invoice #<?php echo $SaleInvoiceReport->FbrNo; ?></div>
        </div>
        
        <div class="fbr-content">
          <div class="fbr-left">
            <div id="qrcode-original" class="qrcode-box"></div>
            <div class="fbr-logo-box">
              <img src="<?php echo base_url() ?>images/fbri.png" alt="FBR Logo" style="width:100%; height:100%; object-fit:contain;">
            </div>
          </div>
          
          <div class="fbr-right">
            <div class="signature-box">
              <img src="<?php echo base_url() ?>images/signature/<?php echo $Settings->signature ?>" 
                   alt="Signature" class="signature-img">
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
    
    <!-- Top Row: Invoice No & Title -->
    <div class="top-row">
      <div class="invoice-info">
        <div>Invoice No: <strong><?php echo $SaleInvoiceReport->SaleId; ?></strong></div>
        <div>Date: <strong><?php echo date("d-M-Y", strtotime($SaleInvoiceReport->SaleDate)); ?></strong></div>
      </div>
      <div class="sales-tax-title">SALES TAX INVOICE</div>
    </div>
    
    <!-- Company & Customer Info -->
    <div class="company-customer-row">
      <!-- Company Info Left -->
      <div class="company-info">
        <h2 style="font-weight: bold; margin:0; padding:0; font-size: 32px; font-family: Calibri;">
    AZIZ MINES PVT LTD.
</h2>
        Shed No. 3, Plot # 00, Sector - 00,<br>
        Korangi Industrial Area, Karachi<br>
        Ph: 0000000, 0000000<br>
        <span style="
        background:#000;
        color:#fff;
        padding:2px 6px;
        font-weight:bold;
        border-radius:3px;
        display:inline-block;
        margin-top:2px;
    ">
      NTN: 0852531-5 | STRN: 00-00-0000-000-00
    </span>

  </div>
      
      <!-- Customer Info Right -->
      <div class="customer-box">
        <div class="customer-title">CUSTOMER INFORMATION</div>
        <div class="customer-detail">
          <span class="customer-label">Name:</span> <?php echo $SaleInvoiceReport->CustomerName; ?>
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
          <span class="customer-label">Type:</span> <?php echo $SaleInvoiceReport->AreaId; ?>
        </div>
      </div>
    </div>
    
<!-- Product Table -->
<div class="table-container">
  <table class="product-table">
    <thead>
      <tr>
        <th>S#</th>
        <th>Description</th>
        <th>TON</th>
        <th>T/Rate</th>

        <th style="display:none;">Rate</th> <!-- HIDDEN -->

        <th>GST %</th>

        <th style="display:none;">Qty</th>  <!-- HIDDEN -->

        <th>Value Ex. ST</th>
        <th>GST Amt</th>
        <th>F.Tax %</th>
        <th>F.Tax Amt</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>

          <?php
          $grandTotal = 0;
          $totalEngineNo = 0;
          $totalValueExST = 0;
          $totalTaxPercentageAmount = 0;
          $totalFurtherTaxAmt = 0;
          $SNo = 1;
          
          if(isset($SaleInvoiceReportDetails)) {
            foreach($SaleInvoiceReportDetails as $row) {
              $lineTotal = $row['NetAmount'];
              $valueExST = $row['Rate'] * $row['Quantity'];
              $grandTotal += $lineTotal;
              $totalTaxPercentageAmount += $row['TaxPercentage'];
              $totalEngineNo += $row['EngineNo'];
              $totalValueExST += $valueExST;
              $totalFurtherTaxAmt += $row['FurtherTaxAmt'];
          ?>
          <tr>
    <td><?php echo $SNo; ?></td>
    <td>
    <strong><?php echo $row['ProductName']; ?></strong>
    <br>
    <span style="font-size:10px; color:#555;">
        HS CODE: <?php echo $row['OpeningStock']; ?> |
        UOM: <?php echo $row['ProductGroupName']; ?>
    </span>
</td>

    <td><?php echo $row['EngineNo']; ?></td>
    <td><?php echo $row['ChassisNo']; ?></td>

    <td style="display:none;"><?php echo number_format($row['Rate'], 2); ?></td> <!-- HIDDEN -->

    <td><?php echo $row['DiscountAmount']; ?>%</td>

    <td style="display:none;"><?php echo number_format($row['Quantity'],2); ?></td> <!-- HIDDEN -->

    <td><?php echo number_format($valueExST, 2); ?></td>
    <td><?php echo number_format($row['TaxPercentage'],2); ?></td>
    <td><?php echo number_format($row['FurtherTaxRate'],2); ?>%</td>
    <td><?php echo number_format($row['FurtherTaxAmt'],2); ?></td>
    <td><?php echo number_format($lineTotal,2); ?></td>
</tr>

          <?php
              $SNo++;
            }
          }
          ?>
          <tr class="total-row">
            <td colspan="4" style="text-align:right; font-weight:bold;">TOTAL:</td>
            <td><strong><?php echo number_format($totalEngineNo, 2) . ' TON'; ?></strong></td>
            <td><?php echo number_format($totalValueExST,2); ?></td>
            <td><?php echo number_format($totalTaxPercentageAmount,2); ?></td>
            <td>-</td>
            <td><?php echo number_format($totalFurtherTaxAmt,2); ?></td>
            <td style="color:#008000; font-weight:bold;"><?php echo number_format($grandTotal,2); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <!-- Amount in Words -->
    <div class="amount-words">
      <strong>Amount in Words:</strong> <?php echo ucfirst(numberToWords($grandTotal)) . " Rupees Only"; ?>
    </div>
    
    <!-- Footer Section - Fixed at bottom -->
    <div class="invoice-footer">
      <!-- FBR Section -->
      <div class="fbr-section">
        <div class="fbr-header">
          <div class="fbr-main">FBR INTEGRATED INVOICE</div>
          <div class="fbr-sub">Invoice #<?php echo $SaleInvoiceReport->FbrNo; ?></div>
        </div>
        
        <div class="fbr-content">
          <div class="fbr-left">
            <div id="qrcode-duplicate" class="qrcode-box"></div>
            <div class="fbr-logo-box">
              <img src="<?php echo base_url() ?>images/fbri.png" alt="FBR Logo" style="width:100%; height:100%; object-fit:contain;">
            </div>
          </div>
          
          <div class="fbr-right">
            <div class="signature-box">
              <img src="<?php echo base_url() ?>images/signature/<?php echo $Settings->signature ?>" 
                   alt="Signature" class="signature-img">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
  // Generate QR Code for Original Copy
  new QRCode(document.getElementById("qrcode-original"), {
    text: "<?php echo $SaleInvoiceReport->FbrNo; ?>",
    width: 50,
    height: 50
  });
  
  // Generate QR Code for Duplicate Copy
  new QRCode(document.getElementById("qrcode-duplicate"), {
    text: "<?php echo $SaleInvoiceReport->FbrNo; ?>",
    width: 50,
    height: 50
  });
</script>
</body>
</html>