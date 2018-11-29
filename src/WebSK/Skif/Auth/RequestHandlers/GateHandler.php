<?php

namespace WebSK\Skif\Auth\RequestHandlers;

use Slim\Http\Request;
use Slim\Http\Response;
use WebSK\Slim\RequestHandlers\BaseHandler;

/**
 * Class GateHandler
 * @package WebSK\Skif\Auth\RequestHandlers
 */
class GateHandler extends \WebSK\Slim\RequestHandlers\BaseHandler
{
    /**
     * @param Request $request
     * @param Response $response
     */
    public function __invoke(Request $request, Response $response)
    {
        \Hybrid_Endpoint::process();

        return;
    }
}
