<?php

namespace aditiya\easyfilemanager\traits;

use aditiya\easyfilemanager\Module;

/**
 * Trait ModuleTrait
 *
 * @property-read Module $module
 * @package aditiya\easyfilemanager\traits
 */
trait ModuleTrait
{
    /**
     * @return Module
     */
    public function getModule()
    {
        return \Yii::$app->getModule('efm');
    }

    /**
     * @return string
     */
    public static function getDb()
    {
        return \Yii::$app->getModule('efm')->getDb();
    }
}
