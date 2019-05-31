<?php

namespace app\controllers;

use Yii;
use app\models\LikeTweet;
use app\models\LikeTweetSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LikeTweetController implements the CRUD actions for LikeTweet model.
 */
class LikeTweetController extends Controller
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
                        'actions' => ['update', 'delete', 'index'],
                        'roles' => ['admin']
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all LikeTweet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LikeTweetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LikeTweet model.
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
     * Creates a new LikeTweet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LikeTweet();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->likeId]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUserCreate()
    {
        $model = new LikeTweet();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return [
                'iRet' => 0,
                'msg' => 'success',
                'data' => $model->toArray()
            ];
        }

        return [
            'iRet' => -1,
            'msg' => 'create tweet failed',
            'data' => null
        ];
    }


    /**
     * Updates an existing LikeTweet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->likeId]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LikeTweet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LikeTweet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LikeTweet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LikeTweet::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
