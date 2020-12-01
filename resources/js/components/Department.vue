<template>
    <div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row" style="margin-top-25px">
        <div class="content-header-left col-xl-9 col-md-7 col-sm-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Departments</h3> 
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a>
                </li>
                <li class="breadcrumb-item active">Departments
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
            <button class="btn btn-primary round btn-glow px-2" type="button" data-animation="pulse" data-toggle="modal" data-target="#addDepartmentModal" @click="clearForm()">New</button>
          </div>
        </div>
      </div>


      <div class="content-body" style="margin-top: -8px">
        <!-- Basic Tables start -->
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h4 class="card-title">Departments</h4>
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

              <div class="card-content collapse show" style="margin-top: -30px">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover table-xs">
                        <thead class="thead-dark">
                            <tr>
                                <th>Department</th>
                                <th>Description</th>
                                <th style="text-align:right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="department in filteredDepartments" v-bind:key="department.id">
                                <td>{{department.name}}</td>
                                <td>{{department.description}}</td>
                                <td>
                                    <a class="pull-right" @click="deleteDepartment(department.id)"><span class="la times-circle text-inverse m-r-10" style="margin :1px 2px; color: red"></span>
                                    </a>
                                    <a class="pull-right" data-toggle="modal" data-target="#addDepartmentModal" 
                                        @click="editDepartment(department)"><span class="la la-pencil text-inverse m-r-10" style="margin :1px 2px; color: #396"></span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    

                    <nav aria-label="Page navigation example pull-right">
                        <ul class="pagination justify-content-end pagination-separate pagination-round mb-1">
                            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                                <a class="page-link"aria-label="Previous" style="" href="#" @click="fetchDepartments(pagination.prev_page_url)">
                                << Prev</i></a>
                            </li>
                            <li class="page-item disabled"><a class="page-link text-dark" href="#" >Page {{pagination.current_page}} of {{pagination.last_page}} </a></li>
                            <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                                <a class="page-link"aria-label="Next" style="" href="#" @click="fetchDepartments(pagination.next_page_url)">
                                 Next >> </a>
                            </li>
                        </ul>
                    </nav>







                    <!-- Modal -->
                    <form @submit.prevent="addDepartment">
                        <div class="modal animated rollin text-left" id="addDepartmentModal" tabindex="-1" role="dialog" style="">
                            <div class="modal-dialog modal-lg" role="document" style="">
                                <div class="modal-content" style="">

                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Add New Department</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color:red">X</span></button>
                                </div>

                                <div class="modal-body">                

                                    <fieldset class="mb-1" style="">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <h5>Department</h5>
                                                <input type="text" class="form-control round" v-model="department.name" required>
                                            </div>
                                        </div>                                            
                                    </fieldset>                                   

                                    <fieldset class="mb-1" style="margin-top:-20px">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <h5>Description</h5>
                                                <textarea rows="2" class="form-control round" v-model="department.description" required></textarea>
                                            </div>
                                        </div>                                            
                                    </fieldset>


                                    
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-outline-warning btn-glow btn-sm round">Close</button>
                                        <button type="submit" class="btn btn-dark btn-sm round">Save Details</button>
                                    </div>

                                    </div>
                                </div><!-- modal-content -->
                            </div><!-- modal-dialog -->
                        </div><!-- modal -->
                    </form>


                    





                  </div>
                </div>
              </div>

            </div>
        </div>
    </div>

    </div>
</div>
</div>

</template>


















<script>
    export default
    {
        data(){
            return{
                search: '',
                departments: [], 
                department: {
                    id: '',
                    name: '',
                    description: ''
                },
                department_id: '',
                pagination: {},
                edit: false
            }
        },


        computed: {
            filteredDepartments: function()
            {
                return this.departments.filter((department) => {
                    return department.name.toLowerCase().match(this.search.toLowerCase()) ||
                           department.description.toLowerCase().match(this.search.toLowerCase())
                });
            }

        },


        created()
        {
            this.fetchAllDepartments();
            this.fetchDepartments();
        },

        methods:{

            fetchAllDepartments(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/departments?all=1'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.departments = res.data;
                })
                .catch(err => console.log(err));            
            },


            fetchDepartments(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/departments'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.departments = res.data;
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
            },
            makePagination(meta, links) 
            {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };

                this.pagination = pagination;
            },

            deleteDepartment(id)
            {
                if(confirm('Are You Sure You Want To Delete This Department Details?'))
                {
                    fetch(`api/department/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        toastr.success('The Department Record Has Been Deleted');
                        this.fetchDepartments();
                        this.edit = false;
                    })
                    .catch(err => console.log(err));
                }
            },

            addDepartment()
            {
                if(this.edit === false)
                {
                    fetch('api/department', 
                    {
                        method: 'post',
                        body: JSON.stringify(this.department),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm()
                        toastr.success('Department Has Been created Successfully');
                        this.fetchDepartments();
                        this.edit = false;
                    })
                    .catch(err => console.log(err)); 
                    $('#addDepartmentModal').trigger('click');

                }
                else
                {
                    fetch('api/department', 
                    {
                        method: 'put',
                        body: JSON.stringify(this.department),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm();
                        toastr.success('Department Has Been Updated');
                        this.fetchDepartments();
                        this.edit = false;
                    }) 
                    .catch(err => console.log(err));
                    $('#addDepartmentModal').trigger('click');
                }
            },

            editDepartment(department)
            {
                this.edit = true;
                this.department.id = department.id;
                this.department.department_id = department.id;
                this.department.name = department.name;
                this.department.description = department.description;
            },



            clearForm()
            {
                this.department.name = '';
                this.department.description = '';
            }
        }
    };
</script>

