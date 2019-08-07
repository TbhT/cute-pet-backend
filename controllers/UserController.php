<?php

namespace app\controllers;

use app\models\LoginForm;
use app\utils\SendSms;
use stdClass;
use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;


/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                        'actions' => ['login-with-user', 'login', 'validate-code'],
                        'roles' => ['?']
                    ],
//                    [
//                        'allow' => true,
//                        'actions' => ['logout', 'logout-with-user'],
//                        'roles' => ['@']
//                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'index', 'view', 'update', 'delete'],
                        'roles' => ['admin']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'login-with-user' => ['post'],
                    'logout-with-user' => ['post'],
                    'delete' => ['post'],
                    'validate-code' => ['post']
                ]
            ],
            [
                'class' => ContentNegotiator::className(),
                'only' => ['login-with-user', 'validate-code', 'update-data'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }


    /**
     * 管理员登录
     * @return string|Response
     * @throws \yii\base\ExitException
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $userId = Yii::$app->user->id;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            Yii::$app->response->data = ActiveForm::validate($model);
            Yii::$app->response->send();
            Yii::$app->end();
        }

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $auth = Yii::$app->authManager;
            $adminRole = $auth->getRole('admin');

            if ($auth->getAssignment($adminRole, $userId)) {
                return $this->redirect('/user/index');
            } else {
                return $this->redirect('/');
            }
        }

        return $this->render('login', ['model' => $model]);
    }

    /**
     * 获取验证码接口
     * @return stdClass
     */
    public function actionValidateCode()
    {
        $res = new stdClass();
        $phone = Yii::$app->request->post('mobile');
        $result = SendSms::send($phone);

        if ($result === false) {
            $res->iRet = -1;
            $res->sMsg = 'validate code error';
            $res->data = $result;
        } else {
            $res->iRet = 0;
            $res->sMsg = 'success';
            $res->data = $result;
        }

        return $res;
    }

    /**
     * 普通用户进行登录
     * 手机号 + 验证码
     * @return stdClass
     */
    public function actionLoginWithUser()
    {
        $model = new LoginForm();
        $result = new stdClass();

        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            $result->iRet = 0;
            $result->sMsg = 'success';
            $result->data = null;
        } else {
            $result->iRet = -2;
            $result->sMsg = 'error';
            $result->data = $model->getErrorSummary(true);
        }

        return $result;
    }

    /**
     * 普通用户进行退出操作
     * @return stdClass
     */
    public function actionLogoutWithUser()
    {
        Yii::$app->getUser()->logout();
        $result = new stdClass();

        $result->iRet = 0;
        $result->sMsg = 'success';
        $result->data = null;

        return $result;
    }

    /**
     * 管理员进行退出
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->getUser()->logout();

        return $this->goHome();
    }

    /**
     * 更新用户数据
     * @return stdClass
     */
    public function actionUpdateData()
    {
        $userId = Yii::$app->user->id;
        $user = User::findOne(['userId' => $userId]);
        $result = new stdClass();

        if ($user->load(Yii::$app->request->post(), '') && $user->save()) {
            $result->iRet = 0;
            $result->sMsg = 'success';
            $result->data = null;
        } else {
            $result->iRet = -3;
            $result->sMsg = 'update failed';
            $result->data = $user->getErrorSummary(true);
        }

        return $result;
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->userId]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->userId]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
