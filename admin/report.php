<?php
require_once ('tcpdf/tcpdf.php'); // Ensure you have installed TCPDF
class MYPDF extends TCPDF
{
    // Page header
    public function Header()
    {
        // Set the path for the logo image
        $image_file = 'logo.jpg'; // Adjust the path if needed

        // Check if the logo file exists
        if (file_exists($image_file)) {
            // Display the logo
            $this->Image($image_file, 5, 5, 40, 20, 'JPG', '', '', true, 100, '', false, false, 0, 'L', false, false, 0);
        } else {
            // Log an error if the image is not found
            error_log('Logo image not found: ' . $image_file);
        }
        $this->SetY(10);
        // Set font for the subheading (small, normal color)
        $this->SetFont('helvetica', '', 10);
        $this->SetTextColor(0, 0, 0); // Black color (R, G, B)
        date_default_timezone_set("Asia/Kolkata");
        // Current date and time
        $currentDateTime = date('d-m-Y h:i:s A');
        $this->Cell(0, 2, "Generated on: $currentDateTime", 0, 1, 'R', false, "", 0, false, 'T', 'M');

        $filter = "Filter: ";
        if(isset($_POST["course"],$_POST["start"],$_POST["end"]) && $_POST["course"]!="" && $_POST["start"]!= "" && $_POST["end"]!=""){
            $filter .= "Course: ".$_POST["course"].", From: ".$_POST["start"].", To: ".$_POST["end"];
        }
        // Additional subheading for filters or other information
        $this->Cell(0, 2, $filter, 0, 1, 'R', false, "", 0, false, 'T', 'B'); // Example filter text

        // Set font for the main header
        $this->SetFont('helvetica', 'B', 20);

        // Set header text color to purple
        $this->SetTextColor(128, 0, 128); // Purple color (R, G, B)

        // Center align the header text
        $this->Cell(0, 2, 'Alumni Report', 0, 1, 'C', false, "", 0, false, 'B', 'M');

        // Set header underline color to purple
        $this->SetDrawColor(128, 0, 128); // Purple color (R, G, B)

        // Set line thickness
        $this->SetLineWidth(1);

        // Draw a thick purple line to separate the header
        $this->Line(0, 25, 300, 25); // Line parameters: x1, y1, x2, y2
    }

}
if (isset($_POST['tableHTML'])) {
    // Store the table HTML in a PHP variable
    $tableHTML = $_POST['tableHTML'];

    // Create new PDF document
    $pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator("Admin");
    $pdf->SetAuthor("Admin");
    $pdf->SetTitle('Alumni Report');
    $pdf->SetSubject('Alumni');

    // Set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // Set margins
    $pdf->SetMargins(2, 40, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // Set image scale factor
    $pdf->setImageScale(1.57);

    // Set font
    $pdf->SetFont('dejavusans', '', 8);

    // Add a page
    $pdf->AddPage();

    // Convert HTML to PDF
    $html = '
    <html>
    <head>
       <style>
         table {
            border-collapse: collapse;
            width: 100%;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
            
   </style>
    </head>
    <body>' . $tableHTML . '</body>
    </html>';
    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the generated PDF to a file
    $filePath = __DIR__ . '/Alumni Report.pdf';
    $pdf->Output($filePath, 'F');

    // Return the file path to the client
    echo json_encode(array("status" => "success", "filePath" => basename($filePath)));
} else {
    echo json_encode(array("status" => "error", "message" => "No table HTML received."));
}
?>