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

    public function barColor($barColor = "")
    {
        return $this->withMeta(["barColor" => $barColor]);
    }

    public function barBackgroundColor($barBackgroundColor = "")
    {
        return $this->withMeta(["barBackgroundColor" => $barBackgroundColor]);
    }

    public function initLabel($initLabel = "initializing")
    {
        return $this->withMeta(["initLabel" => $initLabel]);
    }

    public function processingLabel($processingLabel = "Processing")
    {
        return $this->withMeta(["processingLabel" => $processingLabel]);
    }

    public function doneLabel($doneLabel = "done")
    {
        return $this->withMeta(["doneLabel" => $doneLabel]);
    }

    public function animation($animation = true)
    {
        return $this->withMeta(["animation" => $animation]);
    }

    public function redirectWhenItsDone($redirectUrl = "",$newTab = false)
    {
        return $this->withMeta(["redirectUrl" => $redirectUrl,'redirectNewTab'=>$newTab]);
    }
    public function reloadWhenItsDone($reload = true)
    {
        return $this->withMeta(["reload" => $reload]);
    }

}
