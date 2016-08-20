<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\persons\models\PersonContact */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-contact-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'person_id')->textInput() ?>

    <?= $form->field($model, 'prefix_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'relationship')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_alley')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_village')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_mu')->textInput() ?>

    <?= $form->field($model, 'address_road')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tambol_id')->textInput() ?>

    <?= $form->field($model, 'amphur_id')->textInput() ?>

    <?= $form->field($model, 'province_id')->textInput() ?>

    <?= $form->field($model, 'zip_code')->textInput() ?>

    <?= $form->field($model, 'tel_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'home_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('person', 'Create') : Yii::t('person', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
