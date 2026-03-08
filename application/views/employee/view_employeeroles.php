<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Employee Roles</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12"> 
          <div class="box box-info">
              
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">Roles Detail</h3>
            </div>
              <?php // print '<pre>'; print_r($EmployeeRoles); print '/<pre>';  //echo validation_errors(); ?>
              <div class="box-body">
                 
              <?php echo $this->session->flashdata('record_updated'); ?>
               <form name="rolesform" action="<?php echo base_url("Employee/UpdateEmployeeRoles"); ?>" method="post">     
                
                <table style="border:0px solid; width:90%;">
                  <tr>
                      <th style="width:30%;">Components</th>
                      <th style="width:15%;">View</th>
                      <th style="width:15%;">Add</th>
                      <th style="width:15%;">Update</th>
                      <th style="width:15%;">Delete</th>
                  </tr>
                  <tr><td style="height:5px;" colspan="5"></td></tr>
                  <?php $i=0; foreach ($Roles as $Role): ?>
                  <tr>
                      <td style="padding:5px; background:#f5f8f3;" colspan="5">
                          <span style="color: #f39c12; border:0 px solid; font-weight:600;"><?php echo $Role['RoleName']; ?></span>                    
                      </td>
                  </tr>
                  <?php
		                    
                  if(!empty($EmployeeRoles)) {
                  foreach ($EmployeeRoles as $EmpRoles):    
                  if($Role['RoleId']==$EmpRoles['ParantRoleId']) {   
                  ?>
                  <tr>
                    <td style=" padding-left:20px;"><p><?php echo $EmpRoles['RoleName']; ?></p></td>
                    <td><input type="checkbox" value="<?php echo $EmpRoles['EmployeeRoleId']; ?>" <?php echo $EmpRoles['ViewRoles'] ==  1 ? "checked=checked" : ""; ?> name="ViewRoles<?php echo $i; ?>" /></td>
                    <td><input type="checkbox" value="<?php echo $EmpRoles['EmployeeRoleId']; ?>" <?php echo $EmpRoles['AddRoles'] ==  1 ? "checked=checked" : ""; ?> name="AddRoles<?php echo $i; ?>" /></td>
                    <td><input type="checkbox" value="<?php echo $EmpRoles['EmployeeRoleId']; ?>" <?php echo $EmpRoles['UpdateRoles'] ==  1 ? "checked=checked" : ""; ?> name="UpdateRoles<?php echo $i; ?>" /></td>
                    <td><input type="checkbox" value="<?php echo $EmpRoles['EmployeeRoleId']; ?>" <?php echo $EmpRoles['DeleteRoles'] ==  1 ? "checked=checked" : ""; ?> name="DeleteRoles<?php echo $i; ?>" /></td>
                  </tr>
                  <?php $i++; } endforeach; } else redirect('Dashboard'); ?>
                  <?php endforeach; ?>
              </table>
              <div class="box-footer">
                  <input type="hidden" name="EmployeeId" value="<?php echo $EmployeeRoles[0]['EmployeeId']; ?>">
                  <?php echo anchor("Employee/","Back to Main",array("class"=>"btn btn-primary"))?>&nbsp;&nbsp;&nbsp;&nbsp;
                  <button type="submit" class="btn btn-primary">Update Roles</button>
              </div>
               </form>
             </div>
           <!-- /.box-body -->
          </div>
          <!-- box info -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content --> 
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<?php $this->load->view('includes/footer'); ?>