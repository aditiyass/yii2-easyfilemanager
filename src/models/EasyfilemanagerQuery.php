<?php

namespace aditiya\easyfilemanager\models;

/**
 * This is the ActiveQuery class for [[Easyfilemanager]].
 *
 * @see Easyfilemanager
 */
class EasyfilemanagerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Easyfilemanager[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Easyfilemanager|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
