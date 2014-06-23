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
        <thead>
            <tr><th>Slika</th><th>Ime</th>
                <th>Prezime</th><th>Adresa</th>
                <th>E-mail</th><th>Korisnicko ime</th>
                <th colspan="3"> Operacije </th>
            </tr>
        </thead> <tbody>
            <?php
            $brojac = 0;
            foreach ($this->korisnici as $key => $value) {
                if ($value['id_statusRacuna'] == 2) {
                    if ($this->currentUser["id_tipKorisnika"] > 1 || $this->currentUser["oib"] == $value['oib']) {
                        $brojac++;
                        if($value['id_tipKorisnika']==2){
                            echo "<tr class='info'>";
                        }
                        elseif ($this->currentUser["id_tipKorisnika"] > 1 && $this->currentUser["oib"] == $value['oib'])
                            echo "<tr class='success'>";
                        else
                            echo "<tr>";
                        
                        echo "<td><a href='./korisnici/details/{$value['korIme']}'><img src='" . URL . "{$value['putanja']}' height=40></a></td>"; 
                        echo "<td>{$value['ime']}</td>";
                        echo "<td>{$value['prezime']}</td>";
                        echo "<td>{$value['adresa']}</td>";
                        echo "<td>{$value['email']}</td>";
                        echo "<td>{$value['korIme']}<td>";
                        echo "<td><a title='Detalji' class='glyphicon-view-me' href='" . URL . "korisnici/korisnici/details/{$value['korIme']}'><i class='glyphicon glyphicon-list-alt'></i></a></td>";
                        echo "<td><a title='Obriši' class='glyphicon-remove-me' href=" . URL . "crud/korisnici/delete/{$value['oib']}'><i class='glyphicon glyphicon-remove'></i></a></td>";
                        echo "<td><a title='Promjeni' class='glyphicon-edit-me' href='" . URL . "admin/korisnici/change/{$value['korIme']}'><i class='glyphicon glyphicon-edit'></i></a></td>";
                        echo"</tr>";
                    }
                }
            }
            if ($brojac < 1)
                echo '<tr><td colspan="9">Nije moguce prikazati korisnike</td></tr>';
            ?>
        </tbody>
    </table>
    <br>
<?php if ($this->currentUser["id_tipKorisnika"] > 1): ?>
        <p> Neaktivni korisnici</p>
        <table class="table ">
            <thead> <tr><th>Ime</th><th>Slika</th>
                    <th>Prezime</th><th>Adresa</th>
                    <th>E-mail</th><th>Korisnicko ime</th>
                    <th colspan="3"> Operacije </th>
                </tr>
            </thead> <tbody>
                <?php
                foreach ($this->korisnici as $key => $value) {
                    if ($value['id_statusRacuna'] == 1) {

                        if ($value['obrisan'])
                            echo "<tr class='warning' >";
                        else
                            echo "<tr>";

                        echo "<td>{$value['ime']}</td>";
                        echo "<td><a href='./korisnici/details/{$value['korIme']}'><img src='" . URL . "public/img/{$value['putanja']}' height=40></a></td>";
                        echo "<td>{$value['prezime']}</td>";
                        echo "<td>{$value['adresa']}</td>";
                        echo "<td>{$value['email']}</td>";
                        echo "<td>{$value['korIme']}</td>";
                        echo "<td><a title='Detalji' class='glyphicon-view-me' href='" . URL . "korisnici/korisnici/details/{$value['korIme']}'><i class='glyphicon glyphicon-list-alt'></i></a></td>";
                        echo "<td><a title='Aktiviraj' class='glyphicon-remove-me' href='" . URL . "korisnici/activate/{$value['korIme']}'><i class='glyphicon glyphicon-ok'></i></a></td>";
                        echo "<td><a title='Promjeni' class='glyphicon-edit-me' href='" . URL . "admin/korisnici/change/{$value['korIme']}'><i class='glyphicon glyphicon-edit'></i></a></td>";
                        echo"</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
<?php endif; ?>
</article>
