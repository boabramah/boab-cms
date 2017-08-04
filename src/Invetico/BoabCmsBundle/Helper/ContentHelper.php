<?php

namespace Invetico\BoabCmsBundle\Helper;

trait ContentHelper
{

    protected function getContentUploadedImages($content)
    {
        $thumbnails = [];
        if (!is_dir($content->getUploadRoot())) {
            return [];
        }
        $this->finder->files()->in($content->getUploadRoot())->exclude('thumb');
        $coverThumbnail = $content->getThumbnail();
        foreach ($this->finder as $file) {
            if ($coverThumbnail == $file->getRelativePathname()) {
                array_unshift($thumbnails,$content->getThumbnailUrlRoot().'/'.$file->getRelativePathname());
                continue;
            }
            $thumbnails[]=$content->getThumbnailUrlRoot().'/'.$file->getRelativePathname();
        }

        return $thumbnails;
    }

    protected function isFurnished($state='')
    {
        $option = '';
        foreach (['1'=>'Yes','2'=>'No'] as $key=>$value) {
            $option .= '<option value="' . $key. '"';
                if ($state == $key) {
                    $option .= ' selected = "selected"';
                }
            $option .= '>' . $value . '</option>';
        }

        return $option;
    }

    protected function isNumberOf($number='')
    {
        $option = '';
        for ($i=1; $i < 10; $i++) {
            $option .= '<option value="' . $i. '"';
                if ($number == $i) {
                    $option .= ' selected = "selected"';
                }
            $option .= '>' . $i . '</option>';
        }

        return $option;
    }

    public function generateHash($data)
    {
        $random = openssl_random_pseudo_bytes(18);
        $salt = sprintf('$2y$%02d$%s',13,substr(strtr(base64_encode($random), '+', '.'), 0, 22));

        return crypt($data, $salt);
    }

    public function getTimeElapsed($from, $to, $full = false)
    {
        $from = new \DateTime($from);
        $to = new \DateTime($to);
        $diff = $to->diff($from);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = ['y' => 'year','m' => 'month','w' => 'week','d' => 'day','h' => 'hour','i' => 'minute','s' => 'second',];

        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }

        return $string ? implode(', ', $string) . ' ago' : 'just now';
}
}
