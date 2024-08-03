<?php
require_once('tcpdf/tcpdf/tcpdf.php');

// Define styles
$titleStyle = array(
    'font' => 'helvetica',
    'style' => 'B',
    'size' => 14,
    'color' => array(0, 0, 255),
);

$normalStyle = array(
    'font' => 'helvetica',
    'style' => '',
    'size' => 12,
    'color' => array(0, 0, 0),
);

// Fetch data from request
require("./config.php");
$connection = new PDO($dsn, $db_user, $db_password);
$id_form = $_POST["id_formulaire"];
$sql2 = "SELECT * FROM formulaire WHERE id=:id;";
$statement = $connection->prepare($sql2);
$statement->bindValue(":id", $id_form);
$statement->execute();
$data = $statement->fetchAll();

// Create new PDF instance
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('PDF Solved Request for Intervention');
$pdf->SetSubject('PDF Subject');
$pdf->SetKeywords('PDF, Data, Example');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();

// Add title
$pdf->SetFont($titleStyle['font'], $titleStyle['style'], $titleStyle['size']);
$pdf->SetTextColor(...$titleStyle['color']);
$pdf->Cell(0, 10, 'Form Data', 0, 1, 'C');

// Reset font and color
$pdf->SetFont($normalStyle['font'], $normalStyle['style'], $normalStyle['size']);
$pdf->SetTextColor(...$normalStyle['color']);

// Loop through data and add it to the PDF with styling
// Loop through data and add it to the PDF with styling
foreach ($data as $row) {
    $pdf->Write(0, 'Number: ' . $row['number_of_formulaire'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    $pdf->Write(0, 'Type of Intervention: ' . $row['type_intervention'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    $pdf->Write(0, 'Date/Hour(Agent): ' . $row['date_agent'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    $pdf->Write(0, 'REF: ' . $row['ref'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    // Add styling to the fields below similarly
    $pdf->Write(0, 'Type of Preventive: ' . $row['type_preventive'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    $pdf->Write(0, 'Levels of Danger: ' . $row['levels_danger'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    $pdf->Write(0, 'Type of Problem: ' . $row['type_probleme'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    $pdf->Write(0, 'Subsidiary: ' . $row['subsidiary'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    $pdf->Write(0, 'Line: ' . $row['line'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    $pdf->Write(0, 'Equipment: ' . $row['equipment'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    $pdf->Write(0, 'First Name of Maintenance Director: ' . $row['name_maintenance_director'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    $pdf->Write(0, 'Date/Hour(Maintenance): ' . $row['date_maintenance'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    $pdf->Write(0, 'First Name of Production Director: ' . $row['name_production_director'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    $pdf->Write(0, 'Date/Hour(Production): ' . $row['date_production'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    $pdf->Write(0, 'Name of Department Boss: ' . $row['name_Equipe'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    $pdf->Write(0, 'Date Solve the Problem: ' . $row['date_end'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    $pdf->Write(0, 'Brief About the Machine Problem:', '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    
    $pdf->Write(0, 'Mechanical: ' . $row['summary_Mechanical'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    if (isset($row['summary_Electric'])) {
        $pdf->Write(0, 'Electric: ' . $row['summary_Electric'], '', 0, 'L', true, 0, false, false, 0);
        $pdf->Ln();
    }else{
        $pdf->Write(0, 'Electric: ' . "/", '', 0, 'L', true, 0, false, false, 0);
        $pdf->Ln();
    }
    
    $pdf->Write(0, 'Hydraulic: ' . $row['summary_Hydraulic'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();

    $pdf->Write(0, 'Informatique: ' . $row['summary_Informatique'], '', 0, 'L', true, 0, false, false, 0);
    $pdf->Ln();
}


// Close and output PDF
$pdf->Output('archive'.$row["number_of_formulaire"].'.pdf', 'D');
?>
