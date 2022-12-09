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
                                    <h4>Talent</h4>

                                </div>
                            </div>
                            {{-- @dd($data) --}}
                            <div class="card-body table-striped table-bordered table-responsive">
                                 <a class="btn btn-primary mb-3"
                                href="{{route('admin.user.index')}}">Back</a>
                                <a class="btn btn-success mb-3"
                                       href="{{route('entertainer.talent.add',$data['user_id'])}}">Add Talent</a>
                                <table class="table" id="table_id_talent">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Description</th>
                                            <th>Created at</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     @foreach($data['entertainer'] as $entertainer_details)


                                            {{-- @dd($entertainer->title) --}}
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $entertainer_details->title }}</td>
                                                <td>{{ $entertainer_details->category }}</td>
                                                <td>$ {{ $entertainer_details->price }}</td>
                                                <td>{{ $entertainer_details->description }}</td>
                                                <td>{{ $entertainer_details->created_at }}</td>

                                                <td
                                                style="display: flex;align-items: center;justify-content: center;column-gap: 8px">
                                                {{-- <a class="btn btn-success"
                                               href="{{route('entertainer.edit', $entertainer->id)}}">Categories</a> --}}
                                               <a class="btn btn-primary"
                                               href="{{route('entertainer.photo.show', $entertainer_details->id)}}">Photos</a>
                                               <a class="btn btn-success"
                                               href="{{route('entertainer.talent.price_packages.index', $entertainer_details->id)}}">Packages</a>
                                                <a class="btn btn-info"
                                               href="{{route('entertainer.talent.edit',['user_id'=>$data['user_id'],'entertainer_details_id'=>$entertainer_details->id])}}">Edit</a>
                                                        <form method="get" action="{{ route('entertainer.talent.delete', $entertainer_details->id) }}">
                                                            @csrf
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <button type="submit" class="btn btn-danger btn-flat show_confirm" data-toggle="tooltip" >Delete</button>
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
        $('#table_id_talent').DataTable();
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
