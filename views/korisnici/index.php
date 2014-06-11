<article id="blok">
    
    <h2>
    <?php 
        if ($this->currentUser["id_statusRacuna"] == 1) {
            echo "Niste aktivirali račun";
        }
        ?>
    </h2>
    <p> Aktivni korisnici</p>

    <table class="table table-striped">
        <tr><th>Ime</th><th>Slika</th>
            <th>Prezime</th><th>Adresa</th>
            <th>E-mail</th><th>Korisnicko ime</th>
            <th>Detalji</th>
            <th>Obriši</th><th>Promjena</th>
        </tr>
        
        <?php
            $brojac=0;
            foreach ($this->korisnici as $key => $value) {
                if($value['id_statusRacuna']>1){
                    if($this->currentUser["id_tipKorisnika"]>1 || $this->currentUser["oib"]==$value['oib']){
                        $brojac++;
                        if($this->currentUser["id_tipKorisnika"]>1 && $this->currentUser["oib"]==$value['oib'])
                            echo "<tr class='success'>";
                        else
                            echo "<tr>";
                        echo "<td>{$value['ime']}</td>";
                        echo "<td><a href='./korisnici/details/{$value['korIme']}'><img src='".URL."public/img/{$value['putanja']}' height=60></a></td>";
                        echo "<td>{$value['prezime']}</td>";
                        echo "<td>{$value['adresa']}</td>";
                        echo "<td>{$value['email']}</td>";
                        echo "<td>{$value['korIme']}</td>";
                        echo "<td><a href='./korisnici/details/{$value['korIme']}'>Details</a></td>";
                        echo "<td><a href='./korisnici/delete/{$value['korIme']}'>Obrisi</a></td>";
                        echo "<td><a href='./korisnici/change/{$value['korIme']}'>Promjeni</a></td>";
                        echo"</tr>";
                    }
                }
            }
            if($brojac<1) echo '<tr><td colspan="9">Nije moguce prikazati korisnike</td></tr>';
        ?>
    </table>
    <br>
    <?php if($this->currentUser["id_tipKorisnika"]>1):?>
    <p> Neaktivni korisnici</p>
    <table class="table ">
        <tr><th>Ime</th><th>Slika</th>
            <th>Prezime</th><th>Adresa</th>
            <th>E-mail</th><th>Korisnicko ime</th>
            <th>Detalji</th>
            <th>Aktiviraj/Obriši</th><th>Promjena</th>
        </tr>
        <?php
            foreach ($this->korisnici as $key => $value) {
                if($value['id_statusRacuna']==1){
                    
                    if($value['obrisan']) echo "<tr class='warning' >";
                    else echo "<tr>";
                    
                    echo "<td>{$value['ime']}</td>";
                    echo "<td><a href='./korisnici/details/{$value['korIme']}'><img src='".URL."public/img/{$value['putanja']}' height=60></a></td>";
                    echo "<td>{$value['prezime']}</td>";
                    echo "<td>{$value['adresa']}</td>";
                    echo "<td>{$value['email']}</td>";
                    echo "<td>{$value['korIme']}</td>";
                    echo "<td><a href='./korisnici/details/{$value['korIme']}'>Details</a></td>";
                    echo "<td><a href='./korisnici/activate/{$value['korIme']}'>Aktiviraj</a>"
                    . "  <a href='./korisnici/delete/{$value['korIme']}'>Obrisi</a></td>";
                    echo "<td><a href='./korisnici/change/{$value['korIme']}'>Promjeni</a></td>";
                    echo"</tr>";
                }
            }
        ?>
    </table>
    <?php endif; ?>
</article>
