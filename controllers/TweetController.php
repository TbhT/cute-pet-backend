<?php

namespace app\controllers;

use stdClass;
use Yii;
use app\models\Tweet;
use app\models\TweetSearch;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TweetController implements the CRUD actions for Tweet model.
 */
class TweetController extends Controller
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
                        'actions' => ['view'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete', 'index'],
                        'roles' => ['admin']
                    ]
                ]
            ],
            [
                'class' => ContentNegotiator::className(),
//                todo: 需要添加角色给 j-create
                'only' => ['j-create', 'j-all-tweets'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }

    /**
     * Lists all Tweet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TweetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tweet model.
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
     * Creates a new Tweet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tweet();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tweetId]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @return stdClass
     */
    public function actionJCreate()
    {
        $model = new Tweet();
        $result = new stdClass();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $result->iRet = 0;
            $result->msg = 'success';
            $result->data = $model->toArray();
        } else {
            $result->iRet = -1;
            $result->msg = 'create tweet failed';
            $result->data = $model->getErrorSummary(true);
        }

        return $result;
    }

    /**
     * @return stdClass
     */
    public function actionJAllTweets()
    {
        $query = Tweet::find()
            ->orderBy('createTime DESC')
            ->limit(20)
            ->offset(0);

        $data = $query->asArray();
        $result = new stdClass();

        $result->iRet = 0;
        $result->msg = 'success';
        $result->data = $data;

        return $result;
    }

    /**
     * Updates an existing Tweet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tweetId]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tweet model.
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
     * Finds the Tweet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Tweet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tweet::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
