<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GeneralJournal_model extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
              //  $this->output->enable_profiler();
	}
	
	
	function GetAllGeneralJournal($Column='*')
	{
                $this->db->select($Column);
                $this->db->from('pos_accounts_generaljournal');
                $result = $this->db->get()->result_array();
                return $result;
        }
	

	function Ajax_GetAllGeneralJournal($requestData)
        {
                $columns = array(
                0 => 'GeneralJournalId',
                1 => 'TransactionDate',
                2 => 'Reference',
                3 => 'TotalDebit',
                4 => 'EntryType',
                5 => 'VoucherType',
                );
                // getting total number records without any search
                $sql = "SELECT TransactionDate,Reference,TotalDebit,GeneralJournalId,EntryType,VoucherType ";
                $sql.="FROM pos_accounts_generaljournal";
                $query= $this->db->query($sql); 
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                $sql = "SELECT TransactionDate,Reference,TotalDebit,GeneralJournalId,EntryType,VoucherType ";
                $sql.="FROM pos_accounts_generaljournal";
                
                $sql.=" WHERE 1=1 AND pos_accounts_generaljournal.EntryType IS Null";
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND ( TransactionDate LIKE '%".$requestData['search']['value']."%' ";
                       $sql.=" OR Reference LIKE '%".$requestData['search']['value']."%' ";
                       $sql.=" OR TotalDebit LIKE '%".$requestData['search']['value']."%' )";
                }
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY   ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
                /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
                $query=$this->db->query($sql);  
                $array['record'] = $query->result_array();
                $array['recordsFiltered'] = $totalFiltered;
                $array['recordsTotal'] = $totalData;
                return $array;
        }
        
	
	public function SaveGeneralJournalDetail($Record)
        {
            // echo "<pre>";
            // print_r($Record);
            // echo "</pre>"; exit;
              $PayeeId = 0;
              $SalemanId = 0;
              $PayeeVal = 0;
	      
                    $Series  = 0;
                    $Record['CustomerId'] = 0;
                    $Record['VendorId'] = 0;
                    $Record['BankAccountId'] = 0;
                    $Recipient = '';
                    
                     // If variable is undefined then redirect into main Generaljournal page
                     if($Record['VoucherType'] == '')
                     { redirect("Generaljournal/");}
                    
                     if(isset($Record['VoucherType']) && $Record['VoucherType']==1)   
                     {
                         $Series = $this->db->where('VoucherType','1')->from('pos_accounts_generaljournal')->count_all_results();
                         $Reference = "CPV".($Series+1);
                     }
                     else if(isset($Record['VoucherType']) && $Record['VoucherType']==2) 
                     {
                         $Series = $this->db->where('VoucherType','2')->from('pos_accounts_generaljournal')->count_all_results();
                         $Reference = "BPV".($Series+1);
                     }           
                     else if(isset($Record['VoucherType']) && $Record['VoucherType']==3)   
                     {
                         $Series = $this->db->where('VoucherType','3')->from('pos_accounts_generaljournal')->count_all_results();
                         $Reference = "CRV".($Series+1);
                     }           
                     else if(isset($Record['VoucherType']) && $Record['VoucherType']==4)
                     {
                         $Series = $this->db->where('VoucherType','4')->from('pos_accounts_generaljournal')->count_all_results();
                         $Reference = "BRV".($Series+1);
                     }
                     else   
                     {
                         $Series = $this->db->where('VoucherType','5')->from('pos_accounts_generaljournal')->count_all_results();
                         $Reference = "JV".($Series+1);
                     }           
                     
                     if(isset($Record['TransactionDate']))
                     { $TransctionDate = date('Y-m-d', strtotime($Record['TransactionDate'])); }
                     else 
                     { $TransctionDate = date('Y-m-d H:i:s'); }
                     
                   
                    $VoucherData = array(
                    'TransactionDate' => $TransctionDate,
                    'VoucherType' => $Record['VoucherType'],
                    'Reference' => $Reference,
                    'TotalDebit' => array_sum($Record['Debit']),
                    'TotalCredit' => array_sum($Record['Credit']),
            		    'VoucherNote'=> $Record['VoucherNote'],
            		    'AddedOn' => date('Y-m-d H:i:s'),
                    'AddedBy' => $this->session->userdata('EmployeeId'));
                     
                     $this->db->set($VoucherData);
                     $status = $this->db->insert('pos_accounts_generaljournal');
                    
                     if($status)
                     {
                        $counter = 0;
                        $GJ_LastInsertedId=$this->db->insert_id();
                        $COA_Array = array_filter($Record['ChartOfAccount']);
                        $NoOfRecord =  count($COA_Array);  
                        
			            for($i = 0; $i<$NoOfRecord; $i++ )
                        {
                           //Payees values
                           if(isset($Record['PayeeName'][$i]) && $Record['PayeeName'][$i] != '' && $Record['PayeeName'][$i] != null )
                           {
                            $SalemanId = $Record['PayeeName'][$i];
                            $Record['SalemanId'] = $SalemanId;
                            $Record['CustomerId'] = 0;
                            $Record['VendorId'] = 0;
                            $Record['BankAccountId'] = 0;
                            // $Payee = explode("-", $Record['PayeeName'][$i]);
                            // $PayeeChartOfAccount = $Payee[0];
                            // $PayeeId = $Payee[1];

                            // if(($PayeeChartOfAccount >= '10005') && ($PayeeChartOfAccount <= '14999'))
                            // { $Record['CustomerId'] = $Payee[1]; }
                            //  else { $Record['CustomerId'] = 0; }

                            // if(($PayeeChartOfAccount >= '200001') && ($PayeeChartOfAccount <= '201999'))
                            // { $Record['VendorId'] = $Payee[1]; } 
                            // else { $Record['VendorId'] = 0; }

                            // if($PayeeChartOfAccount >= '150000' && $PayeeChartOfAccount <= '150500')
                            // { $Record['BankAccountId'] = $PayeeId; } 
                            // else { $Record['BankAccountId'] = 0; }
                          }
                          else
                          {
                            $Record['SalemanId'] = $SalemanId;
                            $Record['CustomerId'] = 0;
                            $Record['VendorId'] = 0;
                            $Record['BankAccountId'] = 0;
                          }  
                           // End of code
                          
                           if(isset($Record['Recipient'][$i])) 
                           { $Recipient = $Record['Recipient'][$i]; }
                           else
                           { $Recipient = ''; }
                           
                           $VoucherDetailData = array(
                           'ChartOfAccountId' => $Record['ChartOfAccount'][$i],
                           'SalemanId' => ($Record['Debit'][$i]) ? $Record['SalemanId'] : Null,
                           'VendorId' => $Record['VendorId'],
                           'CustomerId' => $Record['CustomerId'],
                           'BankAccountId' => $Record['BankAccountId'],    
                           'Recipient' => $Recipient,
                           'Detail' => $Record['Description'][$i],
                           'Debit' => $Record['Debit'][$i],
                           'Credit' => $Record['Credit'][$i],
                           'GeneralJournalId' => $GJ_LastInsertedId,
                           'ReconciliationDate' => $TransctionDate
                           );

                             $this->db->set($VoucherDetailData);
                             $status = $this->db->insert('pos_accounts_generaljournal_entries');
                             if($status)
			                  { $counter++; }
                        }
                        if($NoOfRecord == $counter )
			                  { return $GJ_LastInsertedId; }
                        }
                      else    
		                  {  return('fail'); } // roll back all transection
                    }
	
	    
	   
	  public function UpdateGeneralJournalDetail($Record,$GeneralJournalId)
          { 
              $PayeeId = 0;
              $PayeeVal = 0;
              $SalemanId = 0;
	      
                    $Series  = 0;
                    $Record['CustomerId'] = 0;
                    $Record['VendorId'] = 0;
                    $Record['BankAccountId'] = 0;
                    $Recipient = '';
                    
                    if(isset($Record['TransactionDate']))
                    { $TransctionDate = date('Y-m-d', strtotime($Record['TransactionDate'])); }
                    else 
                    { $TransctionDate = date('Y-m-d H:i:s'); }
                     

                    $VoucherData = array(
                    'TransactionDate' => $TransctionDate,
                    'TotalDebit' => array_sum($Record['Debit']),
                    'TotalCredit' => array_sum($Record['Credit']),
		    'VoucherNote'=> $Record['VoucherNote'],
		    'AddedOn' => date('Y-m-d H:i:s'),
                    'AddedBy' => $this->session->userdata('EmployeeId'));
                     
		    
		     if($GeneralJournalId != 0 ) 
		     { $this->db->where('GeneralJournalId',$GeneralJournalId); }
                     $this->db->update('pos_accounts_generaljournal',$VoucherData);
		     
		     
		      $this->db->where('GeneralJournalId', $GeneralJournalId);
                      $DeletStatus = $this->db->delete('pos_accounts_generaljournal_entries');
                       
                      if($DeletStatus)
                      {
			    
                        $counter = 0;
                        $COA_Array = array_filter($Record['ChartOfAccount']);
                        $NoOfRecord =  count($COA_Array);  
                        
			            for($i = 0; $i<$NoOfRecord; $i++ )
                        {
                           //Payees values
                           if(isset($Record['PayeeName'][$i]) && $Record['PayeeName'][$i] != '' && $Record['PayeeName'][$i] != null )
                           {
                            $SalemanId = $Record['PayeeName'][$i];
                            $Record['SalemanId'] = $SalemanId;
                            $Record['CustomerId'] = 0;
                            $Record['VendorId'] = 0;
                            $Record['BankAccountId'] = 0;
                            // if(($PayeeChartOfAccount >= '10005') && ($PayeeChartOfAccount <= '14999'))
                            // { $Record['CustomerId'] = $Payee[1]; } else { $Record['CustomerId'] = 0; }

                            // if(($PayeeChartOfAccount >= '20000') && ($PayeeChartOfAccount <= '20999'))
                            // { $Record['VendorId'] = $Payee[1]; } else { $Record['VendorId'] = 0; }

                            // if($PayeeChartOfAccount >= '15000' && $PayeeChartOfAccount <= '15500')
                            // { $Record['BankAccountId'] = $PayeeId; } else { $Record['BankAccountId'] = 0; }
                          }
                          else
                          {
                            $Record['SalemanId'] = 0;
                            $Record['CustomerId'] = 0;
                            $Record['VendorId'] = 0;
                            $Record['BankAccountId'] = 0;
                          }  
                           // End of code
                          
                           if(isset($Record['Recipient'][$i])) 
                           { $Recipient = $Record['Recipient'][$i]; }
                           else
                           { $Recipient = ''; }
                           
                           $VoucherDetailData = array(
                           'ChartOfAccountId' => $Record['ChartOfAccount'][$i],
                           'VendorId' => $Record['VendorId'],
                           'SalemanId' => ($Record['Debit'][$i]) ? $Record['SalemanId'] : null,
                           'CustomerId' => $Record['CustomerId'],
                           'BankAccountId' => $Record['BankAccountId'],    
                           'Recipient' => $Recipient,
                           'Detail' => $Record['Description'][$i],
                           'Debit' => $Record['Debit'][$i],
                           'Credit' => $Record['Credit'][$i],
                           'GeneralJournalId' => $GeneralJournalId,
                           'ReconciliationDate' => $TransctionDate
                           );

                             $this->db->set($VoucherDetailData);
                             $status = $this->db->insert('pos_accounts_generaljournal_entries');
                             if($status)
			     { $counter++; }
                        }
                        if($NoOfRecord == $counter )
			{ return $GeneralJournalId; }
                    }
                    else    
		    {  return('fail'); } // roll back all transection
            }
	    
	    
	    
	
        public function SaveGeneralJournal($Record,$id=0,$InvoiceId=0)
        { 
              $PayeeId = 0;
              $PayeeVal = 0; 
            
              
              if($id != 0 || $InvoiceId != 0)
              {                 
                  $Record['CustomerId'] = 0;
                  $Record['VendorId'] = 0;
                  $Record['BankAccountId'] = 0;
                  $Recipient = '';
//                     $Series  = 0;
//                     if($Record['VoucherType']==1)   
//                     {
//                         $Series = $this->db->where('VoucherType','1')->from('pos_accounts_generaljournal')->count_all_results();
//                         $Reference = "CPV".($Series+1);
//                     }
//                     elseif($Record['VoucherType']==2)   
//                     {
//                         $Series = $this->db->where('VoucherType','2')->from('pos_accounts_generaljournal')->count_all_results();
//                         $Reference = "BPV".($Series+1);
//                     }           
//                     elseif($Record['VoucherType']==3)   
//                     {
//                         $Series = $this->db->where('VoucherType','3')->from('pos_accounts_generaljournal')->count_all_results();
//                         $Reference = "CRV".($Series+1);
//                     }           
//                     elseif($Record['VoucherType']==4)   
//                     {
//                         $Series = $this->db->where('VoucherType','4')->from('pos_accounts_generaljournal')->count_all_results();
//                         $Reference = "BRV".($Series+1);
//                     }           
//                     else   
//                     {
//                         $Series = $this->db->where('VoucherType','5')->from('pos_accounts_generaljournal')->count_all_results();
//                         $Reference = "JV".($Series+1);
//                     }  
                
                    $TransctionDate =  date('Y-m-d', strtotime($Record['TransactionDate']));
                    
                     
                     if(isset($Record['SalesInvoiceId']) && $Record['SalesInvoiceId']!='')
                     { $SalesInvoiceId = $Record['SalesInvoiceId']; } else { $SalesInvoiceId = 0; }   
                     
                     
                      // array for pos_accounts_generaljournal table
                      $arrFinalData = array(
                      'TransactionDate'=>$TransctionDate,
                      'SalesInvoiceId'=>$SalesInvoiceId,
                      'VoucherType'=>$Record['VoucherType'],
                      'TotalDebit'=>array_sum($Record['Debit']),
                      'TotalCredit'=>array_sum($Record['Credit']),
                      'VoucherNote'=>$Record['VoucherNote'],
		      'AddedOn'=>date('Y-m-d H:i:s'),
                      'AddedBy'=>$this->session->userdata('EmployeeId'));                      
                      
                      // Update General Journal Table
                      if($id != 0 ) { $this->db->where('GeneralJournalId',$id); }
                      if($InvoiceId != 0 ) { $this->db->where('SalesInvoiceId',$InvoiceId); }
                      $status = $this->db->update('pos_accounts_generaljournal',$arrFinalData);
                    
                     if($status)
                     {
                        if($InvoiceId != 0 )
                        {
                            $query = $this->db->select('GeneralJournalId');
                            $this->db->from('pos_accounts_generaljournal');
                            $this->db->where('SalesInvoiceId',$InvoiceId);
                            $query = $this->db->get()->row();
                            $id = $query->GeneralJournalId;
                        }    
                        
                        $this->db->where('GeneralJournalId', $id);
                        $DeletStatus = $this->db->delete('pos_accounts_generaljournal_entries');
                       
                        if($DeletStatus)
                        {
                            $conter = 0;
                            $tepCOA_Array = array_filter($Record['chartOfAccount']);
                            $noOfRecord =  count($tepCOA_Array);  
                            for($i = 0; $i < $noOfRecord; $i++ )
                            { 
                                if($InvoiceId != 0)
                                {$chartOfAccount = $Record['chartOfAccount'][$i];}
                                else
                                {$chartOfAccount = $Record['hdnchartOfAccount'][$i];}
                                
                                
                                //  Payees values
                                if(isset($Record['hdnPayeeName'][$i]) && $Record['hdnPayeeName'][$i] != '' && $Record['hdnPayeeName'][$i] != null )
                                {
                                 $Payee = explode("-", $Record['hdnPayeeName'][$i]);
                                 $PayeeChartOfAccount = $Payee[0];
                                 $PayeeId = $Payee[1];

                                if(($PayeeChartOfAccount >= '10005') && ($PayeeChartOfAccount <= '14999'))
                                { $Record['CustomerId'] = $Payee[1]; } else { $Record['CustomerId'] = 0; }
                                
                                if(($PayeeChartOfAccount >= '20000') && ($PayeeChartOfAccount <= '20999'))
                                { $Record['VendorId'] = $Payee[1]; }  else { $Record['VendorId'] = 0; }

                                if($PayeeChartOfAccount >= '15000' && $PayeeChartOfAccount <= '15500')
                                { $Record['BankAccountId'] = $PayeeId; }  else { $Record['BankAccountId'] = 0; }
                                 }
                                else
                                {
                                 $Record['CustomerId'] = 0;
                                 $Record['VendorId'] = 0;
                                 $Record['BankAccountId'] = 0;
                               }  
                                // End of code                            
                               
                               
                               // Following CustomerId comes from Auto Accounting entry of Sales Invoice entries
                               if(isset($Record['CustomerName']) && ($Record['CustomerName']!=''))
                               { $Record['CustomerId'] = $Record['CustomerName']; }
                               //else
                              // { $Record['CustomerId'] = 0; }
                               // End of code
                               

                               if(isset($Record['Recipient'][$i])) 
                               { $Recipient = $Record['Recipient'][$i]; }
                              // else
                              // { $Recipient = ''; }
                                
                                // array for pos_accounts_generaljournal_entries table
                                $arrSingelRecord = array(
                                'ChartOfAccountId'=>$chartOfAccount,
                                'VendorId'=>$Record['VendorId'],
                                'CustomerId'=>$Record['CustomerId'],
                                'BankAccountId'=>$Record['BankAccountId'],
                                'Recipient'=>$Recipient,
                                'Detail'=>$Record['Description'][$i],
                                'Debit'=>$Record['Debit'][$i],
                                'Credit'=>$Record['Credit'][$i],
                                'GeneralJournalId'=>$id
                                );
                                    $this->db->set($arrSingelRecord);
                                    $status = $this->db->insert('pos_accounts_generaljournal_entries');
                                    if($status)
                                    $conter++;
                            }
                            if($noOfRecord == $conter )
                              return $id; // ('success');
                        }
                        else
                        {//rollback all transection
                        } 
                    }
                    else    
                        return('fail');// rollbakc all transection
                     
                }
                else
                {                 
                    $Series  = 0;
                    $Record['CustomerId'] = 0;
                    $Record['VendorId'] = 0;
                    $Record['BankAccountId'] = 0;
                    $Recipient = '';
//                    $Voucher ='JV';
//                    if($Record['EntryType'] == 1 && $Record['PaymentType']==1) 
//                    {
//                        $Series = $this->db->where('EntryType','1')->where('PaymentType','1')->from('pos_accounts_generaljournal')->count_all_results();
//                        $Voucher = "CPV";
//                        $Series = $Series +1;
//                    }
//                    $Reference = $Voucher.$Series;
                    
                    // If variable is undefined then redirect into main Generaljournal page
                    if($Record['VoucherType'] == '')
                    { redirect("Generaljournal/");}
                    
                     if(isset($Record['VoucherType']) && $Record['VoucherType']==1)   
                     {
                         $Series = $this->db->where('VoucherType','1')->from('pos_accounts_generaljournal')->count_all_results();
                         $Reference = "CPV".($Series+1);
                     }
                     else if(isset($Record['VoucherType']) && $Record['VoucherType']==2) 
                     {
                         $Series = $this->db->where('VoucherType','2')->from('pos_accounts_generaljournal')->count_all_results();
                         $Reference = "BPV".($Series+1);
                     }           
                     else if(isset($Record['VoucherType']) && $Record['VoucherType']==3)   
                     {
                         $Series = $this->db->where('VoucherType','3')->from('pos_accounts_generaljournal')->count_all_results();
                         $Reference = "CRV".($Series+1);
                     }           
                     else if(isset($Record['VoucherType']) && $Record['VoucherType']==4)
                     {
                         $Series = $this->db->where('VoucherType','4')->from('pos_accounts_generaljournal')->count_all_results();
                         $Reference = "BRV".($Series+1);
                     }
                     else   
                     {
                         $Series = $this->db->where('VoucherType','5')->from('pos_accounts_generaljournal')->count_all_results();
                         $Reference = "JV".($Series+1);
                     }           
                     
                     // array for pos_accounts_generaljournal table
                     if(isset($Record['TransactionDate']))
                     { $TransctionDate = date('Y-m-d', strtotime($Record['TransactionDate'])); }
                     else 
                     { $TransctionDate = date('Y-m-d H:i:s'); }
                     

                     if(isset($Record['SalesInvoiceId']) && $Record['SalesInvoiceId']!='')
                     { $SalesInvoiceId = $Record['SalesInvoiceId']; } else { $SalesInvoiceId = 0; }                     
                     
                     $arrFinalData = array(
                    'TransactionDate'=>$TransctionDate,
                    'SalesInvoiceId'=>$SalesInvoiceId,
                    'VoucherType'=>$Record['VoucherType'],
                    'Reference'=>$Reference,
                    'TotalDebit'=>array_sum($Record['Debit']),
                    'TotalCredit'=>array_sum($Record['Credit']),
                    'AddedOn'=>date('Y-m-d H:i:s'),
                    'AddedBy'=>$this->session->userdata('EmployeeId'));
                     
                     $this->db->set($arrFinalData);
                     $status = $this->db->insert('pos_accounts_generaljournal');
                    
                     if($status)
                     {
                        $conter = 0;
                        $GJ_LastInsertedId=$this->db->insert_id();
                        $tepCOA_Array = array_filter($Record['chartOfAccount']);
                        $noOfRecord =  count($tepCOA_Array);  
                        for($i = 0; $i < $noOfRecord; $i++ )
                        {
                          
                          //  Payees values
                           if(isset($Record['hdnPayeeName'][$i]) && $Record['hdnPayeeName'][$i] != '' && $Record['hdnPayeeName'][$i] != null )
                           {
                            $Payee = explode("-", $Record['hdnPayeeName'][$i]);
                            $PayeeChartOfAccount = $Payee[0];
                            $PayeeId = $Payee[1];

                           if(($PayeeChartOfAccount >= '10005') && ($PayeeChartOfAccount <= '14999'))
                           { $Record['CustomerId'] = $Payee[1]; } else { $Record['CustomerId'] = 0; }
                           
                           if(($PayeeChartOfAccount >= '20000') && ($PayeeChartOfAccount <= '20999'))
                           { $Record['VendorId'] = $Payee[1]; } else { $Record['VendorId'] = 0; }

                           if($PayeeChartOfAccount >= '15000' && $PayeeChartOfAccount <= '15500')
                           { $Record['BankAccountId'] = $PayeeId; } else { $Record['BankAccountId'] = 0; }
                          }
                           else
                           {
                            $Record['CustomerId'] = 0;
                            $Record['VendorId'] = 0;
                            $Record['BankAccountId'] = 0;
                          }  
                           // End of code
                          
                          
                          // Following CustomerId comes from Auto Accounting entry of Sales Invoice entries
                          if(isset($Record['CustomerName']) && ($Record['CustomerName']!=''))
                          { $Record['CustomerId'] = $Record['CustomerName']; }
                        //  else
                        //  { $Record['CustomerId'] = 0; }
                          // End of code
                                
                           if(isset($Record['Recipient'][$i])) 
                           { $Recipient = $Record['Recipient'][$i]; }
                          // else
                          // { $Recipient = ''; }
                           
                           // array for pos_accounts_generaljournal_entries table
                           $arrSingelRecord = array(
                           'ChartOfAccountId'=>$Record['chartOfAccount'][$i],
                           'VendorId'=>$Record['VendorId'],
                           'CustomerId'=>$Record['CustomerId'],
                           'BankAccountId'=>$Record['BankAccountId'],    
                           'Recipient'=>$Recipient,
                           'Detail'=>$Record['Description'][$i],
                           'Debit'=>$Record['Debit'][$i],
                           'Credit'=>$Record['Credit'][$i],
                           'GeneralJournalId'=>$GJ_LastInsertedId
                           );
                                
                             $this->db->set($arrSingelRecord);
                             $status = $this->db->insert('pos_accounts_generaljournal_entries');
                             if($status)
                             $conter++;
                        }
                        if($noOfRecord == $conter )
                          //  die;
                        return $GJ_LastInsertedId;   //echo 'success';
                    }
                    else    
                        return('fail'); // roll back all transection
                } 
            }
  
        
         function GetGeneralJournal($GeneralJournalId,$colums='*')
	 {             
            $this->db->select($colums);
            $this->db->from('pos_accounts_generaljournal');
            $this->db->where('GeneralJournalId',$GeneralJournalId);
            $ResultGeneralJournal = $this->db->get()->row();
            
            $this->db->select(
            'pos_accounts_chartofaccount.`ChartOfAccountTitle`,
            pos_accounts_chartofaccount.`ChartOfAccountCode`,
            pos_accounts_generaljournal_entries.`ChartOfAccountId`,
            pos_accounts_generaljournal_entries.`Debit`,
            pos_accounts_generaljournal_entries.`Credit`,
            pos_accounts_generaljournal_entries.`CustomerId`, 
            pos_accounts_generaljournal_entries.`VendorId`,
            pos_accounts_generaljournal_entries.`BankAccountId`,
            pos_accounts_generaljournal_entries.`Detail`,
            pos_saleman.`SalemanId`,
            pos_saleman.`SalemanName`
            ');
            $this->db->from('pos_accounts_generaljournal_entries');
            $this->db->order_by('GeneralJournalEntryId ASC');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId = pos_accounts_generaljournal_entries.ChartOfAccountId');
            $this->db->join('pos_saleman','pos_saleman.ChartOfAccountId = pos_accounts_generaljournal_entries.SalemanId', 'left');
            $this->db->where('GeneralJournalId',$GeneralJournalId);
            $ResultGeneralJournalEntries = $this->db->get()->result_array();
          
            $Result = array('GeneralJournal'=>$ResultGeneralJournal,'GeneralJournalEntries'=>$ResultGeneralJournalEntries);
            return $Result;
        }
         
	// get cash reciept voucher through sale id
        function GetGeneralJournalBySaleId($SaleId,$colums='*')
        {             
	    $this->db->select($colums);
	    $this->db->from('pos_accounts_generaljournal');
	    $this->db->where(['SaleId'=>$SaleId, 'VoucherType'=>3]);
	    $ResultGeneralJournal = $this->db->get()->row();

	    return $ResultGeneralJournal;
        }
	   
	   
        function GetGeneralJournalView($GeneralJournalId,$colums='*')
	{
             $this->db->select($colums);
            $this->db->from('pos_accounts_generaljournal');
            $this->db->where('GeneralJournalId',$GeneralJournalId);
            $ResultGeneralJournal = $this->db->get()->row();
            
            $this->db->select(
            'pos_accounts_chartofaccount.`ChartOfAccountTitle`,
            pos_accounts_chartofaccount.`ChartOfAccountCode`,
            pos_accounts_generaljournal_entries.`ChartOfAccountId`,
            pos_accounts_generaljournal_entries.`Debit`,
            pos_accounts_generaljournal_entries.`Credit`,
            pos_customer.`CustomerName`,
            pos_vendor.`VendorName`,
            pos_bank_accounts.`AccountTitle`,
            pos_saleman.`SalemanName`,
            pos_accounts_generaljournal_entries.`Detail`
            ');
            $this->db->from('pos_accounts_generaljournal_entries');
            $this->db->order_by('GeneralJournalEntryId ASC');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId = pos_accounts_generaljournal_entries.ChartOfAccountId');
            $this->db->join('pos_customer','pos_customer.CustomerId = pos_accounts_generaljournal_entries.CustomerId','left');
            $this->db->join('pos_vendor','pos_vendor.VendorId = pos_accounts_generaljournal_entries.VendorId','left');
            $this->db->join('pos_bank_accounts','pos_bank_accounts.AccountId = pos_accounts_generaljournal_entries.BankAccountId','left');
            $this->db->join('pos_saleman','pos_saleman.ChartOfAccountId = pos_accounts_generaljournal_entries.SalemanId','left');
            
            $this->db->where('GeneralJournalId',$GeneralJournalId);
            $ResultGeneralJournalEntries = $this->db->get()->result_array();
            
            $Result = array('GeneralJournal'=>$ResultGeneralJournal,'GeneralJournalEntries'=>$ResultGeneralJournalEntries);
            return $Result;
        }


        function GetGeneralJournalVoucher($GeneralJournalId,$colums='*')
        {
             $this->db->select($colums);
            $this->db->from('pos_accounts_generaljournal');
            $this->db->where('GeneralJournalId',$GeneralJournalId);
            $ResultGeneralJournal = $this->db->get()->result_array();
            
            $this->db->select(
            'pos_accounts_generaljournal_entries.GeneralJournalId,
            pos_accounts_chartofaccount.`ChartOfAccountTitle`,
            pos_accounts_chartofaccount.`ChartOfAccountCode`,
            pos_accounts_generaljournal_entries.`ChartOfAccountId`,
            pos_accounts_chartofaccount_controls.ControlName,
            pos_accounts_generaljournal_entries.`Debit`,
            pos_accounts_generaljournal_entries.`Credit`,
            pos_customer.`CustomerName`,
            pos_vendor.`VendorName`,
            pos_bank_accounts.`AccountTitle`,
            pos_accounts_generaljournal_entries.`Detail`
            ');
            $this->db->from('pos_accounts_generaljournal_entries');
            $this->db->order_by('GeneralJournalEntryId ASC');
            $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId = pos_accounts_generaljournal_entries.ChartOfAccountId');
            $this->db->join('pos_accounts_chartofaccount_controls','pos_accounts_chartofaccount_controls.ChartOfAccountControlId = pos_accounts_chartofaccount.ChartOfAccountControlId');
            $this->db->join('pos_customer','pos_customer.CustomerId = pos_accounts_generaljournal_entries.CustomerId','left');
            $this->db->join('pos_vendor','pos_vendor.VendorId = pos_accounts_generaljournal_entries.VendorId','left');
            $this->db->join('pos_bank_accounts','pos_bank_accounts.AccountId = pos_accounts_generaljournal_entries.BankAccountId','left');
            
            $this->db->where('GeneralJournalId',$GeneralJournalId);
            $ResultGeneralJournalEntries = $this->db->get()->result_array();
            
            $Result = array('GeneralJournal'=>$ResultGeneralJournal,'GeneralJournalEntries'=>$ResultGeneralJournalEntries);
            return $Result;
        }
        
        
        function GetGeneralJournalView22($GeneralJournalId,$colums='*')
	{
                $this->db->select($colums);
                $this->db->from('pos_accounts_generaljournal');
                $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId = pos_accounts_generaljournal.GeneralJournalId');
                $this->db->join('pos_accounts_chartofaccount','pos_accounts_chartofaccount.ChartOfAccountId = pos_accounts_generaljournal_entries.ChartOfAccountId');
                $this->db->join('pos_customer','pos_customer.CustomerId = pos_accounts_generaljournal_entries.CustomerId');
                $this->db->where('pos_accounts_generaljournal.GeneralJournalId',$GeneralJournalId);
               // $this->db->order_by('GeneralJournalEntryId ASC');
                $ResultGeneralJournal = $this->db->get()->row();
                //$ResultGeneralJournalEntries = $this->db->get()->result_array();
              //  $Result = array('GeneralJournal'=>$ResultGeneralJournal,'GeneralJournalEntries'=>$ResultGeneralJournalEntries);
                return $ResultGeneralJournal;
        }
        
        
// blewo code is trash
        function GetAllCategories()
	{
                $result = $this->db->get('pos_accounts_chartofaccount_categories')->result_array();
                return $result;
        }
        
        function GetAllControlCodes()
	{
                $result = $this->db->get('pos_accounts_chartofaccount_controls')->result_array();
                return $result;
        }

        function GetControlCodeByCategoryId($id)
	{
                $result = $this->db->get_where('pos_accounts_chartofaccount_controls',array('ChartOfAccountCategoryId'=>$id) )->result_array();
                return $result;
        }
        function GetControlCode($id)
	{
                $result = $this->db->get_where('pos_accounts_chartofaccount_controls',array('ChartOfAccountControlId'=>$id) )->row();
                return $result;
        }
        
          function GetChartOfAccountCode($id)
	{
                $this->db->select('MAX(ChartOfAccountCode) AS COA_Code');
                $this->db->from('pos_accounts_chartofaccount');
                $this->db->where('ChartOfAccountControlId',$id);
                $result = $this->db->get()->row();
                return $result;
        }


        function GetAccount($id)
	{
                
                $this->db->select('*');
                $this->db->from('pos_bank_accounts');
                $this->db->join('pos_banks', 'pos_bank_accounts.BankId = pos_banks.BankId');
                $this->db->where('pos_bank_accounts.AccountId', $id);
                $result = $this->db->get()->row();
              
                return $result;
        }
           function UpdateAccount($record,$id)
	{
            
              $this->db->where('AccountId', $id);
              $status =  $this->db->update('pos_bank_accounts', $record);
              if($status)
                 return('success');
              else    
              return('fail');
        }

        
        function GetProductWithCondition($requestData)
        {
       // storing  request (ie, get/post) global array to a variable  
            

                $columns = array( 
                // datatable column index  => database column name
                        0 =>'BrandName', 
                        1 => 'CategoryName',
                        1 => 'ProductGroupName',
                        1 => 'Packing',
                );


       
                // getting total number records without any search
                $sql = "SELECT ProductId,BrandName, CategoryName,ProductGroupName,Packing ";
                $sql.="FROM pos_product AS P
                INNER JOIN pos_category AS C ON C.CategoryId = P.CategoryId
                INNER JOIN pos_productgroup AS PD ON PD.ProductGroupId = P.ProductGroupId";
                $query= $this->db->query($sql); 
                $totalData = $query->num_rows();
                $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                
       
                $sql = "SELECT pos_product.ProductId,BrandName, CategoryName,ProductGroupName,Packing ";
                $sql.=" FROM pos_product AS P
                INNER JOIN pos_category AS C ON C.CategoryId = P.CategoryId
                INNER JOIN pos_productgroup AS PD ON PD.ProductGroupId = P.ProductGroupId WHERE 1=1";
                if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                       $sql.=" AND ( BrandName LIKE '".$requestData['search']['value']."%' ";    
                       $sql.=" OR CategoryName LIKE '".$requestData['search']['value']."%' ";
                       $sql.=" OR ProductGroupName LIKE '".$requestData['search']['value']."%' )";  
                }
                //print_r($columns);
                //echo $columns[$requestData['order'][0]['column']];
                //die;
                $query=$this->db->query( $sql) ;
                $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
                $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
                /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
                
                $query=$this->db->query($sql);  


                //print_r($query->result_array());
                
      
        return $query->result_array();
    }
            
            
        public function AddControlCode	($Record)
            {
             $this->db->set($Record);
             $status = $this->db->insert('pos_accounts_chartofaccount_controls');
              if($status)
                 return('success');
              else    
              return('fail');
            }   
            
        function UpdateControlCode($Record,$id)
	{
              
              $this->db->where('ChartOfAccountControlId', $id);
              $status =  $this->db->update('pos_accounts_chartofaccount_controls', $Record);
              if($status)
                 return('success');
              else    
              return('fail');
        }  
        
        
         public function GetAllCustomers()
        {            
            $this->db->select(' pos_accounts_chartofaccount.ChartOfAccountCode AS CustomerChartOfAccountCode,  
            pos_customer.CustomerId, 
            pos_customer.CustomerName ');
            $this->db->from('pos_customer');
             $this->db->join('pos_accounts_chartofaccount', 'pos_accounts_chartofaccount.ChartOfAccountId = pos_customer.ChartOfAccountId');
            $result = $this->db->get()->result_array();
            return $result;     
            
        }
        
        public function GetAllVendors()
        {            
            $this->db->select(' pos_accounts_chartofaccount.ChartOfAccountCode AS VendorChartOfAccountCode,  
            pos_vendor.VendorId, 
            pos_vendor.VendorName');
            $this->db->from('pos_vendor');
             $this->db->join('pos_accounts_chartofaccount', 'pos_accounts_chartofaccount.ChartOfAccountId = pos_vendor.ChartOfAccountId');
            $result = $this->db->get()->result_array();
            return $result;            
        }
        
        
        public function GetAllBanks()
        {            
            $this->db->select(' pos_accounts_chartofaccount.ChartOfAccountCode AS BanksChartOfAccountCode,  
            pos_bank_accounts.AccountId, 
            pos_bank_accounts.AccountTitle');
            $this->db->from('pos_bank_accounts');
             $this->db->join('pos_accounts_chartofaccount', 'pos_accounts_chartofaccount.ChartOfAccountId = pos_bank_accounts.ChartOfAccountId');
            $result = $this->db->get()->result_array();
            return $result;             
        }
	
	
	
	
	
        
	
	/**********************  Auto Vouchers Functions For Purchase Invoice *****************************************/
	public function AddPurchaseInvoiceGJ($Record,$id=0,$InvoiceId=0)
        { 
              $PayeeId = 0;
              $PayeeVal = 0;
              $Series  = 0;

                    // If variable is undefined then redirect into main Generaljournal page
                    if(isset($Record['VoucherType']) && $Record['VoucherType']==5)
                    {
                        $Series = $this->db->where('VoucherType','5')->from('pos_accounts_generaljournal')->count_all_results();
                        $Reference = "JV".($Series+1);
                    }
                    else
                    { redirect("Generaljournal/"); }

                    // array for pos_accounts_generaljournal table
                    if(isset($Record['TransactionDate']))
                    { $TransctionDate = date('Y-m-d', strtotime($Record['TransactionDate'])); }
                    else 
                    { $TransctionDate = date('Y-m-d H:i:s'); }
                     
                    if(isset($Record['VendorId']) && $Record['VendorId']!='')
                    { $VendorId = $Record['VendorId']; } else { $VendorId = 0; }
                     
                    if(isset($Record['PurchaseInvoiceId']) && $Record['PurchaseInvoiceId']!='')
                    { $PurchaseInvoiceId = $Record['PurchaseInvoiceId']; } else { $PurchaseInvoiceId = 0; }                     
                     
                    $PurchaseInvoiceData = array(
                    'TransactionDate'=>$TransctionDate,
                    'PurchaseInvoiceId'=>$PurchaseInvoiceId,
                    'VoucherType'=>$Record['VoucherType'],
                    'Reference'=>$Reference,
                    'TotalDebit'=>array_sum($Record['Debit']),
                    'TotalCredit'=>array_sum($Record['Credit']),
                    'AddedOn'=>date('Y-m-d H:i:s'),
                    'AddedBy'=>$this->session->userdata('EmployeeId'));
                     
                     $this->db->set($PurchaseInvoiceData);
                     $status = $this->db->insert('pos_accounts_generaljournal');
                    
                     if($status)
                     {
                        $conter = 0;
                        $GJ_LastInsertedId=$this->db->insert_id();
			
                        $tepCOA_Array = array_filter($Record['chartOfAccount']);
                        $NoOfRecord =  count($tepCOA_Array);  
                        
			for($i = 0; $i < $NoOfRecord; $i++ )
                        {      
                           if(isset($Record['Recipient'][$i])) 
                           { $Recipient = $Record['Recipient'][$i]; }
                           else
                           { $Recipient = ''; }
                           
                           // array for pos_accounts_generaljournal_entries table
                           $arrSingelRecord = array(
                           'ChartOfAccountId'=>$Record['chartOfAccount'][$i],
                           'VendorId'=>$VendorId,
                           'CustomerId'=>0,
                           'BankAccountId'=>0,
                           'Recipient'=>$Recipient,
                           'Detail'=>$Record['Description'][$i],
                           'Debit'=>$Record['Debit'][$i],
                           'Credit'=>$Record['Credit'][$i],
                           'GeneralJournalId'=>$GJ_LastInsertedId
                           );
                                
                             $this->db->set($arrSingelRecord);
                             $status = $this->db->insert('pos_accounts_generaljournal_entries');
                             if($status)
                             $conter++;
                        }
                        if($NoOfRecord == $conter )
                        return $GJ_LastInsertedId;   //echo 'success';
                    }
                    else    
                        return('fail'); // roll back all transection
            }
	    
	    
	  public function UpdatePurchaseInvoiceGJ($Record)
          {    
              $PayeeId = 0;
              $PayeeVal = 0;
              $Series  = 0;
	      
               // If variable is undefined then redirect into main Generaljournal page
	      /* if(isset($Record['VoucherType']) && $Record['VoucherType']==5)
	      {
		$Series = $this->db->where('VoucherType','5')->from('pos_accounts_generaljournal')->count_all_results();
		$Reference = "JV".($Series+1);
	      }
	      else
	      { redirect("Generaljournal/"); }
	      */
	      
	    // array for pos_accounts_generaljournal table
	     if(isset($Record['TransactionDate']))
             { $TransctionDate = date('Y-m-d', strtotime($Record['TransactionDate'])); }
             else 
             { $TransctionDate = date('Y-m-d H:i:s'); }
		    

	    if(isset($Record['VendorId']) && $Record['VendorId']!='')
	    { $VendorId = $Record['VendorId']; } else { $VendorId = 0; }

	    if(isset($Record['PurchaseInvoiceId']) && $Record['PurchaseInvoiceId'] != '')
	    { $PurchaseInvoiceId = $Record['PurchaseInvoiceId']; } else { $PurchaseInvoiceId = 0; }                     

	    $PurchaseInvoiceData = array(
	    'TransactionDate'=>$TransctionDate,
	    'TotalDebit'=>array_sum($Record['Debit']),
	    'TotalCredit'=>array_sum($Record['Credit']),
	    'AddedOn'=>date('Y-m-d H:i:s'),
	    'AddedBy'=>$this->session->userdata('EmployeeId'));
	    
	     if($PurchaseInvoiceId != 0 ) { $this->db->where('PurchaseInvoiceId',$PurchaseInvoiceId); }
             $status = $this->db->update('pos_accounts_generaljournal',$PurchaseInvoiceData);

	     if($status)
	     {
		if($PurchaseInvoiceId != 0 )
		{
		    $query = $this->db->select('GeneralJournalId');
		    $this->db->from('pos_accounts_generaljournal');
		    $this->db->where('PurchaseInvoiceId',$PurchaseInvoiceId);
		    $query = $this->db->get()->row();
		    $GeneralJournalId = $query->GeneralJournalId;
		    
		    $this->db->where('GeneralJournalId', $GeneralJournalId);
		    $DeletStatus = $this->db->delete('pos_accounts_generaljournal_entries');
		}
		else
		{
		    redirect("PurchaseInvoice/");
		}
		 
		
		if($DeletStatus)
                {
		    $conter = 0;
		    $tempCOA_Array = array_filter($Record['chartOfAccount']);
		    $TotalRecords =  count($tempCOA_Array);  
		    for($i = 0; $i < $TotalRecords; $i++ )
		    {			
			$chartOfAccount = $Record['chartOfAccount'][$i];
			
			if(isset($Record['VendorId']) && ($Record['VendorId']!=''))
                        { $Record['VendorId'] = $Record['VendorId']; }
			
			if(isset($Record['Recipient'][$i])) 
                        { $Recipient = $Record['Recipient'][$i]; }
			
			// array for pos_accounts_generaljournal_entries table
			$arrSingelRecord = array(
			'ChartOfAccountId'=>$chartOfAccount,
			'VendorId'=>$Record['VendorId'],
			'Recipient'=>$Recipient,
			'Detail'=>$Record['Description'][$i],
			'Debit'=>$Record['Debit'][$i],
			'Credit'=>$Record['Credit'][$i],
			'GeneralJournalId'=>$GeneralJournalId
			);
			
			$this->db->set($arrSingelRecord);
			$status = $this->db->insert('pos_accounts_generaljournal_entries');
			if($status)
			$Counter++;
		    }

		    if($TotalRecords == $Counter )
                    return $GeneralJournalId; // ('success');
		    
		}
	    }
	    else    
	    { 
		return('fail');  // roll back all transection
	    }
         }
   
	 

	 /*********************           Functions For Auto Receipt Vouchers         *********************/
	 public function ReceiptGJEntry($ReceiptGJEntry)
	 {
	    $Series = $this->db->where('VoucherType','4')->from('pos_accounts_generaljournal')->count_all_results();
	    $Reference = "BRV".($Series+1);
	     
	    $ReceiptData = array(
	    'TransactionDate' => date('Y-m-d', strtotime($ReceiptGJEntry['TransactionDate'])),
	    'ReceiptId' => $ReceiptGJEntry['ReceiptId'],
	    'VoucherType' => 4,
	    'EntryType' => 1,
	    'Reference' => $Reference,
	    'TotalDebit' => $ReceiptGJEntry['TotalDebit'],
	    'TotalCredit' => $ReceiptGJEntry['TotalCredit'],
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'));

	    $this->db->set($ReceiptData);
	    $this->db->insert('pos_accounts_generaljournal');
	    $GJ_LastInsertedId = $this->db->insert_id();
	    
	    return $GJ_LastInsertedId;
	}
	
	
	public function UpdateReceiptGJEntry($ReceiptGJEntry)
	{ 
	    $ReceiptData = array(
	    'TransactionDate' => date('Y-m-d', strtotime($ReceiptGJEntry['TransactionDate'])),
	    'TotalDebit' => $ReceiptGJEntry['TotalDebit'],
	    'TotalCredit' => $ReceiptGJEntry['TotalCredit'],
	    'AddedOn' => date('Y-m-d H:i:s'),
	    'AddedBy' => $this->session->userdata('EmployeeId'));
	    
	    $this->db->where('ReceiptId', $ReceiptGJEntry['ReceiptId']);
	    $this->db->update('pos_accounts_generaljournal', $ReceiptData);
	    
	    $row = $this->db->get_where('pos_accounts_generaljournal', array('ReceiptId' => $ReceiptGJEntry['ReceiptId']))->row();

	    return $row->GeneralJournalId;
	}
	
	
	public function ReceiptGJDetailEntry($GJEntryDetail)
        {
	     $NoOfRecord = count($GJEntryDetail['ChartOfAccount']);
	   
	     for($i = 0; $i < $NoOfRecord; $i++ )
             {
		if(isset($GJEntryDetail['Recipient'][$i])) 
		{ $Recipient = $GJEntryDetail['Recipient'][$i]; }
		else
		{ $Recipient = ''; }

		// array for pos_accounts_generaljournal_entries table
		$GJEntryDetailRecord = array(
		'GeneralJournalId' => $GJEntryDetail['GeneralJournalId'],
		'ChartOfAccountId' => $GJEntryDetail['ChartOfAccount'][$i],
		'VendorId' => 0,
		'CustomerId' => $GJEntryDetail['CustomerId'],
		'BankAccountId' => 0,
		'Recipient' => $Recipient,
		'Detail' => $GJEntryDetail['Description'][$i],
		'Debit' => $GJEntryDetail['Debit'][$i],
		'Credit' => $GJEntryDetail['Credit'][$i]
		);
		
		// Check if array value is empty then do not insert record into table
		if($GJEntryDetail['ChartOfAccount'][$i] != 0)
		{
		   $this->db->set($GJEntryDetailRecord);
		   $this->db->insert('pos_accounts_generaljournal_entries');
		}
		
	     }
	     return true;
	}
	/*********************           End of Functions         *********************/
	
	
	
	
	
	public function UpdateReceiptGJDetailEntry_______________($GJEntryDetail)
        {
	     $NoOfRecord = count($GJEntryDetail['ChartOfAccount']);
	    	     
	     for($i = 0; $i < $NoOfRecord; $i++ )
             {
		if(isset($GJEntryDetail['Recipient'][$i])) 
		{ $Recipient = $GJEntryDetail['Recipient'][$i]; }
		else
		{ $Recipient = ''; }

		// array for pos_accounts_generaljournal_entries table
		$GJEntryDetailRecord = array(
		'GeneralJournalId' => $GJEntryDetail['GeneralJournalId'],
		'ChartOfAccountId' => $GJEntryDetail['ChartOfAccount'][$i],
		'VendorId' => 0,
		'CustomerId' => $GJEntryDetail['CustomerId'],
		'BankAccountId' => 0,
		'Recipient' => $Recipient,
		'Detail' => $GJEntryDetail['Description'][$i],
		'Debit' => $GJEntryDetail['Debit'][$i],
		'Credit' => $GJEntryDetail['Credit'][$i]
		);
		
		// Check if array value is empty then do not insert record into table
		if(!empty($GJEntryDetail['ChartOfAccount']))
		{
		    $this->db->set($GJEntryDetailRecord);
		    $this->db->insert('pos_accounts_generaljournal_entries');
		}
	     }
	     return true;
	}
	// get previous cash received voucher.
    function GetGeneralJournalPreviousCash($ChartOfAccountId,$saleDate)
    {               
            $this->db->select(
            'pos_accounts_generaljournal_entries.`Debit`,
            pos_accounts_generaljournal_entries.`Credit`,
            ');
            $this->db->from('pos_accounts_generaljournal');
            $this->db->join('pos_accounts_generaljournal_entries','pos_accounts_generaljournal_entries.GeneralJournalId = pos_accounts_generaljournal.GeneralJournalId');
            $this->db->where('pos_accounts_generaljournal.VoucherType',3);
            $this->db->where('pos_accounts_generaljournal.TransactionDate', '<=', $saleDate);
            $this->db->where('pos_accounts_generaljournal.SaleId', 0);
            $this->db->where('pos_accounts_generaljournal_entries.ChartOfAccountId',$ChartOfAccountId);
            $Result = $this->db->get()->result_array();
            
            $total_amount = 0;
            foreach($Result as $data){
                $total_amount += $data['Credit'];
            }

            return $total_amount;
    }
    }
?>