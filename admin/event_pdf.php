<?php
require_once ('tcpdf/tcpdf.php');

class MYPDF extends TCPDF
{
     // Page header
     public function Header() {
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
        $this->Cell(0, 2, "Generated on: $currentDateTime", 0, 1, 'R',false,"",0,false,'T','M');

        $filter = "Filter: ";
        if(isset($_POST["start"],$_POST["end"]) && $_POST["start"]!="" && $_POST["end"]!=""){
            $filter .= "From - ".date("d-m-Y",strtotime($_POST["start"]))." to - ".date("d-m-Y",strtotime($_POST["end"]));
        }else{
            $filter .= "All Events";
        }
        // Additional subheading for filters or other information
        $this->Cell(0, 2,$filter, 0, 1, 'R',false,"",0,false,'T','B'); // Example filter text

        // Set font for the main header
        $this->SetFont('helvetica', 'B', 20);

        // Set header text color to purple
        $this->SetTextColor(128, 0, 128); // Purple color (R, G, B)

        // Center align the header text
        $this->Cell(0, 2, 'Event Reports', 0, 1, 'C' ,false,"",0,false,'B','M');

        // Set header underline color to purple
        $this->SetDrawColor(128, 0, 128); // Purple color (R, G, B)
        
        // Set line thickness
        $this->SetLineWidth(1);

        // Draw a thick purple line to separate the header
        $this->Line(5, 25, 287, 25); // Line parameters: x1, y1, x2, y2
    }

}

if (isset($_POST['evhtml'])) {
    $html = $_POST['evhtml'];

    // Create new PDF document
    $pdf = new MYPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Alumni Portal');
    $pdf->SetTitle('Event Report');
    $pdf->SetSubject('Event Details');

    // Set margins
    $pdf->SetMargins(10, 40, 10); // Top margin adjusted for the logo and header
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(10);

    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 10);

    // Set font
    $pdf->SetFont('dejavusans', '', 8);

    // Add a page
    $pdf->AddPage();

    // Print HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the PDF
    $filePath = __DIR__ . '/Event Report.pdf';
    $pdf->Output($filePath, 'F');

    // Return the file path to the client
    echo json_encode(array("status" => "success", "filePath" => basename($filePath)));
} else {
    echo json_encode(array("status" => "error", "message" => "No table HTML received."));
}
?>