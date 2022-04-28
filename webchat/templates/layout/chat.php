<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$Description = 'Webchat';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $Description ?>:
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body onload="fun">
    <nav class="top-nav" style="background-color:#99FF00;min-width:100%">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build('/chat') ?>"><span>FEED</span></a>
        </div>
        <div class="top-nav-links">
               <?php
                    echo "Chào mừng <span>$name<span> đến với SCS";
               ?>
            <a href="/user/logout">Đăng Xuất</a>
        </div>
    </nav>
    <main class="main">
        <div class="container" style="background-image: url();height: 100%;background-position: center;
  background-repeat: no-repeat;
  background-size: cover;">
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
        <!-- <div style="width:100%;background-color:lightblue;height:100px;position:fixed;">
            
        </div> -->
    </footer>
</body>
<script>
    function fun(){
        

    } 
</script>
</html>

