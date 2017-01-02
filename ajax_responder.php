<?php
require_once 'config.php';

// include the language settings
//    include("langsettings.php");

//error_log("Ajax responder<br>",3,LOGPATH."error.log");

if (isset($_POST['ajax_function']) && !empty($_POST['ajax_function'])) {
    $ajax_function = $_POST['ajax_function'];
    switch ($ajax_function) {
        case 'CancellaLog' :
            CancellaLog();
            break;
        case 'ControllaEsistenzaCodiceFiscale' :
            ControllaEsistenzaCodiceFiscale();
            break;
        case 'ControllaEsistenzaPartitaIva' :
            ControllaEsistenzaPartitaIva();
            break;
        case 'CreaLista' :
            CreaLista();
            break;
        case 'CreateOptions' :
            CreateOptions();
            break;
        case 'DisattivaRecord' :
            DisattivaRecord();
            break;
        case 'LeggiCoefficienteAugusta' :
            LeggiCoefficienteAugusta();
            break;
        case 'LeggiRecord' :
            LeggiRecord();
            break;
        case 'LeggiPreventivo' :
            LeggiPreventivo();
            break;
        case 'LeggiTabellaFormatoJSON' :
            LeggiTabellaFormatoJSON();
            break;
        case 'LeggiUtente' :
            LeggiUtente();
            break;
        case 'LeggiValoreEtaIntestatario' :
            LeggiValoreEtaIntestatario();
            break;
        case 'LeggiValorePremioBase' :
            LeggiValorePremioBase();
            break;
        case 'LeggiValoriParametri' :
            LeggiValoriParametri();
            break;
        case 'Login' :
            Login();
            break;
        case 'SalvaCliente' :
            SalvaCliente();
            break;
        case 'SalvaPreventivo' :
            SalvaPreventivo();
            break;
        case 'SaveRecord' :
            SaveRecord();
            break;
        case 'SalvaUtentiGruppi' :
            SalvaUtentiGruppi();
            break;
        case 'SalvaGruppiRuoli' :
            SalvaGruppiRuoli();
            break;
        case 'SalvaRuoliAutorizzazioni' :
            SalvaRuoliAutorizzazioni();
            break;
        case 'TestAjax' :
            TestAjax();
            break;
        // ...etc...
    }
}






/***************************************
 * CancellaLog                         *
 ***************************************/
function CancellaLog()
{
    $filename = LOGPATH . "error.log";

    try {
        if (file_exists($filename)) {
            unlink($filename);
        }
        error_log("File di log ricreato!", 3, $filename);
        echo "success";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

/***************************************
 * ControllaEsistenzaCodiceFiscale     *
 ***************************************/
function ControllaEsistenzaCodiceFiscale()
{
    $cfisc = $_POST['codicefiscale'];

    $sql = "SELECT * FROM clienti where codicefiscale = :cfisc";

    if ($cfisc) {
        try {
            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare($sql);

            //$stmt = $conn->prepare("SELECT *,IFNULL(DATE_FORMAT(datanascita,'%d/%m/%Y'),NULL) as datanascitaform
            //      FROM clienti where cfisc = :cfisc");

            $stmt->execute(array(
                "cfisc" => $cfisc
            ));

            if ($stmt->rowCount() > 0) {
                // fetch the row
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode(array(
                    'status' => 'success',
                    'result' => $row,
                    'sql' => $sql
                ));
            } else {
                try {
                    throw new Exception('Value not found in function ' . __FUNCTION__);
                } catch (Exception $e) {
                    echo json_encode(array(
                        'status' => 'error',
                        'result' => $e->getMessage(),
                        'sql' => $sql
                    ));
                }
            }
            $conn = null;
        } catch (Exception $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    } else {
        try {
            throw new Exception('Missing parameters for function ' . __FUNCTION__);
        } catch (Exception $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    }

}

/***************************************
 * ControllaEsistenzaPartitaIva        *
 ***************************************/
function ControllaEsistenzaPartitaIva()
{
    $piva = $_POST['q'];

    if ($piva) {
        try {
            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //$stmt = $conn->prepare("SELECT * FROM clienti where piva = :piva");
            $stmt = $conn->prepare("SELECT *,IFNULL(DATE_FORMAT(datanascita,'%d/%m/%Y'),NULL) as datanascitaform
                  FROM clienti where piva = :piva");

            $stmt->execute(array(
                "piva" => $piva
            ));

            if ($stmt->rowCount() > 0) {
                // fetch the row
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                //error_log("riga!<br>".json_encode($row),3,LOGPATH."error.log");
                echo json_encode(array(
                    'status' => 'success',
                    'result' => $row
                ));
                //echo json_encode($row);
            } else {
                echo json_encode(array(
                    'status' => 'success',
                    'result' => 'NOT_FOUND'
                ));
            }
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage()
            ));
        }
    }
    $conn = null;
}

/***************************************
 * CreaLista                           *
 ***************************************/
function CreaLista()
{
    $thetable = $_POST['thetable'];
    $keycolumn = $_POST['keycolumn'];
    $displaycolumn = $_POST['displaycolumn'];
    $sortcolumn = $_POST['sortcolumn'];

    //start creating the select
    $list = '';

    if ($thetable && $keycolumn && $displaycolumn) {

        //try the connection to the database and execute the SQL statement
        try {
            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT DISTINCT " . $keycolumn . " as keycolumn, " . $displaycolumn . " as displaycolumn FROM " . $thetable;
            if ($sortcolumn) {
                $sql .= " ORDER BY " . $sortcolumn;
            }
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $list .= '<datalist id="lst' . $thetable . '">';

            //fetch all the records from the table
            foreach ($data as $row) {
                $list .= '<option id="' . $row["keycolumn"] . '" value="' . $row["displaycolumn"] . '"></option>';
            }

            $list .= '</datalist>';

            echo json_encode(array(
                'status' => 'success',
                'result' => $list
            ));
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage()
            ));
        }
    }
}

/***************************************
 * CreateOptions                       *
 ***************************************/
function CreateOptions()
{
    $table = $_POST['table'];
    $keycolumn = $_POST['keycolumn'];
    $displaycolumn = $_POST['displaycolumn'];
    $filter = (isset($_POST['filter']) ? $_POST['filter'] : "");
    $sortcolumn = (isset($_POST['sortcolumn']) ? $_POST['sortcolumn'] : "");

    //start creating the select
    //$list = '';
    $list = '<option value=""></option>';

    if ($table && $keycolumn && $displaycolumn) {

        //try the connection to the database and execute the SQL statement
        try {
            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT DISTINCT " . $keycolumn . " as keycolumn, " . $displaycolumn . " as displaycolumn FROM " . $table;
            if ($filter) {
                $sql .= " WHERE " . $filter;
            }
            if ($sortcolumn) {
                $sql .= " ORDER BY " . $sortcolumn;
            }
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);


            //fetch all the records from the table
            foreach ($data as $row) {
                $valore = ($row["valore"] ? $row["valore"] : "");
                $list .= '<option valore="' . $valore . '" id="' . $row["keycolumn"] . '" value="' . $row["keycolumn"] . '">' . $row["displaycolumn"] . '</option>';
            }

            echo json_encode(array(
                'status' => 'success',
                'result' => $list,
                'sql' => $sql
            ));
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    }
}

/***************************************
 * DisattivaRecord                     *
 ***************************************/
function DisattivaRecord()
{

    $thetable = $_POST['thetable'];
    $keyfield = $_POST['keyfield'];
    $keyvalue = $_POST['keyvalue'];

    //session_start();
    $loggedUser = 1; //$_SESSION ["idutente"];

    try {
        $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE " . $thetable . " SET attivo = 0, modificatoda = " . $loggedUser . ",operazione='D', dataoperazione=SYSDATE() WHERE " . $keyfield . " ='" . $keyvalue . "'";


        //error_log("<br>1_Sql: $sql\r\n",3,LOGPATH."error.log");

        //prepare the sql string
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        echo json_encode(array(
            'status' => 'success',
            'result' => $sql
        ));
        $conn = null;
    } catch (PDOException $e) {
        echo json_encode(array(
            'status' => 'error',
            'result' => $e->getMessage()
        ));
    }

}

/***************************************
 * LeggiCoefficienteAugusta            *
 ***************************************/
function LeggiCoefficienteAugusta()
{
    $provincia = $_POST['provincia'];
    $tipologia = $_POST['tipologia'];
    $categoria = $_POST['categoria'];
    $durata = $_POST['durata'];

    if ($provincia && $tipologia && $categoria && $durata) {
        try {
            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT b.coeff as coefficiente FROM zoneaugusta a inner join coeffaugusta b
              on a.tipologia=b.tipologia and b.zona=IF(a.tipologia = 'K', 0, a.zona)
              where a.provincia='" . $provincia . "' and a.tipologia='" . $tipologia . "' and b.categoria='" . $categoria . "' and b.durata=" . $durata;

            $stmt = $conn->prepare($sql);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // fetch the row
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode(array(
                    'status' => 'success',
                    'result' => $row,
                    'sql' => $sql
                ));
                //echo json_encode($row);
            } else {
                echo json_encode(array(
                    'status' => 'success',
                    'result' => 'NOT_FOUND',
                    'sql' => $sql
                ));
            }
        } catch (Exception $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    }
    $conn = null;
}

/***************************************
 * LeggiRecord                         *
 ***************************************/
function LeggiRecord()
{
    $thetable = $_POST['thetable'];
    $keyfield = $_POST['keyfield'];
    $keyvalue = $_POST['keyvalue'];

    if ($thetable && $keyfield && $keyvalue) {
        try {
            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT * FROM " . $thetable . " WHERE " . $keyfield . " = " . $keyvalue;
            $stmt = $conn->prepare($sql);

            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(array(
                'status' => 'success',
                'result' => $data
            ));

        } catch (Exception $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage()
            ));
        }
    }
    $conn = null;
}

/***************************************
 * LeggiPreventivo                     *
 ***************************************/
function LeggiPreventivo()
{
    $idpreventivo = $_POST['idpreventivo'];
    $sql = "SELECT a.*,
                  (select case count(*) when 0 then 'NO' else 'SI' end from polizzerca x where x.idpreventivo=a.idpreventivo) as rca,
                  (select case count(*) when 0 then 'NO' else 'SI' end from polizzeaugusta y where y.idpreventivo=a.idpreventivo) as augusta,
                  (select case count(*) when 0 then 'NO' else 'SI' end from polizzeaccessori z where z.idpreventivo=a.idpreventivo) as accessori, 
                  (select case count(*) when 0 then 'NO' else 'SI' end from polizzecopertureaggiuntive w where w.idpreventivo=a.idpreventivo) as copertureaggiuntive 
                  FROM preventivi a
                  WHERE a.attivo=1 and a.idpreventivo='" . $idpreventivo . "'";

    if ($idpreventivo) {
        try {
            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare($sql);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // fetch the row
                $preventivo = $stmt->fetch(PDO::FETCH_ASSOC);
                $idcliente = $preventivo["idcliente"];
                $rcaSi = ($preventivo["rca"] == "SI" ? true : false);
                $augustaSi = ($preventivo["augusta"] == "SI" ? true : false);
                $accessoriSi = ($preventivo["accessori"] == "SI" ? true : false);
                $copertureaggiuntiveSi = ($preventivo["copertureaggiuntive"] == "SI" ? true : false);

                $sqlCliente = "select a.* from clienti a WHERE a.attivo=1 and a.idcliente='" . $idcliente . "'";
                $stmtCliente = $conn->prepare($sqlCliente);
                $stmtCliente->execute();
                $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

                if ($rcaSi) {
                    $sqlRCA = "select * from polizzerca a inner join zone b on a.idcomune = b.idcomune WHERE a.attivo=1 and a.idpreventivo='" . $idpreventivo . "'";
                    $stmtRCA = $conn->prepare($sqlRCA);
                    $stmtRCA->execute();
                    $rca = $stmtRCA->fetch(PDO::FETCH_ASSOC);
                } else {
                    $rca = null;
                }

                if ($augustaSi) {
                    $sqlAugusta = "select a.* from polizzeaugusta a WHERE a.attivo=1 and a.idpreventivo='" . $idpreventivo . "'";
                    $stmtAugusta = $conn->prepare($sqlAugusta);
                    $stmtAugusta->execute();
                    $augusta = $stmtAugusta->fetch(PDO::FETCH_ASSOC);
                } else {
                    $augusta = null;
                }

                if ($accessoriSi) {
                    $sqlAccessori = "select a.* from polizzeaccessori a WHERE a.attivo=1 and a.idpreventivo='" . $idpreventivo . "'";
                    $stmtAccessori = $conn->prepare($sqlAccessori);
                    $stmtAccessori->execute();
                    $accessori = $stmtAccessori->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $accessori = null;
                }

                if ($copertureaggiuntiveSi) {
                    $sqlCopertureAggiuntive = "select a.* from polizzecopertureaggiuntive a WHERE a.attivo=1 and a.idpreventivo='" . $idpreventivo . "'";
                    $stmtCopertureAggiuntive = $conn->prepare($sqlCopertureAggiuntive);
                    $stmtCopertureAggiuntive->execute();
                    $copertureaggiuntive = $stmtCopertureAggiuntive->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $copertureaggiuntive = null;
                }

                echo json_encode(array(
                    'status' => 'success',
                    'result' => array('preventivo' => $preventivo, 'cliente' => $cliente, 'rca' => $rca, 'augusta' => $augusta, 'accessori' => $accessori, 'copertureaggiuntive' => $copertureaggiuntive),
                    'sql' => $idcliente
                ));
            } else {
                try {
                    throw new Exception('Value not found in function ' . __FUNCTION__);
                } catch (Exception $e) {
                    echo json_encode(array(
                        'status' => 'error',
                        'result' => $e->getMessage(),
                        'sql' => $sql
                    ));
                }
            }
            $conn = null;
        } catch (Exception $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    } else {
        try {
            throw new Exception('Missing parameters for function ' . __FUNCTION__);
        } catch (Exception $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    }
}

/***************************************
 * LeggiTabellaFormatoJSON             *
 ***************************************/
function LeggiTabellaFormatoJSON()
{
    $thetable = $_POST['thetable'];
    $filter = (isset($_POST['filter']) ? $_POST['filter'] : "");
    $sortcolumn = (isset($_POST['sortcolumn']) ? $_POST['sortcolumn'] : "");

    //start creating the select
    //$list = '';
    $list = '<option value=""></option>';

    if ($thetable) {

        //try the connection to the database and execute the SQL statement
        try {
            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM " . $thetable;
            if ($filter) {
                $sql .= " WHERE " . $filter;
            }
            if ($sortcolumn) {
                $sql .= " ORDER BY " . $sortcolumn;
            }
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(array(
                'status' => 'success',
                'result' => $data,
                'sql' => $sql
            ));
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    }
}

/***************************************
 * LeggiUtente                         *
 ***************************************/
function LeggiUtente()
{
    $idutente = $_POST['idutente'];

    $sql = "SELECT * FROM utenti WHERE idutente=" . $idutente;

    if ($idutente) {
        try {
            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare($sql);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // fetch the row
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode(array(
                    'status' => 'success',
                    'result' => $row,
                    'sql' => $sql
                ));
            } else {
                try {
                    throw new Exception('Value not found in function ' . __FUNCTION__);
                } catch (Exception $e) {
                    echo json_encode(array(
                        'status' => 'error',
                        'result' => $e->getMessage(),
                        'sql' => $sql
                    ));
                }
            }
            $conn = null;
        } catch (Exception $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    } else {
        try {
            throw new Exception('Missing parameters for function ' . __FUNCTION__);
        } catch (Exception $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    }
}

/***************************************
 * LeggiValoreEtaIntestatario          *
 ***************************************/
function LeggiValoreEtaIntestatario()
{
    $idetaintestatario = $_POST['idetaintestatario'];

    if ($idetaintestatario) {
        try {
            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT valore as valoreetaintestatario FROM etaintestatari WHERE idetaintestatario=" . $idetaintestatario;

            $stmt = $conn->prepare($sql);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // fetch the row
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode(array(
                    'status' => 'success',
                    'result' => $row
                ));
                //echo json_encode($row);
            } else {
                echo json_encode(array(
                    'status' => 'success',
                    'result' => 'NOT_FOUND'
                ));
            }
        } catch (Exception $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage()
            ));
        }
    }
    $conn = null;
}

/***************************************
 * LeggiValorePremioBase               *
 ***************************************/
function LeggiValorePremioBase()
{
    $idcomune = $_POST['idcomune'];
    $idclassepotenza = $_POST['idclassepotenza'];
    $classemerito = $_POST['classemerito'];

    $sql = 'SELECT valorepremiobase FROM valoripremibase a 
                inner join zone b on a.idzona = b.idzona
                inner join classipotenza c on a.idclassepotenza = c.idclassepotenza
                where b.idcomune = ? and c.idclassepotenza = ? and a.classemerito = ?';

    if ($idcomune && $idclassepotenza && $classemerito) {
        try {
            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare($sql);

            $stmt->execute(array($idcomune,$idclassepotenza,$classemerito));

            if ($stmt->rowCount() > 0) {
                // fetch the row
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode(array(
                    'status' => 'success',
                    'result' => $row,
                    'sql' => $sql
                ));
            } else {
                try {
                    throw new Exception('Value not found in function ' . __FUNCTION__);
                } catch (Exception $e) {
                    echo json_encode(array(
                        'status' => 'error',
                        'result' => $e->getMessage(),
                        'sql' => $sql
                    ));
                }
            }
            $conn = null;
        } catch (Exception $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    } else {
        try {
            throw new Exception('Missing parameters for function ' . __FUNCTION__);
        } catch (Exception $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    }
}

/***************************************
 * LeggiValoriParametri                *
 ***************************************/
function LeggiValoriParametri()
{
    $etaintestatario = $_POST['idetaintestatario'];
    $professione = $_POST['idprofessione'];
    $marcaveicolo = $_POST['idmarcaveicolo'];
    $tipoveicolo = $_POST['idtipoveicolo'];
    $gruppoetaveicolo = $_POST['idgruppoetaveicolo'];
    $numsinistridenunciati = $_POST['idnumsinistridenunciati'];
    $numannisenzasinistri = $_POST['idnumannisenzasinistri'];
    $massimale = $_POST['idmassimale'];
    $tipofrazionamento = $_POST['idtipofrazionamento'];

    $sql = "SELECT 'etaintestatario' as id,valore FROM etaintestatari where idetaintestatario = ?
                UNION
                SELECT 'professione' as id,valore FROM professioni where idprofessione = ?
                UNION
                SELECT 'marcaveicolo' as id,valore FROM marcheveicolo where idmarcaveicolo = ?
                UNION
                SELECT 'tipoveicolo' as id,valore FROM tipiveicolo where idtipoveicolo = ?
                UNION
                SELECT 'gruppoetaveicolo' as id,valore FROM gruppietaveicolo where idgruppoetaveicolo = ?
                UNION
                SELECT 'numsinistridenunciati' as id,valore FROM numsinistridenunciati where idnumsinistridenunciati = ?
                UNION
                SELECT 'numannisenzasinistri' as id,valore FROM numannisenzasinistri where idnumannisenzasinistri = ?
                UNION
                SELECT 'massimale' as id,valore FROM massimali where idmassimale = ?
                UNION
                SELECT 'tipofrazionamento' as id,valore FROM tipifrazionamento where idtipofrazionamento = ?
                UNION
                SELECT nome as id,valore FROM parametri;";

    if ($etaintestatario && $professione && $marcaveicolo && $tipoveicolo && $gruppoetaveicolo && $numsinistridenunciati && $numannisenzasinistri && $massimale && $tipofrazionamento) {

        //try the connection to the database and execute the SQL statement
        try {
            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $stmt = $conn->prepare($sql);
            $stmt->execute(array($etaintestatario,$professione,$marcaveicolo,$tipoveicolo,$gruppoetaveicolo,
                $numsinistridenunciati,$numannisenzasinistri,$massimale,$tipofrazionamento));

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array(
                'status' => 'success',
                'result' => $data,
                'sql' => $sql
            ));
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    } else {
        try {
            throw new Exception('Missing parameters for function ' . __FUNCTION__);
        } catch (Exception $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    }
    $conn = null;
}

/***************************************
 * Login                               *
 ***************************************/
function Login()
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = md5($password);

    $sql = "SELECT idutente,cognome,nome FROM utenti where LOWER(username) = :username and password = :password and attivo = 1";

    if ($username && $password) {
        try {
            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare($sql);
            $stmt->execute(array(
                "username" => $username,
                "password" => $password
            ));

            if ($stmt->rowCount() > 0) {
                // fetch the row
                $row = $stmt->fetch();
                // start a session
                session_start();
                $_SESSION ["authorized"] = 1;
                $_SESSION ["username"] = $username;
                $_SESSION ["idutente"] = $row ["idutente"];
                $_SESSION ["nome"] = $row ["nome"];

                echo json_encode(array(
                    'status' => 'success',
                    'result' => $row,
                    'sql' => $sql
                ));

                //echo json_encode(array(
                //    'status' => 'success',
                //    'result' => array('idutente' => $row ["idutente"], 'username' => $username, 'password' => $password)
                //));
            } else {
                try {
                    throw new Exception('Utente e/o password non corretti! ');
                } catch (Exception $e) {
                    echo json_encode(array(
                        'status' => 'error',
                        'result' => $e->getMessage(),
                        'sql' => $sql
                    ));
                }
            }
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    } else {
        try {
            throw new Exception('Missing parameters for function ' . __FUNCTION__);
        } catch (Exception $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    }
}

/***************************************
 * SalvaCliente                        *
 ***************************************/
function SalvaCliente()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $columns = '';
        $values = '';
        $column_names = array('idcliente', 'codicefiscale', 'cognome', 'nome', 'email', 'telefono', 'cellulare', 'datanascita', 'idprofessione');
        foreach ($column_names as $desired_key) { // Check the cliente received. If blank insert blank into the array.
            $$desired_key = $_POST[$desired_key];
            $columns = $columns . $desired_key . ',';
            $values = $values . "'" . $$desired_key . "',";
        }

        $columns = $columns . 'attivo,modificatoda,operazione,dataoperazione';
        $values = $values . "1,1,'I',sysdate()";

        $sql = 'INSERT INTO clienti(' . $columns . ') VALUES(' . $values . ')';

        try {
            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //prepare the sql string
            $stmt = $conn->prepare($sql);

            $stmt->execute();

            echo json_encode(array(
                'status' => 'success',
                'result' => 'OK',
                'sql' => $sql
            ));
            $conn = null;
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    }
}

/***************************************
 * SalvaPreventivo                     *
 ***************************************/
function SalvaPreventivo()
{
    $fullSql = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        session_start();
        $loggedUser = $_SESSION ["idutente"];

        $idpreventivo = $_POST["preventivo"]["idpreventivo"];
        $idcliente = $_POST["preventivo"]["idcliente"];
        $operazione = $_POST["preventivo"]["operazione"];

        try {
            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            try {
                $conn->beginTransaction();

                // cancello il preventivo
                $sql = "DELETE FROM preventivi WHERE idpreventivo='" . $idpreventivo . "';";
                $fullSql .= $sql;
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                // cancello il cliente
                $sql = "DELETE FROM clienti WHERE idcliente='" . $idcliente . "';";
                $fullSql .= $sql;
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                // cancello la polizza rca
                $sql = "DELETE FROM polizzerca WHERE idpreventivo='" . $idpreventivo . "';";
                $fullSql .= $sql;
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                // cancello la polizza augusta
                $sql = "DELETE FROM polizzeaugusta WHERE idpreventivo='" . $idpreventivo . "';";
                $fullSql .= $sql;
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                //cancello gli accessori
                $sql = "DELETE FROM polizzeaccessori WHERE idpreventivo='" . $idpreventivo . "';";
                $fullSql .= $sql;
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                // cancello le coperture aggiuntive
                $sql = "DELETE FROM polizzecopertureaggiuntive WHERE idpreventivo='" . $idpreventivo . "';";
                $fullSql .= $sql;
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                // Query CLIENTI
                $sql = GeneraQuery($_POST["cliente"], "clienti", $loggedUser, $operazione);
                $fullSql .= $sql;
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                // Query POLIZZERCA
                $rca = $_POST["rca"];
                if ($rca) {
                    $sql = GeneraQuery($_POST["rca"], "polizzerca", $loggedUser, $operazione);
                    $fullSql .= $sql;
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                }

                // Query POLIZZEAUGUSTA
                $augusta = $_POST["augusta"];
                if($augusta) {
                    $sql = GeneraQuery($_POST["augusta"], "polizzeaugusta", $loggedUser, $operazione);
                    $fullSql .= $sql;
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                }

                // Query POLIZZEACCESSORI
                $accessori = $_POST["accessori"];
                if($accessori) {
                    $sql = PreparaQueryAccessori($_POST["accessori"], $loggedUser, $operazione);
                    $fullSql .= $sql;
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                }
                // Query POLIZZECOPERTUREAGGIUNTIVE
                $copertureaggiuntive = $_POST["copertureaggiuntive"];
                if ($copertureaggiuntive) {
                    $sql = PreparaQueryCopertureAggiuntive($_POST["copertureaggiuntive"], $loggedUser, $operazione);
                    $fullSql .= $sql;
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                }

                // Query PREVENTIVI
                $sql = GeneraQuery($_POST["preventivo"], "preventivi", $loggedUser, $operazione);
                $fullSql .= $sql;
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                echo json_encode(array(
                    'status' => 'success',
                    'result' => 'OK',
                    'sql' => $fullSql
                ));

                $conn->commit();

            } catch (PDOException $e) {

                $conn->rollBack();

                echo json_encode(array(
                    'status' => 'error',
                    'result' => $e->getMessage(),
                    'sql' => $fullSql
                ));
            }

            $conn = null;
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $fullSql
            ));
        }
    }
}


/***************************************
 * SaveRecord                          *
 ***************************************/
function SaveRecord()
{
    $table = $_POST['table'];
    $key = $_POST['key'];
    $columns = $_POST['columns'];
    $attivo = $_POST['attivo'];
    $modificatoda = $_POST["modificatoda"];
    $operazione = $_POST['operazione'];
    $autoincrement = $_POST['autoincrement'];

    try {
        $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (!empty($_POST['keyvalue'])) {

            $keyvalue = $_POST['keyvalue'];

            $sql = "UPDATE " . $table . " SET ";

            $set = "";
            foreach ($columns as $k => $v) {
                if ($v == "NULL") {
                    $set .= $k . " = " . $v . ",";
                } else {
                    $set .= $k . " = '" . addslashes($v) . "',";
                }
            }

            $set .= "attivo='" . $attivo . "',modificatoda='" . $modificatoda . "',operazione='" . $operazione . "',dataoperazione=SYSDATE()";

            $sql .= $set . " WHERE " . $key . "='" . $keyvalue . "'";

        } else {
            $timestamp = time();
            $sql = "INSERT INTO " . $table . " (";

            if (!$autoincrement) {
                $keyvalue = substr(strtoupper($table), 0, 2) . $timestamp;
                $fields = $key . ",";
                $values = "'" . $keyvalue . "',";
            }

            foreach ($columns as $k => $v) {
                $fields .= $k . ",";
                if ($v == "NULL") {
                    $values .= $v . ",";
                } else {
                    $values .= "'" . addslashes($v) . "',";
                }

            }

            $fields .= "attivo,modificatoda,operazione,dataoperazione";
            $values .= "'" . $attivo . "','" . $modificatoda . "','" . $operazione . "',SYSDATE()";

            $sql .= $fields . ") VALUES (" . $values . ")";
        }

        //prepare the sql string
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        echo json_encode(array(
            'status' => 'success',
            $key => $keyvalue,
            'sql' => $sql,
            'result' => 'OK'
        ));
    } catch (PDOException $e) {
        echo json_encode(array(
            'status' => 'error',
            $key => $keyvalue,
            'sql' => $sql,
            'result' => $e->getMessage()
        ));
    }
    $conn = null;
}


function SalvaUtentiGruppi()
{
    $searchIDs = $_POST['searchIDs'];
    $sqlTemp = 'TRUNCATE TABLE utenti_gruppi;INSERT INTO utenti_gruppi (idutente,idgruppo) VALUES ';
    foreach ($searchIDs as $v) {
        $pieces = explode("_", $v);
        $sqlTemp .= '(' . $pieces[1] . ',' . $pieces[2] . '),';
    }

    $sql = rtrim($sqlTemp, ",") . ";";

    try {
        $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //prepare the sql string
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        echo json_encode(array(
            'status' => 'success',
            'result' => $sql
        ));
    } catch (PDOException $e) {
        echo json_encode(array(
            'status' => 'error',
            'result' => $e->getMessage()
        ));
    }
    $conn = null;
}

function SalvaGruppiRuoli()
{
    $searchIDs = $_POST['searchIDs'];
    $sqlTemp = 'TRUNCATE TABLE gruppi_ruoli;INSERT INTO gruppi_ruoli (idgruppo,idruolo) VALUES ';
    foreach ($searchIDs as $v) {
        $pieces = explode("_", $v);
        $sqlTemp .= '(' . $pieces[1] . ',' . $pieces[2] . '),';
    }

    $sql = rtrim($sqlTemp, ",") . ";";

    try {
        $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //prepare the sql string
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        echo json_encode(array(
            'status' => 'success',
            'result' => $sql
        ));
    } catch (PDOException $e) {
        echo json_encode(array(
            'status' => 'error',
            'result' => $e->getMessage()
        ));
    }
    $conn = null;
}

function SalvaRuoliAutorizzazioni()
{
    $searchIDs = $_POST['searchIDs'];
    $sqlTemp = 'TRUNCATE TABLE ruoli_autorizzazioni;INSERT INTO ruoli_autorizzazioni (idruolo,idautorizzazione) VALUES ';
    foreach ($searchIDs as $v) {
        $pieces = explode("_", $v);
        $sqlTemp .= '(' . $pieces[1] . ',' . $pieces[2] . '),';
    }

    $sql = rtrim($sqlTemp, ",") . ";";

    try {
        $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //prepare the sql string
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        echo json_encode(array(
            'status' => 'success',
            'result' => $sql
        ));
    } catch (PDOException $e) {
        echo json_encode(array(
            'status' => 'error',
            'result' => $e->getMessage()
        ));
    }
    $conn = null;
}

/***************************************
 * TestAjax                            *
 ***************************************/
function TestAjax()
{
    $starttime = date('h:i:s') . "\n";
    // sleep for 5 seconds
    sleep(5);
    $endtime = date('h:i:s') . "\n";
    echo json_encode(array(
        'status' => 'success',
        'result' => $starttime . " - " . $endtime
    ));
}


/* FUNZIONI DI SERVIZIO */


/***************************************
 * FormatDBDate                        *
 ***************************************/
function FormatDBDate($dateToFormat)
{
    $ddd = "null";
    if (!empty($dateToFormat)) {
        list ($giorno, $mese, $anno) = split('[/.-]', $dateToFormat);
        $ddd = "'" . $anno . "-" . $mese . "-" . $giorno . "'";
    }
    return $ddd;
}

/***************************************
 * FormatDBText                        *
 ***************************************/
function FormatDBText($textToFormat)
{
    $sss = "null";
    if (!empty($textToFormat)) {
        $sss = "'" . $textToFormat . "'";
    }
    return $sss;
}

/***************************************
 * FormatDBNum                         *
 ***************************************/
function FormatDBNum($numToFormat)
{
    $sss = "null";
    if (!empty($numToFormat)) {
        $sss = $numToFormat;
    }
    return $sss;
}

/***************************************
 * PreparaQueryAccessori               *
 ***************************************/
function PreparaQueryAccessori($post, $utente, $operazione)
{
    $values = "";
    $idpreventivo = $post["idpreventivo"];
    $listaaccessori = $post["listaaccessori"];

    foreach ($listaaccessori as $obj) {
        $values = $values . "('" . $idpreventivo . "','" . $obj["id"] . "','" . $obj["listinoscontato"] . "','" . $obj["margine"] . "'," . "1," . $utente . ",'" . $operazione . "',sysdate()),";
    }

    $sql = trim('INSERT INTO polizzeaccessori(idpreventivo,idaccessorio,listinoscontato,margine,attivo,modificatoda,operazione,dataoperazione) VALUES' . $values, ',') . ';';

    return $sql;
}

/***************************************
 * PreparaQueryCopertureAggiuntive     *
 ***************************************/
function PreparaQueryCopertureAggiuntive($post, $utente, $operazione)
{
    $values = "";
    $idpreventivo = $post["idpreventivo"];
    $listacopertureaggiuntive = $post["listacopertureaggiuntive"];

    foreach ($listacopertureaggiuntive as $obj) {
        $values = $values . "('" . $idpreventivo . "','" . $obj["id"] .
            "','" . $obj["premio"] .
            "','" . $obj["durata"] .
            "','" . $obj["costo"] .
            "','" . $obj["margine"] .
            "'," . "1," . $utente . ",'" . $operazione . "',sysdate()),";
    }

    $sql = trim('INSERT INTO polizzecopertureaggiuntive(idpreventivo,idcopertura,premio,durata,costo,margine,attivo,modificatoda,operazione,dataoperazione) VALUES' . $values, ',') . ';';

    return $sql;
}

/***************************************
 * GeneraQuery                         *
 ***************************************/
function GeneraQuery($post, $table, $utente, $operazione)
{
    switch ($table) {
        case 'clienti' :
            $column_names = array('idcliente', 'codicefiscale', 'cognome', 'nome', 'email', 'telefono', 'cellulare', 'datanascita', 'idprofessione');
            break;
        case 'polizzerca' :
            $column_names = array('idpreventivo', 'idcliente', 'idmarcaveicolo', 'idtipoveicolo', 'idgruppoetaveicolo', 'idcilindrata',
                'idclassepotenza', 'idtipoalimentazione', 'classemerito', 'idnumannisenzasinistri', 'idnumsinistridenunciati', 'idmassimale',
                'idtipofrazionamento', 'blackbox', 'guidaesperta', 'polinfcond', 'idcomune', 'idetaintestatario', 'idprofessione', 'totalerca');
            break;
        case 'polizzeaugusta' :
            $column_names = array('idpreventivo', 'categoria', 'regione', 'provincia', 'duratacopertura', 'valoredaassicurare',
                'coeffF', 'importoF', 'coeffC', 'importoC', 'coeffK', 'importoK', 'totaleaugusta');
            break;
        case 'preventivi' :
            $column_names = array('idpreventivo', 'idcliente', 'premiototale');
            break;
    }

    $columns = '';
    $values = '';

    foreach ($column_names as $desired_key) {
        $$desired_key = $post[$desired_key];
        $columns = $columns . $desired_key . ',';
        $values = $values . "'" . addslashes($$desired_key) . "',";
    }

    $columns = $columns . 'attivo,modificatoda,operazione,dataoperazione';
    $values = $values . "1," . $utente . ",'" . $operazione . "',sysdate()";

    $sql = 'INSERT INTO ' . $table . '(' . $columns . ') VALUES(' . $values . ');';

    return $sql;
}

/***************************************
 * Sanitize                            *
 ***************************************/
function Sanitize($data) {
    $data = trim($data);

    if(get_magic_quotes_gpc()) {
        $data = stripslashes($data);
    }
    return($data);
}

?>