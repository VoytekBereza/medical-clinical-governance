<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content"> <br />
        <?php if($this->session->flashdata('err_message')){?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
        <?php } // end if($this->session->flashdata('err_message')) ?>
        <?php if($this->session->flashdata('ok_message')){?>
        <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
        <?php }//if($this->session->flashdata('ok_message'))?>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Notification Listings <small>Notification Listings </small></h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
               <?php if(!empty($list_all_notifications)){ $DataTableId ="notification";} else { $DataTableId = '';}?>
                <table id="<?php echo $DataTableId; ?>" class="display dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                  <thead>
                    <tr class="headings"> 
                      <th>ID</th>
                      <th>Notification Text</th>
                      <th>Notification Type</th>
                      <th>Created  Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($list_all_notifications)){ ?>
                    <?php $i = 1 ;
					      foreach($list_all_notifications as $each): 
					
						  $notification_txt_value = substr($each['notification_txt'],0,1000);
					 ?>
                   
                    <tr class="even pointer"> 
                        <td class=" "><?php echo $i; ?></td>
                        <td ><?php echo filter_string($notification_txt_value); ?></td>
                          <td class=" "><?php echo $each['notification_type']; ?></td>
                        <td class=" "><?php echo kod_date_format($each['created_date']); ?></td>
                    </tr><?php $i++;
					           endforeach; 
							?>
                    <?php } else { ?>
								<tr class="">
									<td class=" " colspan="9">No record founded.</td>
								</tr>
					<?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
