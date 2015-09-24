<?php

  $routes->get('/', function() {
      UserController::login();
  });
  


  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/etusivu', function() {
      UserController::login();
  });
  
  $routes->get('/kurssit', function() {
  KurssiController::index();
  });
  
  $routes->get('/kyselyt/new', function() {
  KyselyController::uusi();
  });
  
  $routes->get('/kyselyt', function() {
  KyselyController::index();
  });
  
  $routes->post('/kyselyt/uusi', function() {
      KyselyController::save();
  });
  
  $routes->get('/kyselyt/:tunniste', function($tunniste) {
      KyselyController::show($tunniste);
  });
  
  $routes->get('/kyselyt/:tunniste/lisaa_kysymys', function($tunniste) {
  KyselyController::add_question($tunniste);
  });
  
  $routes->get('/muokkaa_kurssia', function() {
  HelloWorldController::muokkaa_kurssia();
  });
  
  
  $routes->get('/kurssin_esittelysivu', function() {
  HelloWorldController::kurssin_esittelysivu();
  });
  
  $routes->get('/tervetuloa', function() {
    UserController::tervetulosivu();
  });

  $routes->get('/kurssit/new', function(){
     KurssiController::uusi(); 
  });
  

  
  $routes->get('/kurssit/:tunniste', function($tunniste){
      KurssiController::show($tunniste); 
  });  
  

  
  $routes->post('/kurssi', function(){
      KurssiController::store();
  });
  
  $routes->get('/kurssit/:tunniste/edit', function($tunniste){
      KurssiController::edit($tunniste);
  });
  
    $routes->post('/kurssit/:tunniste/edit', function($tunniste){
      KurssiController::update($tunniste);
  });
  
  
  $routes->post('/kurssit/:tunniste/destroy', function($tunniste){
      KurssiController::destroy($tunniste);
  });
  
  $routes->get('/kurssit/:tunniste/kyselyt', function($tunniste) {
  KyselyController::kurssin_kyselyt($tunniste);
  });
  
  $routes->get('/login', function() {
      UserController::login();
  });
  
  $routes->post('/login', function() {
      UserController::handle_login();
  });
  
  $routes->get('/user/tervetuloa', function() {
        UserController::tervetuloa();
  });
  
    $routes->get('/:nimi/omat_kurssit', function($nimi) {
  KurssiController::omat_kurssit($nimi);
  });
  

  

  


