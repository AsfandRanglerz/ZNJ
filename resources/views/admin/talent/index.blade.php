@extends('admin.layout.app')

@section('title', 'index')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Add Talent</h4>
                            </div>
                            <form action="{{route('talent.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Category Name</label>
                                        <input type="text" class="form-control" name="category" required>
                                        @error('Category Name')
                                        <div class="text-danger p-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary mr-1" type="submit">Add Talent</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Services <small class="font-weight-bold">(Note: You can drag and drop the services
                                        as per priority...)</small></h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Sr.</th>
                                                <th class="text-center">Category</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $talent)


                                                   {{-- @dd($entertainer->title) --}}
                                                   <tr>
                                                       <td >{{ $loop->iteration }}</td>
                                                       <td >{{ $talent->category }}</td>
                                                       <td
                                                       style="display: flex;align-items: center;justify-content: center;column-gap: 8px">
                                                       {{-- <a class="btn btn-success"
                                                      href="{{route('entertainer.edit', $entertainer->id)}}">Categories</a> --}}
                                                      <a class="btn btn-primary"
                                                      href="">Edit</a>
                                                               <form method="get" action="">
                                                                   @csrf
                                                                   <input name="_method" type="hidden" value="DELETE">
                                                                   <button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip" >Delete</button>
                                                               </form>
                                                                  </td>
                                                               </tr>
                                             @endforeach

                                           </tbody>

                                            {{-- @empty
                                                <tr>
                                                    <td colspan="4">Data Not Found!</td>
                                                </tr>
                                            @endforelse --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
