<?php

namespace Invetico\BoabCmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Invetico\BoabCmsBundle\Entity\Content;
use Invetico\BoabCmsBundle\Entity\FileUploadInterface;
use Invetico\BoabCmsBundle\Model\SeoInterface;
use Invetico\BoabCmsBundle\Model\SeoTrait;
/**
 * Article
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="Invetico\BoabCmsBundle\Repository\ContentRepository")
 */
class Article extends Content implements ArticleInterface,FileUploadInterface, SeoInterface
{
    use SeoTrait;

    private $discr = 'article';

    protected $dateformat = 'l jS F Y';

    public function getContentTypeId()
    {
        return 'article';
    }

    public function getContentTypeLabel()
    {
        return 'Article';
    }

    public function getContentTypeDescription()
    {
        return 'Use for creating content like news or blog';
    }

}
