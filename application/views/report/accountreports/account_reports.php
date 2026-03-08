<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<script>
$(document).ready(function(){

  $("#LedgerReport_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>AccountReports/LedgerReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#CustomerLedgerSummaryReport_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>AccountReports/CustomerLedgerSummaryReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  
  $("#VendorLedgerSummaryReport_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>AccountReports/VendorLedgerSummaryReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#TrialBalance_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>AccountReports/TrialBalanceReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
    $("#Aging_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>AccountReports/AgingReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  
  $("#IncomeStatement_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>AccountReports/IncomeStatementReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#BalanceSheet_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>AccountReports/BalanceSheetReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

  $("#ChartOfAccount_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>AccountReports/ChartOfAccountReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

  $("#CustomerBalanceSummary_Report").click(function(){
   $.ajax({url:"<?=base_url(); ?>AccountReports/CustomerBalanceSummaryReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#CustomerOutstanding_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>AccountReports/CustomerOutstandingReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

  $("#VendorOutstanding_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>AccountReports/VendorOutstandingReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

  $("#CashBook_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>AccountReports/CashBookReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

  $("#BankBook_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>AccountReports/BankBookReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

  $("#AccountReceivableAging_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>AccountReports/AccountReceivableAgingReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

  $("#AccountPayableAging_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>AccountReports/AccountPayableAgingReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

  $("#CashPaymentFlow_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>AccountReports/CashPaymentFlowCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

  $("#Voucher_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>AccountReports/VoucherCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

  $("#Activity_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>AccountReports/ActivityCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

  $("#SalemanSaleAndRecovery_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>AccountReports/SalemanSaleAndRecoveryReportCriteria",
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
      <h1><i class="fa fa-file-text-o"></i>&nbsp; Accounts Reports</h1>
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
          	      <a id="LedgerReport_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>General Ledger Report
                     </a>
                    </div>
                    
                    <div class="form-group">
          	      <a id="CustomerLedgerSummaryReport_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Customer Ledger Summary Report
                     </a>
                    </div>
		    <div class="form-group">
          	      <a id="VendorLedgerSummaryReport_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Vendor Ledger Summary Report
                     </a>
                    </div>

		    <div class="form-group">
                      <a id="IncomeStatement_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Income Statement Report
                      </a>
                    </div>

      <div class="form-group">
                      <a id="ChartOfAccount_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Chart of Account Report
                      </a>
                    </div>

                    <div class="form-group">
                      <a id="VendorOutstanding_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Vendor Outstanding Report
                      </a>
                    </div>
		    <div class="form-group">
                      <a id="CustomerOutstanding_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Customer Recovery Report
                      </a>
                    </div>
                    
                    <div class="form-group">
                      <a id="Voucher_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Voucher Report
                      </a>
                    </div>

                    <div class="form-group">
                      <a id="Activity_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Daily Activity Report
                      </a>
                    </div>

                    <div class="form-group">
          	      <a id="SalemanSaleAndRecovery_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Saleman Sale & Recovery Report
                     </a>
                    </div>
                     
                    
                    
	    <div class="form-group">
                      <a id="TrialBalance_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Trial Balance Report
                      </a>
                    </div>
                    <div class="form-group">
                      <a id="Aging_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Aging Report
                      </a>
                    </div>
<!-- 			    <div class="form-group">
                      <a id="BalanceSheet_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Balance Sheet Report
                      </a>
                    </div>
                    <div class="form-group">
                      <a id="CashBook_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Cash Book Report
                      </a>
                    </div>
                    <div class="form-group">
                      <a id="BankBook_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Bank Book Report
                      </a>
                    </div> -->
<!--                     <div class="form-group">
                      <a id="AccountReceivableAging_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Account Receivable Aging
                      </a>
                    </div>
                    <div class="form-group">
                      <a id="AccountPayableAging_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Account Payable Aging
                      </a>
                    </div>
                    <div class="form-group">
                      <a id="CashPaymentFlow_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Cash Payment Flow Report
                      </a>
                    </div>

                     -->

                 </div>
               </div>
      	 
	        <div style="border:0px solid;" class="col-md-8">
                    <center>
                        <img id="loader" src="<?php echo base_url(); ?>lib/img/loader.gif" style="margin-right: 35%; display: none;" />
                    </center>
                 <div id="show_report_criteria">
                   
                   <div style="border:0px solid; width:40%; margin-left:190px;" class="box-header with-border">
                   <h3 class="box-title text-light-blue">General Ledger Reports</h3>
               	   </div>

		    <div class="form-group">
                     <label style="width:24%;" for="CategoryCode" class="col-sm-1 control-label">Category:</label>
		       <div class="input-group date">
                         <select style="width:300px;" class="select2" id="CategoryId" name="CategoryId">
                         <option value="0">Select Category</option>
                         <?php foreach($CategoryCode as  $CategoryValues)
                         {
                          echo '<option value="'.$CategoryValues["ChartOfAccountCategoryId"].'"> '.$CategoryValues['CategoryName'].' </option>';
                         }
                         ?>
                         </select>
		       </div>           
                   </div>
                   <div class="form-group">
                     <label style="width:24%;" for="ControlCode" class="col-sm-1 control-label">Control Code:</label>
		       <div class="input-group date">
                         <select style="width:300px;" class="select2" id="ControlCodeId" name="ControlCodeId">
                         <option value="0">Select Control Code</option>
                         </select>
		       </div>           
                   </div>
                   <div class="form-group">
                     <label style="width:24%;" for="ChartOfAccount" class="col-sm-1 control-label">Chart Of Account:</label>
		        <div class="input-group date">
                         <select style="width:300px;" class="select2" id="ChartOfAccountId" name="ChartOfAccountId">
                         <option value="0">Select Chart Of Account</option>
                         </select>
		        </div>           
                   </div>

                   
                    <div class="form-group">
                      <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Start Range:</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                           <i class="fa fa-calendar"></i>
                          </div>                  
        		              <input class="form-control" name="StartDate" id="datepicker1" type="text" placeholder="Enter Start Date" style="width:40%;" value="" autocomplete="off">
                        </div>                  
                    </div>

                   <div class="form-group">
                     <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">End Range:</label>
                       <div class="input-group date">
                         <div class="input-group-addon">
                           <i class="fa fa-calendar"></i>
                         </div>     
                         <input class="form-control" name="OrderDate" id="datepicker2" type="text" placeholder="Enter Start Date" style="width:40%;" value="<?php // echo  date('m/d/Y',strtotime('1/1/2018')); //date('m/d/Y'); ?>" autocomplete="off">
                       </div>                  
              	   </div>
                   <div class="form-group">
                     <label style="width:24%;" class="col-sm-2"></label>
                       <div class="input-group date">
                         <button type="button" id="generate_ledger_report" class="btn  btn-primary">Show Report</button>
                       </div>                  
                   </div> 
                 </div>

              </div>
            <!-- /.col -->
          </div>    
        </div>
      <!-- /.box-body -->
      </div>
      <!-- /.box-info -->
       </div>
    </section>
    <!-- /.content -->    
    
  </div>
  <!-- /.content-wrapper -->
 <script>
    $(function(){
      $("body").on("click","#generate_ledger_report",function(){
 
        var CustomerId = $("#CustomerId").val();
	      var VendorId = $("#VendorId").val();
        var BId = $("#BankId").val();
        var BAId = $("#AccountId").val();
        var CId = $("#CategoryId").val();
        var CCId = $("#ControlCodeId").val();
        var COAId = $("#ChartOfAccountId").val();
        var SDate = $("#datepicker1").val();
        var EDate = $("#datepicker2").val();
	
        window.open("<?php echo site_url(); ?>AccountReports/LedgerReport?StartDate="+SDate+"&EndDate="+EDate+"&BId="+BId+"&BAId="+BAId+"&CId="+CId+"&CCId="+CCId+"&COAId="+COAId+"&CustomerId="+CustomerId+"&VendorId="+VendorId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
      
      $(function(){
      $("body").on("click","#customer_ledger_summary_report",function(){
 
        var CustomerId = $("#CustomerId").val();
        var BId = $("#BankId").val();
        var BAId = $("#AccountId").val();
        var CId = $("#CategoryId").val();
        var CCId = $("#ControlCodeId").val();
        var COAId = $("#ChartOfAccountId").val();
        var SDate = $("#datepicker1").val();
        var EDate = $("#datepicker2").val();
	
        window.open("<?php echo site_url(); ?>AccountReports/CustomerLedgerSummaryReport?StartDate="+SDate+"&EndDate="+EDate+"&BId="+BId+"&BAId="+BAId+"&CId="+CId+"&CCId="+CCId+"&COAId="+COAId+"&CustomerId="+CustomerId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
      
      
      $(function(){
      $("body").on("click","#vendor_ledger_summary_report",function(){
 
       
	var VendorId = $("#VendorId").val();
        var BId = $("#BankId").val();
        var BAId = $("#AccountId").val();
        var CId = $("#CategoryId").val();
        var CCId = $("#ControlCodeId").val();
        var COAId = $("#ChartOfAccountId").val();
        var SDate = $("#datepicker1").val();
        var EDate = $("#datepicker2").val();
	
        window.open("<?php echo site_url(); ?>AccountReports/VendorLedgerSummaryReport?StartDate="+SDate+"&EndDate="+EDate+"&BId="+BId+"&BAId="+BAId+"&CId="+CId+"&CCId="+CCId+"&COAId="+COAId+"&VendorId="+VendorId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
      
    //   $(function(){
    //   $("body").on("click","#generate_trialbalance_report",function(){
 
    //     var CId = $("#CategoryId").val();
    //     var CCId = $("#ControlCodeId").val();
    //     var COAId = $("#ChartOfAccountId").val();
    //     var SDate = $("#datepicker1").val();
    //     var EDate = $("#datepicker2").val();
    //     window.open("<?php echo site_url(); ?>AccountReports/GeneratTrialBalanceReport?StartDate="+SDate+"&EndDate="+EDate+"&CId="+CId+"&CCId="+CCId+"&COAId="+COAId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
    //     });
    //   });
      
    $(function(){
      $("body").on("click","#generate_trialbalance_report",function(){
 
        
          var ControlCodeId = $("#ControlCodeId").val();
        var CategoryId = $("#CategoryId").val();
        window.open("<?php echo site_url(); ?>AccountReports/TrialBalanceReport?ControlCodeId="+ControlCodeId+"&CategoryId="+CategoryId,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        
      });
      });
      $(function(){
      $("body").on("click","#generate_aging_report",function(){
 
        var CustomerId = $("#ChartOfAccountId").val();
	
        window.open("<?php echo site_url(); ?>AccountReports/AgingReport?ChartOfAccountId="+CustomerId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
    
        });
      });
      $(function(){
      $("body").on("click","#generate_incomestatement_report",function(){
 
        var SDate = $("#datepicker1").val();
        var EDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>AccountReports/ViewIncomeStatementReport?StartDate="+SDate+"&EndDate="+EDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
      
      $(function(){
      $("body").on("click","#generate_balancesheet_report",function(){

        var AsOfDate = $("#datepicker1").val();
        window.open("<?php echo site_url(); ?>AccountReports/GeneratBalanceSheetReport?AsOfDate="+AsOfDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
      
    $(function(){
      $("body").on("click","#generate_chartofaccount_report",function(){
        var ControlCodeId = $("#ControlCodeId").val();
        var CategoryId = $("#CategoryId").val();
        window.open("<?php echo site_url(); ?>AccountReports/ChartOfAccountReport?ControlCodeId="+ControlCodeId+"&CategoryId="+CategoryId,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
      
 // coder for ledger report criteria
 $(function(){
     //Load bank account
     $(document).on('change','#BankId',function(){
        var Bid = $('#BankId').val(); 
        $('#AccountDiv').load("<?php echo base_url('Accounts/GetAccountByBankId')?>",
        {bankId:Bid});
     });
     
    //load Control cod
      $(document).on('change','#CategoryId',function(){
//        alert('test');
        var CatId = $('#CategoryId').val();
        $('#ControlCode').load("<?php echo base_url('ChartOfAccount/ControlCode/dropdown')?>",
       {id:CatId});
     });
     
     //load chart of account
      $(document).on('change','#ControlCodeId',function(){
//        alert($(this).val());
/*        var CCId = $('#ControlCodeId').val();
        $('#ChartOfAccountId').load("<?php echo base_url('ChartOfAccount/GetChartOfAccountList/dropdown')?>",
        {id:CCId});*/
     });
 });

       $(function(){
      $("body").on("click","#generate_customeroutstanding_report",function(){
        var ChartOfAccountId = $("#ChartOfAccountId").val();
        var AreaName = $("#AreaId").val();
		    var SDate = $("#datepicker1").val();
        var EDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>AccountReports/CustomerOutstandingReport?ChartOfAccountId="+ChartOfAccountId+"&AreaId="+AreaName+"&StartDate="+SDate+"&EndDate="+EDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });

      $(function(){
      $("body").on("click","#generate_vendoroutstanding_report",function(){
        var ChartOfAccountId = $("#ChartOfAccountId").val();
		var SDate = $("#datepicker1").val();
        var EDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>AccountReports/VendorOutstandingReport?ChartOfAccountId="+ChartOfAccountId+"&StartDate="+SDate+"&EndDate="+EDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });

      $(function(){
      $("body").on("click","#generate_cashbook_report",function(){
        /*var CustomerId = $("#CustomerId").val();
        var VendorId = $("#VendorId").val();
        var BId = $("#BankId").val();
        var BAId = $("#AccountId").val();*/
/*        var CId = $("#CategoryId").val();
        var CCId = $("#ControlCodeId").val();*/
        var CId = 1;
        var CCId = 1;
        var COAId = $("#ChartOfAccountId").val();
        var SDate = $("#datepicker1").val();
        var EDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>AccountReports/GenerateCashBookReport?StartDate="+SDate+"&EndDate="+EDate+"&CId="+CId+"&CCId="+CCId+"&COAId="+COAId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });

      $(function(){
      $("body").on("click","#generate_bankbook_report",function(){
//        var CId = $("#CategoryId").val();
//        var CCId = $("#ControlCodeId").val();
        var CId = 1;
        var CCId = 4;
        var COAId = $("#ChartOfAccountId").val();
        var SDate = $("#datepicker1").val();
        var EDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>AccountReports/GenerateBankBookReport?StartDate="+SDate+"&EndDate="+EDate+"&CId="+CId+"&CCId="+CCId+"&COAId="+COAId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });

      $(function(){
      $("body").on("click","#generate_accountreceivable_aging_report",function(){
        var AsOfDate = $("#datepicker1").val();
        window.open("<?php echo site_url(); ?>AccountReports/GenerateAccountReceivableAgingReport?AsOfDate="+AsOfDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });

      $(function(){
      $("body").on("click","#generate_accountpayable_aging_report",function(){
        var AsOfDate = $("#datepicker1").val();
        window.open("<?php echo site_url(); ?>AccountReports/GenerateAccountPayableAgingReport?AsOfDate="+AsOfDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });

      $(function(){
      $("body").on("click","#generate_cashpayment_flow_report",function(){
 
        var SDate = $("#datepicker1").val();
        var EDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>AccountReports/GenerateCashFlowPaymentReport?StartDate="+SDate+"&EndDate="+EDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });

      $(function(){
      $("body").on("click","#generate_voucher_report",function(){
 
        var ReferencePrefix = $("#ReferencePrefix").val();
        var SDate = $("#datepicker1").val();
        var EDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>AccountReports/GenerateVoucherReport?StartDate="+SDate+"&EndDate="+EDate+"&ReferencePrefix="+ReferencePrefix,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });

      $(function(){
      $("body").on("click","#generate_activity_report",function(){
 
        var Type = $("#type").val();
        var SDate = $("#datepicker1").val();
        var EDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>AccountReports/GenerateActivityReport?StartDate="+SDate+"&EndDate="+EDate+"&Type="+Type,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });

      $(function(){
      $("body").on("click","#saleman_sale_and_recovery_report",function(){
 
        var SalemanId = $("#SalemanId").val();
        var SDate = $("#datepicker1").val();
        var EDate = $("#datepicker2").val();
	
        window.open("<?php echo site_url(); ?>AccountReports/SalemanSaleAndRecoveryReport?StartDate="+SDate+"&EndDate="+EDate+"&SalemanId="+SalemanId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
 </script>
 <script>
 // coder for ledger report criteria
 $(function(){
     //Load bank account
     $(document).on('change','#BankId',function(){
        var Bid = $('#BankId').val(); 
        $('#AccountDiv').load("<?php echo base_url('Accounts/GetAccountByBankId')?>",
        {bankId:Bid});
     });
     
    //load Control cod
      $(document).on('change','#CategoryId',function(){
        var CatId = $('#CategoryId').val();
        $('#ControlCodeId').load("<?php echo base_url('ChartOfAccount/ControlCode/dropdown')?>",
       {id:CatId});
     });
     
     //load chart of account
      $(document).on('change','#ControlCodeId',function(){
        var CCId = $('#ControlCodeId').val();
        $('#ChartOfAccountId').load("<?php echo base_url('ChartOfAccount/GetChartOfAccountList/dropdown')?>",
        {id:CCId});
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