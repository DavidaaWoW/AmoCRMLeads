<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function getCompany(Request $request){
        return view('company', ['company' => Company::where('id', '=', $request->id)->get()->first()]);
    }
}
