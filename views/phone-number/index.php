<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Phone Numbers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="phone-number-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Phone Number', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'country_id',
            'number',
            'verification_code',
            // 'verified',
            // 'active',
            // 'created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
