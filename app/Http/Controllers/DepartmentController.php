<?php

namespace App\Http\Controllers;

use App\CustomClass\SubDepartment;
use App\Sub_department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class DepartmentController extends Controller
{
    public function createSubDepart(){
        $depart_name=Auth::user()->user_name;
        $depart_id=Auth::user()->data_id;
        return view('backend.depart.create_sub_depart')->with([
            'depart_name' => $depart_name,
            'depart_id' => $depart_id
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
            'type' => $request->get('type'),
            'data_id' => $sub_depart->id
        ]);
       if($res){
            return response()->json(true);
       }else{
            return response()->json(false);
       }
    }

    public function dataSubDepart(){
        $main_part_id=Auth::user()->data_id;
        $sub_departs=Sub_department::where('main_depart_id',$main_part_id)->orderBy('id','Desc')->get();
        $sub_depart_datas=SubDepartment::allSubDepartData($sub_departs);
        return view('backend.depart.sub_depart_data')->with([
            'sub_depart_datas' => $sub_depart_datas
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
        $user->type=$request->get('type');
        $user->user_name=$request->get('name');
        $res=$user->update();
        if($res){
                return response()->json(true);
        }else{
                return response()->json(false);
        }
    }
}
