<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::orderBy('region')->orderBy('name')->get();
        
        return view('branches.index', compact('branches'));
    }

    public function show(Branch $branch)
    {
        return view('branches.show', compact('branch'));
    }
}
