<?php
use kartik\tree\Module;

use kartik\tree\TreeView;
use common\models\Category;

$this->title = Yii::t('app', 'Category');
 
echo TreeView::widget([
    // single query fetch to render the tree
    // use the Category model you have in the previous step
    'query' => Category::find()->addOrderBy('root, lft'), 
    'headingOptions' => ['label' => Yii::t('app', 'Categories')],
    'fontAwesome' => false,     // optional
    'isAdmin' => true,         // optional (toggle to enable admin mode)
    'displayValue' => 1,        // initial display value
    'softDelete' => true,       // defaults to true
    'cacheSettings' => [        
        'enableCache' => true   // defaults to true
    ],
    'nodeAddlViews' => [
        Module::VIEW_PART_1 => '',
        Module::VIEW_PART_2 => '@backend/views/category/seo',
        Module::VIEW_PART_3 => '',
        Module::VIEW_PART_4 => '',
        Module::VIEW_PART_5 => '',
    ]
]);
?>