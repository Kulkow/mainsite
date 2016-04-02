<? use common\models\Category;
$tree = Category::find()->addOrderBy('root, lft')->all();
$tree = Category::menu($tree);
?>
<aside class="main-sidebar">
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <? $items = [
            ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
            ['label' => Yii::t('app','Projets'), 'url' => ['/projects']],
            ['label' => Yii::t('app','Topics'), 'url' => ['/topic']],
            ['label' =>  Yii::t('app','Tags'), 'url' => ['/tag']],
            ['label' =>  Yii::t('app','Category'), 'url' => ['/category'], 'items' => $tree],
            ['label' =>  Yii::t('app','Permissions'), 'url' => '#',
                'items' => [
                    ['label' => Yii::t('app','Roles'), 'url' => ['/permit/access/role']],
                    ['label' => Yii::t('app','Permissions'), 'url' => ['/permit/access/permission']]
                ],
            ],
            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
            ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
        ];
        ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => $items
            ]
        ) ?>

    </section>

</aside>
