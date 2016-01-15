<?php
use yii\widgets\LinkPager;
$this->title = 'Topics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topics_list">
<?php foreach ($topics as $topic) : ?>
    <div class="topic_item">
        <a href="<?php echo $topic->url() ?>" title="<?php echo $topic->title ?>"><?php echo $topic->title ?></a>
        <div class="announce">
            <?php echo $topic->announce ?>
        </div>
    </div>
<?php endforeach ?>
</div>
<?php
echo LinkPager::widget([
    'pagination' => $pages,
]);
?>