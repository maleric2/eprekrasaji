<article>
    <h2><?php
        if ($this->currentUser["id_statusRacuna"] == 1) {
            echo "Niste aktivirali račun";
        }
        ?></h2>
    <h1> Nova Žalba</h1>

    <br>
    <?php //echo $this->prekrsaj['id_prekrsaja']; ?>
    <form id="formUprave" name="uplPictures" class="form-horizontal" action="<?php echo URL ?>crud/zalbe/insert" method="POST" enctype="multipart/form-data" >
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
                    <label class="col-md-4 control-label" for="picture">Dokaz</label>
                    <div class="col-md-5">
                        <div id="putImage">

                        </div>
                        <input id="picture" type="file" name="picture" onchange="PreviewImage();" />
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



</article>
<script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.confirm.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>public/js/PreviewImage.js"></script>