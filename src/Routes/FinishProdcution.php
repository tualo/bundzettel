<?php
namespace Tualo\Office\Bundzettel\Routes;

use Tualo\Office\Basic\TualoApplication as App;
use Tualo\Office\Basic\Route as BasicRoute;
use Tualo\Office\Basic\IRoute;

class FinishProduction implements IRoute{
    public static function register(){
        BasicRoute::add('/cmp_pm_bundzettel/finish_production',function($matches){
            $session = App::get('session');
            $db = $session->getDB();
            try{
        
                if (!isset($_REQUEST['code'])) throw new \Exception("Code not set");
                $db->direct('update eingangs_barcodes set closed_at = now(), closed_by=getSessionUser() where barcode = {code} and closed_at is null',$_REQUEST);
                App::result('success', true);
        
            }catch(\Exception $e){
                App::result('msg', $e->getMessage());
            }
            App::contenttype('application/json');
        
        },array('get','post'),true);

    }
}