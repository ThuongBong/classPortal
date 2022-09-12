<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Models\Assignment;
use App\Models\Subject;
use App\Models\Result;
use App\Http\Requests\Student\AnswerAssignmentRequest;

class AssignmentController extends Controller
{
    public function __construct()
    {
        view()->share([]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $userId = Auth::user()->id;
        $classIds = \DB::table('classes_users')->where('user_id', $userId)->pluck('class_id');
        $subjectIds = \DB::table('classes_subjects')->whereIn('class_id', $classIds)->pluck('subject_id');
        $assignments = Assignment::with('subject')->whereIn('subject_id', $subjectIds)->orderByDesc('id')->paginate(NUMBER_PAGINATION);
        return view('pages.student.assignment.index', compact('assignments'));
    }

    public function detail($id)
    {
        $assignment = Assignment::find($id);

        if (!$assignment) {
            return redirect()->back()->with('error', 'Data does not exist');
        }

        $userId = Auth::user()->id;
        $result = Result::where(['user_id' => $userId, 'assignment_id' => $id])->first();

        return view('pages.student.assignment.details', compact('assignment', 'result'));
    }

    public function answer(AnswerAssignmentRequest $request, $id)
    {
        $userId = Auth::user()->id;
        $result = Result::where(['user_id' => $userId, 'assignment_id' => $id])->first();
        $assignment = Assignment::find($id);

        \DB::beginTransaction();
        try {
            if (!$result) {
                $result = new Result();
            }
            $result->assignment_id = $id;
            $result->user_id = $userId;
            $result->subject_id = $assignment->subject_id;
            $result->description = $request->description;

            if($request->hasfile('source'))
            {
                $file = $request->file('source');
                $source = date('YmdHms'). $userId .'_assignment_'.$id. '_subject_'.$assignment->subject_id .$file->getClientOriginalName();
                $file->move(public_path().'/uploads/answers/', $source);
                $result->source = $source;
            }

            $result->save();

            \DB::commit();
            return redirect()->back()->with('success', 'Answer is successful');
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while saving data');
        }
    }

}
