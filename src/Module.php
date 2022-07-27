<?php

namespace aditiya\easyfilemanager;

/**
 * easy_file_manager module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'aditiya\easyfilemanager\controllers';
    public $dbConnection = 'db';
    public $uploadfilepath = '@app/uploads/efm';
    public $usedemo = false;
    public $defaultUrl = '/efm/file/get';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    /**
     * @return string
     */
    public function getDb()
    {
        return \Yii::$app->get($this->dbConnection);
    }
}
