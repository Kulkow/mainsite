<?
use yii\helpers\Html;
use yii\grid\GridView;

use kartik\tree\TreeView;
use common\models\Category;

$this->title = Yii::t('app', 'Category');
 
echo TreeView::widget([
    // single query fetch to render the tree
    // use the Category model you have in the previous step
    'query' => Category::find()->addOrderBy('root, lft'), 
    'headingOptions' => ['label' => 'Categories'],
    'fontAwesome' => false,     // optional
    'isAdmin' => true,         // optional (toggle to enable admin mode)
    'displayValue' => 1,        // initial display value
    'softDelete' => true,       // defaults to true
    'cacheSettings' => [        
        'enableCache' => true   // defaults to true
    ]
]);
?>