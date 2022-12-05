@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
    <body>
        <div class="main-content">
            <section class="section">
                <div class="section-body">
                    <a class="btn btn-primary mb-2"
                    href="{{route('recruiter.show',$data['user_id'])}}">Back</a>

                    <form id="add_student" action="{{ route('recruiter.event.store',$data['user_id']) }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <h4 class="text-center my-4">Add Event</h4>
                                    <div class="row mx-0 px-4">
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label> Title </label>
                                                <input type="text" name="title" id="name" value="{{ old('title') }}" class="form-control">
                                                @error('title')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-2">
                                            <div class="form-group mb-3">
                                                <label>About Event</label>
                                                <input type="text" name="about_event" value="{{ old('about_event') }}"  class="form-control" />
                                            </div>
                                            @error('about_event')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        </div>

                                    </div>
                                    <div class="row mx-0 px-4">
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Description</label>
                                                <input type="text" name="description" id="phone" value="{{ old('description') }}" class="form-control"
                                                placeholder="example" >
                                                @error('description')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Price</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2">$</span>
                                                    </div>
                                                    <input type="number" class="form-control" placeholder="Price" aria-label="Price" name="price" value="{{ old('price') }}" aria-describedby="basic-addon2">

                                                </div>
                                                @error('price')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Event Type</label>

                                                    <div>
                                                    <label>Public</label>

                                                        <input type="radio"value="Public" name="event_type" value="{{ old('event_type') }}" >
                                                        &nbsp;
                                                    <label>Private</label>
                                                        <input type="radio" value="Private" name="event_type" value="{{ old('event_type') }}" >
                                                        @error('event_type')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>





                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Joining Type</label>

                                                <div>
                                                    <label>Free</label>

                                                        <input type="radio"value="Free" name="joining_type" value="{{ old('joining_type') }}" >
                                                        &nbsp;
                                                    <label>Private</label>
                                                        <input type="radio" value="Paid" name="joining_type" value="{{ old('joining_type') }}" >
                                                        @error('joining_type')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror

                                            </div>


                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Hiring Entertainers Status</label>

                                              <div>
                                                    <label>Hired</label>

                                                        <input type="radio"value="hired" name="hiring_entertainers_status" value="{{ old('hiring_entertainers_status') }}" >
                                                        &nbsp;
                                                    <label>Open For Hiring</label>
                                                        <input type="radio" value="open for hiring" name="hiring_entertainers_status" value="{{ old('hiring_entertainers_status') }}" >
                                                        @error('hiring_entertainers_status')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror

                                                </div>


                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                            <div>
                                                <label for="seats">Seats</label>
                                                <input type="number" name="seats" id="seats" value="{{ old('seats') }}"
                                             class="form-control" placeholder="example">
                                            </div>
                                                @error('seats')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Date</label>

                                                <input type="date" name="date" id="date" value="{{ old('date') }}"  class="form-control"
                                                placeholder="example" >

                                                @error('date')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror



                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>From</label>

                                                <input type="time" name="from" id="from" value="{{ old('from') }}" class="form-control"
                                                placeholder="example" >

                                                @error('from')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>To</label>

                                                <input type="time" name="to" id="to" value="{{ old('to') }}" class="form-control"
                                                 >

                                                @error('to')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>
                                        {{-- <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Hiring Entertainer Status</label>
                                                <input type="text" name="hiring_entertainer_status" id="hiring_entertainer_status" Value="{{ $event['hiring_entertainer_status'] }}" class="form-control"
                                                placeholder="example" >
                                                @error('hiring_entertainer_status')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div> --}}
                                        {{-- <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Company</label>
                                                <input type="text" name="company" id="company" Value="{{ $entertainer['company'] }}" class="form-control"
                                                    >
                                                @error('company')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mx-0 px-4">
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Designation</label>
                                                <input type="text" name="designation" id="designation" Value="{{ $entertainer['designation'] }}" class="form-control"
                                                    >
                                                @error('designation')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div> --}}

                                    </div>
                                    <div class="card-footer text-center row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-success mr-1 btn-bg"
                                                id="submit">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </body>
@endsection
