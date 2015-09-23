<?php

class User extends BaseModel {
    public $nimi, $salasana, $laitos, $nimike;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        
    }
    
    public static function find($nimi){
        $query = DB::connection()->prepare('SELECT * FROM OPETTAJA WHERE nimi = :nimi LIMIT 1');
        $query->execute(array('nimi' => $nimi));
        $row = $query->fetch();
        
        if ($row){
            $opettaja = new User(array(
                'nimi' => $row['nimi'],
                'salasana' => $row['salasana'],
                'laitos' => $row['laitos'],
                'nimike' => $row['nimike']
            ));
            
            return $opettaja;
        }
    }
    
    public function authenticate($nimi, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM OPETTAJA WHERE nimi = :nimi AND salasana = :salasana LIMIT 1');
        $query->execute(array('nimi' => $nimi, 'salasana' => $salasana));
        $row = $query->fetch();
        if($row){
                $user = new User(array(
                'nimi' => $row['nimi'],
                'salasana' => $row['salasana'],
                'laitos' => $row['laitos'],
                'nimike' => $row['nimike']
            ));
            
            return $user;
        }else{
            return null;
        }
    }
}