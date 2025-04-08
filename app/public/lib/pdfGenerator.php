<?php
    require_once(__DIR__ . '/../vendor/setasign/fpdf/fpdf.php');
    require_once(__DIR__ . '/../vendor/autoload.php');

    function generateInvoicePDF($orderID, $userName, $orderDetails, $savePath) {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(0, 15, "Haarlem Festival - Invoice", 0, 1, 'C');
        
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(5);
        $pdf->Cell(0, 10, "Order #: $orderID", 0, 1);
        $pdf->Cell(0, 10, "Customer: $userName", 0, 1);
    
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(120, 10, "Description", 1);
        $pdf->Cell(50, 10, "Price (" . chr(128) . ")", 1);
        $pdf->Ln();
    
        $pdf->SetFont('Arial', '', 12);
        $total = 0;
        foreach ($orderDetails as $item) {
            $description = $item['description'];
            $price = number_format($item['price'], 2);
            $total += $item['price'];
    
            $pdf->Cell(120, 10, iconv('UTF-8', 'windows-1252//IGNORE', $description), 1);
            $pdf->Cell(50, 10, chr(128) . $price, 1, 0, 'R');
            $pdf->Ln();
        }
    
        $vatRate = 0.21;
        $vatAmount = $total * $vatRate;
        $totalWithVat = $total + $vatAmount;
    
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(120, 10, "Total (incl. 21% VAT):", 0);
        $pdf->Cell(50, 10, chr(128) . number_format($totalWithVat, 2), 0, 1, 'R');
    
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 11);
        $pdf->MultiCell(0, 8, iconv('UTF-8', 'windows-1252//IGNORE', "Thank you for booking with Haarlem Festival!\n\nThis invoice can be used as proof of payment. If you have any questions, contact us at support@haarlemfestival.nl."), 0, 'L');
    
        $pdf->Output('F', $savePath);
    }
    
?>
