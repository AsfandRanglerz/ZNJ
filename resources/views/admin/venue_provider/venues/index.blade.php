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
                                <a class="btn btn-success mb-3"
                                       href="{{route('venue-providers.venue.add',$data['user_id'])}}">Add</a>
                                <table class="table" id="table_id_2">
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
                                            {{-- <th scope="col">Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                     @foreach($data['venue'] as $entertainer)


                                            {{-- @dd($entertainer->title) --}}
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $entertainer->title }}</td>
                                                <td>{{ $entertainer->category }}</td>
                                                <td>{{ $entertainer->description }}</td>
                                                <td>{{ $entertainer->seats }}</td>
                                                <td>{{ $entertainer->stands }}</td>
                                                <td>{{ $entertainer->offer_cattering }}</td>
                                                <td>{{ $entertainer->epening_time }}</td>
                                                <td>{{ $entertainer->closing_time }}</td>
                                               <td>{{ $entertainer->created_at }}</td>

                                                {{-- <td
                                                style="display: flex;align-items: center;justify-content: center;column-gap: 8px">
                                                <a class="btn btn-success"
                                               href="{{route('entertainer.edit', $entertainer->id)}}">Categories</a>
                                                <a class="btn btn-info"
                                               href="{{route('entertainer.edit', $entertainer->id)}}">Edit</a>
                                                        <form method="POST" action="{{ route('entertainer.destroy', $entertainer->id) }}">
                                                            @csrf
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip" >Delete</button>
                                                        </form>
                                                           </td> --}}
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
