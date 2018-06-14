<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Command;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display all commands.
     *
     * @return \Illuminate\Http\Response
     */
    public function commands()
    {
        // Get all commands
        $commands = Command::orderBy('name', 'asc')->get();

        return $commands;
    }

    /**
     * Display all replies.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        // Get all replies
        $replies = Reply::orderBy('command', 'asc')->get();

        return $replies;
    }

    /**
     * Store a new reply.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request.
        $this->validate($request, [
            'command' => 'required',
            'content' => 'required'
        ]);
        // Create the reply.
        $reply = Reply::create([
            'command' => $request->command,
            'start_date' => isset($request->start_date) ? Carbon::parse($request->start_date)->format('Y-m-d') : '2018-01-01',
            'end_date' => isset($request->end_date) ? Carbon::parse($request->end_date)->format('Y-m-d') : '2021-01-01',
            'content' => $request->content
        ]);
    }

    /**
     * Update the specified reply.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request.
        $this->validate($request, [
            'command' => 'required',
            'content' => 'required'
        ]);
        // Find the reply by id.
        $reply = Reply::findOrFail($id);
        // Update the reply.
        $reply->update([
            'command' => $request->command,
            'start_date' => isset($request->start_date) ? Carbon::parse($request->start_date)->format('Y-m-d') : '2018-01-01',
            'end_date' => isset($request->end_date) ? Carbon::parse($request->end_date)->format('Y-m-d') : '2020-01-01',
            'content' => $request->content
        ]);
    }

    /**
     * Remove the specified reply.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the reply by id.
        $reply = Reply::findOrFail($id); 
        // Delete the domain.
        $reply->delete();
    }
}
