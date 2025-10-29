<?php

namespace Tualo\Office\Bundzettel\Routes;

use Tualo\Office\Basic\TualoApplication as App;
use Tualo\Office\Basic\Route as BasicRoute;
use Tualo\Office\Basic\IRoute;

class RegisterClient extends \Tualo\Office\Basic\RouteWrapper
{
    public static function register()
    {
        BasicRoute::add('/cmp_pm_bundzettel/registerclient', function ($matches) {

            //$tablename = $matches['tablename'];
            $session = App::get('session');
            $db = $session->getDB();
            try {

                $token = $session->registerOAuth($params = array('cmp' => 'cmp_ds'), $force = false, $anyclient = false, $path = '/cmp_pm_bundzettel/*');
                $session->oauthValidDays($token, 7);

                App::result('token', $token);
                App::result('success', true);
            } catch (\Exception $e) {
                App::result('msg', $e->getMessage());
            }
            App::contenttype('application/json');
        }, array('get', 'post'), true);
    }
}
