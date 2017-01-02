<?php
require_once 'config.php';

date_default_timezone_set('Europe/Rome');
//============================================================+
// File name   : example_048.php
// Begin       : 2009-03-20
// Last Update : 2013-05-14
//
// Description : Example 048 for TCPDF class
//               HTML tables and table headers
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: HTML tables and table headers
 * @author Nicola Asuni
 * @since 2009-03-20
 */

// Include the main TCPDF library (search for installation path).
require_once('TCPDF/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$idpreventivo = $_GET['idpreventivo'];

$preventivo = json_decode(LeggiPreventivo($idpreventivo),true);
$premiototale = $preventivo["result"]["preventivo"]["premiototale"];

//var_dump($preventivo["result"]["preventivo"]["copertureaggiuntive"]);
//die();

$cliente = $preventivo["result"]["cliente"];
foreach ($cliente as $name => $value) {
    $$name = $value;
}

if ($preventivo["result"]["preventivo"]["rca"] == "1") {
    $rca = $preventivo["result"]["rca"];
    $tabellarca = '<p><h2>Dati RCA</h2><table>';
    $tabellarca .= '<tr>';
    $tabellarca .= '<td align="left"><strong>Comune</strong></td><td align="left">' . $rca['comunerca'] . '</td>';
    $tabellarca .= '<td align="left"><strong>Provincia</strong></td><td align="left">' . $rca['provinciarca'] . '</td>';
    $tabellarca .= '</tr>';
    $tabellarca .= '<tr>';
    $tabellarca .= '<td align="left"><strong>Tipo alimentazione</strong></td><td align="left" colspan="3">' . $rca['tipoalimentazione'] . '</td>';
    $tabellarca .= '</tr>';
    $tabellarca .= '<tr>';
    $tabellarca .= '<td align="left"><strong>Cilindrata</strong></td><td align="left">' . $rca['cilindrata'] . '</td>';
    $tabellarca .= '<td align="left"><strong>Classe potenza</strong></td><td align="left">' . $rca['classepotenza'] . '</td>';
    $tabellarca .= '</tr>';
    $tabellarca .= '<tr>';
    $tabellarca .= '<td align="left"><strong>Marca veicolo</strong></td><td align="left">' . $rca['marcaveicolo'] . '</td>';
    $tabellarca .= '<td align="left"><strong>Tipo veicolo</strong></td><td align="left">' . $rca['tipoveicolo'] . '</td>';
    $tabellarca .= '</tr>';
    $tabellarca .= '<tr>';
    $tabellarca .= '<td align="left"><strong>Età veicolo</strong></td><td align="left">' . $rca['etaveicolo'] . '</td>';
    $tabellarca .= '<td align="left"><strong>Classe di merito</strong></td><td align="left">' . $rca['classemerito'] . '</td>';
    $tabellarca .= '</tr>';
    $tabellarca .= '<tr>';
    $tabellarca .= '<td align="left"><strong>Anni senza sinistri</strong></td><td align="left">' . $rca['numannisenzasinistri'] . '</td>';
    $tabellarca .= '<td align="left"><strong>Sinistri denunciati ult. 2 anni</strong></td><td align="left">' . $rca['numsinistridenunciati'] . '</td>';
    $tabellarca .= '</tr>';
    $tabellarca .= '<tr>';
    $tabellarca .= '<td align="left"><strong>Massimale</strong></td><td align="left">' . $rca['massimale'] . '</td>';
    $tabellarca .= '<td align="left"><strong>Frazionamento</strong></td><td align="left">' . $rca['tipofrazionamento'] . '</td>';
    $tabellarca .= '</tr>';
    $tabellarca .= '<tr>';
    $tabellarca .= '<td align="left"><strong>Black-box</strong></td><td align="left">' . ($rca['blackbox'] == 1?"SI":"NO") . '</td>';
    $tabellarca .= '<td align="left"><strong>Guida esperta</strong></td><td align="left">' . ($rca['guidaesperta'] == 1?"SI":"NO") . '</td>';
    $tabellarca .= '</tr>';
    $tabellarca .= '<tr>';
    $tabellarca .= '<td align="left"><strong>Polizza inf. cond.</strong></td><td align="left">' . ($rca['polinfcond'] == 1?"SI":"NO") . '</td>';
    $tabellarca .= '<td align="left"><strong>&nbsp;</strong></td><td align="right">&nbsp;</td>';
    $tabellarca .= '</tr>';
    $tabellarca .= '<tr>';
    $tabellarca .= '<td align="right" colspan="3"><strong>TOTALE RCA</strong></td><td align="right">' . $rca['totalerca'] . '€</td>';
    $tabellarca .= '</tr>';
    $tabellarca .= '</table></p>';
}

if ($preventivo["result"]["preventivo"]["augusta"] == "1") {
    $augusta = $preventivo["result"]["augusta"];
    $tabellaaugusta = '<p><h2>Dati Augusta</h2><table>';
    $tabellaaugusta .= '<tr>';
    $tabellaaugusta .= '<td align="left"><strong>Regione</strong></td><td align="left">' . $augusta['regioneaugusta'] . '</td>';
    $tabellaaugusta .= '<td align="left"><strong>Provincia</strong></td><td align="left">' . $augusta['provinciaaugusta'] . '</td>';
    $tabellaaugusta .= '</tr>';
    $tabellaaugusta .= '<tr>';
    $tabellaaugusta .= '<td align="left"><strong>Durata copertura</strong></td><td align="left">' . $augusta['duratacopertura'] . '</td>';
    $tabellaaugusta .= '<td align="left"><strong>Valore da assicurare</strong></td><td align="right">' . $augusta['valoredaassicurare'] . '€</td>';
    $tabellaaugusta .= '</tr>';
    $tabellaaugusta .= '<tr>';
    $tabellaaugusta .= '<td align="left"><strong>Categoria</strong></td><td align="left" colspan="3">' . ($augusta['categoriaaugusta']=="N"?"Nuovo":"Usato") . '</td>';
    $tabellaaugusta .= '</tr>';
    $tabellaaugusta .= '<tr>';
    $tabellaaugusta .= '<td align="left"><strong>Coeff. FIR</strong></td><td align="left">' . $augusta['coeffF'] . '</td>';
    $tabellaaugusta .= '<td align="left"><strong>Importo FIR</strong></td><td align="right">' . $augusta['importoF'] . '€</td>';
    $tabellaaugusta .= '</tr>';
    $tabellaaugusta .= '<tr>';
    $tabellaaugusta .= '<td align="left"><strong>Coeff. Coll.</strong></td><td align="left">' . $augusta['coeffC'] . '</td>';
    $tabellaaugusta .= '<td align="left"><strong>Importo Coll.</strong></td><td align="right">' . $augusta['importoC'] . '€</td>';
    $tabellaaugusta .= '</tr>';
    $tabellaaugusta .= '<tr>';
    $tabellaaugusta .= '<td align="left"><strong>Coeff. KASKO</strong></td><td align="left">' . $augusta['coeffK'] . '</td>';
    $tabellaaugusta .= '<td align="left"><strong>Importo KASKO</strong></td><td align="right">' . $augusta['importoK'] . '€</td>';
    $tabellaaugusta .= '</tr>';
    $tabellaaugusta .= '<tr>';
    $tabellaaugusta .= '<td align="right" colspan="3"><strong>TOTALE AUGUSTA</strong></td><td align="right">' . $augusta['totaleaugusta'] . '€</td>';
    $tabellaaugusta .= '</tr>';
    $tabellaaccessori .= '</table></p>';
}

if ($preventivo["result"]["preventivo"]["accessori"] == "1") {
    $accessori = $preventivo["result"]["accessori"];
    $tabellaaccessori ='<p><h2>Dati accessori</h2><table>';
    $tabellaaccessori .= '<tr><td align="left"><h3>Accessorio</h3></td><td align="right"><h3>Listino scontato</h3></td></tr>';
    foreach ($accessori as $row) {
        $tabellaaccessori .= '<tr>';
        $tabellaaccessori .= '<td align="left">' . $row['accessorio'] . '</td>';
        $tabellaaccessori .= '<td align="right">' . $row['listinoscontato'] . '€</td>';
        $tabellaaccessori .= '</tr>';
    }
    $tabellaaccessori .= '</table></p>';
}


if ($preventivo["result"]["preventivo"]["copertureaggiuntive"] == "1") {
    $copertureaggiuntive = $preventivo["result"]["copertureaggiuntive"];
    $tabellacoperture = '<p><h2>Dati coperture aggiuntive</h2><table>';
    $tabellacoperture .= '<tr><td align="left"><h3>Copertura</h3></td><td align="center"><h3>Durata</h3></td><td align="right"><h3>Premio</h3></td></tr>';
    foreach ($copertureaggiuntive as $row) {
        $tabellacoperture .= '<tr>';
        $tabellacoperture .= '<td align="left">' . $row['copertura'] . '</td>';
        $tabellacoperture .= '<td align="center">' . $row['durata'] . '</td>';
        $tabellacoperture .= '<td align="right">' . $row['premio'] . '€</td>';
        $tabellacoperture .= '</tr>';
    }
    $tabellacoperture .= '</table></p>';
}


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Simmaco Ferriero');
$pdf->SetTitle('Preventivo n.' . $idpreventivo);
$pdf->SetSubject('Preventivo n.' . $idpreventivo);
$pdf->SetKeywords('PDF, preventivo');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->setHeaderData("../images/logo-palmesano.png");

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 8);

// add a page
$pdf->AddPage();



// -----------------------------------------------------------------------------
//e.descrizione as etaveicolo,f.descrizione as cilindrata,g.descrizione as classepotenza,
//h.descrizione as tipoalimentazione,a.classemerito as classemerito,i.descrizione as numannisenzasinistri,
//j.descrizione as numsinistridenunciati,k.descrizione as massimale,l.descrizione as tipofrazionamento,
//a.blackbox as blackbox,a.guidaesperta as guidaesperta,a.polinfcond as polinfcond

// Table with rowspans and THEAD
$tbl = <<<EOD

<h1>Preventivo n. $idpreventivo</h1>
<br>
<h2>Dati cliente</h2>
<p>
<table border="1" width="100%">
 <tr>
  <td width="20%" align="left"><strong>Cognome</strong></td>
  <td align="left">$cognome</td>
  <td width="20%" align="left"><strong>Nome</strong></td>
  <td align="left">$nome</td>
 </tr>
 <tr>
  <td width="20%" align="left"><strong>Codice fiscale</strong></td>
  <td align="left">$codicefiscale</td>
  <td width="20%" align="left"><strong>Data di nascita</strong></td>
  <td align="left">$datanascita</td>
 </tr>
 <tr>
  <td width="20%" align="left"><strong>Professione</strong></td>
  <td align="left">$professione</td>
  <td width="20%" align="left"><strong>Email</strong></td>
  <td align="left">$email</td>
 </tr>
</table>

$tabellarca

$tabellaaugusta

$tabellaaccessori

$tabellacoperture

<table border="1" width="100%">
 <tr>
  <td width="20%" align="left"><strong>Totale preventivo</strong></td>
  <td align="right" colspan="3">$premiototale €</td>
 </tr>
</table>

EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');


//Close and output PDF document
$pdf->Output('parametri.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+



function LeggiPreventivo($idpreventivo)
{
    $sql = "SELECT a.*,
                  (select case count(*) when 0 then 0 else 1 end from polizzerca x where x.idpreventivo=a.idpreventivo) as rca,
                  (select case count(*) when 0 then 0 else 1 end from polizzeaugusta y where y.idpreventivo=a.idpreventivo) as augusta,
                  (select case count(*) when 0 then 0 else 1 end from polizzeaccessori z where z.idpreventivo=a.idpreventivo) as accessori, 
                  (select case count(*) when 0 then 0 else 1 end from polizzecopertureaggiuntive w where w.idpreventivo=a.idpreventivo) as copertureaggiuntive 
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
                $rcaSi = ($preventivo["rca"] == "1" ? true : false);
                $augustaSi = ($preventivo["augusta"] == "1" ? true : false);
                $accessoriSi = ($preventivo["accessori"] == "1" ? true : false);
                $copertureaggiuntiveSi = ($preventivo["copertureaggiuntive"] == "1" ? true : false);

                $sqlCliente = "select a.* from clienti a WHERE a.attivo=1 and a.idcliente='" . $idcliente . "'";
                $stmtCliente = $conn->prepare($sqlCliente);
                $stmtCliente->execute();
                $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

                if ($rcaSi) {
                    $sqlAxa = "select a.idpreventivo,b.comune as comunerca,b.provincia as provinciarca,
                                c.descrizione as marcaveicolo,d.descrizione as tipoveicolo,
                                e.descrizione as etaveicolo,f.descrizione as cilindrata,g.descrizione as classepotenza,
                                h.descrizione as tipoalimentazione,a.classemerito as classemerito,i.descrizione as numannisenzasinistri,
                                j.descrizione as numsinistridenunciati,k.descrizione as massimale,l.descrizione as tipofrazionamento,
                                a.blackbox as blackbox,a.guidaesperta as guidaesperta,a.polinfcond as polinfcond,a.totalerca
                                from polizzerca a 
                                inner join zone b on a.idcomune = b.idcomune 
                                inner join marcheveicolo c on a.idmarcaveicolo = c.idmarcaveicolo 
                                inner join tipiveicolo d on a.idtipoveicolo = d.idtipoveicolo 
                                inner join gruppietaveicolo e on a.idgruppoetaveicolo = e.idgruppoetaveicolo 
                                inner join cilindrate f on a.idcilindrata = f.idcilindrata 
                                inner join classipotenza g on a.idclassepotenza = g.idclassepotenza
                                inner join tipialimentazione h on a.idtipoalimentazione = h.idtipoalimentazione
                                inner join numannisenzasinistri i on a.idnumannisenzasinistri = i.idnumannisenzasinistri
                                inner join numsinistridenunciati j on a.idnumsinistridenunciati = j.idnumsinistridenunciati
                                inner join massimali k on a.idmassimale = k.idmassimale
                                inner join tipifrazionamento l on a.idtipofrazionamento = l.idtipofrazionamento
                                WHERE a.attivo=1 and a.idpreventivo='" . $idpreventivo . "'";
                    $stmtAxa = $conn->prepare($sqlAxa);
                    $stmtAxa->execute();
                    $rca = $stmtAxa->fetch(PDO::FETCH_ASSOC);
                } else {
                    $rca = null;
                }

                if ($augustaSi) {
                    $sqlAugusta = "select a.categoria as categoriaaugusta,
                                    a.regione as regioneaugusta,a.provincia as provinciaaugusta,
                                    a.duratacopertura,a.valoredaassicurare,
                                    a.coeffF,a.importoF,a.coeffC,a.importoC,a.coeffK,a.importoK,
                                    a.totaleaugusta
                                    from polizzeaugusta a WHERE a.attivo=1 and a.idpreventivo='" . $idpreventivo . "'";
                    $stmtAugusta = $conn->prepare($sqlAugusta);
                    $stmtAugusta->execute();
                    $augusta = $stmtAugusta->fetch(PDO::FETCH_ASSOC);
                } else {
                    $augusta = null;
                }

                if ($accessoriSi) {
                    $sqlAccessori = "select b.descrizione as accessorio,a.listinoscontato
                                        from polizzeaccessori a 
                                        inner join accessori b on a.idaccessorio=b.idaccessorio
                                        WHERE a.attivo=1 and a.idpreventivo='" . $idpreventivo . "'";
                    $stmtAccessori = $conn->prepare($sqlAccessori);
                    $stmtAccessori->execute();
                    $accessori = $stmtAccessori->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $accessori = null;
                }

                if ($copertureaggiuntiveSi) {
                    $sqlCopertureAggiuntive = "select b.descrizione as copertura,a.premio,a.durata,a.costo,a.margine
                                                from polizzecopertureaggiuntive a 
                                                inner join copertureaggiuntive b on a.idcopertura = b.idcoperturaaggiuntiva
                                                WHERE a.attivo=1 and a.idpreventivo='" . $idpreventivo . "'";
                    $stmtCopertureAggiuntive = $conn->prepare($sqlCopertureAggiuntive);
                    $stmtCopertureAggiuntive->execute();
                    $copertureaggiuntive = $stmtCopertureAggiuntive->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $copertureaggiuntive = null;
                }

                return json_encode(array(
                    'status' => 'success',
                    'result' => array('preventivo' => $preventivo, 'cliente' => $cliente, 'rca' => $rca, 'augusta' => $augusta, 'accessori' => $accessori, 'copertureaggiuntive' => $copertureaggiuntive),
                    'sql' => $idcliente
                ));
            } else {
                try {
                    throw new Exception('Value not found in function ' . __FUNCTION__);
                } catch (Exception $e) {
                    return json_encode(array(
                        'status' => 'error',
                        'result' => $e->getMessage(),
                        'sql' => $sql
                    ));
                }
            }
            $conn = null;
        } catch (Exception $e) {
            return json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    } else {
        try {
            throw new Exception('Missing parameters for function ' . __FUNCTION__);
        } catch (Exception $e) {
            return json_encode(array(
                'status' => 'error',
                'result' => $e->getMessage(),
                'sql' => $sql
            ));
        }
    }
}
