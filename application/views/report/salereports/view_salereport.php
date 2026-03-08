<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $this->uri->segment(1); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 

  <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
  
<style type="text/css">
@media print {
    @page {
        size: landscape;
        margin: 0.5cm;
    }
    
    body, html {
        width: 100%;
        height: auto;
        margin: 0;
        padding: 0;
        font-family: "Calibri", sans-serif;
        color: #000000;
        background: #fff !important;
        font-size: 12px;
    }
    
    .no-print, .no-print * {
        display: none !important;
    }
    
    .container {
        width: 100%;
        margin: 0;
        padding: 0;
        box-shadow: none;
        background: #fff;
    }
    
    .print-header {
        display: block !important;
        text-align: center;
        margin-bottom: 10px;
        padding-bottom: 8px;
        border-bottom: 1px solid #ddd;
        page-break-after: avoid;
    }
    
    .print-header img {
        display: none !important;
    }
    
    .print-header h2 {
        margin: 0;
        color: #000;
        font-size: 16px;
        font-weight: bold;
    }
    
    .print-header h3 {
        margin: 2px 0;
        color: #000;
        font-size: 14px;
        font-weight: normal;
    }
    
    .print-header p {
        margin: 0;
        color: #000;
        font-size: 12px;
    }
    
    .header {
        display: none !important;
    }
    
    .table-container {
        overflow: visible;
        margin-bottom: 0;
        box-shadow: none;
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
        page-break-inside: auto;
    }
    
    .table th {
        padding: 6px 5px;
        text-align: left;
        font-weight: bold;
        border: 1px solid #000;
        background: #f0f0f0 !important;
        color: #000 !important;
    }
    
    .table td {
        padding: 5px;
        border: 1px solid #000;
        vertical-align: top;
        page-break-inside: avoid;
    }
    
    .table tbody tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
    
    .table tfoot tr {
        background-color: #f0f0f0 !important;
        font-weight: bold;
    }
    
    .total-row {
        background-color: #f0f0f0 !important;
    }
    
    .status-indicator {
        display: none;
    }
    
    .amount-positive {
        color: #000;
        font-weight: bold;
    }
    
    .salesman-group-header {
        background-color: #e0e0e0 !important;
        font-weight: bold;
    }
}

body {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    color: #333;
    background-color: #f9f9f9;
    padding: 20px;
}

.container {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    padding: 25px;
    margin-bottom: 30px;
}

.print-header {
    display: none;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eaeaea;
}

.company-info {
    text-align: left;
}

.company-name {
    color: #2d3e50;
    font-size: 24px;
    font-weight: 600;
    margin: 0 0 5px 0;
}

.report-title {
    color: #2d3e50;
    font-size: 20px;
    font-weight: 500;
    margin: 0 0 10px 0;
}

.report-period {
    color: #666;
    font-size: 14px;
    margin: 0;
}

.actions-container {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 20px;
    gap: 10px;
}

.btn-print, .btn-summary {
    background: #2d3e50;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-print:hover, .btn-summary:hover {
    background: #1a2633;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.btn-summary.active {
    background: #3498db;
}

.table-container {
    overflow-x: auto;
    margin-bottom: 20px;
    border-radius: 6px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.table thead tr {
    background: #2d3e50;
    color: #fff;
}

.table th {
    padding: 12px 10px;
    text-align: left;
    font-weight: 600;
    border: 1px solid #ddd;
}

.table td {
    padding: 10px;
    border: 1px solid #eaeaea;
    vertical-align: top;
}

.table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

.table tbody tr:hover {
    background-color: #f1f7ff;
}

.table tfoot tr {
    background-color: #e8f1ff;
    font-weight: bold;
}

.text-right {
    text-align: right;
}

.text-center {
    text-align: center;
}

.text-left {
    text-align: left;
}

.total-row {
    background-color: #e8f1ff !important;
    font-weight: 600;
}

.company-logo {
    max-width: 180px;
    height: auto;
    margin-bottom: 15px;
}

.status-indicator {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-right: 5px;
}

.status-cash {
    background-color: #28a745;
}

.status-credit {
    background-color: #ffc107;
}

.status-online {
    background-color: #17a2b8;
}

.amount-positive {
    color: #28a745;
    font-weight: 500;
}

.salesman-group-header {
    background-color: #e8f4fd !important;
    font-weight: 600;
    font-size: 14px;
}

.salesman-total-row {
    background-color: #f0f8ff !important;
    font-weight: 600;
}

.grand-total-row {
    background-color: #2d3e50 !important;
    color: white;
    font-weight: 700;
}

.salesman-summary-view .table th {
    background: #3498db;
}

</style>
</head>
<body>
    <div class="container">
        <!-- Header for screen view -->
        <div class="header">
            <div class="company-info">
                <img src="<?php echo base_url() ?>images/company-logo/<?php echo $GetSettingInformation[0]['CompanyLogo']; ?>" alt="Company Logo" class="company-logo">
                <h1 class="company-name"><?php echo $GetSettingInformation[0]['CompanyName']; ?></h1>
                <h2 class="report-title">
                    <?php 
                    $FunctionName = $this->uri->segment(2);
                    $WithSpace = preg_replace('/(?<!\ )[A-Z]/', ' $0', $FunctionName);
                    echo $WithSpace;
                    ?>
                </h2>
                <p class="report-period">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?></p>
            </div>
        </div>
        
        <!-- Header for print view -->
        <div class="print-header">
            <h2><?php echo $GetSettingInformation[0]['CompanyName']; ?></h2>
            <h3>
                <?php 
                $FunctionName = $this->uri->segment(2);
                $WithSpace = preg_replace('/(?<!\ )[A-Z]/', ' $0', $FunctionName);
                echo $WithSpace;
                ?>
            </h3>
            <p>Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?></p>
        </div>
        
        <div class="actions-container no-print">
            <button class="btn-summary" id="btnSalesmanSummary">
                <i class="fa fa-users"></i> Salesman Summary
            </button>
            <button class="btn-print" onclick="window.print()">
                <i class="fa fa-print"></i> Print Report
            </button>
        </div>
        
        <div class="table-container" id="salesDetailView">
            <table class="table table-bordered">
                <thead>
                    <?php
                    $hasRecords = !empty($AllSales);
                    
                    if (!$hasRecords) {
                        echo "<p class='alert alert-info'>No sales records found for the selected period</p>";
                    } else { ?>
                    <tr>
                        <th style="width: 30px;">S.#</th>
                        <th style="text-align:center;">Date</th>
                        <th style="text-align:center;">Inv: No.</th>
                        <th style="text-align:left;">Product Name</th>
                        <th style="text-align:left;">HS Code</th>
                        <th style="text-align:left;">Category</th>
                        <th style="text-align:left;">Saleman Name</th>
                        <th style="text-align:left;">Customer Name</th>
                        <th style="text-align:left;">FBR Invoice Number</th>
                        <th style="text-align:left;">Address</th>
                        <th style="text-align:left;">Registration No</th>
                        <th style="text-align:center;">Sale Type</th>
                        <th style="text-align:center;">Rate</th>
                        <th style="text-align:center;">Quantity</th>
                        <th style="text-align:center;">Amount</th>
                        <th style="text-align:center;">GST Rate</th>
                        <th style="text-align:center;">Tax Amount</th>
                        <th style="text-align:center;">Discount</th>
                        <th style="text-align:center;">Net Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $SNo = 0;
                    $Amount = 0;
                    $NetQuantity = 0;
                    $DiscountAmount = 0;
                    $TaxAmount = 0;
                    $NetAmount = 0;
                    $ProfitTotal = 0;
                    $TaxPercentage=0;
                    $AveragePurchasePrice = 0;
                    
                    foreach ($AllSales as $AllSalesRecord) {
                        $SNo++;
                        $SaleType = "";
                        $statusClass = "";
                        if($AllSalesRecord['SaleType'] == "1"){
                            $SaleType = "On Cash";
                            $statusClass = "status-cash";
                        }
                        if($AllSalesRecord['SaleType'] == "2"){
                            $SaleType = "On Credit";
                            $statusClass = "status-credit";
                        }
                        if($AllSalesRecord['SaleType'] == "3"){
                            $SaleType = "Online";
                            $statusClass = "status-online";
                        }
                        
                        foreach($GetAveragePrice as $data){
                            if($data['ProductId'] == $AllSalesRecord['ProductId']){
                                $AveragePurchasePrice = $data['PurchasePrice'];
                            }
                        }
                    ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $SNo; ?></td>
                        <td style="text-align:center;"><?php echo date('M d, Y', strtotime($AllSalesRecord['SaleDate'])); ?></td>
                        <td style="text-align:center;"><?php echo $AllSalesRecord['SaleId']; ?></td>
                        <td style="text-align:left;"><?php echo ($AllSalesRecord['ProductName']); ?></td>
                        <td style="text-align:left;"><?php echo ($AllSalesRecord['OpeningStock']); ?></td>
                        <td style="text-align:left;"><?php echo ($AllSalesRecord['CategoryName']); ?></td>
                        <td style="text-align:left;"><?php echo ($AllSalesRecord['SalemanName']); ?></td>
                        <td style="text-align:left;"><?php echo ($AllSalesRecord['CustomerName']); ?></td>
                        <td style="text-align:left;"><?php echo ($AllSalesRecord['FbrNo']); ?></td>
                        <td style="text-align:left;"><?php echo ($AllSalesRecord['fbr_customer']); ?></td>
                        <td style="text-align:left;"><?php echo ($AllSalesRecord['PhoneNo']); ?></td>
                        <td style="text-align:left;"><span class="status-indicator <?php echo $statusClass; ?>"></span><?php echo $SaleType; ?></td>
                        <td style="text-align:center;"><?php echo number_format($AllSalesRecord['Rate'],2); ?></td>
                        <td style="text-align:center;"><?php echo number_format($AllSalesRecord['Quantity'],2); ?></td>
                        <td style="text-align:center;" class="amount-positive"><?php echo number_format($AllSalesRecord['Amount'],2); ?></td>
                        <td style="text-align:center;"><?php echo number_format($AllSalesRecord['DiscountAmount'],2); ?></td>
                        <td style="text-align:center;"><?php echo number_format($AllSalesRecord['TaxPercentage'],2); ?></td>
                        <td style="text-align:center;"><?php echo number_format($AllSalesRecord['TaxAmount'],2); ?></td>
                        <td style="text-align:center;" class="amount-positive"><?php echo number_format($AllSalesRecord['NetAmount'],2); ?></td>
                    </tr>
                    <?php
                        $NetQuantity += $AllSalesRecord['Quantity'];
                        $Amount += $AllSalesRecord['Amount'];
                        $DiscountAmount += $AllSalesRecord['DiscountAmount'];
                        $TaxAmount += $AllSalesRecord['TaxAmount'];
                        $NetAmount += $AllSalesRecord['NetAmount'];
                        $ProfitTotal += $AllSalesRecord['NetAmount'] - ($AveragePurchasePrice * round($AllSalesRecord['Quantity']));
                    }
                    ?>
                    <?php if ($SNo > 0) { ?>
                    <tr class="total-row">             
                        <td colspan="13" style="text-align:right; font-weight: 700; font-size: 13px;">Total:</td>
                        <td style="text-align:center; font-weight:700;"><?php echo number_format($NetQuantity,2); ?></td>
                        <td style="text-align:center; font-weight:700;" class="amount-positive"><?php echo number_format($Amount,2); ?></td>
                        <td style="text-align:center; font-weight:700;"></td> <!-- Empty for GST Rate (no total) -->
                        <td colspan="2" style="text-align:center; font-weight:700; border-left:1px solid #ddd; border-right:1px solid #ddd;">
                            <?php echo number_format(($NetAmount - $Amount),2); ?>
                        </td>
                        <td style="text-align:center; font-weight:700;" class="amount-positive"><?php echo number_format($NetAmount,2); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } ?>
        </div>
        
        <!-- Salesman Summary View (initially hidden) -->
        <div class="table-container" id="salesmanSummaryView" style="display: none;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 30px;">S.#</th>
                        <th style="text-align:left;">Salesman Name</th>
                        <th style="text-align:left;">Customer Name</th>
                        <th style="text-align:center;">Total Quantity</th>
                        <th style="text-align:center;">Amount</th>
                        <th style="text-align:center;">Tax Amount</th>
                        <th style="text-align:center;">Net Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$hasRecords) {
                        echo "<tr><td colspan='7' class='text-center'>No sales records found for the selected period</td></tr>";
                    } else {
                        // Group sales by salesman and customer
                        $salesmanData = [];
                        $grandTotalQty = 0;
                        $grandTotalAmount = 0;
                        $grandTotalTax = 0;
                        $grandTotalNet = 0;
                        
                        foreach ($AllSales as $AllSalesRecord) {
                            $salesmanName = $AllSalesRecord['SalemanName'];
                            $customerName = $AllSalesRecord['CustomerName'];
                            
                            if (!isset($salesmanData[$salesmanName])) {
                                $salesmanData[$salesmanName] = [];
                            }
                            
                            if (!isset($salesmanData[$salesmanName][$customerName])) {
                                $salesmanData[$salesmanName][$customerName] = [
                                    'quantity' => 0,
                                    'amount' => 0,
                                    'tax' => 0,
                                    'net' => 0
                                ];
                            }
                            
                            $salesmanData[$salesmanName][$customerName]['quantity'] += $AllSalesRecord['Quantity'];
                            $salesmanData[$salesmanName][$customerName]['amount'] += $AllSalesRecord['Amount'];
                            $salesmanData[$salesmanName][$customerName]['tax'] += $AllSalesRecord['TaxAmount'];
                            $salesmanData[$salesmanName][$customerName]['net'] += $AllSalesRecord['NetAmount'];
                            
                            $grandTotalQty += $AllSalesRecord['Quantity'];
                            $grandTotalAmount += $AllSalesRecord['Amount'];
                            $grandTotalTax += $AllSalesRecord['TaxAmount'];
                            $grandTotalNet += $AllSalesRecord['NetAmount'];
                        }
                        
                        $SNo = 0;
                        $salesmanCounter = 0;
                        
                        foreach ($salesmanData as $salesmanName => $customers) {
                            $salesmanCounter++;
                            $salesmanTotalQty = 0;
                            $salesmanTotalAmount = 0;
                            $salesmanTotalTax = 0;
                            $salesmanTotalNet = 0;
                            
                            // Salesman header row
                            ?>
                            <tr class="salesman-group-header">
                                <td colspan="7">
                                    <i class="fa fa-user"></i> <?php echo $salesmanName; ?>
                                </td>
                            </tr>
                            <?php
                            
                            // Customer rows for this salesman
                            foreach ($customers as $customerName => $data) {
                                $SNo++;
                                $salesmanTotalQty += $data['quantity'];
                                $salesmanTotalAmount += $data['amount'];
                                $salesmanTotalTax += $data['tax'];
                                $salesmanTotalNet += $data['net'];
                                ?>
                                <tr>
                                    <td style="text-align:center;"><?php echo $SNo; ?></td>
                                    <td style="text-align:left;"></td> <!-- Empty for salesman name (already in header) -->
                                    <td style="text-align:left;"><?php echo $customerName; ?></td>
                                    <td style="text-align:center;"><?php echo number_format($data['quantity'], 2); ?></td>
                                    <td style="text-align:center;" class="amount-positive"><?php echo number_format($data['amount'], 2); ?></td>
                                    <td style="text-align:center;"><?php echo number_format($data['tax'], 2); ?></td>
                                    <td style="text-align:center;" class="amount-positive"><?php echo number_format($data['net'], 2); ?></td>
                                </tr>
                                <?php
                            }
                            
                            // Salesman total row
                            ?>
                            <tr class="salesman-total-row">
                                <td colspan="3" style="text-align:right; font-weight: 700;">Total for <?php echo $salesmanName; ?>:</td>
                                <td style="text-align:center; font-weight:700;"><?php echo number_format($salesmanTotalQty, 2); ?></td>
                                <td style="text-align:center; font-weight:700;" class="amount-positive"><?php echo number_format($salesmanTotalAmount, 2); ?></td>
                                <td style="text-align:center; font-weight:700;"><?php echo number_format($salesmanTotalTax, 2); ?></td>
                                <td style="text-align:center; font-weight:700;" class="amount-positive"><?php echo number_format($salesmanTotalNet, 2); ?></td>
                            </tr>
                            <?php
                        }
                        
                        // Grand total row
                        ?>
                        <tr class="grand-total-row">
                            <td colspan="3" style="text-align:right; font-weight: 700;">GRAND TOTAL:</td>
                            <td style="text-align:center; font-weight:700;"><?php echo number_format($grandTotalQty, 2); ?></td>
                            <td style="text-align:center; font-weight:700;"><?php echo number_format($grandTotalAmount, 2); ?></td>
                            <td style="text-align:center; font-weight:700;"><?php echo number_format($grandTotalTax, 2); ?></td>
                            <td style="text-align:center; font-weight:700;"><?php echo number_format($grandTotalNet, 2); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<script>
$(document).ready(function() {
    // Toggle between sales detail and salesman summary views
    $('#btnSalesmanSummary').click(function() {
        var salesDetailView = $('#salesDetailView');
        var salesmanSummaryView = $('#salesmanSummaryView');
        var btn = $(this);
        
        if (salesDetailView.is(':visible')) {
            // Switch to salesman summary view
            salesDetailView.hide();
            salesmanSummaryView.show();
            btn.addClass('active');
            btn.html('<i class="fa fa-list"></i> Sales Details');
            
            // Update print header for summary view
            $('.print-header h3').text('Salesman Customer Wise Sale Summary');
        } else {
            // Switch back to sales detail view
            salesDetailView.show();
            salesmanSummaryView.hide();
            btn.removeClass('active');
            btn.html('<i class="fa fa-users"></i> Salesman Summary');
            
            // Reset print header
            var FunctionName = window.location.pathname.split('/').pop();
            var WithSpace = FunctionName.replace(/(?<!\ )[A-Z]/g, ' $0');
            $('.print-header h3').text(WithSpace);
        }
    });
});
</script>