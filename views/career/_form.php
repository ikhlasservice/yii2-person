<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\persons\models\PersonCareer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-career-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'person_id')->textInput() ?>

    <?= $form->field($model, 'career_id')->textInput() ?>

    <?= $form->field($model, 'career_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'working_age')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'workplace_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'workplace_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'workplace_village')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'workplace_noRoom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'workplace_class')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'workplace_mu')->textInput() ?>

    <?= $form->field($model, 'workplace_alley')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'workplace_road')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tambol_id')->textInput() ?>

    <?= $form->field($model, 'amphur_id')->textInput() ?>

    <?= $form->field($model, 'province_id')->textInput() ?>

    <?= $form->field($model, 'zip_code')->textInput() ?>

    <?= $form->field($model, 'workplace_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'workplace_fax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'salary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'income_other')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'expenses')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('person', 'Create') : Yii::t('person', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
