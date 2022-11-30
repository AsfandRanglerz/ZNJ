@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
    <body>
        <div class="main-content">
            <section class="section">
                <div class="section-body">
                    {{-- @dd($data['price_package']) --}}
                    <form id="add_student" action="{{ route('venue-providers.venue.venue_pricings.update',$data['price_package']['id']) }}" name="form" method="POST" enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <h4 class="text-center my-4">Edit Price Package</h4>
                                    <div class="row mx-0 px-4">
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Price</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2">PKR</span>
                                                    </div>
                                                    <input type="number" class="form-control" placeholder="Price" aria-label="Price" name="price" Value="{{ $data['price_package']['price'] }}" aria-describedby="basic-addon2">
                                                </div>
                                                @error('price')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group">
                                                <label>Day</label>
                                                <select name="day"  class="form-control">
                                                    @if($data['price_package']['day']==='Monday')

                                                    <option value="">Please Select a Category </option>
                                                    <option value="Monday" selected>Monday</option>
                                                    <option value="Tuesday">Tuesday</option><option value="Wednesday">Wednesday</option>
                                                    <option value="Thursday">Thursday</option>
                                                    <option value="Friday">Friday</option>
                                                    <option value="Saturday">Saturday</option>
                                                    <option value="Sunday">Sunday</option>
                                                    @elseif ($data['price_package']['day']==='Tuesday')
                                                    <option value="">Please Select a Category </option>
                                                    <option value="Monday" >Monday</option>
                                                    <option value="Tuesday"selected>Tuesday</option><option value="Wednesday">Wednesday</option>
                                                    <option value="Thursday">Thursday</option>
                                                    <option value="Friday">Friday</option>
                                                    <option value="Saturday">Saturday</option>
                                                    <option value="Sunday">Sunday</option>
                                                    @elseif ($data['price_package']['day']==='Wednesday')
                                                    <option value="">Please Select a Category </option>
                                                    <option value="Monday" selected>Monday</option>
                                                    <option value="Tuesday">Tuesday</option><option value="Wednesday"selected>Wednesday</option>
                                                    <option value="Thursday">Thursday</option>
                                                    <option value="Friday">Friday</option>
                                                    <option value="Saturday">Saturday</option>
                                                    <option value="Sunday">Sunday</option>
                                                    @elseif ($data['price_package']['day']==='Thursday')
                                                    <option value="">Please Select a Category </option>
                                                    <option value="Monday" selected>Monday</option>
                                                    <option value="Tuesday">Tuesday</option><option value="Wednesday">Wednesday</option>
                                                    <option value="Thursday"selected>Thursday</option>
                                                    <option value="Friday">Friday</option>
                                                    <option value="Saturday">Saturday</option>
                                                    <option value="Sunday">Sunday</option>
                                                    @elseif ($data['price_package']['day']==='Friday')
                                                    <option value="">Please Select a Category </option>
                                                    <option value="Monday" selected>Monday</option>
                                                    <option value="Tuesday">Tuesday</option><option value="Wednesday">Wednesday</option>
                                                    <option value="Thursday">Thursday</option>
                                                    <option value="Friday"selected>Friday</option>
                                                    <option value="Saturday">Saturday</option>
                                                    <option value="Sunday">Sunday</option>
                                                    @elseif ($data['price_package']['day']==='Saturday')
                                                    <option value="">Please Select a Category </option>
                                                    <option value="Monday" selected>Monday</option>
                                                    <option value="Tuesday">Tuesday</option><option value="Wednesday">Wednesday</option>
                                                    <option value="Thursday">Thursday</option>
                                                    <option value="Friday">Friday</option>
                                                    <option value="Saturday"selected>Saturday</option>
                                                    <option value="Sunday">Sunday</option>
                                                    @elseif ($data['price_package']['day']==='Sunday')
                                                    <option value="">Please Select a Category </option>
                                                    <option value="Monday" selected>Monday</option>
                                                    <option value="Tuesday">Tuesday</option><option value="Wednesday">Wednesday</option>
                                                    <option value="Thursday">Thursday</option>
                                                    <option value="Friday">Friday</option>
                                                    <option value="Saturday">Saturday</option>
                                                    <option value="Sunday"selected>Sunday</option>
                                                    @else
                                                    <option value="">Please Select a Category </option>
                                                    <option value="Monday" selected>Monday</option>
                                                    <option value="Tuesday">Tuesday</option><option value="Wednesday">Wednesday</option>
                                                    <option value="Thursday">Thursday</option>
                                                    <option value="Friday">Friday</option>
                                                    <option value="Saturday">Saturday</option>
                                                    <option value="Sunday">Sunday</option>
                                                    @endif
                                                    </select>
                                                @error('day')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            </div>

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
<script>
//     var inputEle = document.getElementById('timeInput');

// function onTimeChange(){
// const a=document.getElementById("timeInput").value;
// console.log('thisssssssssss',a.split(':'));
// }
// function onTimeChange() {
//   var timeSplit = inputEle.value.split(':'),
//     hours,
//     minutes,
//     meridian;
//   hours = timeSplit[0];
//   minutes = timeSplit[1];
//   if (hours > 12) {
//     meridian = 'PM';
//     hours -= 12;
//   } else if (hours < 12) {
//     meridian = 'AM';
//     if (hours == 0) {
//       hours = 12;
//     }
//   } else {
//     meridian = 'PM';
//   }
// //   alert(hours + ':' + minutes + ' ' + meridian);
// ish=hours + ':' + minutes + ' ' + meridian
// document.forms['form']['time'].value = ish;
// document.getElementById("timeInput").value = ish ;

// $(document).ready(function () {
// alert($('#timeInput').val(hours + ':' + minutes + ' ' + meridian))


// });

// }
</script>

@endsection
