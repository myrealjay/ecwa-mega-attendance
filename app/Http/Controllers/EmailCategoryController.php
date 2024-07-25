<?php

namespace App\Http\Controllers;

use App\Models\EmailCategory;
use App\Traits\HasResponse;
use Illuminate\Http\Request;

class EmailCategoryController extends Controller
{
    use HasResponse;

    public function index(Request $request)
    {
        return $this->successResponse(
            'Email templates fetched successfully', 
            EmailCategory::select('id', 'name')->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string']
        ]);

        $category = EmailCategory::updateOrCreate(['name' => $request->name]);

        return $this->successResponse('Category created successfully', $category);
    }
}
