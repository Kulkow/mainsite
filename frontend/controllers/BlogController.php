<?php
namespace frontend\controllers;

use Yii;
use common\models\Topic;
use yii\caching\TagDependency;
use yii\data\Pagination;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Topic controller
 */
class BlogController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions'=>['login','error'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    
    public function actionList()
    {
        return $this->render('list',[]);
    }

    public function actionGetTopics() {
        $query = Topic::find()->where(['active' => 1])->with('tags');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'defaultPageSize' => 3]);
        $cacheTopics = 'Topics'.$pages->getPage();
        if(Yii::$app->request->get('cache')){
            Yii::$app->cache->delete($cacheTopics);
        }
        if (false === $topics = Yii::$app->cache->get($cacheTopics)) {
            if (null === $topics = $query->offset($pages->offset)->limit($pages->limit)->all()) {
                throw new NotFoundHttpException;
            }
            Yii::$app->cache->set(
                $cacheTopics,
                $topics,
                86400,
                new TagDependency(
                    [
                        'tags' => [
                            
                        ]
                    ]
                )
            );
        }
        $this->renderJSON($topics);
    }
     
    protected function renderJSON($data) {
        header('Content-type: application/json');
        echo CJSON::encode($data);
        Yii::app()->end();
    }

    
}
