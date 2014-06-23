
<script src="<?php echo URL; ?>public/js/scrollSidebar.js"></script>
<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand"><a href="#">Admin Panel</a>
            </li>
            <li><a href="#">Početna</a>         </li>
            <li ><a href="<?php echo URL; ?>admin/korisnici"><i class="glyphicon glyphicon-user"></i> Korisnici</a></li>
            <li ><a href="<?php echo URL; ?>admin/policajci"><i class="glyphicon glyphicon-user"></i> Policajci</a></li>
            <li ><a href="<?php echo URL; ?>admin/prekrsaji"><i class="icon-user"></i> Prekršaji</a></li>
            <li ><a href="<?php echo URL; ?>admin/zalbe"><i class="icon-user"></i> Žalbe</a></li>
            <li ><a href="<?php echo URL; ?>admin/slike"><i class="icon-user"></i> Slike</a></li>
            <li ><a href="<?php echo URL; ?>admin/uprave"><i class="glyphicon glyphicon-bookmark"></i> Policijske Uprave</a></li>
            <li ><a href="<?php echo URL; ?>admin/zupanije">Županije</a></li>
            <li ><a href="<?php echo URL; ?>admin/sustav/log">Log</a></li>
            <li ><a href="<?php echo URL; ?>statistika/userStatistic/1">Statistika</a></li>
        </ul>
    </div>
    <div id="page-content-wrapper">

        <div class="page-content inset">
            <a id="menu-toggle" href="#" class="btn btn-default"><i class="icon-reorder">MENU</i></a>
            <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="btn btn-default"><i class="icon-reorder">BACK</i></a>
