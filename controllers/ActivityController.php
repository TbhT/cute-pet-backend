<?php

namespace app\controllers;

use app\models\ActivityUser;
use app\models\AreaCode;
use app\models\UploadForm;
use app\utils\Pay;
use stdClass;
use Throwable;
use Yii;
use app\models\Activity;
use app\models\ActivitySearch;
use yii\db\StaleObjectException;
use yii\debug\Panel;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use Yurun\PaySDK\Weixin\JSAPI\Params\JSParams\Request as jsRequest;
use Yurun\PaySDK\Weixin\JSAPI\Params\Pay\Request;
use Yurun\PaySDK\Weixin\Params\PublicParams;
use Yurun\PaySDK\Weixin\SDK;

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
                        'actions' => [
                            'city-list', 'area-list', 'province-list',
                            'j-activity', 'j-join', 'j-detail',
                            'cities', 'area', 'j-pay'
                        ],
                        'roles' => ['?', '@']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            [
                'class' => ContentNegotiator::className(),
                'only' => ['city-list', 'area-list', 'province-list', 'j-activity', 'j-join', 'j-detail'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]

        ];
    }

    /**
     * 获取类型活动
     * @return stdClass
     */
    public function actionJActivity()
    {
        $type = Yii::$app->request->post('type');
        $offset = Yii::$app->request->post('offset');

        $result = new stdClass();

        if (!$type || !$offset) {
            $result->iRet = -2;
            $result->sMsg = 'invalid parameter';
            $result->data = null;
            return $result;
        }

        $type = $type == 1 ? 1 : 0;

        $models = Activity::find()
            ->getActivities($type)
            ->limit(20)
            ->offset($offset - 1)
            ->asArray()
            ->all();

        $result->iRet = 0;
        $result->sMsg = 'success';
        $result->data = $models;

        return $result;
    }

    /**
     * 获取活动详情
     */
    public function actionJDetail()
    {
        $activityId = Yii::$app->request->post('activityId');
        $userId = Yii::$app->user->id;
        $result = new stdClass();

        if (empty($activityId)) {
            $result->iRet = -1;
            $result->sMsg = 'activity is empty';
            $result->data = null;
            return $result;
        }

        $model = Activity::findOne(['activityId' => $activityId, 'status' => 1]);
        if (empty($model)) {
            $result->iRet = -1;
            $result->sMsg = 'activity is empty';
            $result->data = null;
            return $result;
        }

        $hasJoinModel = ActivityUser::findOne(['userId' => $userId, 'activityId' => $activityId]);

        if (is_string($model->tag)) {
            $model->tag = json_decode($model->tag);
        }

        $result->iRet = 0;
        $result->sMsg = 'success';
        $result->data = [
            'activityId' => $model->activityId,
            'status' => $model->status,
            'name' => $model->name,
            'beginTime' => $model->beginTime,
            'endTime' => $model->endTime,
            'joinBeginTime' => $model->joinBeginTime,
            'joinEndTime' => $model->joinEndTime,
            'organizer' => $model->organizer,
            'coorganizer' => $model->coorganizer,
            'place' => $model->place,
            'createTime' => $model->createTime,
            'image' => $model->image,
            'personUnitPrice' => $model->personUnitPrice,
            'petUnitPrice' => $model->petUnitPrice,
            'personCount' => $model->personCount,
            'province' => $model->provinceName,
            'city' => $model->cityName,
            'area' => $model->areaName,
            'hasJoin' => $model->hasJoin,
            'tag' => $model->tag,
            'userJoinStatus' => empty($hasJoinModel) ? -1 : 1
        ];

        return $result;
    }

    /**
     * 用户参加活动
     * @return stdClass
     */
    public function actionJJoin()
    {
        $activityId = Yii::$app->request->post('activityId');
        $userId = Yii::$app->user->id;
        $activity = Activity::findOne(['activityId' => $activityId]);
        $result = new stdClass();

        if (!$activity) {
            $result->iRet = -3;
            $result->sMsg = 'activity is empty';
            $result->data = null;
            return $result;
        }

        if ($activity->hasJoin >= $activity->personCount) {
            $result->iRet = -4;
            $result->sMsg = 'activity is full';
            $result->data = null;
            return $result;
        }

        $hasJoinModel = ActivityUser::findOne(['userId' => $userId, 'activityId' => $activityId]);
        if ($hasJoinModel) {
            $result->iRet = -4;
            $result->sMsg = 'has join activity';
            $result->data = $hasJoinModel;
            return $result;
        }

        $hasJoinModel = new ActivityUser();
        $hasJoinModel->activityId = $activityId;
        $hasJoinModel->userId = $userId;

        if ($hasJoinModel->save()) {
            $activity->hasJoin += 1;
            $activity->save(false);
            $result->iRet = 0;
            $result->sMsg = 'success';
            $result->data = null;
            return $result;
        }

        $result->iRet = -1;
        $result->sMsg = 'join failed';
        $result->data = $hasJoinModel->getErrorSummary(true);

        Yii::error($hasJoinModel->getErrorSummary(true));

        return $result;
    }

    public function actionJPay()
    {
        $params = new PublicParams();
        $params->appID = Yii::$app->params['WeChatParams']['appid'];
        $params->mch_id = Yii::$app->params['WeChatParams']['mch_id'];
        $params->key = Yii::$app->params['WeChatParams']['key'];

        $pay = new SDK($params);

        $request = new Request();
        $request->body = 'test';
        $request->out_trade_no = 'test' . mt_rand(10000000, 99999999);
        $request->total_fee = 1;
        $request->spbill_create_ip = Yii::$app->request->getUserIP();
        $request->notify_url = Yii::$app->params['WeChatParams']['notify_url'];
        $request->openid = Pay::GetOpenid();

        $result = $pay->execute($request);
        Yii::info($result);

        if ($pay->checkResult()) {
            $request = new jsRequest;
            $request->prepay_id = $result['prepay_id'];
            $jsapiParams = $pay->execute($request);
            return json_encode($jsapiParams);
        } else {
            Yii::error($result);
            Yii::error($pay->signType);
            Yii::error($pay->checkResult());
            Yii::error($pay->getError());
            Yii::error($pay->getErrorCode());
        }
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
        $pictureForm = new UploadForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($pictureForm->upload()) {
                if ($pictureForm->path) {
                    $model->image = $pictureForm->path;
                }

                if (!empty($model->tag)) {
                    $model->tag = json_encode($model->tag);
                }

                if ($model->province) {
                    $_p = AreaCode::findOne(['id' => $model->province]);
                    if ($_p) {
                        $model->provinceName = $_p->name;
                    }
                }

                if ($model->city) {
                    $_c = AreaCode::findOne(['id' => $model->city]);
                    if ($_c) {
                        $model->cityName = $_c->name;
                    }
                }

                if ($model->area) {
                    $_a = AreaCode::findOne(['id' => $model->area]);
                    if ($_a) {
                        $model->areaName = $_a->name;
                    }
                }

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->activityId]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'pictureForm' => $pictureForm
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
        $pictureForm = new UploadForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($pictureForm->upload()) {
                if ($pictureForm->path) {
                    $model->image = $pictureForm->path;
                }

                if ($model->province) {
                    $_p = AreaCode::findOne(['id' => $model->province]);
                    if ($_p) {
                        $model->provinceName = $_p->name;
                    }
                }

                if ($model->city) {
                    $_c = AreaCode::findOne(['id' => $model->city]);
                    if ($_c) {
                        $model->cityName = $_c->name;
                    }
                }

                if ($model->area) {
                    $_a = AreaCode::findOne(['id' => $model->area]);
                    if ($_a) {
                        $model->areaName = $_a->name;
                    }
                }

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->activityId]);
                }
            }
        }

        if (is_string($model->tag)) {
            $model->tag = json_decode($model->tag);
        }

        return $this->render('update', [
            'model' => $model,
            'pictureForm' => $pictureForm
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

    public function actionCities()
    {
        Yii::info($_POST);
        $out = [];
        if (isset($_POST['depdrop_all_params'])) {
            $parent_id = $_POST['depdrop_all_params']['provinceId'];
            $selected_id = $_POST['depdrop_all_params']['selectedCityId'];
            $out = Yii::$app->db->cache(function ($db) use ($parent_id) {
                return AreaCode::find()->select(['id', 'name'])->where(['parent_id' => $parent_id])->asArray()->all();
            }, YII_DEBUG ? 3 : 24 * 3600);
            return Json::encode(['output' => $out, 'selected' => $selected_id]);
        }

        return Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionArea()
    {
        Yii::info($_POST);
        $out = [];
        if (isset($_POST['depdrop_all_params'])) {
            $parent_id = $_POST['depdrop_all_params']['cityId'];
            $selected_id = $_POST['depdrop_all_params']['selectedAreaId'];
            $out = Yii::$app->db->cache(function ($db) use ($parent_id) {
                return AreaCode::find()->select(['id', 'name'])->where(['parent_id' => $parent_id])->asArray()->all();
            }, YII_DEBUG ? 3 : 24 * 3600);
            return Json::encode(['output' => $out, 'selected' => $selected_id]);
        }

        return Json::encode(['output' => '', 'selected' => '']);
    }
}
