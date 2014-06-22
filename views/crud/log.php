<article id="blok">

    <h2>
        <?php
        if ($this->currentUser["id_statusRacuna"] == 1) {
            echo "Niste aktivirali račun";
        }
        ?>
    </h2>
    <p> Log sustava</p>

    <table class="table table-striped">
        <tr>
            <th>Vrijeme</th>
            <th>Radnja</th>
            <th>Upit</th>
            <th>Korisnik</th>
        </tr>

        <?php
        $brojac = 0;
        if (isset($this->logs))
            foreach ($this->logs as $key => $value) {
                echo "<td>{$value['vrijeme']}</td>";
                echo "<td>{$value['radnja']}</td>";
                echo "<td>{$value['upit']}</td>";
                echo "<td>{$value['ime']} {$value['prezime']}({$value['korIme']})</td>";
                echo"</tr>";
                $brojac++;
            }
        if ($brojac < 1)
            echo '<tr><td colspan="9">Nije moguce prikazati korisnike</td></tr>';
        ?>
    </table>
    <table class="table table-striped">
        <tr>
            <th>Vrijeme</th>
            <th>Vrijeme</th>
            <th>Korisnik</th>
        </tr>

        <?php
        $brojac = 0;
        if (isset($this->sesija))
            foreach ($this->sesija as $key => $value) {
                echo "<td>{$value['vrijeme_pocetka']}</td>";
                echo "<td>{$value['vrijeme_zavrsetka']}</td>";
                echo "<td>{$value['ime']} {$value['prezime']}({$value['korIme']})</td>";
                echo"</tr>";
                $brojac++;
            }
        if ($brojac < 1)
            echo '<tr><td colspan="9">Nije moguce prikazati korisnike</td></tr>';
        ?>
    </table>
    <br>

</article>
