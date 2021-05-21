<h3 class="modal-title">Location</h3>
<hr />

<h4><?php echo $pharmacy['pharmacy_surgery_name'].', '.$pharmacy['postcode']; ?></h4>

<strong>Address: </strong> <?php echo filter_string($pharmacy['address']).', '.filter_string($pharmacy['postcode']).', '.filter_string($pharmacy['country_name']); ?>
<br />
<strong>Contact: </strong> <?php echo filter_string($pharmacy['contact_no']); ?>
