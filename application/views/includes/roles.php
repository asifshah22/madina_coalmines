<?php 

 $roleName= $this->uri->segment(1);
 $action= $this->uri->segment(2);
 if($this->session->userdata('EmployeeId')!=1){
$AdminPermissions= $this->Employee_model->GetAdministrationRoles($this->session->userdata('EmployeeId'));
$SalesRoles = $this->Employee_model->GetSalesRoles($this->session->userdata('EmployeeId'));
$PurchasesRoles = $this->Employee_model->GetPurchasesRoles($this->session->userdata('EmployeeId'));
$RegistrationRoles = $this->Employee_model->GetRegistrationRoles($this->session->userdata('EmployeeId'));
	    
$AdminPermissions=array_merge($AdminPermissions, $SalesRoles,$RegistrationRoles,$PurchasesRoles);

function has_permission($roleName, $action,$permissions) {
// $permissions = get_instance()->session->userdata('permissions');
// print_r($permissions);
    $access= true;
    foreach ($permissions as $permission) {
        $parameter='';
        if($roleName=='Category'){
                $parameter='Categories';
        }
        else if($roleName=='Product Groups'){
                $parameter='ProductGroup';
        }
        else if($roleName=='Brands'){
                $parameter='Brand';
        }
        else if($roleName=='Product'){
                $parameter='Products';
        }
        else if($roleName=='Designation'){
                $parameter='Designations';
        } 
        else if($roleName=='Employee'){
                $parameter='Employees';
        }
        else if($roleName=='Company'){
                $parameter='Companies';
        }
        else if($roleName=='Location'){
                $parameter='Locations';
        }
        else if($roleName=='Colour'){
                $parameter='Colours';
        }
        else if($roleName=='Reference'){
                $parameter='References';
        }else{
            $parameter=$roleName;
        }
        if ($permission['RoleName'] === $parameter) {
          
           $normalizedRoleName = ucfirst(strtolower(rtrim($roleName, 's')));
           
           $normalizedRoleName = ucfirst(rtrim($roleName, 's'));

            if (strcasecmp('Add' . $normalizedRoleName, $action) == 0) {
                $access= $permission['AddRoles'] == 1? true : false;
                // Both "AddChartofaccount" and "AddChartOfaccount" will match
            }else if(strcasecmp('Edit' . $normalizedRoleName, $action)){
                 $access= $permission['UpdateRoles']==1? true : false;
            }
            else if($action==''){

                 $access= $permission['ViewRoles'] == 1? true : false;
            }
            
            
        }
    }
    return $access; // Role not found
}

if(!has_permission($roleName, $action,$AdminPermissions)){
    redirect('Dashboard/');
}

}
?>