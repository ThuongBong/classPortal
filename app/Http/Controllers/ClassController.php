<?php

namespace App\Http\Controllers;

use App\Models\Classes_Subject;
use App\Models\Classes_User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Classes;
use App\Models\User;
use App\Models\Assignment;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    /**
     * Specify the middleware for this controller
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    //* Show details about a particular subjects - GET

    public function show($id)
    {
        $class = Classes::find($id);
        $subjects = Subject::all();

        $classes = DB::table('classes_subjects')
            ->where('class_id', $id)
            ->join('subjects', function ($join) {
                $join->on('classes_subjects.subject_id', '=', 'subjects.id');
            })
            ->get();
        $users = DB::table('classes_users')
            ->where('class_id', $id)
            ->join('users', function ($join) {
                $join->on('classes_users.user_id', '=', 'users.id');
            })
            ->where("users.role", '=', "student")
            ->get();
//        dd($users);
//        $user_teacher = DB::table('classes_users')
//            ->where('class_id', $id)
//            ->join('users', function ($join) {
//                $join->on('classes_users.user_id', '=', 'users.id');
//            })
//            ->where("users.role", '=', "teacher")
//            ->get();
////        dd($users);
        $instructor = Auth::user();

        // Grab all the recent activity, which includes
        // assignments and annoucement, then sort date that
        // it was created
        $recent_activity = array();
        $userId = $instructor->id;
        $assignments = Assignment::with('subject')->where(['teacher_id' => $userId, 'class_id' => $id])->orderByDesc('id')->paginate(NUMBER_PAGINATION);

        return view('pages.teacher.class.show', [
            'class1' => $class,
            'instructor' => $instructor,
            'class_id' => $id,
            'classes' => $classes,
            'users' => $users,
//            'user_teacher'=>$user_teacher,
            'subjects' => $subjects,
            'assignments' => $assignments,
            'recent_activity' => $recent_activity
        ]);
    }

    /**
     * Show a form to create a new class - GET
     */
    public function create()
    {
        return view('pages.teacher.class.create');
    }

    /**
     * Save a newly created class - POST
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'title' => 'string|max:255|nullable',   // Roadmap To Computing
            'room' => 'numeric|digits_between:2,5|nullable', // 01
            'section' => 'numeric|digits_between:2,5|nullable' // 01
        ]);

        $user_id = Auth::user()->id;

        $class = new Classes;
        $classes = new Classes_User();
        $class->name = $request->input('name');
        $class->title = $request->input('title');
        $class->room = $request->input('room');
        $class->section = $request->input('section');
        $class->class_code = base64_encode("class_".$class->id.time());

        if ($class->save()) {
            // Insert information into the pivot table for users and classes
            $classes->user_id = $user_id;
            $classes->class_id = $class->id;
            $classes->save();
            return redirect('/class/create')->with('status', 'Class added successfully!');
        }
    }

    /**
     * Update the class' information [PUT]
     */
    public function update(Classes $class, Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'title' => 'string|max:255|nullable',   // Roadmap To Computing
            'room' => 'numeric|digits_between:2,5|nullable', // 01
            'section' => 'numeric|digits_between:2,5|nullable' // 01
        ]);

        $class = Classes::find($id);
        $class->name = $request->input('name');
        $class->title = $request->input('title');
        $class->room = $request->input('room');
        $class->section = $request->input('section');

        if ($class->save()) {
            return redirect('/class/' . $id)->with('status', 'Class updated successfully!');
        }
    }

    public function saveSubject(Request $request)
    {
        $class_subject = new Classes_Subject();
        // Insert information into the pivot table for users and classes
        $class_subject->class_id = $request->input('class_id');
        $class_subject->subject_id = $request->input('subjects');
        $class_subject->save();
        return back()->with('status', 'Class added successfully!');

    }

    public function saveNewSubject(Request $request){

        \DB::beginTransaction();
        try {
            $subject = new Subject();
            $subject->name = $request->name;
            $subject->description = $request->description;
            if ($subject->save()) {
                $class_subject =  new Classes_Subject();
                $class_subject->class_id = $request->class_id;
                $class_subject->subject_id = $subject->id;
                $class_subject->save();
            }
            DB::commit();
            return redirect()->back()->with('success', 'Successfully added new');
        } catch (\Exception $exception) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred while saving data');
        }
    }

    /**
     * Delete a particular class - DELETE
     */
    public function destroy(Classes $class, $id)
    {
        if (Classes::destroy($id)) {
            return redirect('/home')->with('status', 'Class deleted successfully!');
        }
    }

    public function addStudents(Request $request, $class_id)
    {
        foreach ($request->except(['_token']) as $student_id) {
            Classes::find($class_id)->users()->attach($student_id);
        }

        return redirect('/class/' . $class_id)->with('status', 'Students added to the class successfully!');
    }

    public function urlLink(){
        $user_id = Auth::user()->id;
    }
}
