<?php
/**
 * @var $title
 * @var $breadcrumbs
 * @var $content
 */

$user_id = \Skif\Users\AuthUtils::getCurrentUserId();

if (!$user_id) {
    echo \Skif\PhpTemplate::renderTemplate(
        'layouts/layout.admin_login.tpl.php'
    );

    return;
}

if (!\Skif\Users\AuthUtils::currentUserIsAdmin()) {
    \Skif\Http::exit403();
}

$user_obj = \Skif\Users\User::factory($user_id);

$skif_path = \Skif\Conf\ConfWrapper::value('skif_path');
$assets_libraries_path = $skif_path . '/assets/libraries';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>СКИФ - Система управления сайтом</title>

    <link href="<?php echo $skif_path; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon">

    <!-- jQuery -->
    <script src="<?php echo $assets_libraries_path; ?>/jquery/jquery.min.js"></script>
    <link href="<?php echo $assets_libraries_path; ?>/jquery-ui/themes/base/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo $assets_libraries_path; ?>/jquery-ui/jquery-ui.min.js"></script>

    <!-- Bootstrap -->
    <link href="<?php echo $assets_libraries_path; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="<?php echo $assets_libraries_path; ?>/bootstrap/js/bootstrap.min.js"></script>

    <!-- MetisMenu CSS -->
    <link href="<?php echo $assets_libraries_path; ?>/metisMenu/metisMenu.min.css" rel="stylesheet" type="text/css">

    <link href="<?php echo $assets_libraries_path; ?>/sb-admin-2/css/sb-admin-2.css" rel="stylesheet" type="text/css">

    <link href="<?php echo $assets_libraries_path; ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="<?php echo $skif_path; ?>/assets/styles/admin.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="<?php echo $assets_libraries_path; ?>/jquery-validation/jquery.validate.min.js"></script>

    <script type="text/javascript" src="<?php echo $assets_libraries_path; ?>/fancybox/jquery.fancybox.pack.js"></script>
    <link href="<?php echo $assets_libraries_path; ?>/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="<?php echo $assets_libraries_path; ?>/moment/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo $assets_libraries_path; ?>/moment/moment.ru.min.js"></script>
    <script type="text/javascript" src="<?php echo $assets_libraries_path; ?>/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <link href="<?php echo $assets_libraries_path; ?>/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
</head>

<body>

<div id="wrapper">

    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/admin">
                <img src="<?php echo $skif_path; ?>/assets/images/admin/skif_small_logo.png" alt="СКИФ" border="0" height="39" title="Система управления сайтом СКИФ / websk.ru">
            </a>
        </div>

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a href="/" target="_blank">
                    <i class="fa fa-external-link fa-fw"></i>
                </a>
            </li>

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li></li>
                    <li><a href="/admin/users/edit/<?php echo $user_id; ?>"><i class="fa fa-user fa-fw"></i> <?php echo $user_obj->getName(); ?></a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="/user/logout?destination=/admin"><i class="fa fa-sign-out fa-fw"></i> Выход</a>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <?php
                    $current_url_no_query = \Skif\UrlManager::getUriNoQueryString();

                    $admin_menu_contents_arr = array();

                    $content_type_ids_arr = \Skif\Content\ContentUtils::getContentTypeIdsArr();

                    foreach ($content_type_ids_arr as $content_type_id) {
                        $content_type_obj = \Skif\Content\ContentType::factory($content_type_id);

                        $icon = '<i class="fa fa-files-o fa-fw"></i>';
                        if ($content_type_obj->getType() == 'news') {
                            $icon = '<i class="fa fa-newspaper-o fa-fw"></i>';
                        }

                        $admin_menu_contents_arr[] = array(
                            'link' => '/admin/content/' . $content_type_obj->getType(),
                            'name' => $content_type_obj->getName(),
                            'icon' => $icon
                        );
                    }

                    $admin_menu_arr = \Skif\Conf\ConfWrapper::value('admin_menu');

                    $admin_menu_arr = array_merge($admin_menu_contents_arr, $admin_menu_arr);

                    foreach ($admin_menu_arr as $menu_item_arr) {

                        $class = ($current_url_no_query == $menu_item_arr['link']) ? ' active' : '';
                        $target = array_key_exists('target', $menu_item_arr) ? 'target="' . $menu_item_arr['target'] .'""' : '';
                        ?>
                        <li <?php echo ( $class ? 'class="' . $class . '"' : ''); ?>>
                            <a href="<?php echo $menu_item_arr['link']; ?>" <?php echo $target; ?>>
                                <?php
                                if (array_key_exists('icon', $menu_item_arr)) {
                                    echo $menu_item_arr['icon'];
                                }
                                ?>
                                <?php echo $menu_item_arr['name']; ?>
                            </a>
                            <?php
                            if (array_key_exists('sub_menu', $menu_item_arr)) {
                                ?>
                                <ul class="nav nav-second-level">
                                    <?php
                                    foreach ($menu_item_arr['sub_menu'] as $sub_menu_item_arr) {
                                        ?>
                                        <li>
                                            <a href="<?php echo $sub_menu_item_arr['link']; ?>"><?php echo $sub_menu_item_arr['name']; ?></a>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            <?php
                            }
                            ?>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div>
                        <?php
                        if (!isset($breadcrumbs_arr)) {
                            $breadcrumbs_arr = array();
                        }

                        $breadcrumbs_arr = array_merge(
                            array('Главная' => '/admin'),
                            $breadcrumbs_arr
                        );

                        echo \Skif\PhpTemplate::renderTemplate('/admin_breadcrumbs.tpl.php', array('breadcrumbs_arr' => $breadcrumbs_arr));

                        if (!empty($title)) {
                            echo '<h1 class="page-header">' . $title . '</h1>';
                        }

                        echo \Skif\Messages::renderMessages();
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div><?php echo $content; ?></div>
                </div>
            </div>

        </div>
    </div>

</div>

<script src="<?php echo $assets_libraries_path; ?>/metisMenu/metisMenu.min.js"></script>

<script src="<?php echo $skif_path; ?>/assets/libraries/sb-admin-2/js/sb-admin-2.js"></script>

</body>

</html>
