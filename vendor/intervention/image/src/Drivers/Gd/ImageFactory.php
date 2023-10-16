<?php

namespace Intervention\Image\Drivers\Gd;

use Intervention\Image\Collection;
use Intervention\Image\Drivers\Gd\Frame;
use Intervention\Image\Drivers\Gd\Image;
use Intervention\Image\Interfaces\FactoryInterface;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Traits\CanHandleInput;

class ImageFactory implements FactoryInterface
{
    use CanHandleInput;

    public function newImage(int $width, int $height): ImageInterface
    {
        return new Image(
            new Collection([
                new Frame($this->newCore($width, $height))
            ])
        );
    }

    public function newAnimation(callable $callback): ImageInterface
    {
        $frames = new Collection();

        $animation = new class ($frames) extends ImageFactory
        {
            public function __construct(public Collection $frames)
            {
                //
            }

            public function add($source, float $delay = 1): self
            {
                $this->frames->push(
                    $this->handleInput($source)
                         ->getFrame()
                         ->setDelay($delay)
                );

                return $this;
            }
        };

        $callback($animation);

        return new Image($frames);
    }

    public function newCore(int $width, int $height)
    {
        $core = imagecreatetruecolor($width, $height);
        $color = imagecolorallocatealpha($core, 0, 0, 0, 127);
        imagefill($core, 0, 0, $color);
        imagesavealpha($core, true);

        return $core;
    }
}
