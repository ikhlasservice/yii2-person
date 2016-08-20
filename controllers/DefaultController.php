<?php

namespace ikhlas\persons\controllers;

use Yii;
use ikhlas\persons\models\Person;
use ikhlas\persons\models\PersonSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use ikhlas\persons\models\LocalProvince;
use ikhlas\persons\models\LocalAmphur;
use ikhlas\persons\models\LocalTambol;
use yii\helpers\ArrayHelper;
use backend\modules\image\models\Image;
use yii\web\UploadedFile;

/**
 * DefaultController implements the CRUD actions for Person model.
 */
class DefaultController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Person models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Person model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Person();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Person model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Person model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Person model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Person::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    #########################################################################################
    #########################################################################################
    #########################################################################################
    #########################################################################################

    public function actionGetAmphur() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $province_id = $parents[0];
                $out = $this->getAmphur($province_id);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionGetTambol() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $province_id = empty($ids[0]) ? null : $ids[0];
            $amphur_id = empty($ids[1]) ? null : $ids[1];
            if ($province_id != null) {
                $data = $this->getTambol($amphur_id);
                echo Json::encode(['output' => $data, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    protected function getAmphur($id) {
        $datas = LocalAmphur::find()->where(['province_id' => $id])->all();
        return $this->MapData($datas, 'id', 'name');
    }

    protected function getTambol($id) {
        $datas = LocalTambol::find()->where(['amphur_id' => $id])->all();
        return $this->MapData($datas, 'id', 'name');
    }

    protected function MapData($datas, $fieldId, $fieldName) {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }

    public function actionUploadAjax($id) {
        Yii::$app->controller->enableCsrfValidation = false;
        $this->uploadSingleFile($id);
    }

    private function uploadSingleFile($id) {
        $file = [];
        $json = '';
        $img = Yii::$app->img;
        //try {
        $upload_folder = Yii::$app->request->post('upload_folder');
        $UploadedFile = UploadedFile::getInstancesByName('Image[name_file]');
//        print_r($_FILES);
//        var_dump($UploadedFile);
//        //var_dump(Yii::$app->request->post);
//        exit();
        $model = $this->findModel($id);
        if ($UploadedFile !== null && $UploadedFile) {
//                 print_r($UploadedFile);
//                 exit();
            $img->CreateDir($upload_folder);
            $pathFile = $img->getUploadPath() . $upload_folder;

            $file = $UploadedFile[0];
            $oldFileName = $file->basename . '.' . $file->extension;
            $newFileName = md5($file->basename . time()) . '.' . $file->extension;


            if ($file->saveAs($pathFile . '/' . $newFileName)) {
                if ($model->img_id) {
                    @unlink($pathFile . '/' . $model->img_id);
                    @unlink($pathFile . '/thumbnail/' . $model->img_id);
                    Image::findOne($model->img_id)->delete();
                }

                $image = Yii::$app->image->load($pathFile . '/' . $newFileName);
                
                $image->resize(500, 500);
                $image->crop(400, 400);
                $image->save($pathFile . '/' . $newFileName);

                $image = Yii::$app->image->load($pathFile . '/' . $newFileName);
                $image->resize(300, 300);
                $image->save($pathFile . '/thumbnail/' . $newFileName);

                $TbImages = new Image();
                $TbImages->id = $newFileName;
                $TbImages->name_file = $oldFileName;
                $TbImages->type_file = $file->extension;
                $TbImages->path_file = $upload_folder;
                $TbImages->create_at = time();
                $TbImages->temp = '1';
                $TbImages->create_by = Yii::$app->user->id;

                if ($TbImages->save()) {
                    $img_id = $TbImages->id;


                    $model->img_id = $TbImages->id;
                    $model->save(false);
                    $path = $img->getUploadUrl($TbImages->path_file);
                    echo json_encode(['success' => 'true', 'path' => $path, 'files' => $img_id]);
                } else {

                    echo json_encode(['success' => 'false', 'eror' => $TbImages->getErrors()]);
                }
            }
        } else {
            echo json_encode(['success' => 'false', 'error' => $UploadedFile]);
        }
//        } catch (Exception $e) {
//            echo json_encode(['success' => 'false','error'=>$UploadedFile]);
//        }
        //echo $json;
    }

}
