<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Trainings extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('login_mod','login');
        $this->load->model('common_mod','common');
        $this->load->model('trainings_mod','training');

        // Load BreadcrumbComponent Library
        $this->load->library('BreadcrumbComponent');

        //Login Check for the sections defined in here.
        $this->login->verify_is_user_login();

        //Sets the variable $head to use the slice head (/views/slices/header_script.php)
        $this->stencil->slice('header_script');

        //load main template
        $this->stencil->layout('page_template'); //page_template

        //Sets the variable $head to use the slice head (/views/slices/header_top.php)
        $this->stencil->slice('header_top');

        // Contents header (For Bread Crumb and flash messages)
        $this->stencil->slice('contents_header');

        //Sets the Left Navigation
        $this->stencil->slice('left_nav');

        //Sets the variable $head to use the slice head (/views/slices/footer.php)
        $this->stencil->slice('footer');

        //Sets the variable $head to use the slice head (/views/slices/footer_script.php)
        $this->stencil->slice('footer_script');

       // Js file using for CMS page validation
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
        $this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');

    }

    public function index(){

        //Page not on used at the moment
        //redirect(SURL.'login');
        echo 'This is Training - index';

    } //end index()

    /* --------------------------------------------------------- */
    /* ---------------- Start Trainings Section ---------------- */
    /* --------------------------------------------------------- */

    // Start -  add_new_training():
    public function add_new_training($training_id=''){

        //set Page title
        $page_title = DEFAULT_TITLE;
        $this->stencil->title($page_title);

        //Sets the Meta data
        $this->stencil->meta(array(
            'description' => DEFAULT_DESCRIPTION,
            'meta_title' => DEFAULT_TITLE
        ));

        // Load script for ckeditor
        $this->stencil->js('editors/ckeditor/ckeditor.js');

        // Set Bread Crumb
        $this->breadcrumbcomponent->add('Training', base_url().'trainings/list_all_trainings');

        if($training_id == ''){

            // Set Bread Crumb
            $this->breadcrumbcomponent->add('Add New', base_url().'trainings/add-new-training');

        } else {

            $get_training_details = $this->training->get_training_details($training_id);
            $data['get_training_details'] = $get_training_details;
			
			  // Set Bread Crumb
            $this->breadcrumbcomponent->add($get_training_details['course_name'].' Update', base_url().'trainings/add-new-training');

        } //end if($training_id == '')

        // Get all user types
        $data['user_types'] = $this->common->get_all_user_types();
        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();
        $this->stencil->paint('trainings/add_new_training',$data);

    } // End - add_new_training($training_id='')

    // Start -  submit_training(): Submit Training data (New - Update)
    public function submit_training(){

        //If Post is not SET
        if(!$this->input->post() && !$this->input->post('new_training_btn')) redirect(base_url());
        $training_id = $this->input->post('training_id');

        if($training_id == ''){ // If Add new Training is requested

            // Add - Update (Training)
            $add_status = $this->training->add_update_training($this->input->post(), 'add');

            if(isset($add_status['error_upload'])){

                // session set form data in fields
                $this->session->set_flashdata($this->input->post());
                $err_message = 'Image not uploaded';
                $this->session->set_flashdata('err_message', $err_message);
                redirect(SURL.'trainings/add-new-training/');
            }
            else if($add_status && !isset($add_status['error_upload'])){

                $this->session->set_flashdata('ok_message', 'New training added successfully.');
                redirect(SURL.'trainings/list-all-trainings/');

            } else { //if($add_status)

                // session set form data in fields
                $this->session->set_flashdata($this->input->post());

                $this->session->set_flashdata('err_message', 'Oops! Something went wrong, please try again later.');
                redirect(SURL.'trainings/add-new-training/');

            } // else

        } else { // else if($training_id == '')

            // Update Training
            $update_status = $this->training->add_update_training($this->input->post(), 'update');

            if(isset($update_status['error_upload'])){

                // if error form submision
                $this->session->set_flashdata($this->input->post());
                $err_message = 'Image not uploaded';
                $this->session->set_flashdata('err_message', $err_message);
                redirect(SURL.'trainings/add-new-training/'.$training_id);
            } else {

                $this->session->set_flashdata('ok_message', 'Your training updated successfully.');
                redirect(SURL.'trainings/add-new-training/'.$training_id);
            }
            /*
            }else{
                $this->session->set_flashdata('err_message', 'Oops! Something went wrong, please try again later.');
                redirect(SURL.'trainings/add-new-training/'.$training_id);

            } // else
            */

        } // else

    } // End - submit_training():

    // Start - list_all_trainings(): Fetch all training and list
    public function list_all_trainings($user_type = ''){

        //set title
        $page_title = DEFAULT_TITLE;
        $this->stencil->title($page_title);

        //Sets the Meta data
        $this->stencil->meta(array(
            'description' => DEFAULT_DESCRIPTION,
            'meta_title' => DEFAULT_TITLE
        ));

        // Set Bread Crumb
        //$this->breadcrumbcomponent->add('Trainings', base_url().'trainings/index');
        $this->breadcrumbcomponent->add('Edit Training', 	base_url().'trainings/add-new-training');
        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();

        // Add Javascripts
        // icheck
        $this->stencil->js('icheck/icheck.min.js');

        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');

        // Load custom file data_tables.js
        $this->stencil->js('kod_scripts/data_tables.js');
        $this->stencil->js('kod_scripts/custom.js');
        $this->stencil->css('kod_css/jquery.dataTables.min.css');

        // Get all trainings
        $data['trainings'] = $this->training->get_all_trainings($user_type);

        // Get All User Types
        $data['user_types'] = $this->training->get_all_usertypes();

        // Load view: list_all_trainings
        $this->stencil->paint('trainings/list_all_trainings',$data);

    } // End - list_all_trainings():

    // Start - delete_training(): Delete training by id
    public function delete_training($training_id=''){

        if($training_id != ''){

            $deleted = $this->training->delete_training($training_id);

            if($deleted){ // In case success

                $this->session->set_flashdata('ok_message', 'Training has been successfully deleted.');
                redirect(SURL.'trainings/list-all-trainings/');

            } else { // else if($deleted): In case failure

                $this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
                redirect(SURL.'trainings/list-all-trainings/');

            } // else - db error

        } else { // if($training_id != ''): if no id given (to be deleted)

            $this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
            redirect(SURL.'trainings/list-all-trainings/');

        }
    } // End - delete_training():

    /* --------------------------------------------------------- */
    /* ------------- Start Training Documents Section ---------- */
    /* --------------------------------------------------------- */

    // Start - list_all_document_categories():
    public function list_all_document_categories($training_id = '', $category_id = ''){

        //set title
        $page_title = DEFAULT_TITLE;
        $this->stencil->title($page_title);

        //Sets the Meta data
        $this->stencil->meta(array(
            'description' => DEFAULT_DESCRIPTION,
            'meta_title' => DEFAULT_TITLE
        ));

        // Pull all categories from db
        $data['categories'] = $this->training->list_all_document_categories($training_id);

            // Get all trainings
        $data['list_all_traings'] = $this->training->get_all_trainings($user_type);


        if($category_id != ''){ // If update action requested
            $data['category'] = $this->training->get_training_document_category($category_id);
            $data['form_action'] = 'update';
        } else {
            $data['form_action'] = 'add';
        }
		
	    $get_training_details = $this->training->get_training_details($training_id);
		$data['get_training_details'] = $get_training_details;
		
		$this->stencil->js('custom.js');

       	/* // Add scripts
        $this->stencil->js('icheck/icheck.min.js');
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
        // Load custom file data_tables.js
        $this->stencil->js('kod_scripts/data_tables.js');
        $this->stencil->css('kod_css/jquery.dataTables.min.css');*/

        // Set Bread Crumb
        /* $this->breadcrumbcomponent->add('Training', base_url().'trainings/list-all-trainings');
        $this->breadcrumbcomponent->add(''.ucfirst($trainings_name).' Document Category', '#');
        // BreadCrumb OutPut
        $data['breadcrum_data'] = $this->breadcrumbcomponent->output(); */

        $this->stencil->paint('trainings/add_edit_list_document_categories', $data);

    } // End - list_all_document_categories():

    // Start - add_update_category():
    public function add_update_category(){

        $success = $this->training->add_update_category($this->input->post());
        $action = $this->input->post('action');
		
		if($this->input->post('training_id')!=""){
			$training_id = $this->input->post('training_id');
		}
        if($success){
            if($action == 'add')
                $this->session->set_flashdata('ok_message', 'Folder has been successfully added.');
            else
                $this->session->set_flashdata('ok_message', 'Folder has been successfully updated.');
            redirect(SURL.'trainings/documents-listing/'.$training_id);
        } else {
            $this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
            redirect(SURL.'trainings/documents-listing/'.$training_id);
        }

    } // End - add_update_category():

    // Start - delete_document_category($category_id = ''):
    public function delete_document_category($training_id = '', $category_id = ''){

        if($category_id != ''){

            $deleted = $this->training->delete_document_category($category_id);
            if($deleted){

                // Success
                $this->session->set_flashdata('ok_message', 'Folder has been successfully deleted.');
                redirect(SURL.'trainings/documents-listing/'.$training_id);

            } else {

                // Failure
                $this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
                redirect(SURL.'trainings/documents-listing/'.$training_id);

            } // else if($deleted):

        } else {

            $this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
            redirect(SURL.'trainings/documents-listing/'.$training_id);

        } // else - if($category_id != ''):
    } // End - delete_document_category($category_id = ''):

    // Start - add_edit_document():
    public function add_edit_document($training_id = '', $document_id = ''){

        //set title
        $page_title = DEFAULT_TITLE;
        $this->stencil->title($page_title);

        //Sets the Meta data
        $this->stencil->meta(array(
            'description' => DEFAULT_DESCRIPTION,
            'meta_title' => DEFAULT_TITLE
        ));

        $data['course_id'] = $training_id;
        $data['document_categories'] = $this->training->get_all_training_document_categories($training_id);

        // Get Training Name Document Name by ID's
        $trainings_name = $this->training->training_name_by_id($training_id);
        $document_name = $this->training->document_name_by_id($document_id);

        // Set Bread Crumb
        //$this->breadcrumbcomponent->add('Trainings', base_url().'trainings/index');
        $this->breadcrumbcomponent->add('Training', base_url().'trainings/list-all-trainings');
        $this->breadcrumbcomponent->add(''.ucfirst($trainings_name).' Documents', base_url().'trainings/documents_listing/'.$training_id);

        if($document_id != ''){ // Update

            $this->breadcrumbcomponent->add('Update', base_url().'trainings/documents_listing/'.$training_id);

            $data['form_action'] = 'update';
            $data['document'] = $this->training->get_training_document_by_document_id($document_id);

        } else { // Add New

            // Set Bread Crumb for Add new document
            $this->breadcrumbcomponent->add('Add New', base_url().'trainings/add_edit_document');

        $data['form_action'] = 'add';
        }

        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();
        $this->stencil->paint('trainings/documents/add_document', $data);

    } // End - add_edit_document():

    // Start - add_update_document():
    public function add_update_document(){

        // Form action - add or update
        $form_action = $this->input->post('action');
		
        // Send POST data to model
        $status = $this->training->add_update_document($this->input->post(), $form_action);

        $course_id = $this->input->post('course_id');
        $document_id = $this->input->post('document_id');

        if($status == true){ // On success

            if($form_action == 'add'){

                // Success message for Add
                $this->session->set_flashdata('ok_message', 'New document added successfully.');
                redirect(SURL.'trainings/documents-listing/'.$course_id);

            }elseif($form_action == 'update'){

                // Success message for Update
                $this->session->set_flashdata('ok_message', 'Document updated successfully.');
                redirect(SURL.'trainings/documents-listing/'.$course_id);
            }

        } else { // On failure

            $this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
            redirect(SURL.'trainings/documents-listing/'.$course_id);
        }

    } // End - add_update_document()

    // Start - documents_listing(): List all documents by Training id
    public function documents_listing($training_id = ''){

        //set title
        $page_title = DEFAULT_TITLE;
        $this->stencil->title($page_title);

        //Sets the Meta data
        $this->stencil->meta(array(
            'description' => DEFAULT_DESCRIPTION,
            'meta_title' => DEFAULT_TITLE
        ));

        $this->stencil->js('bootstrap-treeview.js');
        $this->stencil->js('kod_scripts/custom.js');

        // Fancy Box Scripts
        $this->stencil->js('jquery.fancybox.js');
        $this->stencil->css('jquery.fancybox.css');
        
        // Add scripts
        // icheck
        $this->stencil->js('icheck/icheck.min.js');
        // Datatables
        $this->stencil->js('datatables/js/jquery.dataTables.js');
        $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
        // Load custom file data_tables.js
        $this->stencil->js('kod_scripts/data_tables.js');
        
        // Js file using for Users  validation
        $this->stencil->js('kod_scripts/jquery.validate.js');
        // end Users file Validation
        
        // Js Form  form validation
        $this->stencil->js('kod_scripts/custom_validate.js');

        $this->stencil->css('kod_css/jquery.dataTables.min.css');

        if($training_id != ''){ // varify training id is given

			$get_training_details = $this->training->get_training_details($training_id);
            $data['get_training_details'] = $get_training_details;
			
			
			  // Pull all categories from db
           $data['categories_list'] = $this->training->get_training_documents_tree($training_id,$category_id);
		   
		   if($category_id != ''){ // If update action requested
            		$data['form_action'] = 'update';
        		} else {
            		$data['form_action'] = 'add';
             }
			
			// Get Training Name by Training ID
            $trainings_name = $this->training->training_name_by_id($training_id);

            // Set Bread Crumb
            //$this->breadcrumbcomponent->add('Trainings', base_url().'trainings/index');
            $this->breadcrumbcomponent->add('Training', base_url().'trainings/list-all-trainings');
            $this->breadcrumbcomponent->add(''.ucfirst($trainings_name).' Documents', base_url().'trainings/list-all-trainings');

            // Get all documents by training id
            $documents = $this->training->documents_listing($training_id);
            if(!empty($documents)){ // on success - data not empty

                $data['documents'] = $documents;
				
				// Js file using for CMS page validation
				//$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.js');
				///$this->stencil->js('kod_scripts/form_validation/bootstrap_validator/dist/validator.min.js');
               

            } else {
                $data['documents'] = NULL;
            }

            $data['course_id'] = $training_id;

            // Bread Crumb Output
            $data['breadcrum_data'] = $this->breadcrumbcomponent->output();
            // Load view trainings/list_all_documents
            $this->stencil->paint('trainings/documents/list_all_documents', $data);

        } else { // if data is empty (documents not founded)
            $this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
            redirect(SURL.'trainings/list_all_trainings/');
        }
    } // End - documents_listing():

    // Start - delete_document
    public function delete_document($course_id, $document_id=''){

        if($document_id != ''){

            $deleted = $this->training->delete_document($document_id);

            if($deleted){ // On success

                $this->session->set_flashdata('ok_message', 'File has been successfully deleted.');
                redirect(SURL.'trainings/documents-listing/'.$course_id);

            } else { // In case failure

                $this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
                redirect(SURL.'trainings/documents-listing/'.$course_id);

            } // else - db error

        } else { // if no id given (to be deleted)

            $this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
            redirect(SURL.'trainings/documents-listing/'.$course_id);

        }
    } // End - delete_document():

    /* --------------------------------------------------------- */
    /* -------------- Start Training Videos Section ------------ */
    /* --------------------------------------------------------- */

    // Start - add_edit_video():
    public function add_edit_video($training_id = '', $video_id = ''){

        //set title
        $page_title = DEFAULT_TITLE;
        $this->stencil->title($page_title);

        //Sets the Meta data
        $this->stencil->meta(array(
            'description' => DEFAULT_DESCRIPTION,
            'meta_title' => DEFAULT_TITLE
        ));

        // Get Training Name by Training ID
        $trainings_name = $this->training->training_name_by_id($training_id);
		$data['trainings_name'] = $trainings_name;

        // Set Bread Crumb
        $this->breadcrumbcomponent->add('Training', base_url().'trainings/list-all-trainings');
        $this->breadcrumbcomponent->add(''.ucfirst($trainings_name).' Videos', base_url().'trainings/videos_listing/'.$training_id);

        $data['course_id'] = $training_id;

        if($video_id != ''){ // Update

            // Set Bread Crumb for Update Video
            $this->breadcrumbcomponent->add('Update', base_url().'trainings/documents_listing/'.$training_id);
            $data['form_action'] = 'update';
            $data['video'] = $this->training->get_training_video_by_video_id($video_id);

        } else { // else if($video_id != ''): Add New Video

            // Set Bread Crumb for Add new video
            $this->breadcrumbcomponent->add('Add New', base_url().'trainings/add_edit_document');
            $data['form_action'] = 'add';
        } // else

        // Bread Crumb Output
        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();
        $this->stencil->paint('trainings/videos/add_video', $data);

    } // End - add_edit_video():

    // Start - videos_listing(): List all documents by Training id
    public function videos_listing($training_id = ''){

        //set title
        $page_title = DEFAULT_TITLE;
        $this->stencil->title($page_title);

        //Sets the Meta data
        $this->stencil->meta(array(
            'description' => DEFAULT_DESCRIPTION,
            'meta_title' => DEFAULT_TITLE
        ));

        // Get Training Name by Training ID
        $trainings_name = $this->training->training_name_by_id($training_id);
		
		 $data['trainings_name'] = $trainings_name;

        // Set Bread Crumb
        //$this->breadcrumbcomponent->add('Trainings', base_url().'trainings/index');
        $this->breadcrumbcomponent->add('Training', base_url().'trainings/list-all-trainings');
        $this->breadcrumbcomponent->add(''.ucfirst(filter_string($trainings_name)).' videos / presentations', base_url().'trainings/videos_listing/'.$training_id);

        if($training_id != ''){ // varify training id is given

            // Get all documents by training id
            $videos = $this->training->videos_listing($training_id);

            // Get all intro videos
            $videos_intro = $this->training->videos_intro_listing($training_id);
            $data['videos_intro'] = $videos_intro;

            if(!empty($videos)){ // on success - data not empty

                $data['videos'] = $videos;

                // Load scripts

                // Datatables
                $this->stencil->js('datatables/js/jquery.dataTables.js');
                $this->stencil->js('datatables/tools/js/dataTables.tableTools.js');
                // Load custom file data_tables.js
                $this->stencil->js('kod_scripts/data_tables.js');
                $this->stencil->css('kod_css/jquery.dataTables.min.css');

            } else {
                $data['videos'] = NULL;
            }

            $data['course_id'] = $training_id;

            // Set Bread Crum Data
            $data['breadcrum_data'] = $this->breadcrumbcomponent->output();

            // Load view trainings/list_all_documents
            $this->stencil->paint('trainings/videos/list_all_videos', $data);

        } else { // if data is empty (videos not founded)
            $this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
            redirect(SURL.'trainings/list_all_trainings/');
        }
    } // End - videos_listing():

    // Start - add_update_video():
    public function add_update_video(){

        // Form action - add or update
        $form_action = $this->input->post('action');

        // Send POST data to model
        $status = $this->training->add_update_video($this->input->post(), $form_action);

        $course_id = $this->input->post('course_id');
        $video_id = $this->input->post('video_id');

        if($status == true){ // On success

            if($form_action == 'add'){

                // Success message for Add
                $this->session->set_flashdata('ok_message', 'New video added successfully.');
                redirect(SURL.'trainings/videos-listing/'.$course_id);

            }elseif($form_action == 'update'){

                // Success message for Update
                $this->session->set_flashdata('ok_message', 'Video updated successfully.');
                redirect(SURL.'trainings/add-edit-video/'.$course_id.'/'.$video_id);
            }

        } else { // On failure

            $this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
            redirect(SURL.'trainings/videos-listing/'.$course_id);
        }

    } // End - add_update_video()

    // Start - delete_video
    public function delete_video($course_id, $video_id=''){

        if($video_id != ''){

            $deleted = $this->training->delete_video($video_id);

            if($deleted){ // On success

                $this->session->set_flashdata('ok_message', 'Video has been successfully deleted.');
                redirect(SURL.'trainings/videos-listing/'.$course_id);

            } else { // In case failure

                $this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
                redirect(SURL.'trainings/videos-listing/'.$course_id);

            } // else - db error

        } else { // if no id given (to be deleted)

            $this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
            redirect(SURL.'trainings/videos-listing/'.$course_id);

        }
    } // End - delete_video():

    // Start - set_video_as_default($video_id = ''):
    public function set_video_as_default($training_id = '', $video_id = ''){

        $success = $this->training->set_video_as_default($video_id);
        if($success){

            $this->session->set_flashdata('ok_message', 'Intro video has been changed successfully.');
            redirect(SURL.'trainings/videos-listing/'.$training_id);

        } else {

            $this->session->set_flashdata('err_message', 'Oops! Something went wrong.');
            redirect(SURL.'trainings/videos-listing/'.$training_id);
        }
    } // End - set_video_as_default($video_id = ''):

    /* --------------------------------------------------------------- */
    /* ----------------- Start Quizes Section ------------------------ */
    /* --------------------------------------------------------------- */

    // Start - quizes($pgd_id=''):
    public function quizes($training_id=''){

        //set title
        $page_title = DEFAULT_TITLE;
        $this->stencil->title($page_title);

        //Sets the Meta data
        $this->stencil->meta(array(
            'description' => DEFAULT_DESCRIPTION,
            'meta_title' => DEFAULT_TITLE
        ));

        // Get Training Name Document Name by ID's
        $trainings_name = $this->training->training_name_by_id($training_id);

        $data['training_detail'] = $this->training->get_training_details($training_id);
	

        // Set Bread Crumb
        $this->breadcrumbcomponent->add('Training', base_url().'trainings/list-all-trainings');
        $this->breadcrumbcomponent->add(''.ucfirst($trainings_name).' Exam', base_url().'trainings/videos_listing/'.$training_id);
        $data['breadcrum_data'] = $this->breadcrumbcomponent->output();

        if($training_id != '')
            $data['quizes'] = $this->training->get_training_quizes($training_id);
        else
            $data['quizes'] = NULL;

        $data['training_id'] = $training_id;
        $this->stencil->js('kod_scripts/custom.js');

        // Load view
        $this->stencil->paint('trainings/quizes/list_all', $data);

    } // End - quizes($training_id=''):

    // Start - quiz_by_id(): For the Ajax call in (js/kod_scripts/custom.js)
    public function quiz_by_id(){

        if($this->input->post('question_id')){
            $quiz = $this->training->quiz_by_id($this->input->post('question_id'));
        }
        else
            $quiz = NULL;

        echo json_encode(array('quiz' => $quiz));

    } // End - quiz_by_id():

    // Start - add_update_quiz($training_id=''):
    public function add_update_quiz($training_id=''){

        $success = $this->training->add_update_quiz($this->input->post(), $training_id);

        if($success == true){

            $this->session->set_flashdata('ok_message', 'Success.');
            redirect(SURL.'trainings/quizes/'.$training_id);

        } else {

            $this->session->set_flashdata('err_message', 'Something went wrong, please try again later.');
            redirect(SURL.'trainings/quizes/'.$training_id);
        }

    } // End - add_update_quiz($training_id=''):
	
	// Start edit_document
	public function edit_document($training_id = '', $category_id = '', $document_id = ''){
	
        $data['category'] = $this->training->get_training_document_category($category_id);

		if($document_id != ''){ // Update

            $this->breadcrumbcomponent->add('Update', base_url().'trainings/documents-listing/'.$training_id);

            $data['form_action'] = 'update';
			$data['course_id'] = $training_id;
			$data['category_id'] = $category_id;
            $data['document'] = $this->training->get_training_document_by_document_id($document_id);

            $data['form_action'] = 'edit';

        } // if($document_id != '') 

		// Js file using for Users  validation
		$this->stencil->js('kod_scripts/jquery.validate.js');
		// end Users file Validation
		
		// Js Form  form validation
		$this->stencil->js('kod_scripts/custom_validate.js');
		
		//load main template
    	$this->stencil->layout('ajax_pages'); //page_template
	   
        if($document_id != ''){ // Update
	       $this->stencil->paint('trainings/documents/edit_document', $data);
        } else {
            $data['category_id'] = $category_id;
            $data['course_id'] = $training_id;
            $data['form_action'] = 'add';
            $this->stencil->paint('trainings/documents/add_document', $data);
        } // if($document_id != '')
	
	} // edit_document
	
	// Start edit_document_category 
	public function edit_document_category($training_id = '', $category_id = ''){
	
		if($category_id != ''){ // Update

            $this->breadcrumbcomponent->add('Update', base_url().'trainings/documents-listing/'.$training_id);

            $data['form_action'] = 'update';
			$data['course_id'] = $training_id;
			$data['category_id'] = $category_id;
            $data['document_category'] = $this->training->get_training_document_category($category_id);
        }

		// Js file using for Users  validation
		$this->stencil->js('kod_scripts/jquery.validate.js');
		// end Users file Validation
		
		// Js Form  form validation
		$this->stencil->js('kod_scripts/custom_validate.js');
 		
		//load main template
    	$this->stencil->layout('ajax_pages'); //page_template
	
        $data['category'] = $this->training->get_training_document_category($category_id);

	    $this->stencil->paint('trainings/documents/edit_document_category', $data);
	
	} // edit_document_category

} /* End of file Ci_Controller (Trainings) */
