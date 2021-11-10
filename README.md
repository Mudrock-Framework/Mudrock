<p align="center">
 <!-- image -->
</p>

<h1 align="center">Mudrock Framework</h1>

<div align="center">

![GitHub go.mod Go version of a Go module](https://badgen.net/badge/Versão/1.0.0/green) &nbsp; &nbsp; 
![License](https://img.shields.io/badge/license-MIT-blue.svg) &nbsp; &nbsp;
[![PHP Version Require](http://poser.pugx.org/badges/poser/require/php)](https://packagist.org/mudrock/mudrock) 


<!--   <a href="https://www.producthunt.com/posts/the-documentation-compendium?utm_source=badge-top-post-badge&utm_medium=badge&utm_souce=badge-the-documentation-compendium" target="_blank"><img src="https://api.producthunt.com/widgets/embed-image/v1/top-post-badge.svg?post_id=157965&theme=dark&period=daily" alt="The Documentation Compendium - Beautiful README templates that people want to read. | Product Hunt Embed" style="width: 250px; height: 54px;" width="250px" height="54px" /></a> -->

</div>

---

<p align = "center">
💡 Mudrock is a MVC PHP framework, which was inspired by the Laravel and CodeIgniter frameworks.<br />Discover all the features:</p>

<br />

## Table of Contents

- [Requirements](#requirements)
- [Installation](#install)
- [Routes](#routes)
    - [Allowed request types](#allowed_requests)
    - [How to define routes](#how_to_define_routes)
- [Translations](#translations)
    
<br />

## Requirements <a name = "requirements"></a>

- [Composer](https://getcomposer.org/)
- [Docker](https://www.docker.com/)

<br />

## Installation <a name = "install"></a>

- Install by <b>Composer:</b>
```shell
composer create-project mudrock/mudrock my-project
```

<br />

- Run by <b>Docker:</b>
```shell
cd my-project
docker-compose build
docker-compose up
```

<br />

- Now open your browser and access the URL:
[http://localhost:8000](http://localhost:8000)

<br />

## Routes<a name = "routes"></a>

<br />

### Allowed request types:<a name = "allowed_requests"></a>

- GET
- POST

<br />

### How to define routes:<a name = "how_to_define_routes"></a>

- All routes must be defined in the file:
```html
app/config/routes.php
```

<br />

- You can declare the route using a method of some Controller:
```php
$this->get('/MyRoute', 'MyController@MyFunction'); 
```

<br />

- Or simply define a callback:
```php
$this->get('/MyRoute', function(){
    return "This is my callback when accessing this route";
}); 
```

<br />

## Translations:<a name = "translations"></a>

<div align="center" style="background-color: #ccc; color: black; border-radius: 10px">With the translations feature it is possible to have multiple languages in your project. All this simply quickly!</div>

<br>

- First, you need to create a folder named after the desired language. For example, we will use the language "Portuguese". So, we create the folder as desired:
```php
app/languages/portuguese/
```

<br>

- Now we need to create the files with the translations. We recommend creating a file for each Controller:
```php
app/languages/portuguese/MyController.php
```

<br>

- In the created file ("MyController.php"), we will have a structure similar to this:
```php
<?php

return [
    'my_phrase' => 'My sentence translated to the desired language'
];
```

<br>

- Now we need to load this translation file into the "<b>construct</b>" method of the Controller file:
```php
<?php
namespace app\controllers;
use system\core\Controller;

class Welcome extends Controller {

    public function __construct() {
        $this->load_language('MyController');
    }

}
?>
```

<br>

- Once that's done, we can now use our translation in the Controller and also in the View we are using:
```php
$this->lang('my_phrase');
```
