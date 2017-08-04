<?php
namespace Invetico\BoabCmsBundle\Validation\Form;

use Invetico\BoabCmsBundle\Validation\ValidationInterface;
use Invetico\BoabCmsBundle\Validation\FormValidationInterface;
use Invetico\BoabCmsBundle\Validation\DataContextInterface;

class Photo implements FormValidationInterface
{
    public function register(ValidationInterface $validation)
	{
        $validation->add('photo_caption','Product Caption',function(DataContextInterface $e){

            $e->isRequire();
        });

        $validation->add('thumbnail', 'Thumbnail',function(DataContextInterface $e){

        	$e->isRequire()
        	  ->isValidFile(['png','jpg']);

        });


	}
}