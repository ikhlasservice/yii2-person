<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\persons\models\PersonCareer */

$this->title = $model->person_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('person', 'Person Careers'), 'url' => ['index']];
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
            'career_id',
            'career_title',
            'position_title',
            'working_age',
            'workplace_title',
            'workplace_no',
            'workplace_village',
            'workplace_noRoom',
            'workplace_class',
            'workplace_mu',
            'workplace_alley',
            'workplace_road',
            'tambol_id',
            'amphur_id',
            'province_id',
            'zip_code',
            'workplace_phone',
            'workplace_fax',
            'salary',
            'income_other:ntext',
            'expenses:ntext',
        ],
    ]) ?>


    </div><!--box-body pad-->
 </div><!--box box-info-->
