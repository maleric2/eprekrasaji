<script type="text/javascript">
    var URL = '<?php echo URL ?>' ;    
</script>
<script src="<?php echo URL; ?>public/js/registration.js"></script>

<div class="container">
	<div class="row form-group">
        <div class="col-xs-12">
            <ul id="steps" class="nav nav-pills nav-justified thumbnail setup-panel">
                <li class="active"><a href="#step-1">
                    <h4 class="list-group-item-heading">Registracija</h4>
                    <p class="list-group-item-text">Registracija u sustav ePrekršaja</p>
                </a></li>
                <li class="disabled"><a href="#step-2">
                    <h4 class="list-group-item-heading">Unos detalja</h4>
                    <p class="list-group-item-text">Unos osobnih detalja</p>
                </a></li>
            </ul>
        </div>
	</div>
</div>

<form id="register_form" class="form-horizontal col-md-6 col-md-offset-3" role="form" method="POST" enctype='multipart/form-data' action="register/run" name="register">
    <fieldset class="panel panel-default">
        <!-- Form Name -->
        <div class="panel-heading">
            <h3 class="panel-title">Registration</h3>
        </div>
        
        <div class="panel-body">
        <!-- Text input-->
        <div class="form-group has-feedback">
          <label class="col-md-4 control-label" for="oib">OIB</label>
          <div class="col-md-5">
              <input id="oib" name="oib" type="text" placeholder="01234567899" class="input-md form-control" required autofocus>
            <p class="help-block">Unesi OIB</p>
          </div>
        </div>
        <!-- Text input-->
        <div class="form-group has-feedback">
          <label class="col-md-4 control-label" for="korime">Email</label>
          <div class="col-md-5">
              <input id="email" name="email" type="email" placeholder="email@something.com" class="input-md form-control" required="">
            <p class="help-block">Unesi korisničko ime</p>
          </div>
        </div>
        <!-- Text input-->
        <div class="form-group has-feedback">
          <label class="col-md-4 control-label" for="korime">Korisničko ime</label>
          <div class="col-md-5">
            <input id="korime" name="korime" type="text" placeholder="username" class="input-md form-control" required="">
            <span class="glyphicon form-control-feedback"></span>
            <p class="help-block">Unesi korisničko ime</p>
          </div>
        </div>

        <!-- Password input-->
        <div class="form-group has-feedback">
          <label class="col-md-4 control-label" for="pass">Lozinka</label>
          <div class="col-md-5">
              <input id="pass" name="pass" type="password" placeholder="password" class="input-md form-control" required="">
              <p class="help-block" style="display:none"></p>
          </div>
        </div>
        <!-- Password input-->
        <div class="form-group has-feedback">
          <label class="col-md-4 control-label" for="pass2">Ponovi Lozinku</label>
          <div class="col-md-5">
              <input id="pass2" name="pass2" type="password" placeholder="password" class="input-md form-control" required="">
              <p class="help-block" style="display:none"></p>
          </div>
        </div>
        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="register_next"></label>
          <div class="col-md-5">
            <button id="register_next" name="register_next" class="btn btn-primary btn-block">Dalje</button>
          </div>
        </div>
        </div>
    </fieldset>
</form>

<form id="register_form2" style="display:none" class="form-horizontal col-md-6 col-md-offset-3 thumbnail" role="form" method="POST" enctype='multipart/form-data' action="register/run" name="register2">
<fieldset>

    <!-- Form Name -->
    <legend>Vaši detalji</legend>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="ime">Ime</label>  
      <div class="col-md-4">
        <input id="ime" name="ime" type="text" placeholder="Ante" class="form-control input-md">
        <span class="help-block">Unesi Ime</span>  
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="prezime">Prezime</label>  
      <div class="col-md-4">
      <input id="prezime" name="prezime" type="text" placeholder="Antic" class="form-control input-md">
      <span class="help-block">Unesi Prezime</span>  
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="adresa">Adresa</label>  
      <div class="col-md-5">
      <input id="adresa" name="adresa" type="text" placeholder="10000 Zagreb" class="form-control input-md">
      <span class="help-block">Unesi adresu</span>  
      </div>
    </div>

    <!-- File Button --> 
    <div class="form-group">
      <label class="col-md-4 control-label" for="avatar">Profilna slika</label>
      <div class="col-md-4">
        <input id="avatar" name="avatar" class="input-file" type="file">
      </div>
    </div>
    <!-- Button -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="register_end"></label>
      <div class="col-md-5">
        <button id="register_end" name="register_end" class="btn btn-success btn-block">Dovrši</button>
      </div>
    </div>
</fieldset>
</form>
