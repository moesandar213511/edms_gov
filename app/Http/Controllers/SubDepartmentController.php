<?php

namespace App\Http\Controllers;

use App\CustomClass\LetterData;
use App\CustomClass\Path;
use App\CustomClass\SubDepartment;
use App\Letter;
use App\Letter_sub_department;
use App\Sub_department;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class SubDepartmentController extends Controller
{
    public function index(){
        date_default_timezone_set("Asia/Rangoon");
        $current_date=date("Y-m-d");
        $sub_departs_arr=$this->expectAuthenciateSubDepart();
        $sub_departs=Letter_sub_department::orderBy('id','Desc')->where('in_sub_depart_id',Auth::user()->data_id)->get();
        $income_letter_arr=[];
        $income_letter_data_arr=[];
        if(count($sub_departs) > 0){
            foreach($sub_departs as $data){
                if($data->created_at->format("Y-m-d") == $current_date && $data->type != "copy_depart"){
                    $out_sub_depart=Sub_department::where('id',$data->out_sub_depart_id)->first();
                    $obj=new LetterData($data->letter_id);
                    $income_letter_data=$obj->singleLetterData();
                    if($income_letter_data['is_read'] == "false" && $income_letter_data['type'] == "simple"){
                        $income_letter_data['from_sub_depart_name']=$out_sub_depart->name;
                        array_push($income_letter_arr,$income_letter_data);
                    }
                    
                    if($income_letter_data['type'] == "simple"){
                        array_push($income_letter_data_arr,$income_letter_data);
                    }
                }
            }
        }
        $income_letter_qty=count($income_letter_data_arr);
        $outcome_letters=Letter_sub_department::Where('out_sub_depart_id',Auth::user()->data_id)->get();
        $arr=[];
        foreach($outcome_letters as $data){
            if($data->type != 'copy_depart' && $data->letter->type == 'simple'){
                array_push($arr,$data);
            }
        }
        $outcome_letter_qty=count($arr);
        return view('backend.sub_depart.admin_index')->with([
            'income_letter_qty' => $income_letter_qty,
            'outcome_letter_qty' => $outcome_letter_qty,
            'income_letters' => $income_letter_arr
        ]);
    }

    public function simpleOutputLetterCreate(){
        $sub_departs_arr=$this->expectAuthenciateSubDepart();
        return view('backend.sub_depart.simple_output_letter_create')->with([
            'sub_departs' => $sub_departs_arr
        ]);
    }

    public function sendSimpleOutputLetter(Request $request){
        $file=$request->file('attach_file'); // file size limited 20 mb
        $data_arr=[];
        $data_arr=$request->all();
        $request->validate([
            'title' => ['string','max:255'],
            'attach_file' => ['required','max:20480']
        ]);
        if(isset($file)){
            $file_name = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path('upload/sub_depart_attach_file'),$file_name);
            $data_arr['attach_file']=$file_name;
        }
        $letter=Letter::create($data_arr);
        Letter_sub_department::create([
            'letter_id' => $letter->id,
            'in_sub_depart_id' => $request->get('in_sub_depart_id'),
            'out_sub_depart_id' => Auth::user()->data_id
        ]);
        $copy_depart=$request->get('copy_depart');
        foreach($copy_depart as $data){
            Letter_sub_department::create([
                'letter_id' => $letter->id,
                'in_sub_depart_id' => $data,
                'out_sub_depart_id' => Auth::user()->data_id,
                'type' => 'copy_depart'
            ]);
        }
        return response()->json(true);
    }

    public function simpleIncomeLetter(Request $request){  // 24 HOURS INCOME LETTERS
        date_default_timezone_set("Asia/Rangoon");
        $current_date=date("Y-m-d");
        $sub_departs_arr=$this->expectAuthenciateSubDepart();
        $sub_departs=Letter_sub_department::orderBy('id','Desc')->where('in_sub_depart_id',Auth::user()->data_id)->get();
        $income_letter_arr=[];
        if(count($sub_departs) > 0){
            foreach($sub_departs as $data){
                if($data->created_at->format("Y-m-d") == $current_date && $data->type != "copy_depart"){
                    $out_sub_depart=Sub_department::where('id',$data->out_sub_depart_id)->first();
                    $obj=new LetterData($data->letter_id);
                    $income_letter_data=$obj->singleLetterData();
                    if($income_letter_data['type'] == "simple"){
                        $income_letter_data['from_sub_depart_name']=$out_sub_depart->name;
                        array_push($income_letter_arr,$income_letter_data);
                    }
                }
            }
        }
        if(!$request->ajax()){
            return view('backend.sub_depart.simple_income_letter')->with([
                'income_letters' => $income_letter_arr,
                'sub_departs' => $sub_departs_arr
            ]);
        }else{
            return response()->json($income_letter_arr);
        }
    }

    public function allSimpleIncomeLetter(){ 
        $sub_departs=Letter_sub_department::orderBy('id','Desc')->where('in_sub_depart_id',Auth::user()->data_id)->get();
        $income_letter_arr=[];
        if(count($sub_departs) > 0){
            foreach($sub_departs as $data){
                if($data->type != "copy_depart"){
                    $out_sub_depart=Sub_department::where('id',$data->out_sub_depart_id)->first();
                    $obj=new LetterData($data->letter_id);
                    $income_letter_data=$obj->singleLetterData();
                    if($income_letter_data['type'] == 'simple'){
                        $income_letter_data['from_sub_depart_name']=$out_sub_depart->name;
                        array_push($income_letter_arr,$income_letter_data);
                    }
                }
            }
        }
        return response()->json($income_letter_arr);
    }

    public function searchIncomeLetter(Request $request){
        $from=$request->get('from');
        $to=$request->get('to');
        $out_sub_depart_id=$request->get('sub_depart_id');
        $sub_departs=Letter_sub_department::orderBy('id','Desc')->where('in_sub_depart_id',Auth::user()->data_id)->where('out_sub_depart_id',$out_sub_depart_id)->get();
        $income_letter_arr=[];
        if(count($sub_departs) > 0){
                foreach($sub_departs as $data){
                    if($data->type != "copy_depart"){
                        $obj=new LetterData($data->letter_id);
                        $income_letter_data=$obj->dateBetweenSearchData($from,$to,$data->out_sub_depart_id);
                        if(!is_null($income_letter_data) && $income_letter_data['type'] == 'simple'){
                            array_push($income_letter_arr,$income_letter_data);
                        }
                    }
                }
        }
        return response()->json($income_letter_arr);
    }

    public function simpleOutcomeLetter(Request $request){ // 24 HOURS OUTCOME LETTERS
        date_default_timezone_set("Asia/Rangoon");
        $current_date=date("Y-m-d");
        $sub_departs_arr=$this->expectAuthenciateSubDepart();
        $sub_departs=Letter_sub_department::orderBy('id','Desc')->where('out_sub_depart_id',Auth::user()->data_id)->get();
        $outcome_letter_arr=[];
        if(count($sub_departs) > 0){
            foreach($sub_departs as $data){
                if($data->created_at->format("Y-m-d") == $current_date && $data->type != "copy_depart"){
                    $out_sub_depart=Sub_department::where('id',$data->in_sub_depart_id)->first();
                    $obj=new LetterData($data->letter_id);
                    $out_letter_data=$obj->singleLetterData();
                    if($out_letter_data['type']=='simple'){
                        $out_letter_data['to_sub_depart_name']=$out_sub_depart->name;
                        array_push($outcome_letter_arr,$out_letter_data);
                    }
                }
            }
        }

        if(!$request->ajax()){
            return view('backend.sub_depart.simple_outcome_letter')->with([
                'outcome_letters' => $outcome_letter_arr,
                'sub_departs' => $sub_departs_arr
            ]);
        }else{
            return response()->json($outcome_letter_arr);
        }
    }

    public function allSimpleOutcomeLetter(){
        $sub_departs=Letter_sub_department::orderBy('id','Desc')->where('out_sub_depart_id',Auth::user()->data_id)->get();
        $outcome_letter_arr=[];
        if(count($sub_departs) > 0){
            foreach($sub_departs as $data){
                if($data->type != "copy_depart"){
                $out_sub_depart=Sub_department::where('id',$data->in_sub_depart_id)->first();
                $obj=new LetterData($data->letter_id);
                $outcome_letter_data=$obj->singleLetterData();
                if($outcome_letter_data['type']=='simple'){
                    $outcome_letter_data['to_sub_depart_name']=$out_sub_depart->name;
                    array_push($outcome_letter_arr,$outcome_letter_data);
                    }
                }
            }
        }
        return response()->json($outcome_letter_arr);
    }

    public function searchOutcomeLetter(Request $request){
        $from=$request->get('from');
        $to=$request->get('to');
        $in_sub_depart_id=$request->get('sub_depart_id');
        $sub_departs=Letter_sub_department::orderBy('id','Desc')->where('in_sub_depart_id',$in_sub_depart_id)->where('out_sub_depart_id',Auth::user()->data_id)->get();
        $outcome_letter_arr=[];
        if(count($sub_departs) > 0){
                foreach($sub_departs as $data){
                    if($data->type != "copy_depart"){
                        $obj=new LetterData($data->letter_id);
                        $outcome_letter_data=$obj->dateBetweenSearchData($from,$to,$data->in_sub_depart_id);
                        if(!is_null($outcome_letter_data) && $outcome_letter_data['type']=='simple'){
                            array_push($outcome_letter_arr,$outcome_letter_data);
                        }
                    }
                }
        }
        return response()->json($outcome_letter_arr);
    }

    public function expectAuthenciateSubDepart(){
        $sub_departs=Sub_department::all('id','name');
        $sub_departs_arr=[];
        foreach($sub_departs as $data){
            if($data['id'] != Auth::user()->data_id){
                array_push($sub_departs_arr,$data);
            }
        }
        return $sub_departs_arr;
    }

    public function profileSetting(){
        $sub_depart_id=Auth::user()->data_id;
        $obj=new SubDepartment($sub_depart_id);
        return view('backend.sub_depart.profile_setting')->with([
            'profile_setting' => $obj->singleSubDepart()
        ]);
    }

    public function changeProfileSetting(Request $request){
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
        $user->update();
        Session::flash('success','Profile Change Successful!');
        return redirect()->back();
    }

    public function downloadFile($path) {
        $file_path = public_path('upload/sub_depart_attach_file/'.$path);
        return response()->download($file_path);
    }

    public function singleLetterPage($id,$to){
        $obj=new LetterData($id);
        $data=$obj->singleLetterData();
        $data['to_sub_depart_name']=$to;
        $copy_depart_arr=[];
        foreach($data['sub_depart_letter_data'] as $item){
            if($item->type == "copy_depart"){
                $obj=new SubDepartment($item->in_sub_depart_id);
                array_push($copy_depart_arr,$obj->singleSubDepart()['name']);
            }
        }
        return view('backend.sub_depart.single_letter_page')->with([
            'letter_data' => $data,
            'copy_departs' => $copy_depart_arr
        ]);
    }

    public function isReadStateChange($id){
        $change=Letter::find($id);
        $change->is_read="true";
        $change->update();
        return response()->json(true);
    }

  // ---------------------------- important outcome letter ----------------------
    public function importantOutputLetterCreate(){
        $sub_departs_arr=$this->expectAuthenciateSubDepart();
        return view('backend.sub_depart.important_output_letter_create')->with([
            'sub_departs' => $sub_departs_arr
        ]);
    }

    public function sendImportantOutputLetter(Request $request){
        $data_arr=[];
        $data_arr=$request->all();
        $request->validate([
            'title' => ['string','max:255'],
            'key_code' => ['string','min:8']
        ]);
        $data_arr['type']="important";
        $letter=Letter::create($data_arr);
        Letter_sub_department::create([
            'letter_id' => $letter->id,
            'in_sub_depart_id' => $request->get('in_sub_depart_id'),
            'out_sub_depart_id' => Auth::user()->data_id
        ]);
        return response()->json(true);
    }

    public function importantIncomeLetter(Request $request){ // 24 HOURS INCOME LETTERS
        date_default_timezone_set("Asia/Rangoon");
        $current_date=date("Y-m-d");
        $sub_departs_arr=$this->expectAuthenciateSubDepart();
        $sub_departs=Letter_sub_department::orderBy('id','Desc')->where('in_sub_depart_id',Auth::user()->data_id)->get();
        $income_letter_arr=[];
        if(count($sub_departs) > 0){
            foreach($sub_departs as $data){
                if($data->created_at->format("Y-m-d") == $current_date && $data->type != "copy_depart"){
                    $out_sub_depart=Sub_department::where('id',$data->out_sub_depart_id)->first();
                    $obj=new LetterData($data->letter_id);
                    $income_letter_data=$obj->singleLetterData();
                    if($income_letter_data['type'] == "important"){
                        $income_letter_data['from_sub_depart_name']=$out_sub_depart->name;
                        array_push($income_letter_arr,$income_letter_data);
                    }
                }
            }
        }

        if(!$request->ajax()){
            return view('backend.sub_depart.important_income_letter')->with([
                'income_letters' => $income_letter_arr,
                'sub_departs' => $sub_departs_arr
            ]);
        }else{
            return response()->json($income_letter_arr);
        }

    }

    public function allImportantIncomeLetter(){
        $sub_departs=Letter_sub_department::orderBy('id','Desc')->where('in_sub_depart_id',Auth::user()->data_id)->get();
        $income_letter_arr=[];
        if(count($sub_departs) > 0){
            foreach($sub_departs as $data){
                if($data->type != "copy_depart"){
                    $out_sub_depart=Sub_department::where('id',$data->out_sub_depart_id)->first();
                    $obj=new LetterData($data->letter_id);
                    $income_letter_data=$obj->singleLetterData();
                    if($income_letter_data['type'] == 'important'){
                        $income_letter_data['from_sub_depart_name']=$out_sub_depart->name;
                        array_push($income_letter_arr,$income_letter_data);
                    }
                }
            }
        }
        return response()->json($income_letter_arr);
    }

    public function searchImportantIncomeLetter(Request $request){
        $from=$request->get('from');
        $to=$request->get('to');
        $out_sub_depart_id=$request->get('sub_depart_id');
        $sub_departs=Letter_sub_department::orderBy('id','Desc')->where('in_sub_depart_id',Auth::user()->data_id)->where('out_sub_depart_id',$out_sub_depart_id)->get();
        $income_letter_arr=[];
        if(count($sub_departs) > 0){
                foreach($sub_departs as $data){
                    if($data->type != "copy_depart"){
                        $obj=new LetterData($data->letter_id);
                        $income_letter_data=$obj->dateBetweenSearchData($from,$to,$data->out_sub_depart_id);
                        if(!is_null($income_letter_data) && $income_letter_data['type'] == 'important'){
                            array_push($income_letter_arr,$income_letter_data);
                        }
                    }
                }
        }
        return response()->json($income_letter_arr);
    }

    public function importantOutcomeLetter(Request $request){ // 24 HOURS OUTCOME LETTERS
        date_default_timezone_set("Asia/Rangoon");
        $current_date=date("Y-m-d");
        $sub_departs_arr=$this->expectAuthenciateSubDepart();
        $sub_departs=Letter_sub_department::orderBy('id','Desc')->where('out_sub_depart_id',Auth::user()->data_id)->get();
        $outcome_letter_arr=[];
        if(count($sub_departs) > 0){
            foreach($sub_departs as $data){
                if($data->created_at->format("Y-m-d") == $current_date && $data->type != "copy_depart"){
                    $out_sub_depart=Sub_department::where('id',$data->in_sub_depart_id)->first();
                    $obj=new LetterData($data->letter_id);
                    $out_letter_data=$obj->singleLetterData();
                    if($out_letter_data['type']=='important'){
                        $out_letter_data['to_sub_depart_name']=$out_sub_depart->name;
                        array_push($outcome_letter_arr,$out_letter_data);
                    }
                }
            }
        }

        if(!$request->ajax()){
            return view('backend.sub_depart.important_outcome_letter')->with([
                'outcome_letters' => $outcome_letter_arr,
                'sub_departs' => $sub_departs_arr
            ]);
        }else{
            return response()->json($outcome_letter_arr);
        }
    }

    public function allImportantOutcomeLetter(){
        $sub_departs=Letter_sub_department::orderBy('id','Desc')->where('out_sub_depart_id',Auth::user()->data_id)->get();
        $outcome_letter_arr=[];
        if(count($sub_departs) > 0){
            foreach($sub_departs as $data){
                if($data->type != "copy_depart"){
                $out_sub_depart=Sub_department::where('id',$data->in_sub_depart_id)->first();
                $obj=new LetterData($data->letter_id);
                $outcome_letter_data=$obj->singleLetterData();
                if($outcome_letter_data['type']=='important'){
                    $outcome_letter_data['to_sub_depart_name']=$out_sub_depart->name;
                    array_push($outcome_letter_arr,$outcome_letter_data);
                    }
                }
            }
        }
        return response()->json($outcome_letter_arr);
    }

    public function searchImportantOutcomeLetter(Request $request){
        $from=$request->get('from');
        $to=$request->get('to');
        $in_sub_depart_id=$request->get('sub_depart_id');
        $sub_departs=Letter_sub_department::orderBy('id','Desc')->where('in_sub_depart_id',$in_sub_depart_id)->where('out_sub_depart_id',Auth::user()->data_id)->get();
        $outcome_letter_arr=[];
        if(count($sub_departs) > 0){
                foreach($sub_departs as $data){
                    if($data->type != "copy_depart"){
                        $obj=new LetterData($data->letter_id);
                        $outcome_letter_data=$obj->dateBetweenSearchData($from,$to,$data->in_sub_depart_id);
                        if(!is_null($outcome_letter_data) && $outcome_letter_data['type']=='important'){
                            array_push($outcome_letter_arr,$outcome_letter_data);
                        }
                    }
                }
        }
        return response()->json($outcome_letter_arr);
    }

    public function singleImportantLetterPage($id,$to){
        $obj=new LetterData($id);
        $data=$obj->singleLetterData();
        $data['to_sub_depart_name']=$to;
        return view('backend.sub_depart.single_important_letter_page')->with([
            'letter_data' => $data,
        ]);
    }
}
