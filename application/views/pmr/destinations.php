
<div class="panel panel-info">
   <div class="panel-heading"> <strong> Your Journey: </strong> </div>
   <div class="panel-body">
      <table class="table table-hover table-bordered">
         <thead>
            <tr>
               <th> Country</th>
               <th> Arrival Date </th>
            </tr>
         </thead>
         <tbody>
<?php 
            $destinations = get_destination($countries_list);

            $arrival_dates = explode('#', $countries_list['arrival_dates']);

            foreach($destinations as $key => $country){ 
               
               if($country){
?>
                  <tr>
                     <td> <?php echo $country['destination']; ?> </td>
                     <td> <?php echo kod_date_format($arrival_dates[$key]); ?> </td>
                  </tr>
<?php       
               } // if($country)

            } // foreach($destinations as $val)
?>
         </tbody>
      </table>
   </div>
</div>