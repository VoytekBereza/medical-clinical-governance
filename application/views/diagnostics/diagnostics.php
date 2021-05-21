<?php 

	$active_tab = $this->input->get('t');
	
    // Set if submition fiald showing data in fields which is user filled 
?>
<div class="panel panel-default"> 
	<div class="panel-heading"><strong><?php echo filter_string($cms_data_arr['page_title'])?></strong></div>
    <div class="panel-body">
        
        <div class="row">
          <div class="col-md-12">
            <!--<ul class="nav nav-tabs">
              <li class="<?php if($active_tab =="") { echo 'active';} else { echo '';}?>"><a data-toggle="tab" href="#introduction_tab">Introduction</a></li>
              <li class="<?php if($active_tab !="" && $active_tab ==2) { echo 'active';} else { echo '';}?>"><a data-toggle="tab" href="#complaints_tab">Complaints</a></li>
              <li class="<?php if($active_tab !="" && $active_tab ==3) { echo 'active';} else { echo '';}?>"><a data-toggle="tab" href="#email_form">Email Form</a></li>
              <li><a data-toggle="tab" href="#link_form">Link to Form</a></li>
              <li><a data-toggle="tab" href="#embed_form">Embed Form </a></li>
            </ul>-->
            <div class="tab-content">
              <div id="introduction_tab" class="tab-pane fade in <?php if($active_tab =="") { echo 'active';} else { echo '';}?>">
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12"> <br />
                   <?php echo filter_string($cms_data_arr['page_description'])?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>   