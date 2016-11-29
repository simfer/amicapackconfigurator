<?php

require_once 'config.php';


function CreateSelect($selectName,$tableName,$othercolumns,$keycolumn,$displaycolumn,$sortcolumn,$class) {

    //start by creating an empty list
    $select = '';

    //try the connection to the database and execute the SQL statement
    try{
        $conn = new PDO ( AXA_DB_DSN, AXA_DB_USER, AXA_DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
        $conn->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        if ($othercolumns) {
            $othercolumns = $othercolumns .', ';
        }

        $sql ='SELECT DISTINCT ' . $othercolumns . $keycolumn . ' as keycolumn, ' . $displaycolumn . ' as displaycolumn FROM ' . $tableName;
        if ($sortcolumn) {
            $sql .= ' ORDER BY ' . $sortcolumn;
        }
        if ($class) {
            $class = ' class="' . $class .'" ';
        }
        $stmt = $conn->prepare($sql);
        $stmt ->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $select .= '<select ' . $class . ' id="' . $selectName .'" name="' . $selectName .'">';
        $select .= '<option value=""></option>';

        $parentid = '';
        //fetch all the records from the table
        foreach($data as $row) {
            if ($othercolumns) {
                $fields = explode(",",$othercolumns);

                $sss = '';
                foreach ($fields as $field) {
                    $sss .=  $field .'=' . $row[$field] . ' ';
                }
                $parentid = $sss; //' parentid="'. $row["parentcolumn"] .'" ';
            }
            $select .= '<option ' . $parentid . ' id="'. $row["keycolumn"] .'" value="'. $row["keycolumn"] .'">'. $row["displaycolumn"] .'</option>';
        }

        $select .= '</select>';


    }catch(PDOException $e){
        return  'ERROR: ' . $e->getMessage();
    }

    //return the list
    return $select;
}


function CreateTableAccessori() {

    $html = '<table id="table-accessori" class="table table-hover">';
    $html .= '<thead>';
    $html .= '<tr>';

    $html .= '<th class="bs-checkbox col-sm-1" style="width: 36px; " data-field="state">';
    $html .= '<div class="th-inner ">&nbsp;';
    $html .= '</th>';

    $html .= '<th class="col-sm-1" style="text-align: left;">';
    $html .= '<div class="th-inner ">ID Access.</div>';
    $html .= '</th>';

    $html .= '<th class="col-sm-2" style="text-align: left;">';
    $html .= '<div class="th-inner ">Accessorio</div>';
    $html .= '</th>';

    $html .= '<th class="col-sm-2" style="text-align: right;">';
    $html .= '<div class="th-inner ">Listino (€)</div>';
    $html .= '</th>';

    $html .= '<th class="col-sm-2" style="text-align: right;">';
    $html .= '<div class="th-inner ">Costo (€)</div>';
    $html .= '</th>';

    $html .= '<th class="col-sm-2" style="text-align: right; ">';
    $html .= '<div class="th-inner ">Montaggio (€)</div>';
    $html .= '</th>';

    $html .= '<th class="col-sm-1" style="text-align: right;">';
    $html .= '<div class="th-inner ">Listino Scontato *</div>';
    $html .= '</th>';

    $html .= '<th class="col-sm-1" style="text-align: right;">';
    $html .= '<div class="th-inner ">Margine</div>';
    $html .= '</th>';

    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    //try the connection to the database and execute the SQL statement
    try{
        $conn = new PDO ( AXA_DB_DSN, AXA_DB_USER, AXA_DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
        $conn->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );


        $sql ='SELECT * FROM accessori where attivo = 1';

        $stmt = $conn->prepare($sql);
        $stmt ->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $index = 1;
        //fetch all the records from the table
        foreach($data as $row) {

            $html .= '<tr data-index="'.$index.'">';
            $html .= '<td class="bs-checkbox col-sm-1">';
            $html .= '<input data-index="'.$index.'" id="chkAccessorio'.$index.'" name="chkAccessorio" type="checkbox">';
            $html .= '</td>';
            $html .= '<td class="col-sm-1" style="text-align: left; ">'.$index.'</td>';
            $html .= '<td class="col-sm-2" style="text-align: left; ">'.$row["descrizione"].'</td>';
            $html .= '<td class="col-sm-2" style="text-align: right; ">'.$row["listino"].'</td>';
            $html .= '<td class="col-sm-2" style="text-align: right; ">'.$row["costo"].'</td>';
            $html .= '<td class="col-sm-2" style="text-align: right; ">'.$row["montaggio"].'</td>';
            $html .= '<td class="col-sm-1" style="">';

            $minval = round((floatval($row["costo"]) + floatval($row["montaggio"])) * 1.22,2);

            $html .= '<input id="listinoscontato'.$index.'" class="form-control input-sm listinoscontato" name="listinoscontato" type="number" placeholder="> '.$minval.'" style="text-align:right;" disabled="">';
            $html .= '</td>';
            $html .= '<td class="col-sm-1">';
            $html .= '<input id="margine'.$index.'" type="number" name="margine" class="form-control input-sm" style="text-align:right;" disabled="">';
            $html .= '</td>';
            $html .= '</tr>';
            $index += 1;
        }
    }catch(PDOException $e){
        return  'ERROR: ' . $e->getMessage();
    }

    $html .= '<tr data-index="'.$index.'">';
    $html .= '<td class="col-sm-2" style="text-align: right; " colspan="6">TOTALE</td>';
    $html .= '<td class="col-sm-1">';
    $html .= '<input id="totalelistinoscontato" class="form-control input-sm listinoscontato" name="totalelistinoscontato" type="number" value="0" style="text-align: right;" readonly></td>';
    $html .= '<td class="col-sm-1" style=""><input id="totalemargine" type="number" name="totalemargine" class="form-control input-sm" value="0" style="text-align: right; " readonly></td>';
    $html .= '</tr>';
    $html .= '</tbody>';
    $html .= '</table>';

    //return the list
    return $html;
}


function CreateDays() {
    $list = '<option value=""></option>';
    for ($x = 1; $x <= 31; $x++) {
        $v = str_pad($x, 2, '0', STR_PAD_LEFT);
        $list .= '<option value="'.$v.'">'.$v.'</option>';
    }
    return $list;
}


function CreateMonths() {
    $list = '<option value=""></option>';
    for ($x = 1; $x <= 12; $x++) {
        $v = str_pad($x, 2, '0', STR_PAD_LEFT);
        $list .= '<option value="'.$v.'">'.$v.'</option>';
    }
    return $list;
}

function CreateYears() {
    $list = '<option value=""></option>';
    $year = date("Y");
    echo $year;
    for ($x = $year; $x >= $year-100; $x--) {
        $list .= '<option value="'.$x.'">'.$x.'</option>';
    }
    return $list;
}

function CreateClassiMerito() {
    $list = '<option value=""></option>';
    for ($x = 1; $x <= 18; $x++) {
        $v = str_pad($x, 2, '0', STR_PAD_LEFT);
        $list .= '<option value="'.$v.'">'.$v.'</option>';
    }
    return $list;
}

function CreateDatalist($dataListName,$tableName,$keycolumn,$displaycolumn,$sortcolumn) {

    //start by creating an empty list
    $list = '';

    //try the connection to the database and execute the SQL statement
    try{
        $conn = new PDO ( AXA_DB_DSN, AXA_DB_USER, AXA_DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
        $conn->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $sql ="SELECT DISTINCT " . $keycolumn . " as keycolumn, " . $displaycolumn . " as displaycolumn FROM " . $tableName;
        if ($sortcolumn) {
            $sql .= " ORDER BY " . $sortcolumn;
        }
        $stmt = $conn->prepare($sql);
        $stmt ->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $list .= '<datalist id="' . $dataListName .'">';

        //fetch all the records from the table
        foreach($data as $row) {
            $list .= '<option id="'. $row["keycolumn"] .'" value="'. $row["displaycolumn"] .'"></option>';
        }

        $list .= '</datalist>';


    }catch(PDOException $e){
        return  'ERROR: ' . $e->getMessage();
    }

    //return the list
    return $list;
}



function GetNumberOfRecords($tableName,$filter) {
    try{
        $conn = new PDO ( AXA_DB_DSN, AXA_DB_USER, AXA_DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
        $conn->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $sql ="SELECT * FROM " . $tableName . " WHERE 1=1 ";
        if ($filter) {
            $sql .= " AND " . $filter;
        }
        $stmt = $conn->prepare($sql);
        $stmt ->execute();

        return $stmt->rowCount();
    }catch(PDOException $e){
        return  'ERROR: ' . $e->getMessage() . "-" . $sql;
    }

}

function GetPermissions($userID) {
    $results = [];
    if($userID){
        try {
            $conn = new PDO(AXA_DB_DSN, AXA_DB_USER, AXA_DB_PASSWORD);
            $conn->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT distinct b.tabella FROM sicurezza a inner join autorizzazioni b on a.idautorizzazione=b.idautorizzazione where idutente=:idutente");
            $stmt->execute(array("idutente" => $userID));

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($results,$row['tabella']);
            }
        } catch ( PDOException $e ) {
            echo "ERROR: " . $e->getMessage ();
        }
    }
    $conn = null;
    return $results;
}
?>