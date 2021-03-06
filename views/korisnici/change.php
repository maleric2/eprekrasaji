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
<form id="forma3" class="form-horizontal" name="details" action="<?php echo URL ?>register/update" method="POST" >
    <fieldset class="panel panel-default">
        <div class="panel-body">
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
                <label class="col-md-4 control-label" for="slika">Putanja slike</label>
                <div class="col-md-5">
                    <input class="input-md form-control" type="text" id="slika" name="slika" value="<?php echo $this->user['putanja']; ?>" readonly disabled >
                </div>
            </div>
            <div class="form-group">
            <label class="col-md-4 control-label" for="promjeni"></label>
                <div class="col-md-5">
                    <button type="submit" id="promjeni" name="promjeni" class="btn btn-primary btn-block">Ažuriraj</button>
            </div>
            </div>
        </div>
    </fieldset>
</form>
<article id="blok">
    <a>*Pri uspješnom ažuriranju dobit ćete <b>poruku o uspješnosti na mail</b></a> <br>
    <a>*Korisničko ime, putanju slike i status računa nije moguće izmjeniti</a>
</article>