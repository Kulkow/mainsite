<?php
use yii\widgets\LinkPager;
use yii\helpers\Html;
$this->title = 'Topics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div ng-controller="NewsController">
    Сортировать:
    <ul>
        <li><a href="javascript:;" ng-click="setOrder('created_date', false)">по дате</a></li>
        <li><a href="javascript:;" ng-click="setOrder('like_count', true)">по полезности</a></li>
    </ul>
    <div ng-init="getNews()">
        <div class="topic_item">
            <a href="{{newsItem.url}}" title="{{newsItem.title}}">{{newsItem.title}}</a>
            <div class="topic_announce">
                {{newsItem.announce}}
            </div>
        </div>
    </div>
</div>
