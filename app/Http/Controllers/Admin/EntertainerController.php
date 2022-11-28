<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EntertainerDetail;
use App\Models\EntertainerEventPhotos;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserLoginPassword;
use App\Models\TalentCategory;
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
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'phone' => 'required',
        ]);
        $data = $request->only(['name', 'email', 'role', 'phone', 'password']);
            $data['role'] = 'entertainer';
            $messages['password'] = random_int(10000000, 99999999);
            $messages['email'] = $request->email;
            $data['password'] = Hash::make($messages['password']);
            try {
            Mail::to($request->email)->send(new UserLoginPassword($messages));
            $user = User::create($data);
                return redirect()->route('admin.user.index')->with(['status'=>true, 'message' => 'Entertainer Created sucessfully']);
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

    /** */
    public function show($id)
    {
        $data['entertainer']= EntertainerDetail::where('user_id',$id)->get();
        $data['user_id'] = $id;
        return view('admin.entertainer.Talent.index',compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entertainer=User::find($id);
        return view('admin.entertainer.edit',compact('entertainer'));
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

        $entertainer=User::find($id);

        $entertainer->name       =    $request->input('name');
        $entertainer->email      =    $request->input('email');
        $entertainer->phone      =    $request->input('phone');
        $entertainer->update();

        return redirect()->route('admin.user.index')->with(['status'=>true, 'message' => 'Entertainer Updated sucessfully']);
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
        return redirect()->back()->with(['status'=>true, 'message' => 'Entertainer Deleted sucessfully']);
    }

      /**
     * Show the form for creating a new Talent for Specific Entertainer.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTalentIndex($id)
    {
        $data['user_id'] = $id;
        $data['talent_categories']=TalentCategory::select('id','category')->get();
        return view('admin.entertainer.Talent.add',compact('data'));
    }
    public function storeTalent(Request $request,$id)

    {
        $validator = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'price' => 'required',
            // 'description' => 'required',
            // 'images'=>'required',
        ]);
        $data = $request->only(['title','user_id', 'category', 'price']);

        $data['user_id'] = $id;
        $user = EntertainerDetail::create($data);
        if ($request->file('event_photos')) {
            foreach ($request->file('event_photos') as $data) {
                $image = hexdec(uniqid()) . '.' . strtolower($data->getClientOriginalExtension());
                $data->move('public', $image);
                EntertainerEventPhotos::create([
                        'event_photos' => 'public/' . $image,
                        'entertainer_details_id' => $user->id
                       ]);
            }
        }
         return redirect()->route('entertainer.show',$id)->with(['status'=>true, 'message' => 'Talent Created sucessfully']);
        // return view('admin.entertainer.Talent.add');

}
    public function destroyTalent($id)
    {

        EntertainerDetail::destroy($id);
        return redirect()->back()->with(['status'=>true, 'message' => 'Talent Deleted sucessfully']);
    }
    public function editTalent($id)
    {
        //$data['user_id'] = EntertainerDetail::find($id);
        $talent=EntertainerDetail::find($id);
        $talent['user_id'] = $id;
        return view('admin.entertainer.Talent.edit',compact('talent'));
    }
    public function updateTalent(Request $request, $id)
    {
        $validator = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'price' => 'required',
            // 'description' => 'required',
            // 'images'=>'required',
        ]);

        $talent    = EntertainerDetail::find($id);
        $talent->title       =    $request->input('title');
        $talent->category      =    $request->input('category');
        $talent->price      =    $request->input('price');
        $talent->update();

        return redirect()->route('entertainer.show',$talent->user_id)->with(['status'=>true, 'message' => 'Talent Updated sucessfully']);

    }

    public function showPhoto($id)
    {
        //  Showing Entertainer Talent
        $data['user_id']= EntertainerEventPhotos::where('entertainer_details_id',$id)->get();
        // dd($data['user_id']);
        $data['entertainer_details_id'] = $id;
        return view('admin.entertainer.Talent.Photo.index',compact('data'));

    }
    //Photo
    public function destroyPhoto($id)
    {

        EntertainerEventPhotos::destroy($id);
        return redirect()->back()->with(['status'=>true, 'message' => 'Photo Deleted sucessfully']);
    }
    public function editPhoto($id)
    {
        //$data['user_id'] = EntertainerDetail::find($id);
        $photo=EntertainerEventPhotos::find($id);
        $photo['entertainer_details_id'] = $id;
        return view('admin.entertainer.Talent.Photo.edit',compact('photo'));
    }
    public function updatePhoto(Request $request, $id)
    {
        $validator = $request->validate([
            'event_photos' => 'required',
            // 'description' => 'required',
            // 'images'=>'required',
        ]);
        $photo = EntertainerEventPhotos::find($id);
        if($request->hasfile('event_photos')){
            $destination='public/'.$photo->event_photos;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
        $file = $request->file('event_photos');
        $extension=$file->getClientOriginalExtension();
        $filename=time().'.'.$extension;
        $file->move('',$filename);
        $photo->event_photos=$filename;
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
        $data= TalentCategory::select('id','category')->get();
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
        $category = TalentCategory::find($category_id);
        $category->category=$request->category;
        $category->update();
        return redirect()->route('entertainer.talent.categories.index')->with(['status'=>true, 'message' => 'Talent Category Updated sucessfully']);
    }
    public function destroyTalentCategory($category_id){
        TalentCategory::destroy($category_id);
        return redirect()->back()->with(['status'=>true, 'message' => 'Category Deleted sucessfully']);
    }
}
