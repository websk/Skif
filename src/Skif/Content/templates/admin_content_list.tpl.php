<?php
/**
 * @var $content_type
 */
$page = array_key_exists('p', $_GET) ? $_GET['p'] : 1;
$limit_to_page = 100;
$contents_ids_arr = \Skif\Content\ContentUtils::getContentsIdsArrByType($content_type, $limit_to_page, $page);
?>
<p><a href="/admin/content/<?php echo $content_type; ?>/edit/new" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Добавить новый материал</a></p>
<p></p>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <colgroup>
            <col class="col-md-1">
            <col class="col-md-2">
            <col class="col-md-7">
            <col class="col-md-1">
        </colgroup>
<?php
foreach ($contents_ids_arr as $content_id) {
    $content_obj = \Skif\Content\Content::factory($content_id);
    ?>
    <tr>
        <td><?php echo $content_obj->getId(); ?></td>
        <td><?php echo $content_obj->getCreatedAt(); ?></td>
        <td><a href="/admin/content/<?php echo $content_type; ?>/edit/<?php echo $content_id; ?>"><?php echo $content_obj->getTitle(); ?>&nbsp;<span class="glyphicon glyphicon-edit" title="Редактировать"></span></a></td>
        <td align="right">
            <a href="<?php echo $content_obj->getUrl(); ?>" target="_blank"><span class="glyphicon glyphicon-new-window"></span></a>
            <a href="/admin/content/<?php echo $content_type; ?>/delete/<?php echo $content_id; ?>" onClick="return confirm('Вы уверены, что хотите удалить?')"><span class="glyphicon glyphicon-remove" title="Удалить"></span></a>
        </td>
    </tr>
    <?php
}
?>
    </table>
</div>
<?php
$count_all_articles = \Skif\Content\ContentUtils::getCountContentsByType($content_type);
echo \Skif\Utils::renderPagination($page, $count_all_articles, $limit_to_page);
?>
