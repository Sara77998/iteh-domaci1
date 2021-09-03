<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript" src="jquery-1.10.2.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#kombo_drzave").change(function(){
                    var vrednost = $("#komboKnjizara").val();
                    $.get("prikaziknjizaru.php", { id: vrednost },
                        function(data){
                            $("#popuni").html(data);
                        });
                });
            });
        </script>
    </head>
<body>
    <?php
        include "konekcija.php";
        
        $rezultat = $mysqli->query("SELECT * FROM knjizara");
    ?>
    <form> 
        <b>KNJIŽARE:</b>
        <select name="knjizare" id="komboKnjizara">

        <?php
            while($red = $rezultat->fetch_object()){
        ?>
        <option value="<?php echo $red->id;?>"><?php echo $red->naziv;?></option>
        <?php
            }
        ?>

        </select>
    </form> 
    <p><div id="popuni"><b>Podaci o knjizari iz selektovanog grada će biti prikazani ovde. Stranica se ne učitava ponovo.</b></div></p>
    <?php
        $mysqli->close();
    ?>
    </body>
</html>

