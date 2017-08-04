<?php

namespace Invetico\BoabCmsBundle\Shortcode;

use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;
use Bundle\GalleryBundle\Library\PhotoGallery;
use Invetico\BoabCmsBundle\View\TemplateInterface;

class SimpleGallery extends BaseShortcode
{
    private $template;
    
    /**
     * @var string
     */
    protected $name = 'simplegallery';

    protected $attributes = [];

    protected $defaultDirectory = 'simplegallery';
 

    public function __construct(TemplateInterface $template)
    {
        $this->template = $template;
    }
 
    /**
     * @param string|null $content
     * @param array $atts
     * @return string
     */
    public function handle($content = null, array $atts=[])
    {
        $photoGallery = new PhotoGallery();

        $album = isset($atts['album']) ? $atts['album']:'';
        $limit = isset($atts['limit']) ? $atts['limit']:0;

        $albumDir =  $photoGallery->getBaseRoot().'/'.$this->defaultDirectory."/$album";
        if(!is_dir($albumDir) || !is_writable($albumDir)){
            throw new \InvalidArgumentException(sprintf('The album directory %s does not exists or is not writable', $albumDir));
        }

        $photoGallery->setCacheFile(sprintf('%s/cache.txt',$albumDir))
                    ->setImageLocation(sprintf('%s/%s/images', $this->defaultDirectory, $album))
                    ->setThumbnailLocation(sprintf('%s/%s/thumbs', $this->defaultDirectory, $album))
                    ->setExtensions(array('jpg','png'))
                    ->setLimiter($limit);
        $photos = $photoGallery->getGallery();
        $view = $this->template->load('GalleryBundle:Widgets:page_gallery_widget');
        $view->photos = $photos;
        $view->title = isset($atts['title']) ? $atts['title']:'';
        return $view->render();
    }     

}