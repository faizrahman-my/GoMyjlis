@extends('components.my_event_template')
@inject('carbon', 'Carbon\Carbon')

@section('title', 'Vendor')

@section('myevent-active')active @endsection
@section('link-home'){{ URL::to('/') }}@endsection
@section('link-event'){{ URL::to('/events') }}@endsection
@section('link-login'){{ URL::to('/signin') }}@endsection
@section('link-account'){{ URL::to('/account') }}@endsection
@section('link-myevent'){{ URL::to('/myevent') }}@endsection



@section('link-info'){{ URL::to('/myevent/' . $event_id . '/info') }}@endsection
@section('link-ticket'){{ URL::to('/myevent/' . $event_id . '/ticket') }}@endsection

@section('dd-item')
    <a class="dropdown-item text-dark" href="{{ URL::to('/myevent/' . $event_id . '/schedule') }}">Schedule</a>
    <a class="dropdown-item text-dark" href="{{ URL::to('/myevent/' . $event_id . '/poll') }}">Poll</a>
    @if ($event->is_organizer == 0 && $event->is_assistant == 0)
        <a class="dropdown-item text-dark" href="{{ URL::to('/myevent/' . $event_id . '/rating') }}">Give Rating</a>
    @endif
    <a class="dropdown-item text-dark" href="{{ URL::to('/myevent/' . $event_id . '/support') }}">Support Ticket</a>
    @if (
        ($event->is_organizer == 1 && $event->is_assistant == 0) ||
            ($event->is_organizer == 0 && $event->is_assistant == 1))
        <a class="dropdown-item text-dark" href="{{ URL::to('/myevent/' . $event_id . '/task') }}">Management Task</a>
        <a class="dropdown-item text-dark" href="{{ URL::to('/myevent/' . $event_id . '/attendee') }}">Attendee List</a>
        <a class="dropdown-item text-dark" href="{{ URL::to('/myevent/' . $event_id . '/vendor') }}">Vendor</a>
        <a class="dropdown-item text-dark" href="{{ URL::to('/myevent/' . $event_id . '/analytic') }}">Analytics</a>
    @endif
@endsection

@section('content')

    <div class="row mb-4">
        <h4 class="fw-light col-md-6 col-8 d-flex align-items-center">Vendor</h4>
    </div>


    <div class="mx-2">

        <div class="col-auto">
            <div>
                <h5 class="m-1">{{ $vendor_detail->name }}</h5>
                <p class="m-1">Phone Number :{{ $vendor_detail->contact_number }}</p>
                <p class="m-1">Address :{{ $vendor_detail->address }}</p>
                <p class="m-1">Category: {{ $vendor_detail->category }}</p>
            </div>
        </div>

        <hr>
        <div class="overflow-auto mx-4" style="max-height: 40vh;">

            @foreach ($message_list as $list)
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <p class="mb-1 fw-bold">{{ $list->username }}</p>
                        <p class="mb-1 fw-bold">{{ $carbon::parse($list->created_at)->diffForHumans() }}</p>
                    </div>
                    <div class="d-flex flex-row justify-content-start">
                        <div>
                            <p class="p-2 ms-3 mb-3 rounded-3" style="background-color: #f5f6f7;">
                                {{ $list->message }}</p>
                        </div>
                    </div>
                </div>
            @endforeach



        </div>


        <div class="mb-5">
            <form action="/myevent/{{ $event_id }}/vendor/{{ $vendor_id }}" method="post">
                @csrf
                <div class="input-group">
                    <input type="text" name="user-message" placeholder="Press Enter" class="form-control primary">
                    <span class="input-group-btn">
                        <button class="btn btn-dark" type="submit">Send</button>
                    </span>
                </div>
            </form>
        </div>


    </div>

@endsection
