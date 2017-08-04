<?php

namespace Invetico\BoabCmsBundle\Api\Normalizer;

use Invetico\BoabCmsBundle\Api\Serializer\SelfAwareNormalizerInterface;

class PhotoUploadSuccessNormalizer implements SelfAwareNormalizerInterface
{
	private $param;
	private $photo;

	public function __construct($param)
	{
		$this->param = $param;
	}

	public function normalize()
	{
		return array(
			"code"=>200,
			"status"=>'success',
			"message"=>'Photo Uploaded Successfully',
			"photo"=>[
				"caption" => $this->photo->getCaption(),
				"smallThumbnail" => $this->param['smallThumbnail'],
				"largeThumbnail" => $this->param['largeThumbnail'],
				"deletePath" => $this->photo->getDeletePath()
			]
		);
	}

	public function setPhoto($photo)
	{
		$this->photo = $photo;
	}
}