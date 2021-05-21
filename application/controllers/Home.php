<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();	
		
		$this->load->model('cms_mod','cms');
		
		//Sets the variable $head to use the slice head (/views/slices/header_script.php)
		$this->stencil->slice('header_script');
		
		//load main template
		$this->stencil->layout('frontend_template_home'); //frontend template
		
		//Sets the variable $head to use the slice head (/views/slices/header_top.php)
		$this->stencil->slice('header_top');
		
		//Sets the variable $head to use the slice head (/views/slices/slider.php)
		$this->stencil->slice('slider');
		
		//Sets the variable $head to use the slice head (/views/slices/footer.php)
		$this->stencil->slice('footer');
		
		//Sets the variable $head to use the slice head (/views/slices/footer_script.php)
		$this->stencil->slice('footer_script');

        $this->stencil->css('jquery.fancybox.css');
        $this->stencil->js('jquery.fancybox.js');
		
	}

	public function index(){
		
		//CMS DATA
		$cms_data_arr = $this->cms->get_cms_page('home');
		
		//set title
		$page_title = $cms_data_arr['cms_page_arr']['page_title'];
		$this->stencil->title($page_title);	
		
		//Sets the Meta data
		$this->stencil->meta(array(
			'description' => $cms_data_arr['cms_page_arr']['meta_description'],
			'keywords' => $cms_data_arr['cms_page_arr']['meta_keywords'],
			'meta_title' => $cms_data_arr['cms_page_arr']['meta_title']
		));
		

		$data['page_data'] = $cms_data_arr['cms_page_arr'];

		//Adds responsive-slider-parallax.css (/assets/css/font-awesome.css)
		$this->stencil->css('responsive-slider-parallax.css');
		
		$this->stencil->js('jquery.event.move.js');
		$this->stencil->js('responsive-slider.js');

		//Mixes everything together and loads the home_view as the $content variable in the layout
		//home_view is located here: /views/home/home.php
		
		$this->stencil->paint('home/home',$data);
		
	}//end function index()
	
	public function buying_group($buying_slug){
		
		$this->load->model('buyinggroup_mod','buyinggroup');
		
		$get_buying_group = $this->buyinggroup->get_active_buyinggroups('',$buying_slug);
		
		if($get_buying_group)
			$this->session->aff_buying_id = $get_buying_group['id'];
		
		redirect(SURL);
		
	}//end buying_group($buying_slug)

	// Start => public function new_terms_process($user_id='')
	public function new_terms_process($user_id=''){

		$upd_arr = array('new_terms_agree' => '1', 'new_terms_agree_date' => date('Y-m-d H:i:s'));

		$this->db->dbprefix('users');
		$this->db->where('id', $user_id);
		$this->db->update('users', $upd_arr);

		redirect($_SERVER['HTTP_REFERER']);

	} // End => public function new_terms_process($user_id='')

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */