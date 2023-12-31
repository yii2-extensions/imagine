<?php

declare(strict_types=1);

namespace yiiunit\imagine;

use yii\imagine\Image;
use yiiunit\imagine\base\AbstractImage;

/**
 * @group imagick
 */
class ImageImagickTest extends AbstractImage
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        if (!class_exists('Imagick')) {
            $this->markTestSkipped('Skipping ImageImagickTest, Imagick is not installed');
        } elseif (defined('HHVM_VERSION')) {
            $this->markTestSkipped('Imagine does not seem to support HHVM right now.');
        } else {
            Image::setImagine(null);
            Image::$driver = Image::DRIVER_IMAGICK;
            parent::setUp();
        }
    }

    protected function isFontTestSupported(): bool
    {
        return true;
    }
}
