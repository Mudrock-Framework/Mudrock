<?php

// To include other files, just use the following code:
echo callFile('header');

// Using the translation function
$this->lang('example');

echo '<div class="separator"></div>';

echo '<pre>';
print_r($users);
echo '</pre>';

echo '<div class="separator"></div>';

echo '<pre>';
print_r($this->model->getUser('users', 1));
echo '</pre>';

echo '<div class="separator"></div>';

echo '<pre>';
print_r($this->model->getUser('users', 2));
echo '</pre>';

?>

<div class="main text-center">
    Welcome to <b>Mudrock Framework <?php getVersion() ?></b>
</div>