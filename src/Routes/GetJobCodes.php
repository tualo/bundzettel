<?php
namespace Tualo\Office\Bundzettel\Routes;

use Tualo\Office\Basic\TualoApplication as App;
use Tualo\Office\Basic\Route as BasicRoute;
use Tualo\Office\Basic\IRoute;

class GetJobCodes implements IRoute{
    public static function register(){
        BasicRoute::add('/bundzettel/jobcodes/(?P<dateiname>[\w\-\_]+)/(?P<auftrag>[\w\-\_]+)',function($matches){
            App::contenttype('application/json');

            $db = App::get('session')->getDB();
            $codes = $db->direct('
            
            insert ignore into pm_bundzettel (
                id,
                create_login,
                update_login,
                found,
                dateiname,
                auftrag,
                bund,
                scantype,
                gepl_zustellung
            )
            
            
            
            select
                concat(pm_codescann_data.id,\'-\',postcon_importe_sendung.p9) id,
                pm_codescann_data.create_login,
                pm_codescann_data.update_login,
                3 found,
                postcon_importe_sendung.dateiname,
                postcon_importe_sendung.auftrag,
                postcon_importe_sendung.p9 bund,
                \'manuelle Erfassung\'  scantype,
                date_add( pm_codescann_data.create_time, interval +1 day )  gepl_zustellung
            from
                pm_codescann_data 
                join postcon_importe_sendung on ( pm_codescann_data.dateiname,pm_codescann_data.auftrag)
                =( postcon_importe_sendung.dateiname,postcon_importe_sendung.auftrag)
            where typ in (\'aktionsnr_vkz\') and status = \'testcode\'
                and pm_codescann_data.create_time>=
                date_add( pm_codescann_data.create_time, interval -2 day )
            
            union
            
            select
                id id,
                create_login,
                update_login,
                3 found,
                dateiname,
                auftrag,
                bund,
                \'manuelle Erfassung\'  scantype,
                date_add( create_time, interval +1 day )  gepl_zustellung
            from
                pm_codescann_data 
            where typ in (\'bundschein\',\'upoc\',\'useid\',\'sendungsid\') and status = \'testcode\'
                and create_time>=
                date_add( create_time, interval -2 day )
            union 
            
            
            select
                id id,
                create_login,
                update_login,
                3 found,
                dateiname,
                auftrag,
                bund,
                \'maschinelle Erfassung\'  scantype,
                date_add( create_time, interval +1 day )  gepl_zustellung
            from
                pm_codescann_data 
            where typ in (\'bundschein\',\'upoc\',\'useid\',\'sendungsid\') and status = \'testcodemachine\'
            
                and create_time>=
                date_add( create_time, interval -2 day )
            
            
            

            ');
            App::set( "success",true );
            App::set( "data", $codes );
            
        },array('get'),true);

    }
}