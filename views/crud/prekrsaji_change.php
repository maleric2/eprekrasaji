<h1 class="center">Ažuriraj prekrsaj <?php //echo $this->user['korIme'] ?></h1>
   <?php /* DODAT I SLIKE VEZANE I SVE OSTALO */
  $prekrsajDate=date("Y-m-d", strtotime($this->prekrsaj['vrijeme_prekrsaja']));
  $prekrsajTime=date("H:i:s", strtotime($this->prekrsaj['vrijeme_prekrsaja']));
  ?>
  <form id="forma3" name="details" class="form-horizontal" action="<?php echo URL ?>crud/prekrsaji/update/<?php echo $this->prekrsaj["id_prekrsaji"] ?>" method="POST" >
      <fieldset class="panel panel-default">
          <div class="panel-body">
              <div class="form-group">
                <label class="col-md-4 control-label"" for="ime">Ime</label>
                <div class="col-md-5">
                    <input class="input-md form-control" type="text" autofocus name="ime" id="ime" value="<?php echo $prekrsajDate;?>" >
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label" for="prezime">Prezime</label>
                <div class="col-md-5">
                    <input class="input-md form-control" type="text" name="prezime" id="prezime" value="<?php echo $prekrsajTime;?>"  >
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label" for="oib">OIB</label>
                <div class="col-md-5">
                    <input class="input-md form-control" type="text" name="oib" id="oib" value="<?php echo $this->prekrsaj['mjesto'];?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label" for="adresa">Adresa</label>
                <div class="col-md-5">
                    <input class="input-md form-control" type="text" name="adresa" id="adresa" value="<?php echo $this->prekrsaj['opis'];?>" >
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label" for="register"></label>
                <div class="col-md-5">
                  <button id="register" name="change" class="btn btn-primary btn-block">Ažuriraj</button>
                </div>
              </div>
            </div>
      </fieldset>
</form>
