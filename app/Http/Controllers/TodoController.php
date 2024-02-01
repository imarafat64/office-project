<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incompleteTodos = Todo::where('status', '!=', 'completed')->paginate(5);
        return view('demo.dashboard', compact('incompleteTodos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showBlankView()
    {
        return view('demo.blank');
    }
    public function showEmptyView()
    {
        return view('demo.empty');
    }
    public function create()
    {
        return view('demo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'status' => 'required|in:pending,completed',
        ]);

        Todo::create($request->all());

        return redirect()->route('demo.dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($todoId)
    {
        // Retrieve the todo based on the provided ID
        $todo = Todo::findOrFail($todoId);

        // Pass the todo to the view
        return view('demo.show', compact('todo'));
    }

    public function completed()
    {

        $completedTodos = Todo::where('status', 'completed')->paginate(10);

        return view('demo.completed', compact('completedTodos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        return view('demo.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required|in:pending,completed', // Add more validation rules as needed
        ]);

        $todo->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            // Update other attributes as needed
        ]);

        return redirect()->route('demo.dashboard', ['todo' => $todo->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {


        $todo->delete();


        return redirect()->route('demo.dashboard')->with('success', 'Todo deleted successfully');
    }
}
