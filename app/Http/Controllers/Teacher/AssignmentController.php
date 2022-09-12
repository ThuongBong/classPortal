<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Models\Assignment;
use App\Models\Subject;
use App\Models\Classes;
use App\Models\Result;
use App\Http\Requests\Teacher\AssignmentRequest;


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
        $assignments = Assignment::with('subject')->where('teacher_id', $userId)->orderByDesc('id')->paginate(NUMBER_PAGINATION);
        return view('pages.teacher.assignment.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $userId = Auth::user()->id;
        $classIds = \DB::table('classes_users')->where('user_id', $userId)->pluck('class_id');
        $class = Classes::whereIn('id', $classIds)->get();
        $subjectIds = \DB::table('classes_subjects');
        $classId = $request->class_id;

        if ($classId) {
            $subjectIds = $subjectIds->where('class_id', $request->class_id);
        } else {
            $subjectIds = $subjectIds->whereIn('class_id', $classIds);
        }
        $subjectIds = $subjectIds->pluck('subject_id');

        $subjects = Subject::whereIn('id', $subjectIds)->get();

        return view('pages.teacher.assignment.create', compact('class', 'subjects', 'classId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssignmentRequest $request)
    {
        //
        $userId = Auth::user()->id;
        \DB::beginTransaction();
        try {
            $data = $request->except('_token', 'submit');
            $data['teacher_id'] = Auth::user()->id;

            if($request->hasfile('source'))
            {
                $file = $request->file('source');
                $data['source'] = date('YmdHms'). $userId .$file->getClientOriginalName();
                $file->move(public_path().'/uploads/assignments/', $data['source']);

            }

            Assignment::create($data);
            \DB::commit();
            return redirect()->route('class.detail', $data['class_id'])->with('success', 'Successfully added new');
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while saving data');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        $assignment = Assignment::findOrFail($id);

        $userId = Auth::user()->id;
        $classIds = \DB::table('classes_users')->where('user_id', $userId)->pluck('class_id');
        $class = Classes::whereIn('id', $classIds)->get();
        $subjectIds = \DB::table('classes_subjects');
        $classId = $assignment->class_id;

        if ($classId) {
            $subjectIds = $subjectIds->where('class_id', $classId);
        } else {
            $subjectIds = $subjectIds->whereIn('class_id', $classIds);
        }
        $subjectIds = $subjectIds->pluck('subject_id');

        $subjects = Subject::whereIn('id', $subjectIds)->get();

        if (!$assignment) {
            return redirect()->back()->with('error', 'Data does not exist');
        }

        return view('pages.teacher.assignment.edit', compact('assignment', 'class', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssignmentRequest $request, $id)
    {
        //
        $userId = Auth::user()->id;

        \DB::beginTransaction();
        try {
            $data = $request->except('_token', 'submit');

            $data['teacher_id'] = Auth::user()->id;

            if($request->hasfile('source'))
            {
                $file = $request->file('source');
                $data['source'] = date('YmdHms'). $userId .$file->getClientOriginalName();
                $file->move(public_path().'/uploads/assignments/', $data['source']);

            }

            $assignment = Assignment::find($id);

            if (!$assignment) {
                return redirect()->back()->with('error', 'Data does not exist');
            }
            $assignment->update($data);
            \DB::commit();
            return redirect()->route('class.detail', $data['class_id'])->with('success', 'Editing is successful');
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while saving data');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $assignment = Assignment::find($id);
        if (!$assignment) {
            return redirect()->back()->with('error', 'Data does not exist');
        }

        try {
            $assignment->delete();
            return redirect()->back()->with('success', 'Delete successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'There was an error that could not be deleted');
        }
    }

    public function getsSubjectByClass(Request $request)
    {
        if ($request->ajax() && !empty($request->class_id)) {
            $classId = $request->class_id;
            $subjectIds = \DB::table('classes_subjects')->where('class_id', $classId)->pluck('subject_id');
            $subjects = Subject::whereIn('id', $subjectIds)->get();

            $html =  view('pages.teacher.assignment.option_subject', compact('subjects'))->render();

            return response([
                'html' => $html
            ]);
        }
    }

    public function answers($id)
    {
        $assignment = Assignment::find($id);
        if (!$assignment) {
            return redirect()->back()->with('error', 'Data does not exist');
        }

        $results = Result::with('user')->where('assignment_id', $id)->get();

        return view('pages.teacher.assignment.answer', compact('assignment', 'results'));
    }

    public function detailAnswer(Request $request, $id)
    {
        if ($request->ajax()) {

            $result = Result::with('user', 'assignment')->find($id);
            $html =  view('pages.teacher.assignment.detail-answer', compact('result'))->render();

            return response([
                'html' => $html
            ]);
        }
    }

    public function updateMark(Request $request, $id)
    {
        if ($request->ajax()) {

            $result = Result::find($id);
            if (!$result) {
                return response([
                    'code' => 404
                ]);
            }
            $result->mark = $request->mark;

            if ($result->save()) {
                return response([
                    'code' => 200,
                    'mark' => $result->mark,
                    'result_id' => $result->id
                ]);
            }

            return response([
                'code' => 404
            ]);
        }
    }
}
