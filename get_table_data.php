<?php
    require_once 'config.php';

    if (isset($_GET['tabella']) && !empty($_GET['tabella'])) {
        $tabella = $_GET['tabella'];
        switch ($tabella) {
            case 'preventivi' :
                $SQL = "SELECT a.idpreventivo,a.idcliente,a.premiototale,b.codicefiscale, b.cognome, b.nome, b.email, b.telefono, b.cellulare, b.datanascita,
                        c.descrizione as professione,
                        (select case count(*) when 0 then 'NO' else 'SI' end from polizzerca x where x.idpreventivo=a.idpreventivo) as rca,
                        (select case count(*) when 0 then 'NO' else 'SI' end from polizzeaugusta y where y.idpreventivo=a.idpreventivo) as augusta,
                        (select case count(*) when 0 then 'NO' else 'SI' end from polizzeaccessori z where z.idpreventivo=a.idpreventivo) as accessori, 
                        (select case count(*) when 0 then 'NO' else 'SI' end from polizzecopertureaggiuntive w where w.idpreventivo=a.idpreventivo) as copertureaggiuntive 
                        FROM preventivi a
                        inner join clienti b on a.idcliente=b.idcliente
                        left join professioni c on b.idprofessione=c.idprofessione
                        WHERE a.attivo=1 ORDER BY a.idpreventivo DESC";
                break;
            case 'clienti' :
                $SQL = "SELECT a.*,b.descrizione as professione,b.valore as valoreprofessione 
                          FROM clienti a inner join professioni b on a.idprofessione=b.idprofessione 
                          WHERE a.attivo=1";
                break;
            case 'utenti' :
                $SQL = "SELECT a.* FROM utenti a  WHERE a.attivo=1";
                break;
            case 'gruppi' :
                $SQL = "SELECT a.* FROM gruppi a  WHERE a.attivo=1";
                break;
            case 'autorizzazioni' :
                $SQL = "SELECT a.*,b.descrizione as azione,c.descrizione as tabella 
                        FROM autorizzazioni a inner join azioni b on a.idazione=b.idazione 
                        inner join tabelle c on a.idtabella=c.idtabella WHERE a.attivo=1";
                break;
            case 'ruoli' :
                $SQL = "SELECT a.* FROM ruoli a  WHERE a.attivo=1";
                break;
            case 'parametri' :
                $SQL = "SELECT a.* FROM parametri a  WHERE a.attivo=1";
                break;
            case 'professioni' :
                $SQL = "SELECT a.* FROM professioni a  WHERE a.attivo=1";
                break;
            case 'etaintestatari' :
                $SQL = "SELECT a.* FROM etaintestatari a WHERE a.attivo=1";
                break;
            case 'massimali' :
                $SQL = "SELECT a.* FROM massimali a WHERE a.attivo=1";
                break;
            case 'numannisenzasinistri' :
                $SQL = "SELECT a.* FROM numannisenzasinistri a WHERE a.attivo=1";
                break;
            case 'numsinistridenunciati' :
                $SQL = "SELECT a.* FROM numsinistridenunciati a WHERE a.attivo=1";
                break;
            case 'tipiveicolo' :
                $SQL = "SELECT a.* FROM tipiveicolo a WHERE a.attivo=1";
                break;
            case 'gruppietaveicolo' :
                $SQL = "SELECT a.* FROM gruppietaveicolo a WHERE a.attivo=1";
                break;
            case 'marcheveicolo' :
                $SQL = "SELECT a.* FROM marcheveicolo a WHERE a.attivo=1";
                break;
            case 'tipifrazionamento' :
                $SQL = "SELECT a.* FROM tipifrazionamento a WHERE a.attivo=1";
                break;
            case 'tipialimentazione' :
                $SQL = "SELECT a.* FROM tipialimentazione a WHERE a.attivo=1";
                break;
            case 'cilindrate' :
                $SQL = "SELECT a.* FROM cilindrate a WHERE a.attivo=1";
                break;
            case 'classipotenza' :
                $SQL = "SELECT a.*,b.descrizione as cilindrata,c.descrizione as tipoalimentazione FROM classipotenza a 
                      inner join cilindrate b on a.idcilindrata=b.idcilindrata 
                      inner join tipialimentazione c on a.idtipoalimentazione=c.idtipoalimentazione WHERE a.attivo=1";
                break;

            case 'rca' :
                $SQL = "SELECT a.* FROM polizzerca a WHERE a.attivo=1";
                break;
            case 'augusta' :
                $SQL = "SELECT a.* FROM polizzeaugusta a WHERE a.attivo=1";
                break;
            case 'accessori' :
                $SQL = "SELECT a.* FROM accessori a  WHERE a.attivo=1";
                break;
        }
    }

    try {
        $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare($SQL);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($data);

    } catch (Exception $e) {
        echo $e->getMessage();
    	error_log(date("Y-m-d H:i:s") . " " . $e->getMessage() . PHP_EOL,3,LOGPATH."error.log");
        
    }
    $conn = null;
?>