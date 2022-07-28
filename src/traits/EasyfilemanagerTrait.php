<?php

namespace aditiya\easyfilemanager\traits;

use aditiya\easyfilemanager\models\Easyfilemanager;

/**
 * Trait EasyfilemanagerTrait
 * To use in model
 *
 * @package aditiya\easyfilemanager\traits
 */
trait EasyfilemanagerTrait
{
    /**
     * @return string Url of file.
     */
    public function getEfmFileUrl($key,$param = 'key')
    {
        $efm = Easyfilemanager::findOne(['key'=>$key]);
        if($efm){
            return $efm->getFileUrl($param);
        }
        return false;
    }

    /**
     * @return string|boolean key, whether file is successfully uploaded or not
     */
    public function uploadEfmByInstance($attribute)
    {
        $efm = new Easyfilemanager();
        return $efm->uploadByInstance($this,$attribute);
    }

    /**
     * @return int|false whether file is successfully deleted or not
     */
    public function deleteEfm($key){
        $efm = Easyfilemanager::findOne(['key'=>$key]);
        if($efm){
            return $efm->delete();
        }
        return false;
    }
}
