<article id="blok">

    <h2>
        <?php
        if ($this->currentUser["id_statusRacuna"] == 1) {
            echo "Niste aktivirali račun";
        }
        ?>
    </h2>
    <p> Statistika</p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Ime</th>
            <th>Prezime</th>
            <th>Korisničko ime</th>
            <th>Broj prijava</th>
        </tr></thead>
        <tbody>
        <?php

        function cmp($a, $b) {
            return strcmp($b->prijava, $a->prijava);
        }
        
        $brojac = 0;
        if (isset($this->brojPrijava)){
            usort($this->brojPrijava, cmp);
            foreach ($this->brojPrijava as $value) {
                echo"<tr>";
                echo "<td>{$value->ime}</td>";
                echo "<td>{$value->prezime}</td>";
                echo "<td>{$value->korime}</td>";
                echo "<td>{$value->prijava}</td>";
                echo"</tr>";
                $brojac++;
            }
        }
        else if(isset($this->brojKoristenjaBaze)){
            foreach ($this->brojKoristenjaBaze as $value) {
                echo"<tr>";
                echo "<td>{$value->ime}</td>";
                echo "<td>{$value->prezime}</td>";
                echo "<td>{$value->korime}</td>";
                echo "<td>{$value->prijava}</td>";
                echo"</tr>";
                $brojac++;
            }
        }
        if ($brojac < 1)
            echo '<tr><td colspan="9">Nije moguce prikazati korisnike</td></tr>';
        ?>
            </tbody>
    </table>
    <br>
</article>
