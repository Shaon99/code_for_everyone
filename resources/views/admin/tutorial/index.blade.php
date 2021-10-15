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
            <a  href="{{route('admin.addtutorial')}}" class="btn btn-gradient-info mdi mdi-plus">Add Tutorial</a>

          </ol>
        </nav>
      </div>      
          <div class="card">
            <div class="card-body">
              <table class="table dataTable  js-exportable">
                <thead>
                  <tr>
                    <th>#ID</th>
                    <th>Tutorial Title</th>
                    <th>Description</th>
                    <th>details</th>                
                    <th>Action</th>
                  </tr>
                </thead>          
                  <tbody>
                    @forelse ($all as $item)
                    <tr data-id="{{$item->id}}">
                      <td>{{$item->id}}</td>
                      <td>{{$item->title}}</td>
                      <td>{!! Str::limit($item->s_description, 30) !!}</td>
                      <td>{!! Str::limit($item->details, 30) !!}</td>

                      <td>
                        {{-- <a><i data-id="{{$item->id}}"  data-toggle="modal" data-target="#editcModal" class=" editBtn mdi mdi-pencil-box-outline tip" style="font-size: 25px;color:rgb(13, 27, 221);">
                              <span class="tooltiptext h6">Edit</span>
                          </i></a>&nbsp;&nbsp;&nbsp; --}}
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


        <script src="/adminjs/tutorial.js"></script>
@endsection