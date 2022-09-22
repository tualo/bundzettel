<?php
namespace Tualo\Office\Bundzettel\Routes;

use Tualo\Office\Basic\TualoApplication as App;
use Tualo\Office\Basic\Route as BasicRoute;
use Tualo\Office\Basic\IRoute;

class AppTree implements IRoute{
    public static function register(){
        BasicRoute::add('/cmp_pm_bundzettel/apptree',function($matches){
            $session = App::get('session');
            $db = $session->getDB();
            try{   
        
                App::result('data',$db->direct('select modell from postcon_importe group by modell'));
                App::result('success', true );
        
            }catch(\Exception $e){
                App::result('msg', $e->getMessage());
            }
            App::contenttype('application/json');
        
        },array('get','post'),true);

    }
}