<?php
/**
 * @var $content_type_id
 */

$content_type_obj = \Skif\Content\ContentType::factory($content_type_id);
?>
<p><a href="<?php echo \Skif\Content\RubricController::getRubricsListUrlByContentType($content_type_obj->getType());?>/edit/new" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Добавить рубрику</a></p>
<p></p>
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <colgroup>
            <col class="col-md-8">
            <col class="col-md-3">
            <col class="col-md-1">
        </colgroup>
        <?php
        $rubric_ids_arr = $content_type_obj->getRubricIdsArr();
        foreach ($rubric_ids_arr as $rubric_id) {
            $rubric_obj = \Skif\Content\Rubric::factory($rubric_id);
            ?>
            <tr>
                <td>
                    <a href="<?php echo $rubric_obj->getEditorUrl(); ?>"><?php echo $rubric_obj->getName(); ?></a>
                    <a href="<?php echo $rubric_obj->getEditorUrl(); ?>"><span class="glyphicon glyphicon-edit" title="Редактировать"></span></a>
                </td>
                <td>
                    <?php echo $rubric_obj->getComment(); ?>
                </td>
                <td align="right">
                    <a href="<?php echo $rubric_obj->getUrl(); ?>" target="_blank"><span class="glyphicon glyphicon-new-window"></span></a>
                    <a href="<?php echo $rubric_obj->getDeleteUrl(); ?>" onClick="return confirm('Вы уверены, что хотите удалить?')"><span class="glyphicon glyphicon-remove" title="Удалить"></span></a>
                </td>
            </tr>
            <?
        }
        ?>
    </table>

