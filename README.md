<p align="center">
 <img src="https://i.imgur.com/rSyq3MW.png" alt="The Documentation Compendium"></a>
</p>

<h1 align="center">Mudrock Framework</h1>

<div align="center">

![GitHub go.mod Go version of a Go module](https://badgen.net/badge/Versão/1.0.0/green)
![License](https://img.shields.io/badge/license-MIT-blue.svg)
[![PHP Version Require](http://poser.pugx.org/badges/poser/require/php)](https://packagist.org/mudrock/mudrock)


<!--   <a href="https://www.producthunt.com/posts/the-documentation-compendium?utm_source=badge-top-post-badge&utm_medium=badge&utm_souce=badge-the-documentation-compendium" target="_blank"><img src="https://api.producthunt.com/widgets/embed-image/v1/top-post-badge.svg?post_id=157965&theme=dark&period=daily" alt="The Documentation Compendium - Beautiful README templates that people want to read. | Product Hunt Embed" style="width: 250px; height: 54px;" width="250px" height="54px" /></a> -->

</div>

---

<p align = "center">💡 Mudrock is a MVC PHP framework, which was inspired by the Laravel and CodeIgniter frameworks.<br />Discover all the features:</p>


## Table of Contents

- [Requirements](#requirements)
- [Installation](#install)
- [Routes](#routes)
    - [Allowed request types](#allowed_requests)
    - [How to define routes](#how_to_define_routes)


## Requirements <a name = "requirements"></a>

- [Composer](https://getcomposer.org/)
- [Docker](https://www.docker.com/)

<br />

## Installation <a name = "install"></a>

- Install by <b>Composer:</b>
```shell
composer create-project mudrock/mudrock my-project
```

- Run by <b>Docker:</b>
```shell
cd my-project
docker-compose build
docker-compose up
```

- Now open your browser and access the URL:
```
https://localhost:8000
```

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

- You can declare the route using a method of some Controller:
```php
$this->get('/MyRoute', 'MyController@MyFunction'); 
```

- Or simply define a callback:
```php
$this->get('/MyRoute', function(){
    return "This is my callback when accessing this route";
}); 
```