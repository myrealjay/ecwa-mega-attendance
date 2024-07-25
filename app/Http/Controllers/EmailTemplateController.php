<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Traits\HasResponse;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    use HasResponse;

    public function index(Request $request)
    {
        $length = $request->length ?? 10;

        return $this->successResponse(
            'Email templates fetched successfully',
            EmailTemplate::with('category:id,name')->select('id', 'template', 'email_category_id')->paginate($length)
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'template' => ['required', 'string', 'max:3000'],
            'email_category_id' => ['required', 'integer', 'exists:email_categories,id']
        ]);

        $template = EmailTemplate::create([
            'template' => $request->template, 
            'email_category_id' => $request->email_category_id
        ]);

        return $this->successResponse('Template created successfully', $template);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'template' => ['required', 'string', 'max:3000'],
            'email_category_id' => ['required', 'integer', 'exists:email_categories,id']
        ]);

        $template = EmailTemplate::where('id', $id)->first();

        if (!$template) {
            return $this->notFoundResponse('No template found with ID');
        }
        
        $template->update(['template' => $request->template, 'email_category_id' => $request->email_category_id]);

        return $this->successResponse('Template updated successfully', $template);
    }

    public function delete($id) 
    {
        EmailTemplate::where('id', $id)->delete();
        return $this->successResponse('Email template deleted successfully', []);
    }
}
