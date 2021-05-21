<?php
class Medicine_mod extends CI_Model {
	
	function __construct(){
		 parent::__construct();
    }
	
	public function search_medicine($keywords){
		
		$this->db->dbprefix('medicine');
		// $this->db->select('med.id AS medicine_id, CONCAT(med.brand_name," ",med.medicine_name) AS med_full_name, med.medicine_class, form.medicine_form, med.suggested_dose,med.is_branded,strength.id AS strength_id,strength.strength,strength.per_price');
		$this->db->select('med.id AS medicine_id, med.medicine_name AS med_full_name, med.medicine_class, form.medicine_form, med.suggested_dose,med.is_branded,strength.id AS strength_id,strength.strength,strength.per_price');
	
		$this->db->from('medicine AS med');
		$this->db->join('medicine_categories AS cat', 'med.category_id = cat.id');
		$this->db->join('medicine_strength AS strength', 'med.id = strength.medicine_id');
		$this->db->join('medicine_form AS form', 'form.id = med.medicine_form_id');
		
		$this->db->where("CONCAT(med.medicine_name,' ',med.brand_name) like '%$keywords%'");
		$this->db->or_where("CONCAT(med.brand_name,' ',med.medicine_name) like '%$keywords%'");
		
		return $this->db->get()->result_array();
		
	} // public function search_medicine($keywords)
	
	//Function get_medicine_quantities(): This function will return the array of Quantity of the medicines
	public function get_medicine_quantities($medicine_id,$quantity_id = ''){
		
		$this->db->dbprefix('medicine_quantity');
		$this->db->select('medicine_quantity.id AS quantity_id, medicine_quantity.discount_precentage, medicine_quantity.quantity, medicine_quantity.quantity_txt');
		
		$this->db->where('medicine_quantity.medicine_id',$medicine_id);
		
		if(trim($quantity_id) != '') $this->db->where('medicine_quantity.id',$quantity_id);
		
		$get = $this->db->get('medicine_quantity');
		
		if(trim($quantity_id) != '') 
			return $get->row_array();
		else
			return $get->result_array();
		
	}//function get_pharmacy_surgery_medicine_quantities($pharmacy_surgery_id,$medicine_id,$strength_id)

	// Start - get_all_medicine(): Get all Medicine for listing
	public function get_medicine_by($category_id='', $medicine_id=''){

		$this->db->dbprefix('medicine,medicine_categories');
		$this->db->select('medicine.id as medicine_id, medicine.*,medicine_categories.*, medicine_form.medicine_form');
		
		$this->db->from('medicine');
		$this->db->join('medicine_categories','medicine.category_id=medicine_categories.id','inner');
		$this->db->join('medicine_form','medicine.medicine_form_id=medicine_form.id','left');
		
		if($category_id != ''){
			$this->db->where('medicine.category_id', $category_id);
			return $this->db->get()->result_array();
		} // if($category_id != '')
		
		if($medicine_id != ''){
			$this->db->where('medicine.id', $medicine_id);
			return $this->db->get()->row_array();
		} // if($medicine_id != '')
		
	} // End - get_medicine_by($category_id='', $medicine_id=''):

	// Start - public function get_all_category_rafs()
	public function get_all_category_rafs(){

		$this->db->dbprefix('medicine_categories');
		$this->db->where('walkin_pmr_pgd IS NOT NULL');

		return $this->db->get('medicine_categories')->result_array();

	} // End - public function get_all_category_rafs()

	// Start - public function get_medicine_category_raf($category_id)
	public function get_medicine_category_raf($category_id){
		
		$this->db->dbprefix('medicine_categories_raf');
		
		$this->db->select('raf.*, label.label');
		
		$this->db->from('medicine_categories_raf AS raf');
		$this->db->join('medicine_raf_labels AS label', 'label.id = raf.raf_label_id');
		$this->db->where('raf.med_category_id', $category_id);
		
		$this->db->order_by('label.display_order', "ASC");
		$result = $this->db->get()->result_array();
		
		//echo $this->db->last_query();
		//exit;

		$response = array();
		for($i=0; $i<count($result); $i++){
			$response[$result[$i]['label']][] = $result[$i];
		} // for($i=0; $i<count($result); $i++)
		
		return $response;
		
	} // End - public function get_medicine_category_raf($category_id)

	// Start - public function get_medicine_raf_by_id($medicine_id)
	public function get_medicine_raf_by_id($medicine_id){
		
		$this->db->dbprefix('medicine_raf');
		
		$this->db->select('raf.*, label.label');
		
		$this->db->from('medicine_raf AS raf');
		$this->db->join('medicine_raf_labels AS label', 'label.id = raf.raf_label_id');
		$this->db->where('raf.medicine_id', $medicine_id);
		
		$this->db->order_by('label.display_order', "ASC");
		$result = $this->db->get()->result_array();

		$response = array();
		for($i=0; $i<count($result); $i++){
			$response[$result[$i]['label']][] = $result[$i];
		} // for($i=0; $i<count($result); $i++)
		
		return $response;
		
	} // End - function get_medicine_raf_by_id($medicine_id)

	// Start - public function get_category_details($category_id)
	public function get_medicine_category_details($category_id){

		$this->db->dbprefix('medicine_categories');
		$this->db->where('id', $category_id);

		return $this->db->get('medicine_categories')->row_array();

	} // End - public function get_category_details($category_id)

	// Start - public function get_flu_vaccine()
	public function get_flu_vaccine($vaccine_type, $show_type){

		$this->db->dbprefix('travel_vaccines');
		
		$this->db->where("(travel_vaccines.show_type = 'BOTH' OR travel_vaccines.show_type = 'PMR')");
		$this->db->where('vaccine_type', $vaccine_type);
		$this->db->or_where('vaccine_type', "B");

		return $this->db->get('travel_vaccines')->result_array();

	} // End - public function get_flu_vaccine()

	// Start - public function get_vaccine_brands($cat_id)
	public function get_vaccine_brands($cat_id){

		$this->db->dbprefix('vaccine_brands');
		$this->db->where('vaccine_cat_id', $cat_id);

		return $this->db->get('vaccine_brands')->result_array();

	} // public function get_vaccine_brands($cat_id)

	// Start - public function get_vaccine_raf() Returns the list of Vaccines RAF
	public function get_vaccine_raf($vaccine_id){
		
		$this->db->dbprefix('vaccine_raf');
		
		$this->db->select('raf.*, label.label');
		
		$this->db->from('vaccine_raf AS raf');
		$this->db->join('medicine_raf_labels AS label', 'label.id = raf.raf_label_id');
		$this->db->where('raf.vaccine_id', $vaccine_id);
		
		$this->db->order_by('label.display_order', "ASC");
		$result = $this->db->get()->result_array();
		
		$response = array();
		for($i=0; $i<count($result); $i++){
			$response[$result[$i]['label']][] = $result[$i];
		} // for($i=0; $i<count($result); $i++)
		
		return $response;

	} // End - public function get_vaccine_raf($medicine_id)

	// Start - public function get_vaccine_advices($advice_type)
	public function get_vaccine_advices($advice_type){

		$this->db->dbprefix('vaccine_advices');

		$this->db->where('advice_type', $advice_type); // T for Travel | F or Flow
		$this->db->or_where('advice_type', 'B'); // Both [ T OR F ]

		return $this->db->get('vaccine_advices')->result_array();

	} // End - public function get_vaccine_advices($advice_type)

	//Function get_medicine_strength(): This function will return the array of default strength if it is NOT set by the Pharamcy/ Organization and going to use that price in future ownwards
	public function get_medicine_strength($medicine_id,$strength_id = ''){
		
		$this->db->dbprefix('medicine_strength');
		
		$this->db->where('medicine_id',$medicine_id);
		if(trim($strength_id) != '') $this->db->where('id',$strength_id);
		
		$get = $this->db->get('medicine_strength');
		
		if(trim($strength_id) != '')
			return $get->row_array();
		else
			return $get->result_array();
		
	}//function get_medicine_strength($medicine_id,$strength_id = '')

	// Start - public function get_vaccine_countries()
	public function get_vaccine_destinations(){
		
		$this->db->dbprefix('vaccine_destinations');
		return $this->db->get('vaccine_destinations')->result_array();
		
	} // End - public function get_vaccine_countries()
	
}//end file
?>