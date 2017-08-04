<?php

namespace Invetico\BoabCmsBundle\Shortcode;

use Invetico\BoabCmsBundle\Shortcode\BaseShortcode;

/**
 * Format and Generate Currency symbols
 */
class Currency extends BaseShortcode
{
    /**
     * @var string
     */
    protected $name = 'currency';
 
    /**
     * @var array
     */
    protected $attributes = ['amount'=>0,'symbol'=>'$'];
 
    /**
     * @param string|null $content
     * @param array $atts
     * @return string
     */
    public function handle($content = null, array $atts=[])
    {
        $amount = number_format($atts['amount'], 2, '.', ',');
        return sprintf('%s%s',$atts['symbol'],$amount);
    }
}