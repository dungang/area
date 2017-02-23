<?php

namespace huluwa\area;

/**
 * ajax module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'huluwa\area\controllers';

    public $defaultRoute = 'info';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}
