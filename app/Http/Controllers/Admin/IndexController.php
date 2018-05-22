<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        return view("admin.index");
        /*
        $pdf = resolve("MPDF");
        $pdf->WriteHtml("<p>hello <b>world</b><small>sma你好ll</small></p>");
        $pdf->SetTitle("测试文档");
        $pdf->Output("t.pdf", \Mpdf\Output\Destination::INLINE);
        */
    }
}
