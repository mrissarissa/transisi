<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Auth;

class AccountController extends Controller
{
    public function myAccount(){
    	$user = User::where('id',auth::user()->id)->first();

    	$data = array(
    		'id'=>$user->id,
    		'nik'=>$user->nik,
    		'name'=>$user->name
    	);
       	return view('user.account_setting')->with($data);
    }

    public function editPassword(Request $request){
    	$id = $request->id;
    	$newpass = trim($request->newpass);

    	try {
           DB::beginTransaction();
                $update = array(
                    'password'=>bcrypt($newpass)
                );
                User::where('id',$id)->update($update);

                $data_response = [
                            'status' => 200,
                            'output' => 'Update Success . . .'
                          ];
           DB::commit(); 
        } catch (Exception $ex) {
            DB::rollback();
            $message = $ex->getMessage();
            ErrorHandler::db($message);
            $data_response = [
                            'status' => 422,
                            'output' => 'Update filed ! ! !'
                          ];
        }

        return response()->json(['data'=>$data_response]);
    }
}
