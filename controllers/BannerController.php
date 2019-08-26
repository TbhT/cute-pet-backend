<?php

namespace app\controllers;

use app\models\UploadForm;
use stdClass;
use Yii;
use app\models\Banner;
use app\models\BannerSearch;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * BannerController implements the CRUD actions for Banner model.
 */
class BannerController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'index', 'view', 'update', 'delete'],
                        'roles' => ['admin']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['j-get'],
                        'roles' => ['?', '@']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            [
                'class' => ContentNegotiator::className(),
                'only' => ['j-get'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }

    /**
     * 获取所有banner图
     * @return stdClass
     */
    public function actionJGet()
    {
        $banners = Banner::findAll(['status' => 1]);
        $result = new stdClass();
        $result->iRet = 0;
        $result->msg = 'success';

        if ($banners) {
            $result->data = $banners;
        } else {
            $result->data = [];
        }

        return $result;
    }

    /**
     * Lists all Banner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BannerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Banner model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Banner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Banner();
        $pictureForm = new UploadForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($pictureForm->upload()) {
                if ($pictureForm->path) {
                    $model->image = $pictureForm->path;
                }

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->bannerId]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'pictureForm' => $pictureForm
        ]);
    }

    /**
     * Updates an existing Banner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $pictureForm = new UploadForm();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($pictureForm->upload()) {
                $model->image = $pictureForm->path;
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->bannerId]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'pictureForm' => $pictureForm
        ]);
    }

    /**
     * Deletes an existing Banner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Banner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Banner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banner::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
