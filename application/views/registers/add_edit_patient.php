<?php 
if($this->uri->segment(3)){
 $tab_id =$this->uri->segment(3);	
}
?>
    <div class="nav nav-bar col-sm-12 col-md-12 col-lg-12">
      <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">
          <h4>Add patient:</h4>
        </div>
      </div>
      
      <hr />
       
      <div class="row">
        <form   data-toggle="validator" role="form" action="<?php echo SURL?>registers/add-edit-patient-process" method="post" name="add_edit_patient_frm" id="add_edit_patient_frm" >
          <div class="col-sm-6 col-md-12 col-lg-12">
            
             <div class="form-group has-feedback">
              <label>First Name<span class="required">*</span></label>
              <input type="text" class="form-control" name="first_name" id="first_name" required="required" pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*" 
              data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30"  value=""/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
             <div class="form-group has-feedback">
              <label>Last Name<span class="required">*</span></label>
              <input type="text" class="form-control" name="last_name" id="last_name"required="required" pattern="[a-zA-z0-9\-]+(['-_][a-zA-Z0-9]+)*" 
              data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore)"  maxlength="30"  value=""/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
             <div class="form-group has-feedback">
              <label>Mobile No</label>
              <input type="digits" class="form-control" name="mobile_no" id="mobile_no" value=""
              data-error="Please use allowed characters (Numbers, should start with 07 and length should be 11 numbers)" pattern="^07(?=.*[0-9])[0-9]{9,}$" maxlength="11">
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
             <label>Date Of Birth<span class="required">*</span> </label>         
                  <div class="row">
                    <div class="form-group  has-feedback col-sm-4 col-md-4 col-lg-4">
                        <select class="form-control month_february_select" id="birth_date" name="birth_date"  required="required" >
                            <option value="">Select Date</option>
                            <?php 
                                for($i=1; $i<=31;$i++){
                                    if($i <10){
                            ?>
                            <option value="<?php echo '0'.$i;?>"><?php echo '0'.$i;?></option>
                           <?php } else {?>
                           <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php 
                                    } // End if($i <10)
                                } // End for loop
                            ?>
                       </select> 
                     <div class="help-block with-errors"></div>
                    </div>
                        <?php /*MONTH*/ $month= array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'); ?>
                     <div class="form-group has-feedback col-sm-4 col-md-4 col-lg-4">
                        <select class="form-control month_february_select" id="birth_month" name="birth_month" required="required" >
                            <option value="">Select Month</option>
                             <?php for($i=0;$i<12;$i++){?>
                                <option value="<?php echo $i+1;?>">
                                    <?php echo $month[$i];?>
                                </option>
                              <?php }?>
                       </select> 
                        <div class="help-block with-errors"></div>   
                    </div>
                        
                     <div class="form-group has-feedback col-sm-4 col-md-4 col-lg-4">
                        <select class="form-control month_february_select" id="birth_year" name="birth_year" required="required">
                            <option value="">Select Year</option>
                             <?php for($i=date('Y'); $i>=date('Y')-100;$i--){?>
                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }?>
                       </select> 
                     <div class="help-block with-errors"></div>  
                    </div>
                  </div> <!-- ./row -->
            
                <div class="form-group col-sm-12 col-md-12 col-lg-12" style="padding-left:0px;">
                    <label for="gender"> Gender<span class="required">*</span>  </label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label class="radio-inline"><input type="radio" name="gender" value="M" required> Male </label>
                    <label class="radio-inline"><input type="radio" name="gender" value="F" required> Female </label>
                      <div class="help-block with-errors"></div>
                </div>
       
            
             <div class="form-group">
              <label>Address 1<span class="required">*</span></label>
              <input type="text" class="form-control" name="address" id="address" required="required"  pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50" value=""/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
             <div class="form-group has-feedback">
              <label>Address 2</label>
              <input type="text" class="form-control" name="address_2" id="address_2" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50" value=""/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
            
             <div class="form-group has-feedback">
              <label>Address 3</label>
              <input type="text" class="form-control" name="address_3" id="address_3" pattern="[a-zA-z0-9 \-,]+([ '-_.][a-zA-Z0-9]+)*"  data-error="Please use allowed characters (Alphabet, Numbers, Hyphens, Underscore, Comma)"  maxlength="50" value=""/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
             <div class="form-group has-feedback">
              <label>Postcode<span class="required">*</span></label>
              <input type="text" class="form-control my_upper_class" name="postcode" id="postcode" value="" required="required" pattern="^[a-z|A-Z|]+[a-z|A-Z|0-9|\s]*" data-error="Please use allowed characters (Alphabets, Numbers and spaces) and first character must be alphabet." maxlength="8" />
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
              <div class="form-group has-feedback">
              <label>Email Address</label>
              <input type="email" class="form-control" name="email_address_patient" id="email_address_patient" value=""  pattern="[a-zA-z0-9\-]+(['-_.][a-zA-Z0-9]+)*"  data-error="Please use a valid email address (Alphabet, Numbers, Hyphens, Underscore, Dot and @)" autocomplete="off" maxlength="30"/>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
              <div class="help-block with-errors"></div>
            </div>
            
            
            <div class="row" style="margin:0">
            <div class="pull-right">
            	<button type="submit" class="btn btn-sm btn-success btn-block"   name="add_update_btn"> Add new patient</button>
                 <input type="hidden" id="tab_id" name="tab_id" value="<?php echo $tab_id;?>">
            	<!--<button class="btn btn-danger btn-sm " onClick="$.fancybox.close();" type="button"> <i class="ace-icon fa fa-times bigger-110"></i> Close </button>-->
            </div>
              </div>
            </div>
        </form>
      </div>
    </div>
<script type="text/javascript">

if($('#add_edit_patient_frm').html())

	$('#add_edit_patient_frm').validator();
	



</script>