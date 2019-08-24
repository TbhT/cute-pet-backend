<?php

namespace app\controllers;

use app\behaviors\GenerateIdBehavior;
use app\models\UploadForm;
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
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['create', 'update', 'delete', 'index', 'view', 'j-create', 'j-detail', 'j-all'],
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['admin']
//                    ],
//                    [
//                        'allow' => true,
//                        'actions' => ['j-create', 'j-detail', 'j-all'],
//                        'roles' => ['@']
//                    ]
//                ]
//            ],
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

        return $result;
    }

    /**
     * 列出所有商家,已经通过审核的
     */
    public function actionJAll()
    {
        $offset = Yii::$app->request->post('offset');
        $offset = $offset ?? 1;

        $model = Market::find(['status' => 1])
            ->offset($offset - 1)
            ->limit(20)
            ->asArray()
            ->all();

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
        $model = Market::findOne(['marketId' => $marketId]);
        $result = new stdClass();

        $result->iRet = 0;
        $result->msg = 'success';
        $result->data = $model;

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
        $pictureForm = new UploadForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($pictureForm->upload()) {
                $model->image = $pictureForm->path;
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->marketId]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'pictureForm' => $pictureForm
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
        $pictureForm = new UploadForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($pictureForm->upload()) {
                $model->image = $pictureForm->path;

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->marketId]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'pictureForm' => $pictureForm
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
