<?php

namespace app\controllers;

use app\models\Activity;
use app\utils\JsApiPay;
use app\utils\WxPayApi;
use app\utils\WxPayConfig;
use app\utils\WxPayOrderQuery;
use app\utils\WxPayUnifiedOrder;
use stdClass;
use Throwable;
use Yii;
use app\models\Order;
use app\models\OrderSearch;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;


/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
                        'actions' => ['j-create', 'j-detail', 'j-pay', 'j-final'],
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            [
                'class' => ContentNegotiator::className(),
                'only' => ['j-create', 'j-detail', 'j-final'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ],
//            [
//                'class' => Cors::className(),
//                'only' => ['j-pay'],
//                'cors' => [
//                    'Origin' => ['*'],
//                    'Access-Control-Request-Method' => ['GET', 'HEAD', 'OPTIONS', 'POST'],
//                ]
//            ]
        ];
    }

    public function actionJFinal()
    {
        $orderId = Yii::$app->request->post('orderId');
        $input = new WxPayOrderQuery();
        $input->SetOut_trade_no($orderId);
        $config = new WxPayConfig();
        $result = WxPayApi::orderQuery($config, $input);
        Yii::error($result, '支付');
        return $result;
    }

    public function actionJPay()
    {
        $orderId = Yii::$app->request->get('orderId');

        try {
            $order = Order::findOne(['orderId' => $orderId]);

            if (empty($orderId) || !$order) {
                return '参数非法';
            }

            $tools = new JsApiPay();
            $openId = $tools->GetOpenid();

            //②、统一下单
            $input = new WxPayUnifiedOrder();
            $input->SetBody("宠伢娱乐-活动");
            $input->SetAttach(Yii::$app->user->id);
            $input->SetOut_trade_no($order->orderId);
            $input->SetTotal_fee($order->totalFee);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
//        $input->SetGoods_tag("test");
            $input->SetNotify_url("http://www.chongyapet.com");
            $input->SetTrade_type("JSAPI");
            $input->SetOpenid($openId);
            $config = new WxPayConfig();
            $order = WxPayApi::unifiedOrder($config, $input);
//        echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
//        var_dump($order);
            $jsApiParameters = $tools->GetJsApiParameters($order);

        } catch (Throwable $e) {
            Yii::error($e);
            $jsApiParameters = null;
        }
//        return $result;

        //获取共享收货地址js函数参数
//        $editAddress = $tools->GetEditAddressParameters();
//        var_dump($jsApiParameters);
        $this->layout = false;
        return $this->render('jsapi', [
            'jsApiParameters' => $jsApiParameters,
            'orderId' => $orderId
        ]);
    }


    /**
     * 创建订单
     */
    public function actionJCreate()
    {
        $result = new stdClass();
        $activityId = Yii::$app->request->post('activityId');
        $personCount = Yii::$app->request->post('personCount');
        $petCount = Yii::$app->request->post('petCount');
        $order = Order::findOne(['userId' => Yii::$app->user->id, 'activityId' => $activityId]);

        if ($order) {
            $result->iRet = -3;
            $result->sMsg = 'order has created';
            $result->data = null;
            return $result;
        }

        if (empty($activityId) || empty($personCount) || empty($petCount)) {
            $result->iRet = -2;
            $result->sMsg = 'params error';
            $result->data = null;
            return $result;
        }

        $activity = Activity::findOne(['activityId' => $activityId]);
        if (empty($activity)) {
            $result->iRet = -2;
            $result->sMsg = 'activity is empty';
            $result->data = null;
            return $result;
        }

        $petFee = $activity->petUnitPrice * 100 * $petCount;
        $personFee = $activity->personUnitPrice * 100 * $personCount;
        $allFee = $petFee + $personFee;

        $order = new Order();
        $order->activityId = $activityId;
        $order->userId = Yii::$app->user->id;
        $order->totalFee = $allFee;
        $order->petCount = $petCount;
        $order->personCount = $personCount;
        $order->status = Order::CREATE;
        $order->name = '活动订单';

        if ($order->save()) {
            $result->iRet = 0;
            $result->sMsg = 'success';
            $result->data = $order;
        } else {
            $result->iRet = -1;
            $result->sMsg = 'create failed';
            $result->data = $order->getErrorSummary(true);
        }

        return $result;
    }

    public function actionJDetail()
    {
        $activityId = Yii::$app->request->post('activityId');
        $userId = Yii::$app->user->id;
        $order = Order::findOne(['activityId' => $activityId, 'userId' => $userId]);
        $result = new stdClass();
        $result->iRet = 0;
        $result->sMsg = 'success';

        if (empty($order)) {
            $result->data = null;
        } else {
            $result->data = $order;
        }

        return $result;
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
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
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->orderId]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->orderId]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
