<template>
    <div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row" style="margin-top-25px">
        <div class="content-header-left col-xl-9 col-md-7 col-sm-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Budgets</h3> 
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a>
                </li>
                <li class="breadcrumb-item active">Budgets
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
            <button class="btn btn-primary round btn-glow px-2" type="button" data-animation="pulse" data-toggle="modal" data-target="#addBudgetModal" @click="clearForm()">New</button>
          </div>
        </div>
      </div>


      <div class="content-body" style="margin-top: -8px">
        <!-- Basic Tables start -->
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h4 class="card-title">Budgets</h4>
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
                          <th>Budget</th>
                          <th>Year</th>
                          <!-- <th>Type</th> -->
                          <th>Amount</th>
                          <th>Balance</th>
                          <th>End Date</th>
                          <th>Department</th>
                          <th>Flow Stage</th>
                          <th style="text-align:right">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr style="background: #fff;" v-for="budget in filteredBudgets" v-bind:key="budget.id">
                            <td>{{budget.name}}</td>
                            <td>{{budget.year}}</td>
                            <!-- <td>{{budget.type_id}}</td> -->
                            <td>{{budget.amount}}</td>
                            <td>{{budget.balance}}</td>
                            <td>{{budget.end_date}}</td>
                            <td>{{budget.department.name}}</td>
                            <td>
                                <div v-if="budget.flow_stage_id === 1"> 
                                    <span class="badge badge-pill badge-secondary badge-glow"> {{budget.action.name}} </span> 
                                </div>
                                <div v-if="budget.flow_stage_id === 2"> 
                                    <span class="badge badge-pill badge-danger badge-glow"> {{budget.action.name}} </span>
                                </div>
                                <div v-if="budget.flow_stage_id === 3"> 
                                    <span class="badge badge-pill badge-warning badge-glow"> {{budget.action.name}} </span> 
                                </div>
                                <div v-if="budget.flow_stage_id === 4"> 
                                    <span class="badge badge-pill badge-success badge-glow"> {{budget.action.name}} </span> 
                                </div>
                            </td>
                            <td style="text-align:right">
                                <a class="pull-right" @click="deleteBudget(budget.id)"><span class="la times-circle text-inverse m-r-10" style="margin :1px 2px; color: red;"></span>
                                </a>
                                
                                <span v-if="budget.flow_stage_id === 2"> 
                                    <a class="pull-right" data-toggle="modal" data-target="#approveBudgetModal" title="Review Budget" 
                                        @click="approveBudget(budget)"><span class="la la-registered text-inverse m-r-10" style="margin :1px 2px; color: #396;"></span>
                                    </a> 
                                </span>
                                <span v-else-if="budget.flow_stage_id === 3"> 
                                    <a class="pull-right" data-toggle="modal" data-target="#approveBudgetModal" title="Approve Budget" 
                                        @click="approveBudget(budget)"><span class="la la-check text-inverse m-r-10" style="margin :1px 2px; color: #396;"></span>
                                    </a> 
                                </span>
                                <!-- <span v-else-if="budget.flow_stage_id === 4"> -->
                                    <a class="pull-right">
                                        <router-link class="" v-bind:to="'/budget-details/' + budget.id" style="">
                                            <span class="la la-eye text-inverse m-r-10" title="View Budget Imprests" style="margin :1px 2px; color:#6cb2eb"></span>
                                        </router-link>
                                    </a> 
                                <!-- </span> -->

                                <a class="pull-right" data-toggle="modal" data-target="#addBudgetModal" 
                                    @click="editBudget(budget)"><span class="la la-pencil text-inverse m-r-10" style="margin :1px 2px; color: #396;"></span>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
            

                    <nav aria-label="Page navigation example pull-right">
                        <ul class="pagination justify-content-end pagination-separate pagination-round mb-1" style="">
                            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                                <a class="page-link pagi-btn"aria-label="Previous" href="#" @click="fetchBudgets(pagination.prev_page_url)">
                                << Prev</i></a>
                            </li>
                            <li class="page-item disabled"><a class="page-link text-dark pagi-btn" href="#">Page {{pagination.current_page}} of {{pagination.last_page}} </a></li>
                            <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                                <a class="page-link pagi-btn"aria-label="Next" href="#" @click="fetchBudgets(pagination.next_page_url)">
                                Next >> </a>
                            </li>
                        </ul>
                    </nav>







                    <!-- Modal -->
                    <form @submit.prevent="addBudget">
                        <div class="modal animated rollin text-left" id="addBudgetModal" tabindex="-1" role="dialog" style="">
                            <div class="modal-dialog modal-lg" role="document" style="">
                                    <div class="modal-content" style="">

                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Add Budget</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color:red">X</span></button>
                                    </div>

                                    <div class="modal-body">

                                        <fieldset class="mb-1">
                                            <h5>Budget Name</h5>
                                            <div class="form-group">
                                            <input type="text" class="form-control round" v-model="budget.name" required>
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px">
                                            <h5>Description</h5>
                                            <div class="form-group">
                                            <textarea rows="2" class="form-control" v-model="budget.description" required></textarea>
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h5>Budget Type</h5>
                                                    <select class="form-control round" v-model="budget.type_id" required>
                                                        <option value=""></option>
                                                        <option value="1">Type One</option>
                                                        <option value="2">Type Two</option>
                                                        <option value="3">Others</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                <h5>Department</h5>
                                                    <select class="form-control round" v-model="budget.department_id" required>
                                                        <option value=""> </option>
                                                        <option v-for="department in departments"  v-bind:key="department.id" v-bind:value="department.id"> {{ department.name }} </option>
                                                    </select>
                                                </div>  
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h5>Amount</h5>
                                                    <input type="number" step="0.01" class="form-control round" v-model="budget.amount" required>
                                                </div>

                                                <div class="col-md-6">
                                                    <h5>Year</h5>
                                                    <input type="text" class="form-control round" v-model="budget.year" required>
                                                </div>
                                            </div>                                            
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h5>End Date</h5>
                                                    <input type="date" class="form-control input-lg round" id="dropBorder" v-model="budget.end_date" required>
                                                </div>

                                                <div class="col-md-6">
                                                <h5>Workflow</h5>
                                                    <select class="form-control round" v-model="budget.workflow_id" required>
                                                        <option value=""> </option>
                                                        <option v-for="workflow in workflows"  v-bind:key="workflow.id" v-bind:value="workflow.id">
                                                            {{ workflow.name }}
                                                        </option>
                                                    </select>
                                                </div>  
                                            </div>
                                        </fieldset>


                                        
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-danger btn-glow btn-sm round" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-dark btn-sm round">Save Details</button>
                                        </div>

                                    </div>
                                </div><!-- modal-content -->
                            </div><!-- modal-dialog -->
                        </div><!-- modal -->
                    </form>


                    



                    <!-- Approve Budget modal -->
                    <form @submit.prevent="approve">
                    <input type="hidden" name="token" id="token" value="">
                        <div class="modal animated rollin text-left" id="approveBudgetModal" tabindex="-1" role="dialog" style="">
                            <div class="modal-dialog modal-sm" role="document" style="">
                                    <div class="modal-content" style="">

                                    <div class="modal-header">
                                        <h4 class="modal-title text-danger" id="myModalLabel"> Budpress Info! </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color:red">X</span></button>
                                    </div>

                                    <div class="modal-body">

                                        <span v-if="budget.flow_stage_id === 2">
                                            <fieldset class="mb-1" style="">
                                                <div class="form-group">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        Are You Sure You Have Reviewed This Budget ?
                                                    </h4>
                                                </div>
                                            </fieldset>

                                            <fieldset class="mb-1">
                                                <h5>Review</h5>
                                                <div class="form-group">
                                                    <select class="form-control round" v-model="budget.actions" required>
                                                        <option value="2">Reviewed</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </span>
                                        
                                        <span v-if="budget.flow_stage_id === 3">
                                            <fieldset class="mb-1" style="">
                                                <div class="form-group">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        Are You Sure You Want To Approve This Budget ?
                                                    </h4>
                                                </div>
                                            </fieldset>

                                            <fieldset class="mb-1">
                                                <h5>Approve</h5>
                                                <div class="form-group">
                                                    <select class="form-control round" v-model="budget.actions" required>
                                                        <option value="3">Approve</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </span>



                                        

                                        




                                         <fieldset class="mb-1" style="display: none">
                                            <h5>Budget Name</h5>
                                            <div class="form-group">
                                            <input type="text" class="form-control round" v-model="budget.name" required>
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px; display: none">
                                            <h5>Description</h5>
                                            <div class="form-group">
                                            <textarea rows="2" class="form-control" v-model="budget.description" required></textarea>
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px; display: none">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h5>Budget Type</h5>
                                                    <select class="form-control round" v-model="budget.type_id" required>
                                                        <option value=""></option>
                                                        <option value="1">Type One</option>
                                                        <option value="2">Type Two</option>
                                                        <option value="3">Others</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                <h5>Department</h5>
                                                    <select class="form-control round" v-model="budget.department_id" required>
                                                        <option value=""> </option>
                                                        <option v-for="department in departments"  v-bind:key="department.id" v-bind:value="department.id"> {{ department.name }} </option>
                                                    </select>
                                                </div>  
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px; display: none">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h5>Amount</h5>
                                                    <input type="number" step="0.01" class="form-control round" v-model="budget.amount" required>
                                                </div>

                                                <div class="col-md-6">
                                                    <h5>Year</h5>
                                                    <input type="text" class="form-control round" v-model="budget.year" required>
                                                </div>
                                            </div>                                            
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px; display: none">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h5>End Date</h5>
                                                    <input type="date" class="form-control input-lg round" id="dropBorder" v-model="budget.end_date" required>
                                                </div>

                                                <div class="col-md-6">
                                                <h5>Workflow</h5>
                                                    <select class="form-control round" v-model="budget.workflow_id" required>
                                                        <option value=""> </option>
                                                        <option v-for="workflow in workflows"  v-bind:key="workflow.id" v-bind:value="workflow.id">
                                                            {{ workflow.name }}
                                                        </option>
                                                    </select>
                                                </div>  
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
                departments: [],
                workflows: [],
                budgets: [], 
                budget: {
                    id: '',
                    name: '',
                    year: '',
                    description: '',
                    type_id: '',
                    department_id: '',
                    amount: '',
                    end_date: '',
                    balance: '',
                    workflow_id: '',
                    flow_stage_id: '',
                    actions: ''
                },
                budget_id: '',
                pagination: {},
                edit: false,
                csrf: '{{csrf_token()}}',



                data:{
                    action_name_id:'',
                    _token:Laravel.csrfToken,

                }
                

            }
        },


        computed: {
            filteredBudgets: function()
            {
                return this.budgets.filter((budget) => {
                    return budget.name.toLowerCase().match(this.search.toLowerCase()) ||
                           budget.description.toLowerCase().match(this.search.toLowerCase()) || 
                           budget.type_id.toString().match(this.search.toString()) || 
                           budget.department.name.toLowerCase().match(this.search.toLowerCase()) || 
                           budget.amount.toString().match(this.search.toString()) || 
                           budget.year.toString().match(this.search.toString()) || 
                           budget.end_date.toString().match(this.search.toString()) 
                });
            }

        },


        created()
        {
            this.fetchAllBudgets();
            this.fetchBudgets();
            this.fetchWorkflows();
            this.fetchDepartments();
            this.fetchBalances();
        },

        methods:{

            fetchAllBudgets(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/budgets?all=1'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.budgets = res.data;
                })
                .catch(err => console.log(err));
            },


            fetchBudgets(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/budgets'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.budgets = res.data;
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

            deleteBudget(id)
            {
                if(confirm('Are You Sure You Want To Delete This Budget Details?'))
                {
                    fetch(`api/budget/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        toastr.success('The Budget Record Has Been Deleted');
                        this.fetchBudgets();
                        this.edit = false;
                    })
                    .catch(err => console.log(err));
                }
            },

            addBudget()
            {
                if(this.edit === false)
                {
                    fetch('api/budget', 
                    {
                        method: 'post',
                        body: JSON.stringify(this.budget),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm()
                        toastr.success('Budget Has Been created Successfully');
                        this.fetchBudgets();
                        this.edit = false;
                    })
                    .catch(err => console.log(err)); 
                    $('#addBudgetModal').trigger('click');

                }
                else
                {
                    fetch('api/budget', 
                    {
                        method: 'put',
                        body: JSON.stringify(this.budget),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm();
                        toastr.success('Budget Has Been Updated');
                        this.fetchBudgets();
                        this.edit = false;
                    }) 
                    .catch(err => console.log(err));
                    $('#addBudgetModal').trigger('click');
                }
            },

            editBudget(budget)
            {
                this.edit = true;
                this.budget.id = budget.id;
                this.budget.budget_id = budget.id;
                this.budget.name = budget.name;
                this.budget.year = budget.year;
                this.budget.description = budget.description;
                this.budget.type_id = budget.type_id;
                this.budget.department_id = budget.department_id;
                this.budget.amount = budget.amount;
                this.budget.end_date = budget.end_date;
                this.budget.balance = budget.balance;
                this.budget.workflow_id = budget.workflow_id;
            },



            clearForm()
            {
                this.budget.name = '';
                this.budget.year = '';
                this.budget.description = '';
                this.budget.type_id = '';
                this.budget.department_id = '';
                this.budget.amount = '';
                this.budget.end_date = '';
                this.budget.balance = '';
                this.budget.workflow_id = '';
            },

            

            approveBudget(budget)
            {
                this.budget.actions = budget.actions;
                this.edit = true;
                this.budget.id = budget.id;
                this.budget.budget_id = budget.id;
                this.budget.name = budget.name;
                this.budget.year = budget.year;
                this.budget.description = budget.description;
                this.budget.type_id = budget.type_id;
                this.budget.department_id = budget.department_id;
                this.budget.amount = budget.amount;
                this.budget.end_date = budget.end_date;
                this.budget.balance = budget.balance;
                this.budget.workflow_id = budget.workflow_id;
                this.budget.flow_stage_id = budget.flow_stage_id;
            },


            approve()
            {
                fetch('api/budget', 
                {
                    method: 'put',
                    body: JSON.stringify(this.budget),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    
                    this.budget.actions = '';
                    toastr.success('Budget Has Been Reviewed / Approved');
                    this.fetchBudgets();
                    this.edit = false;
                }) 
                .catch(err => console.log(err));
                $('#approveBudgetModal').trigger('click');
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

            setId(id)
            {
                $('#action_name_id').val(id);   
            },

            fetchBalances(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/get-budget-balances'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.balance = res.data;
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
            },

            
        }
            
    };

    
    
            

        //FOR EXTERNAL USERS
        $(function()
        {   
            $("#approve-form").on('submit', function(e)
            {           
                $.ajax({
                    url:'http://localhost:8000/approve-budget',
                    data:{
                        action_name_id:$('#action_name_id').val(),
                        _token:'{{csrf_token()}}'
                    },
                    type:'POST',
                    success:function(data)
                    {
                        $('#approveBudgetModal').modal('hide');
                        return toastr.success('Budget Was Approved Successfully');           
                    },
                    error:function()
                    {
                        toastr.error('Sorry, An Error Occurred Please Try Again.');           
                    } 
                });

                return e.preventDefault();
            });

        });
    
</script>