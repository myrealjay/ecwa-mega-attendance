<?php

namespace App\Http\Controllers;

use App\Classes\FileHandler;
use App\Http\Requests\ProgramRequest;
use App\Models\Program;
use App\Traits\HasResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    use HasResponse;

    /**
     * fetch programs.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $length = $request->length ?? 10;
        return $this->successResponse(
            'Program fetched successfully',
            Program::paginate($length)
        );
    }

    /**
     * fetch programs.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        return $this->successResponse(
            'Program fetched successfully',
            Program::all()
        );
    }

    /**
     * Upload a program.
     *
     * @param ProgramRequest $request
     * @return JsonResponse
     */
    public function store(ProgramRequest $request) : JsonResponse
    {
        $handler = new FileHandler();

        $picture = $request->file('picture');
        $fileName = $picture->getClientOriginalName();
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = $handler->getFileName().'.'.$extension;
        $picture = $handler->upload('images', $newFileName, $picture, 'local');

        $program = new Program();
        $program->url  = $picture;
        $program->file_name = $fileName;
        $program->save();

        return $this->successResponse('Program succesfully uploaded', $program);
    }

    /**
     * Delete program.
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function delete(int $id) : JsonResponse
    {
        $program = Program::findOrFail($id);

        $program->delete();

        return $this->successResponse('Program deleted successully', []);
    }
}
