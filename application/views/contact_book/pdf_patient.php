<style>
  tr:nth-child(even) {
    background-color: #EFF3F8;
  }
</style>

<div align="right" style="font-family:Arial;">
  <strong> Date created: <?php echo date('d/m/Y'); ?> </strong>
</div>

<div align="left" style="font-family:Arial;">
  <strong> <?php echo $this->session->my_pharmacy_name; ?> </strong>
</div>
<div align="left" style="font-family:Arial;">
  Total Patients: <?php echo $total; ?>
</div>
<br />

<table width="100%" style="border:solid 1px #777; font-family:Arial, Helvetica, sans-serif; font-size:14px;" cellpadding="5" cellspacing="0">
        <thead>
                <tr style="background-color: #ccc;">
                  <th> Name of Pharmacy </th>
                  <th> Address </th>
                  <th> Head Office Address </th>
                  <th> Opening Hours </th>
                  <th> Access arrangemens for disabled customers</th>
                  <th> Contact details of the local CCG </th>
                  <th> Other services we provide </th>
                  <th> NHS services we provide </th>
                </tr>
              </thead>
    <tbody>
    
    <?php if($patient_list){

            foreach($patient_list as $each){
                
                $list_date = date("d",strtotime($each['date_of_birth']));
                $list_month = date("M",strtotime($each['date_of_birth']));
                $list_year = date("Y",strtotime($each['date_of_birth']));
                
                $dob = $list_date.' '.$list_month.', '.$list_year;
                
    ?>		
                <tr>
                    <td align="center"><?php echo filter_string($each['first_name']); ?></td>
                    <td align="center"><?php echo filter_string($each['last_name']); ?></td>
                    <td align="center"><?php echo $dob; ?></td>
                    <td align="center"><?php echo filter_string($each['address']); ?></td>
                    <td align="center"><?php echo filter_string($each['town']); ?></td>
                    <td align="center"><?php echo filter_string($each['postcode']); ?></td>
                    <td align="center"><?php echo filter_string($each['mobile_no']); ?></td>
                </tr>
 <?php		} // foreach($patient_list as $each)

        } // if($patient_list)
?>
    </tbody>
  </table>