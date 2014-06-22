<article>
    <h2><?php
        if ($this->currentUser["id_statusRacuna"] == 1) {
            echo "Niste aktivirali račun";
        }
        ?></h2>
    <h1> Popis Žalbi</h1>
    <div class="row">
        <div class="col-md-4 col-md-offset-8">
            <a href="./zalbe/insert" id="dodajBtn" class="col-md-4 btn btn-primary btn-block">Dodaj Žalbu</a>

        </div>
    </div>
    <br>
    <table class = "table table-striped" id="tableUprave">
        <thead>
            <tr><th>Naziv</th>
                <th>Opis</th>
                <th colspan="2">Operacije</th>
            </tr>
        <thead>
        <tbody>
            <?php
            $brojac = 0;
            if ($this->zalbe)
                foreach ($this->zalbe as $key => $value) {
                    echo "<tr>";
                    echo "<td>{$value['naziv']}</td>";
                    echo "<td>{$value['opis']}</td>";

                    echo "<td><a class='glyphicon-remove-me confirm' href='" . URL . "crud/zalbe/delete/{$value['id_zalbe']}'>"
                    . "<i class='glyphicon glyphicon-remove'></i></a></td>";
                    echo "<td><a class='glyphicon-edit-me JQchange' href='" . URL . "admin/zalbe/change/{$value['id_zalbe']}'><i class='glyphicon glyphicon-wrench'></i></a></td>"; /*  dummy */
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


<script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.confirm.min.js"></script>
<script type="text/javascript">
    var URL = '<?php echo URL ?>';

$(".confirm").confirm({
    text: "Are you sure you want to delete that comment?",
    title: "Confirmation required",
    confirmButton: "Yes I am",
    cancelButton: "No",
    post: true
});
</script>