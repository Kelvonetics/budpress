<template>
    <div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row" style="margin-top-25px">
        <div class="content-header-left col-xl-9 col-md-7 col-sm-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Users</h3> 
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a>
                </li>
                <li class="breadcrumb-item active">Users
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
            <button class="btn btn-primary round btn-glow px-2" type="button" data-animation="pulse" data-toggle="modal" data-target="#addUserModal" @click="clearForm()">New</button>
          </div>
        </div>
      </div>


      <div class="content-body" style="margin-top: -8px">
        <!-- Basic Tables start -->
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h4 class="card-title">Users</h4>
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
                    <table class="table table-striped table-hover table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>State</th>
                                <th>Join Date</th>
                                <th style="text-align:right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in filteredUsers" v-bind:key="user.id">
                                <td>{{user.firstname}}</td>
                                <td>{{user.lastname}}</td>
                                <td>{{user.email}}</td>
                                <td>{{user.department.name}}</td>
                                <td>{{user.phone}}</td>
                                <td>{{user.gender}}</td>
                                <td>{{user.state.state_name}}</td>
                                <td>{{user.doj}}</td>
                                <td>
                                    <a class="pull-right" @click="deleteUser(user.id)"><span class="la times-circle text-inverse m-r-10" style="margin :1px 2px; color: red"></span>
                                    </a>
                                    <a class="pull-right" data-toggle="modal" data-target="#addUserModal" 
                                        @click="editUser(user)"><span class="la la-pencil text-inverse m-r-10" style="margin :1px 2px; color: #396"></span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    

                    <nav aria-label="Page navigation example pull-right">
                        <ul class="pagination justify-content-end pagination-separate pagination-round mb-1">
                            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                                <a class="page-link"aria-label="Previous" style="" href="#" @click="fetchUsers(pagination.prev_page_url)">
                                << Prev</i></a>
                            </li>
                            <li class="page-item disabled"><a class="page-link text-dark" href="#" >Page {{pagination.current_page}} of {{pagination.last_page}} </a></li>
                            <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                                <a class="page-link"aria-label="Next" style="" href="#" @click="fetchUsers(pagination.next_page_url)">
                                 Next >> </a>
                            </li>
                        </ul>
                    </nav>







                    <!-- Modal -->
                    <form @submit.prevent="addUser">
                        <div class="modal animated rollin text-left" id="addUserModal" tabindex="-1" role="dialog" style="">
                            <div class="modal-dialog modal-lg" role="document" style="">
                                <div class="modal-content" style="">

                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Add New Staff</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color:red">X</span></button>
                                </div>

                                <div class="modal-body">                                        

                                    <fieldset class="mb-1" style="">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <h5>Firstname</h5>
                                                <input type="text" class="form-control round" v-model="user.firstname" required>
                                            </div>

                                            <div class="col-md-6">
                                                <h5>Lastname</h5>
                                                <input type="text" class="form-control round" v-model="user.lastname" required>
                                            </div>
                                        </div>                                            
                                    </fieldset>                                      

                                    <fieldset class="mb-1" style="margin-top:-20px">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <h5>Email</h5>
                                                <input type="email" class="form-control round" v-model="user.email" required>
                                            </div>

                                            <div class="col-md-6">
                                                <h5>Password</h5>
                                                <input type="password" class="form-control round" v-model="user.password" required>
                                            </div>
                                        </div>                                            
                                    </fieldset>                                

                                    <fieldset class="mb-1" style="margin-top:-20px">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <h5>Date Of Join</h5>
                                                <input type="date" class="form-control round" v-model="user.doj" required>
                                            </div>

                                            <div class="col-md-6">
                                                <h5>Department</h5>
                                                <select class="form-control round" v-model="user.department_id" required>
                                                    <option value=""> Select </option>
                                                    <option v-for="department in departments" v-bind:value="department.id">  {{ department.name }} </option>
                                                </select>
                                            </div>

                                        </div>                                            
                                    </fieldset>                                   

                                    <fieldset class="mb-1" style="margin-top:-20px">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <h5>Address</h5>
                                                <textarea rows="1" class="form-control round" v-model="user.address" required></textarea>
                                            </div>
                                        </div>                                            
                                    </fieldset>                                   

                                    <fieldset class="mb-1" style="margin-top:-20px">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <h5>Phone</h5>
                                                <input type="text" class="form-control round" v-model="user.phone" required>
                                            </div>

                                            <div class="col-md-6">
                                                <h5>Date Of Birth</h5>
                                                <input type="date" class="form-control round" v-model="user.dob" required>
                                            </div>

                                        </div>                                            
                                    </fieldset>                                

                                    <fieldset class="mb-1" style="margin-top:-20px">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <h5>Gender</h5>                                                
                                                <div class="row">                                                    
                                                    <div class="col-md-2">
                                                        <label for="male">Male</label>   
                                                    </div>                                                     
                                                    <div class="col-md-2">
                                                        <input type="radio" name="gender" class="form-control" style="height:25px" v-model="male" required>
                                                    </div>                                                                                        
                                                    <div class="col-md-2">
                                                        <label for="male">Female</label>
                                                    </div>                                                 
                                                    <div class="col-md-2">
                                                        <input type="radio" name="gender" class="form-control" style="height:25px" v-model="female" required>
                                                    </div>    
                                                    <div class="col-md-4">                    </div>     
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <h5>Marital Status</h5>
                                                <select class="form-control round" v-model="user.marital_status" required>
                                                    <option value=""> </option>
                                                    <option value="1"> Single </option>
                                                    <option value="2"> Married </option>
                                                    <option value="3"> Others </option>
                                                </select>
                                            </div>
                                        </div>                                            
                                    </fieldset> 

                                    <fieldset class="mb-1" style="margin-top:-20px">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <h5>State Of Origin</h5>
                                                <select class="form-control round" v-model="user.state_id" required>
                                                    <option value=""> Select </option>
                                                    <option v-for="state in states" v-bind:value="state.id">  {{ state.state_name }} </option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <h5>Nationality</h5>
                                                <input type="text" class="form-control round" v-model="user.nationality" required>
                                            </div> 
                                        </div>
                                    </fieldset>

                                    <fieldset class="mb-1" style="margin-top:-20px">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                            <h5>Photo</h5>
                                                <input type="file" name="photo" class="form-control round" @change="getImage">
                                            </div> 

                                            <div class="col-md-6">
                                            <h5>Preview</h5>
                                                <img :src="avatar" alt="Preview" style="max-width: 200px; max-height: 100px">
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


                    



                    <!-- Approve User modal -->
                    <form id="approve-form" action="#" method="POST">
                    <input type="hidden" name="token" id="token" value="">
                        <div class="modal animated rollin text-left" id="approveUserModal" tabindex="-1" role="dialog" style="">
                            <div class="modal-dialog modal-sm" role="document" style="">
                                    <div class="modal-content" style="">

                                    <div class="modal-header">
                                        <h4 class="modal-title text-danger" id="myModalLabel">
                                            Budpress Info!
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color:red">X</span></button>
                                    </div>

                                    <div class="modal-body">

                                        <fieldset class="mb-1" style="">
                                            <div class="form-group">
                                                <h4 class="modal-title" id="myModalLabel">
                                                    Are You Sure You Want To Approve This User ?
                                                </h4>
                                                <input type="hidden" class="form-control" name="action_name_id" id="action_name_id" value="" readonly>
                                            </div>
                                        </fieldset>
                                        
                                        <!-- Modal footer -->
                                        <div class="modal-footer" style="padding:4% 34%">
                                            <button type="submit" class="btn btn-outline-success btn-glow round">Yes</button>
                                            <button type="button" class="btn btn-outline-danger btn-glow round" data-dismiss="modal">No</button>
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
                states: [],
                users: [], 
                user: {
                    id: '',
                    firstname: '',
                    lastname: '',
                    email: '',
                    password: '',
                    department_id: '',
                    phone: '',
                    address: '',
                    doj: '',
                    dob: '',
                    gender: '',
                    marital_status: '',
                    state_id: '',
                    nationality: '',
                    photo: ''
                },
                user_id: '',
                pagination: {},
                avatar: null,
                edit: false
            }
        },


        computed: {
            filteredUsers: function()
            {
                return this.users.filter((user) => {
                    return user.firstname.toLowerCase().match(this.search.toLowerCase()) ||
                           user.lastname.toLowerCase().match(this.search.toLowerCase()) || 
                           user.email.toLowerCase().match(this.search.toLowerCase()) || 
                           user.department.name.toLowerCase().match(this.search.toLowerCase()) || 
                           user.phone.toString().match(this.search.toString()) || 
                        //    user.gender.toString().match(this.search.toString()) || 
                           user.state.state_name.toLowerCase().match(this.search.toLowerCase()) || 
                           user.doj.toString().match(this.search.toString()) 
                });
            }

        },


        created()
        {
            this.fetchStates();
            this.fetchDepartments();
            this.fetchAllUsers();
            this.fetchUsers();
        },

        methods:{
            getImage(e)
            {
                let image = e.target.files[0];
                let reader = new FileReader();    
                reader.readAsDataURL(image);
                reader.onload = e =>{
                    // console.log(e);
                    this.avatar = e.target.result;
                    this.user.photo = e.target.result;

                    console.log(this.photo);
                }
            },

            fetchAllUsers(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/users?all=1'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.users = res.data;
                })
                .catch(err => console.log(err));
            },



            fetchStates()
            {
                let states = '/api/states'
                fetch(states)
                .then(res => res.json())
                .then(res => {
                    this.states = res;
                })
                .catch(err => console.log(err));            
            },

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


            fetchUsers(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/users'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.users = res.data;
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

            deleteUser(id)
            {
                if(confirm('Are You Sure You Want To Delete This User Details?'))
                {
                    fetch(`api/user/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        toastr.success('The User Record Has Been Deleted');
                        this.fetchUsers();
                        this.edit = false;
                    })
                    .catch(err => console.log(err));
                }
            },

            addUser()
            {
                if(this.edit === false)
                {
                    fetch('api/user', 
                    {
                        method: 'post',
                        body: JSON.stringify(this.user),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm()
                        toastr.success('User Has Been created Successfully');
                        this.fetchUsers();
                        this.edit = false;
                    })
                    .catch(err => console.log(err)); 
                    $('#addUserModal').trigger('click');

                }
                else
                {
                    fetch('api/user', 
                    {
                        method: 'put',
                        body: JSON.stringify(this.user),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm();
                        toastr.success('User Has Been Updated');
                        this.fetchUsers();
                        this.edit = false;
                    }) 
                    .catch(err => console.log(err));
                    $('#addUserModal').trigger('click');
                }
            },

            editUser(user)
            {
                this.edit = true;
                this.user.id = user.id;
                this.user.user_id = user.id;
                this.user.firstname = user.firstname;
                this.user.lastname = user.lastname;
                this.user.email = user.email;
                this.user.password = user.password;
                this.user.department_id = user.department_id;
                this.user.phone = user.phone;
                this.user.address = user.address;
                this.user.dob = user.dob;
                this.user.doj = user.doj;
                this.user.gender = user.gender;
                this.user.marital_status = user.marital_status;
                this.user.state_id = user.state_id;
                this.user.nationality = user.nationality;
                this.user.photo = user.photo;
            },



            clearForm()
            {
                this.user.firstname = '';
                this.user.lastname = '';
                this.user.email = '';
                this.user.password = '';
                this.user.phone = '';
                this.user.department_id = '';
                this.user.address = '';
                this.user.dob = '';
                this.user.doj = '';
                this.user.gender = '';
                this.user.marital_status = '';
                this.user.state_id = '';
                this.user.nationality = '';
                this.user.photo = '';
            }
        }
    };
</script>

