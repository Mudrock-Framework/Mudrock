<?php

// To include other files, just use the following code:
echo callFile('header');

// Using the translation function
$this->lang('example');

echo '<div class="separator"></div>';

?>

<div class="main text-center">
    Welcome to <b>Mudrock Framework <?php getVersion() ?></b>
</div>