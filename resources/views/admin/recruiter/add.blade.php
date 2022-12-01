@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
    <body>
        <div class="main-content">
            <section class="section">
                <div class="section-body">
                    <a class="btn btn-primary mb-2"
                    href="{{route('admin.user.index')}}">Back</a>
                    <form id="recruiter" action="{{ route('recruiter.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <h4 class="text-center my-4">Add Recruiter</h4>
                                    <div class="row mx-0 px-4">
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label> Name </label>
                                                <input type="text" name="name" id="name" class="form-control">
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-2">
                                            <div class="form-group mb-3">
                                                <label>Email</label>
                                                <input type="email" name="email" id="email" " class="form-control" />
                                            </div>
                                            @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        </div>

                                    </div>
                                    <div class="row mx-0 px-4">
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Phone</label>
                                                <input type="tel" name="phone" id="phone"  class="form-control"
                                                placeholder="92 XXXXXXXXXX (Mobile Number)" >
                                                @error('phone')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Company</label>
                                                <input type="text" name="company"                                                                          " id="phone"  class="form-control"
                                                placeholder="example" >
                                                @error('company')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Designation</label>
                                                <input type="text" name="designation"                                                                          " id="phone"  class="form-control"
                                                placeholder="example" >
                                                @error('designation')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                              <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            {{-- <div class="form-group mb-2">
                                                <label>Password</label>
                                                <input type="password" placeholder="example" name="password" id="password"  class="form-control"
                                                    >
                                                @error('password')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div> --}}
                                        </div>
                                    </div>

                                    {{-- <div class="row mx-0 px-4">
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Confirm Password</label>
                                                <input type="password" placeholder="Example" name="password_confirmation" id="password" class="form-control"
                                                    >
                                                @error('password_confirmation')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div> --}}
                                    <div class="card-footer text-center row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-success mr-1 btn-bg"
                                                id="submit">Create</button>
                                        </div>
                                    </div>


                                        {{-- <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Venue</label>
                                                <input type="text" name="venue" id="venue"  class="form-control">
                                                @error('venue')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                    </div> --}}



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
