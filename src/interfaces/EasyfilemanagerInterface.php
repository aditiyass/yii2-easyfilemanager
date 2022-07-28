<?php

namespace aditiya\easyfilemanager\interfaces;

use aditiya\easyfilemanager\models\Easyfilemanager;

/**
 * Trait EasyfilemanagerTrait
 * To use in model
 *
 * @package aditiya\easyfilemanager\traits
 */
interface EasyfilemanagerInterface
{
    /**
     * @return string Url of file.
     */
    public function getFileUrl();

    /**
     * @return string|boolean key, or whether file is successfully uploaded or not
     */
    public function uploadFile();

    /**
     * @return int|false whether file is successfully deleted or not
     */
    public function deleteFile();
}
