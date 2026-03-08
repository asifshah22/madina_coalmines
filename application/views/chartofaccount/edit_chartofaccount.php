<?php 
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1><i class="fa fa-cube"></i>&nbsp;Chart Of Accounts</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- form elements  --> 
          <div id="showresult">
          <div class="box box-info">
          
           <?php $id = $GetChartOfAccount->ChartOfAccountId;?>
         
            <!-- /.box-header -->        
            <form role="form" class="form-horizontal" method="post" id="accountform" action='<?php echo site_url("ChartOfAccount/SaveChartOfAccount/$id")?>'> 
  <!--          <form role="form" class="form-horizontal" id="userform" enctype="multipart/form-data" action="<?php // echo base_url(); ?>/Category/SaveCategory" method="post">--> 
            <div class="box-header with-border">
              <h3 class="box-title">Update Chart of Account</h3>
            </div>

              <div class="box-body" id="CategoryCodeDiv">
              </div>
                
               <div class="box-body" >
                   
                   <div class="form-group">
                  <label for="ControlCode" class="col-sm-1 control-label">Control Code:</label>
                   <div class="col-sm-4">
                       <select class="form-control" name="ChartOfAccountControlId" id="ControlCode" >
                          <option value="0">-- Select Control Code --</option>
                             </select>
                   </div><spn style=" cursor: pointer; cursor: hand;" id ='ControlCodeBtn' class='fa  fa-plus' data-toggle="modal" data-target="#CategoryCodeModal" data-whatever=""></spn>
                </div>
              </div> 
           
                
                   
                <!--
                <div class="box-body">
                <div class="form-group">
                  <label for="ParentChartofAccount" class="col-sm-1 control-label">Parent Chart of Account:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="ParentChartofAccount" id="ParentChartofAccount" >
                  </div>
                </div>
              </div> 
                -->
                
                    <div class="box-body">
                <div class="form-group">
                  <label for="ChartOfAccountCode" class="col-sm-1 control-label">Chart of Accounts Code:</label>
                   <div class="col-sm-4">
                       <input type="text" class="form-control" name="ChartOfAccountCode" id="ChartOfAccountCode" value="<?php echo $GetChartOfAccount->ChartOfAccountCode;?>" readonly="readonly" style="background-color: #ffff" >
                  </div>
                </div>
              </div> 
           
                
                    <div class="box-body">
                <div class="form-group">
                  <label for="ChartOfAccountTitle" class="col-sm-1 control-label">Account Title:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="ChartOfAccountTitle" id="ChartOfAccountTitle" value="<?php echo $GetChartOfAccount->ChartOfAccountTitle;?>">
                  </div>
                </div>
              </div> 
           
                
           <!--          <div class="box-body">
                <div class="form-group">
                  <label for="Status" class="col-sm-1 control-label">Status:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="Status" id="Status" value="<?php echo $GetChartOfAccount->Status;?>">
                  </div>
                </div>
              </div>  -->
                     
               <div class="box-body">
                <div class="form-group">
                  <label for="Notes" class="col-sm-1 control-label">Notes:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="Notes" id="Notes" value="<?php echo $GetChartOfAccount->Notes;?>">
                  </div>
                </div>
              </div> 
           
            
              <!-- /.box-body -->
			   <div class="box-footer">
              <div class="col-sm-2">
                <button type="submit" class="btn btn-block btn-primary">Update Record</button>
              </div>
              <div class="col-sm-2">
                <a class="btn btn-block btn-primary" href="<?php echo base_url() ?>ChartOfAccount" role="button">Back to Main</a>
              </div>
              </div>
              <input type="hidden" id="COA_id" value="<?php echo $GetChartOfAccount->ChartOfAccountId?>">
            </form>
          </div>
          <!-- /.box -->
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

  

  <!-- Main content -->
   
     
      <!-- model box-->   
    <div class="modal fade" id="CategoryCodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Banks</h4>
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

 //load category drop down
    var coaid = $('#COA_id').val();
    $('#CategoryCodeDiv').load('<?php echo base_url("ChartOfAccount/CategoryCode")?>',{id:coaid})
    
  // load control code drop down   
              $.ajax({
                url:"<?php echo base_url('ChartOfAccount/ControlCode')?>",
                type:'post',
                data:{COA_id:coaid},
                success:function(data){
                   // console.log(data);  
                        $("#ControlCode").html(data);
                }
            });

    
    
    
   
    // get categorycode though ajax set value of modul box
   $(document).on('click','#CategoryCodeBtn',function(){
       
        $.ajax({
                url:"<?php echo base_url('ChartOfAccount/CategoryCode/page')?>",
                type:'post',
                success:function(data){
                    $('#showData').html(data)
                }
               
            });
   });

    // get controlCode though ajax set value of modul box
   $(document).on('click','#ControlCodeBtn',function(){
        var CategoryId = $('#CategoryCode').val();
        console.log(CategoryId);
        $.ajax({
                url:"<?php echo base_url('ChartOfAccount/ControlCode/page')?>",
                type:'post',
                data:{id:CategoryId},
                success:function(data){
                    $('#showData').html(data)
                }
               
            });
   });


  // show modul box    
  $(document).on('show.bs.modal','#CategoryCodeModal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') 
  var modal = $(this)
  modal.find('.modal-title').text('CategoryCode')
  //modal.find('.modal-body input').val(recipient)
})
 function pauseScript(){
         $('#addBank').click()
 }
    // add new controlcode
    $(document).on('click','#submit',function(){
        var CC = $('#COA_ControlCode').val();
        if(CC == '')
        {
            alert("Please Fill Empty Fields..")
            return
        }    
             var CN = $("#COA_ControlName").val();
             var SR = $("#COA_StartRange").val();
             var ER = $("#COA_EndRange").val();
             var CategoryId = $("#ChartOfAccountCategoryId").val()
                 $.ajax({
                url:"<?php echo base_url('ChartOfAccount/AddControlCode')?>",
                type:'post',
                data:{ControlCode:CC,ControlName:CN,StartRange:SR,EndRange:ER,ChartOfAccountCategoryId:CategoryId},
                success:function(data){
                       $('#showData').load("<?php echo base_url('ChartOfAccount/ControlCode/page')?>",{id:CategoryId})
                       $('#showBankMesg').text('Control Code added Successfuly...!')
                       $('#ControlCode').load('<?php echo base_url("ChartOfAccount/ControlCode")?>',{id:CategoryId})
                   
                   
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
                url:"<?php echo base_url('ChartOfAccount/UpdateControlCode')?>",
                type:'post',
                data:{ControlCode:CC,ControlName:CN,StartRange:SR,EndRange:ER,ChartOfAccountControlId:arr[1]},
                success:function(data){
                    if(data=='success')
                    {
                       $('#showData').load("<?php echo base_url('ChartOfAccount/ControlCode/page')?>",{id:CategoryId})
                       $('#showMesg').text('Control Code Updated Successfuly...!')
                       $('#ControlCode').load('<?php echo base_url("ChartOfAccount/ControlCode")?>',{id:CategoryId})
                    }
                }
            });
    });
 //update bank status
    $(document).on('click','span[id^=BankStatus]',function(){
           // $('#addBank').click()
            var arr= $(this).attr('id').split("_");
                  $.ajax({
                url:"<?php echo base_url('Accounts/UpdateBank')?>",
                type:'post',
                data:{BId:arr[1]},
                success:function(data){
                    console.log(data);
                    if(data=='success')
                    {
                        $('#showBanks').load('<?php echo base_url("Accounts/Banks")?>')
                        $('#showBankMesg').text('Bank Updated Successfuly...!')
                        $('#bankDropDown').load('<?php echo base_url("Accounts/BankDropDown")?>')
        //                setTimeout(pauseScript, 200)
                    }
                }
            });
    });
// select control code


   
 // category code onChange
    $(document).on("change","#CategoryCode",function(){
            var CategoryId = $(this).val();
                if(CategoryId == '')
                    return
        $.ajax({
                url:"<?php echo base_url('ChartOfAccount/ControlCode')?>",
                type:'post',
                data:{id:CategoryId},
                success:function(data){
                   // console.log(data);  
                        $("#ControlCode").html(data);
                }
            });
    });
// control code onchange
    $(document).on("change","#ControlCode",function(){
        var ControlCodeId =  $(this).val();
	
            $.ajax({
                url:"<?php echo base_url('ChartOfAccount/ChartOfAccount_Code')?>",
                type:'post',
		dataType:"json",
                data:{id:ControlCodeId},
                success:function(data){
                    //console.log(data);  
                        $("#ChartOfAccountCode").val(data.Code);
                }
            });

    });

    
 });
  </script>
 
</div>
<!-- ./wrapper -->
<?php $this->load->view("includes/footer"); ?>

<script type="text/javascript">
  $(function(){

    $("#accountform").submit(function(e){
      if($("#CategoryCode").val() == "" || $("#CategoryCode").val() == "0")
      {
          $("#CategoryCode").css('border-color', 'red');
          e.preventDefault();
      }
      else{
          $("#CategoryCode").css('border-color', 'green');
      }

      if($("#ControlCode").val() == "" || $("#ControlCode").val() == "0")
      {
          $("#ControlCode").css('border-color', 'red');
          e.preventDefault();
      }
      else{
          $("#ControlCode").css('border-color', 'green');
      }

      if($("#ChartOfAccountCode").val() == "" || $("#ChartOfAccountCode").val() == "0")
      {
          $("#ChartOfAccountCode").css('border-color', 'red');
          e.preventDefault();
      }
      else{
          $("#ChartOfAccountCode").css('border-color', 'green');
      }

      if($("#ChartOfAccountTitle").val() == "" || $("#ChartOfAccountTitle").val() == "0")
      {
          $("#ChartOfAccountTitle").css('border-color', 'red');
          e.preventDefault();
      }
      else{
          $("#ChartOfAccountCode").css('border-color', 'green');
      }

    })
</script>