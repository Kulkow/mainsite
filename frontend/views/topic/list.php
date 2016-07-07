<?php
use yii\widgets\LinkPager;
use yii\helpers\Html;
$this->title = 'Topics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topics_list">
<?php foreach ($topics as $topic) : ?>
    <div class="topic_item">
        <a href="<?php echo $topic->url() ?>" title="<?php echo $topic->title ?>"><?php echo $topic->title ?></a>
        <?php if(! empty($topic->preview)): ?>
            <div class="topic_preview">
                <a href="<?php echo $topic->url() ?>" title="<?php echo $topic->title ?>">
                    <?php echo Html::img($topic->getThumbUploadUrl('preview', 'small'), ['class' => 'img-thumbnail']) ?>
                </a>
            </div>
        <?php endif ?>
        <div class="topic_announce">
            <?php echo $topic->announce ?>
        </div>
        <?php if(! empty($topic->tags)): ?>
        <div class="topic__tags">
            <ul>
        <?php foreach($topic->tags as $tag):  ?>
            <li>
                <a href="/tag/<?php echo $tag['alias'] ?>" title="<?php echo $tag['tag'] ?>"><?php echo $tag['tag'] ?></a>
            </li>
        <?php endforeach ?>
            </ul>
        </div>
        <?php endif ?>
    </div>
<?php endforeach ?>
</div>
<?php
echo LinkPager::widget(['pagination' => $pages]);
?>