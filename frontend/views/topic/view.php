<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->registerMetaTag(['name' => 'description', 'content' => $topic->keywords]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $topic->description]);
$this->title = $topic->title;
$this->params['breadcrumbs'][] = [
            'label' => 'Topics',
            'url' => ['/topics'],
            ];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if ($this->beginCache($topic->id, ['enabled' => ! Yii::$app->request->get('cache_clear')])) : ?>
    <div class="topic" xmlns="http://www.w3.org/1999/html">
        <h1><?php echo $topic->h1 ?></h1>
        <? if(! empty($topic->preview)): ?>
            <div class="topic_preview">
                <?= Html::img($topic->getThumbUploadUrl('preview', 'big'), ['class' => 'img-thumbnail']) ?>
            </div>
        <? endif ?>
        <div class="topic-contenct">
            <?php echo $topic->content ?>
        </div>
        <div class="topic-category">
           <b>Категория:</b> <a href="<?php echo Url::to(['topic/category', 'alias' => $category->alias]); ?>" title=""><?php echo $category->title ?></a>
        </div>
        <?php if(! empty($tags)): ?>
        <div class="topic__tags">
            <ul>
            <?php foreach($tags as $tag):  ?>
                <li>
                    <a href="/tag/<?php echo $tag['alias'] ?>"><?php echo $tag['tag'] ?></a>
                </li>
            <?php endforeach ?>
            </ul>
        </div>
        <? endif ?>
    </div>
    <?php $this->endCache(); ?>
<?php endif ?>