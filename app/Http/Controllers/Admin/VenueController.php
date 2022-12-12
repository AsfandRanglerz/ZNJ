<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Venue;
use App\Models\VenuesPhoto;
use App\Models\VenueFeatureAdsPackage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\UserLoginPassword;
use App\Models\VenueCategory;
use App\Models\VenuePricing;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;



class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.venue_provider.add');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'phone' => 'required',
        ]);
        $data = $request->only(['name', 'email', 'role', 'phone']);
            $data['role'] = 'venue_provider';
            $messages['password'] = random_int(10000000, 99999999);
            $messages['email'] = $request->email;
            $data['password'] = Hash::make($messages['password']);
            try {
            Mail::to($request->email)->send(new UserLoginPassword($messages));
            $user = User::create($data);
                return redirect()->route('admin.user.index')->with(['status'=>true, 'message' => 'Venue Provider Created sucessfully']);
            } catch (\Throwable $th) {
                return back()
                ->with(['status' => false, 'message'=>'Unexpected error occured']);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        // dd($user_id,$venue_id);
         //  Showing Entertainer Talent

         $data['venue']= Venue::with('venueCategory')->where('user_id',$user_id)->latest()->get();
        //  dd($data);
         $data['user_id']=$user_id;
         return view('admin.venue_provider.venues.index',compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        $venue=User::find($user_id);
        return view('admin.venue_provider.edit',compact('venue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
           $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',

    ]);
        $recruiter=User::find($user_id);

        $recruiter->name=$request->input('name');
        $recruiter->email=$request->input('email');
        $recruiter->phone=$request->input('phone');
        $recruiter->venue=$request->input('venue');
        $recruiter->update();

        return redirect()->route('admin.user.index')->with(['status'=>true, 'message' => 'Venue Provider Updated sucessfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        User::destroy($user_id);
        return redirect()->back()->with(['status'=>true, 'message' => 'Venue Provider Deleted sucessfully']);
    }

    public function createVenueIndex($user_id)
    {
        $data['user_id'] = $user_id;
        $data['venue_categories']=VenueCategory::select('id','category')->get();
        $data['venue_feature_ads_packages']=VenueFeatureAdsPackage::select('id','title','price','validity')->get();
        return view('admin.venue_provider.venues.add',compact('data'));
    }
    public function storeVenue(Request $request,$user_id)

    {
        if($request->has('venue_feature_ads_packages_id')){
        $validator = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
            'seats' => 'required',
            'stands' => 'required',
            'opening_time' =>'required',
            'closing_time' =>'required',
            'venue_feature_ads_packages_id' => 'required',
        ]);
        $data = $request->only(['title','user_id', 'category', 'description','seats','stands','opening_time','closing_time','venue_feature_ads_packages_id']);
        $data['feature_status']=1;
        $data['amenities'] = implode(',', $request->amenities);
            $data['user_id'] = $user_id;
            $user = Venue::create($data);
            if ($request->file('photos')) {
                foreach ($request->file('photos') as $data) {
                    $image = hexdec(uniqid()) . '.' . strtolower($data->getClientOriginalExtension());
                    $data->move('public/admin/assets/img/venue', $image);
                    VenuesPhoto::create([
                            'photos' => '' . $image,
                            'venue_id' => $user->id
                           ]);
                }
            }
            return redirect()->route('venue.show',$user->user_id)->with(['status'=>true, 'message' => 'Venue Created sucessfully']);
        }else{
        $validator = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
            'seats' => 'required',
            'stands' => 'required',
            'opening_time' =>'required',
            'closing_time' =>'required',
        ]);
        $data = $request->only(['title','user_id', 'category', 'description','seats','stands','opening_time','closing_time']);
        $data['amenities'] = implode(',', $request->amenities);
            $data['user_id'] = $user_id;
            $user = Venue::create($data);
            if ($request->file('photos')) {
                foreach ($request->file('photos') as $data) {
                    $image = hexdec(uniqid()) . '.' . strtolower($data->getClientOriginalExtension());
                    $data->move('public/admin/assets/img/venue', $image);
                    VenuesPhoto::create([
                            'photos' => '' . $image,
                            'venue_id' => $user->id
                           ]);
                }
            }
            return redirect()->route('venue.show',$user->user_id)->with(['status'=>true, 'message' => 'Venue Created sucessfully']);
        // return view('admin.entertainer.Talent.add');
    }

}
    public function destroyVenue($user_id)
    {
        $data=Venue::destroy($user_id);
        // return redirect()->route('admin.venue_provider.venues.index',$id)->with(['status'=>true, 'message' => 'Venue Deleted sucessfully']);
        return redirect()->back()->with(['status'=>true, 'message' => 'Venue Deleted sucessfully']);
    }

    public function editVenue($user_id, $venue_id)
    {
        //$data['user_id'] = EntertainerDetail::find($id);
        $venue['venue']=Venue::find($venue_id);
        $venue['venue_categories']=VenueCategory::select('id','category')->get();
        $venue['venue_feature_ads_packages']=VenueFeatureAdsPackage::select('id','title','price','validity')->get();
        $venue['user_id'] = $user_id;
        return view('admin.venue_provider.venues.edit',compact('venue'));
    }
    public function updateVenue(Request $request, $user_id)
    {
        if($request->venue_feature_ads_packages_id !==null && $request->feature_ads==='on'){
        $validator = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
            'seats' => 'required',
            'stands' => 'required',
            'opening_time' => 'required',
            'closing_time'=>'required',

        ]);

        $talent = Venue::find($user_id);
        $talent->title=$request->input('title');
        $talent->category=$request->input('category');
        $talent->description=$request->input('description');
        $talent->seats=$request->input('seats');
        $talent->stands=$request->input('stands');
        $talent->opening_time=$request->input('opening_time');
        $talent->closing_time=$request->input('closing_time');
        $talent->amenities = implode(',', $request->amenities);
        $talent->venue_feature_ads_packages_id=$request->venue_feature_ads_packages_id;
        $talent->feature_status =1;
        $talent->update();
        return redirect()->route('venue.show',$talent->user_id)->with(['status'=>true, 'message' => 'Venue Updated sucessfully']);
    }else if ($request->venue_feature_ads_packages_id ===null && $request->feature_ads==='on'){
        // @dd($request->input());
        return redirect()->back()->with(['status'=>false, 'message' => 'Feature Package Must Be Selected']);
    }else{
        // dd($request->all());
        $validator = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
            'seats' => 'required',
            'stands' => 'required',
            'opening_time' => 'required',
            'closing_time'=>'required',

        ]);

        $talent = Venue::find($user_id);
        $talent->title=$request->input('title');
        $talent->category=$request->input('category');
        $talent->description=$request->input('description');
        $talent->seats=$request->input('seats');
        $talent->stands=$request->input('stands');
        $talent->opening_time=$request->input('opening_time');
        $talent->closing_time=$request->input('closing_time');
        $talent->amenities = implode(',', $request->amenities);
        $talent->venue_feature_ads_packages_id=null;
        $talent->feature_status =0;
        $talent->update();
        return redirect()->route('venue.show',$talent->user_id)->with(['status'=>true, 'message' => 'Venue Updated sucessfully']);
    }

    }
    public function venueCategoriesIndex(){
        $data= VenueCategory::select('id','category')->latest()->get();
        return view('admin.Categories.Venue.index',compact('data'));
    }
    public function venueCategoryStore(Request $request){
        $validator =$request->validate([
            'category' => 'required',
        ]);
        $data = $request->only(['category']);
        $data = VenueCategory::create($data);
        return redirect()->route('venue-providers.venue.categories.index')->with(['status'=>true, 'message' => 'Venue Category Created sucessfully']);
    }
    public function venueCategoryEditIndex($category_id){
        $data = VenueCategory::select('id','category')->where('id',$category_id)->first();
       return view('admin.Categories.Venue.edit',compact('data'));
    }
    public function updateVenueCategory(Request $request,$category_id){
        $validator =$request->validate([
            'category' => 'required',
        ]);
        $venue_category = VenueCategory::find($category_id);
        $venue_category->category=$request->category;
        $venue_category->update();
        return redirect()->route('venue-providers.venue.categories.index')->with(['status'=>true, 'message' => 'Venue Category Updated sucessfully']);
    }
    public function destroyVenueCategory($category_id){
        VenueCategory::destroy($category_id);
        return redirect()->back()->with(['status'=>true, 'message' => 'Category Deleted sucessfully']);
    }
    //Photos
    public function showPhoto($venue_id)
    {
        //  Showing Entertainer Talent
        $data['user_id']=VenuesPhoto::where('venue_id',$venue_id)->latest()->get();
        // dd($data['user_id']);
        $data['venue_id']=$venue_id;
        return view('admin.venue_provider.venues.photo.index',compact('data'));
    }
    //Photo
    public function destroyPhoto($venue_id)
    {

        VenuesPhoto::destroy($venue_id);
        return redirect()->back()->with(['status'=>true, 'message' => 'Photo Deleted sucessfully']);
    }
    public function editPhoto($venue_id)
    {
        //$data['user_id'] = EntertainerDetail::find($id);
        $photo=VenuesPhoto::find($venue_id);
        $photo['venue_id'] = $venue_id;
        //dd( $photo['user_id']);
        return view('admin.venue_provider.venues.photo.edit',compact('photo'));
    }
    public function updatePhoto(Request $request, $venue_id)
    {
        $validator = $request->validate([
            'photos' => 'required',
            // 'description' => 'required',
            // 'images'=>'required',
        ]);
        $photo=VenuesPhoto::find($venue_id);
        if ($request->hasfile('photos')) {
            $file = $request->file('photos');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('admin/assets/img/venue/'), $filename);
            $photo->photos = '' . $filename;
        }
        $photo->update();
        return redirect()->route('venue-providers.venue.photo.show',$photo->venue_id)->with(['status'=>true, 'message' => 'Photo Updated sucessfully']);
}
public function pricePackagesIndex($user_id,$venue_id){
    $data['price_packages']=VenuePricing::where('venues_id',$venue_id)->latest()->get();
    $data['venue_id']=$venue_id;
    $data['user_id']= $user_id;

    // dd($data['price_packages']);
    return view('admin.venue_provider.venues.Price_packages.index',compact('data'));
}
public function createPricePackageIndex($user_id,$venue_id){
    // return dd($venue_id);
    $data['venue_id']=$venue_id;
    $data['user_id']=$user_id;
    return view('admin.venue_provider.venues.Price_packages.add',compact('data'));
}
public function storePricePackage(Request $request,$user_id,$venue_id){
    $validator =$request->validate([
        'price'=>'required',
        'day'=>'required'
    ]);
    $data = $request->only(['price', 'day']);
    $data['venues_id']=$venue_id;
    $user = VenuePricing::create($data);
            return redirect()->route('venue-providers.venue.venue_pricings.index',['user_id'=>$venue_id,'venue_id'=>$venue_id])->with(['status'=>true, 'message' => 'Price Package Created Sucessfully']);
}
public function editPricePackageIndex($user_id,$venue_pricing_id){
    $data['price_package']= VenuePricing::where('id',$venue_pricing_id)->first();
    $data['user_id']= $user_id;
    return view('admin.venue_provider.venues.Price_packages.edit',compact('data'));
}
public function updatePricePackage(Request $request,$user_id,$venue_pricing_id){
    $validator =$request->validate([
        'price'=>'required',
        'day'=>'required'
    ]);
    // dd($request->time);
    $price_package=VenuePricing::find($venue_pricing_id);
    $price_package->price=$request->input('price');
    $price_package->day=$request->input('day');
    $price_package->update();
    return redirect()->route('venue-providers.venue.venue_pricings.index',['user_id'=>$user_id,'venue_id'=>$price_package['venues_id']])->with(['status'=>true, 'message' => 'Price Package Updated Sucessfully']);
}
public function destroyPricePackage($venue_pricing_id){
    VenuePricing::where('id',$venue_pricing_id)->delete();
    return redirect()->back()->with(['status'=>true, 'message' => 'Price Package Deleted Sucessfully']);

}
}
