<!-- Header Carousel -->
<div id="full-video"><!--Video Section-->
  <section class="content-section video-section">
    <video width="300" height="150" id="video_background" poster="//" preload="auto" autoplay="autoplay" loop="loop">
      <source src="<?php echo VIDEOS?>homepagebackgroundvideo.mp4" type="video/mp4" />
      <source src="<?php echo VIDEOS?>homepagebackgroundvideo.ogg" type="video/ogg" />
      <source src="<?php echo VIDEOS?>homepagebackgroundvideo.webm" type="video/webm" />
    </video>
    <div class="pattern-overlay">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="myoverlay" style="width: 60%; margin: 0px auto; background: url('<?php echo IMAGES; ?>transbg.png') repeat; margin-top: 20px; padding: 15px 15px 15px 15px; position: relative;">
              <p><strong>Introducing, the all new...</strong> <img class="img-responsive" style="margin-top: -55px; margin-right: -20px; right: 0; position: absolute;" src="<?php echo IMAGES?>star.png" alt="" /></p>
              <p align="center"><img class="img-responsive" style="border: 0px;" src="<?php echo IMAGES; ?>TC_Logo.png" alt="" /></p>
              <p>Run your own autonomous travel clinic with over 20 paediatric, untethered, locum-enabled PGDs including Yellow Fever, Shingles and Chickenpox. Train with our freshly updated 2016 HD videos which includes 2hr+ of Mike Bereza setting up his travel clinic at Douglas Pharmacy and lectures on each disease state. Benefit from our prescriber phone support and our new online travel vaccine decision making tools. Buy now, start whenever you like!</p>
              <p></p>
              <p></p>
              <p align="right">
                <a href="<?php echo SURL?>pages/travel-core-2" class="btn btn-info" value="Watch the Video">Watch the Video</a>
                <a href="<?php echo SURL?>pages/travel-core-2" class="btn btn-success">More info</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--Video Section Ends Here--></div>
<div class="container" style="margin-top: 25px;">
  <div class="row">
    <div class="col-md-6">
      <h2>What do we do?</h2>
      We are UK based, digital health experts engineering&nbsp;solutions to aid&nbsp;clients in the rapidly evolving&nbsp;health IT sector. We have in house developers, who create beautifully crafted websites with associated cross platform mobile&nbsp;apps with the sole purpose of&nbsp;improving patient care. Interested about&nbsp;knowing more? Please do not hesitate to give to get in contact with us.<br />
      <br />
      <h3><strong>Call us now, on:</strong></h3>
      <h1 style="font-size: 60px;">020 8651 9930</h1>
    </div>
    <div class="col-md-6"><img class="img-responsive" src="<?php echo IMAGES?>devices.png" alt="" /></div>
  </div>
</div>
<div class="container" style="margin-top: 25px;">
  <div class="row">
    <div class="col-md-12">
      <div class="myimage">
        <div class="col-md-4 pull-right">
          <h2>About our practitioners</h2>
          <p>All our practitioners are highly skilled UK based, GMC doctors or GPhC pharmacists. We are united in one common goal, to make healthcare more effective for patients with medical conditions. Our products and services provide patients with meaningful health information and tools to help manage their condition whilst providing healthcare professionals real time access to a patients progress.</p>
          <p style="margin-right: 25px;" align="right">
            <a href="<?php echo SURL?>pages/about-us" class="btn btn-warning" type="button" >About Us </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<p> <?php echo filter_string($page_data['page_description']);?> </p>
