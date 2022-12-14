<?php

use aditiya\easyfilemanager\models\Easyfilemanager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel aditiya\easyfilemanager\models\EasyfilemanagerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('easy_file_manager', 'Easyfilemanagers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="easyfilemanager-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('easy_file_manager', 'Create Easyfilemanager'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'key',
            [
                'label'=>'Name / Url',
                'attribute' => 'name',
                'format' => 'raw',
                'value'=> function($model){
                    return '<a href="'.$model->getFileUrl().'" data-pjax="0">'.$model->name.'</a>';
                }
            ],
            'extension',
            'category',
            'description:ntext',
            //'mimetype',
            //'roles:ntext',
            //'size',
            //'created_at',
            //'filepath',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Easyfilemanager $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'key' => $model->key]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
