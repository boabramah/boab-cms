
            <?php foreach($this->collection as $content):?>    
                    
                    <div class="col-md-6">
                      <h3 class="b-type-b__title-2 ui-title-inner-2"><?php echo $content->getTitle();?></h3>
                      <div class="b-type-b__text">
                        <p><?php echo word_limiter($content->getSummary(),140);?></p>
                      </div>
                    </div>
                 
            <?php endforeach;?>                 

    