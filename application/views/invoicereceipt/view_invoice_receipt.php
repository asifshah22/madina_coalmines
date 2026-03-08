<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Invoice Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #343a40;
            --primary-dark: #1E3F63;
            --primary-light: #E8F0F8;
            --secondary: #6B7280;
            --success: #0E9F6E;
            --danger: #E02424;
            --warning: #F59E0B;
            --light-bg: #F9FAFB;
            --border-color: #D1D5DB;
            --text-primary: #111827;
            --text-secondary: #000;
        }
        
        body {
            background-color: #f5f7fa;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 0.875rem;
            color: var(--text-primary);
            line-height: 1.5;
        }
        
        .form-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .form-header {
            background-color: var(--primary);
            color: white;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .form-header h1 {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
        }
        
        .form-header h1 i {
            margin-right: 0.75rem;
        }
        
        .form-body {
            padding: 1.5rem;
        }
        
        .section-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #198754;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border-color);
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        
        .form-label {
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.375rem;
        }
        
        .form-control, .form-select {
            font-size: 0.8125rem;
            border-radius: 4px;
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--border-color);
            transition: all 0.15s ease;
            height: calc(1.5em + 0.75rem + 2px);
        }
        
        .btn {
            font-size: 0.8125rem;
            font-weight: 500;
            border-radius: 4px;
            padding: 0.5rem 1rem;
            transition: all 0.15s ease;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        .btn-danger {
            background-color: var(--danger);
            border-color: var(--danger);
        }
        
        .btn-danger:hover {
            background-color: #C81E1E;
            border-color: #C81E1E;
        }
        
        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
        }
        
        .alert-success {
            font-size: 0.8125rem;
            background-color: rgba(14, 159, 110, 0.1);
            border-color: rgba(14, 159, 110, 0.2);
            color: #065F46;
            border-radius: 4px;
        }
        
        .field-group {
            margin-bottom: 1.5rem;
        }
        
        .info-value {
            font-size: 0.875rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--border-color);
        }
        
        .info-label {
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 0.25rem;
        }
        
        .customer-name {
            color: var(--primary);
            font-weight: 600;
        }
        
        .department {
            color: var(--success);
            font-weight: 600;
        }
        
        .amount-value {
            font-weight: 600;
        }
        
        .invoice-balance {
            color: var(--danger);
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }
        
        .section-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }
        
        .section-card .section-title {
            margin-top: 0;
        }
        
        .receipt-id {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--primary);
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }
        
        .status-badge.success {
            background-color: rgba(14, 159, 110, 0.1);
            color: var(--success);
        }
        
        .status-badge.warning {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }
        
        .status-badge.danger {
            background-color: rgba(224, 36, 36, 0.1);
            color: var(--danger);
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header and sidebar would be loaded here -->
    
    <div class="container-fluid py-3">
        <div class="form-container">
            <div class="form-header">
                <h1><i class="fas fa-file-invoice-dollar"></i> Invoice Receipt Details</h1>
            </div>
            
            <div class="form-body">
                <?php if($this->session->flashdata('record_update')): ?>
                <div class="alert alert-success mb-3">
                    <?php echo $this->session->flashdata('record_update'); ?>
                </div>
                <?php endif; ?>
                
                <?php if($this->session->flashdata('record_deleted')): ?>
                <div class="alert alert-success mb-3">
                    <?php echo $this->session->flashdata('record_deleted'); ?>
                </div>
                <?php endif; ?>
                
                <div class="section-card">
                    <h5 class="section-title">Receipt Information</h5>
                    
                    <div class="info-grid">
                        <div>
                            <div class="info-label">Receipt #</div>
                            <div class="receipt-id info-value"><?php echo $GetInvoiceReceipt['GeneralJournal']->GeneralJournalId; ?></div>
                        </div>
                        
                        <div>
                            <div class="info-label">Date</div>
                            <div class="info-value"><?php echo date('M d, Y', strtotime($GetInvoiceReceipt['GeneralJournal']->TransactionDate)); ?></div>
                        </div>
                        
                        <div>
                            <div class="info-label">Invoice No</div>
                            <div class="info-value"><?php echo $GetInvoiceReceipt['GeneralJournal']->SaleUniqueId; ?></div>
                        </div>
                        
                        <div>
                            <div class="info-label">Customer Name</div>
                            <div class="customer-name info-value"><?php echo $GetInvoiceReceipt['GeneralJournal']->CustomerName; ?></div>
                        </div>
                        
                        <div>
                            <div class="info-label">Department</div>
                            <div class="department info-value"><?php echo $GetInvoiceReceipt['GeneralJournal']->Area_name; ?></div>
                        </div>
                        
                        <div>
                            <div class="info-label">Payment Type</div>
                            <div class="info-value">
                                <?php 
                                if($GetInvoiceReceipt['GeneralJournal']->VoucherType == 3){ 
                                    echo '<span class="status-badge success">On Cash</span>'; 
                                } else if($GetInvoiceReceipt['GeneralJournal']->VoucherType == 2){ 
                                    echo '<span class="status-badge warning">On Bank</span>'; 
                                } else { 
                                    echo '<span class="status-badge danger">No Type Selected</span>'; 
                                } 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="section-card">
                    <h5 class="section-title">Payment Details</h5>
                    
                    <div class="info-grid">
                        <div>
                            <div class="info-label">Bank Account</div>
                            <div class="info-value"><?php echo $GetInvoiceReceipt['GeneralJournal']->BankName; ?></div>
                        </div>
                        
                        <div>
                            <div class="info-label">Instrument / Cheque No</div>
                            <div class="info-value"><?php echo $GetInvoiceReceipt['GeneralJournal']->ReceiptNo; ?></div>
                        </div>
                        
                        <div>
                            <div class="info-label">Receipt Amount</div>
                            <div class="amount-value info-value"><?php echo $GetInvoiceReceipt['GeneralJournal']->TotalDebit; ?></div>
                        </div>
                    </div>
                </div>
                
                <div class="section-card">
                    <h5 class="section-title">Deductions & Taxes</h5>
                    
                    <div class="info-grid">
                        <div>
                            <div class="info-label">Income Tax</div>
                            <div class="info-value"><?php echo $GetInvoiceReceipt['GeneralJournal']->gst; ?></div>
                        </div>
                        
                        <div>
                            <div class="info-label">WH Tax</div>
                            <div class="info-value"><?php echo $GetInvoiceReceipt['GeneralJournal']->stampduty; ?></div>
                        </div>
                        
                        <div>
                            <div class="info-label">Other Expenses</div>
                            <div class="info-value"><?php echo $GetInvoiceReceipt['GeneralJournal']->OtherExp; ?></div>
                        </div>
                        
                        <div>
                            <div class="info-label">Late Payment</div>
                            <div class="info-value"><?php echo $GetInvoiceReceipt['GeneralJournal']->LatePayment; ?></div>
                        </div>
                        
                        <div>
                            <div class="info-label">Additional Income Tax</div>
                            <div class="info-value"><?php echo $GetInvoiceReceipt['GeneralJournal']->itax; ?></div>
                        </div>
                        
                        <div>
                            <div class="info-label">Total Deduction</div>
                            <div class="amount-value info-value"><?php echo $GetInvoiceReceipt['GeneralJournal']->Detail; ?></div>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="<?php echo base_url(); ?>InvoiceReceipt/" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Main
                    </a>
                    <a href="<?php echo base_url(); ?>InvoiceReceipt/AddInvoiceReceipt" class="btn btn-danger">
                        <i class="fas fa-plus me-1"></i> Add New Record
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer would be loaded here -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>