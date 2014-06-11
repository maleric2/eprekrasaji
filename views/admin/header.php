
    
<div class="row">
    <div class="col-xs-10 col-md-2">
        <div class="sidebar-nav" id="admin_tools">
    <div class="well">
		<ul class="nav nav-list"> 
		  <li class="nav-header">Admin Menu</li>        
		  <li><a href="index"><i class="icon-home"></i> Dashboard</a></li>
          <li><a href="#"><i class="icon-envelope"></i> Messages <span class="badge badge-info">4</span></a></li>
          <li><a href="#"><i class="icon-comment"></i> Comments <span class="badge badge-info">10</span></a></li>
		  <li class="active"><a href="<?php echo URL; ?>admin/korisnici"><i class="icon-user"></i> Korisnici</a></li>
		  <li class="active"><a href="<?php echo URL; ?>admin/prekrsaji"><i class="icon-user"></i> Prekršaji</a></li>
          <li class="divider"></li>
		  <li><a href="#"><i class="icon-comment"></i> Settings</a></li>
		  <li><a href="#"><i class="icon-share"></i> Logout</a></li>
		</ul>
	</div>
</div>
 <script>
 jQuery(function() {
     _RESIDED_WIDTH=998;
     $( window ).scroll(function() {
         
         //if($( window ).width()>_RESIDED_WIDTH)
        //$("#admin_tools").stop().animate({"marginTop": ($(window).scrollTop()) + "px", "marginLeft":($(window).scrollLeft()) + "px"}, "normal" );
     })
 })
</script>      
       
    </div>
  <div class="col-xs-12 col-md-10" id="admin_content">