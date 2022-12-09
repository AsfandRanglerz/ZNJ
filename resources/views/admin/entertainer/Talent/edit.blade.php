@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
    <body>
        <div class="main-content">
            <section class="section">
                <div class="section-body">

                    <a class="btn btn-primary mb-2"
                    href="{{route('entertainer.show',$data['user_id'])}}">Back</a>
                    {{-- @dd($data) --}}
                    <form id="add_student" action="{{ route('entertainer.talent.update',$data['entertainer_talent']['id']) }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <h4 class="text-center my-4">Edit Talent</h4>
                                    <div class="row mx-0 px-4" id="edit_entertainer_row">
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label> Title </label>
                                                <input type="text" placeholder="example" name="title" id="title" Value="{{ $data['entertainer_talent']['title'] }}" class="form-control">
                                                @error('title')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-2">
                                            <div class="form-group mb-3">
                                                <label>Talent Category</label>
                                                <select name="category" id="category"  class="form-control">
                                                    <option value="">Please Select a Category </option>
                                                        @foreach($data['talent_categories'] as $category)
                                                        <option value="{{$category->category}}"
                                                            {{-- @dd($data['talent_categories']) --}}
                                                            {{ str_contains($data['entertainer_talent']['category'],$category->category)? 'selected' : ''  }}>{{$category->category}}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                            @error('category')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        </div>

                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Price</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2">$</span>
                                                    </div>
                                                    <input type="number" class="form-control" placeholder="Price" aria-label="Price" name="price" Value="{{ $data['entertainer_talent']['price'] }}" aria-describedby="basic-addon2">
                                                </div>
                                                @error('price')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Feature Ads</label>
                                                @if($data['entertainer_talent']['feature_status']==='0')
                                                <input type="checkbox"  name="feature_ads" data-toggle="toggle"
                                                    data-on="Featured"
                                                    data-toggle="tooltip" data-off="Unfeatured" data-onstyle="success"
                                                    data-offstyle="danger">
                                                </div>
                                            </div>
                                                    @else
                                                    <input type="checkbox"  name="feature_ads" data-toggle="toggle"
                                                    data-on="Featured"
                                                    data-toggle="tooltip" data-off="Unfeatured" data-onstyle="success"
                                                    data-offstyle="danger" checked>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3"  id='edit_feature_packages'>
                                            <div class="form-group mb-2">
                                                <label>Select Feature Package</label>
                                                <select name="entertainer_feature_ads_packages_id" class="form-control">
                                                    <option value=''>Please Select Package</option>
                                                    @foreach($data['entertainer_feature_ads_packages'] as $feature)
                                                    <option value="{{ $feature->id }}" {{ str_contains($data['entertainer_talent']['entertainer_feature_ads_packages_id'],$feature->id)? 'selected' : ''  }}>{{ $feature->title }} - $ {{ $feature->price }} - {{ $feature->validity }}</option>
                                                    @endforeach
                                               </select>

                                                @error('entertainer_feature_ads_packages_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>
                                        @endif

                                    </div>
                                    <div class="card-footer text-center row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-success mr-1 btn-bg"
                                                id="submit">Update</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.toggle').click(function (e) {
                e.preventDefault();
        if($('.toggle').hasClass('btn-danger')){
          swal({
              title: `Are you sure you want to Feature this Ad?`,
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willFeature) => {
            if (willFeature) {
                $(this).removeClass("btn-danger");
                $(this).removeClass("off");
                $(this).addClass("btn-success");
                $('#edit_feature_packages').remove();
                $('#edit_entertainer_row').append(`<div class="col-sm-6 pl-sm-0 pr-sm-3"  id='edit_feature_packages'>
                                            <div class="form-group mb-2">
                                                <label>Select Feature Package</label>
                                                <select name="entertainer_feature_ads_packages_id" class="form-control">
                                                    <option value=''>Please Select Package</option>
                                                    @foreach($data['entertainer_feature_ads_packages'] as $feature)
                                                    <option value="{{ $feature->id }}" {{ str_contains($data['entertainer_talent']['entertainer_feature_ads_packages_id'],'$feature->id')? 'selected' : ''  }}>{{ $feature->title }} - $ {{ $feature->price }} - {{ $feature->validity }}</option>
                                                    @endforeach
                                               </select>

                                                @error('entertainer_feature_ads_packages_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>`)
            }else{
                $('#edit_feature_packages').remove();
                $(this).removeClass("btn-success");
                $(this).addClass("btn-danger");
                $(this).addClass("off");
            }
          });
        }else{
            swal({
              title: `Are you sure you want to Unfeature this Ad?`,
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willUnfeature) => {
            if (willUnfeature) {
                $(this).removeClass("btn-success");
                $(this).addClass("btn-danger");
                $(this).addClass("off");
                $('#edit_feature_packages').remove();
            }else{
                $(this).removeClass("btn-danger");
                $(this).removeClass("off");
                $(this).addClass("btn-success");
                $('#edit_feature_packages').remove();
                $('#edit_entertainer_row').append(`<div class="col-sm-6 pl-sm-0 pr-sm-3" id='edit_feature_packages'>
                                            <div class="form-group mb-2">
                                                <label>Select Feature Package</label>
                                                <select name="entertainer_feature_ads_packages_id" class="form-control">
                                                    <option value=''>Please Select Package</option>
                                                    @foreach($data['entertainer_feature_ads_packages'] as $feature)
                                                    <option value="{{ $feature->id }}" {{ str_contains($data['entertainer_talent']['entertainer_feature_ads_packages_id'],'$feature->id')? 'selected' : ''  }}>{{ $feature->title }} - $ {{ $feature->price }} - {{ $feature->validity }}</option>
                                                    @endforeach
                                               </select>
                                                @error('entertainer_feature_ads_packages_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>`)
            }
          });


        }

            });
        });
    </script>

@endsection
