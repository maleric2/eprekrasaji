<article>
    <h2><?php
        if ($this->currentUser["id_statusRacuna"] == 1) {
            echo "Niste aktivirali račun";
        }
        ?></h2>
    <h1> Popis policijskih uprava</h1>

    <div id="putImage" class="blockquote-reverse">
    </div>
    <br>
    <div class="row">
        <div class="col-md-4 col-md-offset-8">
            <button id="dodajBtn" class="col-md-4 btn btn-primary btn-block">Dodaj upravu</button>

        </div>
    </div>
    <br>
    <?php //echo $this->prekrsaj['id_prekrsaja']; ?>
    <form id="formUprave" name="uplPictures" class="form-vertical" action="" method="POST" enctype="multipart/form-data" style="display:none">
        <fieldset class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-md-4">
                        <label class="control-label" for="zupanija">Županija</label>
                        <select class="form-control" name="zupanija" id="zupanija">
                            <?php
                            foreach ($this->zupanije as $value) {
                                echo "<option value={$value['id_zupanije']}>{$value['naziv']}</option>";
                            }
                            ?>
                        </select>
                        <span class = "help-block">Odaberi županiju sa popisa ili <a href="./zupanije">dodaj novu</a></span>
                    </div>
                    <div class = "col-md-4">
                        <label class = "control-label" for = "uprava">Nova Policijska Uprava</label>
                        <input id = "uprava" type = "text" class = "form-control" name = "uprava" />
                        <span class = "help-block">Naziv nove policijske uprave</span>
                    </div>
                    <div class = "col-md-4">
                        <label class = "control-label"></label>
                        <button id = "insertBtn" name = "insert" class = "btn btn-primary btn-block form-control">Dodaj Upravu</button>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
    <form id="JQUpdate" name="updateUprave" class="form-vertical" action="<?php echo URL ?>crud/zupanije/update" method="POST" style="display:none">
        <fieldset class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-md-4">
                        <label class="control-label" for="zupanija">Županija</label>
                        <select class="form-control" name="zupanija" id="updateZupanija">
                            <?php
                            foreach ($this->zupanije as $value) {
                                echo "<option value={$value['id_zupanije']}>{$value['naziv']}</option>";
                            }
                            ?>
                        </select>
                        <span class = "help-block">Odaberi županiju sa popisa ili <a href="./zupanije">dodaj novu</a></span>
                    </div>
                    <div class = "col-md-4 ">
                        <label class = "control-label" for = "uprava">Promjeni naziv:</label>
                        <input id = "updateNaziv" type = "text" class = "form-control" name = "uprava" />
                        <span class = "help-block">Novi naziv županije</span>
                    </div>
                    <div class = "col-md-4">
                        <label class = "control-label"></label>
                        <button id = "updateBtn" name = "insert" class = "btn btn-primary btn-block form-control">Ažuriraj</button>
                        <button id = "cancelBtn" name = "odustani" class = "btn btn-danger btn-block form-control">Odustani</button>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>

    <table class = "table table-striped" id="tableUprave">
        <thead>
            <tr><th>Naziv</th>
                <th>Županija</th>
                <th colspan="2">Operacije</th>
            </tr>
        <thead>
        <tbody>
            <?php
            //$distinctValues[] = array(); 
            $brojac = 0;
            if ($this->uprave)
                foreach ($this->uprave as $key => $value) {
                    /* if (in_array($value['putanja'], $distinctValues)) {
                      continue;
                      }
                      $distinctValues[] = $value['putanja']; */
                    echo "<tr>";
                    echo "<td>{$value['uprava']}</td>";
                    echo "<td>{$value['zupanija']}</td>";

                    echo "<td><a class='glyphicon-remove-me JQdelete' val='{$value['id_policijske_uprave']}' href='" . URL . "crud/uprave/delete/{$value['id_policijske_uprave']}'>"
                    . "<i class='glyphicon glyphicon-remove'></i></a></td>";
                    echo "<td><a class='glyphicon-edit-me JQchange' val='{$value['id_policijske_uprave']}'><i class='glyphicon glyphicon-wrench'></i></a></td>"; /*  dummy */
                    echo"</tr>";
                    $brojac++;
                }
            if ($brojac == 0)
                echo "<tr><td colspan=4>Nema policijskih uprava</td></tr>";
            ?>
        </tbody>
    </table>
    <br>
</article>
<div></div>
<script type="text/javascript">
    var URL = '<?php echo URL ?>' ;    
</script>
<script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.confirm.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>public/js/ajax.Uprave.js"></script>