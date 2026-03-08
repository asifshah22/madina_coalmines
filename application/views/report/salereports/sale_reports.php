<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<script>
$(document).ready(function(){

    $.ajax({url:"<?=base_url(); ?>SaleReports/SaleDetailReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});


//        $("#show_report_criteria").load('SaleReports/SaleDetailReportCriteria');


  $("#SaleInvoice_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>SaleReports/SalesInvoiceDetailReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  }); 
  
  $("#SaleDetail_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>SaleReports/SaleDetailReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#CustomerSaleDetail_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SaleReports/CustomerSaleDetailReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#CustomerSaleSummary_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SaleReports/CustomerSaleSummaryReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  
  $("#ProductSaleSummary_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SaleReports/ProductSaleSummaryReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
   $("#Quotation_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>SaleReports/QuotationReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  $("#SalesOrder_ProductWiseSummary_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>SaleReports/SalesOrderProductWiseSummaryReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#SalesOrder_ProductWiseDetail_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>SaleReports/SalesOrderProductWiseDetailReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#SalesOrderSummary_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SaleReports/SalesOrderSummaryReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#SalesOrderCustomerWiseDetail_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SaleReports/SalesOrderCustomerWiseDetailReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#SalesOrderDetail_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SaleReports/SalesOrderDetailReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#CancelSalesOrderCustomerWiseDetail_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SaleReports/CancelSalesOrderCustomerWiseDetailReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#CustomerWise_Invoice_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SaleReports/CustomerWiseInvoiceReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#customer_report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SaleReports/CustomerReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

  $("#SaleReturn_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SaleReports/SaleReturnReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

$("#CustomerProductSaleSummary_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SaleReports/CustomerProductSaleSummaryReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

});
</script>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-file-text-o"></i>&nbsp;Sales Reports</h1>
    </section>
    
  <!-- Main content -->
    <section class="content">
     <!-- <div class="row">-->
       <div class="box box-info">
           
         <div class="box-body">
           <div class="row">
             <div class="col-md-12">
                
               <div class="col-md-4">	
                 <div class="box-header with-border">
                    
		    <div class="form-group">
                     <a id="SaleDetail_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Sale Report
                     </a>
                    </div>
		    <div class="form-group">
                     <a id="SaleReturn_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Sale Return Report
                     </a>
                    </div>
        <div class="form-group">
                     <a id="SaleInvoice_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Sale Invoice Report
                     </a>
                    </div>
                    
         <div class="form-group">
                    <a id="Quotation_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                    <i class="fa fa-file-text-o"></i>Quotation Report
                    </a>
        </div>

		    <!-- <div class="form-group">
                     <a id="ProductSaleSummary_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Product Sale Summary
                     </a>
                    </div>
		    <div class="form-group">
                     <a id="CustomerSaleDetail_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Customer Sale Detail
                     </a>
                    </div>
		    <div class="form-group">
                     <a id="CustomerSaleSummary_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Customer Sale Summary
                     </a>
                    </div>
		    <div class="form-group">
                     <a id="CustomerProductSaleSummary_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Customer Sale Summary Product Wise
                     </a>
                    </div>   -->

                 </div>
               </div>
      	
		<?php //echo form_open("SalesOrder/ShowReport"); ?> 
                <div style="border:0px solid;" class="col-md-8">
                    <center>
                       <img id="loader" src="<?php echo base_url(); ?>lib/img/loader.gif" style="margin-right:35%; display:none;" />
                    </center>
                   <div id="show_report_criteria">



                 </div>
                 <?php  // echo form_close(); ?> 
                <div id="dialog"></div>
              </div>
            <!-- /.col -->
          </div>    
        
        </div>
      <!-- /.box-body -->
      </div>
      <!-- /.box-info -->
      </div>
      <!-- /.box-info -->
    </section>
    <!-- /.content -->    
    
  </div>
  <!-- /.content-wrapper -->
	
<script>

     $(function(){

      $("body").on("click","#generate_sale_invoice_report",function(){
      var InvoiceNo = $("#InvoiceNo").val();
      
      $('.cbCheck:checkbox:checked').each(function(){
      ledger = $(this).val();
      });
      
      window.open("<?php echo site_url(); ?>SaleReports/ViewSaleInvoiceReport?InvoiceNo="+InvoiceNo+"&ledger="+ledger,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
    
    $(function(){
	$("body").on("click","#generate_customer_sale_detail_report",function(){
        var CustomerId = $("#CustomerId").val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>SaleReports/CustomerSaleDetailReport?CustomerId="+CustomerId+"&StartDate="+StartDate+"&EndDate="+EndDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
    });

  $(function(){
  $("body").on("click","#generate_sale_detail_report",function(){
        var CustomerId = $('#CustomerId').val();
        var SalemanId = $('#SalemanId').val();
        var Counter = $('#Counter').val();
        var ReferenceId = $('#ReferenceId').val();
        var ProductId = $('#ProductId').val();
        var LocationId = $('#LocationId').val();
        var SaleType = $('#SaleType').val();
        var SaleMethod = $('#SaleMethod').val();
        var ColourId = $('#ColourId').val();
        var CategoryId = $('#CategoryId').val();
        var ProductGroupId = $('#ProductGroupId').val();
        var BrandId = $('#BrandId').val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>SaleReports/SaleDetailReport?StartDate="+StartDate+"&EndDate="+EndDate+"&CustomerId="+CustomerId+"&SalemanId="+SalemanId+"&Counter="+Counter+"&ReferenceId="+ReferenceId+"&ProductId="+ProductId+"&LocationId="+LocationId+"&SaleType="+SaleType+"&SaleMethod="+SaleMethod+"&ColourId="+ColourId+"&CategoryId="+CategoryId+"&ProductGroupId="+ProductGroupId+"&BrandId="+BrandId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
    });

  $(function(){
  $("body").on("click","#generate_sale_return_report",function(){
        var CustomerId = $('#CustomerId').val();
        var ProductId = $('#ProductId').val();
        var LocationId = $('#LocationId').val();
        var ColourId = $('#ColourId').val();
        var CategoryId = $('#CategoryId').val();
        var ProductGroupId = $('#ProductGroupId').val();
        var BrandId = $('#BrandId').val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>SaleReports/ViewSaleReturnReport?StartDate="+StartDate+"&EndDate="+EndDate+"&CustomerId="+CustomerId+"&ProductId="+ProductId+"&LocationId="+LocationId+"&ColourId="+ColourId+"&CategoryId="+CategoryId+"&ProductGroupId="+ProductGroupId+"&BrandId="+BrandId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
    });  

     
     
     $(function(){
      $("body").on("click","#generate_customer_report",function(){
    
      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();
    
      window.open("<?php echo site_url(); ?>SaleReports/GeneratCustomerReport?StartDate="+SDate+"&EndDate="+EDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });
      
    $(function(){

      $("body").on("click","#generate_quotation_report",function(){
      var QuotationNo = $("#QuotationNo").val();

      window.open("<?php echo site_url(); ?>SaleReports/ViewQuotationeReport?QuotationNo="+QuotationNo,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
    });
 </script>
 <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
    </div>
    <!-- Default to the left -->
  </footer>
<!-- ./wrapper -->
<?php $this->load->view("includes/footer"); ?>