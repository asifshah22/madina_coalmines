<?php 
$this->load->view('includes/header');
$this->load->view('includes/sidebar');
?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-clipboard"></i>&nbsp;Finished Products</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
          <div class="box box-info">
            <div class="box-header with-border col-md-12">
              <h3 class="box-title text-light-blue">View Finished Product</h3>
            </div>
	    <?php
	    $TotalCurrentQty = 0;
	    $TotalFinishedProductsQty = 0;
	    ?>
	    <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>
	    
	    <div class="box-body">
	      <div class="row invoice-info">
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Production #:</strong><br>
		    <span style="color:#3333CC; font-size:13px; font-weight:bold;"><?php echo $FinishedProducts[0]['ProductionNo']; ?></span>
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Finished Date:</strong><br>
		    <div class="input-group date"><?php print date('M d, Y', strtotime($FinishedProducts[0]['FinishedDate'])); ?></div>
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Product:</strong><br>
		     <?php echo $FinishedProducts[0]['ProductName']; ?>
                  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Mill Serial #:</strong><br>
		   		<?php echo $FinishedProducts[0]['MillSerialNo']; ?>
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Shift:</strong><br>
		    <div class="input-group date"><?php print $FinishedProducts[0]['Shift']; ?></div>
		  </address>
		</div>        		
	      </div>
	    <?php

		$TotalQuantity = '';
		$TotalWeight = 0;
	    ?>
            <div class="row">
		<div class="col-md-12">
		  <div class="box-body pad table-responsive">
		    <table class='table table-bordered text-center' id="Purchase_EntriesTable">
		     <tr style="background-color:#ECF9FF;">
		      <th style="padding:5px;">S.#</th>
		      <th style="padding:5px;">Product Quality</th>
		      <th style="padding:5px; text-align:center;">Reel Size</th>
		      <th style="padding:5px; text-align:center;">Quantities</th>
		      <th style="padding:5px; text-align:center;">Weight</th>
		     </tr>
		     <?php
		      $SNo = 1;
		      $TotalQuantities = 0;
		      foreach($FinishedProductsDetail as $Record) {
	     	    ?>
		    <tr>
		    <td style='padding:5px; width:2%;'><?php echo $SNo; ?></td>
		    <td style='padding:5px; width:10%; text-align:center;'><?php echo $Record['ProductQuality']; ?></td>
		    <td style='padding:5px; width:10%; text-align:right;'><?php echo $Record['ReelSize']; ?></td>
		    <td style='padding:5px; width:10%; text-align:right;'><?php echo $Record['Quantity']; ?></td>
		    <td style='padding:5px; width:20%; text-align:right;'><?php echo $Record['Weight']; ?></td>
		    </tr>
		     <?php 
		     $SNo++; 
		     $TotalQuantities += $Record['Quantity'];
		     $TotalWeight += $Record['Weight'];
		     } ?>
		     </table>
		     <table class="table table-bordered text-center">
		     <tr>
		      <td colspan="4" style="width:42%; text-align:right; font-weight:600;">Total Weight</td>
		      <td style="width:10%;"><div style='font-weight:600; color:#3333CC; text-align:right;'><?php echo $TotalWeight; ?></div></td>
		     </tr>	
		    </table>
		  </div>
		</div>
	      </div>
	      <?php // } ?>	
	      <div class="box-body">
		<div class="row">
		  <div class="col-md-2">
		      <a href="<?php echo base_url(); ?>FinishedProducts/AddFinishedProduct" class="btn btn-block btn-primary">Add Record</a>
		  </div>
		  <div class="col-md-2">
		    <a href="<?php echo base_url(); ?>FinishedProducts/" class="btn btn-block bg-orange">Back to main</a>
		  </div>
		</div>
	      </div>
            </div>
        </div>
  </section>
  </div>
<?php $this->load->view('includes/footer'); ?>