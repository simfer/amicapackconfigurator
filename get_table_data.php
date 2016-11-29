<?php
    require_once 'config.php';

    if (isset($_GET['tabella']) && !empty($_GET['tabella'])) {
        $tabella = $_GET['tabella'];
        switch ($tabella) {
            case 'preventivi' :
                $SQL = "SELECT a.idpreventivo,a.idcliente,a.premiototale,b.codicefiscale, b.cognome, b.nome, b.email, b.telefono, b.cellulare, b.datanascita,
                        c.descrizione as professione,
                        (select case count(*) when 0 then 'NO' else 'SI' end from polizzeaxa x where x.idpreventivo=a.idpreventivo) as axa,
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
                          WHERE a.attivo=1"; // "SELECT * FROM clienti";
                break;
            case 'parametri' :
                $SQL = "SELECT a.* FROM parametri a  WHERE a.attivo=1";
                break;
            case 'professioni' :
                $SQL = "SELECT a.* FROM professioni a  WHERE a.attivo=1";
                break;
            case 'etaintestatari' :
                $SQL = "SELECT a.* FROM etaintestatari a  WHERE a.attivo=1";
                break;

            case 'axa' :
                $SQL = "SELECT * FROM polizzeaxa WHERE 1=1";
                break;
            case 'augusta' :
                $SQL = "SELECT * FROM polizzeaugusta WHERE 1=1";
                break;
            case 'accessori' :
                $SQL = "SELECT a.* FROM accessori a  WHERE 1=1";
                break;
        }
    }

    try {
        $conn = new PDO (AXA_DB_DSN, AXA_DB_USER, AXA_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
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