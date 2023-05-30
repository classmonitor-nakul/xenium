<?php

namespace App\Http\Controllers\Pos\HRMS;

use App\Http\Controllers\Controller;
use App\Models\HRMS\Positions;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;   

class PositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pos.hrms.positions');
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
    public function store(Request $request): JsonResponse
    {
        $posId = $request->id;
        //
        $validate = $request->validate([
            'position' => ['required','max: 32','unique:'.Positions::class],
            'max_pos' => ['numeric'],
            'details' => ['max: 255'],
        ]);
        $data = Positions::updateOrCreate(
            [
                'id' => $posId,
            ],
            [
                'position' => $request->position,
                'max_pos' => $request->max_pos,
                'details' => $request->details
            ]
        );   
        //return response()->json($data);
        return redirect(route('pos.hrms.positions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = Positions::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<button onclick="showData('.$row->id.')" data-toggle="modal" data-target="#addEditModel" class="edit btn btn-success btn-sm"><i class="fa-light fa-edit"></i></button> <button onclick="delData('.$row->id.')" class="delete btn btn-danger btn-sm"><i class="fa-light fa-trash"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
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
        $data = Positions::where('id', $id)->get();
        return response()->json($data[0]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Positions $positions)
    {
        //
        $data['id']=$request->input('id');
        $data['position']=$request->input('position');
        $data['max_pos']=$request->input('max_pos');
        $data['details']=$request->input('details');
        if(Positions::where('id', $data['id'])->update($data))
        {
            return redirect(route('pos.hrms.positions'));
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $data = Positions::where('id', $request->id)->delete();
        return response()->json($data);
    }
}
