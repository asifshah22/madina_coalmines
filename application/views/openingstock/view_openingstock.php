<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-medkit"></i>&nbsp;Opening Stock</h1>
    </section>
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">View Opening Stock Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" class="form-horizontal" enctype="multipart/form-data" action='<?php echo base_url("Opening Stock/SaveOpening Stock"); ?>' method="post"> 
              <div class="box-body">
                <div class="form-group">
                    <div class="col-xs-12 col-md-12">
                      <?php echo $this->session->flashdata('record_added'); ?>
                    </div>
                  </div>

						            <div class="col-md-6">
                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Opening Stock.#:</div>
                            <div class="col-sm-8 col-sm-8"><?= $OpeningStockDetail->StockId; ?></div>
                          </div>

                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Opening Stock Date:</div>
                            <div class="col-sm-8 col-sm-8"><?php echo date("M d, Y", strtotime($OpeningStockDetail->InOutDate)); ?></div>
                          </div>

                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Product Name:</div>
                            <div class="col-sm-8 col-sm-8"><?php echo $OpeningStockDetail->ProductName; ?></div>
                          </div>

                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Rate:</div>
                            <div class="col-sm-8 col-sm-8"><?php echo $OpeningStockDetail->Rate; ?></div>
                          </div>
                        </div>
                          

						            <div class="col-md-6">
							             <div class="form-group">
	                            <div style="font-weight:600;" class="col-sm-4">Stock Available In:</div>
	                            <div class="col-sm-8 col-sm-8"> <?php echo $OpeningStockDetail->LocationName; ?></div>
	                          </div>

							             <div class="form-group">
	                            <div style="font-weight:600;" class="col-sm-4">Colour:</div>
	                            <div class="col-sm-8 col-sm-8"> <?php echo $OpeningStockDetail->ColourName; ?></div>
	                          </div>

							             <div class="form-group">
	                            <div style="font-weight:600;" class="col-sm-4">Quantity:</div>
	                            <div class="col-sm-8 col-sm-8"> <?php echo $OpeningStockDetail->Quantity; ?></div>
	                          </div>

                            <div class="form-group">
                              <div style="font-weight:600;" class="col-sm-4">Total Amount:</div>
                              <div class="col-sm-8 col-sm-8"> <?php echo $OpeningStockDetail->Amount; ?></div>
                            </div>
	                      </div>
	                   </div>

          <div class="box-body">
            <div class="row">
              
              <div class='col-md-2'>
                <a href="<?php echo base_url(); ?>OpeningStock/AddOpeningStock" class="btn btn-block btn-primary">Add Record</a>
              </div>

              <div class="col-md-2">
                <a href="<?php echo base_url(); ?>OpeningStock/"><button type="button" name="" value="" class="btn btn-block btn-primary">Back to Main</button></a>
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