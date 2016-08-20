<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('person', 'Person Careers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
     <!-- <h3 class='box-title'><?= Html::encode($this->title) ?></h3>-->
    </div><!--box-header -->
    
    <div class='box-body pad'>
        
    <p>
        <?= Html::a(Yii::t('person', 'Create Person Career'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'person_id',
            'career_id',
            'career_title',
            'position_title',
            'working_age',
            // 'workplace_title',
            // 'workplace_no',
            // 'workplace_village',
            // 'workplace_noRoom',
            // 'workplace_class',
            // 'workplace_mu',
            // 'workplace_alley',
            // 'workplace_road',
            // 'tambol_id',
            // 'amphur_id',
            // 'province_id',
            // 'zip_code',
            // 'workplace_phone',
            // 'workplace_fax',
            // 'salary',
            // 'income_other:ntext',
            // 'expenses:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


    </div><!--box-body pad-->
 </div><!--box box-info-->
