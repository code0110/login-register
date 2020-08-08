<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Note;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user())
        {
            $notes = Note::all();
            $user = User::find(Auth::user()->id);
            return view('notes.view', compact('notes'))->withUser($user);

        } else {
            return redirect()->back();
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user())
        {
            $user = User::find(Auth::user()->id);
            return view('notes.add')->withUser($user);
        } else {
            return redirect()->back();
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required'
        ]);

        $note = new Note([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'job_title' => $request->get('job_title'),
            'city' => $request->get('city'),
            'country' => $request->get('country')
        ]);
        $note->save();
        return redirect('/notes')->with('success', 'Note saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user())
        {
            $notes = Note::all();
            $user = User::find(Auth::user()->id);
            $note = Note::find($id);
            return view('notes.edit', compact('note'))->withUser($user); 
            
        } else {
            return redirect()->back();
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required'
        ]);

        $note = Note::find($id);
        $note->first_name =  $request->get('first_name');
        $note->last_name = $request->get('last_name');
        $note->email = $request->get('email');
        $note->job_title = $request->get('job_title');
        $note->city = $request->get('city');
        $note->country = $request->get('country');
        $note->save();

        return redirect('/notes')->with('success', 'Note updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::find($id);
        $note->delete();

        return redirect('/notes')->with('success', 'Note deleted!');
    }
}
