<?php

namespace App\Http\Controllers;

use App\Imports\ImportMCQ;
use App\Imports\MCQImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AppController extends Controller
{
    public function import()
    {
        return view('import');
    }

    public function submitImport(Request $request)
    {
        $validation = Validator::make($request->all(),
            [
                'file' => 'required|mimes:xlsx,xls'
            ],
            [
                'file.required' => 'Please select a file to import',
                'file.mimes' => 'Import file should be valid excel file.'
            ]);
        if ($validation->fails()) {
            return back()->with('errors', $validation->getMessageBag()->toArray());
        }

        try {
            $importFile = $request->file('file');
            $result = Excel::import(new ImportMCQ, $importFile);

            return back()->with('success', 'Data Imported Successfully.');
        } catch(\Maatwebsite\Excel\Validators\ValidationException $e){
            $failures = $e->failures();
            $errors = [];
//            dd("Failures...", $failures);

            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
                $errors[] = $failure->errors();
            }
            return back()->with('errors', $errors);
        } catch (\Exception $ex) {
            dd("Error...",$ex->getMessage());
        }
//        $importFile = $request->file('file');
//        //$result = Excel::import(new ImportMCQ, $importFile);
//        $mcqImport = new ImportMCQ();
//        $result = Excel::import($mcqImport, $importFile);
//        dd($result);
//
//        return back()->with('success', 'Data Imported Successfully.');
    }
}
