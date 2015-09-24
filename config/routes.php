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
  
  $routes->post('kurssit/:tunniste/edit', function($tunniste){
      KurssiController::update($tunniste);
  });
  
  $routes->post('/kurssi', function(){
      KurssiController::store();
  });
  
  $routes->get('/kurssit/:tunniste/edit', function($tunniste){
      KurssiController::edit($tunniste);
  });
  
  
  $routes->post('/kurssit/:tunniste/destroy', function($tunniste){
      KurssiController::destroy($tunniste);
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
  


