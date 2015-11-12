<?php
/**
 * @var $rubric_id
 */

$rubric_obj = \Skif\Content\Rubric::factory($rubric_id);

$content_type_obj = \Skif\Content\ContentType::factory($rubric_obj->getContentTypeId());

$page = array_key_exists('p', $_GET) ? $_GET['p'] : 1;
$limit_to_page = \Skif\Conf\ConfWrapper::value('content.' . $content_type_obj->getType() . '.limit_to_page');
$current_date = date('Y-m-d');
$current_unix_time = time();

$content_ids_arr = \Skif\Content\ContentUtils::getPublishedContentsIdsArrByRubricId($rubric_id, $limit_to_page, $page);

foreach ($content_ids_arr as $content_id) {
    $content_obj = \Skif\Content\Content::factory($content_id);

    if (!$content_obj->isPublished()) {
        continue;
    }
    ?>
    <div class="list_news">
        <div class="news_data"><?= date('d.m.Y', $content_obj->getUnixTime()) ?></div>
        <div class="news_title">
            <a href="<?php echo $content_obj->getUrl(); ?>"><?php echo $content_obj->getTitle(); ?></a>
        </div>
        <div class="row">
            <?php
            $col = 12;
            if ($content_obj->getImage()) {
                $col = 9;
                ?>
                <div class="col-md-3 news_image"><img src="<?php echo \Skif\Image\ImageManager::getImgUrlByPreset($content_obj->getImagePath(), '120_auto'); ?>" alt="<?php $content_obj->getTitle() ?>" title="<?php echo $content_obj->getTitle() ?>" class="img-responsive"></div>
            <?php
            }
            ?>
            <div class="col-md-<?php echo $col; ?>"><?= \Skif\Content\ContentUtils::filterContent($content_obj->getAnnotation()) ?></div>
        </div>
    </div>
<?php
}

$count_all_articles = \Skif\Content\ContentUtils::getCountPublishedContentsByRubricId($rubric_id);
echo \Skif\Utils::renderPagination($page, $count_all_articles, $limit_to_page);
