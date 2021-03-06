<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'channel' => 'nullable',
            'note' => 'nullable',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'time_zone' => 'required',
            'creator_name' => 'string',
            'creator_email' => 'email',
        ]);

        $meeting = Meeting::create($validatedData);

        /* slug */
        $meeting->slug = Str::slug($meeting->title,"-");
        $meeting->save();
        $meeting->refresh();
        
        if($request->has('password')){
            /* Creating User */
            $current_user = User::create([
                'name' => $request->input('creator_name'), 
                'email' => $request->input('creator_email'),
                'password' => Hash::make($request->input('password')),
            ]);

            /* Update Meeting */
            $meeting->update(['user_id' => $current_user->id]);
            $meeting->refresh();
            
            return json_encode($meeting);
        } 

        return json_encode($meeting);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function show(Meeting $meeting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function edit(Meeting $meeting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meeting $meeting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meeting $meeting)
    {
        //
    }
}
