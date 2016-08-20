<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\persons\models\Person */

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('person', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
     <!-- <h3 class='box-title'><?= Html::encode($this->title) ?></h3>-->
    </div><!--box-header -->

    <div class='box-body pad'>

        <p>
            <?= Html::a(Yii::t('person', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a(Yii::t('person', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('person', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ])
            ?>
        </p>

        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id_card',
                'fullname',
                //'surname_en',
                'birthday',
                [
                    'attribute' => 'sex',
                    'value' => $model->sexLabel
                ],
                'address_id',
                'contact_address_id',
                'telephone',
                'home_phone',
                'email:email',
                'facebook',
                'doc_delivery',
                'img_id',
                'created_at',
                'updated_at',
            ],
        ])
        ?>


    </div><!--box-body pad-->
</div><!--box box-info-->
