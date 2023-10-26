<?php

declare(strict_types=1);

namespace yiiunit\imagine\providers;

final class Data
{
    public static function resize(): array
    {
        // [width, height, keepAspectRatio, allowUpscaling, newWidth, newHeight]
        return [
            'Height and width set. Image should keep aspect ratio.' =>
                [350, 350, true, false, 350, 180],
            'Height and width set. Image should be resized to exact dimensions.' =>
                [350, 350, false, false, 350, 350],
            'Height omitted and is calculated based on original image aspect ratio.' =>
                [350, null, true, false, 350, 180],
            'Width omitted and is calculated based on original image aspect ratio.' =>
                [null, 180, true, false, 350, 180],
            'Upscaling' =>
                [800, 800, true, true, 800, 411],
        ];
    }
}
