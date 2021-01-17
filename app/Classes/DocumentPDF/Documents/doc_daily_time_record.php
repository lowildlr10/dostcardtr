<?php

/* ------------------------------------- Start of Config ------------------------------------- */

//set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//Set margins
$pdf->SetMargins(7, 10, 7);
$pdf->SetHeaderMargin(10);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

//Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 10);

//Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//Set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

//Set default font subsetting mode
$pdf->setFontSubsetting(true);

/* ------------------------------------- End of Config ------------------------------------- */

//Add a page
$pdf->AddPage();

/* ------------------------------------- Start of Doc ------------------------------------- */
$pdf->Line(105, 0, 105, 297);

//Title
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(91, 5, 'DAILY TIME RECORD', '0', '', 'C');
$pdf->Cell(14, 5, '', '0', '', 'C'); //Center margin
$pdf->Cell(91, 5, 'DAILY TIME RECORD', '0', '', 'C');
$pdf->Ln(10);

$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(13, 5, '', '0', '', 'L');
$pdf->Cell(10, 5, 'Name:', '0', '', 'L');
$pdf->Cell(3, 5, '', '0', '', 'L');
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->Cell(65, 5, $empName, 'B', '', 'L');
$pdf->Cell(14, 5, '', '0', '', 'C'); //Center margin
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(13, 5, '', '0', '', 'L');
$pdf->Cell(10, 5, 'Name:', '0', '', 'L');
$pdf->Cell(3, 5, '', '0', '', 'L');
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->Cell(65, 5, $empName, 'B', '', 'L');
$pdf->Ln(10);

$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(26, 5, 'For the month of', '0', '', 'L');
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->Cell(65, 5, $fDateRange, 'B', '', 'L');
$pdf->Cell(14, 5, '', '0', '', 'C'); //Center margin
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(26, 5, 'For the month of', '0', '', 'L');
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->Cell(65, 5, $fDateRange, 'B', '', 'L');
$pdf->Ln(7);

$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(53, 4, 'Official hours for arrival and departure', '0', '', 'L');
$pdf->Cell(38, 4, '', 'B', '', 'R');
$pdf->Cell(14, 5, '', '0', '', 'C'); //Center margin
$pdf->Cell(53, 4, 'Official hours for arrival and departure', '0', '', 'L');
$pdf->Cell(38, 4, '', 'B', '', 'R');
$pdf->Ln(8);

// Table header
$pdf->SetFillColor(127); //Set to Gray
$pdf->Cell(13, 5, 'Day', '1', '', 'C', 1);
$pdf->Cell(26, 5, 'AM', '1', '', 'C', 1);
$pdf->Cell(26, 5, 'PM', '1', '', 'C', 1);
$pdf->Cell(26, 5, 'Undertime', '1', '', 'C', 1);
$pdf->Cell(14, 5, '', '0', '', 'C'); //Center margin
$pdf->Cell(13, 5, 'Day', '1', '', 'C', 1);
$pdf->Cell(26, 5, 'AM', '1', '', 'C', 1);
$pdf->Cell(26, 5, 'PM', '1', '', 'C', 1);
$pdf->Cell(26, 5, 'Undertime', '1', '', 'C', 1);
$pdf->Ln();

$pdf->Cell(13, 5, '', '1', '', 'C', 1);
$pdf->Cell(13, 5, 'Arr', '1', '', 'C', 1);
$pdf->Cell(13, 5, 'Dep', '1', '', 'C', 1);
$pdf->Cell(13, 5, 'Arr', '1', '', 'C', 1);
$pdf->Cell(13, 5, 'Dep', '1', '', 'C', 1);
$pdf->Cell(13, 5, 'Hrs', '1', '', 'C', 1);
$pdf->Cell(13, 5, 'Min', '1', '', 'C', 1);
$pdf->Cell(14, 5, '', '0', '', 'C'); //Center margin
$pdf->Cell(13, 5, '', '1', '', 'C', 1);
$pdf->Cell(13, 5, 'Arr', '1', '', 'C', 1);
$pdf->Cell(13, 5, 'Dep', '1', '', 'C', 1);
$pdf->Cell(13, 5, 'Arr', '1', '', 'C', 1);
$pdf->Cell(13, 5, 'Dep', '1', '', 'C', 1);
$pdf->Cell(13, 5, 'Hrs', '1', '', 'C', 1);
$pdf->Cell(13, 5, 'Min', '1', '', 'C', 1);
$pdf->Ln();

$pdf->SetFillColor(255); //Revert back to White

foreach ($monthListDate as $key => $date) {
    $dtDate = new DateTime($date);
    $index = $dtDate->format('j');
    $currentDay++;

    $timeInAM = "";
    $timeOutAM = "";
    $timeInPM = "";
    $timeOutPM = "";
    $remarks = "";

    $hasRecord = false;

    foreach ($data->dtr as $dtr) {
        if ($date == $dtr->date_log) {
            $timeInAM = !empty($dtr->time_in_am) ? strtotime($dtr->time_in_am) : '';
            $timeOutAM = !empty($dtr->time_out_am) ? strtotime($dtr->time_out_am) : '';
            $timeInPM = !empty($dtr->time_in_pm) ? strtotime($dtr->time_in_pm) : '';
            $timeOutPM = !empty($dtr->time_out_pm) ? strtotime($dtr->time_out_pm) : '';

            $timeInAM = !empty($timeInAM) ? date('g:i', $timeInAM) : '';
            $timeOutAM = !empty($timeOutAM) ? date('g:i', $timeOutAM) : '';
            $timeInPM = !empty($timeInPM) ? date('g:i', $timeInPM) : '';
            $timeOutPM = !empty($timeOutPM) ? date('g:i', $timeOutPM) : '';

            $remarks = strtoupper($dtr->remarks);
            $hasRecord = true;
            break;
        }
    }

    if ($hasRecord) {
        $pdf->Cell(13, 5, $index, '1', '', 'C');
        $pdf->Cell(13, 5, $timeInAM, '1', '', 'C');
        $pdf->Cell(13, 5, $timeOutAM, '1', '', 'C');
        $pdf->Cell(13, 5, $timeInPM, '1', '', 'C');
        $pdf->Cell(13, 5, $timeOutPM, '1', '', 'C');
        $pdf->Cell(13, 5, '', '1', '', 'C');
        $pdf->Cell(13, 5, '', '1', '', 'C');
        $pdf->Cell(14, 5, '', '0', '', 'C'); //Center margin
        $pdf->Cell(13, 5, $index, '1', '', 'C');
        $pdf->Cell(13, 5, $timeInAM, '1', '', 'C');
        $pdf->Cell(13, 5, $timeOutAM, '1', '', 'C');
        $pdf->Cell(13, 5, $timeInPM, '1', '', 'C');
        $pdf->Cell(13, 5, $timeOutPM, '1', '', 'C');
        $pdf->Cell(13, 5, '', '1', '', 'C');
        $pdf->Cell(13, 5, '', '1', '', 'C');
    } else {
        $textualDay = strtoupper($dtDate->format('l'));

        if ($textualDay == 'SATURDAY' || $textualDay == 'SUNDAY') {
            $pdf->Cell(13, 5, $index, '1', '', 'C');
            $pdf->SetFont('Helvetica', 'B', 8);
            $pdf->Cell(78, 5, $textualDay, '1', '', 'C');
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->Cell(14, 5, '', '0', '', 'C'); //Center margin
            $pdf->Cell(13, 5, $index, '1', '', 'C');
            $pdf->SetFont('Helvetica', 'B', 8);
            $pdf->Cell(78, 5, $textualDay, '1', '', 'C');
            $pdf->SetFont('Helvetica', '', 8);
        } else {
            $pdf->Cell(13, 5, $index, '1', '', 'C');
            $pdf->Cell(13, 5, '', '1', '', 'C');
            $pdf->Cell(13, 5, '', '1', '', 'C');
            $pdf->Cell(13, 5, '', '1', '', 'C');
            $pdf->Cell(13, 5, '', '1', '', 'C');
            $pdf->Cell(13, 5, '', '1', '', 'C');
            $pdf->Cell(13, 5, '', '1', '', 'C');
            $pdf->Cell(14, 5, '', '0', '', 'C'); //Center margin
            $pdf->Cell(13, 5, $index, '1', '', 'C');
            $pdf->Cell(13, 5, '', '1', '', 'C');
            $pdf->Cell(13, 5, '', '1', '', 'C');
            $pdf->Cell(13, 5, '', '1', '', 'C');
            $pdf->Cell(13, 5, '', '1', '', 'C');

            if (empty($remarks)) {
                $pdf->Cell(13, 5, '', '1', '', 'C');
                $pdf->Cell(13, 5, '', '1', '', 'C');
            } else {
                $pdf->SetFont('Helvetica', 'B', 8);
                $pdf->Cell(26, 5, $remarks, '1', '', 'C');
                $pdf->SetFont('Helvetica', '', 8);
            }
        }
    }

    $pdf->Ln();
}

$pdf->Cell(52, 5, '', '0', '', 'C');
$pdf->Cell(39, 5, 'TOTAL', '0', '', 'L');
$pdf->Cell(14, 5, '', '0', '', 'C'); //Center margin
$pdf->Cell(52, 5, '', '0', '', 'C');
$pdf->Cell(39, 5, 'TOTAL', '0', '', 'L');
$pdf->Ln(10);

$pdf->SetFont('Helvetica', '', 9);
$pdf->MultiCell(91, 5, 'I CERTIFY on my honor that the above is a true and '.
                        'correct report of the hours of work performed, record of '.
                        'which is made daily at the time of arrival and departure '.
                        'from office.', 0, 'J', 1, 0);
$pdf->MultiCell(14, 5, '', 0, 'J', 1, 0);
$pdf->MultiCell(91, 5, 'I CERTIFY on my honor that the above is a true and '.
                        'correct report of the hours of work performed, record of '.
                        'which is made daily at the time of arrival and departure '.
                        'from office.', 0, 'J', 1, 1);
$pdf->Ln(8);

$pdf->Cell(13, 5, '', '0', '', 'C');
$pdf->Cell(65, 5, '', 'B', '', 'C');
$pdf->Cell(13, 5, '', '0', '', 'C');
$pdf->Cell(14, 5, '', '0', '', 'C'); //Center margin
$pdf->Cell(13, 5, '', '0', '', 'C');
$pdf->Cell(65, 5, '', 'B', '', 'C');
$pdf->Cell(13, 5, '', '0', '', 'C');
$pdf->Ln();

$pdf->SetFont('Helvetica', 'B', 9);
$pdf->Cell(91, 5.6, 'Employee Signature', 'B', '', 'C');
$pdf->Cell(14, 5, '', '0', '', 'C'); //Center margin
$pdf->Cell(91, 5.6, 'Employee Signature', 'B', '', 'C');
$pdf->Ln(5);

$pdf->SetFont('Helvetica', '', 9);
$pdf->Cell(91, 5.4, '(VERIFIED AS PRESCRIBED OFFICE HOURS)', 'T', '', 'C');
$pdf->Cell(14, 5, '', '0', '', 'C'); //Center margin
$pdf->Cell(91, 5.4, '(VERIFIED AS PRESCRIBED OFFICE HOURS)', 'T', '', 'C');
$pdf->Ln(15);

$pdf->SetFont('Helvetica', 'B', 9);
$pdf->Cell(26, 5, '', '0', '', 'C');
$pdf->Cell(65, 5, $immediateSup, 'B', '', 'C');
$pdf->Cell(14, 5, '', '0', '', 'C'); //Center margin
$pdf->Cell(26, 5, '', '0', '', 'C');
$pdf->Cell(65, 5, $immediateSup, 'B', '', 'C');
$pdf->Ln();

$pdf->Cell(26, 5, '', '0', '', 'C');
$pdf->Cell(65, 5, 'Immediate Supervisor', '', '', 'C');
$pdf->Cell(14, 5, '', '0', '', 'C'); //Center margin
$pdf->Cell(26, 5, '', '0', '', 'C');
$pdf->Cell(0, 5, 'Immediate Supervisor', '', '', 'C');

/* ------------------------------------- End of Doc ------------------------------------- */
