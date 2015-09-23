<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/etusivu', function() {
  HelloWorldController::etusivu();
  });
  
  $routes->get('/kurssit', function() {
  KurssiController::index();
  });
  
  $routes->get('/kyselyt', function() {
  HelloWorldController::kyselyt();
  });
  
  $routes->get('/muokkaa_kurssia', function() {
  HelloWorldController::muokkaa_kurssia();
  });
  
  
  $routes->get('/kurssin_esittelysivu', function() {
  HelloWorldController::kurssin_esittelysivu();
  });
  
  $routes->get('/tervetuloa', function() {
  HelloWorldController::tervetuloa();
  });

  $routes->get('/kurssit/new', function(){
     KurssiController::uusi(); 
  });
  
  $routes->get('/kurssit/:tunniste', function($tunniste){
      KurssiController::show($tunniste); 
  });  
  
  $routes->post('kurssit/:tunniste/update', function($tunniste){
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
  


