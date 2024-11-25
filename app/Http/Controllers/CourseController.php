<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        // We give default value for the 'column' and 'type' Before the request came to us
        $col = 'id'; // sorting by 'name' , 'id', 'created_at', 'price' etc ..
        $type = 'asc'; // sorting type 'asc' or 'desc'

        // 1- if the request has a selected "column" values and has a selected "type" values Return -> True | False
        if ($request->has('column') && $request->has('type')) {
            // 2- if the user didn't add a value for the column or type we will add our default values .
            // if the value  is not in the array so we will add Our Default values
            if (!in_array($request->column, ['id', 'name', 'price', 'created_at', 'status']) || !in_array($request->type, ['asc', 'desc'])) {
                $col = 'id';
                $type = 'asc';
            } else {
                $col = $request->column;
                $type = $request->type;
            }
        }
        /* ->> I Worte This <<- */
        $search = $request->search;
        // 3- if user add search value or user didn't add search value
        if ($request->has('search') && !empty($request->search)) { // $request->search != null -> my code
            //$courses = Course::where('name',$search)->orderBy($col, $type)->paginate(10);
            // 4- SELECT * FROM courses WHERE name = $serach ORDER BY $col, $type LIMIT 10;
            // $courses = DB::select("select * from courses where price LIKE ? OR name LIKE ?", ['%'.$search.'%','%'.$search.'%']);
            $courses = Course::where('name', 'LIKE', "%{$search}%")
                ->orWhere('price', 'LIKE', "%{$search}%")
                ->orderBy($col, $type)
                ->paginate(10);
            $searchValue = $request->search; // to send it to the input field of the search
            // return the courses and the search value to be shown in search bar
            return view('courses.index', compact('courses', 'searchValue'));
        } else {
            // 4- just return the courses order by user choice.
            $courses = Course::orderBY($col, $type)->paginate(10);
            return view('courses.index', compact('courses'));
        }
        return view('courses.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   //Store Process
        /*
            1- Validation
            2- Upload Files
            3- Store in database
            4- Redirect to specific Route
        */
        // Validation
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'content' => 'required',
            'price' => 'required|numeric',
            'hours' => 'required|integer'
        ]);
        // File Upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses/images', 'public');
        } else {
            $imagePath = null;
        }
        // Database Storing
        $course = Course::create([
            'name' => $request->input('name'),
            'image' => $imagePath,  // Store image path in the database
            'content' => $request->input('content'),
            'price' => $request->input('price'),
            'hours' => $request->input('hours'),
        ]);
        // Redirection
        // return response()->json($course, 201); // return to the json page contain user inputs data
        return redirect()->route('courses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $course = Course::find($id);
        return view('courses.show',compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $course = Course::find($id);
        // If the course is not found, return a 404 error
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // Validate incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'content' => 'required|string',
            'price' => 'required|numeric',
            'hours' => 'required|integer',
        ]);

        // Find the course by ID
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        // Handle the file upload if there's a new image
        if ($request->hasFile('image')) {
            // Delete the old image if a new one is uploaded
            if ($course->image) {
                Storage::delete('public/' . $course->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('courses/images', 'public');
        } else {
            // Keep the old image if no new image is uploaded
            $imagePath = $course->image;
        }

        // Update the course
        $course->update([
            'name' => $request->input('name'),
            'image' => $imagePath,  // Store the new image path or keep the old one
            'content' => $request->input('content'),
            'price' => $request->input('price'),
            'hours' => $request->input('hours'),
        ]);
        return redirect()->route('courses.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        // DELETE FROM courses where id = $id
        Course::destroy($id);
        return redirect()->back(); // stay in the same route
    }

    public function trash()
    {
        $courses = Course::onlyTrashed()->latest('deleted_at')->paginate(10);
        return view('courses.trash', compact('courses'));
    }
    public function restore($id)
    {

        $course = Course::onlyTrashed()->find($id)->restore();
        // return redirect()->back(); // return to the latest route user visit
        return redirect(route('courses.trash'));
    }
    public function destroy(string $id)
    {
        $course = Course::onlyTrashed()->find($id)->forceDelete();
        // return redirect()->back(); // return to the latest route user visit
        return redirect(route('courses.trash'));
    }
}
