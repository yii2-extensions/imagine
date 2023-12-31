<?php

declare(strict_types=1);

namespace yiiunit\imagine\base;

use Yii;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use Imagine\Image\ImageInterface;
use yii\base\InvalidConfigException;
use yiiunit\imagine\TestCase;

abstract class AbstractImage extends TestCase
{
    protected $imageFile;
    protected $watermarkFile;
    protected $runtimeTextFile;
    protected $runtimeWatermarkFile;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        FileHelper::createDirectory(Yii::getAlias('@yiiunit/imagine/runtime'));
        $this->imageFile = Yii::getAlias('@yiiunit/imagine/data/large.jpg');
        $this->watermarkFile = Yii::getAlias('@yiiunit/imagine/data/xparent.gif');
        $this->runtimeTextFile = Yii::getAlias('@yiiunit/imagine/runtime/image-text-test.png');
        $this->runtimeWatermarkFile = Yii::getAlias('@yiiunit/imagine/runtime/image-watermark-test.png');
        parent::setUp();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        @unlink($this->runtimeTextFile);
        @unlink($this->runtimeWatermarkFile);
    }

    public function testText(): void
    {
        if (!$this->isFontTestSupported()) {
            $this->markTestSkipped('Skipping ImageGdTest Gd not installed');
        }

        $fontFile = Yii::getAlias('@yiiunit/imagine/data/GothamRnd-Light.otf');

        $img = Image::text($this->imageFile, 'Yii-2 Image', $fontFile, [0, 0], [
            'size' => 12,
            'color' => '000',
        ]);

        $img->save($this->runtimeTextFile);
        $this->assertFileExists($this->runtimeTextFile);
    }

    public function testCrop(): void
    {
        $point = [20, 20];
        $img = Image::crop($this->imageFile, 100, 100, $point);

        $this->assertEquals(100, $img->getSize()->getWidth());
        $this->assertEquals(100, $img->getSize()->getHeight());
    }

    public function testWatermark(): void
    {
        $img = Image::watermark($this->imageFile, $this->watermarkFile);
        $img->save($this->runtimeWatermarkFile);
        $this->assertFileExists($this->runtimeWatermarkFile);
    }

    public function testFrame(): void
    {
        $frameSize = 5;
        $original = Image::getImagine()->open($this->imageFile);
        $originalSize = $original->getSize();
        $img = Image::frame($this->imageFile, $frameSize, '666', 0);
        $size = $img->getSize();

        $this->assertEquals($size->getWidth(), $originalSize->getWidth() + ($frameSize * 2));
    }

    public function testThumbnail(): void
    {
        // THUMBNAIL_OUTBOUND mode.
        $img = Image::thumbnail($this->imageFile, 120, 120);

        $this->assertEquals(120, $img->getSize()->getWidth());
        $this->assertEquals(120, $img->getSize()->getHeight());

        // THUMBNAIL_INSET mode. Missing thumbnail part is filled with background so dimensions are exactly
        // the ones specified.
        $img = Image::thumbnail($this->imageFile, 120, 120, ImageInterface::THUMBNAIL_INSET);

        $this->assertEquals(120, $img->getSize()->getWidth());
        $this->assertEquals(120, $img->getSize()->getHeight());

        // Height omitted and is calculated based on original image aspect ratio regardless of the mode.
        $img = Image::thumbnail($this->imageFile, 120, null);

        $this->assertEquals(120, $img->getSize()->getWidth());
        $this->assertEquals(62, $img->getSize()->getHeight());

        $img = Image::thumbnail($this->imageFile, 120, null, ImageInterface::THUMBNAIL_INSET);

        $this->assertEquals(120, $img->getSize()->getWidth());
        $this->assertEquals(62, $img->getSize()->getHeight());

        // Width omitted and is calculated based on original image aspect ratio regardless of the mode.
        $img = Image::thumbnail($this->imageFile, null, 120);

        $this->assertEquals(234, $img->getSize()->getWidth());
        $this->assertEquals(120, $img->getSize()->getHeight());

        $img = Image::thumbnail($this->imageFile, null, 120, ImageInterface::THUMBNAIL_INSET);

        $this->assertEquals(234, $img->getSize()->getWidth());
        $this->assertEquals(120, $img->getSize()->getHeight());
    }

    public function testThumbnailWithUpscaleFlag(): void
    {
        // THUMBNAIL_OUTBOUND mode.
        $img = Image::thumbnail($this->imageFile, 700, 700, ImageInterface::THUMBNAIL_OUTBOUND | ImageInterface::THUMBNAIL_FLAG_UPSCALE);

        $this->assertEquals(700, $img->getSize()->getWidth());
        $this->assertEquals(700, $img->getSize()->getHeight());

        // THUMBNAIL_INSET mode. Missing thumbnail part is filled with background so dimensions are exactly
        // the ones specified.
        $img = Image::thumbnail($this->imageFile, 700, 700, ImageInterface::THUMBNAIL_INSET | ImageInterface::THUMBNAIL_FLAG_UPSCALE);

        $this->assertEquals(700, $img->getSize()->getWidth());
        $this->assertEquals(700, $img->getSize()->getHeight());

        // Height omitted and is calculated based on original image aspect ratio regardless of the mode.
        $img = Image::thumbnail($this->imageFile, 840, null, ImageInterface::THUMBNAIL_OUTBOUND | ImageInterface::THUMBNAIL_FLAG_UPSCALE);

        $this->assertEquals(840, $img->getSize()->getWidth());
        $this->assertEquals(432, $img->getSize()->getHeight());

        $img = Image::thumbnail($this->imageFile, 840, null, ImageInterface::THUMBNAIL_INSET | ImageInterface::THUMBNAIL_FLAG_UPSCALE);

        $this->assertEquals(840, $img->getSize()->getWidth());
        $this->assertEquals(432, $img->getSize()->getHeight());

        // Width omitted and is calculated based on original image aspect ratio regardless of the mode.
        $img = Image::thumbnail($this->imageFile, null, 540, ImageInterface::THUMBNAIL_OUTBOUND | ImageInterface::THUMBNAIL_FLAG_UPSCALE);

        $this->assertEquals(1050, $img->getSize()->getWidth());
        $this->assertEquals(540, $img->getSize()->getHeight());

        $img = Image::thumbnail($this->imageFile, null, 540, ImageInterface::THUMBNAIL_INSET | ImageInterface::THUMBNAIL_FLAG_UPSCALE);

        $this->assertEquals(1050, $img->getSize()->getWidth());
        $this->assertEquals(540, $img->getSize()->getHeight());
    }

    /**
     * @dataProvider \yiiunit\imagine\providers\Data::resize
     */
    public function testResize($width, $height, $keepAspectRatio, $allowUpscaling, $newWidth, $newHeight): void
    {
        $img = Image::resize($this->imageFile, $width, $height, $keepAspectRatio, $allowUpscaling);

        $this->assertEquals($newWidth, $img->getSize()->getWidth());
        $this->assertEquals($newHeight, $img->getSize()->getHeight());
    }

    public function testShouldThrowExceptionOnDriverInvalidArgument(): void
    {
        Image::setImagine(null);
        Image::$driver = 'fake-driver';

        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage('Unknown driver: fake-driver');
        Image::getImagine();
    }

    public function testIfAutoRotateThrowsException(): void
    {
        $img = Image::thumbnail($this->imageFile, 120, 120);
        $this->assertInstanceOf(ImageInterface::class, Image::autorotate($img));
    }

    abstract protected function isFontTestSupported();
}
