@extends('admin.layout.index')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header" >
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
            <i class="mdi mdi-lan"></i> </span>Courses</h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <a data-toggle="modal" data-target="#courseModel" class="btn btn-gradient-info mdi mdi-plus">Add Course</a>
          </ol>
        </nav>
      </div>      
          <div class="card">
            <div class="card-body">
              <table class="table dataTable table-responsive js-exportable">
                <thead>
                  <tr>
                    <th>#ID</th>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  
                    @forelse ($data as $item)
                    <tr data-id="{{$item->id}}">
                <td>{{$item->id}}</td>
               <td>{{$item->name}}</td>
               <td>{!! Str::limit($item->description, 20) !!}</td>
               <td>{{$item->price}}</td>
               <td><img src="{{URL::to('/uploads/course_images/'.$item->image)}}"></td>
               <td class="text-capitalize">
                <span class="badge badge-danger">{{$item->status=='deactive'?'deactive':""}}</span>
                 <span class="badge badge-success">{{$item->status=='active'?'active':""}}</span>    
               </td>
                <td>
                  <a><i data-id="{{$item->id}}"  data-toggle="modal" data-target="#editcModal" class=" editBtn mdi mdi-pencil-box-outline tip" style="font-size: 25px;color:rgb(13, 27, 221);">
                        <span class="tooltiptext h6">Edit</span>
                    </i></a>&nbsp;&nbsp;&nbsp;
                    <a data-id="{{$item->id}}" class="deletebtn" href="#"><i class="mdi mdi-delete tip"style="font-size: 25px;color:crimson;">
                        <span class="tooltiptext h6">Delete</span>
                    </i></a>
                  </td>
                  </tr>
                  @empty
                        <p>Not Found</p>
                  @endforelse
                </tbody>
              
              </table>
            </div>
          </div>
        </div>
        
        </div>


{{-- Add_course_modal --}}

<div class="modal fade modal-md" id="courseModel" tabindex="-1" role="dialog" aria-labelledby="courseModel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header bg-light">
            <h5 class="modal-title" id="exampleModalLabel">ADD COURSE</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
      <div class="modal-body">
        <form action="" id="add-course-form" method="POST" enctype="multipart/form-data">
          @csrf            
           <div class="form-group">
            <label>Course Name</label>
            <input type="text" class="mt-1 mb-1 form-control" name="name" id="name" placeholder="Name" required>
            </div>
            <div class="form-group">
                <label>Description</label>
              <textarea  name="description" id="description" cols="50" rows="5" required></textarea> 
                   </div>
                    <div class="form-group">
                    <label>Price</label>
                    <input type="number" class="mt-1 mb-1 form-control" name="price" id="price" placeholder="Price"  required>
                    </div>
                    <div class="form-group">
                      <label>Image</label>
                          <input type="file" onchange="showPreview(event);" class="form-control" id="image" name="image" required>
                          <div class="Preview" id="Preview">
                            <img id="file-id-preview">
                         </div>
                      
                        </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="mt-1 mb-1 form-control" name="status" id="status" required>
                          <option  selected disabled >Select Status</option>

                          <option value="active">Active</option>
                          <option value="deactive">Deactive</option>
                        </select>
                        </div>         
                        <button type="submit" class="btn btn-primary">Submit</button>            
                </form>
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary closeBtn" data-dismiss="modal">Close</button>
  
      </div>
    </div>
  </div>
</div>

{{-- Edit course modal --}}
<div class="modal fade bd-example-modal-md" tabindex="-1" id="editcModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title h4" id="myLargeModalLabel"><strong>EDIT EXECUTIVE</strong></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
            <form action="" id="edit-course-form" method="POST" enctype="multipart/form-data">
              @csrf            
              <input type="text" id="course-id" name="id" hidden>

               <div class="form-group">
                <label>Course Name</label>
                <input type="text" class="mt-1 mb-1 form-control" name="name" id="edit-name" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                  <textarea  name="description" id="edit-description" cols="50" rows="5" required></textarea> 
                       </div>
                        <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="mt-1 mb-1 form-control" name="price" id="edit-price" placeholder="Price"  required>
                        </div>
                        <div class="form-group">
                          <label>Image</label>
                              <input type="file" onchange="showPreview1(event);" class="form-control" id="edit-image" name="image">
                              <div class="Preview" id="Preview1">
                                <img id="file-id-preview1">
                             </div>
                             <div class="col-6">
                              <img width="100%" height="120px" id="oldPhoto" style="margin-top: 10px" src="" alt="">
                          </div>
                            </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="mt-1 mb-1 form-control" name="status" id="status" required>
                              <option  selected disabled >Select Status</option>
    
                              <option value="active">Active</option>
                              <option value="deactive">Deactive</option>
                            </select>
                            </div>         
                            <button type="submit" class="btn btn-primary">Submit</button>            
                    </form>
                  </div>
        
          <div class="modal-footer">
              <button type="button" class="btn btn-danger closeBtn" data-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>


<script src="/adminjs/course.js"></script>
@endsection