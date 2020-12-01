@extends('layouts.app-perm')
@section('content') 


<style>
    #cate_name
    {
        margin: 1px 20px; font-size: 16px; color: #666;
    }

    /* Customize the label (the container) */
    .container 
    {
      display: block;
      position: relative;
      padding-left: 35px;
      margin-bottom: 1px;
      cursor: pointer;
      font-size: 14px;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;

      font-weight: lighter;
    }

    /* Hide the browser's default radio button */
    .container input 
    {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;
    }

    /* Create a custom radio button */
    .checkmark 
    {
      position: absolute;
      top: 0;
      left: 0;
      height: 20px;
      width: 20px;
      background-color: #E5E4E2;
      border-radius: 15%;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input ~ .checkmark 
    {
      background-color: #008B8B;
    }

    /* When the radio button is checked, add a blue background */
    .container input:checked ~ .checkmark 
    {
      background-color: #008B8B;   /*2196F3*/
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after 
    {
      content: "";
      position: absolute;
      display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .container input:checked ~ .checkmark:after 
    {
      display: block;
    }

    /* Style the indicator (dot/circle) */
    .container .checkmark:after 
    {
      top: 7px;
      left: 7px;
      width: 7px;
      height: 7px;
      border-radius:15%;
      background: white;
    }

    .cate-class
    {
        border:thin dotted #eee;
        padding: 4px;
    }

    .cate-class:hover
    {
        border:thin solid #666;
        padding: 4px;
        color: #dcdcdc;
        background: #2C303B;
        cursor: pointer;
    }

    .cate-class_active
    {
        background: #202020;
        color: #fff;
    }
</style>
    
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row" style="margin-top-25px">
            <div class="content-header-left col-xl-9 col-md-7 col-sm-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Assign Permission</h3> 
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Assign Permission
                    </li>
                </ol>
                </div>
            </div>
            </div>
            <div class="content-header-right col-xl-2 col-md-3 col-sm-12">
            <div class="dropdown float-md-right">
                <input type="text" class="form-control pull-right" placeholder="Search" v-model="search" />
            </div>
            </div>
            <div class="content-header-right col-xl-1 col-md-2 col-sm-12">
            <div class="dropdown float-md-right">
                <button class="btn btn-primary round btn-glow px-2" type="button" data-animation="pulse" data-toggle="modal" data-target="#addRoleModal" @click="clearForm()">New</button>
            </div>
            </div>
        </div>


        <div class="content-body" style="margin-top: -8px">
            <!-- Basic Tables start -->
            <div class="row">
            <div class="col-12">
                <div class="card">

                <div class="card-header">
                    <h4 class="card-title">Assign Permission</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                    </div>
                </div>


                <div class="table-responsive"> 
                    <form class="form-horizontal" method="post" action="{{route('assign-permission-to-role')}}">   
                        {{ csrf_field() }}  
                        <div class="row col-md-12" style="padding: 0px">
                            <div class="col-md-6" style="padding: 0px 10px"><h5 style="margin-left: 25px; color: #202020">  Departments  </h5> </div>   
                            <div class="col-md-6" style="padding: 0px 50px">
                                <h5 style="margin-left: 25px; color: #202020">  
                                    <label class="container"> Check All
                                    <input type="checkbox" id="check_all">
                                    <span class="checkmark"></span>
                                    </label>
                                </h5> 
                            </div>
                        </div> 

                        
                        <div class="row col-md-12">  
                            <div class="col-md-3" style="">
                                @if(count($categories)>0)
                                    @foreach($categories as $categories)
                                        <p class="cate-class" id="{{$categories->id}}" onclick="showId({{$categories->id}})" onmouseup="setTab({{$categories->id}})"> {{$categories->name}} </p>
                                    @endforeach
                                @endif
                            </div>

                            <div class="col-md-3" style="">     
                                <button data-toggle="tooltip" type="button" style="cursor: pointer; color:#fff; font-size:10px; border-radius:13px; margin-top: -20px; margin-right: -35px" class="btn btn-danger btn-sm pull-right" data-original-title="Clear Boxes" id="clear_box">  <i class="la la-remove"></i> 
                                </button> 

                                <select class="pull-right form-control" name="perm_role_id" id="perm_role_id" style="width: 90%; margin-top:-20px" required>
                                    <option value=""> Select Role </option>
                                    @if(count($roles)>0)
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-5" style="padding-left: 5%">
                                <table class="table">                        
                                    <tr id="constants">    </tr>
                                </table> 
                            </div>

                            <div class="col-md-1" style=""> <button type="submit" class="btn btn-dark btn-sm pull-right" name="" id="" style="margin-top: -20px"><i class="la la-check"></i> Assign </button> </div>
                        </div>
                    
                    </form>
                </div> <!-- end col -->




            



            </div>
        </div>

        </div>
    </div>


    </div>
    </div>


<script> 
    $(function()
    {
        $('[data-toggle="tooltip"]').tooltip(); 
    });

    //on category click script
    function showId(id) 
    {
      var department_id = id;

      $.get('{{url('getConstants')}}?department_id=' +department_id, function(data)
      {  //success data
         $('#constants').empty();
        $.each(data, function(index, constObj)
        {         
          $('#constants').append('<tr class="trow"> <td> <label class="container"> '+constObj.name+'  <input type="checkbox" id="perm_'+constObj.id+'" name="permission_list[]" value="'+constObj.id+'" class="switch checkall" />   <span class="checkmark"></span>   </label>  </td> <tr>');      
        });
        $('#constants').append('<input type="hidden" name="cate_id" value="'+id+'" /> <input type="hidden" name="count_perm" id="count_perm" />');
        //$('#const').val(id);
        $('#'+id).val(id);
      }); 
      
      $('#perm_role_id').get(0).selectedIndex = 0;
    }


    function setTab(id) 
    {
        $('.cate-class').removeClass('cate-class_active');
        $('#'+id).addClass('cate-class_active');
    }

    $(function()
    {
        $('#cleared').on("change", function(e)
        {   
            //  alert(); //$('.checkall').attr( 'checked', true );         
        });

        $('#perm_role_id').on("change", function(e)
        {   
            // $('input[type=checkbox]').each(function(){ $(this).removeAttr('checked'); });
            var role_id = $(this).val();    
            $.get('{{url('checkPermissions')}}?role_id=' +role_id, function(data)
            {  
                console.log(role_id);
                // $('.checkall').attr( 'checked', false );
                $.each(data, function(index, permObj)
                {
                    $('#perm_'+permObj.permission_id).attr( 'checked', true );                             
                });
            }); 
        });
    });

    function clearBoxes()
    {
        var all = document.getElementsByClassName("checkall");
        all.checked = true;
    }


    $('#perm_role_id').mouseleave(function()
    {
        //$('.checkall').attr( 'checked', true); 
    });

    $(function()
    {
        $('#clear_box').click(function()
        {
            //$('.checkall').removAattribute( 'checked');
            $('.trow').remove(); 
            $('#perm_role_id').get(0).selectedIndex = 0;
            $('.cate-class').removeClass('cate-class_active');
        });
    });



    //CHECK ALL CHECKBOXES
    $(function()
    {
        $('#check_all').click(function () 
        {    
            $('input:checkbox').prop('checked', this.checked);    
        });
    });

    
    // number 0f checked boxes

</script>



    @if(Session::has('info'))
        <script>
            $(function() 
            {
                toastr.success('{{session('info')}}', {timeOut:50000});
            });
        </script>
    @elseif(Session::has('error'))
        <script>
            $(function() 
            {
                toastr.error('{{session('error')}}', {timeOut:50000});
            });
        </script>

    @endif

@endsection