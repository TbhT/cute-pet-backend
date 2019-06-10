<?php

namespace app\controllers;

use app\behaviors\GenerateIdBehavior;
use app\models\Pet;
use stdClass;
use Yii;
use app\models\Market;
use app\models\MarketSearch;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * MarketController implements the CRUD actions for Market model.
 */
class MarketController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete', 'index', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                ]
            ],
            [
                'class' => GenerateIdBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['marketId']
                ],
                'idType' => GenerateIdBehavior::MARKET_ID_TYPE
            ],
            [
                'class' => ContentNegotiator::className(),
                'only' => ['j-create', 'j-detail', 'j-all'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }

    /**
     * 添加商家
     */
    public function actionJCreate()
    {
        $model = new Market();
        $result = new stdClass();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            $result->iRet = 0;
            $result->msg = 'success';
            $result->data = null;
        } else {
            $result->iRet = -1;
            $result->msg = 'create market failed';
            $result->data = $model->getErrorSummary(true);
        }
    }

    /**
     * 列出所有商家
     */
    public function actionJAll()
    {
        $model = Market::find()->asArray()->all();
        $result = new stdClass();

        $result->iRet = 0;
        $result->msg = 'success';
        $result->data = $model;

        return $result;
    }

    /**
     * 获取商家详情
     * @return stdClass
     */
    public function actionJDetail()
    {
        $marketId = Yii::$app->request->post('marketId');
        $model = Market::find()->detail($marketId)->one();
        $result = new stdClass();

        $result->iRet = 0;
        $result->msg = 'success';
        $result->data= $model;

        return $result;
    }


    /**
     * Lists all Market models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MarketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Market model.
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
     * Creates a new Market model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Market();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->marketId]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Market model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->marketId]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Market model.
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
     * Finds the Market model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Market the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Market::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
