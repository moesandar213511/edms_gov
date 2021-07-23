<?php

namespace App\Http\Controllers;

use App\Adjure;
use App\CustomClass\AdjureData;
use App\CustomClass\MainDepartment;
use App\CustomClass\SubDepartment;
use App\Letter;
use App\Letter_sub_department;
use App\Main_department;
use App\Sub_department;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;

class AdminController extends Controller
{

    public function departData(){
        $departs=Main_department::orderBy('id','desc')->get();
        $depart_datas=MainDepartment::allDepartData($departs);
        return response()->json($depart_datas);
    }

    public function createDepart(){
        return view('backend.admin.create_depart');
    }

    public function storeDepart(Request $request){
        $request->validate([
            'depart_name' => ['required', 'string', 'max:255', 'unique:main_departments'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $res=Main_department::create([
            'depart_name' => $request->get('depart_name')
        ]);
        // $res=User::create([
        //     'user_name' => $request->get('depart_name'),
        //     'password' => Hash::make($request->get('password')),
        //     'data_id' => $depart->id,
        //     'type' => 'depart'
        // ]);
        if($res){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }

    public function editDepart($id){
        $obj=new MainDepartment($id);
        return response()->json($obj->singleDepart());
    }

    public function updateDepart(Request $request){
        $update=Main_department::find($request->get('id'));
        if($update->depart_name != $request->get('depart_name')){
            $request->validate([
                'depart_name' => ['required', 'string', 'max:255', 'unique:main_departments'],
            ]);
        }
        $update->depart_name=$request->get('depart_name');
        $update->update();
    //     $user=User::where('data_id',$request->get('id'))->first();
    //     $user->user_name = $request->get('depart_name');
    //     if($request->get('new_password')){
    //         $request->validate([
    //             'new_password' => ['string', 'min:8'],
    //         ]);
    //         $user->password = Hash::make($request->get('new_password'));
    //    }
    //     $user->update();
        return response()->json(true);
    }

    // ----------------------------------sub department section------------------
    public function createSubDepart(){
        $main_departs=Main_department::all('id','depart_name');
        return view('backend.admin.create_sub_depart')->with([
            'main_departs' => $main_departs
        ]);
    }

    public function storeSubDepart(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:sub_departments'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'office_phone' => ['required', 'numeric'],
            'human_phone' => ['required', 'numeric'],
            'address' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'logo' => ['required','image']
        ]);
        $logo=$request->file('logo');
        $logo_name = uniqid().'_'.$logo->getClientOriginalName();
        $logo->move(public_path('upload/sub_depart_logo'),$logo_name);
        $sub_depart_arr=[];
        $sub_depart_arr=$request->all();
        $sub_depart_arr['logo']=$logo_name;
        $sub_depart=Sub_department::create($sub_depart_arr);
        $res=User::create([
                'user_name' => $request->get('name'),
                'password' => Hash::make($request->get('password')),
                'type' => 'sub_depart_admin',
                'data_id' => $sub_depart->id
            ]);
       if($res){
            return response()->json(true);
       }else{
            return response()->json(false);
       }
    }

    public function dataSubDepart(){
        $main_departs=Main_department::all('id','depart_name');
        $sub_departs=Sub_department::orderBy('id','Desc')->get();
        $sub_depart_datas=SubDepartment::allSubDepartData($sub_departs);
        return view('backend.admin.sub_depart_data')->with([
            'sub_depart_datas' => $sub_depart_datas,
            'main_departs' => $main_departs
        ]);
    }

    public function editSubDepartData($id){
        $obj=new SubDepartment($id);
        return response()->json($obj->singleSubDepart());
    }

    public function updateSubDepartData(Request $request){
        $request->validate([
            'office_phone' => ['required', 'numeric'],
            'human_phone' => ['required', 'numeric'],
            'address' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'logo' => ['image']
        ]);

        $logo=$request->file('logo');
        $update=Sub_department::find($request->get('id'));
        $data_arr=[];
        $data_arr=$request->all();
        if(isset($logo)){
            if(file_exists(public_path('upload/sub_depart_logo/'.$update->logo))){
                unlink(public_path('upload/sub_depart_logo/'.$update->logo));
            }
            $logo_name = uniqid().'_'.$logo->getClientOriginalName();
            $logo->move(public_path('upload/sub_depart_logo'),$logo_name);
            $data_arr['logo']=$logo_name;
        }
       if($update->name != $request->get('name')){
            $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:sub_departments'],
            ]);
       }
        $update->update($data_arr);
        $user=User::where('data_id',$request->get('id'))->first();
        if($request->get('new_password')){
            $request->validate([
                'new_password' => ['string', 'min:8'],
            ]);
            $user->password = Hash::make($request->get('new_password'));
        }
        $user->user_name=$request->get('name');
        $res=$user->update();
        if($res){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }

    public function deleteSubDepartData($id){
        $delete=Sub_department::find($id);
        if(file_exists(public_path('upload/sub_depart_logo/'.$delete->logo))){
            unlink(public_path('upload/sub_depart_logo/'.$delete->logo));
        }
        $delete_user=User::where('data_id',$id)->first();
        $delete->delete();
        $delete_user->delete();
        $sub_letter_datas=Letter_sub_department::where('in_sub_depart_id',$id)->orWhere('out_sub_depart_id',$id)->get();
        if(count($sub_letter_datas) > 0){
            foreach($sub_letter_datas as $data){
                $letter_del=Letter::find($data->letter_id);
                $letter_del->delete();
                $data->delete();
            }
        }
        Session::flash('success','Delete Data Successful!');
        return redirect()->back();
    }

    public function departmentShow(){
        $main_departs=Main_department::all();
        $main_depart_datas=MainDepartment::allDepartData($main_departs);
        return response()->json($main_depart_datas);
    }

    public function mainDepartRelatedSubDepart($id){
        $related_sub_departs=Sub_department::where("main_depart_id",$id)->get();
        return response()->json(count($related_sub_departs));
    }

    public function mainDepartRelatedSubDepartDelete($id){
        $main_depart_delete=Main_department::find($id);
        $sub_departs=Sub_department::where('main_depart_id',$id)->get();
        if(count($sub_departs) > 0){
            foreach($sub_departs as $data){
                $data->delete();
            }
        }
        $main_depart_delete->delete();
        return response()->json(true);
    }
    

    // ------------------------------adjure letter section--------------------------
    public function createAdjureLetter(){
        return view('backend.admin.create_adjure_letter');
    }

    public function storeAdjureLetter(Request $request){
        $request->validate([
            'title' => ['string','max:255'],
            'description' => ['string'],
            'file' => ['required','mimes:pdf','max:20480']
            ],
            [
                'file.mimes' => 'Please choose PDF file!',
                'file.required' => 'Upload pdf file required!'
            ]
        );
        $file=$request->file('file');
        $data_arr=[];
        $data_arr=$request->all();
        if(isset($file)){
            $file_name = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path('upload/admin_adjure_file'),$file_name);
            $data_arr['file']=$file_name;
        }
        Adjure::create($data_arr);

        return response()->json(true);
    }

    public function adjureData(Request $request){
        $adjures=Adjure::orderBy('id','Desc')->get();
        $adjure_datas=AdjureData::allAdjureData($adjures);
        if($request->ajax()){
            return response()->json($adjure_datas);
        }else{
            return view('backend.adjure_letter')->with([
                'adjure_datas' => $adjure_datas
            ]);
        }
    }

    public function editAdjureData($id){
        $obj=new AdjureData($id);
        return response()->json($obj->singleAdjureData());
    }

    public function updateAdjureData(Request $request){
        $request->validate([
            'title' => ['string','max:255'],
            'description' => ['string'],
            'file' => ['mimes:pdf','max:20480']
            ],
            [
                'file.mimes' => 'Please choose PDF file!',
            ]
        );
        $update=Adjure::where('id',$request->get('id'))->first();
        $file=$request->file('file');
        $data_arr=[];
        $data_arr=$request->all();
        if(isset($file)){
            if(file_exists(public_path('upload/admin_adjure_file/'.$update->file))){
                unlink(public_path('upload/admin_adjure_file/'.$update->file));
            }
            $file_name = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path('upload/admin_adjure_file'),$file_name);
            $data_arr['file']=$file_name;
        }
        $update->update($data_arr);
        return response()->json();
    }

    public function adjureDownloadFile($path) {
        $file_path = public_path('upload/admin_adjure_file/'.$path);
        return response()->download($file_path);
    }

    public function deleteAdjureData($id){
        $delete=Adjure::find($id);
        if(file_exists(public_path('upload/admin_adjure_file/'.$delete->file))){
            unlink(public_path('upload/admin_adjure_file/'.$delete->file));
        }
        $delete->delete();
        return response()->json(true);
    }

    public function detailAdjureData($id){
        $obj=new AdjureData($id);
        return response()->json($obj->singleAdjureData());
    }
}
