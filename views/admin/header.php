
<script src="<?php echo URL; ?>public/js/scrollSidebar.js"></script>
<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand"><a href="#">Start Bootstrap</a>
            </li>
            <li><a href="#">Dashboard</a>
            </li>
            <li><a href="#">Shortcuts</a>
            </li>
            <li><a href="#">Overview</a>
            </li>
            <li ><a href="<?php echo URL; ?>admin/korisnici"><i class="glyphicon glyphicon-user"></i> Korisnici</a></li>
            <li ><a href="<?php echo URL; ?>admin/prekrsaji"><i class="icon-user"></i> Prekršaji</a></li>
            <li ><a href="<?php echo URL; ?>admin/zalbe"><i class="icon-user"></i> Žalbe</a></li>
            <li ><a href="<?php echo URL; ?>admin/slike"><i class="icon-user"></i> Slike</a></li>
            <li ><a href="<?php echo URL; ?>admin/uprave"><i class="glyphicon glyphicon-bookmark"></i> Policijske Uprave</a></li>
            <li ><a href="<?php echo URL; ?>admin/zupanije">Županije</a></li>
        </ul>
    </div>
    <!--<div class="col-xs-10 col-md-2 ">
        <div class="sidebar-nav panel panel-default" id="admin_tools">
                <ul class="nav nav-pills nav-stacked panel-body"> 
                  <li class="nav-header">Admin Menu</li>        
                  <li><a href="index"><i class="icon-home"></i> Dashboard</a></li>
          <li><a href="#"><i class="icon-envelope"></i> Messages <span class="badge badge-info">4</span></a></li>
                  <li ><a href="<?php echo URL; ?>admin/korisnici"><i class="icon-user"></i> Korisnici</a></li>
                  <li ><a href="<?php echo URL; ?>admin/prekrsaji"><i class="icon-user"></i> Prekršaji</a></li>
                  <li ><a href="<?php echo URL; ?>admin/slike"><i class="icon-user"></i> Slike</a></li>
                  <li ><a href="<?php echo URL; ?>admin/slike"><i class="icon-user"></i> Slike</a></li>
          <li class="divider"></li>
                  <li><a href="#"><i class="icon-comment"></i> Settings</a></li>
                  <li><a href="#"><i class="icon-share"></i> Logout</a></li>
                </ul>
</div>
  
       
    </div>-->
    <!--<div class="col-xs-12 col-md-10" id="admin_content">-->
    <div id="page-content-wrapper">

        <div class="page-content inset">
            <a id="menu-toggle" href="#" class="btn btn-default"><i class="icon-reorder">MENU</i></a>
            <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="btn btn-default"><i class="icon-reorder">BACK</i></a>
