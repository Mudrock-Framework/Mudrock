<?php

$this->get('/', 'Welcome@index');

$this->get('/changeLanguage', 'Welcome@changeLanguage');

$this->get('/login', 'Welcome@login');