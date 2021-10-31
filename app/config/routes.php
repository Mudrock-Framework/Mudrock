<?php

$this->get('/', 'Welcome@index');

$this->post('/', function(){
    echo 'Requisição do tipo POST';
});