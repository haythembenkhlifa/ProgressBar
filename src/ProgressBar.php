<?php

namespace Haythem\ProgressBar;

use Laravel\Nova\Fields\Field;

class ProgressBar extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'progress-bar';

    /**
     * Tells the client side component which channel to broadcast on
     * @param $callEvery
     * @return Element
     */
    public function callEvery($callEvery = 2000)
    {
        return $this->withMeta(["callEvery" => $callEvery]);
    }
    public function endPoint($endPoint = "")
    {
        return $this->withMeta(["endPoint" => $endPoint]);
    }
    public function markAsDone($markAsDone = false)
    {
        return $this->withMeta(["markAsDone" => $markAsDone]);
    }
}
