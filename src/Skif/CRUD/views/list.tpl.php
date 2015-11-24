<?php
/**
 * @var $model_class_name
 * @var $context_arr array
 * @var $list_title string
 */

\Skif\Utils::assert($model_class_name);

// готовим список ID объектов для вывода
$filter = '';
if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
}
$objs_ids_arr = \Skif\CRUD\CRUDUtils::getObjIdsArrayForModel($model_class_name, $context_arr, $filter);

// готовим список полей, которые будем выводить в таблицу
$reflect = new \ReflectionClass($model_class_name);
$props_arr = array();

$crud_fields_list_arr = array();

foreach ($reflect->getProperties() as $prop_obj) {
    if (!$prop_obj->isStatic()) { // игнорируем статические свойства класса - они относятся не к объекту, а только к классу (http://www.php.net/manual/en/language.oop5.static.php), и в них хранятся настройки ActiveRecord и CRUD
        $prop_obj->setAccessible(true);
        $props_arr[] = $prop_obj;
    }
}

if (property_exists($model_class_name, 'crud_fields_list_arr') && (count($model_class_name::$crud_fields_list_arr) > 0)) {
    $crud_fields_list_arr = $model_class_name::$crud_fields_list_arr;

    foreach ($props_arr as $delta => $property_obj) {
        if (!array_key_exists($property_obj->getName(), $crud_fields_list_arr)) {
            unset($props_arr[$delta]);
        }
    }
}

$container_models_arr = array();
if (property_exists($model_class_name, 'crud_container_model')) {
    $container_models_arr = $model_class_name::$crud_container_model;
}
?>

<div>
    <?php
    if ($list_title) {
        ?>
        <h2 class="pull-left"><?php echo $list_title; ?></h2>
    <?php
    }
    ?>

    <?php
    if (isset($model_class_name::$crud_model_title_field)) {
        if (isset($model_class_name::$crud_allow_search)) {
            if ($model_class_name::$crud_allow_search == true) {
                ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <form action="<?php echo \Skif\UrlManager::getUriNoQueryString(); ?>">
                                    <input name="filter" value="<?php echo $filter; ?>">
                                    <input type="submit" value="искать">
                                </form>
                            </div>
                            <div class="col-md-4">

                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }
    ?>

    <?php
    if (\Skif\CRUD\CRUDUtils::canDisplayCreateButton($model_class_name, $context_arr)) {
        ?>
        <p class="padding_top_10 padding_bottom_10">
            <a href="<?php echo '/crud/add/' . urlencode($model_class_name) . '?' . http_build_query(array('context_arr' => $context_arr)); ?>"
               class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Добавить</a>
        </p>
        <?php
    }
    ?>

    <?php
    // create fast add block

    echo \Skif\PhpTemplate::renderTemplateBySkifModule(
        'CRUD',
        'fast_create_form.tpl.php',
        array(
            'model_class_name' => $model_class_name,
        )
    );
    ?>

    <?php
    if (count($objs_ids_arr) > 0) {
    ?>
    <div>
        <table class="table table-striped table-hover">
            <?php
            if ($crud_fields_list_arr) {
                ?>
                <colgroup>
            <?php
                foreach ($crud_fields_list_arr as $field_arr) {
                    ?>
                    <col class="<?php echo $field_arr['col_class']; ?>">
                    <?php
                }
                ?>
                </colgroup>
            <?php
            }
            ?>
            <thead>
            <tr>
                <?php
                foreach ($props_arr as $prop_obj) {
                    $table_title = \Skif\CRUD\CRUDUtils::getTitleForField($model_class_name, $prop_obj->getName());
                    echo '<th>' . $table_title . '</th>';
                }
                ?>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($objs_ids_arr as $obj_id) {
                $obj_obj = \Skif\CRUD\CRUDUtils::createAndLoadObject($model_class_name, $obj_id);
                ?>
                <tr>
                    <?php
                    foreach ($props_arr as $prop_obj) {
                        $link_field_key = array_search($prop_obj->getName(), array_values($container_models_arr));
                        $roles = \Skif\CRUD\Widgets::getFieldWidgetName($prop_obj->getName(), $obj_obj);

                        $title = '';

                        if ($link_field_key !== false) {
                            $container_array_keys = array_keys($container_models_arr);
                            $container_model = $container_array_keys[$link_field_key];

                            $container_obj = \Skif\CRUD\CRUDUtils::createAndLoadObject($container_model, $prop_obj->getValue($obj_obj));

                            if (method_exists($container_obj, 'getTitle')) {
                                $title .= $container_obj->getTitle() . ' ';
                            }

                            $title .= '(' . $container_obj->getId() . ')';
                        } else if ($roles == 'options') {
                            $role = \Skif\CRUD\Widgets::getFieldWidgetOptionsArr($prop_obj->getName(), $obj_obj);
                            if (array_key_exists($prop_obj->getValue($obj_obj), $role)) {
                                $title = $role[$prop_obj->getValue($obj_obj)];
                            }
                        } else {
                            $title = \Skif\CRUD\Widgets::renderListFieldWithWidget($prop_obj->getName(), $obj_obj);

                            /*
                             * если это поле с названием модели - делаем его значение ссылкой на редактирование
                             * если же значение не содержит видимымх символов - выводим кнопку редактирования (чтобы не остаться без ссылки)
                             */
                            if (property_exists($model_class_name, 'crud_model_title_field')) {
                                if ($prop_obj->getName() == $model_class_name::$crud_model_title_field) {
                                    if (\Skif\CRUD\CRUDUtils::stringCanBeUsedAsLinkText($title)) {
                                        $edit_url = \Skif\CRUD\ControllerCRUD::getEditUrl($model_class_name, $obj_id);
                                        $title = '<a href="' . $edit_url . '">' . $title . '</a>';
                                    }
                                }
                            }

                        }

                        echo '<td>' . $title . '</td>';
                    }

                    $edit_url = \Skif\CRUD\ControllerCRUD::getEditUrl($model_class_name, $obj_id);
                    $delete_url = \Skif\CRUD\ControllerCRUD::getDeleteUrl($model_class_name, $obj_id);
                    ?>
                    <td align="right">
                        <a href="<?php echo $edit_url; ?>" title="Редактировать" class="btn btn-outline btn-default btn-sm">
                            <span class="fa fa-edit fa-lg text-warning fa-fw"></span>
                        </a>
                        <?php

                        $delete_disabled = false;
                        $model_class_interfaces_arr = class_implements($model_class_name);
                        if (!array_key_exists('Skif\Model\InterfaceDelete', $model_class_interfaces_arr)) {
                            $delete_disabled = true;
                        }

                        if (!$delete_disabled) {
                            ?>
                            <a href="<?php echo $delete_url . '?destination=' . urlencode($_SERVER['REQUEST_URI']); ?>"
                               onClick="return confirm('Вы уверены, что хотите удалить?')" title="Удалить"
                               class="btn btn-outline btn-default btn-sm">
                                <span class="fa fa-trash-o fa-lg text-danger fa-fw"></span>
                            </a>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <?php
        echo \Skif\Pager::renderPager(count($objs_ids_arr));
        }
        ?>
    </div>

