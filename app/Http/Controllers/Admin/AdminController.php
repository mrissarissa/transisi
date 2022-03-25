<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use DataTables;
use App\Role;
use Auth;
use Carbon\Carbon;
use Validator;


class AdminController extends Controller
{
    public function user_account(){
    	return view('admin.user_account');
    }

    public function getDataUser(){
    	$data = DB::table('users')->where('factory_id',Auth::user()->factory_id)->orderBy('nik','asc');
        // dd($data->get());
    	return DataTables::of($data)
    			->addColumn('status',function($data){
    				if ($data->deleted_at==null) {
    					return '<label class="label label-success label-rounded">Active</label>';
    				}else{
    					return '<label class="label label-danger label-rounded">Non Active</label>';
    				}
    			})
                ->editColumn('factory_id',function($data){
                    $fact = DB::table('factory')->where('id',$data->factory_id)->first();

                    return $fact->factory_name;
                })
    			->addColumn('action',function($data){
    				return view('_action',[
    										'model'=>$data,
    										'edituser'=>route('admin.formEditUser',[
    											'id'=>$data->id
    										]),
                                            'innactive'=>route('admin.innactiveUser',['id'=>$data->id])
    									]);
    			})
    			->rawColumns(['status','factory_id','admin_role','action'])
    			->make(true);

    }

    public function ajaxGetRole(){
    	$data = Role::select('id','display_name','name','description')->get();
    	

    	return response()->json(['role'=>$data],200);
    }

    public function addUser(Request $request){
    	
    	$password = "Pass@123";
        $cek = User::where('nik',trim($request->nik))->whereNull('deleted_at')->first();

        if ($cek) {
            
           return response()->json("Nik was already, add user field",422);
        }else{
            $data = array(
                'nik'=>trim($request->nik),
                'name'=>strtoupper(trim($request->name)),
                'factory_id'=>$request->factory_id,
                'admin'=>$request->admin_role,
                'password'=>bcrypt($password),
                'email'=>$request->nik."@bbi-apparel.com",
                'created_at'=>carbon::now()
            );

            try {
                DB::begintransaction();

                    User::insert($data);

                    $getid = User::where('nik',trim($request->nik))->whereNull('deleted_at')->first();

                    $user_role = array('user_id'=>$getid->id,'role_id'=>$request->role_user);

                    DB::table('role_user')->insert($user_role);
                    $data_response = [
                                'status' => 200,
                                'output' => 'Add User Success . . .'
                              ];
                DB::commit();
            } catch (Exception $ex) {
                DB::rollback();
                $message = $ex->getMessage();
                ErrorHandler::db($message);
                $data_response = [
                                'status' => 422,
                                'output' => 'Add User filed ! ! !'
                              ];
            }

            return response()->json(['data'=>$data_response]);
        }

    	
    }

    public function formEditUser(Request $request){

    	$dt_role = DB::table('role_user')->where('user_id',$request->id)->first();
        $user = User::where('id',$request->id)->first();
    	return view('admin.edit_account')->with('user',$user)->with('role_id',$dt_role->role_id);
    }

    public function editAccount(Request $request){
        $id = $request->user_id;
        $admin = $request->admin;
        $factory_id = $request->factory_id;
        $role_user = $request->role_user;
      
        try {
            db::begintransaction();
           
                $data = array(
                    'admin'=>$admin,
                    'factory_id'=>$factory_id,
                    'updated_at'=>carbon::now()
                );

                $role = array('role_id'=>$role_user);
                User::where('id',$id)->update($data);
                DB::table('role_user')->where('user_id',$id)->update($role);
          

            
            db::commit();
            $data_response = [
                            'status' => 200,
                            'output' => 'Edit User Success ! ! !'
                          ];
        } catch (Exception $ex) {
            DB::rollback();
            $message = $ex->getMessage();
            ErrorHandler::db($message);
            $data_response = [
                            'status' => 422,
                            'output' => 'Edit User filed ! ! !'
                          ];
        }

        return response()->json(['data'=>$data_response]);
    }

    public function passwordReset(Request $request){
        $id = $request->user_id;
        try {
            db::begintransaction();
                $pass = "Pass@123";
                $reset = array('password'=>bcrypt($pass));
                User::where('id',$id)->update($reset);

                $data_response = [
                            'status' => 200,
                            'output' => 'Reset password Success ! ! !'
                          ];
            db:: commit();
        } catch (Exception $ex) {
            DB::rollback();
            $message = $ex->getMessage();
            ErrorHandler::db($message);
            $data_response = [
                            'status' => 422,
                            'output' => 'Reset password filed ! ! !'
                          ];
        }

        return response()->json(['data'=>$data_response]);
    }

    public function innactiveUser(Request $request){
        try {
            DB::begintransaction();
                $data = array('deleted_at'=>carbon::now());

                User::where('id',$request->id)->update($data);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            $message = $ex->getMessage();
            ErrorHandler::db($message);
        }

        return redirect()->route('admin.user_account');
    }

    public function formRole(){
        return view('admin.roles');
    }

    public function ajaxRoleData(){
        $data = DB::table('roles');


        return DataTables::of($data)
                ->addColumn('action',function($data){
                    return view('_action',[
                                            'model'=>$data,
                                            'editrole'=>route('admin.editRoleUser',[
                                                'id'=>$data->id
                                            ])
                                        ]);
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function newRole(){
        $permissions = DB::table('permissions')->get();
        return view('admin.create_role',['permissions'=>$permissions]);
    }

    public function addRole(Request $request){
        $nama = strtoupper($request->nama);
        $display = strtoupper($request->display);
        $descript = strtoupper($request->descript);
        $datax = $request->data;

        
       
        try {
            DB::begintransaction();

            $data = new Role;
            $data->name = $nama;
            $data->display_name = $display;
            $data->description = $descript;
            $data->created_at = carbon::now();
            $insert = array();

           
              if ($data->save()) {
                    foreach ($datax as $key => $value) {
                        $permission_role = array(
                            'role_id'=>$data->id,
                            'permission_id'=>$value['id']
                        );

                        $insert[]=$permission_role;
                    }

                    DB::table('permission_role')->insert($insert);

                    
                    
                }
            
            
            $data_response = [
                            'status' => 200,
                            'output' => 'Add Role Success ! ! !'
                          ];
            DB::commit();
        } catch (Exception $ex) {
              DB::rollback();
            $message = $ex->getMessage();
            ErrorHandler::db($message);

            $data_response = [
                            'status' => 422,
                            'output' => 'Add Role filed ! ! !'
                          ];
        }

        return response()->json(['data'=>$data_response]);
    }

    public function editRoleUser(Request $request){
        $id = $request->id;
        $role = DB::table('roles')->where('id',$id)->first();
        $permissions = DB::table('permissions')->get();
        $permission_role = DB::table('permission_role')->select('permission_id')->where('role_id',$id)->get();

        return view('admin.edit_role',['permissions'=>$permissions,'permission_role'=>$permission_role,'role'=>$role]);
    }

    public function updateRole(Request $request){
        $role_id = $request->role_id;
        $datax = $request->data;
   
        $insert =  array();
        try {
            db::begintransaction();
                if ($datax!==null) {
                    DB::table('permission_role')->where('role_id','=',$role_id)->delete();
                }

                foreach ($datax as $key => $value) {
                   $permission_role = array(
                        'role_id'=>$role_id,
                        'permission_id'=>$value['id']
                   );
                   $insert[]=$permission_role;
                }

                DB::table('permission_role')->insert($insert);

                $data_response = [
                            'status' => 200,
                            'output' => 'Update Success ! ! !'
                          ];
            db::commit();
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

    public function getFactory(){
        $data = DB::table('factory')->get();

        return response()->json(['factory'=>$data],200);
    }

}
