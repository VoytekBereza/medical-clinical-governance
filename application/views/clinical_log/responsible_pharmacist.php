<link rel="stylesheet" href="<?php echo SURL;?>assets/css/kod_pdf.css">
<div style="background-color:#FFF">
<div style="width:100%; font-family:Arial; ">
<div style="width:33%;float:left;"><h1></h1></div>
<!--<div style="width:33%; float:left; text-align:right"><img src="<?php echo SURL;?>assets/images/logo.jpg" width="110px;"/></div>
--></div>

<div style="width:30%; float:right;font-size:30px; color:#03769C; border-bottom:2px solid #03769C;"><strong>General Pharmaceutical Council</strong></div>
<div style="width:100%; font-family:Arial; ">
<div style="width:50%; float:left; font-size:50px; color:#007C5A">
  Responsible <br />pharmacist notice
</div>
</div>
</div>
<hr />
<br />
<div style="background-color:#FFF">
<p style="color:#007C5A; font-size:20px;">The responsible pharmacist is:</p>
<div style="border-left-style: solid; border-bottom-style: solid; border-right-style: solid; border-top-style: solid; border-left-width: thin; border-bottom-width: thin; border-right-width: thin; border-top-width: thin; background-color:#FFF; color:#333; font-size:24px; width:35%; height:25px; 	border-radius: 25px;">
  <p align="center"><strong><?php echo ucwords($get_user_details['user_full_name']);?></strong></p>
</div>

<p style="color:#007C5A; font-size:20px;">Their registration number is:</p>

<div style="border-left-style: solid; border-bottom-style: solid; border-right-style: solid; border-top-style: solid; border-left-width: thin; border-bottom-width: thin; border-right-width: thin; border-top-width: thin; background-color:#FFF; color:#333; font-size:24px; width:35%; height:25px; 	border-radius: 25px;">
  <p align="center"><strong><?php echo $get_user_details['registration_no'];?></strong></p>
</div>

<p style="color:#007C5A; font-size:20px;">At this time, the above named person is the pharmacist in charge of this pharmacy.</p>

</div>

