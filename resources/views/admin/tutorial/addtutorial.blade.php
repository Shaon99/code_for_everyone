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
            <a  href="{{route('admin.tutorial')}}" class="btn btn-gradient-info mdi mdi-plus">All Tutorial</a>

          </ol>
        </nav>
      </div>    
        <div class="body">
            
   

@if (session('success'))

<div class="alert alert-success">
    {{session('success')}}
</div>
@endif
            <form action="{{route('admin.posttutorial')}}" method="post">
                @csrf
                <div class="form-group">
                    <h6>Title</h6>
                    <div class="input-group">
                        <input type="text" name="title" class="form-control" placeholder="Enter title" required>
                    </div>
                </div>

                <div class="form-group">
                    <h6> Short Description</h6>
                    <div class="input-group">
                   <textarea name="s_description" id="s_description"class="form-control" cols="30" rows="10" required></textarea> 
                   </div>
                </div>
                <div class="form-group">
                    <h6>Details</h6>
                    <div class="input-group">
                        <textarea name="body" class="summernote" required></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary theme-bg gradient">Add Blog</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>
</div>
</div>

</div>
     
        
@endsection





