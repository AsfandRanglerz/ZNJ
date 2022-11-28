<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Venue;
use App\Models\VenuesPhoto;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\UserLoginPassword;
use App\Models\VenueCategory;
use Illuminate\Support\Facades\Mail;
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
        $data = $request->only(['name', 'email', 'role', 'phone', 'password']);
            $data['role'] = 'venue';
            $messages['password'] = random_int(10000000, 99999999);
            $messages['email'] = $request->email;
            $data['password'] = Hash::make($messages['password']);
            try {
            Mail::to($request->email)->send(new UserLoginPassword($messages));
            $user = User::create($data);
                return redirect()->route('admin.user.index')->with(['status'=>true, 'message' => 'Venue Provider Created sucessfully']);
            } catch (\Throwable $th) {
                return $this->sendError('Something Went Wrong');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         //  Showing Entertainer Talent

         $data['venue']= Venue::where('user_id',$id)->get() ;
         $data['user_id']=$id;
         return view('admin.venue_provider.venues.index',compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $venue=User::find($id);
        return view('admin.venue_provider.edit',compact('venue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
           $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',

    ]);
        $recruiter=User::find($id);

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
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->back()->with(['status'=>true, 'message' => 'Venue Provider Deleted sucessfully']);
    }

    public function createVenueIndex($id)
    {
        $data['user_id'] = $id;
        return view('admin.venue_provider.venues.add',compact('data'));
    }
    public function storeVenue(Request $request,$id)

    {
        $validator=$request->validate([
            'title'=>'required',
            'category'=>'required',
            'description'=>'required',
            'seats'=>'required',
            'stands'=>'required',
            // 'offer cattering' => 'required',
            // 'opening time' =>'required',
            // 'closing time' =>'required'
        ]);
        $data = $request->only(['title','user_id', 'category', 'description','seats','stands','offer_cattering','epening_time','closing_time']);
            $data['user_id'] = $id;
            $user = Venue::create($data);
            if ($request->file('photos')) {
                foreach ($request->file('photos') as $data) {
                    $image = hexdec(uniqid()) . '.' . strtolower($data->getClientOriginalExtension());
                    $data->move('public/admin/assets/upload/', $image);
                    VenuesPhoto::create([
                            'photos' => 'public/' . $image,
                            'venue_id' => $user->id
                           ]);
                }
            }
            return redirect()->route('venue.show',$user->user_id)->with(['status'=>true, 'message' => 'Venue Created sucessfully']);
        // return view('admin.entertainer.Talent.add');
    }
    public function destroyVenue($id)
    {
        $data=Venue::destroy($id);
        // return redirect()->route('admin.venue_provider.venues.index',$id)->with(['status'=>true, 'message' => 'Venue Deleted sucessfully']);
        return redirect()->back()->with(['status'=>true, 'message' => 'Venue Deleted sucessfully']);
    }

    public function editVenue($id)
    {
        //$data['user_id'] = EntertainerDetail::find($id);
        $venue=Venue::find($id);
        $venue['user_id'] = $id;
        return view('admin.venue_provider.venues.edit',compact('venue'));
    }
    public function updateVenue(Request $request, $id)
    {
        // dd($request->all());
        $validator = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
            'seats' => 'required',
            'stands' => 'required'
            // 'description' => 'required',
            // 'images'=>'required',
        ]);

        $talent = Venue::find($id);
        $talent->title=$request->input('title');
        $talent->category=$request->input('category');
        $talent->description=$request->input('description');
        $talent->seats=$request->input('seats');
        $talent->stands=$request->input('stands');
        $talent->epening_time=$request->input('epening_time');
        $talent->closing_time=$request->input('closing_time');
        $talent->offer_cattering=$request->input('offer_cattering');
        $talent->update();
        return redirect()->route('venue.show',$talent->user_id)->with(['status'=>true, 'message' => 'Talent Updated sucessfully']);

    }
    public function venueCategoriesIndex(){
        $data= VenueCategory::select('id','category')->get();
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
        $category = VenueCategory::find($category_id);
        $category->category=$request->category;
        $category->update();
        return redirect()->route('venue-providers.venue.categories.index')->with(['status'=>true, 'message' => 'Venue Category Updated sucessfully']);
    }
    public function destroyVenueCategory($category_id){
        VenueCategory::destroy($category_id);
        return redirect()->back()->with(['status'=>true, 'message' => 'Category Deleted sucessfully']);
    }
    //Photos
    public function showPhoto($id)
    {
        //  Showing Entertainer Talent
        $data['user_id']=VenuesPhoto::where('venue_id',$id)->get();
        // dd($data['user_id']);
        $data['venue_id']=$id;
        return view('admin.venue_provider.venues.photo.index',compact('data'));

    }
    //Photo
    public function destroyPhoto($id)
    {

        VenuesPhoto::destroy($id);
        return redirect()->back()->with(['status'=>true, 'message' => 'Photo Deleted sucessfully']);
    }
    public function editPhoto($id)
    {
        //$data['user_id'] = EntertainerDetail::find($id);
        $photo=VenuesPhoto::find($id);
        $photo['venue_id'] = $id;
        //dd( $photo['user_id']);
        return view('admin.venue_provider.venues.photo.edit',compact('photo'));
    }
    public function updatePhoto(Request $request, $id)
    {
        $validator = $request->validate([
            'photos' => 'required',
            // 'description' => 'required',
            // 'images'=>'required',
        ]);
        $photo=VenuesPhoto::find($id);
        if($request->hasfile('photos')){
            $destination=''.$photo->photos;
           // dd($destination);
            if(File::exists($destination))
            {
                File::delete($destination);
            }
        $file = $request->file('photos');
        //dd($file);
        $extension=$file->getClientOriginalExtension();
        $filename=time().'.'.$extension;
        $file->move('',$filename);
        $photo->photos=$filename;
        }
        $photo->update();
        return redirect()->route('admin.venue_provider.venues.photo.index',$photo->venue_id)->with(['status'=>true, 'message' => 'Photo Updated sucessfully']);

}
}
