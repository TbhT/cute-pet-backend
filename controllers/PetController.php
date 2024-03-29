<?php

namespace app\controllers;

use app\models\UploadForm;
use app\models\UserPet;
use stdClass;
use Yii;
use app\models\Pet;
use app\models\PetSearch;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * PetController implements the CRUD actions for Pet model.
 */
class PetController extends Controller
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
                    ],
                    [
                        'allow' => true,
                        'actions' => ['j-create', 'j-detail', 'j-update'],
                        'roles' => ['?', '@']
                    ]
                ],
            ],
            [
                'class' => ContentNegotiator::className(),
                'only' => ['j-create', 'j-detail', 'j-update'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }

    /**
     * Lists all Pet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pet model.
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
     * Creates a new Pet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pet();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->petId]);
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
        $model = new Pet();
        $result = new stdClass();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            $concatModel = new UserPet();
            $concatModel->userId = Yii::$app->user->id;
            $concatModel->petId = $model->petId;

            if ($concatModel->save()) {
                $result->iRet = 0;
                $result->msg = 'success';
                $result->data = null;
            } else {
                Yii::error("添加宠物和人的关联关系失败 {$concatModel->userId}|{$concatModel->petId}");
                $result->iRet = -3;
                $result->msg = 'save pet relation failed';
                $result->data = $concatModel->getErrorSummary(true);
            }

        } else {
            $result->iRet = -1;
            $result->msg = 'create pet failed';
            $result->data = $model->getErrorSummary(true);
        }

        return $result;
    }

    /**
     * 更新宠物信息
     */
    public function actionJUpdate()
    {
        $petId = Yii::$app->request->post('petId');
        $model = Pet::findOne(['petId' => $petId]);
        $result = new stdClass();

        if ($model && $model->load(Yii::$app->request->post(), '') && $model->save()) {
            $result->iRet = 0;
            $result->sMsg = 'success';
            $result->data = null;
        } else {
            $result->iRet = -1;
            $result->sMsg = 'update failed';
            $result->data = $model->getErrorSummary(true);
        }

        return $result;
    }

    /**
     * 获取宠物的详情
     * @return stdClass
     */
    public function actionJDetail()
    {
        $petId = Yii::$app->request->post('petId');
        $result = new stdClass();

        $model = Pet::findOne(['petId' => $petId]);

        if ($model) {
            $detail = [
                'nickname' => $model->nickname,
                'gender' => $model->gender,
                'age' => $model->age,
                'vaccineStatus' => $model->vaccineStatus,
                'petType' => $model->petType,
                'subType' => $model->subType,
                'weight' => $model->weight,
                'neuter' => $model->neuter,
                'size' => $model->size,
                'color' => $model->color,
                'avatar' => $model->avatar
            ];
        } else {
            $detail = null;
        }

        $result->iRet = 0;
        $result->data = $detail;
        $result->msg = 'success';

        return $result;
    }


    /**
     * Updates an existing Pet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->petId]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Pet model.
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
     * Finds the Pet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Pet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pet::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
