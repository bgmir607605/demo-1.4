<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProblemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Problems';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="problem-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Problem', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'timestamp',
            'name',
            'description:ntext',
            // 'idUser',
            // 'idCategory',
            [
                'attribute' => 'idCategory',
                'value' => 'category.name',
            ],
            'status',
            //'photoBefore',
            //'photoAfter',

            [
                'class' => 'yii\grid\ActionColumn', 
                'template' => '{view} {delete}',
            ],
        ],
    ]); ?>


</div>
