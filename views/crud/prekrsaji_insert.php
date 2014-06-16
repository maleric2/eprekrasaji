<h1 class="center">Novi prekrsaj <?php //echo $this->user['korIme']    ?></h1>

<?php /* DODAT I SLIKE VEZANE I SVE OSTALO */
?>
<form id="forma3" name="details" class="form-horizontal" action="<?php echo URL ?>crud/prekrsaji/insert/" method="POST" enctype="multipart/form-data">
    <fieldset class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-md-4 control-label"" for="datum">Datum</label>
                <div class="col-md-5">
                    <input class="input-md form-control" type="date" autofocus name="datum" id="datum" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="vrijeme">Vrijeme</label>
                <div class="col-md-5">
                    <input class="input-md form-control" type="time" name="vrijeme" id="vrijeme"  >
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="mjesto">Mjesto</label>
                <div class="col-md-5">
                    <input class="input-md form-control" type="text" name="mjesto" id="mjesto">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="opis">Opis</label>
                <div class="col-md-5">
                    <textarea class="form-control" id="opis" name="opis"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="vrijeme_zastare">Vrijeme zastare</label>
                <div class="col-md-5">
                    <input class="form-control" type="date" id="vrijeme_zastare" name="vrijeme_zastare">
                </div>
            </div>

            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="policajac_oib_policajac">Policajac</label>
                <div class="col-md-5">
                    <select id="policajac_oib_policajac" name="policajac_oib_policajac" class="form-control">
                        <?php
                        foreach ($this->policajci as $value)
                            echo "<option value='{$value["oib"]}'>{$value["ime"]} {$value["prezime"]}</option>";
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
                        foreach ($this->kategorije as $value)
                            echo "<option value='{$value["id_kategorije_prekrsaja"]}'>{$value["vrsta_prekrsaja"]}</option>";
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4 control-label" for="picture">Slike</label>
                <div class="col-md-5">
                    <div id="putImage">
                        
                    </div>
                    <input id="picture" type="file" multiple name="picture[]" onchange="PreviewImage();" />
                </div>
            </div>


            
            <div class="form-group">
                <label class="col-md-4 control-label" for="register"></label>
                <div class="col-md-5">
                    <button id="register" name="change" class="btn btn-primary btn-block">Unesi novi prekršaj</button>
                </div>
            </div>
    </fieldset>
</form>

            <!-- Image Preview, stavlja na #putImage -->
<script type="text/javascript" src="<?php echo URL; ?>public/js/PreviewImage.js"></script>