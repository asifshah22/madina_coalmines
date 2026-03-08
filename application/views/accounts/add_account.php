<?php 
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<script src="<?=site_url();?>/lib/js/autocompletejs/jquery-ui.js"></script>
<link rel="stylesheet" href="<?=site_url();?>/lib/css/autocompletecss/jquery-ui.css" />  
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1><i class="fa fa-bank"></i>&nbsp;Bank Account</h1>
    </section>

  <!-- Main content -->
     <section class="content">
         <div class="row">
          <div class="col-md-12">
          <!-- form elements  --> 
          <div id="showresult">
              <div class="box box-info">
          
            <!-- /.box-header -->
            <form role="form" class="form-horizontal" method="post" id="accountform" action='<?php echo site_url("BankAccount/SaveAccount")?>'> 
  <!--      <form role="form" class="form-horizontal" id="userform" enctype="multipart/form-data" action="<?php // echo base_url(); ?>/Category/SaveCategory" method="post">--> 
              
                <div class="box-header with-border">
              <h3 class="box-title">Add Bank Information</h3>
            </div>
              <div class="box-body" id="bankDropDown">
              </div>
                
               <div class="box-body">
                <div class="form-group">
                  <label for="AccountTitle" class="col-sm-1 control-label">Account Title:</label>
                   <div class="col-sm-4">
                       <input type="text" class="form-control" name="AccountTitle" id="AccountTitle" required="required" >
                  </div>
                </div>
              </div> 
              <div class="box-body">
                <div class="form-group">
                  <label for="AccountNumber" class="col-sm-1 control-label">Account Number:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="AccountNumber" id="AccountNumber" required="required" >
                  </div> &nbsp; &nbsp;
                <span id="VerifyAccountNumber"></span>
                </div>
              </div> 
              <div class="box-body">
                <div class="form-group">
                  <label for="BranchName" class="col-sm-1 control-label">Branch Name:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="BranchName" id="BranchName" required="required">
                  </div>
                </div>
              </div> 
              <div class="box-body">
                <div class="form-group">
                  <label for="BranchName" class="col-sm-1 control-label">Branch Number:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="BranchNumber" id="BranchNumber" >
                  </div>
                </div>
              </div> 
              <div class="box-body">
                <div class="form-group">
                  <label for="BranchCode" class="col-sm-1 control-label">Branch Code:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="BranchCode" id="BranchCode" >
                  </div>
                </div>
              </div> 
              <div class="box-body">
                <div class="form-group">
                  <label for="ContactPerson" class="col-sm-1 control-label">Contact Person:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="ContactPerson" id="ContactPerson">
                  </div>
                </div>
              </div> 
              <div class="box-body">
                <div class="form-group">
                  <label for="Address" class="col-sm-1 control-label">Address:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="Address" id="Address">
                  </div>
                </div>
              </div> 
              <div class="box-body">
                <div class="form-group">
                  <label for="PhoneNumber" class="col-sm-1 control-label">Phone Number:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="PhoneNumber" id="PhoneNumber" >
                  </div>
                </div>
              </div> 

              <div class="box-body">
                <div class="form-group">
                  <label for="OppeningBalance" class="col-sm-1 control-label">Opening Balance:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="OppeningBalance" id="OppeningBalance" >
                  </div>
                </div>
              </div> 

              <div class="box-body">
                <div class="form-group">
                  <label for="OppeningBalanceDate" class="col-sm-1 control-label">Opening Balance Date:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" id="datepicker1" name="OppeningBalanceDate" id="OppeningBalanceDate" >
                  </div>
                </div>
              </div> 
             <!-- <div class="box-body">
                <div class="form-group">
                  <label for="Status" class="col-sm-1 control-label">Status:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="Status" id="Status" >
                  </div>
                </div>
              </div>
              -->  
<!--               <div class="box-header with-border">
              <h3 class="box-title">Add Account Information</h3>
              </div>
              <div class="box-body" id="CategoryCodeDiv">
              </div> -->
                  
                  <input type="hidden" class="form-control"  name="ChartOfAccountCode" id="ChartOfAccountCode" value="<?php echo $COA_Code;?>" readonly="readonly">
                  <input type="hidden" class="form-control"  name="ChartOfAccountCategoryId" id="ChartOfAccountCategoryId" value="<?php echo $Category_Id;?>" >
                  <input type="hidden" class="form-control"  name="ControlCode" id="ControlCode" value="<?php echo $ControlCode_Id;?>" >
                  <input type="hidden" class="form-control"  name="ChartOfAccountTitle" id="ChartOfAccountTitle" required="required" readonly="readonly">

<!--               <div class="box-header with-border">
              <h3 class="box-title">Add Other Information</h3>
             </div>
             <div class="box-body">
                <div class="form-group">
                  <label for="Notes" class="col-sm-1 control-label">Notes:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="Notes" id="Notes" >
                  </div>
                </div>
              </div>  -->

              <div class="box-footer">
                <div class="col-sm-2">
                  <button type="submit" class="btn btn-block btn-primary">Save Record</button>
                </div>
                <div class="col-sm-2">
                  <a class="btn btn-block btn-primary" href="<?php echo base_url() ?>BankAccount" role="button">Back to Main</a>
                </div>
              </div>
            </form>
          </div>
          <!-- /.box -->
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
  <!-- Main content -->
  <!--bank  model box-->   
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
      
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Banks</h4>
        <p id="showBankMesg"><p>
      </div>
        <div class="modal-body"  id="showBanks"></div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="submit" type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
 <!-- model box -->   
 <!-- category and cantrol code model box-->   
    <div class="modal fade" id="CategoryCodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="ModalLabel"></h4>
        <p id="showMesg"><p>
      </div>
      
        <div class="modal-body"  id="showData">
        </div>
      
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="submit" type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
 <!-- model box -->   
   
  </section>
    <!-- /.content -->
    
  </div>
  <!-- /.content-wrapper -->

  <script>
  $(function(){

 //load bank drop down
    $('#bankDropDown').load('<?php echo base_url("BankAccount/BankDropDown")?>')
   
    // get bank though ajax set value of modul box
   $(document).on('click','#addBank',function(){
           $('#showBankMesg').text('')
        $.ajax({
                url:"<?php echo base_url('BankAccount/Banks')?>",
                type:'post',
                success:function(data){
                   
                    $('#showBanks').html(data)
                }
               
            });
   });
      

   // add new bank 
    $(document).on('click','#submit',function(){
        var BankName = $('#NewBankName').val();
        if(BankName == '')
        {
            alert("Please Fill Empty Fields..")
            return
        }    
        var BankAbb = $('#NewBankAbb').val();
            $.ajax({
                url:"<?php echo base_url('BankAccount/AddBank')?>",
                type:'post',
                data:{BName:BankName,BAbb:BankAbb},
                success:function(data){
                    $('#showBanks').load('<?php echo base_url("BankAccount/Banks")?>')
                    //setTimeout(pauseScript, 200)                
                   $('#showBankMesg').text('Bank added Successfuly...!')
                   $('#bankDropDown').load('<?php echo base_url("BankAccount/BankDropDown")?>')
                   
                   
                }
               
            });
          
      });
 
 
 //update bank
    $(document).on('click','span[id^=BankEdit]',function(){
        // $('#addBank').click()
             var arr= $(this).attr('id').split("_");
             var BankName = $("#BankName_"+arr[1]).val();
             var BankAbb = $("#BankAbb_"+arr[1]).val();
               $.ajax({
                url:"<?php echo base_url('BankAccount/UpdateBank')?>",
                type:'post',
                data:{BName:BankName,BAbb:BankAbb,BId:arr[1]},
                success:function(data){
                    if(data=='success')
                    {
                        $('#showBanks').load('<?php echo base_url("BankAccount/Banks")?>')
                        //setTimeout(pauseScript, 200)
                        $('#showBankMesg').text('Bank Updated Successfuly...!')
                        $('#bankDropDown').load('<?php echo base_url("BankAccount/BankDropDown")?>')
                       
                    }
                }
            });
    });
 
 
 //update bank status
    $(document).on('click','span[id^=BankStatus]',function(){
           // $('#addBank').click()
            var arr= $(this).attr('id').split("_");
                  $.ajax({
                url:"<?php echo base_url('BankAccount/UpdateBank')?>",
                type:'post',
                data:{BId:arr[1]},
                success:function(data){
                    console.log(data);
                    if(data=='success')
                    {
                        $('#showBanks').load('<?php echo base_url("BankAccount/Banks")?>')
                        $('#showBankMesg').text('Bank Updated Successfuly...!')
                        $('#bankDropDown').load('<?php echo base_url("BankAccount/BankDropDown")?>')
        //                setTimeout(pauseScript, 200)
                    }
                }
            });
    });
 
// //autocomplete
//       $('#ChartOfAccount').autocomplete({
//   		source: function(request, response)   {
//			$.ajax({
//				url: "<?php echo site_url('GeneralJournal/AutoCompleteSearch_COA')?>",
//				data: { term:$("#ChartOfAccount").val()},
//				dataType: "json",
//				type: "POST",
//				success: function(data) {					
//					//console.log(data);
//                                        response(data);
//				}
//			});
//		},
//                 select: function (event, ui) {
//                 $(this).val(ui.item.value); // display the selected text
//                 $("#hdnChartOfAccount").val(ui.item.id); // save selected id to hidden input
//                },
//		minLength: 2
//	});


//load category drop down
    $('#CategoryCodeDiv').load('<?php echo base_url("ChartOfBankAccount/CategoryCode")?>')
 
      // get categorycode though ajax set value of modul box
   $(document).on('click','#CategoryCodeBtn',function(){
          $("#ModalLabel").text("Category Code")
        $.ajax({
                url:"<?php echo base_url('ChartOfBankAccount/CategoryCode/page')?>",
                type:'post',
                success:function(data){
                    $('#showData').html(data)
                }
               
            });
   });

 // get controlCode though ajax set value of modul box
   $(document).on('click','#ControlCodeBtn',function(){
        $("#ModalLabel").text("Cantrol Code")
        var CategoryId = parseInt($('#CategoryCode').val());
        if(CategoryId == 0)
        {
            $('#showData').html("Please select Category...!");
            return;
        }
        $.ajax({
                url:"<?php echo base_url('ChartOfBankAccount/ControlCode/page')?>",
                type:'post',
                data:{id:CategoryId},
                success:function(data){
                    $('#showData').html(data)
                }
            });
   });

// category code onChange
    $(document).on("change","#CategoryCode",function(){
            var CategoryId = $(this).val();
                if(CategoryId == '')
                    return
        $.ajax({
                url:"<?php echo base_url('ChartOfBankAccount/ControlCode')?>",
                type:'post',
                data:{id:CategoryId},
                success:function(data){
                   // console.log(data);  
                        $("#ControlCode").html(data);
                }
            });
        
        
    });
    
    
       // add new controlcode
    $(document).on('click','#submit',function(){

        var CategoryId = $('#CategoryCode').val()
        if(CategoryId == '')
        {
            alert("Please Fill Empty Fields..")
            return
        }
        var CC = $('#COA_ControlCode').val();
        var CN = $("#COA_ControlName").val();
             var SR = $("#COA_StartRange").val();
             var ER = $("#COA_EndRange").val();
             var CategoryId = $("#ChartOfAccountCategoryId").val()
                 $.ajax({
                url:"<?php echo base_url('ChartOfBankAccount/AddControlCode')?>",
                type:'post',
                data:{ControlCode:CC,ControlName:CN,StartRange:SR,EndRange:ER,ChartOfAccountCategoryId:CategoryId},
                success:function(data){
                       $('#showData').load("<?php echo base_url('ChartOfBankAccount/ControlCode/page')?>",{id:CategoryId})
                       $('#showBankMesg').text('Control Code added Successfuly...!')
                       $('#ControlCode').load('<?php echo base_url("ChartOfBankAccount/ControlCode")?>',{id:CategoryId})
                }
               
            });
          
      });
      
      //update ControlCode
    $(document).on('click','span[id^=ControlCodeEdit]',function(){
             
                
             var arr= $(this).attr('id').split("_");
             var CC = $("#ControlCode_"+arr[1]).val();
             var CN = $("#ControlName_"+arr[1]).val();
             var SR = $("#StartRange_"+arr[1]).val();
             var ER = $("#EndRange_"+arr[1]).val();
             var CategoryId = $("#ChartOfAccountCategoryId").val()
               $.ajax({
                url:"<?php echo base_url('ChartOfBankAccount/UpdateControlCode')?>",
                type:'post',
                data:{ControlCode:CC,ControlName:CN,StartRange:SR,EndRange:ER,ChartOfAccountControlId:arr[1]},
                success:function(data){
                    if(data=='success')
                    {
                       $('#showData').load("<?php echo base_url('ChartOfBankAccount/ControlCode/page')?>",{id:CategoryId})
                       $('#showMesg').text('Control Code Updated Successfuly...!')
                       $('#ControlCode').load('<?php echo base_url("ChartOfBankAccount/ControlCode")?>',{id:CategoryId})
                    }
                }
            });
    });
 
 // control code onchange
    $(document).on("change","#ControlCode",function(){
        var ControlCodeId =  $(this).val();
            $.ajax({
                url:"<?php echo base_url('ChartOfBankAccount/ChartOfAccount_Code')?>",
                type:'post',
                dataType:"json",
                data:{id:ControlCodeId},
                success:function(data){
                        $("#ChartOfAccountCode").val(data.Code);
                }
            });

    });

     // show modul box    
  $(document).on('show.bs.modal','#exampleModal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') 
        var modal = $(this)
        modal.find('.modal-title').text('')
        //modal.find('.modal-body input').val(recipient)
    });

      //set chart of account title
      $('#AccountTitle').focus( function() {
          $("#ChartOfAccountTitle").val('');
      });
      $('#AccountTitle').blur( function() {
          var CustomerName = $(this).val();
          $("#ChartOfAccountTitle").val(CustomerName)
      });
  });
  </script>
  
  
<?php $this->load->view("includes/footer"); ?>
<script type="text/javascript">
  $(function(){

    $("#AccountNumber").on('focusout', function(){
      var AccountNumber = $(this).val();

        $.ajax({
          url: '<?php echo base_url() ?>BankAccount/VerifyAccountNumber',
          type: 'post',
          dataType: 'html',
          data:{AccountNumber:AccountNumber},
          success:function(response){
            if(response == "success"){
              $("#VerifyAccountNumber").html("Already Exists..!");
            }
            if(response == "error"){
              $("#VerifyAccountNumber").html("");
            }
          }
        })

    })

    $("#accountform").submit(function(e){
      if($("#VerifyAccountNumber").html() != "")
      {
        alert('Account Number already exists.\nPlease try with new number');
        e.preventDefault();
      }
    })
  })
</script>