

                <?php foreach($this->collection as $member):?>
	                <div class="col-md-3 col-sm-6 col-xs-12 column team-member">
	                    <article class="column-inner hvr-float-shadow">
	                        <figure class="member-cover">
	                            <img src="<?php echo BASE_URL. $member->getDefaultThumbnailPath();?>" alt="<?php echo $member->getFullName();?>" title="<?php echo $member->getFullName();?>">
	                        </figure>
	                        <div class="lower-part">
	                            <h3><?php echo $member->getFullName();?></h3>
	                            <div class="info">
	                                <p><strong>Constituency</strong> : <?php echo $member->getConstituency();?></p>
	                              
	                            </div>
	                        </div>
	                    </article>
	                </div>
				<?php endforeach;?>