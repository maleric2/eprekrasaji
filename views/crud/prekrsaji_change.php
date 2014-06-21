<h1 class="center">Ažuriraj prekrsaj <?php //echo $this->user['korIme']            ?></h1>
<?php
/* DODAT I SLIKE VEZANE I SVE OSTALO */
$prekrsajDate = date("Y-m-d", strtotime($this->prekrsaj['vrijeme_prekrsaja']));
$prekrsajTime = date("H:i:s", strtotime($this->prekrsaj['vrijeme_prekrsaja']));
$prekrsajZastaraDate = date("Y-m-d", strtotime($this->prekrsaj['vrijeme_zastare']));
?>
<script src="<?php echo URL; ?>public/js/slider.js"></script>

<form id="forma3" name="details" class="form-horizontal" action="<?php echo URL ?>crud/prekrsaji/change/<?php echo $this->prekrsaj["id_prekrsaji"] ?>" method="POST" >
    <fieldset class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-md-4 control-label" for="oib">Prekršitelj</label>
                <div class="col-md-5" id="PrekrsiteljiCbox">
                    <?php  foreach ($this->korisniciPrekrsaja as $value)
                      echo "<div class='checkbox checkbox-block'><label for='checkboxes-0'>"
                        . "<input type='checkbox' checked name='oib[]' value='{$value["oib"]}'>"
                        . "{$value["ime"]} {$value["prezime"]}"
                        . '<span class="glyphicon glyphicon-remove pull-right"></span></label></div>';
                      ?>
                    
                </div>
            </div>
        <div class="form-group has-success has-feedback">
            <label class="col-md-4 control-label"" for="PrekrsiteljNovi"></label>
            
            <div class="col-md-5">
                <span class="help-block">Dodaj novog</span>
                <select id="PrekrsiteljNovi" name="PrekrsiteljNovi" class="form-control no-arrow">
                    <?php
                    foreach ($this->korisnici as $value)
                        echo "<option value='{$value["oib"]}'>{$value["ime"]} {$value["prezime"]}</option>";
                    ?>
                    
                </select>
                
                <span class="glyphicon glyphicon-plus form-control-feedback"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label"" for="datum">Datum</label>
            <div class="col-md-5">
                <input class="input-md form-control" type="date" autofocus name="datum" id="datum" value="<?php echo $prekrsajDate; ?>" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="vrijeme">Vrijeme</label>
            <div class="col-md-5">
                <input class="input-md form-control" type="time" name="vrijeme" id="vrijeme"  value="<?php echo $prekrsajTime; ?>"  >
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="mjesto">Mjesto</label>
            <div class="col-md-5">
                <input  class="input-md form-control" type="text" name="mjesto" id="mjesto" value="<?php echo $this->prekrsaj['mjesto']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="opis">Opis</label>
            <div class="col-md-5">
                <input class="input-md form-control" type="text" name="opis" id="opis" value="<?php echo $this->prekrsaj['opis']; ?>" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="vrijeme_zastare">Vrijeme zastare</label>
            <div class="col-md-5">
                <input class="form-control" type="date" id="vrijeme_zastare" name="vrijeme_zastare" value="<?php echo $prekrsajZastaraDate ?>">
            </div>
        </div>
        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="policajac_oib_policajac">Policajac</label>
            <div class="col-md-5">
                <select id="policajac_oib_policajac" name="policajac_oib_policajac" class="form-control">
                    <?php
                    foreach ($this->policajci as $value) {
                        if ($value["oib"] == $this->prekrsaj["policajac_oib_policajac"])
                            echo "<option selected value='{$value["oib"]}'>{$value["ime"]} {$value["prezime"]}</option>";
                        else
                            echo "<option value='{$value["oib"]}'>{$value["ime"]} {$value["prezime"]}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="id_kategorije_prekrsaja">Kategorija</label>
            <div class="col-md-5">
                <select id="id_kategorije_prekrsaja" name="id_kategorije_prekrsaja" class="form-control">
                    <?php
                    foreach ($this->kategorije as $value) {
                        if ($value['id_kategorije_prekrsaja'] == $this->prekrsaj['id_kategorije_prekrsaja'])
                            echo "<option selected value='{$value["id_kategorije_prekrsaja"]}'>{$value["vrsta_prekrsaja"]}</option>";
                        else
                            echo "<option value='{$value["id_kategorije_prekrsaja"]}'>{$value["vrsta_prekrsaja"]}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="register"></label>
            <div class="col-md-5">
                <button id="register" name="change" class="btn btn-primary btn-block">Ažuriraj</button>
            </div>
        </div>
        <?php if (!$this->datoteke[0]): ?>
            <div class="col-md-5 col-md-offset-4 btnCustomOffset">
                <a href="<?php echo URL ?>admin/slike/<?php echo $this->prekrsaj["id_prekrsaji"] ?>">
                    <button type="button" class="btn btn-success  btn-block">Dodaj slike</button>
                </a>
            </div>
        <?php endif; ?>
        </div>
    </fieldset>
</form>
<?php if ($this->datoteke[0]): ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-0"><h1>Galerija slika</h1></div>
        <div class="col-md-4 col-md-offset-4 btnCustomOffset">
            <a href="<?php echo URL ?>admin/slike/<?php echo $this->prekrsaj["id_prekrsaji"] ?>">
                <button type="button" class="btn btn-success  btn-block">Izmjeni slike</button>
            </a>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div id="gallery_sync1" class="owl-carousel">
                <?php
                foreach ($this->datoteke as $value) {
                    echo "<div class='item'><img src='" . URL . $value['putanja'] . " '></div>";
                }
                ?>
            </div>
            <div id="gallery_sync2" class="owl-carousel">
                <?php
                foreach ($this->datoteke as $value) {
                    echo "<div class='item'><img src='" . URL . $value['putanja'] . "'></div>";
                }
                ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<script src="<?php echo URL; ?>public/js/owl.carousel.min.js"></script>
<script src="<?php echo URL; ?>public/js/slider.js"></script>
<script src="<?php echo URL; ?>public/js/customSelectToCheckbox.js"></script>
