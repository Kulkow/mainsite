<?php
namespace frontend\controllers;

use common\models\Category;
use Yii;
use common\models\Topic;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Topic controller
 */
class TopicController extends LayoutController
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
    public function actionView($alias = null)
    {
        $cacheKey = 'Topic:'.$alias;
        if (false === $topic = $this->getCache($cacheKey)) {
            if (null === $topic = Topic::find()->where(['alias' => $alias])->with('tags')->one()) {
                $this->error(404);
            }
            $this->setCache($cacheKey, $topic, 'Topic_View', ['topic-'.$topic->id]);
        }
        return $this->render('view',[
                'topic'  => $topic,
                'tags' => $topic->tags,
                'category' => $topic->category
            ]
        );
    }

    /**
     * @param $alias
     */
    public function actionCategory($alias = null)
    {
        $cacheKey = 'Category:'.$alias;
        if (false === $category = $this->getCache($cacheKey)) {
            if (null === $category = Category::find()->where(['alias' => $alias])->one()) {
                $this->error(404);
            }
            $this->setCache($cacheKey, $category, 'Category_View', ['category-'.$category->id]);
        }
        $list = Topic::find()->where(['active' => 1, 'category_id' => $category->id])->with('tags');
        $countQuery = clone $list;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'defaultPageSize' => $this->paginate['per_page']]);
        $cacheKey = 'Topics_'.$this->cacheKeyPaginate($pages);
        if (false === $topics = $this->getCache($cacheKey)) {
            if (null === $topics = $list->offset($pages->offset)->limit($pages->limit)->all()) {
                $this->error(404);
            }
            $this->setCache($cacheKey, $topics, 'Topic_List', []);
        }
        return $this->render('category',[
            'topics' => $topics,
            'category' => $category,
            'pages'     => $pages,
        ]);
    }
    
    public function actionList()
    {
        $list = Topic::find()->where(['active' => 1])->with('tags');
        $countQuery = clone $list;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'defaultPageSize' => $this->paginate['per_page']]);
        $cacheKey = 'Topics_'.$this->cacheKeyPaginate($pages);
        if (false === $topics = $this->getCache($cacheKey)) {
            if (null === $topics = $list->offset($pages->offset)->limit($pages->limit)->all()) {
                $this->error(404);
            }
            $this->setCache($cacheKey, $topics, 'Topic_List', []);
        }
        return $this->render('list',[
            'topics'    => $topics,
            'pages'     => $pages,
        ]);
    }

    
}
