<?php
$current_url_no_query = \Skif\UrlManager::getUriNoQueryString();

\Skif\UrlManager::route('@^/error$@', '\Skif\Http', 'errorPageAction');

\Skif\UrlManager::route('@^@', '\Skif\Redirect\ControllerRedirect', 'redirectAction');

// Admin
if (strpos($current_url_no_query, '/admin') !== false) {
    \Skif\UrlManager::route('@^/admin$@i', '\Skif\AdminController', 'indexAction', 0);
    \Skif\UrlManager::route('@^/admin/$@i', '\Skif\AdminController', 'indexAction', 0);

    // Admin Logger
    \Skif\UrlManager::route('@^/admin/logger/list$@i', '\Skif\Logger\ControllerLogger', 'listAction', 0);
    \Skif\UrlManager::route('@^/admin/logger/object_log/@i', '\Skif\Logger\ControllerLogger', 'object_logAction', 0);
    \Skif\UrlManager::route('@^/admin/logger/record/@', '\Skif\Logger\ControllerLogger', 'recordAction', 0);

    // Admin Blocks
    \Skif\UrlManager::route('@^/admin/blocks$@i', '\Skif\Blocks\ControllerBlocks', 'listAction', 0);
    \Skif\UrlManager::route('@^/admin/blocks/list$@i', '\Skif\Blocks\ControllerBlocks', 'listAction', 0);
    \Skif\UrlManager::route('@^/admin/blocks/edit/(.+)/position@i', '\Skif\Blocks\ControllerBlocks', 'placeInRegionTabAction', 0);
    \Skif\UrlManager::route('@^/admin/blocks/edit/(.+)/region@i', '\Skif\Blocks\ControllerBlocks', 'chooseRegionTabAction', 0);
    \Skif\UrlManager::route('@^/admin/blocks/edit/(.+)/caching@i', '\Skif\Blocks\ControllerBlocks', 'cachingTabAction', 0);
    \Skif\UrlManager::route('@^/admin/blocks/edit/(.+)/ace@i', '\Skif\Blocks\ControllerBlocks', 'aceTabAction', 0);
    \Skif\UrlManager::route('@^/admin/blocks/edit/(.+)/delete@i', '\Skif\Blocks\ControllerBlocks', 'deleteTabAction', 0);
    \Skif\UrlManager::route('@^/admin/blocks/edit/(.+)@i', '\Skif\Blocks\ControllerBlocks', 'editAction', 0);
    \Skif\UrlManager::route('@^/admin/blocks/search$@i', '\Skif\Blocks\ControllerBlocks', 'searchAction', 0);
    \Skif\UrlManager::route('@^/admin/blocks/change_template/(\d+)@i', '\Skif\Blocks\ControllerBlocks', 'changeTemplateAction', 0);

    // Материалы
    \Skif\UrlManager::route('@^/admin/content/(.+)/rubrics$@', '\Skif\Content\RubricController', 'listAdminRubricsAction');
    \Skif\UrlManager::route('@^/admin/content/(.+)/rubrics/edit/(.+)@', '\Skif\Content\RubricController', 'editRubricAction');
    \Skif\UrlManager::route('@^/admin/content/(.+)/rubrics/save/(.+)@', '\Skif\Content\RubricController', 'saveRubricAction');
    \Skif\UrlManager::route('@^/admin/content/(.+)/rubrics/delete/(.+)@', '\Skif\Content\RubricController', 'deleteRubricAction');
    \Skif\UrlManager::route('@^/admin/content/autocomplete$@i', '\Skif\Content\ContentController', 'autoCompleteContentAction', 0);
    \Skif\UrlManager::route('@^/admin/content/(.+)/edit/(.+)$@i', '\Skif\Content\ContentController', 'editAdminAction', 0);
    \Skif\UrlManager::route('@^/admin/content/(.+)/save/(.+)$@i', '\Skif\Content\ContentController', 'saveAdminAction', 0);
    \Skif\UrlManager::route('@^/admin/content/(.+)/delete/(.+)$@i', '\Skif\Content\ContentController', 'deleteAction', 0);
    \Skif\UrlManager::route('@^/admin/content/(.+)/delete_image/(.+)$@i', '\Skif\Content\ContentController', 'deleteImageAction', 0);
    \Skif\UrlManager::route('@^/admin/content/(.+)$@i', '\Skif\Content\ContentController', 'listAdminAction', 0);

    // Меню сайта
    \Skif\UrlManager::route('@^/admin/site_menu$@i', '\Skif\SiteMenu\SiteMenuController', 'listAdminAction', 0);
    \Skif\UrlManager::route('@^/admin/site_menu/edit/(.+)$@i', '\Skif\SiteMenu\SiteMenuController', 'editAdminAction', 0);
    \Skif\UrlManager::route('@^/admin/site_menu/save/(.+)$@i', '\Skif\SiteMenu\SiteMenuController', 'saveAdminAction', 0);
    \Skif\UrlManager::route('@^/admin/site_menu/delete/(\d+)$@i', '\Skif\SiteMenu\SiteMenuController', 'deleteAdminAction', 0);
    \Skif\UrlManager::route('@^/admin/site_menu/(\d+)/items/list/(\d+)$@i', '\Skif\SiteMenu\SiteMenuController', 'listItemsAdminAction', 0);
    \Skif\UrlManager::route('@^/admin/site_menu/(\d+)/items/list_for_move/(\d+)$@i', '\Skif\SiteMenu\SiteMenuController', 'listForMoveItemsAdminAction', 0);
    \Skif\UrlManager::route('@^/admin/site_menu/(\d+)/item/move/(\d+)$@i', '\Skif\SiteMenu\SiteMenuController', 'moveItemAdminAction', 0);
    \Skif\UrlManager::route('@^/admin/site_menu/(\d+)/item/edit/(.+)$@i', '\Skif\SiteMenu\SiteMenuController', 'editItemAdminAction', 0);
    \Skif\UrlManager::route('@^/admin/site_menu/(\d+)/item/save/(.+)$@i', '\Skif\SiteMenu\SiteMenuController', 'saveItemAdminAction', 0);
    \Skif\UrlManager::route('@^/admin/site_menu/(\d+)/item/delete/(\d+)$@i', '\Skif\SiteMenu\SiteMenuController', 'deleteItemAdminAction', 0);

    // Admin2 Redirect
    \Skif\UrlManager::route('@^/admin/redirect/list$@i', '\Skif\Redirect\ControllerRedirect', 'listAction', 0);
    \Skif\UrlManager::route('@^/admin/redirect/add$@i', '\Skif\Redirect\ControllerRedirect', 'addAction', 0);
    \Skif\UrlManager::route('@^/admin/redirect/edit/@', '\Skif\Redirect\ControllerRedirect', 'editAction', 0);
    \Skif\UrlManager::route('@^/admin/redirect/save$@i', '\Skif\Redirect\ControllerRedirect', 'saveAction', 0);
    \Skif\UrlManager::route('@^/admin/redirect/delete$@i', '\Skif\Redirect\ControllerRedirect', 'deleteAction', 0);

    // User
    \Skif\UrlManager::route('@^/admin/users$@', '\Skif\Users\UserController', 'listAction');
    \Skif\UrlManager::route('@^/admin/users/edit/(.+)@', '\Skif\Users\UserController', 'editAction', 0, \Skif\Conf\ConfWrapper::value('layout.admin'));
    \Skif\UrlManager::route('@^/admin/users/roles$@', '\Skif\Users\UserController', 'listUsersRolesAction');
    \Skif\UrlManager::route('@^/admin/users/roles/edit/(.+)@', '\Skif\Users\UserController', 'editUsersRoleAction');
    \Skif\UrlManager::route('@^/admin/users/roles/save/(.+)@', '\Skif\Users\UserController', 'saveUsersRoleAction');
    \Skif\UrlManager::route('@^/admin/users/roles/delete/(.+)@', '\Skif\Users\UserController', 'deleteUsersRoleAction');

    // Admin2 KeyValue
    \Skif\UrlManager::route('@^/admin/key_value$@i', '\Skif\KeyValue\KeyValueController', 'listAction', 0);
    \Skif\UrlManager::route('@^/admin/key_value/edit/(.+)$@', '\Skif\KeyValue\KeyValueController', 'editAction', 0);
    \Skif\UrlManager::route('@^/admin/key_value/save/(.+)$@i', '\Skif\KeyValue\KeyValueController', 'saveAction', 0);
    \Skif\UrlManager::route('@^/admin/key_value/delete/(\d+)$@i', '\Skif\KeyValue\KeyValueController', 'deleteAction', 0);

    exit;
}

// Captcha
\Skif\UrlManager::route('@^/captcha/(.+)$@i', '\Skif\Captcha\CaptchaController', 'mainAction');


// User
\Skif\UrlManager::route('@^/user/edit/(.+)@', '\Skif\Users\UserController', 'editAction');
\Skif\UrlManager::route('@^/user/save/(.+)@', '\Skif\Users\UserController', 'saveAction');
\Skif\UrlManager::route('@^/user/delete/(.+)@', '\Skif\Users\UserController', 'deleteAction');
\Skif\UrlManager::route('@^/user/create_password/(.+)@', '\Skif\Users\UserController', 'createAndSendPasswordToUserAction');
\Skif\UrlManager::route('@^/user/add_photo/(.+)@', '\Skif\Users\UserController', 'addPhotoAction');
\Skif\UrlManager::route('@^/user/delete_photo/(.+)@', '\Skif\Users\UserController', 'deletePhotoAction');
\Skif\UrlManager::route('@^/user/logout@', '\Skif\Users\AuthController', 'logoutAction');
\Skif\UrlManager::route('@^/user/login@', '\Skif\Users\AuthController', 'loginAction');

// Комментарии
\Skif\UrlManager::route('@^/comments/list$@', '\Skif\Comments\CommentsController', 'listAction');
\Skif\UrlManager::route('@^/comments/add$@', '\Skif\Comments\CommentsController', 'saveAction');
\Skif\UrlManager::route('@^/comments/delete/(\d+)$@', '\Skif\Comments\CommentsController', 'deleteAction');

// Country
\Skif\UrlManager::route('@^/autocomplete/countries$@', '\Skif\CountryController', 'CountriesAutoCompleteAction');

// Regions
\Skif\UrlManager::route('@^/regions/import_from_vk$@', '\Skif\Regions\RegionController', 'importFromVKAction');


\Skif\UrlManager::route('@^/files/images/cache/(.+)/(.+)$@', '\Skif\Image\ControllerIndex', 'indexAction');
//\Skif\UrlManager::route('@^/images/upload$@', '\Skif\Image\ImageController', 'uploadAction');
//\Skif\UrlManager::route('@^/images/upload_to_files$@', '\Skif\Image\ImageController', 'uploadToFilesAction');
//\Skif\UrlManager::route('@^/images/upload_to_images$@', '\Skif\Image\ImageController', 'uploadToImagesAction');

\Skif\UrlManager::route('@^@', '\Skif\Content\ContentController', 'viewAction');
\Skif\UrlManager::route('@^@', '\Skif\Content\RubricController', 'listAction');
\Skif\UrlManager::route('@^/(.+)$@i', '\Skif\Content\ContentController', 'listAction');
