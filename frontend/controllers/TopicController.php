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
class TopicController extends Controller
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

    public function actionHelp()
    {
        return $this->render('index');
    }
    
    /**
     * @param $alias
    */
    public function actionIndex($alias = null)
    {
        if(Yii::$app->request->get('cache')){
            $cacheKey = 'Topic:' . $alias;
            Yii::$app->cache->delete($cacheKey);
        }
        $cacheKey = 'Topic:' . $alias;
        if (false === $topic = Yii::$app->cache->get($cacheKey)) {
            if (null === $topic = Topic::find()->where(['alias' => $alias])->with('tags')->one()) {
                throw new NotFoundHttpException;
            }
            Yii::$app->cache->set(
                $cacheKey,
                $topic,
                86400,
                new TagDependency(
                    [
                        'tags' => [
                            
                        ]
                    ]
                )
            );
        }
        return $this->render('index',[
                                    'topic'  => $topic,
                                    'tags' => $topic->tags
                                    ]);
    }
    
    public function actionList()
    {
        $query = Topic::find()->where(['active' => 1]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'defaultPageSize' => 2]);
        $cacheTopics = 'Topics'.$pages->getPage();
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
        return $this->render('list',[
                                    'topics'    => $topics,
                                    'pages'     => $pages,
                                    ]);
    }

    
}
