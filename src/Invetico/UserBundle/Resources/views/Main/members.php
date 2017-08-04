

	<section class="four-column team-section">
        <div class="auto-container">
            <div class="sec-title">
                <h2>Proud Registered <strong>Member</strong></h2>
            </div>
                        
            <div class="row clearfix">
                <?php foreach($this->collection as $member):?>
	                <div class="col-md-3 col-sm-6 col-xs-12 column team-member">
	                    <article class="column-inner hvr-float-shadow">
	                        <figure class="member-cover">
	                            <img src="<?php echo BASE_URL.$member->getDefaultThumbnailPath();?>" alt="" title="Volunteer">
	                        </figure>
	                        <div class="lower-part">
	                            <h3><?php echo $member->getFullName();?></h3>
	                            <p><strong>Constituency</strong> : <?php echo $member->getConstituency();?></p>
	                        </div>
	                    </article>
	                </div>
			<?php endforeach;?>                
            </div>
        </div>
    </section>