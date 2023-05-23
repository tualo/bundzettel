<?php

namespace Tualo\Office\Bundzettel\Middlewares;
use Tualo\Office\Basic\TualoApplication as App;
use Tualo\Office\Basic\IMiddleware;

class Middleware implements IMiddleware{
    public static function register(){
        App::use('bundzettel',function(){
            try{
                // App::javascript('bundzettel_loader', './bundzettel/loader.js',[],1000);
            }catch(\Exception $e){
                App::set('maintanceMode','on');
                App::addError($e->getMessage());
            }
        },-100);
    }
}