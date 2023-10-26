<?php

namespace yiiunit\imagine;

use yii\imagine\Image;
use yiiunit\imagine\base\AbstractImage;

/**
 * @group gmagick
 */
class ImageGmagickTest extends AbstractImage
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        if (!class_exists('Gmagick')) {
            $this->markTestSkipped('Skipping ImageGmagickTest, Gmagick is not installed');
        } else {
            Image::setImagine(null);
            Image::$driver = Image::DRIVER_GMAGICK;
            parent::setUp();
        }
    }

    protected function isFontTestSupported()
    {
        return true;
    }
}
