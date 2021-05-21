<div class="col-xs-12">
  <!-- PAGE CONTENT BEGINS -->  
  <h4 class="blue"> <?php if($get_check_balance_details['note']!='') {?>Note(s)<?php } else if($get_check_balance_details['reason'] !=""){?>Reason<?php }?></h4> 
  <hr /> 
   <br />   
   
  <div class="row">
  <?php 
	  $notes_arr = explode('||',$get_check_balance_details['note']);

  ?>
      <div class="form-group col-sm-12">
      <?php 
	  	if($get_check_balance_details['note']!='') { 
	  ?>
          <table class="table table-striped">
            <tr>
                <td width="10%"><strong>Date</strong></td>
                <td width="90%"><strong>Notes</strong></td>
            </tr>
             <?php 
                $notes_arr = explode('||',$get_check_balance_details['note']);
                
                for($i=0;$i<count($notes_arr);$i++){
                    
                    $notes_data = explode('|',$notes_arr[$i]);
            ?>
                    <tr>
                        <td>
                            <?php 
                                if($notes_data[1])
                                    echo $notes_data[0];
                                else
                                    echo '';
                            ?>
                        </td>
                        <td>
                            <?php 
                                if(!$notes_data[1])
                                    echo $notes_data[0];
                                else
                                    echo $notes_data[1];
                            ?>
                        </td>
                    </tr>
            
            <?php
                }//end for($i=0; $i<count($notes_arr);$i++)
            ?>
            </table>    
    <?php		
        }//end if($get_check_balance_details['note']!='') {  

		if($get_check_balance_details['reason'] !=""){  echo filter_string($get_check_balance_details['reason']);}?>
      </div>
  </div>    

 
  
  