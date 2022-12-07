<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EntertainerDetail;
use App\Models\EntertainerEventPhotos;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TalentCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserLoginPassword;
use App\Models\EntertainerPricePackage;

class EntertainerController extends Controller
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
        return view('admin.entertainer.add');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator =$request->validate([
            'name'=>'required',
            'email'=>'required|unique:users,email|email',
            'phone'=>'required',
            // 'password'=>'required|confirmed',
            // 'password_confirmation'=>'required'
        ]);
        $data = $request->only(['name', 'email', 'role', 'phone']);
            $data['role'] = 'entertainer';
            $messages['password'] = random_int(10000000, 99999999);
            $messages['email'] = $request->email;
            $data['password'] = Hash::make($messages['password']);
            try {
            Mail::to($request->email)->send(new UserLoginPassword($messages));
            $user = User::create($data);
                return redirect()->route('admin.user.index')->with(['status'=>true, 'message' => 'Entertainer Created sucessfully']);
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

    /** */
    public function show($user_id)
    {
        $data['entertainer']=EntertainerDetail::where('user_id',$user_id)->latest()->get();
        $data['user_id']=$user_id;
        return view('admin.entertainer.Talent.index',compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        $entertainer=User::find($user_id);
        return view('admin.entertainer.edit',compact('entertainer'));
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
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required',

        ]);

        $entertainer=User::find($user_id);

        $entertainer->name=$request->input('name');
        $entertainer->email=$request->input('email');
        $entertainer->phone=$request->input('phone');
        $entertainer->update();

        return redirect()->route('admin.user.index')->with(['status'=>true, 'message' => 'Entertainer Updated sucessfully']);
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
        return redirect()->back()->with(['status'=>true, 'message' => 'Entertainer Deleted sucessfully']);
    }

      /**
     * Show the form for creating a new Talent for Specific Entertainer.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTalentIndex($user_id)
    {
        $data['user_id'] = $user_id;
        $data['talent_categories']=TalentCategory::select('id','category')->get();
        return view('admin.entertainer.Talent.add',compact('data'));
    }
    public function storeTalent(Request $request,$user_id)

    {
        if($request->has('entertainer_feature_ads_packages_id')){
        $validator = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'price' => 'required',
            'entertainer_feature_ads_packages_id' => 'required',
            // 'images'=>'required',
        ]);
        $data = $request->only(['title','user_id', 'category', 'price','entertainer_feature_ads_packages_id']);
        $data['feature_status']=1;

        $data['user_id'] = $user_id;
        $user = EntertainerDetail::create($data);
        if ($request->file('event_photos')) {
            foreach ($request->file('event_photos') as $data) {
                $image = hexdec(uniqid()) . '.' . strtolower($data->getClientOriginalExtension());
                $data->move('public/admin/assets/img/entertainer', $image);
                EntertainerEventPhotos::create([
                        'event_photos' => '' . $image,
                        'entertainer_details_id' => $user->id
                       ]);
            }
        }
         return redirect()->route('entertainer.show',$user_id)->with(['status'=>true, 'message' => 'Talent Created sucessfully']);
    }else{
        $validator = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'price' => 'required',
            // 'images'=>'required',
        ]);
        $data = $request->only(['title','user_id', 'category', 'price']);
        //  If admin unfeatured the featured add
        $data['user_id'] = $user_id;
        $user = EntertainerDetail::create($data);
        if ($request->file('event_photos')) {
            foreach ($request->file('event_photos') as $data) {
                $image = hexdec(uniqid()) . '.' . strtolower($data->getClientOriginalExtension());
                $data->move('public/admin/assets/img/entertainer', $image);
                EntertainerEventPhotos::create([
                        'event_photos' => '' . $image,
                        'entertainer_details_id' => $user->id
                       ]);
            }
        }
         return redirect()->route('entertainer.show',$user_id)->with(['status'=>true, 'message' => 'Talent Created sucessfully']);

    }
        // return view('admin.entertainer.Talent.add');

}
    public function destroyTalent($user_id)
    {

        EntertainerDetail::destroy($user_id);
        return redirect()->back()->with(['status'=>true, 'message' => 'Talent Deleted sucessfully']);
    }
    public function editTalent($user_id, $entertainer_details_id)
    {
        //$data['user_id'] = EntertainerDetail::find($id);
        $data['entertainer_talent']=EntertainerDetail::find($entertainer_details_id);
        // $data['user_id'] = $entertainer_details_id;
        $data['user_id'] = $user_id;
        return view('admin.entertainer.Talent.edit',compact('data'));
    }
    public function updateTalent(Request $request, $user_id)
    {
        // dd($request->input());

        if($request->entertainer_feature_ads_packages_id !=='null' && $request->feature_ads==='on'){
        $validator=$request->validate([
            'title' => 'required',
            'category' => 'required',
            'price' => 'required',
            // 'images'=>'required',
        ]);
        $talent=EntertainerDetail::find($user_id);
        $talent->title=$request->input('title');
        $talent->category=$request->input('category');
        $talent->price=$request->input('price');
        $talent->entertainer_feature_ads_packages_id=$request->input('entertainer_feature_ads_packages_id');
        $talent->feature_status =1;
        $talent->update();
        return redirect()->route('entertainer.show',$talent->user_id)->with(['status'=>true, 'message' => 'Talent Updated successfully']);
    }else if ($request->entertainer_feature_ads_packages_id ==='null' && $request->feature_ads==='on'){
        // @dd($request->input());
        return redirect()->back()->with(['status'=>false, 'message' => 'Feature Package Must Be Selected']);
    }else{
        // @dd($request->input());
        $validator=$request->validate([
            'title' => 'required',
            'category' => 'required',
            'price' => 'required',
            // 'images'=>'required',
        ]);
        $talent=EntertainerDetail::find($user_id);
        $talent->title=$request->input('title');
        $talent->category=$request->input('category');
        $talent->price=$request->input('price');
        $talent->entertainer_feature_ads_packages_id=null;
        $talent->feature_status=0;
        $talent->update();
        return redirect()->route('entertainer.show',$talent->user_id)->with(['status'=>true, 'message' => 'Talent Updated successfully']);

    }

    }

    public function showPhoto($entertainer_details_id)
    {
        //  Showing Entertainer Talent
        $data['user_id']=EntertainerEventPhotos::where('entertainer_details_id',$entertainer_details_id)->latest()->get();
        // dd($data['user_id']);
        $data['entertainer_details_id']=$entertainer_details_id;
        // dd($data['user_id']);
        return view('admin.entertainer.Talent.Photo.index',compact('data'));

    }
    //Photo
    public function destroyPhoto($entertainer_details_id)
    {

        EntertainerEventPhotos::destroy($entertainer_details_id);
        return redirect()->back()->with(['status'=>true, 'message' => 'Photo Deleted sucessfully']);
    }
    public function editPhoto($entertainer_details_id)
    {
        //$data['user_id'] = EntertainerDetail::find($id);
        $photo=EntertainerEventPhotos::find($entertainer_details_id);
        $photo['entertainer_details_id'] = $entertainer_details_id;
        return view('admin.entertainer.Talent.Photo.edit',compact('photo'));
    }
    public function updatePhoto(Request $request, $entertainer_details_id)
    {
        $validator = $request->validate([
            'event_photos' => 'required',
            // 'description' => 'required',
            // 'images'=>'required',
        ]);
        $photo = EntertainerEventPhotos::find($entertainer_details_id);
        if ($request->hasfile('event_photos')) {
            $file = $request->file('event_photos');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('admin/assets/img/entertainer/'), $filename);
            $photo->event_photos = '' . $filename;
        }
        $photo->update();
        return redirect()->route('entertainer.photo.show',$photo->entertainer_details_id)->with(['status'=>true, 'message' => 'Photo Updated sucessfully']);

}
/**
     * Talent Categories
     *
     *
     *
     */
    public function talentCategoriesIndex(){
        $data= TalentCategory::select('id','category')->latest()->get();
        return view('admin.Categories.Talent.index',compact('data'));
    }
    public function talentCategoryStore(Request $request){
        $validator =$request->validate([
            'category' => 'required',
        ]);
        $data = $request->only(['category']);
        $data = TalentCategory::create($data);
        return redirect()->route('entertainer.talent.categories.index')->with(['status'=>true, 'message' => 'Talent Category Created sucessfully']);
    }
    public function talentCategoryEditIndex($category_id){
        $data = TalentCategory::select('id','category')->where('id',$category_id)->first();
       return view('admin.Categories.Talent.edit',compact('data'));
    }
    public function updateTalentCategory(Request $request,$category_id){
        $validator =$request->validate([
            'category' => 'required',
        ]);
        $talent_category = TalentCategory::find($category_id);
        $talent_category->category = $request->category;
        $talent_category->update();
        return redirect()->route('entertainer.talent.categories.index')->with(['status'=>true, 'message' => 'Talent Category Updated sucessfully']);
    }
    public function destroyTalentCategory($category_id){
        TalentCategory::destroy($category_id);
        return redirect()->back()->with(['status'=>true, 'message' => 'Category Deleted sucessfully']);
    }
    public function pricePackagesIndex($entertainer_details_id){
        $data['price_packages']=EntertainerPricePackage::where('entertainer_details_id',$entertainer_details_id)->latest()->get();
        $data['entertainer_details_id']=$entertainer_details_id;
        // $data['user_id']= $user_id;
        return view('admin.entertainer.Talent.Price_packages.index',compact('data'));
    }
    public function createPricePackageIndex($entertainer_details_id){
        $data['entertainer_details_id']=$entertainer_details_id;
        return view('admin.entertainer.Talent.Price_packages.add',compact('data'));
    }
    public function storePricePackage(Request $request,$entertainer_details_id){
        $validator =$request->validate([
            'price_package'=>'required',
            'time'=>'required'
        ]);
        $data = $request->only(['entertainer_details_id','price_package', 'time']);
        $data['entertainer_details_id']=$entertainer_details_id;
        $user = EntertainerPricePackage::create($data);
                return redirect()->route('entertainer.talent.price_packages.index',$entertainer_details_id)->with(['status'=>true, 'message' => 'Price Package Created Sucessfully']);
    }
    public function editPricePackageIndex($price_package_id){
        $data['price_package']= EntertainerPricePackage::where('id',$price_package_id)->select('id','price_package','time')->first();
        return view('admin.entertainer.Talent.Price_packages.edit',compact('data'));
    }
    public function updatePricePackage(Request $request,$price_package_id){
        $validator =$request->validate([
            'price_package'=>'required',
            'time'=>'required'
        ]);
        // dd($request->time);
        $price_package=EntertainerPricePackage::find($price_package_id);
        $price_package->price_package=$request->input('price_package');
        $price_package->time=$request->input('time');
        $price_package->update();
        return redirect()->route('entertainer.talent.price_packages.index',$price_package['entertainer_details_id'])->with(['status'=>true, 'message' => 'Price Package Updated Sucessfully']);
    }
    public function destroyPricePackage($price_package_id){
        EntertainerPricePackage::where('id',$price_package_id)->delete();
        return redirect()->back()->with(['status'=>true, 'message' => 'Price Package Deleted Sucessfully']);
    }
}
