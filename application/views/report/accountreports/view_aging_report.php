<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $this->uri->segment(1); ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
  <style type="text/css">
    @media print {    
        .no-print, .no-print * {
            display: none !important;
        }
    }
    
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }
    
    .report-header {
        border-bottom: 2px solid #3c8dbc;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }
    
    .company-logo {
        max-width: 120px;
        height: auto;
    }
    
    .report-title {
        color: #333;
        font-weight: 600;
        margin-top: 20px;
        text-align: center;
    }
    
    .report-subtitle {
        color: #333;
        font-weight: 500;
        text-align: center;
        margin-bottom: 10px;
    }
    
    .report-period {
        font-size: 14px;
        color: #666;
        text-align: center;
        margin-bottom: 15px;
    }
    
    .table-container {
        margin-top: 20px;
    }
    
    .table-bordered thead th {
        background-color: #3c8dbc;
        color: white;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
    }
    
    .table-bordered tbody td {
        vertical-align: middle;
    }
    
    .total-row {
        background-color: #f5f5f5;
        font-weight: bold;
    }
    
    .amount-cell {
        text-align: right !important;
        padding-right: 20px !important;
    }
    
    .print-options {
        margin-bottom: 15px;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f9f9f9;
    }
    
    .due-days {
        font-weight: bold;
    }
    
    .due-0-30 {
        color: #28a745;
    }
    
    .due-31-60 {
        color: #ffc107;
    }
    
    .due-61-90 {
        color: #fd7e14;
    }
    
    .due-90-plus {
        color: #dc3545;
    }
  </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row report-header">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h2 class="report-title"><?php echo $GetSettingInformation[0]['CompanyName']; ?></h2>
                            <h4 class="report-subtitle">Accounts Receivable Aging Report</h4>
                        </div>
                        <div class="col-xs-12 text-right no-print">
                            <button class="btn btn-sm btn-primary" onclick="window.print();">
                                <i class="fa fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 text-center report-period">
                    As of <?php echo date('d F, Y'); ?>
                </div>
            </div>
            
            <div class="row table-container">
                <div class="col-xs-12">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align: center;">#</th>
                                <th style="width: 25%;">Customer Name</th>
                                <th style="width: 10%;">Invoice No</th>
                                <th style="width: 12%;">Invoice Date</th>
                                <th style="width: 12%; text-align: right;">Invoice Amount</th>
                                <th style="width: 12%; text-align: right;">Amount Paid</th>
                                <th style="width: 12%; text-align: right;">Balance</th>
                                <th style="width: 12%; text-align: center;">Due Days</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(isset($LedgerReport)) {
                                $PaidAmountTotal = 0;
                                $TotalAmountTotal = 0;
                                $balanceAmountTotal = 0;
                                $i = 0;
                                
                                foreach($LedgerReport as $key => $ChartOfAccountsReport) {
                                    $i++;
                                    
                                    // Calculate due days
                                    $invoiceDate = new DateTime($ChartOfAccountsReport['SaleDate']);
                                    $currentDate = new DateTime();
                                    $dueDays = $currentDate->diff($invoiceDate)->format("%a");
                                    
                                    // Determine due days class for styling
                                    $dueDaysClass = '';
                                    if ($dueDays <= 30) {
                                        $dueDaysClass = 'due-0-30';
                                    } elseif ($dueDays <= 60) {
                                        $dueDaysClass = 'due-31-60';
                                    } elseif ($dueDays <= 90) {
                                        $dueDaysClass = 'due-61-90';
                                    } else {
                                        $dueDaysClass = 'due-90-plus';
                                    }
                                    
                                    $TotalAmountTotal += $ChartOfAccountsReport['PreviousBalance'];
                                    $PaidAmountTotal += $ChartOfAccountsReport['lastPaidAmount'];
                                    $balanceAmountTotal += $ChartOfAccountsReport['previousBalanceamount'];
                            ?>
                            <tr style="font-size:13px;">
                                <td style="text-align: center;"><?php echo $i; ?></td>
                                <td><?php echo $ChartOfAccountsReport['CustomerName']; ?></td>
                                <td><?php echo $ChartOfAccountsReport['SaleId']; ?></td>
                                <td><?php echo date('d F, Y', strtotime($ChartOfAccountsReport['SaleDate'])); ?></td>
                                <td class="amount-cell"><?php echo number_format($ChartOfAccountsReport['PreviousBalance'], 2); ?></td>
                                <td class="amount-cell"><?php echo number_format($ChartOfAccountsReport['lastPaidAmount'], 2); ?></td>
                                <td class="amount-cell"><?php echo number_format($ChartOfAccountsReport['previousBalanceamount'], 2); ?></td>
                                <td style="text-align: center;" class="due-days <?php echo $dueDaysClass; ?>"><?php echo $dueDays; ?></td>
                            </tr>
                            <?php
                                }
                            ?>
                            <tr class="total-row">
                                <td colspan="4" style="text-align: right;"><strong>Grand Total:</strong></td>
                                <td class="amount-cell"><strong><?php echo number_format($TotalAmountTotal, 2); ?></strong></td>
                                <td class="amount-cell"><strong><?php echo number_format($PaidAmountTotal, 2); ?></strong></td>
                                <td class="amount-cell"><strong><?php echo number_format($balanceAmountTotal, 2); ?></strong></td>
                                <td></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>plugins/select2/select2.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/js/freeze-table.js"></script>
    <script>
    $(document).ready(function() {
        $(".table").freezeTable({
            'freezeColumn': true,
            'scrollable': true
        });
    });
    </script>
</body>
</html>