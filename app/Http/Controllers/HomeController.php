<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function pdf()
    {
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $pdf = new \Mpdf\Mpdf([
            "fontDir" => array_merge($fontDirs, [
                public_path("storage/fonts/")
            ]),
            "fontdata" => $fontData + [
                "msyh" => [
                    "R" => "msyh.ttf",
                ],
                "msyhbd" => [
                    "R" => "msyhbd.ttf",
                ],
            ],
            "default_font" => "msyh",
        ]);
        $pdf->WriteHTML('<small>你</small><p>好</p> <button>world</button><code>world!</code>');
        $pdf->Output();
    }
}
