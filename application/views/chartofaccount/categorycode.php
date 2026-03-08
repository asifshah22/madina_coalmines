<?php
if($view == 'page')
{
?>
        
  
       

    <table style="border: 1px solid" class="table table-striped">
            <tr>
                <th> Category Code </th>
                <th> Category Name </th>
                <th> Start Range </th>
                <th> End Range </th>
            </tr>   
        <?php
        foreach($GetAllCategories as $row){
        ?>
           <tr>
            <td><?php echo $row['CategoryCode'] ?> </td>
            <td><?php echo $row['CategoryName'] ?> </td>
            <td><?php echo $row['StartRange'] ?> </td>
            <td><?php echo $row['EndRange'] ?> </td>
          </tr>
        <?php
        } 
        ?>
     </table>     
<?php    
}
else
{    
?>
<div class="form-group">
                  <label for="CategoryCode" class="col-sm-1 control-label"> Category Code:</label>
                   <div class="col-sm-4">
                       <select class="form-control"  id="CategoryCode" name="ChartOfAccountCategoryId">
                          <option value="0">-- Select Category Code --</option>
                            <?php
                           foreach($GetAllCategories as $row){
                               ?>
                           <option value="<?php echo $row['ChartOfAccountCategoryId'] ?>" <?php if(isset($GetChartOfAccount)){if($GetChartOfAccount->ChartOfAccountCategoryId == $row['ChartOfAccountCategoryId']) echo "selected=selected";}  ?>   ><?php echo $row['CategoryCode'].'-'.$row['CategoryName'];?></option>
                           <?php
                           }
                           ?>
                       </select>
                   </div><spn style=" cursor: pointer; cursor: hand;" id ='CategoryCodeBtn' class='fa  fa-plus' data-toggle="modal" data-target="#CategoryCodeModal" data-whatever=""></spn>
                </div>
      
<?php
}
?>