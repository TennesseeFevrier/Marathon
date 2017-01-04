<?php
echo "<h3> Ajouter une histoire </h3>";
?><!--
<label for="url" xmlns="http://www.w3.org/1999/html">Photo :</label>
            <input type="file" id="url" value=""/>
                <div>
                    <label for="titre">Titre de la photo :</label>
                    <input type="text" id="titre" value=""/>
                </div>
                <div>
                    <label for="texte">Légende :</label>
                    <input type="text" id="texte" value=""/>
                </div>


<script type="text/javascript">
    function ajout() {
        document.getElementById('liste').innerHTML += "<li><label for="url">Photo :</label> <input type="file" id="url"/></li>";
    }
</script>-->

<form action="/~groupe12_2016/marathon2016/public/histoire/ajout" enctype="multipart/form-data" method="post">
    <div>
        <label for="titre">Titre de l'histoire :</label>
        <input type="text" name='titre' id="titre" value="<?php $histoire->titre; ?>"/>
    </div>
    <div>
        <label for="texte">L'histoire :</label>
    </div>
    <textarea type="text" name='texte' id="texte" value="<?php $histoire->texte; ?>"></textarea>
    <br /><br />

        <?php for($num=0;$num<8;$num++){?>

    <div class='ajoutphoto'>
        <br />
            <input type="file" name="image<?php echo $num;?>" /><br />
            Texte : <input typ="text" name="texteimage<?php echo $num;?>" />
            Titre: <input typ="text" name="titreimage<?php echo $num;?>" />
    </div><br />
        <?php } ?>
        <br />
        <!--<a href="javascript:ajout()">Ajouter</a>-->

        <button class="btn btn-grey" type="submit">Valider</button>
</form>

