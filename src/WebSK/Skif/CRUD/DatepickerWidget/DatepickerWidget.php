<?php

namespace WebSK\Skif\CRUD\DatepickerWidget;

use WebSK\Views\PhpRender;

class DatepickerWidget
{

    public static function renderWidget($field_name, $field_value, $widget_options = array())
    {
        $widget_options['field_name'] = $field_name;
        $widget_options['field_value'] = $field_value;

        $output = PhpRender::renderTemplateInViewsDir(
            'CRUD' . DIRECTORY_SEPARATOR . 'DatepickerWidget',
            'datepicker_widget.tpl.php',
            $widget_options
        );

        return $output;
    }
}
