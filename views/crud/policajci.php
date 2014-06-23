<article id="blok">
    
    <h2>
    <?php 
        if ($this->currentUser["id_statusRacuna"] == 1) {
            echo "Niste aktivirali račun";
        }
        POLICAJCI
        ?>
    </h2>
    <div class="row">
        <div class="col-md-4 col-md-offset-8">
            <button id="dodajBtn" class="col-md-4 btn btn-primary btn-block">Dodaj Policajca</button>

        </div>
    </div>
    <br>
    <?php //echo $this->prekrsaj['id_prekrsaja']; ?>
    <form id="formPolicajci" name="uplPictures" class="form-vertical" action="<?php echo URL ?>crud/policajci/policajac" method="POST" style="display:none">
        <fieldset class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-md-4">
                        <label class="control-label" for="oib">Novi policajac</label>
                        <select class="form-control" name="oib" id="oib">
                            <?php
                            foreach ($this->users as $value) {
                                echo "<option value={$value['oib']}>{$value['ime']} {$value['prezime']}</option>";
                            }
                            ?>
                        </select>
                        <span class = "help-block">Odaberi korisnika sa popisa</span>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label" for="id_policijske_uprave">Policijska uprava</label>
                        <select class="form-control" name="id_policijske_uprave" id="id_policijske_uprave">
                            <?php
                            foreach ($this->uprave as $value) {
                                echo "<option value={$value['id_policijske_uprave']}>{$value['naziv']}</option>";
                            }
                            ?>
                        </select>
                        <span class = "help-block">Odaberi policijsku upravu sa popisa</span>
                    </div>
                    <div class = "col-md-4">
                        <label class = "control-label"></label>
                        <button id = "insertPolicajac" name = "insert" class = "btn btn-primary btn-block form-control">Dodaj policajca</button>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
    
    <table class="table table-striped">
        <tr><th>Slika</th><th>Ime</th>
            <th>Prezime</th><th>Uprava</th>
            <th>E-mail</th><th>Korisnicko ime</th>
            <th colspan="3"> Operacije </th>
        </tr>
        
        <?php
            $brojac=0;
            foreach ($this->policajci as $key => $value) {
                if($value['id_statusRacuna']==2){
                    if($this->currentUser["id_tipKorisnika"]>1 || $this->currentUser["oib"]==$value['oib']){
                        $brojac++;
                        if($this->currentUser["id_tipKorisnika"]>1 && $this->currentUser["oib"]==$value['oib'])
                            echo "<tr class='success'>";
                        else
                            echo "<tr>";
                        echo "<td><a href='./korisnici/details/{$value['korIme']}'><img src='" . URL . "{$value['putanja']}' height=40></a></td>";
                        echo "<td>{$value['ime']}</td>";
                        echo "<td>{$value['prezime']}</td>";
                        echo "<td>{$value['uprava']} </td>";
                        echo "<td>{$value['email']}</td>";
                        echo "<td>{$value['korIme']}</td>";
                        echo "<td><a title='Detalji' class='glyphicon-view-me' href='" . URL . "korisnici/korisnici/details/{$value['korIme']}'><i class='glyphicon glyphicon-list-alt'></i></a></td>";
                        echo "<td><a title='Obriši' class='glyphicon-remove-me' href=" . URL . "crud/korisnici/delete/{$value['oib']}'><i class='glyphicon glyphicon-remove'></i></a></td>";
                        echo "<td><a title='Promjeni' class='glyphicon-edit-me' href='" . URL . "admin/korisnici/change/{$value['korIme']}'><i class='glyphicon glyphicon-edit'></i></a></td>";
                        echo"</tr>";
                    }
                }
            }
            if($brojac<1) echo '<tr><td colspan="9">Nije moguce prikazati korisnike</td></tr>';
        ?>
    </table>
    
</article>
<script type="text/javascript">
jQuery("#dodajBtn").click(function() {
        jQuery("#formPolicajci").css("display", "block");
        jQuery("#dodajBtn").css("display", "none");
    })
</script>