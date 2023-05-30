<?php

namespace App\Http\Controllers\Pos\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Specifications;
use App\Models\Inventory\Products;
use App\Models\Inventory\Categories;
use App\Models\Inventory\ProductImages;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Products::leftjoin('categories','categories.id','=','products.categoryId')
                        ->select('products.*','categories.name as categoryName')->get();
        $categories = Categories::get();
        return view('pos.inventory.products', compact('data','categories'));
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
        $data['productName']=$request->input('productName');
        $data['categoryId']=$request->input('productCategory');
        $data['price']=$request->input('productPrice');
        $data['quantity']=$request->input('productQuantity');
        $data['isFeatured']=$request->input('isFeatured');
        $data['status']=$request->input('status'); 
       

        $tags=json_encode(explode(',',$request->input('tags')));
        
        $data['tags']=$tags;

        $arrSpecs=[];    

         foreach($request->input() as $name=>$value)
         {
            if(substr($name,-2)=='**')
            $arrSpecs[rtrim($name,'*')]=$value;
         }
         $data['specifications']=json_encode($arrSpecs);

        $pid=Products::insertGetId($data);

         $prefix=Categories::where('id',$request->input('productCategory'))->get()->first()->prefix;

         define( 'SKU_Length' , 7);
         $sku='';
         for($zeros='';  strlen( $sku) < SKU_Length ;$zeros.='0') $sku=$prefix . $zeros . $pid;

         Products::where('id',$pid)->update(['sku'=>$sku]);

        return redirect(route('pos.inventory.products'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
        if ($request->ajax()) {

            //$data = Products::latest()->get();
            $data = Products::leftjoin('categories','products.categoryId','=','categories.id')
                        ->select('products.*','categories.name as categoryName')
                        ->orderBy('id','desc')
                        ->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = 
                    '<button onclick="getProductImages('.$row->id.')" data-toggle="modal" data-target="#addUpdateImageModel" class="delete btn btn-primary btn-sm"><i class="fa-light fa-image"></i></button>
                    <button onclick="showData('.$row->id.')" data-toggle="modal" data-target="#addEditModel" class="edit btn btn-success btn-sm"><i class="fa-light fa-edit"></i></button> 
                    <button onclick="delData('.$row->id.')" class="delete btn btn-danger btn-sm"><i class="fa-light fa-trash"></i></button>';
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
        // $data = Products::leftjoin('categories','categories.id','=','products.categoryId')
        //                 ->select('products.*','categories.name as categoryName')
        //                 ->where('products.id', $id)
        //                 ->orderBy('products.id','desc')
        //                 ->get();
        $data = Products::where('id', $id)->get();
        $data[0]->tags=join(',',json_decode($data[0]->tags, true));
        return response()->json($data[0]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data['productName']=$request->input('productName');
        $data['categoryId']=$request->input('productCategory');
        $data['price']=$request->input('productPrice');
        $data['quantity']=$request->input('productQuantity');
        $data['isFeatured']=$request->input('isFeatured');
        $data['status']=$request->input('status'); 
       

        $tags=json_encode(explode(',',$request->input('tags')));
        
        $data['tags']=$tags;

        $arrSpecs=[];    

         foreach($request->input() as $name=>$value)
         {
            if(substr($name,-2)=='**')
            $arrSpecs[rtrim($name,'*')]=$value;
         }
         $data['specifications']=json_encode($arrSpecs);

         Products::where('id',$request->input('id'))->update($data);

        return redirect(route('pos.inventory.products'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if(Products::where('id', $request->id)->delete())
        return response()->json(['status'=>'success','data'=>$request->id],200);
        else
        return response()->json(['status'=>'failed','data'=>$request->id],500);

    }

    public function getSpecForm(Request $request)
    {
        $ids=explode(', ',$request->id);
        $catId=$ids[0];
        $prodId=false;
        
        $specs = Specifications::where('categoryId', $catId)->get();

        
        if(count($ids)==2)  //it is case of edit of existing product, in this case category id and product id are present in the request
        {
            $prodId=$ids[1];
           
            $product=Products::where('id', $prodId)->get()->first();

            if($product->categoryId==$catId)  //checking wheather user has changed the dropdown of product category or not
            {
                $productSpecs=$product->specifications;
                return response()->json(
                    $this->editForm($prodId, $specs)  
                );
            }
            else
            {
                return response()->json(
                    $this->freshForm($specs)   
                );
            }
        }
        else{                           //it is case of new product add, in this case only product id is present in the request
            
            return response()->json(
                $this->freshForm($specs)   
            );
        }
    }

    public function freshForm($specs):string
    {
        $formItems="";

        foreach($specs as $spec)
        {
            $fieldName=$spec->name.'**';
            if($spec->type=='text')
            {
                $formItems.=
             '<div class="col-md-6">
                <div class="form-group">
                  <label for="'.$spec->name.'">'.$spec->name.':</label>
                  <input class="form-control" type="text" id="'.$spec->name.'" name="'.$fieldName.'" value="'.$spec->content.'" required>
                </div>
              </div>';
            }
            else if($spec->type=='dropdown')
            {
                $formItems.=
             '<div class="col-md-6">
                <div class="form-group">
                  <label for="'.$spec->name.'">'.$spec->name.'</label>
                  <select class="form-control" id="'.$spec->name.'" name="'.$fieldName.'"  required>';
                  
                  $options=json_decode($spec->content, true);  
                  foreach($options as $option)
                  {
                    $formItems.='<option value="'.$option.'">'.$option.'</option>';
                  }
                
                  $formItems.=
                '</select>
                </div>
              </div>';
            }
            else if($spec->type=='boolean')
            {
                $formItems.=
                '<div class="col-md-6">
                   <div class="form-group">'
                   .$spec->name.
                    ':<br><input  type="radio" id="'.$spec->name.'_1" name="'.$fieldName.'" value="1" '.(($spec->content=='1')?'checked':'').'>
                     <label for="'.$spec->name.'_0">Yes</label><br>
                     <input  type="radio" id="'.$spec->name.'_0" name="'.$fieldName.'" value="0" '.(($spec->content=='0')?'checked':'').'>
                     <label for="'.$spec->name.'_0">No</label>
                   </div>
                 </div>';
            }
        }   
        return $formItems;
    }
    public function editForm($prodId, $specs):string
    {
       $formItems="";
        
        if($prodId)
        {
            $productSpecs=Products::where('id', $prodId)->get()->first()->specifications;
        }

        $productSpecs=json_decode($productSpecs, true);

        foreach($specs as $spec)
        {
            $fieldName=$spec->name.'**';
            if($spec->type=='text')
            {
                $formItems.=
             '<div class="col-md-6">
                <div class="form-group">
                  <label for="'.$spec->name.'">'.$spec->name.':</label>
                  <input class="form-control" type="text" id="'.$spec->name.'" name="'.$fieldName.'" value="'.$productSpecs[str_replace(' ','_',$spec->name)].'" required>
                </div>
              </div>';
            }
            else if($spec->type=='dropdown')
            {
                $formItems.=
             '<div class="col-md-6">
                <div class="form-group">
                  <label for="'.$spec->name.'">'.$spec->name.'</label>
                  <select class="form-control" id="'.$spec->name.'" name="'.$fieldName.'"  required>';
                  
                  $options=json_decode($spec->content, true);  
                  foreach($options as $option)
                  {
                    $formItems.='<option value="'.$option.'">'.$option.'</option>';
                  }
                
                  $formItems.=
                '</select>
                </div>
              </div>';
            }
            else if($spec->type=='boolean')
            {
                $formItems.=
                '<div class="col-md-6">
                   <div class="form-group">'
                   .$spec->name.
                    ':<br><input  type="radio" id="'.$spec->name.'_1" name="'.$fieldName.'" value="1" '.(($productSpecs[str_replace(' ','_',$spec->name)]=='1')?'checked':'').'>
                     <label for="'.$spec->name.'_0">Yes</label><br>
                     <input  type="radio" id="'.$spec->name.'_0" name="'.$fieldName.'" value="0" '.(($productSpecs[str_replace(' ','_',$spec->name)]=='0')?'checked':'').'>
                     <label for="'.$spec->name.'_0">No</label>
                   </div>
                 </div>';
            }
        }
        
        
        return $formItems;
    }
    public function addUpdateImages(Request $request)
    {
        if($request->productImages)
        {
            $request->validate([
                'productImages' => 'required',
                'productImages.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            
            $i=1;
            foreach($request->productImages as $image)
            {

                $imageName = $i++.'pImg'.time().'.'.$image->extension();  
                if($image->move(public_path('productImages'), $imageName))
                $data['image']=$imageName;
                $data['productId']=$request->input('productId-1');

                ProductImages::insert($data);
            }

        }
        return redirect(route('pos.inventory.products'));
    }
    public function getProductImages(Request $request)
    {
        $id = $request->all();

        $images=ProductImages::where('productId',$id)->get();

        return response()->json($images);
    }
    public function delImage(Request $request)
    {
        ProductImages::where('id', $request->id)->delete();
        return redirect(route('pos.inventory.products'));
    }
}

