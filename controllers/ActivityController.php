<?php

namespace app\controllers;

use app\models\ActivityUser;
use stdClass;
use Throwable;
use Yii;
use app\models\Activity;
use app\models\ActivitySearch;
use yii\db\StaleObjectException;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ActivityController implements the CRUD actions for Activity model.
 */
class ActivityController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            [
                'class' => ContentNegotiator::className(),
                'only' => ['city-list', 'area-list', 'province-list'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]

        ];
    }

    /**
     * Lists all Activity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ActivitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Activity model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'type' => 2
        ]);
    }

    /**
     * Creates a new Activity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Activity();
        $activityUserModel = new ActivityUser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $activityUserModel->activityId = $model->activityId;
            if ($activityUserModel->load(Yii::$app->request->post()) && $activityUserModel->save()) {
                return $this->redirect(['view', 'id' => $model->activityId]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'activityUserModel' => $activityUserModel
        ]);
    }

    /**
     * Updates an existing Activity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $activityUserModel = ActivityUser::findOne(['activityId' => $id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->activityId]);
        }

        return $this->render('update', [
            'model' => $model,
            'activityUserModel' => $activityUserModel
        ]);
    }

    /**
     * Deletes an existing Activity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Activity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Activity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Activity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionProvinceList()
    {
        $result = new stdClass();

        $result->iRet = 0;
        $result->sMsg = 'success';
        $result->data = Activity::getProvinceList();

        return $result;
    }

    public function actionCityList()
    {
        $pId = Yii::$app->request->post('pId');

        $result = new stdClass();
        $result->iRet = 0;
        $result->sMsg = 'success';
        $result->data = Activity::getCityList($pId);

        return $result;
    }

    public function actionAreaList()
    {
        $result = new stdClass();

//        $pId = Yii::$app->request->post('pId');
        $cId = Yii::$app->request->post('cId');

        $result->iRet = 0;
        $result->sMsg = 'success';
        $result->data = Activity::getAreaList($cId);

        return $result;
    }
}
