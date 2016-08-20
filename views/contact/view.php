<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model ikhlas\persons\models\PersonContact */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('person', 'Person Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
     <!-- <h3 class='box-title'><?= Html::encode($this->title) ?></h3>-->
    </div><!--box-header -->
    
    <div class='box-body pad'>

    <p>
        <?= Html::a(Yii::t('person', 'Update'), ['update', 'id' => $model->person_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('person', 'Delete'), ['delete', 'id' => $model->person_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('person', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'person_id',
            'prefix_id',
            'name',
            'surname',
            'relationship',
            'address_no',
            'address_alley',
            'address_village',
            'address_mu',
            'address_road',
            'tambol_id',
            'amphur_id',
            'province_id',
            'zip_code',
            'tel_number',
            'home_phone',
            'email:email',
        ],
    ]) ?>


    </div><!--box-body pad-->
 </div><!--box box-info-->
