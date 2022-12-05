@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')

    <body>
        <div class="main-content">
            <section class="section">
                <div class="section-body">
                    <a class="btn btn-primary mb-3"
                    href="{{route('venue.show',$venue['user_id'])}}">Back</a>
                    {{-- @dd($data) --}}
                    <form id="add_student" action="{{ route('venue-providers.venue.update', $venue['id']) }}"
                        method="POST" enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <h4 class="text-center my-4">Edit Venue</h4>
                                    <div class="row mx-0 px-4">
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label> Title </label>
                                                <input type="text" placeholder="example" name="title" id="title"
                                                    Value="{{ $venue['title'] }}" class="form-control">
                                                @error('title')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-2">
                                            <div class="form-group mb-3">
                                                <label>Category</label>
                                                <input type="text" placeholder="example" name="category" id="category"
                                                    Value="{{ $venue['category'] }}" class="form-control" />
                                            </div>
                                            @error('category')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row mx-0 px-4">
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Description</label>
                                                <input type="text" name="description" id="description"
                                                    Value="{{ $venue['description'] }}" class="form-control"
                                                    placeholder="example">
                                                @error('description')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Seats</label>
                                                <input type="number" placeholder="example" name="seats" id="seats"
                                                    Value="{{ $venue['seats'] }}" class="form-control">
                                                @error('seats')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Opening Time</label>
                                                <input type="time" name="opening time" id="opening_time"
                                                    Value="{{ $venue['opening_time'] }}" class="form-control">
                                                @error('opening_time')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Closing Time</label>
                                                <input type="time" placeholder="" name="closing_time" id="closing_time"
                                                    Value="{{ $venue['closing_time'] }}" class="form-control">
                                                @error('closing_time')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- <div class="col-sm-4 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Price</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2">PKR</span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Price" aria-label="Price" name="price" aria-describedby="basic-addon2">
                                                    @error('price')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Stands</label>
                                                <input type="number" placeholder="" name="stands" id="stands"
                                                Value="{{ $venue['stands'] }}" class="form-control">
                                                @error('Stands')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mx-0 px-4 mt-3">
                                            {{-- <select name="amenities[]" value="amenities"
                                           multiselect-select-all="true"> --}}
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Free Parking" {{ str_contains($venue->amenities, 'Free Parking') ? 'checked' : '' }} id="FreeParking">
                                                    <label class="form-check-label" for="FreeParking">
                                                      Free Parking
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input"  name=amenities[] type="checkbox" value="Food & Drinks" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Food&Drinks">
                                                    <label class="form-check-label" for="Food&Drinks">
                                                      Food & Drinks
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Pets Allowed" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="PetsAllowed">
                                                    <label class="form-check-label" for="PetsAllowed">
                                                      Pets Allowed
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Bar" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Bar">
                                                    <label class="form-check-label" for="Bar">
                                                      Bar
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input"  name=amenities[] type="checkbox" value="Security alam" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Securityalam">
                                                    <label class="form-check-label" for="Securityalam">
                                                      Security alam
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Safety deposit box" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Safetydepositbox">
                                                    <label class="form-check-label" for="Safetydepositbox">
                                                      Safety deposit box
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Cattering" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Cattering">
                                                    <label class="form-check-label" for="Cattering">
                                                        Cattering
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Designated smooking area" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Designatedsmookingarea">
                                                    <label class="form-check-label" for="Designatedsmookingarea">
                                                      Designated smooking area
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Non-Smoking" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="NonSmoking">
                                                    <label class="form-check-label" for="NonSmoking">
                                                      Non-Smoking
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Business center" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Businesscenter">
                                                    <label class="form-check-label" for="Businesscenter">
                                                      Business center
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Terrace" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Terrace">
                                                    <label class="form-check-label" for="Terrace">
                                                      Terrace
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input"  name=amenities[] type="checkbox" value="CCTV outside" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="CCTVoutside">
                                                    <label class="form-check-label" for="CCTVoutside">
                                                      CCTV outside
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Amoke alarms" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Amokealarms">
                                                    <label class="form-check-label" for="Amokealarms">
                                                      Amoke alarms
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Lift" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Lift">
                                                    <label class="form-check-label" for="Lift">
                                                      Lift
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value=" Car hire" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Carhire">
                                                    <label class="form-check-label" for="Carhire">
                                                      Car hire
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="ATM/Cash machine" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="ATMCashmachine">
                                                    <label class="form-check-label" for="ATMCashmachine">
                                                      ATM/Cash machine
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Ticket service" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Ticketservice">
                                                    <label class="form-check-label" for="Ticketservice">
                                                      Ticket service
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Velet Parking" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="VeletParking">
                                                    <label class="form-check-label" for="VeletParking">
                                                      Velet Parking
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Wheel chair accessible" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Wheelchairaccessible">
                                                    <label class="form-check-label" for="Wheelchairaccessible">
                                                      Wheel chair accessible
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Shops" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Shops">
                                                    <label class="form-check-label" for="Shops">
                                                      Shops(on site)
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Free Wifi" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="FreeWifi">
                                                    <label class="form-check-label" for="FreeWifi">
                                                      Free Wifi
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Garden" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Garden">
                                                    <label class="form-check-label" for="Garden">
                                                      Garden
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Kids Friendly buffet" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="KidsFriendlybuffet">
                                                    <label class="form-check-label" for="KidsFriendlybuffet">
                                                      Kids Friendly buffet
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value=" Fire extinguisher" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Fireextinguisher">
                                                    <label class="form-check-label" for="Fireextinguisher">
                                                      Fire extinguisher
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="24-hour security" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="security">
                                                    <label class="form-check-label" for="security">
                                                      24-hour security
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Restaurant" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Restaurant">
                                                    <label class="form-check-label" for="Restaurant">
                                                      Restaurant
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Air conditioning" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Airconditioning">
                                                    <label class="form-check-label" for="Airconditioning">
                                                    Air conditioning
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Fax/Photocopy" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="FaxPhotocopy">
                                                    <label class="form-check-label" for="FaxPhotocopy">
                                                      Fax/Photocopy
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value=" Outdoor pool" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Outdoorpool">
                                                    <label class="form-check-label" for="Outdoorpool">
                                                      Outdoor pool
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="on-side cafe house" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="cafehouse">
                                                    <label class="form-check-label" for="cafehouse">
                                                      on-side cafe house
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Special diet" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Specialdiet">
                                                    <label class="form-check-label" for="Specialdiet">
                                                      Special diet
                                                    </label>
                                                  </div>
                                            </div>

                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="CCTV in common area" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="CCTV">
                                                    <label class="form-check-label" for="CCTV">
                                                      CCTV in common area
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Heating" {{ str_contains($venue->amenities, 'Food & Drinks') ? 'checked' : '' }} id="Heating">
                                                    <label class="form-check-label" for="Heating">
                                                        Heating
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Lockers" id="Lockers">
                                                    <label class="form-check-label" for="Lockers">
                                                      Lockers
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="V.I.P room facilities" id="roomfacilities">
                                                    <label class="form-check-label" for="roomfacilities">
                                                      V.I.P room facilities
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Luggage" id="Luggage">
                                                    <label class="form-check-label" for="Luggage">
                                                      Luggage
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Currency exchange" id="Currencyexchange">
                                                    <label class="form-check-label" for="Currencyexchange">
                                                      Currency exchange
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Tour desk" id="Tourdesk">
                                                    <label class="form-check-label" for="Tourdesk">
                                                      Tour desk
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name=amenities[] type="checkbox" value="Baby sitting service" id="Babysittingservice">
                                                    <label class="form-check-label" for="Babysittingservice">
                                                      Baby sitting service
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-sm-3 pl-sm-0 pr-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input"  name=amenities[] type="checkbox" value="Barbar/Beauty shop" id="Beautyshop">
                                                    <label class="form-check-label" for="Beautyshop">
                                                      Barbar/Beauty shop
                                                    </label>
                                                  </div>
                                            </div>


                                        </div>
                                        {{-- <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Choose Images</label>
                                                <input type="file" placeholder="" name="stands" id="stands"  class="form-control"
                                                    >
                                                @error('Stands')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div> --}}
                                        {{-- <div class="col-sm-4 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Offer Cattering</label>
                                                <p>
                                                    <label>Yes</label>
                                                    <input type="radio" name="offer cattering" value="Yes"
                                                    @if($venue['offer_cattering'] == 'Yes')  checked @endif id="">
                                                    <label>No</label>
                                                    <input type="radio" name="offer cattering" value="No" @if($venue['offer_cattering'] == 'No')  checked  @endif  id="">
                                                </p>

                                                @error('offer cattering')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="card-footer text-center row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-success mr-1 btn-bg"
                                                id="submit">Update</button>
                                        </div>
                                    </div>

                                </div>


                                {{-- <div class="row mx-0 px-4">
                                        <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                            <div class="form-group mb-2">
                                                <label>Confirm Password</label>
                                                <input type="password" placeholder="Example" name="password_confirmation" id="password" class="form-control"
                                                    >
                                                @error('password_confirmation')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div> --}}

                            </div>
                        </div>
                </div>
                </form>
        </div>
        </section>
        </div>
    </body>
@endsection

@section('scripts')
    @if (\Illuminate\Support\Facades\Session::has('message'))
        <script>
            toastr.success('{{ \Illuminate\Support\Facades\Session::get('message') }}');
        </script>
    @endif
@endsection
