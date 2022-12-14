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
                    <form id="add_student" action="{{ route('entertainer.talent.store',$data['user_id']) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <h4 class="text-center my-4">Add Talent</h4>
                                    <div class="row mx-0 px-4" id='entertainer_row'>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label> Title </label>
                                                <input type="text" placeholder="Title" name="title" id="title" value="{{ old('title') }}" class="form-control">
                                                @error('title')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-2">
                                            <div class="form-group mb-3">
                                                <label>Talent Category</label>
                                                <!-- <input type="text" name="name" id="name"
                                                    class="form-control"
                                                    placeholder="Enter name"> -->
                                                    <select name="category" id="myCategory" value="{{ old('category') }}" class="form-control">
                                                    <option value="">Please Select a Category </option>

                                                        @foreach($data['talent_categories'] as $category)
                                                        <option value="{{$category->id}}">{{$category->category}}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                            @error('category')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Name</label>
                                                <input type="text" placeholder="Name" name="name"  value="{{ old('name') }}" class="form-control">
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>DOB</label>
                                                <input type="date" placeholder="Date of birth" name="dob"  value="{{ old('dob') }}" class="form-control">
                                                @error('dob')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                            <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                                <div class="form-group mb-2">
                                                    <label>Contact</label>
                                                    <input type="tel" name="contact"  value="{{ old('contact') }}"  class="form-control"
                                                    placeholder="92 XXXXXXXXXX (Mobile Number)" >
                                                    @error('contact')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                                <div class="form-group mb-2">
                                                    <label>Country</label>
                                                    <input type="text" placeholder="Country" name="country"  value="{{ old('country') }}" class="form-control">
                                                    @error('country')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                                <div class="form-group mb-2">
                                                    <label>City</label>
                                                    <input type="text" placeholder="city" name="city"  value="{{ old('city') }}" class="form-control">
                                                    @error('city')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                                <div class="form-group mb-2">
                                                    <label>Gender</label>
                                                <div>
                                                    <label>Male</label>
                                                        <input type="radio"value="Male" name="gender" value="{{ old('gender') }}" >
                                                        &nbsp;
                                                    <label>Female</label>
                                                        <input type="radio" value="Female" name="gender" value="{{ old('gender') }}" >
                                                        <label>Others</label>
                                                        <input type="radio" value="Others" name="gender" value="{{ old('gender') }}" >
                                                        @error('gender')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                                <div class="form-group mb-2">
                                                    <label>Nationality</label>
                                                    <input type="text" placeholder="Nationality" name="nationality"  value="{{ old('nationality') }}" class="form-control">
                                                    @error('nationality')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                                <div class="form-group mb-2">
                                                    <label>City</label>
                                                    <input type="text" placeholder="city" name="city"  value="{{ old('city') }}" class="form-control">
                                                    @error('city')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                                <div class="form-group mb-2">
                                                    <label>Awards</label>
                                                    <input type="text" placeholder="No of awards" name="awards"  value="{{ old('awards') }}" class="form-control">
                                                    @error('awards')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                                <div class="form-group mb-2">
                                                    <label>Height</label>
                                                    <input type="text" placeholder="Height" name="height"  value="{{ old('height') }}" class="form-control">
                                                    @error('height')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                                <div class="form-group mb-2">
                                                    <label>Weight</label>
                                                    <input type="text" placeholder="Weight" name="weight"  value="{{ old('weight') }}" class="form-control">
                                                    @error('weight')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                                <div class="form-group mb-2">
                                                    <label>Waist</label>
                                                    <input type="text" placeholder="Waist" name="waist"  value="{{ old('waist') }}" class="form-control">
                                                    @error('waist')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                                <div class="form-group mb-2">
                                                    <label>Shoe Size</label>
                                                    <input type="text" placeholder="Shoe Size" name="shoe_size"  value="{{ old('shoe_size') }}" class="form-control">
                                                    @error('shoe_size')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                                <div class="form-group mb-2">
                                                    <label>Bio</label>
                                                    <input type="text" placeholder="Bio" name="bio"  value="{{ old('bio') }}" class="form-control">
                                                    @error('bio')
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
                                                <label>Choose Images(Multiples)</label>
                                                <input type="file" placeholder="Images" name="event_photos[]" id="images" value="{{ old('event_photos') }}" class="form-control" multiple="multiple">
                                                @error('images')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Feature Ads</label>
                                                <input type="checkbox"  name="featured_ads" data-toggle="toggle"
                                                    data-on="Featured"
                                                    data-toggle="tooltip" data-off="Unfeatured" data-onstyle="success"
                                                    data-offstyle="danger">
                                            </div>
                                        </div>
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

@section ('scripts')
@if (\Illuminate\Support\Facades\Session::has('message'))
<script>
    toastr.success('{{ \Illuminate\Support\Facades\Session::get('message') }}');
</script>
@endif
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script type="text/javascript">
        $(document).on('click','#show_confirm',(function(event) {
        console.log('sss');
        }));
    </script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

    <script>
        $(document).ready(function () {
         // Bind the change event to the dropdown menu
        $("#myCategory").change(function(e) {
        e.preventDefault()
        //  let categoryName = $(this).text();
         var categoryName = $('#myCategory').find(':selected').text();
         console.log(categoryName);
         if (categoryName === '') {

         }



         console.log(selectedValue);

});

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
                $('#feature_packages').remove();
                $('#entertainer_row').append(` <div class="col-sm-6 pl-sm-0 pr-sm-3"  id='feature_packages'>
                                            <div class="form-group mb-2">
                                                <label>Select Feature Package</label>
                                                <select name="entertainer_feature_ads_packages_id" class="form-control">
                                                <option>Please Select Package</option>
                                                @foreach($data['entertainer_feature_ads_packages'] as $feature)
                                                <option value="{{ $feature->id }}">{{ $feature->title }} - $ {{ $feature->price }} - {{ $feature->validity }}</option>
                                                @endforeach
                                               </select>
                                                @error('entertainer_feature_ads_packages_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>`)
            }else{
                $('#feature_packages').remove();
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
                $('#feature_packages').remove();
            }else{
                $(this).removeClass("btn-danger");
                $(this).removeClass("off");
                $(this).addClass("btn-success");
                $('#feature_packages').remove();
                $('#entertainer_row').append(` <div class="col-sm-6 pl-sm-0 pr-sm-3" id='feature_packages'>
                                            <div class="form-group mb-2">
                                                <label>Select Feature Package</label>
                                                <select name="entertainer_feature_ads_packages_id" class="form-control">
                                                <option>Please Select Package</option>
                                                @foreach($data['entertainer_feature_ads_packages'] as $feature)
                                                <option value="{{ $feature->id }}">{{ $feature->title }} - $ {{ $feature->price }} - {{ $feature->validity }}</option>
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
