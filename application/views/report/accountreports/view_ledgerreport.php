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
    a[href]:after {
        content: none !important;
    }

    
    .container {
        width: 100%;
        margin: 0;
        padding: 0;
        box-shadow: none;
        background: #fff;
    }
    
    .print-header {
        display: flex !important;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ddd;
        page-break-after: avoid;
    }
    
    .print-header img {
        max-width: 120px;
        height: auto;
    }
    
    .print-header > div {
        text-align: center;
        flex-grow: 1;
    }
    
    .print-header h2 {
        margin: 0;
        color: #000;
        font-size: 18px;
    }
    
    .print-header h3 {
        margin: 3px 0;
        color: #000;
        font-size: 16px;
    }
    
    .print-header p {
        margin: 0;
        color: #000;
        font-size: 13px;
    }
    
    .table-container {
        overflow: visible;
        margin-bottom: 0;
        box-shadow: none;
    }
    
    .ledger-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
        page-break-inside: auto;
        margin-bottom: 20px;
    }
    
    .ledger-table th {
        padding: 8px 6px;
        text-align: left;
        font-weight: bold;
        border: 1px solid #000;
        background: #f0f0f0 !important;
        color: #000 !important;
    }
    
    .ledger-table td {
        padding: 6px;
        border: 1px solid #000;
        vertical-align: top;
        page-break-inside: avoid;
    }
    
    .ledger-table tbody tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
    
    .summary-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        margin-top: 20px;
    }
    
    .summary-table th, .summary-table td {
        padding: 8px;
        border: 1px solid #000;
        text-align: right;
    }
    
    .summary-table th {
        background: #f0f0f0 !important;
        text-align: left;
    }
    
    .status-indicator {
        display: none;
    }
    
    .amount-positive {
        color: #000;
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

.btn-action {
    background: #2d3e50;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
}

.btn-action:hover {
    background: #1a2633;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.ledger-container {
    overflow-x: auto;
    margin-bottom: 20px;
    border-radius: 6px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.ledger-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.ledger-table thead tr {
    background: #2d3e50;
    color: #fff;
}

.ledger-table th {
    padding: 12px 10px;
    text-align: left;
    font-weight: 600;
    border: 1px solid #ddd;
}

.ledger-table td {
    padding: 10px;
    border: 1px solid #eaeaea;
    vertical-align: top;
}

.ledger-table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

.ledger-table tbody tr:hover {
    background-color: #f1f7ff;
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

.account-header {
    background-color: #e8f1ff !important;
    font-weight: 600;
    padding: 15px 10px;
    border-left: 4px solid #2d3e50;
}

.contact-info {
    background-color: #f9f9f9;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
    border-left: 3px solid #2d3e50;
}

.contact-info p {
    margin: 5px 0;
    font-size: 13px;
}

.company-logo {
    max-width: 180px;
    height: auto;
    margin-bottom: 15px;
}

.summary-section {
    margin-top: 30px;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 6px;
    border-left: 4px solid #2d3e50;
}

.summary-table {
    width: 100%;
    border-collapse: collapse;
}

.summary-table th {
    background: #2d3e50;
    color: white;
    padding: 12px;
    text-align: left;
}

.summary-table td {
    padding: 12px;
    border-bottom: 1px solid #eaeaea;
    font-weight: 500;
}

.summary-table tr:last-child td {
    border-bottom: none;
    font-weight: bold;
    background: #e8f1ff;
}

.total-amount {
    font-weight: bold;
    color: #2d3e50;
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
            <img src="<?php echo base_url() ?>images/company-logo/<?php echo $GetSettingInformation[0]['CompanyLogo']; ?>" alt="Company Logo">
            <div>
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
        </div>
        
        <div class="actions-container no-print">
            <button class="btn-action" onclick="window.print()">
                <i class="fa fa-print"></i> Print
            </button>
            <a class="btn-action" href="<?php echo base_url() ?>Export/ExportExcelLedgerReport?StartDate=<?php echo $this->input->get('StartDate') ?>&EndDate=<?php echo $this->input->get('EndDate'); ?>&BId=<?php echo $this->input->get('BId'); ?>&BAId=<?php echo $this->input->get('BAId'); ?>&CId=<?php echo $this->input->get('CId'); ?>&CCId=<?php echo $this->input->get('CCId'); ?>&COAId=<?php echo $this->input->get('COAId'); ?>&CustomerId=<?php echo $this->input->get('CustomerId'); ?>&VendorId=<?php echo $this->input->get('VendorId'); ?>">
                <i class="fa fa-file-excel-o"></i> Export Excel
            </a>
        </div>
        
        <?php
        $SNo=1;
        $CompanyName = '';
        $dTotal_Debit = 0;
        $dTotal_Credit = 0;
        $dGrandTotal_Debit = 0;
        $dGrandTotal_Credit = 0;
        $GrandBalance = 0;
        
        $dDebit = 0; 
        $dCredit = 0;
        $dTransBalance = 0;
        $dBalance = 0;
        $dClosingBalance = 0;
        
        // Initialize summary variables
        $grandOpeningBalance = 0;
        $grandTotalDebit = 0;
        $grandTotalCredit = 0;
        $grandFinalBalance = 0;

        if(isset($LedgerReport)) {
            foreach($LedgerReport as $LedgerReportRecord) {
                
                $ContactName = "Contact Name - ";
                $Area        = "Company Name - ";
                $Mobile      = "Mobile no - ";
                $Address     = "Address - ";
                
                $ChartOfAccountId = $LedgerReportRecord['ChartOfAccountId'];
                $ChartOfAccountTitle = $LedgerReportRecord['ChartOfAccountTitle'];
                $DebitIncrease = $LedgerReportRecord['DebitIncrease'];
                $CreditIncrease = $LedgerReportRecord['CreditIncrease'];
                
                if(isset($OpenningBalance)) {
                    foreach($OpenningBalance as $OpenningBalanceRecord) {
                        if($OpenningBalanceRecord['ChartOfAccountId'] === $ChartOfAccountId) {
                            $dBalance = $OpenningBalanceRecord['Balance'];
                            $grandOpeningBalance += $dBalance;
                        }
                    }
                }
                
                if(isset($Detailss)) {
                    foreach($Detailss as $d){
                        if($ChartOfAccountId == $d['ChartOfAccountId']) {
                            $ContactName .= $d['ContactName'];
                            $Area        .= $d['AreaName'];
                            $Mobile      .= $d['CellNo'];
                            $Address     .= $d['Address']; 
                        }
                    }
                }
        ?>
        
        <div class="ledger-container">
            <div class="account-header">
                General Ledger - <?php echo $ChartOfAccountTitle; ?>
            </div>
            
            <?php if(($CategoryId == 1 && $ControlCodeId == 3) || ($CategoryId == 2 && $ControlCodeId == 2)) { ?>
            <div class="contact-info">
                <p><?php echo $ContactName; ?></p>
                <p><?php echo $Area; ?></p>
                <p><?php echo $Mobile; ?></p>
                <p><?php echo $Address; ?></p>
            </div>
            <?php } ?>
            
            <div style="margin: 10px 0; padding: 10px; background: #f0f8ff; border-radius: 4px;">
                <strong>Opening Balance:</strong> <?php echo number_format($dBalance, 0); ?>
            </div>
            
            <table class="ledger-table">
                <thead>
                    <tr>
                        <th style="width:10%">Date</th>
                        <th style="width:40%">Detail</th>
                        <th style="width:10%">Ref No.</th>
                        <th style="width:10%; text-align: right;">Debit</th>
                        <th style="width:10%; text-align: right;">Credit</th>
                        <th style="width:10%; text-align: right;">Balance</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $accountTotalDebit = 0;
                $accountTotalCredit = 0;
                $accountFinalBalance = $dBalance;
                
                foreach($SubLedgerReport as $SubLedgerReportRecord) {
                    if($SubLedgerReportRecord['ChartOfAccountId'] == $LedgerReportRecord['ChartOfAccountId']) {
                        
                        $ChartOfAccountId = $SubLedgerReportRecord['ChartOfAccountId'];
                        $GeneralJournalId = $SubLedgerReportRecord['GeneralJournalId'];
                        $Reference = $SubLedgerReportRecord['Reference'];
                        $dTransactionDate = $SubLedgerReportRecord['TransactionDate'];
                        $sTransactionDate = date("M j, Y", strtotime($dTransactionDate));
                        $Detail = $SubLedgerReportRecord['Detail'];
                        $dDebit = $SubLedgerReportRecord['Debit'];
                        $dCredit = $SubLedgerReportRecord['Credit'];
                        $voucherType = $SubLedgerReportRecord['VoucherType'];
                        
                        if($DebitIncrease == 1) {
                            $dTransBalance = $dDebit - $dCredit;
                        }
                        
                        if($CreditIncrease == 1) {
                            $dTransBalance = $dCredit - $dDebit;
                        }
                        
                        if($DebitIncrease == 1) {
                            $dBalance += $dTransBalance; 
                        }
                        
                        if($CreditIncrease == 1) {
                            $dBalance += $dTransBalance;
                        }
                        
                        $accountTotalDebit += $dDebit;
                        $accountTotalCredit += $dCredit;
                        $accountFinalBalance = $dBalance;
                        
                        $sDebit = number_format($dDebit, 0);
                        $sCredit = number_format($dCredit, 0);
                        
                        if ($dDebit == 0) $sDebit = '';
                        if ($dCredit == 0) $sCredit = '';
                        
                        $PurchaseId = $SubLedgerReportRecord['PurchaseId'];
                        $SaleUniqueId = $SubLedgerReportRecord['SaleUniqueId'];
                        $SaleId = $SubLedgerReportRecord['SaleId'];
                        $ReportLink = "";
                        
                        if(($SaleId != 0)) {
                            $ReportLink = '<a target="_blank" href="'.base_url().'SaleReports/ViewSaleInvoiceReport?InvoiceNo='.$SaleId.'&isBalance=1&productName=1&generics=1&mfr=1&batchNo=1&mfg=1&discount=1&warranty=1&date=1">'.'Sale Invoice no. '.$SaleId.'</a>';
                        } elseif($PurchaseId != 0) {
                            $ReportLink = '<a target="_blank" href="'.base_url().'PurchaseReports/PurchaseInvoiceReport?PNo='.$PurchaseId.'">'.'Pur Invoice no. '.$PurchaseId.'</a>';
                        } 
                ?>
                <tr>
                    <td><?php echo $sTransactionDate; ?></td>
                    <td><?php echo "<b>".$Detail . "</b>"." ".$ReportLink; ?></td> 
                    <td><?php echo $Reference; ?></td>
                    <td style="text-align: right;"><?php echo $sDebit ?></td> 
                    <td style="text-align: right;"><?php echo $sCredit; ?></td>
                    <td style="text-align: right;"><?php echo number_format($dBalance,0); ?></td>                
                </tr>
                <?php
                        $dGrandTotal_Debit += $dDebit;
                        $dGrandTotal_Credit += $dCredit;
                        $GrandBalance = $dGrandTotal_Debit - $dGrandTotal_Credit;
                    } 
                }
                ?>
                <tr style="background-color: #f5f5f5; font-weight: bold;">
                    <td colspan="3" style="text-align: right;">Account Total:</td>
                    <td style="text-align: right;"><?php echo number_format($accountTotalDebit,0); ?></td>
                    <td style="text-align: right;"><?php echo number_format($accountTotalCredit,0); ?></td>
                    <td style="text-align: right;"><?php echo number_format($accountFinalBalance,0); ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        
        <?php
                // Add to grand totals
                $grandTotalDebit += $accountTotalDebit;
                $grandTotalCredit += $accountTotalCredit;
                $grandFinalBalance += $accountFinalBalance;
                
                $sDebit = 0;
                $sCredit = 0;
                $dBalance = 0;
                $dTotal_Debit = 0;
                $dTotal_Credit = 0;
                $dBalance = 0;
            } 
        } 
        ?>
        
        <!-- Summary Section -->
        <div class="summary-section">
            <h3>Ledger Summary</h3>
            <table class="summary-table">
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
                <tr>
                    <td>Total Opening Balance</td>
                    <td class="total-amount"><?php echo number_format($grandOpeningBalance, 0); ?></td>
                </tr>
                <tr>
                    <td>Total Debit</td>
                    <td class="total-amount"><?php echo number_format($grandTotalDebit, 0); ?></td>
                </tr>
                <tr>
                    <td>Total Credit</td>
                    <td class="total-amount"><?php echo number_format($grandTotalCredit, 0); ?></td>
                </tr>
                <tr>
                    <td>Final Balance</td>
                    <td class="total-amount"><?php echo number_format($grandFinalBalance, 0); ?></td>
                </tr>
            </table>
        </div>
        
    </div>
</body>
</html>

<script>
$(document).ready(function() {
    // Any additional JavaScript functionality can be added here
});
</script>