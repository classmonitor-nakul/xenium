<?php

namespace App\Http\Controllers\Pos\HRMS;

use App\Http\Controllers\Controller;
use App\Models\HRMS\Positions;
use App\Models\HRMS\Employees;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $positions = Positions::get();
        return view('pos.hrms.employees', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data['first_name']=$request->input('firstname');
        $data['last_name']=$request->input('lastname');
        $data['birth_date']=$request->input('dob');
        $data['mobile']=$request->input('mobile');
        $data['email']=$request->input('email');
        $data['gender']=$request->input('gender');
        $data['birth_date']=$request->input('dob');
        $data['address']=$request->input('address');
        $data['pincode']=$request->input('pincode');
        $data['city']=$request->input('city');
        $data['aadhar']=$request->input('aadhar');
        $data['emergency']=$request->input('emergency');
        $data['salary']=$request->input('salary');
        $data['pos_id']=$request->input('position');

        //dd($request->file('photo'));
        if($request->file('photo'))
        {
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
        
            $imageName = 'emp'.time().'.'.$request->photo->extension();  
            if($request->photo->move(public_path('empphotos'), $imageName))
            $data['photo']=$imageName;
        }
        if(Employees::insert($data))
        {
            if($request->input('username')&&$request->input('password')&&$request->input('password_confirmation')&&$request->input('email'))
            {
                $data_1['emp_id']=Employees::orderBy('id','DESC')->first()->id;
                $data_1['username']=$request->input('username');
                $data_1['password']=$request->input('password');
                $data_1['name']=$request->input('firstname');
                $data_1['email']=$request->input('email');
                //$data_1['email_verified_at']=1;
                User::insert($data_1);
            }

        // return response()->json(['Message' => 'Success' , 'Status' => 200 , 'Data' => 'Added' ])
        // ->setStatusCode(200);
        return redirect(route('pos.hrms.employees'));
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
        if ($request->ajax()) {

            $data = Employees::latest()->get();
            
            //$path=url('assets/empphotos');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('personal_info', function($row){
                    return $row->first_name.' '.$row->last_name.'<br>'.$row->birth_date.'</b>';
                })
                ->addColumn('contact_info', function($row){
                    return $row->mobile.'<br>'.$row->email.'<br>'.$row->address.'</b>';
                })
                ->addColumn('employee_photo', function($row){
                    return "<img src='".url('empphotos/').'/'.$row->photo."' width=80px height=100px>";
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<button onclick="showData('.$row->id.')" data-toggle="modal" data-target="#addEditModel" class="edit btn btn-success btn-sm"><i class="fa-light fa-edit"></i></button> <button onclick="delData('.$row->id.')" class="delete btn btn-danger btn-sm"><i class="fa-light fa-trash"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->escapeColumns([])
                ->make(true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
        $id = $request->all();
        $data = Employees::where('id', $id)->get();
         $user=$data;
         $user1=User::where('emp_id', $id)->get();
         $user_array=json_decode(json_encode($user1),true);
          if(!empty($user_array))
         {
            $user=$user1;
         }
            //echo 'll';
            $data=array_merge(json_decode(json_encode($user),true), json_decode(json_encode($data),true));
            $data=array_merge($data[0],$data[1]);
    
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employees $employees)
    {
        //

        $data['id']=$request->input('id');
        $data['first_name']=$request->input('firstname');
        $data['last_name']=$request->input('lastname');
        $data['birth_date']=$request->input('dob');
        $data['mobile']=$request->input('mobile');
        $data['email']=$request->input('email');
        $data['gender']=$request->input('gender');
        $data['birth_date']=$request->input('dob');
        $data['address']=$request->input('address');
        $data['pincode']=$request->input('pincode');
        $data['city']=$request->input('city');
        $data['aadhar']=$request->input('aadhar');
        $data['emergency']=$request->input('emergency');
        $data['salary']=$request->input('salary');
        $data['pos_id']=$request->input('position');

        if($request->file('photo'))
        {
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            $imageName = 'emp'.time().'.'.$request->photo->extension();  
            if($request->photo->move(public_path('empphotos'), $imageName))
            $data['photo']=$imageName;
        }

        if(Employees::where('id', $data['id'])->update($data))
        {
            if(!empty(User::where('emp_id', $data['id'])->get()->first()->username)
            &&$request->input('password')
            &&$request->input('password_confirmation')
            &&$request->input('email'))
            {
                $data_1['password']=$request->input('password');
                $data_1['name']=$request->input('firstname');
                $data_1['email']=$request->input('email');

                User::where('emp_id', $data['id'])->update($data_1);
            }
            return redirect(route('pos.hrms.employees'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $data = Employees::where('id', $request->id)->delete();
        return response()->json($data);
    }
}
