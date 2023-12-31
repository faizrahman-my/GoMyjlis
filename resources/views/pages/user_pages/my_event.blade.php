@extends('components.template')

@section('title', 'My Event')

@section('myevent-active')active @endsection

@section('link-home'){{ URL::to('/') }}@endsection
@section('link-event'){{ URL::to('/events') }}@endsection
@section('link-login'){{ URL::to('/signin') }}@endsection
@section('link-account'){{ URL::to('/account') }}@endsection
@section('link-myevent'){{ URL::current() }}@endsection
@section('link-manageuser'){{ URL::to('/admin/manage-user') }}@endsection



@section('content')

    <section class="mt-4">
        <div class="container">

            <div class="justify-content-center row">
                <div class="col-lg-12">
                    <form action="/myevent" method="POST">
                        @csrf
                        <div class="row d-flex justify-content-lg-center bg-primary-subtle bg-gradient p-3 mx-2 rounded">
                            <div class="col-lg-3">
                                <label for="exampleSelect1" class="form-label">State</label>
                                <select class="form-select" id="exampleSelect1" name="state">
                                    <option value="">All State</option>
                                    @foreach ($state_list as $list)
                                        <option {{ $state == $list ? 'selected' : '' }}>{{ $list }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="exampleSelect1" class="form-label">Category</label>
                                <select class="form-select" id="exampleSelect1" name="mode">
                                    <option value="">All Type</option>
                                    <option {{ $mode == 'Online' ? 'selected' : '' }}>Online</option>
                                    <option {{ $mode == 'In Person' ? 'selected' : '' }}>In Person</option>
                                    <option {{ $mode == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
                            </div>
                            <div class="col-lg-3 d-flex align-items-end pt-3">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                            <div class="col-lg-3 d-flex align-items-end pt-3">
                                <a class="btn btn-secondary w-100" href="{{ URL::to('/create-event') }}">Create New Event
                                    +</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div>
                        @if ($user_event->isEmpty())
                            <div class="page-wrap d-flex flex-row align-items-center mt-5">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12 text-center">
                                            <span class="display-5 d-block">No Event Found</span>
                                            <div class="mb-4 lead">You are not joining any event.</div>
                                            <a href="{{ URL::to('/events') }}" class="btn btn-outline-primary">Join Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @foreach ($user_event as $mylist)
                            @if ( $state == $mylist->state  && $mode == $mylist->event_mode 
                            || empty($state)  && $mode == $mylist->event_mode
                            || $state == $mylist->state  && empty($mode))
                                <div class="card mt-4">
                                    <div class="p-4 card-body">
                                        <div class="align-items-center row">
                                            <div class="col-md-5 col-12">
                                                <div class="mt-3 mt-lg-0">
                                                    <h5 class="fs-19 mb-0">
                                                        <a class="primary-link"
                                                            href="/myevent/{{ $mylist->event_id }}/info">{{ $mylist->title }}</a>
                                                    </h5>
                                                    <p class="text-muted my-1">
                                                        @if ($mylist->is_organizer == 1 && $mylist->is_assistant == 0)
                                                            Organizer
                                                        @elseif ($mylist->is_organizer == 0 && $mylist->is_assistant == 1)
                                                            Assistant
                                                        @else
                                                            Attendee
                                                        @endif
                                                    </p>
                                                    <ul class="list-inline mb-0 text-muted mb-2">
                                                        <li class="list-inline-item"> {{ $mylist->state }}</li>
                                                        <li class="list-inline-item"> {{ $mylist->start_date }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @if ($mylist->is_organizer == 1)
                                                <div class="col-md-7 col-12 d-flex justify-content-md-end">
                                                    <form action="/myevent/delete" method="post">
                                                        {{ method_field('DELETE') }}
                                                        @csrf
                                                        <input type="hidden" name="event_id"
                                                            value="{{ $mylist->event_id }}" autocomplete="off">
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @elseif (empty($state) && empty($mode))
                                <div class="card mt-4">
                                    <div class="p-4 card-body">
                                        <div class="align-items-center row">
                                            <div class="col-md-5 col-12">
                                                <div class="mt-3 mt-lg-0">
                                                    <h5 class="fs-19 mb-0">
                                                        <a class="primary-link"
                                                            href="/myevent/{{ $mylist->event_id }}/info">{{ $mylist->title }}</a>
                                                    </h5>
                                                    <p class="text-muted my-1">
                                                        @if ($mylist->is_organizer == 1 && $mylist->is_assistant == 0)
                                                            Organizer
                                                        @elseif ($mylist->is_organizer == 0 && $mylist->is_assistant == 1)
                                                            Assistant
                                                        @else
                                                            Attendee
                                                        @endif
                                                    </p>
                                                    <ul class="list-inline mb-0 text-muted mb-2">
                                                        <li class="list-inline-item"> {{ $mylist->state }}</li>
                                                        <li class="list-inline-item"> {{ $mylist->start_date }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @if ($mylist->is_organizer == 1)
                                                <div class="col-md-7 col-12 d-flex justify-content-md-end">
                                                    <form action="/myevent/delete" method="post">
                                                        {{ method_field('DELETE') }}
                                                        @csrf
                                                        <input type="hidden" name="event_id"
                                                            value="{{ $mylist->event_id }}" autocomplete="off">
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach




                    </div>
                </div>
            </div>



        </div>
    </section>
@endsection
