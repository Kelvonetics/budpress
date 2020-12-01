<template>
    <div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row" style="margin-top-25px">
        <div class="content-header-left col-xl-9 col-md-7 col-sm-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Flows</h3> 
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a>
                </li>
                <li class="breadcrumb-item active">Flows
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
            <button class="btn btn-primary round btn-glow px-2" type="button" data-animation="pulse" data-toggle="modal" data-target="#addFlowModal" @click="clearForm()">New </button>
          </div>
        </div>
      </div>


      <div class="content-body" style="margin-top: -8px">
        <!-- Basic Tables start -->
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h4 class="card-title">Flows</h4>
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

              <div class="card-content collapse show" style="margin-top:-30px">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover table-xs">
                      <thead class="thead-dark">
                        <tr>
                          <th>Workflow</th>
                          <th>Flows</th>
                          <th>Action Type</th>
                          <th>Position</th>
                          <th>Authorized User</th>
                          <th style="text-align:right">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="flow in filteredFlows" v-bind:key="flow.id" style="">
                            <td>{{flow.workflow.name}}</td>
                            <td>{{flow.name}}</td>
                            <td>{{flow.action.name}}</td>
                            <td>{{flow.position}}</td>
                            <td>{{flow.user.firstname}} {{flow.user.lastname}}</td>
                            <td>
                                <a class="pull-right" @click="deleteFlow(flow.id)"><span class="la times-circle m-r-10" style="margin :1px 2px; color: red"></span>
                                </a>
                                <a class="pull-right" data-toggle="modal" data-target="#addFlowModal" 
                                    @click="editFlow(flow)"><span class="la la-pencil m-r-10" style="margin :1px 2px; color: #396"></span>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
            

                    <nav aria-label="Page navigation example pull-right">
                        <ul class="pagination justify-content-end pagination-separate pagination-round mb-1">
                            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                                <a class="page-link"aria-label="Previous" style="" href="#" @click="fetchFlows(pagination.prev_page_url)">
                                << Prev</i></a>
                            </li>
                            <li class="page-item disabled"><a class="page-link text-dark" href="#" >Page {{pagination.current_page}} of {{pagination.last_page}} </a></li>
                            <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                                <a class="page-link"aria-label="Next" style="" href="#" @click="fetchFlows(pagination.next_page_url)">
                                 Next >> </a>
                            </li>
                        </ul>
                    </nav>



                    <!-- Modal -->
                    <form @submit.prevent="addFlow">
                        <div class="modal animated rollin text-left" id="addFlowModal" tabindex="-1" role="dialog" style="">
                            <div class="modal-dialog modal-lg" role="document" style="">
                                    <div class="modal-content" style="">

                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Add Flow</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color:red">X</span></button>
                                    </div>

                                    <div class="modal-body">
                                        <div id="rows">

                                            <fieldset class="mb-1" style="">
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <h5>Workflow</h5>
                                                        <select class="form-control round" v-model="flow.workflow_id" required>
                                                            <option value=""> Select </option>
                                                            <option v-for="workflow in workflows" v-bind:key="workflow.id" v-bind:value="workflow.id">
                                                                {{ workflow.name }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5>Flow Name</h5>
                                                        <input type="text" class="form-control round" v-model="flow.name" style="padding:20px" required>
                                                    </div>  
                                                </div>
                                            </fieldset>

                                            <fieldset class="mb-1" style="margin-top:-30px">
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <h5>Action Type</h5>
                                                        <select class="form-control round" v-model="flow.action_id" required>
                                                            <option value=""> Select </option>
                                                            <option v-for="action in actions"  v-bind:key="action.id" v-bind:value="action.id">
                                                                {{ action.name }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h5>Authorized User</h5>
                                                        <select class="form-control round" v-model="flow.user_role_id" required>
                                                            <option value=""> Select </option>
                                                            <option v-for="user in users"  v-bind:key="user.id" v-bind:value="user.id">
                                                                {{ user.firstname }}  {{ user.lastname }}
                                                            </option>
                                                        </select>
                                                    </div>  
                                                    <div class="col-md-4">
                                                        <h5>Position</h5>
                                                        <input type="text" class="form-control round" v-model="flow.position" style="padding:20px" required>
                                                    </div>  
                                                </div>
                                            
                                                <!-- <button type="button" id="plusBtn" class="btn btn-outline-success btn-glow round pull-left"
                                                title="Add Another Flow Below" @mouseleave="fillWorkflow()">  <i class="la la-plus"></i></button>  -->
                                            </fieldset>   
                                         


                                        </div>  

                                        
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-outline-warning btn-glow btn-sm round">Clear</button>
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
                workflows: [],
                w_flows: [],
                users: [],
                actions: [],
                flows: [], 
                flow: {
                    id: '',
                    workflow_id: '',
                    name: '',
                    action_id: '',
                    position: '',
                    user_role_id: ''
                },
                flow_id: '',
                pagination: {},
                edit: false
            }
        },


        computed: {
            filteredFlows: function()
            {
                return this.flows.filter((flow) => {
                    return flow.name.toLowerCase().match(this.search.toLowerCase()) ||
                           flow.workflow.name.toLowerCase().match(this.search.toLowerCase()) || 
                           flow.action.name.toLowerCase().match(this.search.toLowerCase()) ||
                           flow.position.toString().match(this.search.toString()) ||  
                           flow.user.firstname.toLowerCase().match(this.search.toLowerCase()) || 
                           flow.user.lastname.toLowerCase().match(this.search.toLowerCase()) 
                });
            }

        },


        created()
        {
            this.fetchFlows();
            this.fetchAllFlows();
            this.fetchWorkflows();
            this.fetchUsers();
            this.fetchActions();
        },

        methods:{

            fetchAllFlows(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/flows?all=1'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.flows = res.data;
                })
                .catch(err => console.log(err));
            },

            fetchFlows(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/flows'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.flows = res.data;
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

            deleteFlow(id)
            {
                if(confirm('Are You Sure You Want To Delete This Flow Details?'))
                {
                    fetch(`api/flow/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        toastr.success('The Flow Record Has Been Deleted');
                        this.fetchFlows();
                        this.edit = false;
                    })
                    .catch(err => console.log(err));
                }
            },

            addFlow()
            {
                if(this.edit === false)
                {
                    this.edit = false;
                    fetch('api/flow', 
                    {
                        method: 'post',
                        body: JSON.stringify(this.flow),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm()
                        toastr.success('Flow Has Been created Successfully');
                        this.fetchFlows();
                        this.edit = false;
                    })
                    .catch(err => console.log(err)); 
                    $('#addFlowModal').trigger('click');

                }
                else
                {
                    fetch('api/flow', 
                    {
                        method: 'put',
                        body: JSON.stringify(this.flow),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm();
                        toastr.success('Flow Has Been Updated');
                        this.fetchFlows();
                        this.edit = false;
                    }) 
                    .catch(err => console.log(err));
                    $('#addFlowModal').trigger('click');
                }
            },

            editFlow(flow)
            {
                this.edit = true;
                this.flow.id = flow.id;
                this.flow.flow_id = flow.id;
                this.flow.workflow_id = flow.workflow_id;
                this.flow.name = flow.name;
                this.flow.action_id = flow.action_id;
                this.flow.position = flow.position;
                this.flow.user_role_id = flow.user_role_id;
            },



            clearForm()
            {
                this.flow.name = '';
                this.flow.workflow_id = '';
                this.flow.action_id = '';
                this.flow.position = '';
                this.flow.user_role_id = '';
            },

            fetchWorkflows()
            {
                let workflows = '/api/workflows'
                fetch(workflows)
                .then(res => res.json())
                .then(res => {
                    this.workflows = res.data;
                })
                .catch(err => console.log(err));            
            },

            fetchUsers()
            {
                let users = '/api/users'
                fetch(users)
                .then(res => res.json())
                .then(res => {
                    this.users = res.data;
                })
                .catch(err => console.log(err));            
            },

            fetchActions()
            {
                let actions = '/api/actions'
                fetch(actions)
                .then(res => res.json())
                .then(res => {
                    this.actions = res.data;
                })
                .catch(err => console.log(err));            
            },

            fillWorkflow()
            {
                let w_flows = '/api/workflows'
                fetch(w_flows)
                .then(res => res.json())
                .then(res => {
                    this.w_flows = res.data;
                })
                .catch(err => console.log(err));           
            },
        }
    };


    $(function ()
    {       
        //for Part
        var i = 0;      var c = 0;
        $('#plusBtn').on('click', function ()            //
        {
            i++;  
            $('#rows').append(
            '<span id="row'+i+'"> <fieldset class="mb-1" style=""> <div class="form-group row">  <div class="col-md-6"> <h5>Workflow</h5>  <select class="form-control round" id="wflow'+i+'" required>  <option value=""> Select </option>  <option v-for="wflow in w_flows"  v-bind:key="workflow.id" v-bind:value="workflow.id"> {{ workflow.name }}  </option> </select>  </div>  <div class="col-md-6">  <h5>Flow Name</h5>   <input type="text" class="form-control round" required>  </div>  </div>   </fieldset> <fieldset class="mb-1" style="margin-top:-30px">  <div class="form-group row">  <div class="col-md-6">     <h5>Type</h5>    <select class="form-control round" required>   <option value=""> Select Type</option>  <option value="1"> Role Based</option>   <option value="2"> User Based</option>   </select>     </div>   <div class="col-md-6">  <h5>User / Role Name</h5>    <select class="form-control round"> <option value=""> Select </option>  <option>  </option>  </select>   </div>   </div>                                          <input type="text" class="form-control round" name="count" id="count">                                         <button type="button" id="plusBtn" class="btn btn-outline-success btn-glow round pull-left" title="Add Another Flow Below">  <i class="la la-plus"></i></button>            <button type="button" id="'+i+'" class="btn btn-outline-danger btn-glow round pull-right btn_remove" title="Remove This Flow">  <i class="la la-trash"></i></button> </fieldset>      </span>'                      
        );
           
        });
        
        //Function To load all labour Description
        //getLabour();
        
        
        $(document).on('click', '.btn_remove', function ()
        {
            var button_id = $(this).attr("id");
            $('#row'+button_id+"").remove();
            
            //reducing the count value
            document.getElementById('count').value = --i;
            
        });
            
    });
</script>



