
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/default.css" />
    -->
    <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/maleric2.css">
    
    <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/bootstrap.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="<?php echo URL; ?>public/js/bootstrap.js"></script>
    <!-- Owl Carousel Assets -->
    <link href="<?php echo URL; ?>public/css/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo URL; ?>public/css/owl.theme.css" rel="stylesheet">
    <title>ePrekršaji</title>
        
</head>
<body>
    <div id="pageContainer">
  <?php Session::init();   ?>  
    
    <!--
    -->
    
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <a class="navbar-brand" href="#"><img style="margin-top: -8px"src="<?php echo URL; ?>/public/img/logo.png" height="38px"></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?php echo URL; ?>index">Home</a></li>
            <?php if(Session::get('loggedIn')==true):?>
                <li><a href="<?php echo URL; ?>korisnici">Korisnici</a></li>
                <li><a href="<?php echo URL; ?>admin">Admin</a></li>
            <?php endif; ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php if(Session::get('loggedIn')==false):?>
                <li><a href="<?php echo URL; ?>register">Registracija</a></li>
                <li><a href="<?php echo URL; ?>login">Login</a></li>
            <?php else: ?>
                <li><a href="<?php echo URL; ?>login/logout">Logout</a></li>
            <?php endif; ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    
    
    
    <!-- <nav id="izbornik">
        <ul>
            <li><a href="<?php echo URL; ?>index">Index</a></li>
            
            <?php if(Session::get('loggedIn')==true):?>
                <li><a href="<?php echo URL; ?>korisnici">Korisnici</a></li>
                <li><a href="<?php echo URL; ?>login/logout">Logout</a></li>
            <?php else: ?>
                <li><a href="<?php echo URL; ?>register">Registracija</a></li>
                <li><a href="<?php echo URL; ?>login">Login</a></li>
            <?php endif; ?>
                <li><a href="<?php echo URL; ?>logs/report.html">Testiranje</a></li>
        </ul>
    </nav>-->
    <header>
       ePrekršaji 
    </header>


    <section  class="container" id="pageContent">
        <div>
            <?php     
            
            $cookie=isset($_COOKIE['user']);
            if (empty($cookie)) echo "Dobrodosli";
                else echo "Dobrodosao ".$cookie;?>
        </div>
	
