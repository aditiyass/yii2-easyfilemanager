<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model aditiya\easyfilemanager\models\Easyfilemanager */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="easyfilemanager-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'extension')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'mimetype')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'roles')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'size')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'filepath')->textInput(['maxlength' => true]) ?> -->

    <?= $form->field($model, 'file')->fileInput()->label('Upload Demo') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('easy_file_manager', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
