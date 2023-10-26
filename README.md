<p align="center">
    <a href="https://github.com/yii2-extensions/imagine" target="_blank">
        <img src="https://www.yiiframework.com/image/yii_logo_light.svg" height="100px;">
    </a>
    <h1 align="center">Imagine</h1>
    <br>
</p>

<p align="center">
    <a href="https://www.php.net/releases/8.1/en.php" target="_blank">
        <img src="https://img.shields.io/badge/PHP-%3E%3D8.1-787CB5" alt="php-version">
    </a>
    <a href="https://github.com/yiisoft/yii2/tree/2.2" target="_blank">
        <img src="https://img.shields.io/badge/Yii2%20version-2.2-blue" alt="yii2-version">
    </a>
    <a href="https://github.com/yii2-extensions/imagine/actions/workflows/build.yml" target="_blank">
        <img src="https://github.com/yii2-extensions/imagine/actions/workflows/build.yml/badge.svg" alt="PHPUnit">
    </a>
    <a href="https://codecov.io/gh/yii2-extensions/imagine" target="_blank"> 
        <img src="https://codecov.io/gh/yii2-extensions/imagine/graph/badge.svg?token=Sx1GlGe8n2" alt="Codecov"> 
    </a>    
    <a href="https://github.com/yii2-extensions/imagine/actions/workflows/static.yml" target="_blank">
        <img src="https://github.com/yii2-extensions/gii/actions/workflows/static.yml/badge.svg" alt="PHPStan">
    </a>
    <a href="https://github.com/yii2-extensions/imagine/actions/workflows/static.yml" target="_blank">
        <img src="https://img.shields.io/badge/PHPStan%20level-3-blue" alt="PHPStan level">
    </a>
    <a href="https://github.styleci.io/repos/708447136?branch=main" target="_blank">
        <img src="https://github.styleci.io/repos/708447136/shield?branch=main" alt="Code style">
    </a>        
</p>

## Installation

The preferred way to install this extension is through [composer](https://getcomposer.org/download/).

Either run

```
php composer.phar require --dev --prefer-dist yii2-extensions/imagine
```

or add

```
"yii2-extensions/imagine": "dev-main"
```

to the require-dev section of your `composer.json` file.

## Usage

This extension is a wrapper to the [Imagine](https://imagine.readthedocs.org/) and also adds the most commonly used
image manipulation methods.

The following example shows how to use this extension:

```php
use yii\imagine\Image;

// frame, rotate and save an image
Image::frame('path/to/image.jpg', 5, '666', 0)
    ->rotate(-8)
    ->save('path/to/destination/image.jpg', ['jpeg_quality' => 50]);
```


## Testing

[Check the documentation testing](/docs/testing.md) to learn about testing.

## Our social networks

[![Twitter](https://img.shields.io/badge/twitter-follow-1DA1F2?logo=twitter&logoColor=1DA1F2&labelColor=555555?style=flat)](https://twitter.com/Terabytesoftw)

## License

The MIT License. Please see [License File](LICENSE.md) for more information.
