<article>
    <h2><?php
        if ($this->currentUser["id_statusRacuna"] == 1) {
            echo "Niste aktivirali račun";
        }
        ?></h2>
    <h1> Ažuriranje Žalbe </h1>

    <div id="putImage" class="blockquote-reverse">
    </div>
    <br>
    <?php //echo $this->prekrsaj['id_prekrsaja']; ?>
    <form id="formUprave" name="uplPictures" class="form-horizontal" action="<?php echo URL ?>crud/zalbe/update/<?php echo $this->zalba['id_zalbe']?>" method="POST" enctype="multipart/form-data" >
        <fieldset class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label class = "col-md-4 control-label" for = "id_prekrsaji">Žalba za prekršaj</label>
                    <div class = "col-md-5 ">
                        <select class="form-control" name="id_prekrsaji" id="id_prekrsaji">
                            <?php
                            foreach ($this->prekrsaj as $value) {
                                if ($value['id_prekrsaji'] == $this->zalba['id_prekrsaji'])
                                    echo "<option selected value={$value['id_prekrsaji']}>{$value['opis']} ({$value['mjesto']})</option>";
                                else
                                    echo "<option value={$value['id_prekrsaji']}>{$value['opis']} ({$value['mjesto']})</option>";
                            }
                            ?>
                        </select>
                        <span class = "help-block">Mjenjanjem prekršaja mjenjate predmet žalbe</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class = "col-md-4 control-label" for = "naziv">Naziv žalbe</label>
                    <div class = "col-md-5 ">

                        <input id = "naziv" type = "text" class = "form-control" name = "naziv" value="<?php echo $this->zalba['naziv']; ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class = "control-label col-md-4" for = "opis">Opis</label>
                    <div class = "col-md-5 ">
                        <textarea id = "opis" type = "text" class = "form-control" name = "opis" ><?php echo $this->zalba['opis']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class = "control-label col-md-4"></label>
                    <div class = "col-md-5">
                        <button id = "insertBtn" name = "insert" class = "btn btn-primary btn-block form-control">Ažuriraj Žalbu</button>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>


</article>
<div></div>
<script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.confirm.min.js"></script>
