<h1 class="center">Ažuriraj prekrsaj <?php //echo $this->user['korIme']  ?></h1>
<?php
/* DODAT I SLIKE VEZANE I SVE OSTALO */
$prekrsajDate = date("Y-m-d", strtotime($this->prekrsaj['vrijeme_prekrsaja']));
$prekrsajTime = date("H:i:s", strtotime($this->prekrsaj['vrijeme_prekrsaja']));
?>
<script src="<?php echo URL; ?>public/js/slider.js"></script>

<div id="sync1" class="owl-carousel">
  <?php
    foreach ($this->datoteke as $value){
        echo "<div class='item'><img src='".URL.$value['putanja']."'></div>";
    }
    ?>
</div>
<div id="sync2" class="owl-carousel">
  <?php
    foreach ($this->datoteke as $value){
        echo "<div class='item'><img src='".URL.$value['putanja']."'></div>";
    }
    ?>
</div>





<form id="forma3" name="details" class="form-horizontal" action="<?php echo URL ?>crud/prekrsaji/update/<?php echo $this->prekrsaj["id_prekrsaji"] ?>" method="POST" >
    <fieldset class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-md-4 control-label"" for="datum">Datum</label>
                <div class="col-md-5">
                    <input class="input-md form-control" disabled type="date" name="ime" id="ime" value="<?php echo $prekrsajDate; ?>" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="vrijeme">Vrijeme</label>
                <div class="col-md-5">
                    <input class="input-md form-control" disabled type="time" name="vrijeme" id="vrijeme"  value="<?php echo $prekrsajTime; ?>"  >
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="mjesto">Mjesto</label>
                <div class="col-md-5">
                    <input  class="input-md form-control" disabled type="text" name="mjesto" id="mjesto" value="<?php echo $this->prekrsaj['mjesto']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="opis">Opis</label>
                <div class="col-md-5">
                    <input class="input-md form-control" disabled type="text" name="opis" id="opis" value="<?php echo $this->prekrsaj['opis']; ?>" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="vrijeme_zastare">Vrijeme zastare</label>
                <div class="col-md-5">
                    <input class="form-control"  disabled type="datetime" id="vrijeme_zastare" name="vrijeme_zastare" value="<?php echo $this->prekrsaj['vrijeme_zastare']; ?>">
                </div>
            </div>
            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="policajac_oib_policajac">Policajac</label>
                <div class="col-md-5">
                    <select id="policajac_oib_policajac" disabled name="policajac_oib_policajac" class="form-control">
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
                    <select id="id_kategorije_prekrsaja" disabled name="id_kategorije_prekrsaja" class="form-control">
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

        </div>
    </fieldset>
</form>

<?php if ($this->datoteke[0]): ?>
<h1>Galerija slika</h1>

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