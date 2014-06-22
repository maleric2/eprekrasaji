<h1 class="center">Detalji korisnika </h1>
<?php
//var_dump($this->user);
if ($this->user['id_statusRacuna'] == 1) {
    $this->user['status'] = "neaktivan";
} elseif ($this->user['id_statusRacuna'] == 2) {
    $this->user['status'] = "aktivan";
} elseif ($this->user['id_statusRacuna'] == 3) {
    $this->user['status'] = "ban";
}
if ($this->user['obrisan']) {
    $this->user['status'] = "OBRISAN";
}
?>
<form id="forma3" class="form-horizontal" name="details" action="<?php echo URL ?>crud/korisnici/update" method="POST" enctype="multipart/form-data" >
    <fieldset class="panel panel-default">

        <div class="panel-body">
            <?php if ($this->user['putanja']): ?>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="currentPicture"></label>
                    <div class="col-md-5">
                        <img src="<?php echo URL . $this->user['putanja']; ?>" height="150">
                    </div>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label class="col-md-4 control-label" for="picture"></label>
                <div class="col-md-5">
                    <div id="putImage">

                    </div>
                    <input id="picture" type="file" name="picture" onchange="PreviewImage();" />
                    <span class="help-block">Promjeni profilnu sliku</span>  
                </div>
            </div>
            <div class="form-group has-success">
                <label class="col-md-4 control-label" for="id_tipKorisnika">Tip Korisnika</label>
                <div class="col-md-5">
                    <select class="form-control" id="id_tipKorisnika" name="id_tipKorisnika">
                        <?php
                        foreach ($this->tipKorisnika as $value)
                            if ($value['id_tipKorisnika']==$this->user['id_tipKorisnika'])
                                echo "<option selected value='{$value['id_tipKorisnika']}' >{$value['naziv']}</option>";
                        else
                            echo "<option value='{$value['id_tipKorisnika']}'  >{$value['naziv']}</option>";
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="ime">Ime</label>
                <div class="col-md-5">
                    <input class="input-md form-control" type="text" autofocus name="ime" id="ime" value="<?php echo $this->user['ime']; ?>" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="prezime">Prezime</label>
                <div class="col-md-5">
                    <input class="input-md form-control" type="text" name="prezime" id="prezime" value="<?php echo $this->user['prezime']; ?>"  >
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="oib">OIB</label>
                <div class="col-md-5">
                    <input class="input-md form-control" type="number" name="oib" id="oib" value="<?php echo $this->user['oib']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="adresa">Adresa</label>
                <div class="col-md-5">
                    <input class="input-md form-control" type="text" name="adresa" id="adresa" value="<?php echo $this->user['adresa']; ?>" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="status">Status Računa:</label>
                <div class="col-md-5">
                    <input class="input-md form-control" type="text" id="status" name="status" disabled value="<?php echo $this->user['status']; ?>" readonly> 
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="email">E-mail</label>
                <div class="col-md-5">
                    <input class="input-md form-control" type="email" id="email" name="email" value="<?php echo $this->user['email']; ?>" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="korime">Korisničko ime</label>
                <div class="col-md-5">
                    <input class="input-md form-control" type="text" id="korime" name="korime" value="<?php echo $this->user['korIme']; ?>" readonly > 
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="pass">Lozinka</label>
                <div class="col-md-5">
                    <input class="input-md form-control" type="text" id="pass" name="pass" value="<?php echo $this->user['lozinka']; ?>" > 
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="promjeni"></label>
                <div class="col-md-5">
                    <button type="submit" id="promjeni" name="promjeni" class="btn btn-primary btn-block">Ažuriraj</button>
                </div>
            </div>

    </fieldset>
</form>
<article id="blok">
    <a>*Pri uspješnom ažuriranju dobit ćete <b>poruku o uspješnosti na mail</b></a> <br>
    <a>*Korisničko ime, putanju slike i status računa nije moguće izmjeniti</a>
</article>
<!-- Image Preview, stavlja na #putImage -->
<script type="text/javascript" src="<?php echo URL; ?>public/js/PreviewImage.js"></script>