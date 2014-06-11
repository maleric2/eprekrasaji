<article id="blok">
    
    <h2>
    <?php 
        if ($this->currentUser["id_statusRacuna"] == 1) {
            echo "Niste aktivirali račun";
        }
        ?>
    </h2>
    <h1> Prekršaji</h1>
    <p>
    <div class="row">
      <div class="col-md-4 col-md-offset-8">
          <a href="<?php echo URL ?>admin/prekrsaji/insert">
              <button type="button" class="btn btn-primary  btn-block">Unesi novi</button>
          </a>
      </div>
    </div>
    
    </p>
    <table class="table table-striped">
        <tr><th>Datum</th><th>Vrijeme</th>
            <th>Lokacija</th><th>Opis</th>
            <th>E-mail</th>
            <th>Detalji</th>
            <th>Obriši</th><th>Promjena</th>
        </tr>
        
        <?php
            $brojac=0;
            foreach ($this->prekrsaji as $key => $value) {
                        $brojac++;
                        echo "<tr>";
                        $date=date("Y-m-d", strtotime($value['vrijeme_prekrsaja']));
                        $time=date("H:i:s", strtotime($value['vrijeme_prekrsaja']));
                        //$time=$date
                        echo "<td>{$date}</td>";
                        echo "<td>{$time}</td>";
                        echo "<td>{$value['mjesto']}</td>";
                        echo "<td>{$value['opis']}</td>";
                        echo "<td>{$value['vrijeme_zastare']}</td>";
                        
                        echo "<td><a href='./prekrsaji/details/{$value['korIme']}'>Details</a></td>";
                        echo "<td><a href='".URL."crud/prekrsaji/delete/{$value['id_prekrsaji']}'>Obrisi</a></td>";
                        echo "<td><a href='./prekrsaji/change/{$value['id_prekrsaji']}'>Promjeni</a></td>";
                        echo"</tr>";
                    }
        ?>
    </table>
    <br>
</article>