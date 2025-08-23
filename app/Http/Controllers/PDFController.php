<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PDF\PDFKardexDocAlm;

class PDFController extends Controller
{
    public function kardexDocAlmacen(Request $request) {
        try {
            $pdf = new PDFKardexDocAlm;
            $pdf = $pdf->index($request);

            return $pdf;
        } catch (Exception $err) {
            return response()->json($err->getMessage(), $err->status);
        }
    }
}
