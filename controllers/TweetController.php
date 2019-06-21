<?php

namespace app\controllers;

use app\models\LikeTweet;
use dektrium\user\helpers\Password;
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
                        'actions' => ['view', 'j-create', 'j-all-tweets', 'j-like'],
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
                'only' => ['j-create', 'j-all-tweets', 'j-like'],
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
     * 发表推特
     * @return stdClass
     */
    public function actionJCreate()
    {
        $model = new Tweet();
        $result = new stdClass();
        $model->userId = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            $result->iRet = 0;
            $result->msg = 'success';
            $result->data = null;
        } else {
            $result->iRet = -1;
            $result->msg = 'create tweet failed';
            $result->data = $model->getErrorSummary(true);
        }

        return $result;
    }

    /**
     * 点赞或者取消点赞
     * @return stdClass
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionJLike()
    {
        $type = Yii::$app->request->post('type');
        $tweetId = Yii::$app->request->post('tweetId');
        $tweet = Tweet::findOne(['tweetId' => $tweetId]);
        $result = new stdClass();
        $userId = Yii::$app->user->id;

        if (!$tweet) {
            return $result;
        }

        if ($type == 1) {
            $tweet->likeCount += 1;
            $likeTweet = new LikeTweet();
            $likeTweet->tweetId = $tweetId;
            $likeTweet->userId = $userId;

            if (!$likeTweet->save()) {
                $result->iRet = -3;
                $result->data = $likeTweet->getErrorSummary(true);
                $result->msg = 'like failed';
                return $result;
            }
        } else {
            $tweet->likeCount -= 1;
            $likeTweet = LikeTweet::findOne(['userId' => $userId, 'tweetId' => $tweetId]);
            if ($likeTweet) {
                $likeTweet->delete();
            }
        }

        if ($tweet->save(false)) {
            $result->iRet = 0;
            $result->msg = 'success';
            $result->data = null;
        } else {
            $result->iRet = -1;
            $result->msg = 'like or not like failed';
            $result->data = $tweet->getErrorSummary(true);
        }

        return $result;
    }

    /**
     * 获取所有的推特信息流
     * @return stdClass
     */
    public function actionJAllTweets()
    {
        $offset = Yii::$app->request->post('offset');
        $result = new stdClass();

        if (!is_numeric($offset)) {
            $result->iRet = -2;
            $result->msg = 'parameter invalid';
            $result->data = null;

            return $result;
        }

        $query = Tweet::find()
            ->innerJoinWith('user')
            ->joinWith('userLikeStatus')
            ->orderBy('createTime DESC')
            ->limit(20)
            ->offset($offset - 1);

        $data = $query->asArray()->all();
        $tweets = [];
        foreach ($data as $d) {
            array_push($tweets, [
                'commentCount' => $d['commentCount'],
                'createTime' => $d['createTime'],
                'image' => $d['image'],
                'likeCount' => $d['likeCount'],
                'text' => $d['text'],
                'tweetId' => $d['tweetId'],
                'userId' => $d['userId'],
                'liked' => !empty($d['userLikeStatus']),
                'nickname' => $d['user']['nickname'],
                'avatar' => $d['user']['image']
            ]);
        }

        $result->iRet = 0;
        $result->msg = 'success';
        $result->data = $tweets;

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
