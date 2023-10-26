<?php

namespace yiiunit\imagine;

use yii\imagine\Image;
use yiiunit\imagine\base\AbstractImage;

/**
 * @group gd
 */
class ImageGdTest extends AbstractImage
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        if (!function_exists('gd_info')) {
            $this->markTestSkipped('Skipping ImageGdTest, Gd not installed');
        } else {
            Image::setImagine(null);
            Image::$driver = Image::DRIVER_GD2;
            parent::setUp();
        }
    }

    protected function isFontTestSupported()
    {
        $infos = gd_info();

        return isset($infos['FreeType Support']) ? $infos['FreeType Support'] : false;
    }
}
