<?php 
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?> 
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-book"></i>&nbsp;Bank Receipt Voucher</h1>
    </section>
        <?php if($this->session->flashdata('messag_accounts') != ''){?>
            <div class="alert alert-success" role="alert" >
        <?php echo $this->session->flashdata('messag_accounts');?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
       <?php }?> 
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           
          <div class="box box-info">
            <div class="box-header"></div>
            <!-- /.box-header -->
            <div class="box-body ">
            <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_added')."</font>"; ?>
              <table id="bankreceiptvoucher-grid" class="table table-striped" class="table table-bordered table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%" >
                  <thead>
                  <tr>
                  <th>Transaction Date</th>
                  <th>Reference</th>
		  <th>Voucher Type</th>
                  <th>Amount</th>
                  <th>Actions</th>
                </tr>
                </thead>
              </tbody>
              </table>
              <?php 
	      if ($AccountsRoles[0]['AddRoles']==1) { ?>
              <div class="box-footer col-md-2 col-sm-4 col-xs-6">
                <a href="<?php echo base_url(); ?>BankReceiptVoucher/AddBRV" class="btn btn-primary">Add Record</a>
              </div>
              <?php } ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->  
  </div>
<?php $this->load->view("includes/footer"); ?> 

