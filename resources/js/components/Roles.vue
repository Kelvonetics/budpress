<template>
    <div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row" style="margin-top-25px">
        <div class="content-header-left col-xl-9 col-md-7 col-sm-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Roles</h3> 
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a>
                </li>
                <li class="breadcrumb-item active">Roles
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
                <h4 class="card-title">Roles</h4>
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
                                            <th>Role Name</th>
                                            <th>Description</th>
                                            <th style="text-align:right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="role in filteredRoles" v-bind:key="role.id">
                                            <td>{{role.name}}</td>
                                            <td>{{role.description}}</td>
                                            <td>
                                                <a class="pull-right" @click="deleteRole(role.id)"><span class="la times-circle text-inverse m-r-10" style="margin :1px 2px; color: red"></span>
                                                </a>
                                                <a class="pull-right" data-toggle="modal" data-target="#addRoleModal" 
                                                    @click="editRole(role)"><span class="la la-pencil text-inverse m-r-10" style="margin :1px 2px; color: #396"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                

                                <nav aria-label="Page navigation example pull-right">
                                    <ul class="pagination justify-content-end pagination-separate pagination-round mb-1" style="">
                                        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                                            <a class="page-link pagi-btn"aria-label="Previous" href="#" @click="fetchRoles(pagination.prev_page_url)">
                                            << Prev</i></a>
                                        </li>
                                        <li class="page-item disabled"><a class="page-link text-dark pagi-btn" href="#">Page {{pagination.current_page}} of {{pagination.last_page}} </a></li>
                                        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                                            <a class="page-link pagi-btn"aria-label="Next" href="#" @click="fetchRoles(pagination.next_page_url)">
                                            Next >> </a>
                                        </li>
                                    </ul>
                                </nav>

                            </div>
                        </div>
                        <div class="col-md-4" style="border-left: 2px solid #ddd; padding-left: 50px;"> 
                            <form @submit.prevent="addRole">

                                        <div class="modal-header" style="padding-left: 0px">
                                            <h4 class="modal-title" id="myModalLabel">Add New Role</h4>
                                        </div>

                                        <div class="">   <br>             

                                            <fieldset class="mb-1" style="">
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <h5>Role</h5>
                                                        <input type="text" class="form-control round" v-model="role.name" required>
                                                    </div>
                                                </div>                                            
                                            </fieldset>                                 

                                            <fieldset class="mb-1" style="margin-top:-20px">
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <h5>Description</h5>
                                                        <textarea rows="2" class="form-control round" v-model="role.description" required></textarea>
                                                    </div>
                                                </div>                                            
                                            </fieldset>


                                            
                                            <!-- Modal footer -->
                                            <div class="pull-right">
                                                <!-- <button type="reset" class="btn btn-outline-warning btn-glow btn-sm round">Close</button> -->
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
                roles: [], 
                role: {
                    id: '',
                    name: '',
                    description: ''
                },
                role_id: '',
                pagination: {},
                edit: false
            }
        },


        computed: {
            filteredRoles: function()
            {
                return this.roles.filter((role) => {
                    return role.name.toLowerCase().match(this.search.toLowerCase()) ||
                           role.description.toLowerCase().match(this.search.toLowerCase()) 
                });
            }

        },


        created()
        {
            this.fetchAllRoles();
            this.fetchRoles();
        },

        methods:{

            fetchAllRoles(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/roles?all=1'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.roles = res.data;
                })
                .catch(err => console.log(err));            
            },


            fetchRoles(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/roles'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.roles = res.data;
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

            deleteRole(id)
            {
                if(confirm('Are You Sure You Want To Delete This Role Details?'))
                {
                    fetch(`api/role/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        toastr.success('The Role Record Has Been Deleted');
                        this.fetchRoles();
                        this.edit = false;
                    })
                    .catch(err => console.log(err));
                }
            },

            addRole()
            {
                if(this.edit === false)
                {
                    fetch('api/role', 
                    {
                        method: 'post',
                        body: JSON.stringify(this.role),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm()
                        toastr.success('Role Has Been created Successfully');
                        this.fetchRoles();
                        this.edit = false;
                    })
                    .catch(err => console.log(err));                    

                }
                else
                {
                    fetch('api/role', 
                    {
                        method: 'put',
                        body: JSON.stringify(this.role),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm();
                        toastr.success('Role Has Been Updated');
                        this.fetchRoles();
                        this.edit = false;
                    }) 
                    .catch(err => console.log(err));                    
                }
            },

            editRole(role)
            {
                this.edit = true;
                this.role.id = role.id;
                this.role.role_id = role.id;
                this.role.name = role.name;
                this.role.description = role.description;
            },



            clearForm()
            {
                this.role.name = '';
                this.role.description = '';
            }
        }
    };
</script>

