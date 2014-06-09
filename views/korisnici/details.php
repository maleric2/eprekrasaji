<h1 class="center">Detalji korisnika <?php echo $this->user['korIme'] ?></h1>
  <?php //var_dump($this->user);
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
  <form id="forma2" name="details" method="" >
                <label class="registracija" for="ime">Ime</label>
                <input class="registracija" type="text" autofocus name="ime" id="ime" value="<?php echo $this->user['ime'];?>" readonly>
                <label class="registracija" for="prezime">Prezime</label>
                <input class="registracija" type="text" name="prezime" id="prezime" value="<?php echo $this->user['prezime'];?>" readonly >
                <label class="registracija" for="oib">OIB</label>
                <input class="registracija" type="number" name="oib" id="oib" value="<?php echo $this->user['oib'];?>" readonly disabled>
                <label class="registracija" for="adresa">Adresa</label>
                <input class="registracija" type="text" name="adresa" id="adresa" value="<?php echo $this->user['adresa'];?>" readonly>
                <label class="registracija" for="status">Status Računa:</label>
                <input class="registracija" type="text" id="status" name="status" disabled value="<?php echo $this->user['status'];?>" readonly> 
                <label class="registracija" for="email">E-mail</label>
                <input class="registracija" type="email" id="email" name="email" value="<?php echo $this->user['email'];?>" readonly>
                <label class="registracija" for="korime">Korisničko ime</label>
                <input class="registracija" type="text" id="korime" name="korime" value="<?php echo $this->user['korIme'];?>" readonly > 
                <label class="registracija" for="pass">Lozinka</label>
                <input class="registracija" type="text" id="pass" name="pass" value="<?php echo $this->user['lozinka'];?>" readonly > 
                <label class="registracija" for="slika">Putanja slike</label>
                <input class="registracija" type="text" id="slika" name="slika" value="<?php echo $this->user['putanja'];?>" readonly > 
 </form>
