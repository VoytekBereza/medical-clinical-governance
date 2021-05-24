<?php

class Avicenna_mod extends CI_Model {

    

    function __construct(){

         parent::__construct();

    }

    

    // get_all_avicenna_ajax_call

    public function get_all_avicenna_ajax_call(){

        

        $aColumns = array('buying_group_id', 'first_name','last_name', 'mobile_no','email_address','created_date');



        // DB table to use

        $sTable = 'users';

        $usertype = 'usertype';

        

        $iDisplayStart = $this->input->get_post('iDisplayStart', true);

        $iDisplayLength = $this->input->get_post('iDisplayLength', true);

        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);

        $iSortingCols = $this->input->get_post('iSortingCols', true);

        $sSearch = $this->input->get_post('sSearch', true);

        $sEcho = $this->input->get_post('sEcho', true);

    

        // Paging

        if(isset($iDisplayStart) && $iDisplayLength != '-1')

        {

            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));

        }

    

        // Ordering

        if(isset($iSortCol_0))

        {

            for($i=0; $i<intval($iSortingCols); $i++)

            {

                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);

                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);

                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

    

                if($bSortable == 'true')

                {

                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));

                }

            }

        }

                /*

        * Filtering

        * NOTE this does not match the built-in DataTables filtering which does it

        * word by word on any field. It's possible to do here, but concerned about efficiency

        * on very large tables, and MySQL's regex functionality is very limited

        */

        

        $more_fields_to_search = array('buying_group_id', 'CONCAT(first_name, " ", last_name)', 'registration_no', 'registration_type', 'usertype.user_type');

        $search_fields = array_merge($aColumns, $more_fields_to_search);

        

        if(isset($sSearch) && !empty($sSearch))

        {

            $this->db->group_start();

            for($i=0; $i<count($search_fields); $i++)

            {

                $bSearchable = $this->input->get_post('bSearchable_'.$i, true);

                

                // Individual column filtering

                //if(isset($bSearchable) && $bSearchable == 'true')

                //{

                    $this->db->or_like($search_fields[$i], $sSearch);

                //}

            }

            $this->db->group_end();

        }

        

            /* author : mzm

        * INDIVIDUAL COLUMN FILTERING 



        * Check if individual filtering is enabled

        */

        

        for($i=0; $i<count($search_fields); $i++)

        {

            if($this->input->get_post('sSearch_6', true) == ''){

                $sSearch = $this->input->get_post('sSearch_'.$i, true);

                

                // Individual column filtering

                if(isset($sSearch) && !empty($sSearch) && $sSearch)

                {

                    $this->db->or_like($search_fields[$i], $sSearch);

                }

            }

        }

        

        $select = array('buying_group_id', 'first_name', 'last_name', 'mobile_no', 'email_address', 'registration_no', 'usertype.user_type', 'created_date', 'users.id', 'usertype.id as user_type_id');



        // Select Data

        $this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $select)), false);

        $this->db->dbprefix($sTable);

        

        //this->db->where('user_type','buyer');

        //join if any 

        //$this->db->join('stores','products.store_id = stores.store_id','INNER');

        // $this->db->where('users.buying_group_id', '1');

        $this->db->join('usertype', 'usertype.id = users.user_type');

        

        // temp-haseeb "We can ad where clause to get the particular result "

        $registration_type = $this->input->get_post('sSearch_6', true);

            

        if(!empty($registration_type) ){

            

            if($registration_type == 'GPhC Non' || $registration_type == 'NMC Non'){

                

                $exploded = explode(' ', $registration_type);

                

                $this->db->where('registration_type', $exploded[0]);

                $this->db->where('is_prescriber', '0');

                

            } else {

                $this->db->or_like('registration_type', $registration_type);

            }

        }

        

        $prescriber = $this->input->get_post('sSearch_7', true);

        

        if(!empty($prescriber) ){

            if($prescriber == 'Yes'){

                $is_prescriber = 1;

            } else {

                $is_prescriber = 0;

            }

            $this->db->or_like('is_prescriber', $is_prescriber);

        }

         

        //$this->db->where('registration_type','GMC');

        //get data : QUERY 1 to get filtered data

        

        $this->db->order_by('id', "DESC");

        

        $this->db->where('users.buying_group_id', '1');

        

        $rResult = $this->db->get($sTable);



        //echo $this->db->last_query();

        

        //mzm total get the current total from the recent query with all filters

        // Data set length after filtering

        

        $this->db->dbprefix($sTable);

        $this->db->select('FOUND_ROWS() AS found_rows');

        

        $iFilteredTotal = $this->db->get()->row()->found_rows;

        $this->db->where('users.buying_group_id', '1');

        $this->db->join('usertype', 'usertype.id = users.user_type');

        

        // Total data set length. QUERY 2 to get overall total without any filters

        //add join referernce here too if required. For total no filters

        //$this->db->join('stores','products.store_id = stores.store_id','INNER');

        

        $iTotal = $this->db->count_all_results($sTable);

        

        // Output

        $output = array(

            'sEcho' => intval($sEcho),

            'iTotalRecords' => $iTotal,

            'iTotalDisplayRecords' => $iFilteredTotal,

            'aaData' => array()

        );

        

        

        $data_db = $rResult->result_array();

        //print_this($data_db); exit;

        foreach( $data_db as $aRow){

            

            $row = array();

            $option_html = '';

            

            // Call Js Login action

            //$login_action = 'user_login_function(\''.$aRow['email_address'].'\',\''.$aRow['id'].'\',\''.$aRow['password'].'\')';          

            //$row[] = "<div class='btn-group'><input type='checkbox' name='admin_verify_status[]' value='".$aRow['id']."' class='inline pull-left' /> &nbsp; &nbsp; <a href='#login' onclick=$login_action type='button' title='Click here to login this user.' class='pull-right btn btn-default btn-xs'><i class='fa fa-external-link'></i></a><div>";

            

            foreach($select as $col)

            {

                

                $user_full_name = ucwords($aRow['first_name'].' '.$aRow['last_name']);

                //$user_purchase_list = $this->purchase->get_purchased_items_split_by_user($aRow['id']);

                $user_purchase_list = $this->purchase->get_purchased_items_split_by_user($aRow['id']);

                    

                $get_user_data = $this->users->get_users_details($aRow['id']);

                    

                $pT = 0;

                $pT18 = 0;

                $aT = 0;

                $F15 = 0;

                $F16 = 0;

                $tH = 0;

                

                $arr_data = '';



                if($col == 'first_name'){

                    $row[] = $aRow['first_name'];

                }elseif($col == 'last_name'){

                    $row[] = $aRow['last_name'];

                }elseif($col == 'mobile_no'){

                    $row[] = $aRow['mobile_no'];

                }elseif($col == 'email_address'){

                    $row[] = $aRow['email_address'];

                    

                }elseif($col == 'usertype.user_type'){

                    

                    $user_type_txt = $aRow['user_type'].' <br>';

                    $is_prescriber_txt = ($aRow['is_prescriber'] == '1') ? '(Precriber)' : '(Non Prescriber)';

                    $user_type_txt .= $is_prescriber_txt;

                    $row[] = $user_type_txt.'<br />'.$aRow['buying_group_id'];

                    

                }elseif($col == 'registration_no'){

                    $row[] = $aRow['registration_no'];

                    

                }elseif($col == 'created_date'){

                    

                    if($aRow['is_prescriber'] == 0){



                    // Check for pT : ID = 10

                    $index_key = array_search(10, array_column($user_purchase_list['pgds']['pgd_list'], 'product_id'));

                    if(strlen($index_key) > 0){



                        $pT_data = $user_purchase_list['pgds']['pgd_list'][10];

                        $pT_is_expired = ((strtotime(date('Y-m-d')) < strtotime($pT_data['expiry_date'])) || $pT_data['expiry_date'] == '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1

                        $pT = ($pT_is_expired) ? 0 : 1;

                        

                        $pT_is_expiring = verify_any_pgd_expiring(10, $pT_data['expiry_date']); //If it is about to expire

                    

                        //$pT = 1;

                        

                    }//end if(strlen($index_key) > 0)



                    // Check for pT18 : ID = 31 //Travel Core 4.0

                    $index_key = array_search(31, array_column($user_purchase_list['pgds']['pgd_list'], 'product_id'));

                    if(strlen($index_key) > 0){



                        $pT18_data = $user_purchase_list['pgds']['pgd_list'][31];

                        $pT18_is_expired = ((strtotime(date('Y-m-d')) < strtotime($pT18_data['expiry_date'])) || $pT18_data['expiry_date'] == '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1

                        $pT18 = ($pT18_is_expired) ? 0 : 1;

                        

                        $pT18_is_expiring = verify_any_pgd_expiring(31, $pT18_data['expiry_date']); //If it is about to expire

                    

                        //$pT = 1;

                        

                    }//end if(strlen($index_key) > 0)

                    

                    // Check for aT : ID = 11

                    $index_key = array_search(11, array_column($user_purchase_list['pgds']['pgd_list'], 'product_id'));

                    if(strlen($index_key) > 0){

                        

                        $aT_data = $user_purchase_list['pgds']['pgd_list'][11];

                        $aT_is_expired = ((strtotime(date('Y-m-d')) < strtotime($aT_data['expiry_date'])) || $aT_data['expiry_date'] == '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1

                        $aT = ($aT_is_expired) ? 0 : 1;

                        

                        $aT_is_expiring = verify_any_pgd_expiring(11, $aT_data['expiry_date']); //If it is about to expire



                        //$aT = 1;

                        

                    }// if(strlen($index_key) > 0)

                    

                    // Check for F15 : ID = 16

                    $index_key = array_search(16, array_column($user_purchase_list['pgds']['pgd_list'], 'product_id'));

                    if(strlen($index_key) > 0){



                        $F15_data = $user_purchase_list['pgds']['pgd_list'][16];

                        $F15_is_expired = ((strtotime(date('Y-m-d')) < strtotime($F15_data['expiry_date'])) || $F15_data['expiry_date'] == '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1

                        $F15 = ($F15_is_expired) ? 0 : 1;

                        

                        $F15_is_expiring = verify_any_pgd_expiring(16, $F15_data['expiry_date']); //If it is about to expire

                        

                        //$F15 = 1;

                        

                    }// if(strlen($index_key) > 0)

                    

                    // Check for F16 : ID = 15

                    $index_key = array_search(15, array_column($user_purchase_list['pgds']['pgd_list'], 'product_id'));

                    if(strlen($index_key) > 0){



                        $F16_data = $user_purchase_list['pgds']['pgd_list'][15];

                        $F16_is_expired = ((strtotime(date('Y-m-d')) < strtotime($F16_data['expiry_date'])) || $F16_data['expiry_date'] == '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1

                        $F16 = ($F16_is_expired) ? 0 : 1;

                        

                        $F16_is_expiring = verify_any_pgd_expiring(15, $F16_data['expiry_date']); //If it is about to expire

                        

                        //$F16 = 1;



                    }//end if(strlen($index_key) > 0)

                    

                    // Check for F16 : ID = 28 // Seasonal 2018

                    $index_key = array_search(28, array_column($user_purchase_list['pgds']['pgd_list'], 'product_id'));

                    if(strlen($index_key) > 0){



                        $F18_data = $user_purchase_list['pgds']['pgd_list'][28];

                        $F18_is_expired = ((strtotime(date('Y-m-d')) < strtotime($F18_data['expiry_date'])) || $F18_data['expiry_date'] == '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1

                        $F18 = ($F18_is_expired) ? 0 : 1;

                        

                        $F18_is_expiring = verify_any_pgd_expiring(28, $F18_data['expiry_date']); //If it is about to expire

                        

                        //$F18 = 1;

                        

                    }//end if(strlen($index_key) > 0)



                    //////////// PGD32-START ///////////



                      // Check for 32 : ID = 32 // Travel Clinic Bolt On - HPV+

                      $index_key_32 = array_search(32, array_column($user_purchase_list['pgds']['pgd_list'], 'product_id'));

                      if(strlen($index_key_32) > 0){



                        $H32_data = $user_purchase_list['pgds']['pgd_list'][32];

                        $H32_is_expired = ((strtotime(date('Y-m-d')) < strtotime($H32_data['expiry_date'])) || $H32_data['expiry_date'] == '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1

                        $H32 = ($H32_is_expired) ? 0 : 1;

                        

                        $H32_is_expiring = verify_any_pgd_expiring(32, $H32_data['expiry_date']); //If it is about to expire

                        

                        //$H32 = 1;

                        

                      } else {



                        $H32 = false;



                      } //end if(strlen($index_key_32) > 0)



                      //////////// PGD32-END ///////////

                     //////////// PGD33-START ///////////

                    // Check for 33 : ID = 33 // Urinary Tract Infection
                    $index_key_33 = array_search(33, array_column($user_purchase_list['pgds']['pgd_list'], 'product_id'));
                    if(strlen($index_key_33) > 0){

                      $H33_data = $user_purchase_list['pgds']['pgd_list'][33];
                      $H33_is_expired = ((strtotime(date('Y-m-d')) < strtotime($H33_data['expiry_date'])) || $H33_data['expiry_date'] == '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1
                      $H33 = ($H33_is_expired) ? 0 : 1;
                      
                      $H33_is_expiring = verify_any_pgd_expiring(33, $H33_data['expiry_date']); //If it is about to expire
                      
                      //$H33 = 1;
                      
                    } else {

                      $H33 = false;

                    } //end if(strlen($index_key_33) > 0)

                    //////////// PGD33-END ///////////

                    //////////// PGD34-START ///////////

                    // Check for 34 : ID = 34 // Dermatitis 
                    $index_key_34 = array_search(34, array_column($user_purchase_list['pgds']['pgd_list'], 'product_id'));
                    if(strlen($index_key_34) > 0){

                      $H34_data = $user_purchase_list['pgds']['pgd_list'][34];
                      $H34_is_expired = ((strtotime(date('Y-m-d')) < strtotime($H34_data['expiry_date'])) || $H34_data['expiry_date'] == '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1
                      $H34 = ($H34_is_expired) ? 0 : 1;
                      
                      $H34_is_expiring = verify_any_pgd_expiring(34, $H34_data['expiry_date']); //If it is about to expire
                      
                      //$H34 = 1;
                      
                    } else {

                      $H34 = false;

                    } //end if(strlen($index_key_34) > 0)

                    //////////// PGD34-END ///////////

                    // Check for F16 : ID = 29 Throat

                    $index_key = array_search(29, array_column($user_purchase_list['pgds']['pgd_list'], 'product_id'));

                    if(strlen($index_key) > 0){

                        

                        $th_data = $user_purchase_list['pgds']['pgd_list'][29];

                        $tH_is_expired = ((strtotime(date('Y-m-d')) < strtotime($th_data['expiry_date'])) || $th_data['expiry_date'] == '0000-00-00') ? 0 : 1; //If PGD is expired marked as 1

                        $tH = ($tH_is_expired) ? 0 : 1;

                        

                        $tH_is_expiring = verify_any_pgd_expiring(29, $th_data['expiry_date']); //If it is about to expire

                        

                        //$tH = 1;

                        

                    }//end if(strlen($index_key) > 0)

                    

                    

                    $user_id = $aRow['id'];

                

                    if($user_purchase_list['pgds']['package_purchased'] && $user_purchase_list['pgds']['package_purchased'] == 1 && ($user_purchase_list['pgds']['package_expired'] != '1') ){



                        //This methods verify if any of the Oral PGD is expired within the Package if yes.. need to show the option to renew

                        $any_oral_pgd_expired = verify_any_oral_package_pgd_expired($user_purchase_list);

                        $any_oral_pgd_expiring = verify_any_oral_package_pgd_expiring($user_purchase_list);

                        

                        if($any_oral_pgd_expiring == 1){

                            

                            $order_temp_details = get_order_temp_details($user_id, '', 'O', '1');

                            

                            if(count($order_temp_details) > 0 ){

                                $arr_data .= '<button class="btn btn-xs btn-warning"  type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'\', \'ORAL\', \'unassign\', \'Standard Oral PGD Package\',\''.$user_full_name.'\')" > O </button>';        

                            }else{

                                $arr_data .= '<button class="btn btn-xs btn-primary"  type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'\', \'ORAL\', \'assign\', \'Standard Oral PGD Package\',\''.$user_full_name.'\')" > O </button>';      

                            }//end if($order_temp_details)

                            

                        }elseif($any_oral_pgd_expired == 1){

                            

                            $arr_data .= '<button class="btn btn-xs btn-warning"  type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'\', \'ORAL\', \'assign\', \'Standard Oral PGD Package\',\''.$user_full_name.'\')" > O </button>'; 

                            

                        }else{

                            

                            $arr_data .= '<button class="btn btn-xs btn-success" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'\', \'ORAL\', \'unassign\', \'Standard Oral PGD Package\',\''.$user_full_name.'\')" > O </button>';    

                            

                        }//end if($any_oral_pgd_expired == 1)

                        

                    } else {

                    

                        $arr_data .= '<button class="btn btn-xs btn-danger"  type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'\', \'ORAL\', \'assign\', \'Standard Oral PGD Package\',\''.$user_full_name.'\')" > O </button>';  

                    

                    }//end if($row[$key]['purchases']['pgds']['package_purchased'] && $row[$key]['purchases']['pgds']['package_purchased'] == 1)

                    

                    if($user_purchase_list['pgds']['premium_package_purchased'] && $user_purchase_list['pgds']['premium_package_purchased'] == 1 && ($user_purchase_list['pgds']['premium_package_expired'] != '1')){

                        

                            //This methods verify if any of the Oral PGD is expired within the Package if yes.. need to show the option to renew

                            $any_prem_pgd_expired = verify_any_premium_package_pgd_expired($user_purchase_list);

                            $any_prem_pgd_expiring = verify_any_premium_package_pgd_expiring($user_purchase_list);

                            

                            if($any_prem_pgd_expiring == 1){

                                

                                $order_temp_details = get_order_temp_details($user_id, '', 'OP', '1');

                                

                                if(count($order_temp_details) > 0 ){

                                    $arr_data .= '<button class="btn btn-xs btn-warning"  type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'\', \'P_ORAL\', \'unassign\', \'Premium Oral PGD Package\',\''.$user_full_name.'\')" > O+ </button>';      

                                }else{

                                    $arr_data .= '<button class="btn btn-xs btn-primary"  type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'\', \'P_ORAL\', \'assign\', \'Premium Oral PGD Package\',\''.$user_full_name.'\')" > O+ </button>';        

                                }//end if($order_temp_details)

                                

                            }elseif($any_prem_pgd_expired == 1){

                                

                                $arr_data .= '<button class="btn btn-xs btn-warning" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'\', \'P_ORAL\', \'assign\', \'Premium Oral PGD Package\',\''.$user_full_name.'\')" > O+ </button>';                                

                                

                            }else{

                                

                                $arr_data .= '<button class="btn btn-xs btn-success" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'\', \'P_ORAL\', \'unassign\', \'Premium Oral PGD Package\',\''.$user_full_name.'\')" > O+ </button>';                              

                                

                            }//end if($any_prem_pgd_expired == 1)

                            

                        } else {

                        

                        $arr_data .= '<button class="btn btn-xs btn-danger" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'\', \'P_ORAL\', \'assign\', \'Premium Oral PGD Package\',\''.$user_full_name.'\')" > O+ </button>'; 



                    }//end if($row[$key]['purchases']['pgds']['premium_package_purchased'] && $row[$key]['purchases']['pgds']['premium_package_purchased'] == 1)

                    

                    if($pT && $pT == 1){

                        

                        if($pT_is_expiring == '1'){

                            

                            $order_temp_details = get_order_temp_details($user_id, '10', '', '0');

                            

                            if(count($order_temp_details) > 0){

                                $arr_data .= '<button class="btn btn-xs btn-warning" type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'10\', \'PGD\', \'unassign\', \'Travel Core 3.0\',\''.$user_full_name.'\')" > T19 </button>';

                            }else{

                                $arr_data .= '<button class="btn btn-xs btn-primary" type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'10\', \'PGD\', \'assign\', \'Travel Core 3.0\',\''.$user_full_name.'\')" > T19 </button>';  

                            }//end if(count($order_temp_details) > 0)

                            

                        }else{

                            

                            $arr_data .= '<button class="btn btn-xs btn-success" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'10\', \'PGD\', \'unassign\', \'Travel Core 3.0\',\''.$user_full_name.'\')" > T19 </button>';

                            

                        }//end if($pT_is_expiring == '1')

                        

                    } else {

                        $arr_data .= '<button class="btn btn-xs btn-danger"  type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'10\', \'PGD\', \'assign\', \'Travel Core 3.0\',\''.$user_full_name.'\')" > T19 </button>'; 

                        

                    }//end if($pT && $pT == 1)



                    if($pT18 && $pT18 == 1){

                        

                        if($pT18_is_expiring == '1'){

                            

                            $order_temp_details = get_order_temp_details($user_id, '31', '', '0');

                            

                            if(count($order_temp_details) > 0){

                                

                                $arr_data .= '<button class="btn btn-xs btn-warning" type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'31\', \'PGD\', \'unassign\', \'Travel Core 4.0\',\''.$user_full_name.'\')" > T20 </button>';

                                

                            }else{

                                

                                $arr_data .= '<button class="btn btn-xs btn-primary" type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'31\', \'PGD\', \'assign\', \'Travel Core 4.0\',\''.$user_full_name.'\')" > T20 </button>';  

                                

                            }//end if(count($order_temp_details) > 0)

                            

                        }else{

                            

                            $arr_data .= '<button class="btn btn-xs btn-success" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'31\', \'PGD\', \'unassign\', \'Travel Core 4.0\',\''.$user_full_name.'\')" > T20 </button>';   

                            

                        }//end if($pT18_is_expiring == '1')

                        

                    } else {

                        $arr_data .= '<button class="btn btn-xs btn-danger"  type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'31\', \'PGD\', \'assign\', \'Travel Core 4.0\',\''.$user_full_name.'\')" > T20 </button>'; 

                        

                    }//end if($pT18 && $pT18 == 1)

                

                    if($F16 && $F16 == 1){

                        

                        if($F16_is_expiring == '1'){

                            

                            $order_temp_details = get_order_temp_details($user_id, '15', '', '0');

                            

                            if(count($order_temp_details) > 0){

                                

                                $arr_data .= '<button class="btn btn-xs btn-warning" type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'15\', \'PGD\', \'unassign\', \'Seasonal 2019\',\''.$user_full_name.'\')" > F19 </button>';

                                

                            }else{

                                

                                $arr_data .= '<button class="btn btn-xs btn-primary" type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'15\', \'PGD\', \'assign\', \'Seasonal 2019\',\''.$user_full_name.'\')" > F19 </button>';    

                                

                            }//end if(count($order_temp_details) > 0)

                            

                        }else{

                            $arr_data .= '<button class="btn btn-xs btn-success" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'15\', \'PGD\', \'unassign\', \'Seasonal 2019\',\''.$user_full_name.'\')" > F19 </button>';     

                            

                        }//end if($F16_is_expiring == '1')

                     

                    } else {

                     

                        $arr_data .= '<button class="btn btn-xs btn-danger" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'15\', \'PGD\', \'assign\', \'Seasonal 2019\',\''.$user_full_name.'\')" > F19 </button>';    

                     

                    }//end if($F16 && $F16 == 1)

                    

                    if($F18 && $F18 == 1){

                        

                        if($F18_is_expiring == '1'){

                            

                            $order_temp_details = get_order_temp_details($user_id, '28', '', '0');

                            

                            if(count($order_temp_details) > 0){

                                

                                $arr_data .= '<button class="btn btn-xs btn-warning" type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'28\', \'PGD\', \'unassign\', \'Seasonal 2020\',\''.$user_full_name.'\')" > F20 </button>';

                                

                            }else{

                                

                                $arr_data .= '<button class="btn btn-xs btn-primary" type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'28\', \'PGD\', \'assign\', \'Seasonal 2020\',\''.$user_full_name.'\')" > F20 </button>';    

                                

                            }//end if(count($order_temp_details) > 0)

                            

                        }else{

                            

                            $arr_data .= '<button class="btn btn-xs btn-success" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'28\', \'PGD\', \'unassign\', \'Seasonal 2020\',\''.$user_full_name.'\')" > F20 </button>';     

                            

                        }//end if($F18_is_expiring == '1') 

                     

                    } else {

                     

                        $arr_data .= '<button class="btn btn-xs btn-danger" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'28\', \'PGD\', \'assign\', \'Seasonal 2020\',\''.$user_full_name.'\')" > F20 </button>';    

                     

                    }//end if($F18 && $F18 == 1)



                    //////////// PGD32-START ///////////



                      if($H32 && $H32 == 1){ 

                        

                        if($H32_is_expiring == '1'){

                          

                          $order_temp_details = get_order_temp_details($user_id, '32', '', '0');

                          

                          if(count($order_temp_details) > 0){

                            

                            $arr_data .= '<button class="btn btn-xs btn-warning" type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'32\', \'PGD\', \'unassign\', \'Travel Clinic Bolt On - HPV+\',\''.$user_full_name.'\')" > H </button>';

                            

                          }else{

                            

                            $arr_data .= '<button class="btn btn-xs btn-primary" type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'32\', \'PGD\', \'assign\', \'Travel Clinic Bolt On - HPV+\',\''.$user_full_name.'\')" > H </button>';  

                            

                          }//end if(count($order_temp_details) > 0)

                          

                        }else{

                          

                          $arr_data .= '<button class="btn btn-xs btn-success" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'32\', \'PGD\', \'unassign\', \'Travel Clinic Bolt On - HPV+\',\''.$user_full_name.'\')" > H </button>';   

                          

                        }//end if($H32_is_expiring == '1') 

                       

                      } else {

                       

                        $arr_data .= '<button class="btn btn-xs btn-danger" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'32\', \'PGD\', \'assign\', \'Travel Clinic Bolt On - HPV+\',\''.$user_full_name.'\')" > H </button>';  

                       

                      }//end if($H32 && $H32 == 1)



                      //////////// PGD32-END ///////////

                    //////////// PGD33-START ///////////

                      if($H33 && $H33 == 1){ 
                        
                        if($H33_is_expiring == '1'){
                          
                          $order_temp_details = get_order_temp_details($user_id, '33', '', '0');
                          
                          if(count($order_temp_details) > 0){
                            
                            $arr_data .= '<button class="btn btn-xs btn-warning" type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'33\', \'PGD\', \'unassign\', \'Urinary Tract Infection\',\''.$user_full_name.'\')" > U </button>';
                            
                          }else{
                            
                            $arr_data .= '<button class="btn btn-xs btn-primary" type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'33\', \'PGD\', \'assign\', \'Urinary Tract Infection\',\''.$user_full_name.'\')" > U </button>';  
                            
                          }//end if(count($order_temp_details) > 0)
                          
                        }else{
                          
                          $arr_data .= '<button class="btn btn-xs btn-success" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'33\', \'PGD\', \'unassign\', \'Urinary Tract Infection\',\''.$user_full_name.'\')" > U </button>';   
                          
                        }//end if($H33_is_expiring == '1') 
                       
                      } else {
                       
                        $arr_data .= '<button class="btn btn-xs btn-danger" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'33\', \'PGD\', \'assign\', \'Urinary Tract Infection\',\''.$user_full_name.'\')" > U </button>';  
                       
                      }//end if($H33 && $H33 == 1)

                      //////////// PGD33-END ///////////

                      //////////// PGD34-START ///////////

                      if($H34 && $H34 == 1){ 
                        
                        if($H34_is_expiring == '1'){
                          
                          $order_temp_details = get_order_temp_details($user_id, '34', '', '0');
                          
                          if(count($order_temp_details) > 0){
                            
                            $arr_data .= '<button class="btn btn-xs btn-warning" type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'34\', \'PGD\', \'unassign\', \'Dermatitis\',\''.$user_full_name.'\')" > B </button>';
                            
                          }else{
                            
                            $arr_data .= '<button class="btn btn-xs btn-primary" type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'34\', \'PGD\', \'assign\', \'Dermatitis\',\''.$user_full_name.'\')" > B </button>';  
                            
                          }//end if(count($order_temp_details) > 0)
                          
                        }else{
                          
                          $arr_data .= '<button class="btn btn-xs btn-success" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'34\', \'PGD\', \'unassign\', \'Dermatitis\',\''.$user_full_name.'\')" > B </button>';   
                          
                        }//end if($H34_is_expiring == '1') 
                       
                      } else {
                       
                        $arr_data .= '<button class="btn btn-xs btn-danger" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'34\', \'PGD\', \'assign\', \'Dermatitis\',\''.$user_full_name.'\')" > B </button>';  
                       
                      }//end if($H34 && $H34 == 1)

                      //////////// PGD34-END ///////////

                    if($tH && $tH == 1){

                        

                        if($tH_is_expiring == '1'){

                            

                            $order_temp_details = get_order_temp_details($user_id, '29', '', '0');

                            

                            if(count($order_temp_details) > 0){

                                

                                $arr_data .= '<button class="btn btn-xs btn-warning" type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'29\', \'PGD\', \'unassign\', \'Sore Throat\',\''.$user_full_name.'\')" > ST </button>';

                                

                            }else{

                                

                                $arr_data .= '<button class="btn btn-xs btn-primary" type="button" onClick="renew_pgd_admin(\''.$user_id.'\', \'29\', \'PGD\', \'assign\', \'Sore Throat\',\''.$user_full_name.'\')" > ST </button>';   

                                

                            }//end if(count($order_temp_details) > 0)

                            

                        }else{

                            

                        $arr_data .= '<button class="btn btn-xs btn-success" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'29\', \'PGD\', \'unassign\', \'Sore Throat\',\''.$user_full_name.'\')" > ST </button>';        

                        

                        }//end if($tH_is_expiring == '1')

                     

                    } else {

                     

                        $arr_data .= '<button class="btn btn-xs btn-danger" type="button" onClick="assign_pgd_admin(\''.$user_id.'\', \'29\', \'PGD\', \'assign\', \'Sore Throat\',\''.$user_full_name.'\')" > ST </button>';   

                     

                    }//end if($tH && $tH == 1)

                     

                     /*if($aT && $aT == 1){

                         

                        $arr_data .= '<button class="btn btn-xs btn-success" onClick="assign_pgd_admin('.$row['id'].', "11", "PGD", "unassign","Adult Travel Core PGD",'.$user_full_name.')" > aT </button>';

                         

                     } else {

                         

                        $arr_data .= '<button class="btn btn-xs btn-danger" onClick="assign_pgd_admin('.$row['id'].', "11", "PGD", "assign","Adult Travel Core PGD",'.$user_full_name.');" > aT </button>';

                     }

                     

                     

                     if($F15 && $F15 == 1){

                         

                         $arr_data .= '<button class="btn btn-xs btn-success" onClick="assign_pgd_admin('.$row['id'].', "16", "PGD", "unassign","Seasonal PGD  2015",'.$user_full_name.')" > F20 </button>';

                         

                     } else {

                         

                        $arr_data .= '<button class="btn btn-xs btn-danger" onClick="assign_pgd_admin('.$row['id'].', "16", "PGD", "assign","Seasonal PGD  2015",'.$user_full_name.');" > F15 </button>';

                     }*/

                     

                    } // end if($row['is_prescriber'] == 0){

                        

                    $arr_data .='<a href="'.SURL.'avicenna/view-trainings/'.$aRow['user_type_id'].'/'.$aRow['id'].'" class="inline btn btn-xs btn-block btn-warning pull-right trainings-admin fancybox.ajax"> Training </a>';                      

                    

                    

                    $row[] = $arr_data;

                    

                    

                }elseif($col == 'users.id'){

                    

                    $row[] = ' <a class="btn btn-success btn-xs pull-right users_pgd_list_view fancybox.ajax" href="'.SURL.'avicenna/view-avicenna-user-pgds/'.$aRow['id'].'"><span class="glyphicon glyphicon-list"></span></a> <a class="btn btn-info btn-xs pull-right"   href="'.SURL.'avicenna/add-edit-avicenna-user/'.$aRow['id'].'"><span class="glyphicon glyphicon-edit"></span></a>  ';

                }

                

            }//end of inner columns loop

            

            $output['aaData'][] = $row;

            

        }

        

        header('Content-type: application/json');

        echo json_encode($output);

        

    } // End - get_all_avicenna_ajax_call()



     //Function is_product_expired(): Will return tthe array if the product is NOT EXPIRED

     public function is_product_expired($product_id, $product_type, $user_id = '', $pharmacy_surgery_id = '', $organziation_id = ''){

    

      $this->db->dbprefix('user_order_details');

      $this->db->select('user_order_details.*, users.first_name,users.last_name,');

      $this->db->from('user_order_details');

      $this->db->join('users', 'users.id = user_order_details.user_id', 'inner');

      /*if(trim($user_id) != '')  $this->db->where('user_id',$user_id);*/

      if(trim($pharmacy_surgery_id) != '')  $this->db->where('pharmacy_surgery_id',$pharmacy_surgery_id);

      if(trim($organziation_id) != '')  $this->db->where('organziation_id',$organziation_id);

      

      $this->db->where('product_type',$product_type);

      $this->db->where('product_id',$product_id);

      $this->db->where('users.buying_group_id',"1");

      $this->db->where("(expiry_date > '".date('Y-m-d')."' OR expiry_date = '0000-00-00')"); //Is not Expired

      $get = $this->db->get('user_order_details');

    

      //echo $this->db->last_query();

      

      return $get->result_array();

      

     }//end is_product_expired($product_id, $product_type, $user_id = '', $pharmacy_surgery_id = '', $organziation_id = '')

     

     // count all pgds where buying group = 2 and  id 10,11,15,16 count_all_pgds_buying_group_id_2 

    public function count_all_pgds_buying_group_id_2($product_id){

        

        $this->db->dbprefix('user_order_details,users');

        $this->db->select('COUNT(product_id) as total');

        $this->db->from('user_order_details');

        $this->db->join('users', 'users.id = user_order_details.user_id', 'inner');

        $this->db->where('user_order_details.product_id ',$product_id);

        $this->db->where('user_order_details.product_type ',"PGD");

        $this->db->where('users.buying_group_id',"1");

        $this->db->where("(expiry_date > '".date('Y-m-d')."' OR expiry_date = '0000-00-00')"); //Is not Expired

        

        $query = $this->db->get();

        $row = $query->row_array();

        return $row['total'];

        

    } // End - count_all_pgds_buying_group_id_2():

    

    // Start - get_all_active_trainings(): Get all active trainings for listing

    public function get_all_active_trainings(){

        

        $this->db->dbprefix('package_training');

        $this->db->select('package_training.*');

        $this->db->from('package_training');

        $this->db->where('package_training.is_admin_deleted !=', 1);

        $this->db->order_by('package_training.id', 'DESC');

        

        return $this->db->get()->result_array();

        

    } // End - get_all_active_trainings():

    

    // count - count_all_active_pgds(): Get all active pgds for listing

    public function count_all_active_pgds(){

        

        $this->db->dbprefix('user_order_details,users');

        $this->db->select('COUNT(product_id) as total');

        $this->db->from('user_order_details');

        $this->db->join('users', 'users.id = user_order_details.user_id', 'inner');

        $this->db->where('user_order_details.product_type ',"PGD");

        $this->db->where('users.buying_group_id',"1");

        $this->db->where("(expiry_date > '".date('Y-m-d')."' OR expiry_date = '0000-00-00')"); //Is not Expired

        

        $query = $this->db->get();

        $row = $query->row_array();

        return $row['total'];

        

        

    } // End - count_all_active_pgds():

    

     //Function download_csv_file(): 

     public function download_csv_file($product_id, $product_type){

         

      $this->load->dbutil();

    

       $qry_user_data = $this->db->query("SELECT kod_users.first_name AS FIRST_NAME,kod_users.last_name AS LAST_NAME, kod_users.email_address AS EMAIL, kod_users.mobile_no AS CONTACT, kod_package_pgds.pgd_name AS PGD_NAME, kod_usertype.user_type AS USER_TYPE, kod_package_pgds.id AS pid, kod_user_order_details.expiry_date AS EXPIRY_DATE, kod_user_order_details.is_quiz_passed AS QUIZ_PASSED FROM `kod_user_order_details` INNER JOIN `kod_users` ON `kod_users`.`id` = `kod_user_order_details`.`user_id` INNER JOIN `kod_usertype` ON `kod_users`.`user_type` = `kod_usertype`.`id` INNER JOIN `kod_package_pgds` ON `kod_package_pgds`.`id` = `kod_user_order_details`.`product_id` WHERE `product_type` = '".$product_type."' AND `product_id` = '".$product_id."' AND `kod_users`.`buying_group_id` = '1' AND (`expiry_date` >  '".date('Y-m-d')."' OR `expiry_date` = '0000-00-00') GROUP BY `kod_user_order_details`.`id`");

     

      

      for($i=0; $i<count($count_all_record); $i++){

          

        $final_arr[$i]['first_name']= $count_all_record[$i]['first_name'];

        $final_arr[$i]['last_name']= $count_all_record[$i]['last_name'];

        $final_arr[$i]['pgd_name']= $count_all_record[$i]['pgd_name'];

        $final_arr[$i]['user_type']= $count_all_record[$i]['user_type'];

        $final_arr[$i]['expiry_date']= $count_all_record[$i]['expiry_date'];

        

      }//end for($i=0; $i<count($count_all_record); $i++)

      

      

        $delimiter = ",";

        $newline = "\r\n";

        

        $download_csv = $this->dbutil->csv_from_result($qry_user_data, $delimiter, $newline);

        

        

        return $download_csv;

      

    }//end  download_csv_file($product_id, $product_type)')

    

     //Function download_csv_file_all_pgds(): 

     public function download_csv_file_all_pgds($product_type){

         

       $this->load->dbutil();

      

       $qry_user_data = $this->db->query("SELECT kod_users.first_name AS FIRST_NAME,kod_users.last_name AS LAST_NAME, kod_users.email_address AS EMAIL, kod_users.mobile_no AS CONTACT, kod_package_pgds.pgd_name AS PGD_NAME, kod_package_pgds.id AS pid, kod_usertype.user_type AS USER_TYPE, kod_user_order_details.expiry_date AS EXPIRY_DATE, kod_user_order_details.is_quiz_passed AS QUIZ_PASSED FROM `kod_user_order_details` INNER JOIN `kod_users` ON `kod_users`.`id` = `kod_user_order_details`.`user_id` INNER JOIN `kod_usertype` ON `kod_users`.`user_type` = `kod_usertype`.`id` INNER JOIN `kod_package_pgds` ON `kod_package_pgds`.`id` = `kod_user_order_details`.`product_id` WHERE `product_type` = '".$product_type."' AND `kod_users`.`buying_group_id` = '1' AND (`expiry_date` >  '".date('Y-m-d')."' OR `expiry_date` = '0000-00-00') GROUP BY `kod_user_order_details`.`id`");

     

      

      for($i=0; $i<count($count_all_record); $i++){

          

        $final_arr[$i]['first_name']= $count_all_record[$i]['first_name'];

        $final_arr[$i]['last_name']= $count_all_record[$i]['last_name'];

        $final_arr[$i]['pgd_name']= $count_all_record[$i]['pgd_name'];

        $final_arr[$i]['user_type']= $count_all_record[$i]['user_type'];

        $final_arr[$i]['expiry_date']= $count_all_record[$i]['expiry_date'];

        

      }//end for($i=0; $i<count($count_all_record); $i++)

      

      

        $delimiter = ",";

        $newline = "\r\n";

        

        $download_csv = $this->dbutil->csv_from_result($qry_user_data, $delimiter, $newline);

        

        

        return $download_csv;

      

    }//end  download_csv_file_all_pgds($product_type)')

    

    //Function download_csv_file_all_training(): 

     public function download_csv_file_training($product_id=''){

         

       $this->load->dbutil();

      

      if($product_id=="all"){

          

        $qry_user_data = $this->db->query("SELECT kod_users.first_name AS FIRST_NAME,kod_users.last_name AS LAST_NAME, kod_users.email_address AS EMAIL, kod_users.mobile_no AS CONTACT, kod_package_training.course_name AS TRAINING, kod_usertype.user_type AS USER_TYPE, kod_user_order_details.expiry_date AS EXPIRY_DATE, kod_user_order_details.is_quiz_passed AS QUIZ_PASSED FROM `kod_user_order_details` INNER JOIN `kod_users` ON `kod_users`.`id` = `kod_user_order_details`.`user_id` INNER JOIN `kod_usertype` ON `kod_users`.`user_type` = `kod_usertype`.`id` INNER JOIN `kod_package_training` ON `kod_package_training`.`id` = `kod_user_order_details`.`product_id` WHERE `product_type` = 'TRAINING' AND `kod_users`.`buying_group_id` = '1' AND (`expiry_date` >  '".date('Y-m-d')."' OR `expiry_date` = '0000-00-00') GROUP BY `kod_user_order_details`.`id`");

       

      } else {

         

        $qry_user_data = $this->db->query("SELECT kod_users.first_name AS FIRST_NAME,kod_users.last_name AS LAST_NAME, kod_users.email_address AS EMAIL, kod_users.mobile_no AS CONTACT, kod_package_training.course_name AS TRAINING,kod_usertype.user_type AS USER_TYPE, kod_user_order_details.expiry_date AS EXPIRY_DATE, kod_user_order_details.is_quiz_passed AS QUIZ_PASSED FROM `kod_user_order_details` INNER JOIN `kod_users` ON `kod_users`.`id` = `kod_user_order_details`.`user_id` INNER JOIN `kod_usertype` ON `kod_users`.`user_type` = `kod_usertype`.`id` INNER JOIN `kod_package_training` ON `kod_package_training`.`id` = `kod_user_order_details`.`product_id` WHERE `product_type` = 'TRAINING' AND `product_id` = '".$product_id."' AND `kod_users`.`buying_group_id` = '1' AND (`expiry_date` >  '".date('Y-m-d')."' OR `expiry_date` = '0000-00-00') GROUP BY `kod_user_order_details`.`id`");

          

      }

     

      

      for($i=0; $i<count($count_all_record); $i++){

          

        $final_arr[$i]['first_name']= $count_all_record[$i]['first_name'];

        $final_arr[$i]['last_name']= $count_all_record[$i]['last_name'];

        $final_arr[$i]['pgd_name']= $count_all_record[$i]['pgd_name'];

        $final_arr[$i]['user_type']= $count_all_record[$i]['user_type'];

        $final_arr[$i]['expiry_date']= $count_all_record[$i]['expiry_date'];

        

      }//end for($i=0; $i<count($count_all_record); $i++)

      

        $delimiter = ",";

        $newline = "\r\n";

        

        $download_csv = $this->dbutil->csv_from_result($qry_user_data, $delimiter, $newline);

        

        return $download_csv;

      

    }//end  download_csv_file_all_training($product_id, $product_type)')

    

    

    // get_all_avicenna_pgd_ajax_call

    public function get_all_avicenna_pgd_ajax_call($product_id=''){

        

        

        $aColumns = array('first_name','last_name','email_address', 'mobile_no');



        // DB table to use

        $sTable = 'user_order_details';

        $usertype = 'usertype';

        

        $iDisplayStart = $this->input->get_post('iDisplayStart', true);

        $iDisplayLength = $this->input->get_post('iDisplayLength', true);

        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);

        $iSortingCols = $this->input->get_post('iSortingCols', true);

        $sSearch = $this->input->get_post('sSearch', true);

        $sEcho = $this->input->get_post('sEcho', true);

    

        // Paging

        if(isset($iDisplayStart) && $iDisplayLength != '-1')

        {

            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));

        }

    

        // Ordering

        if(isset($iSortCol_0))

        {

            for($i=0; $i<intval($iSortingCols); $i++)

            {

                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);

                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);

                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

    

                if($bSortable == 'true')

                {

                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));

                }

            }

        }

                /*

        * Filtering

        * NOTE this does not match the built-in DataTables filtering which does it

        * word by word on any field. It's possible to do here, but concerned about efficiency

        * on very large tables, and MySQL's regex functionality is very limited

        */

        

        $more_fields_to_search = array('CONCAT(first_name, " ", last_name)', 'registration_no', 'registration_type', 'usertype.user_type');

        $search_fields = array_merge($aColumns, $more_fields_to_search);

        

        if(isset($sSearch) && !empty($sSearch))

        {

            for($i=0; $i<count($search_fields); $i++)

            {

                $bSearchable = $this->input->get_post('bSearchable_'.$i, true);

                

                // Individual column filtering

                //if(isset($bSearchable) && $bSearchable == 'true')

                //{

                    $this->db->or_like($search_fields[$i], $sSearch);

                //}

            }

        }

        

            /* author : mzm

        * INDIVIDUAL COLUMN FILTERING 



        * Check if individual filtering is enabled

        */

        

        for($i=0; $i<count($search_fields); $i++)

        {

            if($this->input->get_post('sSearch_6', true) == ''){

                $sSearch = $this->input->get_post('sSearch_'.$i, true);

                

                // Individual column filtering

                if(isset($sSearch) && !empty($sSearch) && $sSearch)

                {

                    $this->db->or_like($search_fields[$i], $sSearch);

                }

            }

        }

        

        $select = array('first_name', 'last_name', 'mobile_no', 'email_address', 'package_pgds.pgd_name', 'package_pgds.id as pid','user_order_details.expiry_date','user_order_details.is_quiz_passed');



        // Select Data

        $this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $select)), false);

        $this->db->dbprefix($sTable);

    

        $this->db->where('users.buying_group_id', '1');

        $this->db->where('user_order_details.product_type ',"PGD");

        if(trim($product_id) !='') $this->db->where('user_order_details.product_id ',$product_id);

        $this->db->where("(kod_user_order_details.expiry_date > '".date('Y-m-d')."' OR kod_user_order_details.expiry_date = '0000-00-00')"); //Is not Expired

        $this->db->group_by('kod_user_order_details.id');

        $this->db->join('users', 'users.id = user_order_details.user_id','INNER');

        $this->db->join('usertype', 'usertype.id = users.user_type','INNER');

        $this->db->join('package_pgds', 'package_pgds.id = user_order_details.product_id','INNER');

        

         

        //$this->db->where('registration_type','GMC');

        //get data : QUERY 1 to get filtered data

        

        $this->db->order_by('user_order_details.id', "DESC");

        

        $rResult = $this->db->get($sTable);

        

        //mzm total get the current total from the recent query with all filters

        // Data set length after filtering

        

        $this->db->dbprefix($sTable);

        $this->db->select('FOUND_ROWS() AS found_rows');

        

        $iFilteredTotal = $this->db->get()->row()->found_rows;

        $this->db->join('users', 'users.id = user_order_details.user_id','INNER');

        $this->db->join('usertype', 'usertype.id = users.user_type','INNER');

        $this->db->join('package_pgds', 'package_pgds.id = user_order_details.product_id','INNER');

        

        // Total data set length. QUERY 2 to get overall total without any filters

        //add join referernce here too if required. For total no filters

        //$this->db->join('stores','products.store_id = stores.store_id','INNER');

        

        $iTotal = $this->db->count_all_results($sTable);

        

        // Output

        $output = array(

            'sEcho' => intval($sEcho),

            'iTotalRecords' => $iTotal,

            'iTotalDisplayRecords' => $iFilteredTotal,

            'aaData' => array()

        );

        

        $data_db = $rResult->result_array();

        

        //echo $this->db->last_query();exit;

        

        //print_this($data_db); exit;

        

        foreach( $data_db as $aRow){

            

            $row = array();

            $option_html = '';

            

            // Call Js Login action

            //$login_action = 'user_login_function(\''.$aRow['email_address'].'\',\''.$aRow['id'].'\',\''.$aRow['password'].'\')';          

            //$row[] = "<div class='btn-group'><input type='checkbox' name='admin_verify_status[]' value='".$aRow['id']."' class='inline pull-left' /> &nbsp; &nbsp; <a href='#login' onclick=$login_action type='button' title='Click here to login this user.' class='pull-right btn btn-default btn-xs'><i class='fa fa-external-link'></i></a><div>";

            

            foreach($select as $col)

            {



                if($col == 'first_name'){

                    $row[] = $aRow['first_name'];

                }elseif($col == 'last_name'){

                    $row[] = $aRow['last_name'];

                }elseif($col == 'email_address'){

                    $row[] = $aRow['email_address'];

                }elseif($col == 'mobile_no'){

                    $row[] = $aRow['mobile_no'];

                }elseif($col == 'package_pgds.pgd_name'){

                    if($aRow['pid'] =='12') { $row[] = 'Premium Oral PGD Package (O+)'; } else if($aRow['pid'] =='19'){  $row[] = 'Standard Oral PGD Package (O-)';} else {  $row[] = filter_string($aRow['pgd_name']);}

                    

                }elseif($col == 'user_order_details.expiry_date'){

                                            

                    $row[] = $aRow['expiry_date'];

                        

                }elseif($col == 'user_order_details.is_quiz_passed'){

                    

                    if($aRow['is_quiz_passed'] =='0'){ $row[]= 'Failed'; } else { $row[] = 'Passed';}

                }

                

            }//end of inner columns loop

            

            

        

            $output['aaData'][] = $row;

            

        }

        

        header('Content-type: application/json');

        echo json_encode($output);

        

    } // End - get_all_avicenna_pgd_ajax_call()

    

     //Function list_avicena_pgds(): 

     public function list_avicena_pgds($product_type='',$product_id=''){

         

        $this->db->dbprefix('users');

        $this->db->select('users.first_name,users.last_name,users.email_address,users.mobile_no,package_pgds.pgd_name,package_pgds.id as pid, usertype.user_type As utype,user_order_details.expiry_date,user_order_details.is_quiz_passed');

        $this->db->from('user_order_details');

        $this->db->join('users', 'users.id = user_order_details.user_id', 'inner');

        $this->db->join('usertype', 'usertype.id = users.user_type', 'inner');

        $this->db->join('package_pgds', 'package_pgds.id = user_order_details.product_id', 'inner');

        if(trim($product_id) !='') $this->db->where('user_order_details.product_id ',$product_id);

        $this->db->where('user_order_details.product_type ',"PGD");

        $this->db->where('users.buying_group_id',"1");

        $this->db->where("(expiry_date > '".date('Y-m-d')."' OR expiry_date = '0000-00-00')"); //Is not Expired

        $this->db->group_by('kod_user_order_details.id');

        return $this->db->get()->result_array();

        

        //echo $this->db->last_query();exit;

      

    }//end  list_avicena_pgds($product_id, $product_type)')



    

     //Function list_avicena_trainging(): 

     public function list_avicena_trainging($product_id=''){

         

        $this->db->dbprefix('users');

        $this->db->select('users.first_name,users.last_name,users.email_address,users.mobile_no,package_training.course_name,usertype.user_type As utype,user_order_details.expiry_date,user_order_details.is_quiz_passed');

        $this->db->from('user_order_details');

        $this->db->join('users', 'users.id = user_order_details.user_id', 'inner');

        $this->db->join('usertype', 'usertype.id = users.user_type', 'inner');

        $this->db->join('package_training', 'package_training.id = user_order_details.product_id', 'inner');

        if(trim($product_id) !='' && $product_id !='all') $this->db->where('user_order_details.product_id ',$product_id);

        $this->db->where('user_order_details.product_type ',"TRAINING");

        $this->db->where('users.buying_group_id',"1");

        $this->db->where("(expiry_date > '".date('Y-m-d')."' OR expiry_date = '0000-00-00')"); //Is not Expired

        $this->db->group_by('kod_user_order_details.id');

        return $this->db->get()->result_array();

        

        //echo $this->db->last_query();exit;

      

    }//end  list_avicena_trainging($product_id)')

    

    //Function add_edit_avicenna_user(): Add new user into the database

    public function add_edit_avicenna_user($data){

        

        extract($data);

        

        //print_this($data); exit;

        $created_date = date('Y-m-d G:i:s');

        $created_by_ip = $this->input->ip_address();

        

        //Generate Random code  

         $email_activation_code = $this->common->random_number_generator(10);

         

         if($user_type == 1){

             

            $registration_type = 'GMC';

         

         }elseif($user_type == 2 || $user_type == 6 ){

             

            $registration_type = 'GPhC';

             

         }elseif($user_type == 3){

             

            $registration_type = 'NMC';

             

         }//end if($user_type == 1)

         

    

        if($user_id==''){

            

            $is_owner = ($is_owner) ? $is_owner : '0';

        

            //Record insert into database

            $ins_data = array(

            

                'user_type' => $this->db->escape_str(trim($user_type)),

                'first_name' => $this->db->escape_str(trim($first_name)),

                'last_name' => $this->db->escape_str(trim($last_name)),

                'mobile_no' => $this->db->escape_str(trim($mobile_no)),

                'email_address' => $this->db->escape_str(trim($email_address)),

                'registration_no' => $this->db->escape_str(trim($registration_no)),

                'registration_type' => $this->db->escape_str(trim($registration_type)),

                'user_country' => $this->db->escape_str(trim($user_country)),

                'password' => $this->db->escape_str(trim(md5($password))),

                'is_locum' => $this->db->escape_str(trim($is_locum)),

                'is_prescriber' => $this->db->escape_str(trim($is_prescriber)),

                'is_owner' => $this->db->escape_str(trim($is_owner)),

                'email_verify_status' => $this->db->escape_str(1),

                'admin_verify_status' => $this->db->escape_str(1),

                'activation_code' => $this->db->escape_str(trim(md5($email_activation_code))),

                'buying_group_id' => $this->db->escape_str(trim($org_buying_group)),

                'created_date' => $this->db->escape_str(trim($created_date)),

                'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),

            );

    

        

        

            //If is_pres == 1, take the speciality field, otherwise leave it blank

            $ins_data['speciality'] = ($is_prescriber == 1) ? $this->db->escape_str(trim($speciality)) : '';

            

            //If usertype = 1 (doctor) he will always be a prescriber

            $ins_data['is_prescriber'] = ($user_type == 1) ? $this->db->escape_str(trim(1)) : $this->db->escape_str(trim($is_prescriber));

            

            //Inserting User data into the database. 

            $this->db->dbprefix('users');

            $ins_into_db = $this->db->insert('users', $ins_data);

            

            $new_user_id = $this->db->insert_id();

            

            //If Locum Selected as 1, enter the locum cities into the database.

            if($is_locum == 1){

                

                for($i=0;$i<count($location_arr);$i++){

    

                    $ins_data = array(

                    

                        'user_id' => $this->db->escape_str(trim($new_user_id)),

                        'city_id' => $this->db->escape_str(trim($location_arr[$i])),

                        'created_date' => $this->db->escape_str(trim($created_date)),

                        'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),

                    );

                    

                    //Inserting Locum cities into the database. 

                    $this->db->dbprefix('locum_cities');

                    $ins_into_db = $this->db->insert('locum_cities', $ins_data);

                    

                }//end for($i=0;$i<count($location_arr);$i++)

                

            }//end if($is_locum == 1)

        

        

            //IF The User is also registring the Organization.

            if($is_owner == 1){

    

                //Record insert into organization database

                

                // Organization Post code remove spance

                $org_postcode = str_replace(' ', '', $org_postcode);

                

                $ins_data = array(

                

                    'owner_id' => $this->db->escape_str(trim($new_user_id)),

                    'company_name' => $this->db->escape_str(trim($company_name)),

                    'address' => $this->db->escape_str(trim($org_address)),

                    'contact_no' => $this->db->escape_str(trim($org_contact)),

                    'postcode' => $this->db->escape_str(trim($org_postcode)),

                    'country_id' => $this->db->escape_str(trim($org_country)),

                    // 'buying_group_id' => $this->db->escape_str(trim($org_buying_group)),

                    'status' => $this->db->escape_str(trim(1)),

                    'created_date' => $this->db->escape_str(trim($created_date)),

                    'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),

                );

                

                //Inserting User data into the database. 

                $this->db->dbprefix('organization');

                $this->db->insert('organization', $ins_data);

            

                $organization_id = $this->db->insert_id();

                

                //Inserting Global Settings record into the Organization Global Setting Table

                $ins_data = array(

                

                    'organization_id' => $this->db->escape_str(trim($organization_id)),

                    'governance_status' => $this->db->escape_str('1'),

                    'online_doctor_status' => $this->db->escape_str('1'),

                    'survey_status' => $this->db->escape_str('1'),

                    'pmr_status' => $this->db->escape_str('1'),

                    'todolist_status' => $this->db->escape_str('1'),

                    'ipos_status' => $this->db->escape_str('1'),

                    'created_date' => $this->db->escape_str(trim($created_date)),

                    'created_by_ip' => $this->db->escape_str(trim($created_by_ip)),

                );

                

                //Inserting User data into the database. 

                $this->db->dbprefix('org_global_settings');

                $this->db->insert('org_global_settings', $ins_data);

                

                // Make a copy of Governance and SOPs, Get Governance

                $this->db->dbprefix('package_governance');

                $this->db->where('id', 1);

                $governance = $this->db->get('package_governance')->row_array();

                

                // Ready Organization Governance data and insert into db ( Table - org_governance )

                $insert_governance = array('organization_id' => $organization_id, 'governance_text' => $governance['governance_text'], 'sop_text' => $governance['sop_text'], 'finish_text' => $governance['finish_text']);

                

                $this->db->dbprefix('org_governance');

                $ins_into_db = $this->db->insert('org_governance', $insert_governance);

                

                //Get SOPs Categories and Make a COPY into the Organization SOP Table.

    

                // Get SOPs

                $this->db->dbprefix('sop_categories');

                $sop_categories = $this->db->get('sop_categories')->result_array();

                

                // Ready Organization SOP Categories data and insert into db ( Table - org_sop_categories )

                if(!empty($sop_categories)){

                    

                    foreach($sop_categories as $each){

                        

                        $insert_sop_categories = array('organization_id' => $organization_id, 

                                                    'category_name' => $each['category_name'], 

                                                    'status' => 1, 

                                                    'created_date' => date('Y-m-d H:i:s'), 

                                                    'created_ip' => $this->input->ip_address()

                                                );

                        

                        $this->db->dbprefix('org_sop_categories');

                        $ins_into_db = $this->db->insert('org_sop_categories', $insert_sop_categories);

                        

                        $new_category_insert_id = $this->db->insert_id();

                        

                        //Getting LIst of default SOP's added by system and sending the copy to the Organization SOP

                        $get_sops_list = $this->governance->get_sops_list('',$each['id']);

                        

                        for($i=0;$i<count($get_sops_list);$i++){

                            

                            $insert_sop = array('organization_id' => $organization_id, 

                                                'category_id' => $new_category_insert_id, 

                                                'user_types' => $get_sops_list[$i]['user_types'],

                                                'sop_title' => $get_sops_list[$i]['sop_title'], 

                                                'sop_description' => $get_sops_list[$i]['sop_description'], 

                                                'status' => 1, 

                                                'created_date' => date('Y-m-d H:i:s'), 

                                                'created_ip' => $this->input->ip_address()

                                            );

    

                            $this->db->dbprefix('org_sops');

                            $ins_into_db = $this->db->insert('org_sops', $insert_sop);

                            

                        }//end for($i=0$i<count($result_sop)$i++)

                        

                    }//end foreach($sop_categories as $each)

                    

                }//end if(!empty($sop_categories))

                

            }//end if($is_owner == 1)

        

        } else {

            

            //Record update into database

            $ups_data = array(

            

                'first_name' => $this->db->escape_str(trim($first_name)),

                'last_name' => $this->db->escape_str(trim($last_name)),

                'registration_no' => $this->db->escape_str(trim($registration_no)),

                'user_country' => $this->db->escape_str(trim($user_country)),

                'email_address' => $this->db->escape_str(trim($email_address)),

                'mobile_no' => $this->db->escape_str(trim($mobile_no)),

                'admin_verify_status' => $this->db->escape_str($admin_verify_status),

                'modified_date' => $this->db->escape_str(trim($created_date)),

                'modified_by_ip' => $this->db->escape_str(trim($created_by_ip)),

        );

        

            

            if(trim($password) != ''){

                $ups_data['password'] = $this->db->escape_str(trim(md5($password)));

            }

            

            //print_this($ups_data); exit;

            //Inserting User data into the database. 

            $this->db->dbprefix('users');

            $this->db->where('users.id', $user_id);

            $ins_into_db = $this->db->update('users', $ups_data);

            

        }       

        

        if($ins_into_db)

            return true;

        else

            return false;

        

    }//  end public function add_edit_avicenna_user($data)

        

    //Function verify_if_email_already_exist_user(): Verify if the email already exist before registration.

    public function verify_if_email_already_exist_user($email_address,  $user_id=''){

            

        $this->db->dbprefix('users');

        $this->db->where('email_address', $email_address);

        if(trim($user_id) !='')$this->db->where('id !=', $user_id);



        $get = $this->db->get('users');

        

        //echo $this->db->last_query();         exit;

        

        if($get->num_rows() > 0)

            return true;    

        else

            return false;

        

    } // end verify_if_email_already_exist_user 

    

    

    //Function get_user_list($users_id): Get Users get_user_list from users table via user id

    public function get_user_list($users_id = ''){



        $this->db->dbprefix('users');

        $this->db->select('users.*');

        $this->db->from('users');

        if(trim($users_id) !='')$this->db->where('users.id',$users_id);

        $this->db->where('buying_group_id','1');

        $get_users= $this->db->get();

        //echo $this->db->last_query();         exit;

        

        if(trim($users_id) !='')

            return $get_users->row_array();

        else 

            return $get_users->result_array();

        

    }//end get_old_user_list($users_id)

    

    

    //Function get_user_type($users_id): Get Users details from users table via user id

    public function get_user_type(){



        $this->db->dbprefix('usertype');

        $this->db->select('usertype.*');

        $this->db->from('usertype');

        $get_users= $this->db->get();

        //echo $this->db->last_query();         exit;

        return $get_users->result_array();

        

    }//end get_old_user_list($users_id)

    

    // get_all_pharmacy_ajax_call

    public function get_all_pharmacy_ajax_call(){

        

        $aColumns = array('org_pharmacy_surgery.pharmacy_surgery_name', 'org_pharmacy_surgery.status','org_pharmacy_surgery.contact_no','org_pharmacy_surgery.postcode');



        // DB table to use

        $sTable = 'org_pharmacy_surgery';

        

        $iDisplayStart = $this->input->get_post('iDisplayStart', true);

        $iDisplayLength = $this->input->get_post('iDisplayLength', true);

        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);

        $iSortingCols = $this->input->get_post('iSortingCols', true);

        $sSearch = $this->input->get_post('sSearch', true);

        $sEcho = $this->input->get_post('sEcho', true);

            

        // Paging

        if(isset($iDisplayStart) && $iDisplayLength != '-1')

        {

            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));

        }

    

        // Ordering

        if(isset($iSortCol_0))

        {

            for($i=0; $i<intval($iSortingCols); $i++)

            {

                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);

                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);

                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);

    

                if($bSortable == 'true')

                {

                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));

                }

            }

        }

                /*

        * Filtering

        * NOTE this does not match the built-in DataTables filtering which does it

        * word by word on any field. It's possible to do here, but concerned about efficiency

        * on very large tables, and MySQL's regex functionality is very limited

        */

        

        $more_fields_to_search = array('org_pharmacy_surgery.pharmacy_surgery_name','org_pharmacy_surgery.status','org_pharmacy_surgery.contact_no','org_pharmacy_surgery.postcode');

        $search_fields = array_merge($aColumns, $more_fields_to_search);

        

        if(isset($sSearch) && !empty($sSearch))

        {

            for($i=0; $i<count($search_fields); $i++)

            {

                $bSearchable = $this->input->get_post('bSearchable_'.$i, true);

                

                // Individual column filtering

                //if(isset($bSearchable) && $bSearchable == 'true')

                //{

                    $this->db->or_like($search_fields[$i], $sSearch);

                //}

            }

        }

        

            /* author : mzm

        * INDIVIDUAL COLUMN FILTERING 



        * Check if individual filtering is enabled

        */

        

        for($i=0; $i<count($search_fields); $i++)

        {

            if($this->input->get_post('sSearch_6', true) == ''){

                $sSearch = $this->input->get_post('sSearch_'.$i, true);

                

                // Individual column filtering

                if(isset($sSearch) && !empty($sSearch) && $sSearch)

                {

                    $this->db->or_like($search_fields[$i], $sSearch);

                }

            }

        }

        

        $select = array('pharmacy_surgery_name','org_pharmacy_surgery.address','organization.company_name', 'org_pharmacy_surgery.contact_no','org_pharmacy_surgery.organization_id', 'org_pharmacy_surgery.manager_id','org_pharmacy_surgery.postcode','org_pharmacy_surgery.gphc_no','org_pharmacy_surgery.type','website_expiry','org_pharmacy_surgery.id','org_pharmacy_surgery.is_deleted','users.id as userid','users.first_name','users.last_name','org_pharmacy_surgery.enable_clinical_governance','org_pharmacy_surgery.enable_prescription','org_pharmacy_surgery.enable_register','website_package', 'org_pharmacy_surgery.status');



        // Select Data

        $this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $select)), false);

        $this->db->dbprefix($sTable);

        $this->db->join('organization', 'org_pharmacy_surgery.organization_id = organization.id', 'left'); 

        $this->db->join('users', 'organization.superintendent_id = users.id', 'left');

        $this->db->where(' (kod_org_pharmacy_surgery.is_deleted = "0" )' );

        $this->db->order_by('org_pharmacy_surgery.id', "DESC");

        

        $rResult = $this->db->get($sTable);

        

        //echo $this->db->last_query(); exit;

        

        //mzm total get the current total from the recent query with all filters

        // Data set length after filtering

        

        $this->db->dbprefix($sTable);

        $this->db->select('FOUND_ROWS() AS found_rows');

        

        $iFilteredTotal = $this->db->get()->row()->found_rows;

        

        // Total data set length. QUERY 2 to get overall total without any filters

        //add join referernce here too if required. For total no filters

        //$this->db->join('stores','products.store_id = stores.store_id','INNER');

        

        $iTotal = $this->db->count_all_results($sTable);

        

        // Output

        $output = array(

            'sEcho' => intval($sEcho),

            'iTotalRecords' => $iTotal,

            'iTotalDisplayRecords' => $iFilteredTotal,

            'aaData' => array()

        );

        

        $data_db = $rResult->result_array();

        

        foreach( $data_db as $aRow){

            

            // is_deleted not equel to 1 is_deleted 1 mean( deleted)

            if($aRow['is_deleted'] !=1) {

            

                    $row = array();

                    $option_html = '';

                    

                    $get_user_data = $this->users->get_users_details($aRow['manager_id']);

                    $get_user_supertintendent = $this->get_organizaiotion_superintendent_name($aRow['organization_id']);

                    

                    foreach($select as $col){

                        

                        //get_users_details[]

                        

                        if($aRow['enable_clinical_governance'] == '1'){

                            $class_c = 'btn-success';

                            $text_c = 'Unassign';

                        }else{

                            $class_c = 'btn-danger';

                            $text_c = 'Assign';

                        }



                        if($aRow['enable_prescription'] == '1'){

                            $class_p = 'btn-success';

                            $text_p = 'Unassign';

                        }else{

                            $class_p = 'btn-danger';

                            $text_p = 'Assign';

                        }

                        

                        if($aRow['enable_register'] == '1'){

                            $class_r = 'btn-success';

                            $text_r = 'Unassign';

                        }else{

                            $class_r = 'btn-danger';

                            $text_r = 'Assign';

                        }

                        

                        $class_w = '';

                        if($aRow['website_package'] == 'S'){

                            $class_w = 'btn-success';

                            $text_w = 'Are you sure you want to unassign STANDARD website to <strong>'.ucfirst($aRow["pharmacy_surgery_name"]).'</strong>?';

                        }else{

                            $class_w = 'btn-danger';

                            $text_w = 'Are you sure you want to assign STANDARD website to <strong>'.ucfirst($aRow["pharmacy_surgery_name"]).'</strong>?';

                            

                        }

                        

                        $class_wp = '';

                        if($aRow['website_package'] == 'P'){

                            $class_wp = 'btn-success';

                            

                            $text_wp = 'Are you sure you want to unassign PREMIUM website to <strong>'.ucfirst($aRow["pharmacy_surgery_name"]).'</strong>?';

                        }else{

                            $class_wp = 'btn-danger';

                            $text_wp = 'Are you sure you want to assign PREMIUM website to <strong>'.ucfirst($aRow["pharmacy_surgery_name"]).'</strong>?';

                        }

                        

                        if($col == 'pharmacy_surgery_name'){

                             if($aRow['pharmacy_surgery_name'] !=''){ $row[] = ucfirst(filter_string($aRow['pharmacy_surgery_name']));} else {$row[] ='--';}

                             

                        }elseif($col == 'org_pharmacy_surgery.address'){

                             if($aRow['address'] !=''){ $row[] = filter_string($aRow['address']).', '.filter_string($aRow['postcode']);} else { $row[] = '--'; }

                            

                        }elseif($col == 'org_pharmacy_surgery.contact_no'){

                            if($aRow['contact_no'] !=''){ $row[] = filter_string($aRow['contact_no']);} else { $row[] = '--'; }

                            

                        }elseif($col == 'org_pharmacy_surgery.organization_id'){

                            $row[] = ucfirst(filter_string($get_user_supertintendent['first_name']).' '.filter_string($get_user_supertintendent['last_name']));

                            

                        }elseif($col == 'org_pharmacy_surgery.status'){

                            if($aRow['status'] == '0') { $row[] =  'InActive';} else { $row[] =  'Active';}

                        

                        }elseif($col == 'website_expiry'){

                            

                            if($aRow['website_expiry']){ 

                            

                                $td_verify_if_pharmacy_already_purchased = json_decode(td_verify_if_pharmacy_already_purchased($aRow['id']));

                                

                                if(!$td_verify_if_pharmacy_already_purchased->expiry_date || $td_verify_if_pharmacy_already_purchased->expiry_date == '0000-00-00')

                                    $row[] = 'Pending';

                                else{

                                    

                                    $renew_str = '';

                                    if($td_verify_if_pharmacy_already_purchased->expiry_date < date('Y-m-d')){



                                        $renew_str = '

                                            <a href="#" data-toggle="modal" data-target="#confirm-subscription-'.$aRow["id"].'"><strong>[Expired! Renew Now]</strong></a>

                                            

                                        <div class="modal fade" id="confirm-subscription-'.$aRow["id"].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                            <div class="modal-dialog">

                                                <div class="modal-content">

                                                    <h4 class="modal-header">

                                                        Confirmation

                                                    </h4>

                                                    <div class="modal-body">

                                                        <p>Are you sure you want to renew subscription for <strong>'.ucfirst($aRow["pharmacy_surgery_name"]).'</strong>?</p>

                                                    </div>

                                                    <div class="modal-footer">

                                                        <a href="'.base_url().'avicenna/renew-subscription/'.$aRow["id"].'" class="btn btn-danger">Renew</a>

                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>                                          

                                        

                                        ';

                                    }

                                    

                                    $current_date = date_create(date('Y-m-d'));

                                    $expiry_date = date_create($td_verify_if_pharmacy_already_purchased->expiry_date);

                                    $difference_days = date_diff($current_date,$expiry_date);

                                    

                                    if($difference_days->format("%a") <= 30){

                                        $expiry_before_month_str = '<strong class="text-danger">Expiring</strong>'; 

                                    }

                                    

                                    $row[] = $expiry_before_month_str.'<br>'.date('d/m/Y', strtotime($td_verify_if_pharmacy_already_purchased->expiry_date)).'<br>'.$renew_str;

                                    

                                }

                                

                            }else { 

                                $row[] =  '-';

                            }   

                        

                        }elseif($col == 'org_pharmacy_surgery.id'){

                    

                            $row[] = '

                            

                                <a href="#" data-href="'.base_url().'avicenna/-/'.$aRow["id"].'" data-toggle="modal" data-target="#confirm-w-'.$aRow["id"].'" class="btn '.$class_w.' btn-xs" >W</a>

                                <a href="#" data-href="'.base_url().'avicenna/-/'.$aRow["id"].'" data-toggle="modal" data-target="#confirm-wp-'.$aRow["id"].'" class="btn '.$class_wp.' btn-xs" >W+</a>



                                <a href="#" data-href="'.base_url().'avicenna/assign-unassign-pharmacy/'.$aRow["id"].'" data-toggle="modal" data-target="#confirm-c-'.$aRow["id"].'" class="btn '.$class_c.' btn-xs" >C</a>

                                

                                <a href="#" data-href="'.base_url().'avicenna/assign-unassign-pharmacy/'.$aRow["id"].'" data-toggle="modal" data-target="#confirm-p-'.$aRow["id"].'" class="btn '.$class_p.' btn-xs" >P</a>

                                

                                <a href="#" data-href="'.base_url().'avicenna/assign-unassign-pharmacy/'.$aRow["id"].'" data-toggle="modal" data-target="#confirm-r-'.$aRow["id"].'" class="btn '.$class_r.' btn-xs" >R</a>

                                        

                                <div class="modal fade" id="confirm-c-'.$aRow["id"].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <h4 class="modal-header">

                                                Confirmation

                                            </h4>

                                            <div class="modal-body">

                                                <p>Are you sure you want to '.strtolower($text_c).' the <strong>Clinical Governance</strong> for <strong>'.ucfirst($aRow["pharmacy_surgery_name"]).' '.$aRow["last_name"].'</strong>?</p>

                                            </div>

                                            <div class="modal-footer">

                                                <a href="'.base_url().'organization/assign-unassign-pharmacy/enable-clinical-governance/'.$aRow["id"].'" class="btn btn-danger">'.$text_c.'</a>

                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                

                                <div class="modal fade" id="confirm-p-'.$aRow["id"].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <h4 class="modal-header">

                                                Confirmation

                                            </h4>

                                            <div class="modal-body">

                                                <p>Are you sure you want to '.strtolower($text_p).' the <strong>Prescription</strong> for <strong>'.ucfirst($aRow["pharmacy_surgery_name"]).' '.$aRow["last_name"].'</strong>?</p>

                                            </div>

                                            <div class="modal-footer">

                                                <a href="'.base_url().'organization/assign-unassign-pharmacy/enable-prescription/'.$aRow["id"].'" class="btn btn-danger">'.$text_p.'</a>

                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                

                                <div class="modal fade" id="confirm-r-'.$aRow["id"].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <h4 class="modal-header">

                                                Confirmation

                                            </h4>

                                            <div class="modal-body">

                                                <p>Are you sure you want to '.strtolower($text_r).' the <strong>Register</strong> for <strong>'.ucfirst($aRow["pharmacy_surgery_name"]).' '.$aRow["last_name"].'</strong>?</p>

                                            </div>

                                            <div class="modal-footer">

                                                <a href="'.base_url().'organization/assign-unassign-pharmacy/enable-register/'.$aRow["id"].'" class="btn btn-danger">'.$text_r.'</a>

                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                                            </div>

                                        </div>

                                    </div>

                                </div>



                                <div class="modal fade" id="confirm-w-'.$aRow["id"].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <h4 class="modal-header">

                                                Confirmation

                                            </h4>

                                            <div class="modal-body">

                                                <p>'.$text_w.'</p>

                                            </div>

                                            <div class="modal-footer">

                                                <a href="'.base_url().'avicenna/assign-unassign-website/S/'.$aRow["id"].'" class="btn btn-success">Yes</a>

                                                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>

                                            </div>

                                        </div>

                                    </div>

                                </div>                                          



                                <div class="modal fade" id="confirm-wp-'.$aRow["id"].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <h4 class="modal-header">

                                                Confirmation

                                            </h4>

                                            <div class="modal-body">

                                                <p>'.$text_wp.'</p>

                                            </div>

                                            <div class="modal-footer">

                                                <a href="'.base_url().'avicenna/assign-unassign-website/P/'.$aRow["id"].'" class="btn btn-success">Yes</a>

                                                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>

                                            </div>

                                        </div>

                                    </div>

                                </div>                                          



                            ';

                        }

                        

                    }//end of inner columns loop

                    

                    $output['aaData'][] = $row;

            

          } // end if( $aRow['is_deleted'] !=1) 

        }



        header('Content-type: application/json');

        echo json_encode($output);  

    }

    



    // Start - get_organizaiotion_company_name(): Get all Organization Company Name

    public function get_organizaiotion_superintendent_name($organization_id){

        

        $this->db->dbprefix('organization,users');

        $this->db->select('organization.company_name,users.first_name,users.last_name');

        $this->db->from('organization');

        $this->db->join('users', 'users.id = organization.superintendent_id', 'left');

        $this->db->where('organization.id',$organization_id);

        return  $organization_supertintendentname = $this->db->get()->row_array();

            

    } // get_organizaiotion_company_name



     //Function download_single_pgd_csv(): 

     public function download_single_avicenna_pgd_csv($product_id, $product_type){

         

      $this->load->dbutil();

    

       $qry_user_data = $this->db->query("SELECT kod_users.first_name AS FIRST_NAME,kod_users.last_name AS LAST_NAME, kod_users.email_address AS EMAIL, kod_users.mobile_no AS CONTACT, kod_package_pgds.pgd_name AS PGD_NAME, kod_usertype.user_type AS USER_TYPE, kod_user_order_details.expiry_date AS EXPIRY_DATE, kod_user_order_details.is_quiz_passed AS QUIZ_PASSED FROM `kod_user_order_details` INNER JOIN `kod_users` ON `kod_users`.`id` = `kod_user_order_details`.`user_id` INNER JOIN `kod_usertype` ON `kod_users`.`user_type` = `kod_usertype`.`id` INNER JOIN `kod_package_pgds` ON `kod_package_pgds`.`id` = `kod_user_order_details`.`product_id` WHERE kod_users.buying_group_id = '1' AND `product_type` = '".$product_type."' AND `product_id` = '".$product_id."'  AND (`expiry_date` >  '".date('Y-m-d')."' OR `expiry_date` = '0000-00-00') GROUP BY `kod_user_order_details`.`id`");

     

      

      for($i=0; $i<count($count_all_record); $i++){

          

        $final_arr[$i]['first_name']= $count_all_record[$i]['first_name'];

        $final_arr[$i]['last_name']= $count_all_record[$i]['last_name'];

        $final_arr[$i]['pgd_name']= $count_all_record[$i]['pgd_name'];

        $final_arr[$i]['user_type']= $count_all_record[$i]['user_type'];

        $final_arr[$i]['expiry_date']= $count_all_record[$i]['expiry_date'];

        

      }//end for($i=0; $i<count($count_all_record); $i++)

      

        $delimiter = ",";

        $newline = "\r\n";

        

        $download_csv = $this->dbutil->csv_from_result($qry_user_data, $delimiter, $newline);

        

        return $download_csv;

      

    }//end  download_single_avicenna_pgd_csv($product_id, $product_type)')



    //Function download_csv_file_all_pgds(): 

     public function download_csv_file_all_avicenna_pgds($product_type){

         

        $this->load->dbutil();

      

        $qry_user_data = $this->db->query("SELECT kod_users.first_name AS FIRST_NAME,kod_users.last_name AS LAST_NAME, kod_users.email_address AS EMAIL, kod_users.mobile_no AS CONTACT, kod_package_pgds.pgd_name AS PGD_NAME, kod_usertype.user_type AS USER_TYPE, kod_user_order_details.expiry_date AS EXPIRY_DATE, kod_user_order_details.is_quiz_passed AS QUIZ_PASSED FROM `kod_user_order_details` INNER JOIN `kod_users` ON `kod_users`.`id` = `kod_user_order_details`.`user_id` INNER JOIN `kod_usertype` ON `kod_users`.`user_type` = `kod_usertype`.`id` INNER JOIN `kod_package_pgds` ON `kod_package_pgds`.`id` = `kod_user_order_details`.`product_id` WHERE kod_users.buying_group_id = '1' AND `product_type` = '".$product_type."'  AND (`expiry_date` >  '".date('Y-m-d')."' OR `expiry_date` = '0000-00-00') GROUP BY `kod_user_order_details`.`id`");

     

        for($i=0; $i<count($count_all_record); $i++){

          

            $final_arr[$i]['first_name']= $count_all_record[$i]['first_name'];

            $final_arr[$i]['last_name']= $count_all_record[$i]['last_name'];

            $final_arr[$i]['pgd_name']= $count_all_record[$i]['pgd_name'];

            $final_arr[$i]['user_type']= $count_all_record[$i]['user_type'];

            $final_arr[$i]['expiry_date']= $count_all_record[$i]['expiry_date'];

        

        }//end for($i=0; $i<count($count_all_record); $i++)

      

        $delimiter = ",";

        $newline = "\r\n";

        

        $download_csv = $this->dbutil->csv_from_result($qry_user_data, $delimiter, $newline);

        

        return $download_csv;

      

    }//end  download_csv_file_all_avicenna_pgds($product_type)')



}//end file CI_Model (Trainings_mod)

?>