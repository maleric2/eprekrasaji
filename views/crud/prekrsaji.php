<article id="blok">

    <h2>
        <?php
        if ($this->currentUser["id_statusRacuna"] == 1) {
            echo "Niste aktivirali račun";
        }
        ?> 
    </h2>
    <h1> Prekršaji </h1>

    <div class="row">
        <div class="col-md-4 col-md-offset-8">
            <a href="<?php echo URL ?>admin/prekrsaji/insert">
                <button type="button" class="btn btn-primary  btn-block">Unesi novi</button>
            </a>
        </div>
    </div>
    <br>
    <?php if (count($this->prekrsaji) > 0): ?> 
        <table class="table table-striped">
          <thead>  <tr><th>Datum</th><th>Vrijeme</th>
                <th>Lokacija</th><th>Opis</th>
                <th>Zastara</th><th>Detalji</th>
                <th>Obriši</th><th>Promjena</th>
                <th>Slike</th>
            </tr></thead>
          <tbody>
            <?php
            $brojac = 0;
            foreach ($this->prekrsaji as $key => $value) {
                echo "<tr>";
                $date = date("Y-m-d", strtotime($value['vrijeme_prekrsaja']));
                $vrijeme_zastare = date("Y-m-d", strtotime($value['vrijeme_zastare']));
                $time = date("H:i:s", strtotime($value['vrijeme_prekrsaja']));
                //$time=$date
                echo "<td>{$date}</td>";
                echo "<td>{$time}</td>";
                echo "<td>{$value['mjesto']}</td>";
                echo "<td>{$value['opis']}</td>";
                echo "<td>{$vrijeme_zastare}</td>";

                echo "<td><a href='./prekrsaji/details/{$value['id_prekrsaji']}'>Details</a> </td>";
                echo "<td><a class='glyphicon-remove-me' href='" . URL . "crud/prekrsaji/delete/{$value['id_prekrsaji']}'><i class='glyphicon glyphicon-remove'></i></a> </td>";
                echo "<td><a href='./prekrsaji/change/{$value['id_prekrsaji']}'>Promjeni</a> </td>";
                echo "<td><a href='./slike/{$value['id_prekrsaji']}'>Dodaj slike</a> </td>";
                echo "</tr>";
                $brojac++;
            }
            ?>
        <?php else: ?>
            <div class="jumbotron">
                <h1>Čestitamo!</h1>
                <p>Trenutno nemate nikakvih prekršaja</p>
            </div>
        <?php endif; ?> 
          </tbody>
    </table>
    <br>
</article>
