<article>
    <h2><?php
        if ($this->currentUser["id_statusRacuna"] == 1) {
            echo "Niste aktivirali račun";
        }
        ?></h2>
    <h1> Nova Žalba</h1>

    <div id="putImage" class="blockquote-reverse">
    </div>
    <br>
    <?php //echo $this->prekrsaj['id_prekrsaja']; ?>
    <form id="formUprave" name="uplPictures" class="form-horizontal" action="<?php echo URL?>crud/zalbe/insert" method="POST" enctype="multipart/form-data" >
        <fieldset class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label class = "col-md-4 control-label" for = "id_prekrsaji">Žalba za prekršaj</label>
                    <div class = "col-md-5 ">
                        <select class="form-control" name="id_prekrsaji" id="id_prekrsaji">
                            <?php
                            foreach ($this->prekrsaj as $value) {
                                echo "<option value={$value['id_prekrsaji']}>{$value['opis']} ({$value['mjesto']})</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class = "col-md-4 control-label" for = "naziv">Naziv žalbe</label>
                    <div class = "col-md-5 ">
                        
                        <input id = "naziv" type = "text" class = "form-control" name = "naziv" />
                        <span class = "help-block">Naziv nove žalbe</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class = "control-label col-md-4" for = "opis">Opis</label>
                    <div class = "col-md-5 ">
                        <textarea id = "opis" type = "text" class = "form-control" name = "opis" ></textarea>
                        <span class = "help-block">Opis žalbe</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class = "control-label col-md-4"></label>
                    <div class = "col-md-5">
                        <button id = "insertBtn" name = "insert" class = "btn btn-primary btn-block form-control">Dodaj Žalbu</button>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
    
    
    <form id="JQUpdate" name="updateZupanije" class="form-vertical" action="<?php echo URL ?>crud/zupanije/update" method="POST" style="display:none">
        <fieldset class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <div class = "col-md-4 ">
                        <label class = "control-label" for = "naziv">Promjeni naziv:</label>
                        <input id = "updateId" type = "text" class = "form-control" name = "id_zupanije" style="display:none" />
                        <input id = "updateNaziv" type = "text" class = "form-control" name = "naziv" />
                        <span class = "help-block">Novi naziv županije</span>
                    </div>
                    <div class = "col-md-4 col-md-offset-4">
                        <label class = "control-label"></label>
                        <button id = "updateBtn" name = "insert" class = "btn btn-success btn-block form-control">Ažuriraj</button>
                        <button id = "cancelBtn" name = "odustani" class = "btn btn-danger btn-block form-control">Odustani</button>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>


</article>
<script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.confirm.min.js"></script>
