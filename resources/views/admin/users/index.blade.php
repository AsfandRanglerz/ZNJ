@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <div class="card">
            <div class="card-header">
              <h4>Users</h4>
            </div>

            {{-- @dd($data['recruiter']) --}}
            <div class="card-body">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Recruiters</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Entertainers</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Venue Providers</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card-body table-striped table-bordered table-responsive">
                        <table class="table" id="table_id_1">
                            <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Company</th>
                                    <th>Designation</th>
                                    <th>Created At</th>


                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                             @foreach($data['recruiter'] as $recruiter)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $recruiter->name }}</td>
                                        <td>{{ $recruiter->email }}</td>
                                        <td>{{ $recruiter->phone }}</td>
                                        <td>{{ $recruiter->company }}</td>
                                        <td>{{ $recruiter->designation }}</td>
                                        <td>{{ $recruiter->created_at }}</td>

                                        <td
                                        style="display: flex;align-items: center;justify-content: center;column-gap: 8px">
                                        <a class="btn btn-info"
                                                href="{{route('recruiter.edit', $recruiter->id)}}">Edit</a>
                                                <form method="POST" action="{{ route('recruiter.destroy', $recruiter->id) }}">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip" >Delete</button>
                                                </form>
                                                   </td>
                                                </tr>
                              @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="card-body table-striped table-bordered table-responsive">
                        <table class="table" id="table_id_2">
                            <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Created at</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                             @foreach($data['entertainer'] as $entertainer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $entertainer->name }}</td>
                                        <td>{{ $entertainer->email }}</td>
                                        <td>{{ $entertainer->phone }}</td>
                                        <td>{{ $entertainer->created_at }}</td>

                                        <td
                                        style="display: flex;align-items: center;justify-content: center;column-gap: 8px">
                                        <a class="btn btn-danger"
                                                href="{{route('entertainer.edit', $entertainer->id)}}">Talent</a>
                                        <a class="btn btn-info"
                                                href="{{route('entertainer.edit', $entertainer->id)}}">Edit</a>
                                                <form method="POST" action="{{ route('entertainer.destroy', $entertainer->id) }}">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip" >Delete</button>
                                                </form>
                                                   </td>
                                                </tr>
                              @endforeach

                            </tbody>
                        </table>
                    </div>



                </div>


                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="card-body table-striped table-bordered table-responsive">
                        <table class="table" id="table_id_3">
                            <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Venue</th>
                                    <th>Created At</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                             @foreach($data['venue'] as $venue)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $venue->name }}</td>
                                        <td>{{ $venue->email }}</td>
                                        <td>{{ $venue->phone }}</td>
                                        <td>{{ $venue->venue}}</td>
                                        <td>{{ $venue->created_at }}</td>

                                        <td
                                        style="display: flex;align-items: center;justify-content: center;column-gap: 8px">
                                        <a class="btn btn-info"
                                                href="{{route('venue.edit', $venue->id)}}">Edit</a>
                                                <form method="POST" action="{{ route('venue.destroy', $venue->id) }}">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip" >Delete</button>
                                                </form>
                                                   </td>
                                                </tr>
                              @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
              </div>
            </div>
          </div>



    </div>
@endsection

@section ('scripts')
@if (\Illuminate\Support\Facades\Session::has('message'))
<script>
    toastr.success('{{ \Illuminate\Support\Facades\Session::get('message') }}');
</script>
@endif
<script>
    $(document).ready(function() {
        $('#table_id_1').DataTable();
        $('#table_id_2').DataTable();
        $('#table_id_3').DataTable();


    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">

$('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this record?`,
              text: "If you delete this, it will be gone forever.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });

</script>
@endsection

