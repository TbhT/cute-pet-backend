<?php

namespace app\controllers;

use app\models\Tweet;
use stdClass;
use Yii;
use app\models\Topic;
use app\models\TopicSearch;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;


/**
 * TopicController implements the CRUD actions for Topic model.
 */
class TopicController extends Controller
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
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'index', 'view', 'update', 'delete'],
                        'roles' => ['admin']
                    ]
                ],
            ],
            [
                'class' => ContentNegotiator::className(),
                'only' => ['j-all', 'j-list'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }

    /**
     * 获取所有的topic列表
     */
    public function actionJAll()
    {
        $models = Topic::find()->asArray()->all();

        $result = new stdClass();
        $result->iRet = 0;
        $result->data = $models;
        $result->msg = 'success';

        return $result;
    }

    /**
     * 获取所有的topic相关的tweet列表
     */
    public function actionJList()
    {
        $topicId = Yii::$app->request->post('topicId');
        $result = new stdClass();

        $result->iRet = 0;
        $result->msg = 'success';
        $data = Tweet::find()
            ->innerJoinWith('user')
            ->relatedTweets($topicId)
            ->asArray()
            ->all();

        $resultData = [];

        foreach ($data as $d) {
            array_push($resultData, [
                'commentCount' => $d['commentCount'],
                'createTime' => $d['createTime'],
                'image' => $d['image'],
                'likeCount' => $d['likeCount'],
                'status' => $d['status'],
                'text' => $d['text'],
                'tweetId' => $d['tweetId'],
                'mobile' => $d['user']['mobile'],
                'avatar' => $d['user']['avatar'],
                'nickname' => $d['user']['nickname']
            ]);
        }

        $result->data = $resultData;

        return $result;
    }

    /**
     * Lists all Topic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TopicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Topic model.
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
     * Creates a new Topic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Topic();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->topicId]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Topic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->topicId]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Topic model.
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
     * Finds the Topic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Topic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Topic::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
