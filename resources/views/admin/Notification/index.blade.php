@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
    <body>
        <div class="main-content">
            <section class="section">
                <div class="section-body">
                    {{-- @dd($data) --}}
                    <form id="add_student" action="{{ route('entertainer.talent.price_packages.store',$data['entertainer_details_id']) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <h4 class="text-center my-4">Push Notification</h4>
                                    <div class="row mx-0 px-4">
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group">
                                                <label>Notification</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Notification"  name="notification" value="{{ old('notification') }}" aria-describedby="basic-addon2">
                                                </div>
                                                @error('price_package')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>User Type</label>
                                                <select name="user_type">
                                                    <option>Please Select User Type</option>
                                                    <option value="">All Users</option>
                                                    <option value="">Recruiter</option>
                                                    <option value="">Entertainer</option>
                                                    <option value="">Venue Providers</option>
                                                </select>
                                                @error('user_type')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
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
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </body>
@endsection

@section ('scripts')
@if (\Illuminate\Support\Facades\Session::has('message'))
<script>
    toastr.success('{{ \Illuminate\Support\Facades\Session::get('message') }}');
</script>
@endif

@endsection
