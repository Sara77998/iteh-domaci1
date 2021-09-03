<?php
if(isset($_POST['key'])){

    //$conn = mysqli_connect("localhost", "root", "", "bazapodataka");
     $conn = new mysqli("localhost", "root", "", "bazapodataka");

    if($_POST['key'] == 'getRowData'){
        $rowID = $conn->real_escape_string($_POST['rowID']);
        $sql = $conn->query("SELECT Naziv, Autor, Opis FROM knjige WHERE ID = '$rowID'");
        $data = $sql->fetch_array();
        $jsonArray = array(
            'naziv' => $data['Naziv'],
            'autor' => $data['Autor'],
            'opis' => $data['Opis'],
        );
        exit(json_encode($jsonArray));
    }



    if($_POST['key'] == 'getExistingData'){
        $start = $conn->real_escape_string($_POST['start']);
        $limit = $conn->real_escape_string($_POST['limit']);

        $sql = $conn->query("SELECT ID,Naziv FROM knjige LIMIT $start,$limit");
        if($sql->num_rows>0){
            $response = "";
            while($data = $sql -> fetch_array()){
                $response .='
                    <tr>
                        <td>'.$data["ID"].'</td>
                        <td id="knjige_'.$data["ID"].'">'.$data["Naziv"].'</td>
                        <td>
                            <input type="button" onclick = "viewOrEdit('.$data["ID"].', \'edit\')" value = "Edit" class = "btn btn-primary">
                            <input type="button" onclick = "viewOrEdit('.$data["ID"].', \'view\')" value = "View" class = "btn">
                            <input type="button" onclick = "deleteRow('.$data["ID"].') "value = "Delete" class = "btn btn-danger">
                        </td>
                    </tr>              
                ';
            }
            exit($response);
        }else{
            exit('reachedMax');
        }

    }
    $rowID = $conn->real_escape_string($_POST['rowID']);

    if ($_POST['key'] == 'deleteRow') {
        $conn->query("DELETE FROM knjige WHERE ID='$rowID'");
        exit('Red je obrisan!');
    }

    $naziv = $conn->real_escape_string($_POST['naziv']);
    $autor = $conn->real_escape_string($_POST['autor']);
    $opis = $conn->real_escape_string($_POST['opis']);
    

    if($_POST['key'] == 'updateRow'){
        $conn -> query("UPDATE knjige SET Naziv = '$naziv', Autor = '$autor', Opis = '$opis' WHERE ID = '$rowID' ");
        exit('Uspesno izvrseno!');
    }



    if($_POST['key'] == 'addNew'){

        $sql = $conn->query("SELECT ID FROM knjige WHERE Naziv = '$naziv'");
        if($sql->num_rows>0){
            exit("Vec postoji ova knjiga");
        }else{
            $conn -> query("INSERT INTO knjige (Naziv, Autor, Opis) VALUES ('$naziv','$autor','$opis')");
            exit('Knjiga je dodata!');
        }
    }
}
?>