<article id="blok">

    <h2>
        <?php
        if ($this->currentUser["id_statusRacuna"] == 1) {
            echo "Niste aktivirali račun";
        }
        ?>
    </h2>
    <h1> Popis slika</h1>

    <div id="putImage" class="blockquote-reverse">
    </div>
    <br>
    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <?php //echo $this->prekrsaj['id_prekrsaja']; ?>
            <form id="frmUplPictures" name="uplPictures" class="form-horizontal" action="<?php echo URL ?>crud/slike/insert/<?php echo $this->prekrsaj['id_prekrsaja']; ?>" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label class="col-md-2 control-label" for="picture"></label>
                    <div class="col-md-6">
                        <input id="picture" type="file" multiple name="picture[]" onchange="PreviewImage(true);" />
                        <span class="help-block">Označi slike za prijenos</span>  
                    </div>
                    <div class="col-md-4">
                        <button id="register" name="insert" class="btn btn-primary btn-block">Dodaj slike</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-striped">
        <tr><th>Slika</th>
            <th>Naziv</th>
            <th>Putanja</th>
            <th>Obriši</th>
        </tr>

        <?php
        //$distinctValues[] = array(); 
        $brojac = 0;
        $prekrsaj_id=0;
        if($this->prekrsaj['id_prekrsaja'])$prekrsaj_id=$this->prekrsaj['id_prekrsaja'];
        if ($this->datoteke)
            foreach ($this->datoteke as $key => $value) {
                /* if (in_array($value['putanja'], $distinctValues)) {
                  continue;
                  }
                  $distinctValues[] = $value['putanja']; */
                echo "<tr>";
                echo "<td><img src='" . URL . $value['putanja'] . "' height=40></td>";

                echo "<td>{$value['naziv']}</td>";
                echo "<td>{$value['putanja']}</td>";

                echo "<td><a class='glyphicon-remove-me' href='" . URL . "crud/slike/delete/{$prekrsaj_id}/{$value['id_datoteke']}'><i class='glyphicon glyphicon-remove'></i></a></td>";
                echo"</tr>";
                $brojac++;
            }
        if ($brojac == 0)
            echo "<tr ><td colspan=4>Nema slika</td></tr>";
        ?>
    </table>
    <br>
</article>

<script type="text/javascript" src="<?php echo URL; ?>public/js/PreviewImage.js">
</script>
