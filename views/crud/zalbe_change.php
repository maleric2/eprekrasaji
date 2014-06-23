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
    <form id="formUprave" name="uplPictures" class="form-horizontal" action="<?php echo URL ?>crud/zalbe/update/<?php echo $this->zalba['id_zalbe'] ?>" method="POST" enctype="multipart/form-data" >
        <fieldset class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label class = "col-md-4 control-label" for = "status">Status</label>
                    <div class = "col-md-5 ">
                        <input id = "status" type = "text" readonly class = "form-control" name = "status" value="<?php echo $this->statusZalbe[$this->zalba['status']]; ?>"/>
                    </div>
                </div>
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
                    <div class = "col-md-5 col-md-offset-4 ">
                        <img alt = "dokaz" height=200 src="<?php echo URL . $this->zalba['putanja']; ?>">
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
                <?php if ($this->currentUser['id_tipKorisnika']>1 && $this->zalba['status']<1): ?>
                <div class="form-group">
                    <div class = "col-md-2 col-md-offset-4">
                        <a id = "prihvatiBtn" href="<?php echo URL; ?>crud/zalbe/prihvati/<?php echo $this->zalba['id_zalbe']; ?>" name = "prihvatiBtn" class = "btn btn-success btn-block form-control">Prihvati</a>
                    </div>
                    <div class = "col-md-2">
                        <a id = "odbaciBtn" href="<?php echo URL; ?>crud/zalbe/odbij/<?php echo $this->zalba['id_zalbe']; ?>" name = "odbaciBtn" class = "btn btn-danger btn-block form-control">Odbaci</a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </fieldset>
    </form>


</article>
<div></div>
<script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.confirm.min.js"></script>
