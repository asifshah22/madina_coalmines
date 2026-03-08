<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Saleman_model extends CI_Model{
	
    function __construct(){
	
		parent::__construct();
		$this->tbl_saleman = "pos_saleman";
        $this->tbl_accounts_chartofaccount_controls = "pos_accounts_chartofaccount_controls";
		$this->tbl_accounts_chartofaccount = "pos_accounts_chartofaccount";
    }
	
        public function Ajax_GetAllCategories($requestData)
        {
               $columns = array( 
                        0 => 'SalemanName',
                        1 => 'SalemanId',
                        2 => 'ContactNumber',
                        3 => 'Address',
                        4 => 'SalemanStatus',
                );
                $sql = "SELECT SalemanId,SalemanName,ContactNumber,Address,SalemanStatus";
                $sql.=" FROM pos_saleman";
                //die($sql);
                $query= $this->db->query($sql); 
                //die('test');
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                $sql.=" WHERE 1=1 ";
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND (SalemanId LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR  SalemanName LIKE '".$requestData['search']['value']."%' )";
                }
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY SalemanName ASC ". "  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
                $query=$this->db->query($sql);  
                
                $array['record'] = $query->result_array();
                $array['recordsFiltered'] = $totalFiltered;
                $array['recordsTotal'] = $totalData;
                return $array;
   
        }

        
    function GetAllCategories()
    {
        $this->db->select('*')->from('pos_saleman');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function TotalRecord()
    {
        $this->db->select('*')->from('pos_saleman');
        $query = $this->db->get();
        return $query->num_rows();
    }

	
    public function GetCategoryById($NewCategoryId)
     {
        if ($NewCategoryId === 0)
        {
            $query = $this->db->get('pos_saleman');
            return $query->result_array();
        }
		
		$this->db->select('*');
		$this->db->from($this->tbl_saleman);
        $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId =pos_saleman.ChartOfAccountId');
		$this->db->where('pos_saleman.SalemanId',$NewCategoryId);
		$query = $this->db->get();
		return $query->row();
     }
	
	public function SaveCategory($array,$id=0) 
        {
            $this->load->helper('url');
            if($id ==0)
            {
                $this->db->insert($this->tbl_saleman,$array);
                return $NewCategoryId = intval($this->db->insert_id());
            }
            else
            {
               $this->db->where('SalemanId',$id);
               if($this->db->update('pos_saleman',$array))
               return $id;
            }    
        }

        public function SaveSalemanDetail($Record,$SalemanId=0)
        {
    
            if($SalemanId==0)
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
                  
                        $arrSaleman = array(
                        'SalemanName'=>$Record['SalemanName'],
                        'ContactNumber'=>$Record['ContactNumber'],
                        'Address'=>$Record['Address'],
                        'ChartOfAccountId'=>$ChartOfAccountId,
                        'AddedOn' => date('Y-m-d H:i:s'),
                        'AddedBy' => $this->session->userdata('EmployeeId'),
                        ); 
                    }
                        $StatsAccount = $this->db->insert($this->tbl_saleman,$arrSaleman);
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
                'SalemanName'=>$Record['SalemanName'],
                'ContactNumber'=>$Record['ContactNumber'],
                'Address'=>$Record['Address'],
                'ChartOfAccountId'=>$Record['ChartOfAccountId']                    
                ); 
            }
                      $this->db->where('SalemanId',$SalemanId);
                      $StatsSaleman = $this->db->update($this->tbl_saleman,$arrCustomer);
                     if($StatsSaleman)
                        return 'success';
                    else
                        {
                            //transection rollback
                        }
                }
        }

    public function DeleteCategory($CategoryId)
    {
        $this->db->where('SalemanId',$CategoryId);
        $this->db->delete('pos_saleman');
        return true;
    }

    function GetSalemanrByName($SalemanName)
    {
        $this->db->select('*');
        $this->db->from($this->tbl_saleman);
        $this->db->where('SalemanName',$SalemanName);
        $result = $this->db->get();
        return ($result->row());
    }
}
?>