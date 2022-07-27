<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\easy_file_manager\models\Easyfilemanager */

$this->title = Yii::t('easy_file_manager', 'Create Easyfilemanager');
$this->params['breadcrumbs'][] = ['label' => Yii::t('easy_file_manager', 'Easyfilemanagers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="easyfilemanager-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
