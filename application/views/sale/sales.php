<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="display:inline"><i class="fa fa-shopping-cart"></i>&nbsp;Sales</h1>
    </section>

        <?php if($this->session->flashdata('messag_accounts') != ''){?>
            <div class="alert alert-success" role="alert" >
          <?php echo $this->session->flashdata('messag_accounts');?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
         <?php }?> 
         
         <?php if($this->session->flashdata('fbr_success') != ''){?>
            <div class="alert alert-success" role="alert" >
          <?php echo $this->session->flashdata('fbr_success');?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
         <?php }?> 
         
         <?php if($this->session->flashdata('fbr_error') != ''){?>
            <div class="alert alert-danger" role="alert" >
          <?php echo $this->session->flashdata('fbr_error');?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
         <?php }?> 
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           
          <div class="box box-info">
            <div class="box-header">
    <!--          <h3 class="box-title">Total Records (<?php // print count($GetAllAccounts); ?>)</h3> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body ">
            <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_added')."</font>"; ?>
                    <table id="sale-grid"  class="table table-striped"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%" >
                      <thead>
                        <tr>
                          <th style="width:40px; text-align:center;">
                            <input type="checkbox" id="select-all-sales">
                          </th>
                          <th>Invoice No</th>
                         <th>Dc No</th>
                          <th>Sale Date</th>
                          <th>Sale Type</th>
                          <th>Saleman</th>
						 <th> Customer </th>
						 <th> Recipt Status </th>
						 <th> FBR Invocie No </th>
                          <th>Total Amount</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                    </table>
                    
                  <?php // if ($SalesRoles[0]['AddRoles'] == 1) {
                    ?>
<div class="row" style="margin-top:15px;">
<div class="col-md-12">

<div style="
background: linear-gradient(135deg,#f8fbff,#eef5ff);
border-radius:10px;
padding:15px 18px;
box-shadow:0 4px 12px rgba(0,0,0,0.08);
border-left:5px solid #4e73df;
">

<div class="row align-items-center">

<div class="col-sm-2" style="margin-bottom:10px;">
<a href="<?= base_url(); ?>Sales/AddSale" 
class="btn"
style="
background:linear-gradient(135deg,#4e73df,#224abe);
color:white;
border:none;
border-radius:6px;
padding:8px 16px;
font-weight:600;
box-shadow:0 3px 8px rgba(0,0,0,0.15);
">
<i class="fa fa-plus"></i> Add Record
</a>
</div>

<div class="col-sm-10">

<form action="<?= base_url(); ?>Sales/ImportSalesExcel" method="post" enctype="multipart/form-data" class="form-inline">

<div class="form-group" style="margin-right:10px;">
<input type="file" name="import_excel" class="form-control"
style="
border-radius:6px;
border:1px solid #d1d9e6;
padding:6px 10px;
background:#fff;
"
accept=".xlsx,.xls" required>
</div>

<button type="submit"
class="btn"
style="
background:linear-gradient(135deg,#e74a3b,#c0392b);
color:white;
border:none;
border-radius:6px;
padding:8px 16px;
font-weight:600;
box-shadow:0 3px 8px rgba(0,0,0,0.15);
margin-right:6px;
">
<i class="fa fa-upload"></i> Import Excel
</button>

<a href="<?= base_url(); ?>Sales/DownloadSalesImportTemplate"
class="btn"
style="
background:linear-gradient(135deg,#f6c23e,#dda20a);
color:black;
border:none;
border-radius:6px;
padding:8px 16px;
font-weight:600;
box-shadow:0 3px 8px rgba(0,0,0,0.15);
margin-right:6px;
">
<i class="fa fa-download"></i> Download Latest Template
</a>

<a href="#"
class="btn"
style="
background:linear-gradient(135deg,#6f42c1,#4b2e83);
color:white;
border:none;
border-radius:6px;
padding:8px 16px;
font-weight:600;
box-shadow:0 3px 8px rgba(0,0,0,0.15);
">
<i class="fa fa-database"></i> FBR POSTING
</a>

</form>

</div>
</div>
</div>
</div>
</div>
                    <?php
//                  } ?>
                </div><!-- /.span -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view('includes/footer'); ?>

<style>
  .qbo-dropdown.is-open .qbo-dropdown-content {
    display: block !important;
  }
</style>

  <script>
 $(function(){
     var selectedSales = {};

     function syncHeaderCheckbox() {
         var $rows = $('.sale-row-checkbox');
         var totalRows = $rows.length;
         var selectedRows = $rows.filter(':checked').length;
         $('#select-all-sales').prop('checked', totalRows > 0 && totalRows === selectedRows);
     }

     var dataTable = $('#sale-grid').DataTable( {
            'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [0, -1]
            }],
	    'order': [[ 1, "desc" ]],
            "processing": true,
            "serverSide": true,
            "drawCallback": function() {
                $('.sale-row-checkbox').each(function () {
                    var saleId = $(this).val();
                    $(this).prop('checked', !!selectedSales[saleId]);
                });
                syncHeaderCheckbox();
            },
            "ajax":{
                url :"<?php echo base_url('Sales/Ajax_GetAllSales')?>", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".sale-grid-error").html("");
                    $("#sale-grid").append('<tbody class="employee-grid-error"><tr><th colspan="5">No data found in the server</th></tr></tbody>');
                    $("#sale-grid_processing").css("display","none");
 
                }
            }
        } ); 

        $(document).on('change', '#select-all-sales', function() {
            var isChecked = $(this).is(':checked');
            $('.sale-row-checkbox').each(function () {
                var saleId = $(this).val();
                $(this).prop('checked', isChecked);
                if (isChecked) {
                    selectedSales[saleId] = true;
                } else {
                    delete selectedSales[saleId];
                }
            });
        });

        $(document).on('change', '.sale-row-checkbox', function() {
            var saleId = $(this).val();
            if ($(this).is(':checked')) {
                selectedSales[saleId] = true;
            } else {
                delete selectedSales[saleId];
            }
            syncHeaderCheckbox();
        });

        $(document).on('click', '.qbo-dropbtn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var $dropdown = $(this).closest('.qbo-dropdown');
            $('.qbo-dropdown').not($dropdown).removeClass('is-open');
            $dropdown.toggleClass('is-open');
        });

        $(document).on('click', '.qbo-dropdown-content', function(e) {
            e.stopPropagation();
        });

        $(document).on('click', function() {
            $('.qbo-dropdown').removeClass('is-open');
        });
 });   
</script>
