<?php

namespace app\controllers;

use app\models\ActivityUser;
use stdClass;
use Yii;
use app\models\Activity;
use app\models\ActivitySearch;
use yii\filters\AccessControl;
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
                    'delete' => ['POST']
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete', 'index', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'view'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['updateActivity'],
                        'roleParams' => function () {
                            return [
                                'activity' => Activity::findOne([
                                    'activityId' => Yii::$app->request->get('id')
                                ])
                            ];
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'update', 'index'],
                        'roles' => ['admin']
                    ]
                ]
            ],
            [
                'class' => ContentNegotiator::className(),
                'only' => ['j-join', 'j-create'],
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->activityId]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * 用户新建活动
     * @return stdClass
     */
    public function actionJCreate()
    {
        $model = new Activity();
        $result = new stdClass();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            $result->iRet = 0;
            $result->msg = 'success';
            $result->data = null;
        } else {
            $result->iRet = -1;
            $result->msg = 'create activity failed';
            $result->data = $model->getErrorSummary(true);
        }

        return $result;
    }

    /**
     * 报名参加某项活动
     * @return stdClass
     */
    public function actionJJoin()
    {
        $activityId = Yii::$app->request->post('activityId');
        $userId = Yii::$app->user->id;
        $model = Activity::findOne(['activityId' => $activityId]);
        $result = new stdClass();

        if (!$model) {
            $result->iRet = -3;
            $result->msg = 'activity is empty';
            $result->data = null;
            return $result;
        }

        $auModel = ActivityUser::findOne(['userId' => $userId, 'activityId' => $activityId]);

        if (!$auModel) {
//             已经参加过活动
            $result->iRet = -4;
            $result->msg = 'has joined activity';
            $result->data = null;
            return $result;
        }

        $auModel = new ActivityUser();
        $auModel->activityId = $activityId;
        $auModel->userId = $userId;

        if ($auModel->save()) {
            $result->iRet = 0;
            $result->data = null;
            $result->msg = 'success';
        } else {
            $result->data = $auModel->getErrorSummary(true);
            $result->msg = 'join activity failed';
            $result->iRet = -4;
        }

        return $result;
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->activityId]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Activity model.
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
}
