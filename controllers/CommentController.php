<?php

namespace app\controllers;

use app\models\Tweet;
use stdClass;
use Yii;
use app\models\Comment;
use app\models\CommentSearch;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends Controller
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
                'only' => ['j-create', 'j-tweet'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }

    /**
     * Lists all Comment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Comment model.
     * @param integer $id
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
     * Creates a new Comment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->commentId]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * 获取某条动态下的评论
     */
    public function actionJTweet()
    {
        $tweetId = Yii::$app->request->post('tweetId');
        $offset = Yii::$app->request->post('offset');
        $result = new stdClass();

        $data = Comment::find()
            ->getTweetAllComment($tweetId, $offset - 1)
            ->orderBy('createTime DESC')
            ->innerJoinWith('userInfo')
            ->asArray()
            ->all();

        $tweetInfo = [];

        foreach ($data as $d) {
            array_push($tweetInfo, [
                'commentId' => $d['commentId'],
                'createTime' => $d['createTime'],
                'text' => $d['text'],
                'tweetId' => $d['tweetId'],
                'userId' => $d['userId'],
                'nickname' => $d['userInfo']['nickname'],
                'mobile' => $d['userInfo']['mobile'],
                'avatar' => $d['userInfo']['avatar']
            ]);
        }

        $result->iRet = 0;
        $result->msg = 'success';
        $result->data = $tweetInfo;

        return $result;
    }

    /**
     * 新建评论
     * @return stdClass
     */
    public function actionJCreate()
    {
        $model = new Comment();
        $result = new stdClass();
        $model->userId = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            $tweetId = Yii::$app->request->post('tweetId');
            $tweet = Tweet::findOne(['tweetId' => $tweetId]);
            if (!$tweet) {
                $result->iRet = -3;
                $result->msg = 'tweet is not exist';
                $result->data = null;
                return $result;
            } else {
                $tweet->commentCount += 1;
                $tweet->save(false);
            }

            $result->iRet = 0;
            $result->msg = 'success';
            $result->data = null;
        } else {
            $result->iRet = -4;
            $result->msg = 'comment failed';
            $result->data = $model->getErrorSummary(true);
        }

        return $result;
    }


    /**
     * Updates an existing Comment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->commentId]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Comment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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
     * Finds the Comment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
