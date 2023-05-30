@extends('layouts.pos.dashboard', ['title' => 'Categories', 'module' => 'Inventory'])
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h2 class="mb-4 col-md-6 text-md-left text-center">Categories</h2>
                    <div class="mb-4 col-md-6 text-right">
                        <button class="btn btn-primary btn-sm" id="btnNew" data-toggle="modal" data-target="#addEditModel">New Category</button>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="addEditModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add / Edit</h5>
                                <button type="button" class="close" data-dismiss="modal" id="closeModal" aria-label="Close">
                                <span aria-hidden="true"><i class="fa-light fa-close"></i></span>
                                </button>
                            </div>
                            <div class="modal-body" id="demo">
                                <form action={{route('pos.inventory.categories.add')}} method='post' id="addEditForm" enctype="multipart/form-data">
                                  @csrf
                                <div class="step-app">
                                  <ul class="step-steps">
                                    <li><a href="#step1"><span class="number">1</span> Category Info</a></li>
                                    <li><a href="#step2"><span class="number">2</span> Required Specifications</a></li>
                                  </ul>
                                  <div class="step-content">
                                    <div class="step-tab-panel" id="step1">
                                     <input class="form-control" id="id" name="id" type="text" hidden>
                                        <div class="row m-t-2">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="categoryName">Category Name:</label>
                                              <input class="form-control" type="text" id="categoryName" placeholder="name" name="categoryName" required>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="isActive">Is Active?</label>
                                              <select class="form-control" name="isActive" id="isActive" required>
                                                <option value=1>Yes</option>
                                                <option value=0>No</option>
                                              </select>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                            <label for="categoryPrefix">Category prefix for stock keeping unit:</label>
                                              <input class="form-control" type="text" id="categoryPrefix" placeholder="prefix" name="categoryPrefix" required>
                                            </div>
                                          </div>

                                        </div>                                        
                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <label for="tags">Tags</label>
                                              <textarea class="form-control" placeholder="Please fill comma separated keywords" name="tags" id="tags"></textarea>
                                            </div>
                                          </div>

                                        </div>
                                  </div>
                                    <div class="step-tab-panel" id="step2" >
                                      <div class="row m-t-2">
                                        <div class="col-md-6" >
                                          <div class="form-group">
                                            <h4>Add Inputs</h4>
                                              
                                                <label id="addInput" class="btn btn-primary" >Add</label> <label id="removeInput" class="btn btn-primary" >Remove</label>
                                                <input type="hidden" id="countInputs" value=0 name="countInputs"></input>
                                              
                                          </div>
                                        </div>
                                        <!-- <div class="col-md-6" id='dropdowns'>                                          
                                          <div class="form-group">
                                          <h4>Add Dropdown Inputs</h4>
                                            <label id="addDropdown" class="btn btn-primary">Add</label> <label id="removeText" class="btn btn-primary" >Remove</label>
                                            <input class="form-control" type="hidden" id="countDropdowns" value=0 name="countDropdowns">
                                          </div>
                                        </div>
                                        <div class="col-md-6" id='booleans'>
                                          <div class="form-group"> 
                                            <h4>Add Boolean(Yes/No) Inputs</h4>
                                            <label id="addBoolean" class="btn btn-primary">Add</label> <label id="removeText" class="btn btn-primary" >Remove</label>
                                            <input class="form-control" type="hidden" id="countBooleans" value=0 name="countBooleans">
                                          </div>
                                        </div> -->
                                      </div>
                                    </div>

                                  </div>
                                  <div class="step-footer">
                                    <button type='submit' id='btnSubmit' data-direction="finish" class="btn btn-primary">Submit</button>
                                  </div>
                                </div>
                                <form>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-hover table-sm">
                        <thead>
                          <tr>
                            <th>Sr. #</th>
                            <th>Category ID</th>
                            <th>Category Name</th>
                            <th>Tags</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/plugins/formwizard/jquery-steps.css') }}">
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/plugins/datatables/datatables.min.js')}}"></script>
    <!-- form wizard --> 
    <script src="{{ asset('assets/plugins/formwizard/jquery-steps.js') }}"></script> 
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                paging: true,
                retrieve: true,
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('pos.inventory.categories.table') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'categoryId', name: 'categoryId'},
                    {data: 'name', name: 'name'},
                    {data: 'tags', name: 'tags'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
            
        $('#addBtn').on('click', function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            $(".save-btn").html('<i class="fa-light fa-loader rotate"></i>');
            $.ajax({
                data: $('#addEditForm').serialize(),
                url: "{{ route('pos.inventory.categories.add') }}",
                type: 'POST',
                dataType: 'JSON',
                success: function(data) {
                    $('#addEditForm')[0].reset();
                    $('#error').empty();
                    $('#closeModal').trigger('click');
                    $('.save-btn').html('Save');
                    $('#datatable').DataTable().ajax.reload();
                },
                error: function(data) {
                    if(data.error = 422) {
                        $('#error').html('<p class="alert alert-danger">'+data.responseJSON.message+'</p>');
                        console.log(data.responseJSON.message);
                    }
                    $('.save-btn').html('Save');
                }
            });
        });
        function showData(id) {
            $.ajax({
                data: {'id':id},
                url: "{{ route('pos.inventory.categories.show') }}",
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                  console.log(response);
                    $('#id').val(response.id);                  
                    $('#categoryName').val(response.name);
                    $('#isActive').val(response.isActive);
                    $('#tags').val(response.tags);

                    $("#addEditForm").attr('action', "{{ route('pos.inventory.categories.update')}}"); 
                    $('#btnSubmit').html("Update");           
                }
            });
        }
        function delData(id) {
            if(confirm('Are you sure you want to delete?') == true) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ route('pos.inventory.categories.delete') }}",
                    data: {'id': id},
                    dataType: 'JSON',
                    success: function(response) {
                        $('#datatable').DataTable().ajax.reload();
                    }
                });
            }
        }

        $('#demo').steps({
            onFinish: function () {

            }
        });
        $( "#btnSubmit" ).on( "click", function() {
          $( "#addEditForm" ).trigger( "submit" );
        } );
        $( "#btnNew" ).on( "click", function() {
          $('#btnSubmit').html("submit");
          $("#addEditForm").attr('action', "{{ route('pos.inventory.categories.add')}}");
          $("#addEditForm")[0].reset();
        } );


        $("#addInput").on("click",function(){
              var count=parseInt($("#countInputs").val())+1;
                $("#countInputs").val(count);
                var str="<div class='row'>";
                str+= "<div class='col-md-4'>Name "+count+":<input class='form-control'  type='text' name='inputName-"+count+"'></input></div>";
                str+= "<div class='col-md-3'>Type of input:<select class='form-control' id='inputType-"+count+"' onchange='typeChange("+count+")' name='inputType-"+count+"'>";
                str+= "<option value='text'>Text</option> <option value='dropdown'>Dropdown</option> <option value='boolean'>Boolean</option> </select> </div>";    
                str+= "<div class='col-md-3'>Status:<select class='form-control' name='inputStatus-"+count+"'>";  
                str+= "<option value='1'>Active</option> <option value='0'>Inactive</option> </select> </div></div>";    
                str+= "<div class='row'><div class='col-md-12' id='div"+count+"' >Value: <input  class='form-control' placeholder='Please fill default value' type='text' name='inputValue-"+count+"'></input></div></div><br><br>";
                $("#step2").append(str);
        });

        function typeChange(count)
        {
          str="";
          if($("#inputType-"+count.toString()).val()==="dropdown")
          {
            str="Value: <input  class='form-control'  type='text' name='inputValue-"+count+"' placeholder='Please fill options separated by comma'></input></div></div><br><br>";
            $("#div"+count.toString()).html(str);
          }
          if($("#inputType-"+count.toString()).val()==="boolean")
          {
            str="Choose default value:<select class='form-control' name='inputValue-"+count+"'> <option value='1'>Yes</option> <option value='0'>No</option></select></div></div><br><br>";
            $("#div"+count.toString()).html(str);
          }
          if($("#inputType-"+count.toString()).val()==="text")
          {
            str="Value: <input  class='form-control'  type='text' name='inputValue-"+count+"' placeholder='Please fill default value'></input></div></div><br><br>";
            $("#div"+count.toString()).html(str);
          }
          
        }
        // $("#addDropdown").click(function(){
        //   var count1=parseInt($("#countDropdowns").val())+1;
        //         $("#countDropdowns").val(count1);            
        //         $("#dropdowns").append("Name "+count1+": <input class='form-control'  type='text' name='text-"+count1+"'></input><br>");
        // });
        // $("#addBoolean").click(function(){
        //   var count2=parseInt($("#countBooleans").val())+1;
        //         $("#countBooleans").val(count2);            
        //         $("#booleans").append("Name "+count2+": <input class='form-control'  type='text' name='text-"+count2+"'></input><br>");
        // });

        // $("#removeText").on("click",function(){
        //   var count;
        //   if(parseInt($("#countTexts").val())>0)    
        //    count=parseInt($("#countTexts").val())-1;
        //         $("#countTexts").val(count);            
        //         $("#texts").append("Name "+count+": <input class='form-control'  type='text' name='text-"+count+"'></input><br>");
        // });
        // $("#removeDropdown").click(function(){
        //   var count1;
        //   if(parseInt($("#countDropdowns").val())>0)          
        //    count1=parseInt($("#countDropdowns").val())-1;
        //         $("#countDropdowns").val(count1);            
        //         $("#dropdowns").append("Name "+count1+": <input class='form-control'  type='text' name='text-"+count1+"'></input><br>");
        // });
        // $("#removeBoolean").click(function(){
        //   var count2;
        //   if(parseInt($("#countBooleans").val())>0)
        //    count2=parseInt($("#countBooleans").val())-1;
        //         $("#countBooleans").val(count2);            
        //         $("#booleans").append("Name "+count2+": <input class='form-control'  type='text' name='text-"+count2+"'></input><br>");
    </script>

@endsection