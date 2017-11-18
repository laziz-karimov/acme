<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PhoneNumber */

$this->title = 'Create Phone Number';
$this->params['breadcrumbs'][] = ['label' => 'Phone Numbers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="phone-number-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
