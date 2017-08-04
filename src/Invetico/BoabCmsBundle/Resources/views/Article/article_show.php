

<div id="article-entry">
    <div class="img-wrapper">
    	<img class="img-responsive propertyImgRow" src="[asset path=<?php echo $this->content->getThumbnailUrlPath();?>]" alt="<?php echo $this->content->getTitle();?>">
    </div>
    <div class="propertyContent">
            <h1><?php echo $this->content->getTitle();?></h1>
            <span>POSTED BY <a href="#"><?php echo $this->content->getUser()->getFullName();?></a>, DATE: <a href="#"><?php echo $this->content->getDatePublished() ;?></a></span>
            <div class="body">
            	<?php echo $this->content->getBody();?>
            </div>
    </div>
</div>
<div class="comment-box">
    [commentbox id=comment]
</div>

