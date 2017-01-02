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

//$tabella = $_POST;

var_dump($_POST);
die();

// Include the main TCPDF library (search for installation path).
require_once('TCPDF/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Simmaco Ferriero');
$pdf->SetTitle(ucfirst($tabella));
$pdf->SetSubject(ucfirst($tabella));
$pdf->SetKeywords('PDF,' . $tabella);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

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
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage();

$pdf->Write(0, ucfirst($tabella), '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);


// -----------------------------------------------------------------------------


if ($tabella) {

    switch ($tabella) {
        case 'parametri':
            $fields = array(
                array(name=>'idparametro', displayname=>'ID', width=>'30', align=>'center'),
                array(name=>'nome', displayname=>'Nome', width=>'140', align=>'center',sort=>true),
                array(name=>'descrizione', displayname=>'Descrizione', width=>'140', align=>'center'),
                array(name=>'valore', displayname=>'Valore', width=>'80', align=>'center'),
                array(name=>'tipovalore', displayname=>'TipoValore', width=>'30', align=>'center')
            );
            break;
        case 'utenti':
            $fields = array(
                array(name=>'idutente', displayname=>'ID', width=>'30', align=>'center'),
                array(name=>'username', displayname=>'Username', width=>'80', align=>'center',sort=>true),
                array(name=>'cognome', displayname=>'Cognome', width=>'80', align=>'center'),
                array(name=>'nome', displayname=>'Nome', width=>'80', align=>'center'),
                array(name=>'email', displayname=>'Email', width=>'240', align=>'center')
            );
            break;
        case 'gruppi':
            $fields = array(
                array(name=>'idgruppo', displayname=>'ID', width=>'80', align=>'center'),
                array(name=>'descrizione', displayname=>'Descrizione', width=>'80', align=>'center',sort=>true)
            );
            break;
        case 'ruoli':
            $fields = array(
                array(name=>'idruolo', displayname=>'ID', width=>'80', align=>'center'),
                array(name=>'descrizione', displayname=>'Descrizione', width=>'80', align=>'center',sort=>true)
            );
            break;
        case 'autorizzazioni':
            $fields = array(
                array(name=>'idautorizzazione', displayname=>'ID', width=>'80', align=>'center'),
                array(name=>'descrizione', displayname=>'Descrizione', width=>'140', align=>'center',sort=>true),
                array(name=>'idazione', displayname=>'Azione', width=>'80', align=>'center'),
                array(name=>'idtabella', displayname=>'Tabella', width=>'80', align=>'center')
            );
            break;
    }

    $thead = '<thead>';
    $thead .= '<tr style="background-color:#FFFF00;color:#0000FF;">';
    $sqlFields = '';
    $sortFields ='';

    foreach ($fields as $row) {
        $thead .= '<td width="' . $row["width"] . '" align="' . $row["align"] . '"><b>' . $row["displayname"] . '</b></td>';
        $sqlFields .= $row["name"] . ' as ' . $row["displayname"] . ',';
        if ($row["sort"]) {
            $sortFields .= $row["name"] . ',';
        }
    }
    $thead .= '</tr>';
    $thead .= '</thead>';

    $sql = 'select ' . rtrim($sqlFields,',') . ' from ' . $tabella . ' where attivo = 1 order by ' . rtrim($sortFields,',') . ';';
    //var_dump($thead);
    //die();


    try {
        $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        throw new Exception('Missing parameter for GET request!');
    } catch (Exception $e) {
        echo json_encode(array(
            'status' => 'error',
            'result' => $e->getMessage(),
            'sql' => $sql
        ));
    }
}

$html .= '<table border="1" cellpadding="2" cellspacing="2" width="100%">';

$html .= $thead;

foreach ($records as $row) {
    $html .= '<tr>';
    foreach ($fields as $field) {
        $html .= '<td width="' . $field['width'] . '">' . $row[$field['displayname']] . '</td>';
    }
    $html .= '</tr>';
}
$html .= '</table>';





// Table with rowspans and THEAD
$tbl = <<<EOD
<br>
<br>
$html

EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');


//Close and output PDF document
$pdf->Output($tabella . '.pdf', 'I');

function DescribeTable($table) {
    try {
        $sql = "DESCRIBE " . $table;
        $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode(array(
            'status' => 'success',
            'result' => $records,
            'sql' => $sql
        ));

        $conn = null;
    } catch (Exception $e) {
        return json_encode(array(
            'status' => 'error',
            'result' => $e->getMessage(),
            'sql' => $sql
        ));
    }
}
//============================================================+
// END OF FILE
//============================================================+
