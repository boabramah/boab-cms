

<?php foreach($this->collection as $content):?>
<div class="col-sm-4">
    <div class="ts-wrapper">
        <article class="ts-service-style3 ">
            <a href="#"><figure><img src="[asset path=<?php echo $content->getThumbnailUrlPath();?>]" class="img-responsive" alt="<?php echo $content->getTitle();?>"></figure></a>
            <a href="#"><h4><?php echo $content->getTitle();?></h4></a>
            <p><?php echo word_limiter($content->getSummary(),150);?></p>
            <a class="ts-style-button small" href="<?php echo $this->generate($content);?>">Read More</a>
        </article>
    </div>
</div>
<?php endforeach;?>

