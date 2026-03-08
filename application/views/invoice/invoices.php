<?php $this->load->view("includes/header");
$this->load->view("includes/sidebar");
?> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><i class="fa fa-edit"></i>&nbsp;Sales Invoice</h1>
    </section> 
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           
          <div class="box box-info">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body ">
              <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_added')."</font>"; ?>
              <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_delete')."</font>"; ?>
              <table id="invoice-grid" class="table table-striped" class="table table-bordered table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                <thead>
                  <tr>
                  <th>Invoice: #</th>
                  <th>S.Order #</th>
                  <th>Date</th>
                  <th>Customer</th>
                  <th>Net Amount</th>
                  <th>Actions</th>
                </tr>
               </thead> 
             </table>
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