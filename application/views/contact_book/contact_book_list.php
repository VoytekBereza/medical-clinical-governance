<?php // echo count($contact_list)%3; exit; ?>
<br />
<table class="table table-hover table-bordered" style="margin-left:16px; width:96%;">
	<?php if($contact_list){ $i=0; ?>
     <?php foreach($contact_list as $each){ ?>
     	<?php if($i == 0){ ?>
            <tr>
        <?php } ?>
              <td>
              	<strong><?php echo $each['first_name'].' '.$each['last_name']; ?></strong> <br />
                <?php echo $each['contact_no']; ?><br />
                <?php echo $each['email_address']; ?>
              </td>
     	<?php if($i == 2){ ?>
            </tr>
        <?php } ?>

        <?php if($i == 2){ $i = 0; } else { $i++; } 
	  } // foreach ?>
<?php } else { ?>
     <tr>
        <td> No record founded..</td>
     </tr>

<?php } ?>
                    
</table>