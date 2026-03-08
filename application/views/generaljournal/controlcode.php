<?php
$this->load->view("includes/sidebar");

if($view == 'page')
{
?>
        
        <div class="row">
            <div class="box-body">
                <div class="col-xs-2">
                    Control Code
                </div>
                <div class="col-xs-4">
                 Control Name
                </div>
               <div class="col-xs-2">
                 Start Range
                </div>
                <div class="col-xs-2">
                End Range
                </div>
           
                <div class="col-xs-2">
                  Action
                </div>
          
            </div>
          </div>
        
    
    <?php $i=0;  foreach($GetControlCode as $row){?>
            <div class="row">
            <div class="box-body">
                <div class="col-xs-2">
                    <input type="text" id="ControlCode_<?php echo $row['ChartOfAccountsControlId']?>" class="form-control" value="<?php echo $row['ControlCode']?>" >
                </div>
                <div class="col-xs-4">
                  <input type="text" id="ControlName_<?php echo $row['ChartOfAccountsControlId']?>" class="form-control" value="<?php echo $row['ControlName']?>" >
                </div>
               <div class="col-xs-2">
                  <input type="text" id="StartRange_<?php echo $row['ChartOfAccountsControlId']?>" class="form-control" value="<?php echo $row['StartRange']?>" >
                </div>
                <div class="col-xs-2">
                  <input type="text" id="EndRange_<?php echo $row['ChartOfAccountsControlId']?>" class="form-control" value="<?php echo $row['EndRange']?>" >
                </div>
           
                <div class="col-xs-2">
                    <span id="ControlCodeEdit_<?php echo $row['ChartOfAccountsControlId']?>" style=" cursor: pointer; cursor: hand;" class="fa fa-edit">update</span>
                </div>
          
            </div>
          </div>
           <?php }?>
             <div class="row">
            <div class="box-body">
                <div class="col-xs-2">
                    <input type="text" id="COA_ControlCode" class="form-control"  >
                </div>
                <div class="col-xs-4">
                    <input type="text" id="COA_ControlName" class="form-control"  >
                </div>
                <div class="col-xs-2">
                  <input type="text" id="COA_StartRange" class="form-control"  >
                </div>
                <div class="col-xs-2">
                    <input type="text" id="COA_EndRange" class="form-control"  >
                </div>
                <div class="col-xs-2">
                    <span class="fa fa-edit"><input type="hidden" id="ChartOfAccountsCategoryId" value="<?php echo $row['ChartOfAccountsCategoryId']?>"></span>
                </div>
            </div>
          </div>
            
<?php    
}
else
{    
?>         
                          <option value="0">-- Select Control Code --</option>
                            <?php
                           foreach($GetControlCode as $row){
                               ?>
                           <option value="<?php echo $row['ChartOfAccountsControlId'] ?>" <?php if(isset($GetChartOfAccount)){if($GetChartOfAccount->ChartOfAccountsControlId == $row['ChartOfAccountsControlId']) echo "selected=selected";}  ?>   ><?php echo $row['ControlCode'].'-'.$row['ControlName'];?></option>
                           <?php
                           }
                           ?>
                 
      
<?php
}
?> 