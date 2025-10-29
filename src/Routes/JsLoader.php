<?php

namespace Tualo\Office\Bundzettel\Routes;

use Tualo\Office\Basic\TualoApplication as App;
use Tualo\Office\Basic\Route as BasicRoute;
use Tualo\Office\Basic\IRoute;

class JsLoader extends \Tualo\Office\Basic\RouteWrapper
{
    public static function register()
    {
        BasicRoute::add('/bundzettel/loader.js', function ($matches) {
            App::contenttype('application/javascript');
            $list = [
                "js/views/controller/Viewport.js",
                "js/views/models/Viewport.js",
                "js/views/SetupAuthToken.js",
                "js/views/Viewport.js"
            ];
            $content = '';
            foreach ($list as $item) {
                $content .= file_get_contents(dirname(__DIR__, 1) . '/' . $item) . PHP_EOL . PHP_EOL;
            }
            App::body($content);
        }, array('get'), false);
    }
}
