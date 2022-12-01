@extends('admin.layout.app')

@section('title', 'index')

@section('content')

    <div class="main-content" style="min-height: 562px;">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-12">
                                    <h4>Venue Price Packages</h4>
                                </div>
                            </div>
                            <div class="card-body table-striped table-bordered table-responsive">
                                 <a class="btn btn-primary mb-3"
                                 href="{{route('venue.show',$data['user_id'])}}">Back</a>
                                <a class="btn btn-success mb-3"
                                href="{{route('venue-providers.venue.venue_pricings.add',$data['venue_id'])}}">Add Price Package</a>
                                <table class="table" id="table_talent_price">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Price</th>
                                            <th>Day</th>
                                            <th>Created At</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     @foreach($data['price_packages'] as $price)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $price->price }}</td>
                                                <td>{{ $price->day }}</td>
                                                <td>{{ $price->created_at }}</td>
                                                <td
                                                style="display: flex;align-items: center;justify-content: center;column-gap: 8px">
                                                <a class="btn btn-info"
                                               href="{{route('venue-providers.venue.venue_pricings.edit', $price->id)}}">Edit</a>
                                                        <form method="POST" action="{{ route('venue-providers.venue.venue_pricings.delete', $price->id) }}">
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
        $('#table_talent_price').DataTable();
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
