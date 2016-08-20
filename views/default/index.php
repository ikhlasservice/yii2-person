<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\persons\models\PersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('person', 'People');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
     <!-- <h3 class='box-title'><?= Html::encode($this->title) ?></h3>-->
    </div><!--box-header -->

    <div class='box-body pad'>

        <p>
            <?= Html::a(Yii::t('person', 'Create Person'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'id',
                'id_card',
                'fullname',
                //'name',
                //'surname',
                // 'name_en',
                // 'surname_en',
                // 'birthday',
                // 'sex',
                // 'address_id',
                // 'contact_address_id',
                // 'telephone',
                // 'home_phone',
                // 'email:email',
                // 'facebook',
                // 'doc_delivery',
                // 'img_id',
                // 'created_at',
                // 'updated_at',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
        ?>


    </div><!--box-body pad-->
</div><!--box box-info-->
