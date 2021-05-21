<?php 
if($this->uri->segment(3)){
 $drug_id =$this->uri->segment(3);	
}
if($this->uri->segment(3)){
 $drug_id =$this->uri->segment(3);	
}
?>
    <div class="nav nav-bar col-sm-12 col-md-12 col-lg-12">
      <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">
          <h4>Current Balance:</h4>
        </div>
      </div>
      
      <hr />
       
        <div class="">
        	The Current balance for "<?php echo  filter_string($get_drug_balance['drug_name']).' '.filter_string($get_drug_balance['drug_form']).' '.filter_string($get_drug_balance['drug_strength']);?>" <strong> <?php echo $get_drug_balance['stock_in_hand'];?> </strong>
        </div>
        <br />
        
        
        <div class="row col-sm-12">
        	Would you like to make an adjustment ?                  
        	<button type="button" class="btn btn-sm btn-success " onclick="javascript:$('#balance_id').toggle();"  name="make_adjustment">Make an adjustment</button>
        </div>

       
      <div class="row">
        <form  action="<?php echo base_url(); ?>registers/add-edit-check-balance-process" method="post" name="check_balance_frm" id="check_balance_frm" >
          <div class="col-md-12">            	             

             <div  id="balance_id" style="display: none;">
			 <!-- stock_in_hand-->
                 <div class="form-group has-feedback">
                  <label>Adjusted quantity<span class="required">*</span></label>
                  <input  type="number" min="0" class="form-control" name="opening_balance" id="opening_balance" value="<?php echo $get_drug_balance['stock_in_hand'];?>" required="required"/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                 </div>
            
                 <div class="form-group has-feedback">
                  <label>Reason<span class="required">*</span></label>
                  <textarea class="form-control"  name="reason" id="reason" value="" rows="4" required="required"/>
                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                  <div class="help-block with-errors"></div>
                </div>
            
                <div class="pull-right">
                
                    <button class="btn btn-success btn-sm" type="submit" id="save_btn" name="save_btn"> <i class="ace-icon fa fa-floppy-o bigger-110"></i> Save </button>
                    <input type="hidden" name="drug_id" value="<?php echo $get_drug_balance['drug_id'];?>">
                    <input type="hidden" name="entry_id" value="<?php echo $get_drug_balance['id'];?>">
                    <input type="hidden" name="tab_id" value="<?php echo $tab_id;?>">
                                        
                    <button class="btn btn-danger btn-sm" type="button" onclick="$.fancybox.close();"> <i class="ace-icon fa fa-times bigger-110"></i> Close </button>
                
                </div>            
            
            </div>
            
            
            
          </div>
        </form>
      </div>
    </div>
    
<script type="text/javascript">

$(document).ready(function(){
	
		if($('#check_balance_frm').html()){

		    $('#check_balance_frm').formValidation({
		        framework: 'bootstrap',
		        icon: {
		            validating: 'glyphicon glyphicon-refresh'
		        },
		        fields: {
					
					 opening_balance: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please fill out this field.'
		                    }
		                }
		            },
		           
		            reason: {
		                validators: {
		                    notEmpty: {
		                        message: 'Please fill out this field.'
		                    }
		                }
		            },
					
		        }
		    });

		} // end - if
	
});

</script>