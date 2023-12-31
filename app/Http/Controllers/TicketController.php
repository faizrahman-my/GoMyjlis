<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    //
    public function showEventTicket($id)
    {
        $event_id = $id;
        $user_ticket = DB::table('events')
            ->join('tickets', 'tickets.event_id', '=', 'events.id')
            ->join('users', 'users.id', '=', 'tickets.user_id')
            ->where('events.id', '=', $event_id)
            ->where('tickets.is_approve', '=', 1)
            ->where('users.id', '=', auth()->id())
            ->select('events.*', 'tickets.*', 'users.username', 'users.email')
            ->get();

        $event = DB::table('events')
            ->join('tickets', 'tickets.event_id', '=', 'events.id')
            ->join('users', 'users.id', '=', 'tickets.user_id')
            ->where('events.id', '=', $event_id)
            ->where('user_id', auth()->id())
            ->where('is_approve', 1)
            ->select('events.*', 'tickets.*', 'users.username')
            ->get()->first();

        if ($user_ticket->isEmpty()) {
            return redirect('/myevent');
        } else {
            return view('pages.my_event_pages.ticket', ['user_ticket' => $user_ticket, 'event_id' => $event_id, 'event' => $event]);
        }
    }

    public function showEventAttendee($id)
    {
        $event_id = $id;
        $user_list = DB::table('users')
            ->join('tickets', 'tickets.user_id', '=', 'users.id')
            ->where('event_id', $event_id)
            ->where('is_organizer', 0)
            ->get();


        $event_team = DB::table('events')
            ->join('tickets', 'tickets.event_id', '=', 'events.id')
            ->join('users', 'users.id', '=', 'tickets.user_id')
            ->where('events.id', '=', $event_id)
            ->where('user_id', auth()->id())
            ->where('is_approve', 1)
            ->where(function ($query) {
                $query->where('is_organizer', 1)->where('is_assistant', 0);
            })
            ->orWhere(function ($query) {
                $query->where('is_organizer', 0)->where('is_assistant', 1);
            })
            ->select('events.*', 'tickets.*', 'users.username')
            ->get()->first();

        $event = DB::table('events')
            ->join('tickets', 'tickets.event_id', '=', 'events.id')
            ->join('users', 'users.id', '=', 'tickets.user_id')
            ->where('events.id', '=', $event_id)
            ->where('user_id', auth()->id())
            ->where('is_approve', 1)
            ->select('events.*', 'tickets.*', 'users.username')
            ->get()->first();

        if ($event_team == null) {
            return redirect('/myevent');
        } else {
            return view('pages.my_event_pages.attendee', ['event_id' => $event_id, 'user_list' => $user_list, 'event' => $event]);
        }
    }

    public function acceptEventAttendee(Request $request, $id)
    {
        $accept_request = [
            'is_approve' => 1,
            'updated_at' => Carbon::now()
        ];

        DB::table('tickets')
            ->where('user_id', $request['user_id'])
            ->where('event_id', $id)
            ->where('is_approve', 0)
            ->update($accept_request);

        return redirect('/myevent/' . $id . '/attendee');
    }

    public function declineEventAttendee(Request $request, $id)
    {

        DB::table('tickets')
            ->where('user_id', $request['user_id'])
            ->where('event_id', $id)
            ->where('is_approve', 0)
            ->delete();

        return redirect('/myevent/' . $id . '/attendee');
    }

    public function hireEventAssitant(Request $request, $id)
    {

        $hire_assistant = [
            'is_assistant' => 1
        ];

        DB::table('tickets')
            ->where('user_id', $request['user_id'])
            ->where('event_id', $id)
            ->where('is_approve', 1)
            ->update($hire_assistant);

        return redirect('/myevent/' . $id . '/attendee');
    }

    public function demoteEventAttendee(Request $request, $id)
    {

        $demote_attendee = [
            'is_assistant' => 0
        ];

        DB::table('tickets')
            ->where('user_id', $request['user_id'])
            ->where('event_id', $id)
            ->where('is_approve', 1)
            ->update($demote_attendee);

        return redirect('/myevent/' . $id . '/attendee');
    }

    public function kickEventAttendee(Request $request, $id)
    {

        DB::table('tickets')
            ->where('user_id', $request['user_id'])
            ->where('event_id', $id)
            ->where('is_approve', 1)
            ->where('is_organizer', 0)
            ->delete();

        return redirect('/myevent/' . $id . '/attendee');
    }

    public function checkInEventAttendee(Request $request, $id)
    {
        $checkin_attendee = [
            'is_attend' => 1
        ];

        DB::table('tickets')
            ->where('user_id', $request['user_id'])
            ->where('event_id', $id)
            ->where('is_approve', 1)
            ->update($checkin_attendee);

        return redirect('/myevent/' . $id . '/attendee');
    }
}
