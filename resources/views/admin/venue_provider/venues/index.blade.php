@extends('admin.layout.app')

@section('title', 'venue')

@section('content')

    <div class="main-content" style="min-height: 562px;">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-12">
                                    <h4>Venue</h4>

                                </div>
                            </div>
                            <div class="card-body table-striped table-bordered table-responsive">
                                <a class="btn btn-primary mb-3"
                                href="{{route('admin.user.index')}}">Back</a>
                                <a class="btn btn-success mb-3"
                                       href="{{route('venue-providers.venue.add',$data['user_id'])}}">Add Venue</a>
                                <table class="table" id="table_id_venue">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Seats</th>
                                            <th>Stands</th>
                                            <th>Offer Catering</th>
                                            <th>Opening_time</th>
                                            <th>Closing_time</th>
                                            <th>Created_At</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     @foreach($data['venue'] as $venue)


                                            {{-- @dd($entertainer->title) --}}
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $venue->title }}</td>
                                                <td>{{ $venue->category }}</td>
                                                <td>{{ $venue->description }}</td>
                                                <td>{{ $venue->seats }}</td>
                                                <td>{{ $venue->stands }}</td>
                                                <td>{{ $venue->offer_cattering }}</td>
                                                @if( explode(':',$venue->opening_time)[0]>=12)
                                                <td>{{ $venue->opening_time }} PM</td>
                                                @else
                                                 <td>{{ $venue->opening_time }} AM</td>
                                                @endif
                                                @if( explode(':',$venue->closing_time)[0]>=12)
                                                <td>{{ $venue->closing_time }} PM</td>
                                                @else
                                                 <td>{{ $venue->closing_time }} AM</td>
                                                @endif
                                               <td>{{ $venue->created_at }}</td>

                                                <td
                                                style="display: flex;align-items: center;justify-content: center;column-gap: 8px">
                                                {{-- <a class="btn btn-success"
                                               href="{{route('entertainer.edit', $entertainer->id)}}">Categories</a> --}}
                                               <a class="btn btn-primary"
                                               href="{{route('venue-providers.venue.photo.show', $venue->id)}}">Photos</a>
                                               <a class="btn btn-success"
                                               href="{{route('venue-providers.venue.venue_pricings.index', $venue->id)}}">Price Packages</a>
                                                <a class="btn btn-info"
                                               href="{{route('venue-providers.venue.edit', $venue->id)}}">Edit</a>
                                                        <form method="get" action="{{ route('venue-providers.venue.delete', $venue->id) }}">
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
        </section>
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
        $('#table_id_venue').DataTable();
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

