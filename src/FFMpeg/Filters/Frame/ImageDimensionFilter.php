<?php

namespace FFMpeg\Filters\Frame;

use FFMpeg\Exception\RuntimeException;
use FFMpeg\Media\Frame;

class ImageDimensionFilter implements FrameFilterInterface
{
    /** @var \FFMpeg\Coordinate\Dimension */
    private $dimension;

    /** @var integer */
    private $priority;

    public function __construct($priority = 0)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * {@inheritdoc}
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    public function setDimension(\FFMpeg\Coordinate\Dimension $dimension) {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Frame $frame)
    {
        $dimensions = null;
        $commands = array();

        foreach ($frame->getVideo()->getStreams() as $stream) {
            if ($stream->isVideo()) {
                try {
                    $commands[] = '-s';
                    $commands[] = $this->dimension->getWidth() . 'x' . $this->dimension->getHeight();
                    break;
                } catch (RuntimeException $e) {

                }
            }
        }

        return $commands;
    }
}