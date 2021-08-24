<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $error_tampil = [];

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
            ], 302);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            try {
                $import = Excel::import(new SiswaImport, $file);

                return response()->json([
                    'message' => 'Siswa Kelas successfully imported',
                    'status' => true,
                    'data' => []
                ], 200);
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                $failures = $e->failures();

                foreach ($failures as $failure) {
                    $error_tampil[] = [
                        'error' => '' . $failure->errors()[0] . 'pada baris ke-' . $failure->row() . ''
                    ];
                }

                return response()->json([
                    'message' => $error_tampil
                ], 302);
            }
        }
    }
}
