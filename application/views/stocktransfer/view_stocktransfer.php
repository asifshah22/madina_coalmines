<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-medkit"></i>&nbsp;Stock Transfer</h1>
    </section>
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">View Stock Transfer Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="form-group">
                    <div class="col-xs-12 col-md-12">
                      <?php echo $this->session->flashdata('record_added'); ?>
                    </div>
                  </div>
            <form role="form" class="form-horizontal" enctype="multipart/form-data" action='<?php echo base_url("StockTransfer/SaveStockTransfer"); ?>' method="post"> 

        <div class="box-body">
                <div class="row invoice-info">
            
            <div class="col-sm-6 invoice-col">
              <address>
                <strong>Stock Transfer #:</strong><br>
                <span style="color:#3333CC; font-size:13px; font-weight:bold;"><?= $StockTransferDetail->StockId; ?></span>
              </address>
            </div>

            <div class="col-sm-6 invoice-col">
              <address>
                <strong>Stock Transfer Date:</strong><br>
                    <?php echo date('M d, Y',strtotime($StockTransferDetail->InOutDate)); ?>
                </address>
            </div>

            <div class="col-sm-6 invoice-col">
              <address>
                <strong>Product Name:</strong><br>
                  <?php echo $StockTransferDetail->ProductName; ?>
                </address>
            </div>

						<div class="col-sm-6 invoice-col">
              <address>
                <strong>Stock Available In:</strong><br>
	                 <?php echo $StockTransferDetail->LocationName; ?>
                </address>
	         </div>

						<div class="col-sm-6 invoice-col">
              <address>
                <strong>Colour:</strong><br>
	               <?php echo $StockTransferDetail->ColourName; ?>
               </address>
	          </div>

							<div class="col-sm-6 invoice-col">
              <address>
                <strong>Quantity:</strong><br>
	                 <?php echo $StockTransferDetail->Quantity; ?>
	            </address>
            </div>

	                        </div>

 <div class="box-body">
               <div class="row">
    <div class='col-md-2'>
     <a href="<?php echo base_url(); ?>StockTransfer/AddStockTransfer" class="btn btn-block btn-primary">Add Record</a>
    </div>   
               <div class="col-md-2">
               <a href="<?php echo base_url(); ?>StockTransfer/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block btn-primary">Back to Main</button></a>
                </div>
               </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
       </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<?php
$this->load->view('includes/footer');
?>