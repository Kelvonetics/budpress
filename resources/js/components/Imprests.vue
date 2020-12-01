<template>
    <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row" style="margin-top-25px">
        <div class="content-header-left col-xl-9 col-md-7 col-sm-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Imprests</h3> 
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a>
                </li>
                <li class="breadcrumb-item active">Imprests
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
            <button class="btn btn-primary round btn-glow px-2 pull-right" type="button" data-animation="pulse" data-toggle="modal" data-target="#addImprestModal" @click="clearForm()">New</button>
          </div>
        </div>
      </div>


      <div class="content-body" style="margin-top: -8px">
        <!-- Basic Tables start -->
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h4 class="card-title">Imprests </h4> 
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

              <div class="card-content collapse show" style="margin-top: -25px">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover table-xs">
                      <thead class="thead-dark">
                        <tr>
                          <th>Imprest</th>
                          <th>Year</th>
                          <!-- <th>Description</th> -->
                          <!-- <th>Workflow</th> -->
                          <th>Budget</th>
                          <th>Department</th>
                          <th>Amount</th>
                          <th>Balance</th>
                          <th>Duration</th>
                          <th>Flow Stage</th>
                          <th style="text-align:right">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr style="background: #fff;" v-for="imprest in filteredImprests" v-bind:key="imprest.id">
                            <td>{{imprest.name}}</td>
                            <td>{{imprest.year}}</td>
                            <!-- <td>{{imprest.workflow.name}}</td> -->
                            <td>{{imprest.budget.name}}</td>
                            <td>{{imprest.department.name}}</td>
                            <td>{{imprest.amount}}</td>
                            <!-- <td>{{imprest.type_id}}</td> -->
                            <td>{{imprest.balance}}</td>
                            <td>{{imprest.start_date}} - {{imprest.end_date}}</td>
                            <td>
                                <div v-if="imprest.flow_stage_id === 1"> 
                                    <span class="badge badge-pill badge-secondary badge-glow"> {{imprest.action.name}} </span> 
                                </div>
                                <div v-if="imprest.flow_stage_id === 2"> 
                                    <span class="badge badge-pill badge-danger badge-glow"> {{imprest.action.name}} </span>
                                </div>
                                <div v-if="imprest.flow_stage_id === 3"> 
                                    <span class="badge badge-pill badge-warning badge-glow"> {{imprest.action.name}} </span> 
                                </div>
                                <div v-if="imprest.flow_stage_id === 4"> 
                                    <span class="badge badge-pill badge-success badge-glow"> {{imprest.action.name}} </span> 
                                </div>
                            </td>
                            <td>
                                <a class="pull-right" @click="deleteImprest(imprest.id)"><span class="la times-circle text-inverse m-r-10" style="margin :1px 2px; color: red"></span>
                                </a>
                                
                                <span v-if="imprest.flow_stage_id === 2"> 
                                    <a class="pull-right" data-toggle="modal" data-target="#approveImprestModal" title="Review Imprest" 
                                        @click="approveImprest(imprest)"><span class="la la-eye text-inverse m-r-10" style="margin :1px 2px; color: #396;"></span>
                                    </a> 
                                </span>
                                <span v-else-if="imprest.flow_stage_id === 3"> 
                                    <a class="pull-right" data-toggle="modal" data-target="#approveImprestModal" title="Approve Imprest" 
                                        @click="approveImprest(imprest)"><span class="la la-check text-inverse m-r-10" style="margin :1px 2px; color: #396;"></span>
                                    </a> 
                                </span>
                                <span v-else-if="imprest.flow_stage_id === 1 || imprest.flow_stage_id > 3">
                                    <a class="pull-right"> <span class="la la-registered text-inverse m-r-10" style="margin :1px 2px; color:#fff"></span>  </a> 
                                </span>
                                <a class="pull-right" data-toggle="modal" data-target="#addImprestModal" 
                                    @click="editImprest(imprest)"><span class="la la-pencil text-inverse m-r-10" style="margin :1px 2px; color: #396"></span>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
            

                    <nav aria-label="Page navigation example pull-right">
                        <ul class="pagination justify-content-end pagination-separate pagination-round mb-1" style="">
                            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                                <a class="page-link pagi-btn"aria-label="Previous" href="#" @click="fetchImprests(pagination.prev_page_url)">
                                << Prev</i></a>
                            </li>
                            <li class="page-item disabled"><a class="page-link text-dark pagi-btn" href="#">Page {{pagination.current_page}} of {{pagination.last_page}} </a></li>
                            <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                                <a class="page-link pagi-btn"aria-label="Next" href="#" @click="fetchImprests(pagination.next_page_url)">
                                Next >> </a>
                            </li>
                        </ul>
                    </nav>







                    <!-- Modal -->
                    <form @submit.prevent="addImprest">
                        <div class="modal animated rollin text-left" id="addImprestModal" tabindex="-1" role="dialog" style="">
                            <div class="modal-dialog modal-lg" role="document" style="">
                                    <div class="modal-content" style="">

                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Add Imprest</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color:red">X</span></button>
                                    </div>

                                    <div class="modal-body">

                                        <fieldset class="mb-1" style="margin-bottom:-30px">
                                            <h5>Imprest Name</h5>
                                            <div class="form-group">
                                            <input type="text" class="form-control round" v-model="imprest.name" required>
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px">
                                            <h5>Imprest Description</h5>
                                            <div class="form-group">
                                            <textarea rows="2" class="form-control" v-model="imprest.description" required></textarea>
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                <h5>Budget</h5>
                                                    <select class="form-control round" v-model="imprest.budget_id" required>
                                                        <option value=""> </option>
                                                        <option v-for="budget in budgets"  v-bind:key="budget.id" v-bind:value="budget.id">
                                                            {{ budget.name }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5>Workflow</h5>
                                                    <select class="form-control round" v-model="imprest.workflow_id" required>
                                                        <option value=""> </option>
                                                        <option v-for="workflow in workflows"  v-bind:key="workflow.id" v-bind:value="workflow.id">
                                                            {{ workflow.name }}
                                                        </option>
                                                    </select>
                                                </div>  
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                <h5>Type</h5>
                                                    <select class="form-control round" v-model="imprest.type_id" required>
                                                        <option value=""></option>
                                                        <option value="1">Type One</option>
                                                        <option value="2">Type Two</option>
                                                        <option value="3">Others</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5>Department</h5>
                                                    <select class="form-control round" v-model="imprest.department_id" required>
                                                        <option value=""> </option>
                                                        <option v-for="department in departments"  v-bind:key="department.id" v-bind:value="department.id">
                                                            {{ department.name }}
                                                        </option>
                                                    </select>
                                                </div>  
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h5>Amount</h5>
                                                    <input type="number" step="0.01" class="form-control round" v-model="imprest.amount" required>
                                                </div>

                                                <div class="col-md-6">
                                                    <h5>Year</h5>
                                                    <input type="text" class="form-control round" v-model="imprest.year" required>
                                                </div>
                                            </div>                                            
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                <h5>Start Date</h5>
                                                    <input type="date" class="form-control round pull-left" id="dropBorder" v-model="imprest.start_date" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5>End Date</h5>
                                                    <input type="date" class="form-control round pull-left" id="dropBorder2" v-model="imprest.end_date" required>
                                                </div>  
                                            </div>
                                        </fieldset>

                                                                               
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


                    

                    <!-- Approve Imprest modal -->
                    <form @submit.prevent="approve">
                    <input type="hidden" name="token" id="token" value="">
                        <div class="modal animated rollin text-left" id="approveImprestModal" tabindex="-1" role="dialog" style="">
                            <div class="modal-dialog modal-sm" role="document" style="">
                                    <div class="modal-content" style="">

                                    <div class="modal-header">
                                        <h4 class="modal-title text-danger" id="myModalLabel"> Budpress Info! </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color:red">X</span></button>
                                    </div>

                                    <div class="modal-body">

                                        <span v-if="imprest.flow_stage_id === 2">
                                            <fieldset class="mb-1" style="">
                                                <div class="form-group">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        Are You Sure You Have Reviewed This Imprest ?
                                                    </h4>
                                                </div>
                                            </fieldset>

                                            <fieldset class="mb-1">
                                                <h5>Review</h5>
                                                <div class="form-group">
                                                    <select class="form-control round" v-model="imprest.actions" required>
                                                        <option value="2" selected="true">Reviewed</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </span>
                                        
                                        <span v-if="imprest.flow_stage_id === 3">
                                            <fieldset class="mb-1" style="">
                                                <div class="form-group">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        Are You Sure You Want To Approve This Imprest ?
                                                    </h4>
                                                </div>
                                            </fieldset>

                                            <fieldset class="mb-1">
                                                <h5>Approve</h5>
                                                <div class="form-group">
                                                    <select class="form-control round" v-model="imprest.actions" required>
                                                        <option value="3" selected>Approve</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </span>



                                        

                                        




                                         <fieldset class="mb-1" style="margin-bottom:-30px; display: none">
                                            <h5>Imprest Name</h5>
                                            <div class="form-group">
                                                <input type="text" class="form-control round" v-model="imprest.name" required>
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px; display: none">
                                            <h5>Imprest Description</h5>
                                            <div class="form-group">
                                                <textarea rows="2" class="form-control" v-model="imprest.description" required></textarea>
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px; display: none">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                <h5>Budget</h5>
                                                    <select class="form-control round" v-model="imprest.budget_id" required>
                                                        <option value=""> </option>
                                                        <option v-for="budget in budgets"  v-bind:key="budget.id" v-bind:value="budget.id">
                                                            {{ budget.name }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5>Workflow</h5>
                                                    <select class="form-control round" v-model="imprest.workflow_id" required>
                                                        <option value=""> </option>
                                                        <option v-for="workflow in workflows"  v-bind:key="workflow.id" v-bind:value="workflow.id">
                                                            {{ workflow.name }}
                                                        </option>
                                                    </select>
                                                </div>  
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px; display: none">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                <h5>Type</h5>
                                                    <select class="form-control round" v-model="imprest.type_id" required>
                                                        <option value=""></option>
                                                        <option value="1">Type One</option>
                                                        <option value="2">Type Two</option>
                                                        <option value="3">Others</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5>Department</h5>
                                                    <select class="form-control round" v-model="imprest.department_id" required>
                                                        <option value=""> </option>
                                                        <option v-for="department in departments"  v-bind:key="department.id" v-bind:value="department.id">
                                                            {{ department.name }}
                                                        </option>
                                                    </select>
                                                </div>  
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px; display: none">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h5>Amount</h5>
                                                    <input type="number" step="0.01" class="form-control round" v-model="imprest.amount" required>
                                                </div>

                                                <div class="col-md-6">
                                                    <h5>Year</h5>
                                                    <input type="text" class="form-control round" v-model="imprest.year" required>
                                                </div>
                                            </div>                                            
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px; display: none">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                <h5>Start Date</h5>
                                                    <input type="date" class="form-control round pull-left" id="dropBorder" v-model="imprest.start_date" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5>End Date</h5>
                                                    <input type="date" class="form-control round pull-left" id="dropBorder2" v-model="imprest.end_date" required>
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
                budgets: [], 
                workflows: [], 

                imprests: [], 
                imprest: {
                    id: '',
                    name: '',
                    description: '',
                    workflow_id: '',
                    budget_id: '',
                    type_id: '',
                    department_id: '',
                    amount: '',
                    year: '',
                    start_date: '',
                    end_date: '',
                    balance: '',
                    status_id: '',
                    flow_stage_id: '',
                    actions: ''
                },
                imprest_id: '',
                pagination: {},
                edit: false
            }
        },


        computed: {
            filteredImprests: function()
            {
                return this.imprests.filter((imprest) => {
                    return imprest.name.toLowerCase().match(this.search.toLowerCase()) ||
                           imprest.description.toLowerCase().match(this.search.toLowerCase()) || 
                           imprest.workflow.name.toLowerCase().match(this.search.toLowerCase()) || 
                           imprest.budget.name.toLowerCase().match(this.search.toLowerCase()) || 
                           imprest.year.toString().match(this.search.toString()) || 
                           imprest.department.name.toLowerCase().match(this.search.toLowerCase())  || 
                           imprest.amount.toString().match(this.search.toString())  || 
                           imprest.start_date.toString().match(this.search.toString())  || 
                           imprest.end_date.toString().match(this.search.toString())
                });
            }

        },


        created()
        {
            this.fetchImprests();
            this.fetchBudgets();
            this.fetchWorkflows();
            this.fetchDepartments();
        },

        methods:{

            fetchBudgets()
            {
                let budgets = '/api/budgets'
                fetch(budgets)
                .then(res => res.json())
                .then(res => {
                    this.budgets = res.data;
                })
                .catch(err => console.log(err));            
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


            fetchAllImprests(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/imprests?all=1'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.imprests = res.data;
                })
                .catch(err => console.log(err));
            },


            fetchImprests(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/imprests'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.imprests = res.data;
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

            deleteImprest(id)
            {
                if(confirm('Are You Sure You Want To Delete This Imprest Details?'))
                {
                    fetch(`api/imprest/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        toastr.success('The Imprest Record Has Been Deleted');
                        this.fetchImprests();
                        this.edit = false;
                    })
                    .catch(err => console.log(err));
                }
            },

            addImprest()
            {
                if(this.edit === false)
                {
                    fetch('api/imprest', 
                    {
                        method: 'post',
                        body: JSON.stringify(this.imprest),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm()
                        toastr.success('Imprest Has Been created Successfully');
                        this.fetchImprests();
                        this.edit = false;
                    })
                    .catch(err => console.log(err)); 
                    $('#addImprestModal').trigger('click');

                }
                else
                {
                    fetch('api/imprest', 
                    {
                        method: 'put',
                        body: JSON.stringify(this.imprest),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm();
                        toastr.success('Imprest Has Been Updated');
                        this.fetchImprests();
                        this.edit = false;
                    }) 
                    .catch(err => console.log(err));
                    $('#addImprestModal').trigger('click');
                }
            },

            editImprest(imprest)
            {
                this.edit = true;
                this.imprest.id = imprest.id;
                this.imprest.imprest_id = imprest.id;
                this.imprest.name = imprest.name;
                this.imprest.description = imprest.description;
                this.imprest.workflow_id = imprest.workflow_id;
                this.imprest.budget_id = imprest.budget_id;
                this.imprest.type_id = imprest.type_id;
                this.imprest.department_id = imprest.department_id;
                this.imprest.amount = imprest.amount;
                this.imprest.year = imprest.year;
                this.imprest.start_date = imprest.start_date;
                this.imprest.end_date = imprest.end_date;
                this.imprest.balance = imprest.balance;
                this.imprest.status_id = imprest.status_id;
            },

            

            approveImprest(imprest)
            {
                this.imprest.actions = imprest.actions;
                this.edit = true;
                this.imprest.id = imprest.id;
                this.imprest.imprest_id = imprest.id;
                this.imprest.name = imprest.name;
                this.imprest.description = imprest.description;
                this.imprest.workflow_id = imprest.workflow_id;
                this.imprest.budget_id = imprest.budget_id;
                this.imprest.type_id = imprest.type_id;
                this.imprest.department_id = imprest.department_id;
                this.imprest.amount = imprest.amount;
                this.imprest.year = imprest.year;
                this.imprest.start_date = imprest.start_date;
                this.imprest.end_date = imprest.end_date;
                this.imprest.balance = imprest.balance;
                this.imprest.status_id = imprest.status_id;
                this.imprest.flow_stage_id = imprest.flow_stage_id;
            },


            approve()
            {
                fetch('api/imprest', 
                {
                    method: 'put',
                    body: JSON.stringify(this.imprest),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    
                    this.imprest.actions = '';
                    toastr.success('Imprest Has Been Reviewed / Approved');
                    this.fetchImprests();
                    this.edit = false;
                }) 
                .catch(err => console.log(err));
                $('#approveImprestModal').trigger('click');
            },



            clearForm()
            {
                this.imprest.name = '';
                this.imprest.description = '';
                this.imprest.workflow_id = '';
                this.imprest.budget_id = '';
                this.imprest.type_id = '';
                this.imprest.amount = '';
                this.imprest.year = '';
                this.imprest.start_date = '';
                this.imprest.end_date = '';
                this.imprest.balance = '';
            }
        }
    };
</script>