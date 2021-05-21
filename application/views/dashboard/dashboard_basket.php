<table class="table table-responsive dashboard_cart_table">
    <tr>
      <th>Products</th>
      <th>Price</th>
    </tr>
    <?php 
        if(count($this->cart->contents()) > 0){
            
            foreach($this->cart->contents() as $row_id => $items){
				$items['qty'] = 1;
                $sub_total+=$items['price'];
    ?>
                    <tr>
        
                      <td><?php echo $items['name']?></td>
                      <td>&pound;<?php echo filter_price($items['price']) ?></td>
                      <td><a href="javascript:;" class="remove_from_basket" id="<?php echo $row_id ?>">
                            <i class="fa fa-times-circle"></i></a>
                      </td>
                    </tr>
    <?php 
            }//end foreach ($this->cart->contents() as $items)
    ?>
    
            <tr><td colspan="4" class="text-right"><strong>Subtotal:</strong> &pound;<?php echo filter_price($sub_total);?></td></tr>
            <tr><td colspan="4" class="text-right"><strong>VAT:</strong> &pound<?php
                    $vat_amount = ($vat_percentage / 100) * $sub_total;
                    echo filter_price($vat_amount);
                ?>
            </td></tr>
            <tr><td colspan="4" class="text-right"><strong>Grand Total:</strong> &pound;<?php 
                    $total_amount = $sub_total + $vat_amount ;
                    echo filter_price($total_amount);
                ?>
             </td></tr>
            <tr>
                <td colspan="4" class="text-center">
                    <a href="javascript:;" class="btn btn-xs btn-danger empty_basket"><i class="fa fa-times-circle"></i> Empty Basket</a>
                    <a href="<?php echo SURL?>dashboard/checkout" class="btn btn-xs btn-warning"><i class="fa fa-paypal"></i> Check Out</a>
                </td>
            </tr>
     <?php
        }else{
    ?>
            <tr>
                <td align="center" colspan="2"><img src="<?php echo IMAGES?>remove_from_shopping_cart.png" /><br />OOps! Your Cart is Empty.
                </td>
            </tr>
    <?php		
        }//end if(count($this->cart->contents() > 0)
     ?>
</table>