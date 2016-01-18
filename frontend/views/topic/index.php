<?php
use yii\helpers\Html;
$this->registerMetaTag(['name' => 'description', 'content' => $topic->keywords]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $topic->description]);
$this->title = $topic->title;
$this->params['breadcrumbs'][] = [
            'label' => 'Topics',
            'url' => ['/topics'],
            ];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if ($this->beginCache($topic->id, ['enabled' => ! Yii::$app->request->get('cache')])) : ?>
    <div class="topic">
        <h1><?php echo $topic->h1 ?></h1>
        <? if(! empty($topic->preview)): ?>
            <div class="topic_preview">
                <?= Html::img($topic->getThumbUploadUrl('preview', 'big'), ['class' => 'img-thumbnail']) ?>
            </div>
        <? endif ?>
        <div class="topic__contenct">
            <?php echo $topic->content ?>
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