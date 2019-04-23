<?php

namespace WebSK\Skif\Content;

use Slim\App;
use WebSK\SimpleRouter\SimpleRouter;
use WebSK\Skif\Content\RequestHandlers\Admin\ContentEditHandler;
use WebSK\Skif\Content\RequestHandlers\Admin\ContentListAjaxHandler;
use WebSK\Skif\Content\RequestHandlers\Admin\ContentPhotoCreateHandler;
use WebSK\Skif\Content\RequestHandlers\Admin\ContentPhotoDeleteHandler;
use WebSK\Skif\Content\RequestHandlers\Admin\ContentPhotoListHandler;
use WebSK\Skif\Content\RequestHandlers\Admin\SetDefaultContentPhotoHandler;
use WebSK\Utils\HTTP;

/**
 * Class ContentRoutes
 * @package WebSK\Skif\Content
 */
class ContentRoutes
{
    public static function route()
    {
        if (SimpleRouter::matchGroup('@/admin@')) {
            SimpleRouter::staticRoute('@^/admin/content/(\w+)/rubrics$@', RubricController::class,
                'listAdminRubricsAction');
            SimpleRouter::staticRoute('@^/admin/content/(\w+)/rubrics/edit/(\w+)@', RubricController::class,
                'editRubricAction');
            SimpleRouter::staticRoute('@^/admin/content/(\w+)/rubrics/save/(\w+)@', RubricController::class,
                'saveRubricAction');
            SimpleRouter::staticRoute('@^/admin/content/(\w+)/rubrics/delete/(\w+)@', RubricController::class,
                'deleteRubricAction');
            SimpleRouter::staticRoute('@^/admin/content/autocomplete$@i', ContentController::class,
                'autoCompleteContentAction', 0);
            SimpleRouter::staticRoute('@^/admin/content/(\w+)/new$@i', ContentController::class, 'newAdminAction',
                0);
            SimpleRouter::staticRoute('@^/admin/content/(\w+)/save/(\w+)$@i', ContentController::class, 'saveAdminAction',
                0);
            SimpleRouter::staticRoute('@^/admin/content/(\w+)/delete/(\w+)$@i', ContentController::class, 'deleteAction',
                0);
            SimpleRouter::staticRoute('@^/admin/content/(\w+)/delete_image/(\w+)$@i', ContentController::class,
                'deleteImageAction', 0);
            SimpleRouter::staticRoute('@^/admin/content/(\w+)$@i', ContentController::class, 'listAdminAction', 0);
        }

        SimpleRouter::route(
            '@^@',
            [new ContentController(), 'viewAction'],
            0
        );

        SimpleRouter::staticRoute('@^@', RubricController::class, 'listAction');
        SimpleRouter::staticRoute('@^/(.+)$@i', ContentController::class, 'listAction');
    }

    /**
     * @param App $app
     */
    public static function registerAdmin(App $app)
    {
        $app->group('/content', function (App $app) {
            $app->group('/{content_type:\w+}', function (App $app) {
                $app->map([HTTP::METHOD_GET, HTTP::METHOD_POST], '/ajax', ContentListAjaxHandler::class)
                    ->setName(ContentListAjaxHandler::class);

                $app->group('/{content_id:\d+}', function (App $app) {
                    $app->map([HTTP::METHOD_GET, HTTP::METHOD_POST], '', ContentEditHandler::class)
                        ->setName(ContentEditHandler::class);

                    $app->post('/content_photo/create', ContentPhotoCreateHandler::class)
                        ->setName(ContentPhotoCreateHandler::class);

                    $app->get('/content_photo/list', ContentPhotoListHandler::class)
                        ->setName(ContentPhotoListHandler::class);
                });

                $app->group('/content_photo/{content_photo_id:\d+}', function (App $app) {
                    $app->get('/delete', ContentPhotoDeleteHandler::class)
                        ->setName(ContentPhotoDeleteHandler::class);
                    $app->get('/set_default', SetDefaultContentPhotoHandler::class)
                        ->setName(SetDefaultContentPhotoHandler::class);
                });
            });
        });
    }

}
