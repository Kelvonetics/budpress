<template>
    <div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row" style="margin-top-25px">
        <div class="content-header-left col-xl-9 col-md-7 col-sm-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Permissions</h3> 
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a>
                </li>
                <li class="breadcrumb-item active">Permissions
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
            <button class="btn btn-primary round btn-glow px-2" type="button" data-animation="pulse" data-toggle="modal" data-target="#addPermissionModal" @click="clearForm()">New</button>
          </div>
        </div>
      </div>


      <div class="content-body" style="margin-top: -8px">
        <!-- Basic Tables start -->
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h4 class="card-title">Permissions</h4>
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

                    <div class="row">
                        <div class="col-md-8" style="padding-right: 50px"> 
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-xs">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Permission Name</th>
                                            <th>Department</th>
                                            <th>Permission Constant</th>
                                            <th style="text-align:right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="permission in filteredPermissions" v-bind:key="permission.id">
                                            <td>{{permission.name}}</td>
                                            <td>{{permission.department.name}}</td>
                                            <td>{{permission.constant}}</td>
                                            <td>
                                                <a class="pull-right" @click="deletePermission(permission.id)"><span class="la times-circle text-inverse m-r-10" style="margin :1px 2px; color: red"></span>
                                                </a>
                                                <a class="pull-right" data-toggle="modal" data-target="#addPermissionModal" 
                                                    @click="editPermission(permission)"><span class="la la-pencil text-inverse m-r-10" style="margin :1px 2px; color: #396"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                

                                <nav aria-label="Page navigation example pull-right">
                                    <ul class="pagination justify-content-end pagination-separate pagination-round mb-1" style="">
                                        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                                            <a class="page-link pagi-btn"aria-label="Previous" href="#" @click="fetchPermissions(pagination.prev_page_url)">
                                            << Prev</i></a>
                                        </li>
                                        <li class="page-item disabled"><a class="page-link text-dark pagi-btn" href="#">Page {{pagination.current_page}} of {{pagination.last_page}} </a></li>
                                        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                                            <a class="page-link pagi-btn"aria-label="Next" href="#" @click="fetchPermissions(pagination.next_page_url)">
                                            Next >> </a>
                                        </li>
                                    </ul>
                                </nav>

                            </div>
                        </div>
                        <div class="col-md-4" style="border-left: 2px solid #ddd; padding-left: 50px;"> 
                            <form @submit.prevent="addPermission">

                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Add New Permission</h4>
                                        </div>

                                        <div class="">   <br>             

                                            <fieldset class="mb-1" style="">
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <h5>Permission</h5>
                                                        <input type="text" class="form-control round" v-model="permission.name" required>
                                                    </div>
                                                </div>                                            
                                            </fieldset>                                   

                                            <fieldset class="mb-1" style="margin-top:-20px">
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <h5>Department</h5>
                                                        <select class="form-control round" v-model="permission.department_id" required>
                                                            <option value=""> </option>
                                                            <option v-for="department in departments"  v-bind:key="department.id" v-bind:value="department.id">  {{ department.name }} </option>
                                                        </select>
                                                    </div>
                                                </div>                                            
                                            </fieldset>                                  

                                            <fieldset class="mb-1" style="margin-top:-20px">
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <h5>Constant</h5>
                                                        <input type="text" class="form-control round" v-model="permission.constant" required>
                                                    </div>
                                                </div>                                            
                                            </fieldset>


                                            
                                            <!-- Modal footer -->
                                            <div class="pull-right">
                                                <button type="reset" class="btn btn-outline-warning btn-glow btn-sm round">Close</button>
                                                <button type="submit" class="btn btn-dark btn-sm round">Save Details</button>
                                            </div>

                                        </div>
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
</div>

</template>


















<script>
    export default
    {
        data(){
            return{
                search: '',
                departments: [],
                permissions: [], 
                permission: {
                    id: '',
                    name: '',
                    department_id: '',
                    constant: ''
                },
                permission_id: '',
                pagination: {},
                edit: false
            }
        },


        computed: {
            filteredPermissions: function()
            {
                return this.permissions.filter((permission) => {
                    return permission.name.toLowerCase().match(this.search.toLowerCase()) ||
                           permission.department.name.toLowerCase().match(this.search.toLowerCase()) 
                        //    permission.constant.toLowerCase().match(this.search.toLowerCase())
                });
            }

        },


        created()
        {
            this.fetchDepartments();
            this.fetchAllPermissions();
            this.fetchPermissions();
        },

        methods:{

            fetchDepartments()
            {
                let departments = '/api/departments'
                fetch(departments)
                .then(res => res.json())
                .then(res => {
                    this.departments = res.data;
                })
                .catch(err => console.log(err));            
            },

            fetchAllPermissions(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/permissions?all=1'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.permissions = res.data;
                })
                .catch(err => console.log(err));            
            },


            fetchPermissions(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/permissions'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.permissions = res.data;
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

            deletePermission(id)
            {
                if(confirm('Are You Sure You Want To Delete This Permission Details?'))
                {
                    fetch(`api/permission/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        toastr.success('The Permission Record Has Been Deleted');
                        this.fetchPermissions();
                        this.edit = false;
                    })
                    .catch(err => console.log(err));
                }
            },

            addPermission()
            {
                if(this.edit === false)
                {
                    fetch('api/permission', 
                    {
                        method: 'post',
                        body: JSON.stringify(this.permission),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm()
                        toastr.success('Permission Has Been created Successfully');
                        this.fetchPermissions();
                        this.edit = false;
                    })
                    .catch(err => console.log(err));                    

                }
                else
                {
                    fetch('api/permission', 
                    {
                        method: 'put',
                        body: JSON.stringify(this.permission),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm();
                        toastr.success('Permission Has Been Updated');
                        this.fetchPermissions();
                        this.edit = false;
                    }) 
                    .catch(err => console.log(err));                    
                }
            },

            editPermission(permission)
            {
                this.edit = true;
                this.permission.id = permission.id;
                this.permission.permission_id = permission.id;
                this.permission.name = permission.name;
                this.permission.department_id = permission.department_id;
                this.permission.constant = permission.constant;
            },



            clearForm()
            {
                this.permission.name = '';
                this.permission.department_id = '';
                this.permission.constant = '';
            }
        }
    };
</script>

