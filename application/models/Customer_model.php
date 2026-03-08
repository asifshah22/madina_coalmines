<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model{
	
	function __construct(){
	
		parent::__construct();
		$this->tbl_customer = "pos_customer";
		$this->tbl_setting = "pos_setting";
		$this->tbl_accounts_chartofaccount_controls = "pos_accounts_chartofaccount_controls";
		$this->tbl_accounts_chartofaccount = "pos_accounts_chartofaccount";
		$this->tbl_area = "pos_area";
	}
    
    function GetAllCustomers()
    {
	$this->db->select('*');
	$this->db->from($this->tbl_customer);
	$GetAllCustomers = $this->db->get();
        return ($GetAllCustomers->result_array());   
    }
    
     function GetCustomerByName($CustomerName)
    {
        $this->db->select('*');
        $this->db->from($this->tbl_customer);
        $this->db->where('CustomerName',$CustomerName);
        $result = $this->db->get();
        return ($result->row());
    }
	
    public function SaveCustomerDetail($Record,$CustomerId=0)
    {

        if($CustomerId==0)
        {       
            $arrChartOfAccount = array(
            'ChartOfAccountCategoryId'=>$Record['ChartOfAccountCategoryId'],
            'ChartOfAccountControlId'=>$Record['ChartOfAccountControlId'],
            'ChartOfAccountTitle'=>$Record['ChartOfAccountTitle'],
            'ChartOfAccountCode'=>$Record['ChartOfAccountCode'],
            'ChartOfAccountAddedOn' => date('Y-m-d H:i:s'),    
            'ChartOfAccountAddedBy'=> $this->session->userdata('EmployeeId')
             );
                
             $this->db->set($arrChartOfAccount);
             $status = $this->db->insert('pos_accounts_chartofaccount');
             if($status)
                 {
                    $ChartOfAccountId = $this->db->insert_id();
              
                    $arrCustomer = array(
                    'CustomerName'=>$Record['CustomerName'],
                    'ContactName'=>$Record['ContactName'],
                    'Address'=>$Record['Address'],
                    'AreaId'=>$Record['Area_name'],
                    'Email'=>$Record['Email'],
                    'PhoneNo'=>$Record['PhoneNo'],
                    'CellNo'=>$Record['CellNo'],
		            'FaxNo'=>$Record['FaxNo'],
                    'Website'=>$Record['Website'],
                    'Note'=>$Record['note'],
                    'AlertDate'=>$Record['alert_date'],
                    'ChartOfAccountId'=>$ChartOfAccountId,
                    'AddedOn' => date('Y-m-d H:i:s'),
	    			'AddedBy' => $this->session->userdata('EmployeeId'),
                    ); 
                }
                    $StatsAccount = $this->db->insert($this->tbl_customer,$arrCustomer);
                if($StatsAccount)
                    return $this->db->insert_id();
                else
                    {
                        //transection rollback
                    }
        }
        else
        {                   
             $arrChartOfAccount = array(
             'ChartOfAccountCategoryId'=>$Record['ChartOfAccountCategoryId'],
             'ChartOfAccountControlId'=>$Record['ChartOfAccountControlId'],
             'ChartOfAccountTitle'=>$Record['ChartOfAccountTitle'],
             'ChartOfAccountCode'=>$Record['ChartOfAccountCode'],
             'ChartOfAccountAddedOn' => date('Y-m-d H:i:s'),    
             'ChartOfAccountAddedBy'=> $this->session->userdata('EmployeeId')     
             );
                  
             $this->db->where('ChartOfAccountId',$Record['ChartOfAccountId']);
             $status = $this->db->update('pos_accounts_chartofaccount',$arrChartOfAccount);
             
        if($status){
			$arrCustomer = array(
			'CustomerName'=>$Record['CustomerName'],
			'ContactName'=>$Record['ContactName'],
			'Address'=>$Record['Address'],
			'AreaId'=>$Record['Area_name'],
			'Email'=>$Record['Email'],
            'PhoneNo'=>$Record['PhoneNo'],
            'CellNo'=>$Record['CellNo'],
            'FaxNo'=>$Record['FaxNo'],
			'Website'=>$Record['Website'],
			'Note'=>$Record['note'],
			'Cleared'=>$Record['Cleared'],
            'AlertDate'=>$Record['alert_date'],
			'ChartOfAccountId'=>$Record['ChartOfAccountId']                    
			); 
        }
                  $this->db->where('CustomerId',$CustomerId);
                  $StatsCustomer = $this->db->update($this->tbl_customer,$arrCustomer);
                 if($StatsCustomer)
                    return 'success';
                else
                    {
                        //transection rollback
                    }
            }
    }



	
       public function UpdateCustomerDetail($data,$CustomerId)
       {   
	   $this->db->select('ChartOfAccountTitle');
	   $this->db->from('pos_accounts_chartofaccount');
	   $this->db->where('ChartOfAccountId',$data['ChartOfAccountId']);
	   $query = $this->db->get();
	    
	   if ($query->num_rows() > 0)
	   {
	      $UpdateCustomerName = array('ChartOfAccountTitle' => $data['CustomerName']);	       
	      $this->db->where('ChartOfAccountId',$data['ChartOfAccountId']);
	      $this->db->update($this->tbl_accounts_chartofaccount,$UpdateCustomerName);
	   }
	   else
	   {
	       redirect("Customer/");
	   }
	    
	   $CustomerDetail = array(
	   'CustomerName'=>$data['CustomerName'],
	   'ContactName'=>$data['ContactName'],
	   'Address'=>$data['Address'],
	   'AreaId'=>$data['Area_name'],
	   'Email'=>$data['Email'],
	   'PhoneNo'=>$data['PhoneNo'],
	   'CellNo'=>$data['CellNo'],
	   'FaxNo'=>$data['FaxNo'],
	   'Website'=>$data['Website'],
	   );
	   
	   $this->db->where('CustomerId',$CustomerId);
	   $StatsCustomer = $this->db->update($this->tbl_customer,$CustomerDetail);
	   return 'success';   
       }
    
	    
	    
    public function Ajax_GetAllCustomers($requestData)
    {
      // storing  request (ie, get/post) global array to a variable  
             /*   $columns = array( 
                // datatable column index  => database column name
                        0 => 'CustomerName',
                        1 => 'CustomerId', 
                        2 => 'ContactName',
                        3 => 'Area_name',
                        4 => 'CellNo', );
                // getting total number records without any search
                $sql = "SELECT pos_customer.CustomerId, pos_customer.CustomerName, pos_customer.ContactName, pos_area.Area_name,
                 pos_customer.PhoneNo, pos_customer.CellNo";
                $sql .=" FROM pos_customer ";
                $sql.=" INNER JOIN pos_area ON pos_area.id = pos_customer.AreaId ";
//                $sql .="FROM pos_customer AS C INNER JOIN pos_division AS DIV ON DIV.DivisionId = C.DivisionId";      
                $query= $this->db->query($sql); 
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
				$sql.=" WHERE 1 = 1 ";
		
                $sql = "SELECT pos_customer.CustomerId, pos_customer.CustomerName, pos_customer.ContactName, pos_area.Area_name,
                pos_customer.PhoneNo, pos_customer.CellNo"; //$sql .="FROM pos_customer AS C";
				$sql.=" FROM pos_customer";
                $sql.=" INNER JOIN pos_area ON pos_area.id = pos_customer.AreaId ";
                $sql.=" WHERE 1=1";
                
		if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND ( pos_customer.CustomerName LIKE '".$requestData['search']['value']."%' ";    
                       $sql.=" OR pos_customer.ContactName LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR pos_customer.CellNo LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR pos_area.Area_name LIKE '".$requestData['search']['value']."%' )";  
                }
                //print_r($columns);
                //echo $columns[$requestData['order'][0]['column']];
                //die;
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY CustomerName ". "  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
//                $sql.=" ORDER BY pos_customer.CustomerName DESC "."   ";
                $query=$this->db->query($sql);  
                 $array['record'] = $query->result_array();
                $array['recordsFiltered'] = $totalFiltered;
                $array['recordsTotal'] = $totalData;
                
                return $array;
     */
     $columns = array( 
    // datatable column index  => database column name
   0 => 'CustomerName',
                        1 => 'CustomerId', 
                        2 => 'ContactName',
                        3 => 'Email',
                        4 => 'CellNo',
                        5 => 'DueAmount'// Adding due amount to the columns
);

// Base query for customer details with debit, credit, and due amount
$this->db->select(''
    . 'pos_customer.CustomerId,'
    . 'pos_customer.CustomerName,'
    . 'pos_customer.ContactName,'
    . 'pos_customer.Email,'
    . 'pos_customer.PhoneNo,'
    . 'pos_customer.CellNo,'
    . 'SUM(pos_accounts_generaljournal_entries.Debit) AS Debit,'
    . 'SUM(pos_accounts_generaljournal_entries.Credit) AS Credit,'
    . '(SUM(pos_accounts_generaljournal_entries.Debit) - SUM(pos_accounts_generaljournal_entries.Credit)) AS DueAmount'
);

$this->db->from('pos_customer');
$this->db->join('pos_area', 'pos_area.id = pos_customer.AreaId', 'left');
$this->db->join('pos_accounts_chartofaccount', 'pos_customer.ChartOfAccountId = pos_accounts_chartofaccount.ChartOfAccountId', 'left');
$this->db->join('pos_accounts_generaljournal_entries', 'pos_accounts_generaljournal_entries.ChartOfAccountId = pos_accounts_chartofaccount.ChartOfAccountId', 'left');
$this->db->join('pos_accounts_generaljournal', 'pos_accounts_generaljournal.GeneralJournalId = pos_accounts_generaljournal_entries.GeneralJournalId', 'left');

// Search filter
if( !empty($requestData['search']['value']) ) {   
    $this->db->group_start();
    $this->db->like('pos_customer.CustomerName', $requestData['search']['value']);
    $this->db->or_like('pos_customer.ContactName', $requestData['search']['value']);
    $this->db->or_like('pos_customer.CellNo', $requestData['search']['value']);
    $this->db->or_like('pos_area.Area_name', $requestData['search']['value']);
    $this->db->group_end();
}

// Grouping by customer
$this->db->group_by('pos_customer.CustomerId');

// Get total number of records without filtering
$totalData = $this->db->count_all_results('', false);
$totalFiltered = $totalData;

// Ordering
$order_column = $columns[$requestData['order'][0]['column']];
$order_dir = $requestData['order'][0]['dir'];
$this->db->order_by($order_column, $order_dir);

// Limiting results for pagination
$this->db->limit($requestData['length'], $requestData['start']);

// Execute the query
$query = $this->db->get();
$result = $query->result_array();

// Prepare result array for response
$array = array(
    'record' => $result,
    'recordsFiltered' => $totalFiltered,
    'recordsTotal' => $totalData
);

return $array;

    }
    public function Ajax_GetAllCustomerss($requestData)
    {
      // storing  request (ie, get/post) global array to a variable  
                $columns = array( 
                // datatable column index  => database column name
                        0 => 'CustomerName',
                        1 => 'CustomerId', 
                        2 => 'ContactName',
                        3 => 'Email',
                        4 => 'CellNo',
                        5 => 'DueAmount');
                // getting total number records without any search
                $sql = "SELECT CustomerId,CustomerName,ContactName,Email,PhoneNo,CellNo ";
                $sql .="FROM pos_customer ";
//                $sql .="FROM pos_customer AS C INNER JOIN pos_division AS DIV ON DIV.DivisionId = C.DivisionId";      
                $query= $this->db->query($sql); 
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
				$sql.=" WHERE 1 = 1 ";
		
                $sql = "SELECT CustomerId,CustomerName,ContactName,PhoneNo,Email,CellNo "; //$sql .="FROM pos_customer AS C";
				$sql.=" FROM pos_customer WHERE 1=1";
				
                
		if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND ( CustomerName LIKE '".$requestData['search']['value']."%' ";    
                       $sql.=" OR ContactName LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR CellNo LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR Email LIKE '".$requestData['search']['value']."%' )";  
                }
                //print_r($columns);
                //echo $columns[$requestData['order'][0]['column']];
                //die;
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY CustomerName ". "  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
//                $sql.=" ORDER BY pos_customer.CustomerName DESC "."   ";
                /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
                $query=$this->db->query($sql);  
                 $array['record'] = $query->result_array();
                $array['recordsFiltered'] = $totalFiltered;
                $array['recordsTotal'] = $totalData;
                
                return $array;
     
    }
     
    function GetCustomer($id,$columns='*')
    {
         $this->db->select($columns);
         $this->db->from('pos_customer');
         $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId =pos_customer.ChartOfAccountId');
         $this->db->where('CustomerId',$id);
         $result = $this->db->get();
        return ($result->row());
    }
    
    function GetNotifications()
    {
    $date = date("Y-m-d");
	$this->db->select('*');
	$this->db->from($this->tbl_customer);
    $this->db->where('AlertDate <=',$date);
    $this->db->where('Cleared !=',1);
    $this->db->order_by("CustomerName", "asc");
	$GetAllCustomers = $this->db->get();
        return ($GetAllCustomers->result_array());   
    }
     
    function GetCustomerById($id,$columns='*')
    {   
        $finalResult = array();
        $Customers = array();
        if($id == 0){
            $this->db->select('*');
            $this->db->from($this->tbl_customer);
            $this->db->order_by("CustomerName", "asc");
            $GetAllCustomers = $this->db->get();
            $Customers = $GetAllCustomers->result_array(); 
        }else{

            $this->db->select($columns);
            $this->db->from('pos_customer');
            $this->db->where('ChartOfAccountId',$id);
            $result = $this->db->get();
            $Customers = $result->result_array();
        }
      
        $i =0;
        foreach($Customers as $customer){
            $Area = new Area_model();
            $getArea = $Area->GetArea($customer['AreaId']);
            $finalResult[$i]['CustomerId']        = $customer['CustomerId'];
            $finalResult[$i]['ChartOfAccountId']  = $customer['ChartOfAccountId'];
            $finalResult[$i]['AreaName']          = ($getArea) ? $getArea->Area_name : "";
            $finalResult[$i]['ContactName']       = $customer['ContactName'];
            $finalResult[$i]['CellNo']            = $customer['CellNo'];
            $finalResult[$i]['Address']           = $customer['Address'];
        $i++;
        }

         return $finalResult;
    }
    function GetCustomerId($id,$columns='*')
    {   
        $finalResult = array();
    
        $this->db->select($columns);
        $this->db->from('pos_customer');
        $this->db->where('ChartOfAccountId',$id);
        $result = $this->db->get();
        $Customers = $result->result_array();
      
        $i =0;
        foreach($Customers as $customer){

            $finalResult[$i]['CustomerId']        = $customer['CustomerId'];
            $finalResult[$i]['ChartOfAccountId']  = $customer['ChartOfAccountId'];
            $finalResult[$i]['CustomerName']      = $customer['CustomerName'];
            $finalResult[$i]['ContactName']       = $customer['ContactName'];
            $finalResult[$i]['PhoneNo']           = $customer['PhoneNo'];
            $finalResult[$i]['CellNo']            = $customer['CellNo'];
            $finalResult[$i]['Address']           = $customer['Address'];
        $i++;
        }

         return $finalResult;
    }
    
    function GetCustomerChartOfAccountId($id)
    {   
        $this->db->select('ChartOfAccountId');
        $this->db->from($this->tbl_customer);
        $this->db->where('CustomerId', $id);
        $GetAllCustomers = $this->db->get();
        $Customers = $GetAllCustomers->result_array(); 
        return $Customers;
    }
    
/*    function GetAllStates()
    {
        $GetAllStates = $this->db->get($this->tbl_state);
        return ($GetAllStates->result_array());
    }
    
    function GetAllDivisions()
    {
        $GetAllDivisions = $this->db->get($this->tbl_division);
        return ($GetAllDivisions->result_array());
    }
    
    function GetAllDistricts()
    {
        $GetAllDistricts = $this->db->get($this->tbl_district);
        return ($GetAllDistricts->result_array());
    }*/
    
    
}
?>