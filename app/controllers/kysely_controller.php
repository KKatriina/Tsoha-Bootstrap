<?php

class KyselyController extends BaseController{
    public static function index() {
//        $kyselyt = Kysely::keraa_tiedot();
//        View::make('kyselyt/index.html', array('kyselyt' => $kyselyt));
        View::make('/kyselyt/index.html');
    }
    
    public static function uusi() {
        View::make('/kyselyt/new.html');
    }
    
    public static function save() {
        $params = $_POST;
        $kysely = new Kysely(array(
            'kurssi' => $params['kurssi'],
            'aika' => $params['aika'],
            'kyselyn_nimi' => $params['kyselyn_nimi'],
            'paattyminen' => $params['paattyminen'],
            'tarkoitus' => $params['tarkoitus']
        ));
        
                
        $kysely->save();
        
        Redirect::to('/kyselyt');
    
    }
}