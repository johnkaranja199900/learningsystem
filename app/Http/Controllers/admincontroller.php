<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


use App\Models\admin;
use App\Models\User;
use App\Models\Course;
use App\Models\notes;
use App\Models\StudentResult;
use App\Models\MeetingLink;
use App\Models\Announcement;
use Illuminate\Http\Request;


class admincontroller extends Controller
{
    
        
    

        public function loginadmin()
        {
            return view('admin.loginadmin');
        }

        public function login(Request $request)
        {
             if (Auth::guard('admin')->check()) {
            if (time() - session('last_activity') > config('session.lifetime') * 60) {
                Auth::guard('admin')->logout();
                return redirect('/loginadmin')->with('message', 'Your session has expired. Please log in again.');
            }
        }

        // Proceed with the login attempt
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            // Update last activity time
            session(['last_activity' => time()]);

            return redirect()->route('summary');
        }

        return redirect()->route('loginadmin')->withErrors(['loginError' => 'Invalid credentials']);
    
        }

        public function logout()
        {
            Auth::guard('admin')->logout();
            return redirect('/');
        }

        
        public function insertData()
            {
                // Create an instance of the model
                $data = new admin();
        
                // Set values for the fields
                $data->username = 'johnkaranja2';
                $data->phone = '0725152865';
                $data->email = 'johnkaranja@gmail.com';
                $data->password = '36889063';
                // Save the data to the database
                $data->save();
        
                return "Data inserted successfully!";
            }
            
    public function adminview()
        {
        $admins = admin::all();
    return view('admin.addadmin', compact('admins'));
        }

    public function addadmin(Request $request)
        {
                
            $request->validate([
                'username' => 'required|string|max:255',
                'phone' => 'required|string|unique:admins',
                'email' => 'required|string|max:255',
                'password' => 'required|nullable|string|min:6',
                ]);
            
            admin::create([
                'username' => $request->input('username'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                ]);
                
            
            return redirect()->route('adminview')->with('success', 'admin added successfully');
        }


    public function adminupdate(Request $request, $id)
        {
            $request->validate([
                'username' => 'required|string|max:255',
                'phone' => 'required|string|unique:admins,phone,' . $id,
                'email' => 'required|string|max:255',
                'password' => 'nullable|string|min:6',
            ]);
            
            $admin = admin::findOrFail($id);
            $admin->update([
                'username' => $request->input('username'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'password' => $request->filled('password') ? Hash::make($request->input('password')) : $admin->password,
            ]);

            if ($request->filled('password')) {
                $admin->update([
                    'password' => Hash::make($request->input('password')),
                ]);
            }
            
            return redirect()->route('adminview')->with('success', 'Meeting link updated successfully');
        }
    public function destroyadmin($id)
        {
            $admin = admin::findOrFail($id);
            $admin->delete();
            
            return redirect()->route('adminview')->with('success', 'Meeting link deleted successfully');
        }


    public function staff(Request $request)
        {
            $search = $request->input('search');
            $maxFees = $request->input('max_fees');
            $sort = $request->input('sort', 'desc');

            
        // $students = User::all();
            $search = $request->input('search');
            $students = User::when($search, function ($query) use ($search) {
            $query->where('fname', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%')
                ->orWhere('gender', 'like', '%' . $search . '%')
                ->orWhere('unit', 'like', '%' . $search . '%')
                ->orWhere('fees', 'like', '%' . $search . '%');
                })
            ->when($maxFees, function ($query) use ($maxFees) {
                $query->where('paid', '<=', $maxFees);
            })
            ->orderBy('created_at', $sort)
            ->paginate(30);

            return view('admin.staff', compact('students','search'));
        }


    public function summary()
        {
            $totalStudents = User::count();
            $totalFees = User::sum('fees');
            $totalFeesPaid = User::sum('paid');
            $totalBalanceRemaining = $totalFees - $totalFeesPaid;
            $packages = User::where('unit', 'packages')->count();
            $cprogramming = User::where('unit', 'C programming')->count();
            $webdevelopment = User::where('unit', 'web development')->count();
            $python = User::where('unit', 'python programming')->count();
            $php = User::where('unit', 'php programming')->count();
            

            return view('admin.summary', compact(
                'totalStudents',
                'totalFees',
                'totalFeesPaid', 
                'totalBalanceRemaining',
                'packages',
                'cprogramming',
                'webdevelopment',
                'python',
                'php'
            ));
        }

    public function meetingpage()
        {
            //view anncouncement together with class links 
            $announcements = Announcement::latest()->get();
            $latestAnnouncement = $announcements->first();

            $meetingLinks = MeetingLink::all();
            
            return view('admin.meeting', compact('meetingLinks', 'latestAnnouncement'));
        }


    // create anncouncements
    public function addAnnouncement(Request $request)
        {
            $request->validate([
                'message' => 'required|string',
            ]);

            Announcement::create([
                'message' => $request->input('message'),
            ]);

            return redirect()->route('meetingpage')->with('success', 'Announcement added successfully');
        }


    public function meeting(Request $request)
        {
            $request->validate([
                'unit' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'url' => 'required|url',
            ]);

            MeetingLink::create([
                'unit' => $request->input('unit'),
                'title' => $request->input('title'),
                'url' => $request->input('url'),
            ]);

            return redirect()->route('meetingpage')->with('success', 'Meeting link added successfully');
        }


    public function updatelink(Request $request, $id)
        {
            $request->validate([
                'unit' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'url' => 'required|url',
            ]);

            $meetingLink = MeetingLink::findOrFail($id);
            $meetingLink->update([
                'unit' => $request->input('unit'),
                'title' => $request->input('title'),
                'url' => $request->input('url'),
            ]);

            return redirect()->route('meetingpage')->with('success', 'Meeting link updated successfully');
        }

    public function destroylink($id)
        {
            $meetingLink = MeetingLink::findOrFail($id);
            $meetingLink->delete();

            return redirect()->route('meetingpage')->with('success', 'Meeting link deleted successfully');
        }

    //edit student results
    public function viewAllStudentsMarks(Request $request)
        {
            $results = StudentResult::all();
            $query = User::with('results');
            
             $unitFilter = $request->input('unit');
                if ($unitFilter) {
                  $query->where('unit', $unitFilter);
                }
            // Apply search filter
             $search = $request->input('search');
         if ($search) {
            $query->where(function ($query) use ($search) {
            $query->where('fname', 'like', '%' . $search . '%')
                  ->orWhere('admission_number', 'like', '%' . $search . '%')
                  ->orWhere('lname', 'like', '%' . $search . '%');
        });
    }

            // Apply sort order
            $sort = $request->input('sort');
    $direction = $request->input('direction', 'desc');
    if ($sort) {
        $query->orderBy($sort, $direction);
    }

            $direction = 'desc';
             $students = $query->paginate(30);


            return view('admin.view_all_students_marks', [
                'students' => $students,
                'results' => $results,
                'search' => $search,
                'sort' => $sort,
                'direction' => $direction,
                'unitFilter' => $unitFilter,
            ]);
        }


    public function editStudentResults($userId)
        {
            $user = User::findOrFail($userId);
            $results = $user->results;

            return view('admin.edit-results', ['user' => $user, 'results' => $results]);
        }

    public function updateStudentResults(Request $request, $userId)
        {
            $user = User::findOrFail($userId);

            // Loop through the subjects and update the marks
            foreach ($request->input('results', []) as $subject => $marks) {
            
                if (in_array($subject, ['introduction', 'windows', 'word', 'excel', 'access', 'powerpoint', 'publisher', 'internet'])) {
                    // Use 0 as the default value if $marks is null
                    $marks = $marks ?? 0;

                    $result = $user->results()->where($subject, '=', 0)->first();

                    if ($result) {
                        // Update the existing result
                        $result->update([$subject => $marks]);
                    } else {
                        // Create a new result if it doesn't exist
                        $user->results()->create([$subject => $marks]);
                    }
                }
            }

            return redirect()->route('admin.view-all-students-marks', $userId)->with('success', 'Student results updated successfully');
        }
    


public function bulkUpdateStudentResults(Request $request)
{
    // Validate the request data as needed
    
    foreach ($request->input('students', []) as $studentId => $marks) {
        // Check if the student exists
        $student = User::find($studentId);

        if ($student) {
            foreach ($marks as $subject => $mark) {
                // Check if the subject is one of the specified subjects
                if (in_array($subject, ['introduction', 'windows', 'word', 'excel', 'access', 'powerpoint', 'publisher','pagemaker','DOS', 'internet'])) {
                    // Use 0 as the default value if $mark is null
                    $mark = $mark ?? 0;

                    // Get the existing result or create a new one
                    $result = $student->results()->updateOrInsert(
                        ['user_id' => $studentId],
                        [$subject => $mark]
                    );
                }
            }
        } else {
            // If the student doesn't exist, create a new user with the given ID
            $newStudent = User::create(['id' => $studentId]);

            // Loop through the marks and create results for the new student
            foreach ($marks as $subject => $mark) {
                // Check if the subject is one of the specified subjects
                if (in_array($subject, ['introduction', 'windows', 'word', 'excel', 'access', 'powerpoint', 'publisher', 'internet'])) {
                    // Use 0 as the default value if $mark is null
                    $mark = $mark ?? 0;

                    // Create a new result for the new student
                    $newStudent->results()->create([$subject => $mark]);
                }
            }
        }
    }

    return redirect()->route('admin.view-all-students-marks')->with('success', 'Students\' results updated successfully');
}






        //edit page of a student
    public function edit($id)
        {
            $student = User::find($id);
            return view('admin.edit', compact('student'));
        }

    //update student details
    public function update(Request $request, $id)
        {
            $request->validate([
                'fname' => 'required|string|max:255',
                'sname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'gender' => 'required|string|max:255',
                'phone' => 'required|numeric|unique:users,phone,' . $id,
                'paid' => 'required|integer|max:1000000',
                'email' => 'required|email|unique:users,email,' . $id,
                'unit' => 'required|string|max:255',
                'password' => 'nullable|string|min:6',
            ]);

            $student = User::find($id);
            $student->update($request->only(['fname', 'sname', 'lname', 'gender', 'paid', 'phone', 'email','unit']));
            

            if ($request->filled('password')) {
                $student->update([
                    'password' => bcrypt($request->input('password')),
                ]);
            }
        
            return redirect()->route('students')->with('success', 'Student details updated successfully');
        }
        
    //delete a student
    public function destroy($id)
        {
            $student = User::find($id);
            $student->delete();
            return redirect()->route('students')->with('success', 'Student details deleted successfully');
        }
        
        
public function downloadResults()
{
    // Fetch all students with their results
    $students = DB::table('users')
                ->leftJoin('student_results', 'users.id', '=', 'student_results.user_id')
                ->select(
		    'users.admission_number',
		    'users.fname',
                    'users.sname',
                    'users.lname',
                    'student_results.introduction',
                    'student_results.windows',
                    'student_results.word',
                    'student_results.excel',
                    'student_results.access',
                    'student_results.powerpoint',
                    'student_results.publisher',
                    'student_results.pagemaker',
                    'student_results.DOS',
                    'student_results.internet'
                )
                ->where('student_results.introduction', '>', 0)
                ->where('student_results.windows', '>', 0)
                ->where('student_results.word', '>', 0)
                ->where('student_results.excel', '>', 0)
                ->where('student_results.access', '>', 0)
                ->where('student_results.powerpoint', '>', 0)
                ->where('student_results.publisher', '>', 0)
                ->where('student_results.pagemaker', '>', 0)
                ->where('student_results.DOS', '>', 0)
                ->where('student_results.internet', '>', 0)
                ->orderBy('users.created_at', 'desc')
                ->limit(50)
                ->get();

    // Set headers for CSV download
    $headers = array(
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename=students_with_results.csv',
    );

    // Create CSV content
    $csvString = $this->generateCsvString($students);

    // Create response with CSV content
    return Response::make($csvString, 200, $headers);
}

private function generateCsvString($students)
{
    $output = fopen('php://temp', 'w');

    // Write headers
    fputcsv($output, array(
        'ADM',
        'First Name',
    	'Second Name',
        'Last Name',
        'Introduction',
        'Windows',
        'Word',
        'Excel',
        'Access',
        'PowerPoint',
        'Publisher',
        'Pagemaker',
        'DOS',
        'Internet'
    ));

    // Write student data
    foreach ($students as $student) {
        fputcsv($output, array(
            $student->admission_number,
	    $student->fname,
            $student->sname,
            $student->lname,
            $student->introduction ?? 0,
            $student->windows ?? 0,
            $student->word ?? 0,
            $student->excel ?? 0,
            $student->access ?? 0,
            $student->powerpoint ?? 0,
            $student->publisher ?? 0,
            $student->pagemaker ?? 0,
            $student->DOS ?? 0,
            $student->internet ?? 0
        ));
    }

    // Rewind the file pointer
    rewind($output);

    // Read the file pointer to a string
    $csvString = stream_get_contents($output);

    // Close the file pointer
    fclose($output);

    return $csvString;
}


 public function courses()
    {
        $courses = Course::all();
        return view('courses.courses', compact('courses'));
    }
    
    
     public function create()
    {
        return view('courses.addcourse');
    }

    public function addCourse(Request $request)
    {
           $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:courses,name',
        ]);
    
        // Redirect back with errors if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        // Create a new course instance
        $course = new Course();
        $course->name = $request->input('name');
        $course->save();
    
        // Redirect to courses index with success message
        return redirect()->route('courses.courses')
            ->with('status', 'Course added successfully!');
    }
    
    
    public function editCourse($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.editcourse', compact('course'));
    }

    public function updateCourse(Request $request, $id)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:courses,name,'.$id,
        ]);

        // Redirect back with errors if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update the course instance
        $course = Course::findOrFail($id);
        $course->name = $request->input('name');
        $course->save();

        // Redirect to courses index with success message
        return redirect()->route('courses.courses')
            ->with('status', 'Course updated successfully!');
    }
    

    public function deleteCourse(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.courses')->with('success', 'Course deleted successfully.');
    }

    public function notes()
    {
        $notes = notes::with('course', 'admin')->get();
        return view('notes.notes', compact('notes'));
    }

   public function addNote()
        {
            $courses = Course::all();
            return view('notes.form', compact('courses'));
        }

    public function storeNote(Request $request)
    {
               if (!Auth::guard('admin')->check()) {
                return redirect()->route('loginadmin')->with('error', 'You must be logged in to add a note.');
            }
        
             // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'required',
            'pdf_file' => 'nullable|mimes:pdf|max:1024', // Max 1MB for PDF files
        ]);

        // Redirect back with errors if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle file upload if a file is provided
        $pdfPath = null;
        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $pdfPath = 'notes/' . uniqid() . '-' . $pdfFile->getClientOriginalName();
            $pdfFile->move(public_path('../public_html/notes'), $pdfPath);
        }

        // Create a new note instance
        $note = new Notes();
        $note->course_id = $request->course_id;
        $note->admin_id = Auth::guard('admin')->id(); // Assuming you have an admin guard
        $note->title = $request->title;
        $note->content = $request->content;
        $note->pdf_file = $pdfPath; // Store the path to the PDF file
        $note->save();

        // Redirect to notes index with success message
        return redirect()->route('notes.notes')->with('success', 'Note uploaded successfully.');
    }

    public function viewNote(notes $note)
    {
        return view('notes.view', compact('note'));
    }

    public function editNote(notes $note)
        {
            $courses = Course::all();
            return view('notes.form', compact('note', 'courses'));
        }

    public function updateNote(Request $request, notes $note)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $note->update($request->all());
        return redirect()->route('notes.notes')->with('success', 'Note updated successfully.');
    }

    public function deleteNote(notes $note)
    {
        if ($note->pdf_file) {
            $pdfPath = public_path('../public_html/' . $note->pdf_file);
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
        }

    // Delete the note record
    
        $note->delete();
        return redirect()->route('notes.notes')->with('success', 'Note deleted successfully.');
    }
    
    
   

    
}
