<?php

namespace App\Http\Services\Export;

use PDF;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ExportService
{
    public function exportPdf($data)
    {
        $paperSize = $this->paperSize($data['paperSize']);

        $pdf = PDF::loadView($data['view'], $data)
            ->setPaper($paperSize, $data['orientation']);

        // Save PDF to storage
        // if ($data['enskripsi'] == 1) {
        //     $filename = md5(time() . str_replace(' ', '_', strtolower($data['fileName'])) . Str::random(20));
        // } else {
        //     $filename = str_replace(' ', '_', strtolower($data['fileName']));
        // }
        // $pdfPath = $data['filePath'] . $filename  . '.pdf';
        // Storage::disk('public')->put($pdfPath, $pdf->output());

        return $pdf;
    }

    public function paperSize($paperSize)
    {
        if ($paperSize == 'A0') {
            $paperSize = [0, 0, 2382.7, 3367.6];
        } elseif ($paperSize == 'A1') {
            $paperSize = [0, 0, 1683.8, 2382.7];
        } elseif ($paperSize == 'A2') {
            $paperSize = [0, 0, 1190.7, 1683.8];
        } elseif ($paperSize == 'A3') {
            $paperSize = [0, 0, 841.9, 1190.7];
        } elseif ($paperSize == 'A4') {
            $paperSize = 'a4';
        } elseif ($paperSize == 'A5') {
            $paperSize = [0, 0, 419.5, 595.3];
        } elseif ($paperSize == 'A6') {
            $paperSize = [0, 0, 297.7, 419.5];
        } elseif ($paperSize == 'A7') {
            $paperSize = [0, 0, 209.7, 297.7];
        } elseif ($paperSize == 'A8') {
            $paperSize = [0, 0, 147.1, 209.7];
        } elseif ($paperSize == 'A9') {
            $paperSize = [0, 0, 104.8, 147.1];
        } elseif ($paperSize == 'A10') {
            $paperSize = [0, 0, 73.6, 104.8];
        } elseif ($paperSize == 'C4') {
            $paperSize = [0, 0, 649.1, 918.3];
        } elseif ($paperSize == 'C5') {
            $paperSize = [0, 0, 459.2, 649.1];
        } elseif ($paperSize == 'C6') {
            $paperSize = [0, 0, 323.0, 459.2];
        } elseif ($paperSize == 'C7') {
            $paperSize = [0, 0, 229.6, 323.0];
        } elseif ($paperSize == 'Letter') {
            $paperSize = [0, 0, 612.2, 790.3];
        } elseif ($paperSize == 'F4') {
            $paperSize = [0, 0, 595.3, 934.8];
        } else {
            $paperSize = 'a4'; // Default to A4
        }

        return $paperSize;
    }
}
