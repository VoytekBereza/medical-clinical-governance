<h3 class="modal-title">Organisation Details</h3>
<hr />

<h4><?php echo filter_string($organization_data['company_name'])?></h4>

<strong>Address: </strong> <?php echo filter_string($organization_data['address']).', '.filter_string($organization_data['postcode']).', '.filter_string($organization_data['country_name']); ?>
<br />
<strong>Contact: </strong> <?php echo filter_string($organization_data['contact_no']); ?>
