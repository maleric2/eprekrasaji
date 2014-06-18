<article id="blok">
    
    <h2>
    <?php 
        if ($this->currentUser["id_statusRacuna"] == 1) {
            echo "Niste aktivirali račun";
        }
        POLICAJCI
        ?>
    </h2>

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
                if($value['id_statusRacuna']==2){
                    if($this->currentUser["id_tipKorisnika"]>1 || $this->currentUser["oib"]==$value['oib']){
                        $brojac++;
                        if($this->currentUser["id_tipKorisnika"]>1 && $this->currentUser["oib"]==$value['oib'])
                            echo "<tr class='success'>";
                        else
                            echo "<tr>";
                        echo "<td>{$value['ime']}</td>";
                        echo "<td><a href='./korisnici/details/{$value['korIme']}'><img src='".URL."{$value['putanja']}' height=60></a></td>";
                        echo "<td>{$value['prezime']}</td>";
                        echo "<td>{$value['adresa']}</td>";
                        echo "<td>{$value['email']}</td>";
                        echo "<td>{$value['korIme']}</td>";
                        echo "<td><a href='".URL."korisnici/details/{$value['korIme']}'>Details</a></td>";
                        echo "<td><a href='./korisnici/delete/{$value['korIme']}'>Obrisi</a></td>";
                        echo "<td><a href='".URL."admin/korisnici/change/{$value['korIme']}'>Promjeni</a></td>";
                        echo"</tr>";
                    }
                }
            }
            if($brojac<1) echo '<tr><td colspan="9">Nije moguce prikazati korisnike</td></tr>';
        ?>
    </table>
    
</article>
