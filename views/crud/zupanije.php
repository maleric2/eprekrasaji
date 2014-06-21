<article>
    <h2><?php
        if ($this->currentUser["id_statusRacuna"] == 1) {
            echo "Niste aktivirali račun";
        }
        ?></h2>
    <h1> Popis Županija</h1>

    <div id="putImage" class="blockquote-reverse">
    </div>
    <br>
    <div class="row">
        <div class="col-md-4 col-md-offset-8">
            <button id="dodajBtn" class="col-md-4 btn btn-primary btn-block">Dodaj Zupaniju</button>

        </div>
    </div>
    <br>
    <?php //echo $this->prekrsaj['id_prekrsaja']; ?>
    <form id="formUprave" name="uplPictures" class="form-vertical" action="" method="POST" enctype="multipart/form-data" style="display:none">
        <fieldset class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <div class = "col-md-4 ">
                        <label class = "control-label" for = "naziv">Nova Županija:</label>
                        <input id = "naziv" type = "text" class = "form-control" name = "naziv" />
                        <span class = "help-block">Naziv nove Županije</span>
                    </div>
                    <div class = "col-md-4 col-md-offset-4">
                        <label class = "control-label"></label>
                        <button id = "insertBtn" name = "insert" class = "btn btn-primary btn-block form-control">Dodaj upravu</button>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
    <form id="JQUpdate" name="updateZupanije" class="form-vertical" action="<?php echo URL ?>crud/zupanije/update" method="POST" style="display:none">
        <fieldset class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <div class = "col-md-4 ">
                        <label class = "control-label" for = "naziv">Promjeni naziv:</label>
                        <input id = "updateId" type = "text" class = "form-control" name = "id_zupanije" style="display:none" />
                        <input id = "updateNaziv" type = "text" class = "form-control" name = "naziv" />
                        <span class = "help-block">Novi naziv županije</span>
                    </div>
                    <div class = "col-md-4 col-md-offset-4">
                        <label class = "control-label"></label>
                        <button id = "updateBtn" name = "insert" class = "btn btn-success btn-block form-control">Ažuriraj</button>
                        <button id = "cancelBtn" name = "odustani" class = "btn btn-danger btn-block form-control">Odustani</button>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>

    <table class = "table table-striped" id="tableUprave">
        <thead>
            <tr><th>Naziv Županije</th>
                <th colspan="2">Operacije</th>
            </tr>
        <thead>
        <tbody>
            <?php
            $brojac = 0;
            if ($this->zupanije)
                foreach ($this->zupanije as $key => $value) {
                    echo "<tr>";
                    echo "<td>{$value['naziv']}</td>";

                    echo "<td><a class='glyphicon-remove-me JQdelete' val='{$value['id_zupanije']}' href='" . URL . "crud/zupanije/delete/{$value['id_zupanije']}'>"
                    . "<i class='glyphicon glyphicon-remove'></i></a></td>";
                    echo "<td><a class='glyphicon-edit-me JQchange' val='{$value['id_zupanije']}'><i class='glyphicon glyphicon-wrench'></i></a></td>"; /*  dummy */
                    echo"</tr>";
                    $brojac++;
                }
            if ($brojac == 0)
                echo "<tr><td colspan=4>Nema zupanija</td></tr>";
            ?>
        </tbody>
    </table>
    <br>
    *Ne može za sad brisat sve, jer su tablice povezane a ne cascade, izbrisa bi i pol. uprave
</article>
<div></div>
<script type="text/javascript">
    var URL = '<?php echo URL ?>' ;
    _insertZupanija=true;
    
</script>
<script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.confirm.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>public/js/ajax.Uprave.js"></script>