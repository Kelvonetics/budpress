<template>
    <div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row" style="margin-top-25px">
        <div class="content-header-left col-xl-9 col-md-7 col-sm-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Expenses</h3> 
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a>
                </li>
                <li class="breadcrumb-item active">Expenses
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
            <button class="btn btn-primary round btn-glow px-1" type="button" data-animation="pulse" data-toggle="modal" data-target="#addExpenseModal" @click="clearForm()"> New</button>
          </div>
        </div>
      </div>



      <div class="content-body" style="margin-top: -8px">
        <!-- Basic Tables start -->
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h4 class="card-title">Expenses</h4>
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
                          <th>year</th>
                          <th>Expense</th>
                          <th>Purpose</th>
                          <th>Imprest</th>
                          <th>Amount</th>
                          <th>Propose Date</th>
                          <th>Flow Stage</th>
                          <th style="text-align:right">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr style="background: #fff;" v-for="expense in filteredExpenses" v-bind:key="expense.id">
                            <td>{{expense.year}}</td>
                            <td>{{expense.name}}</td>
                            <td>{{expense.purpose}}</td>
                            <td>{{expense.imprest.name}}</td>
                            <!-- <td>
                              <span v-if="expense.type_id === 1"> Personal </span>
                              <span v-else-if="expense.type_id === 2"> Company</span>
                              <span v-else-if="expense.type_id === 3"> Others </span>
                            </td> -->
                            <td>{{expense.amount}}</td>
                            <td>{{expense.propose_date}}</td>
                            <td>
                                <div v-if="expense.flow_stage_id === 1"> 
                                    <span class="badge badge-pill badge-secondary badge-glow"> {{expense.action.name}} </span> 
                                </div>
                                <div v-if="expense.flow_stage_id === 2"> 
                                    <span class="badge badge-pill badge-danger badge-glow"> {{expense.action.name}} </span>
                                </div>
                                <div v-if="expense.flow_stage_id === 3"> 
                                    <span class="badge badge-pill badge-warning badge-glow"> {{expense.action.name}} </span> 
                                </div>
                                <div v-if="expense.flow_stage_id === 4"> 
                                    <span class="badge badge-pill badge-success badge-glow"> {{expense.action.name}} </span> 
                                </div>
                            </td>
                            <td>
                                <a class="pull-right" @click="deleteExpense(expense.id)"><span class="la times-circle text-inverse m-r-10" style="margin :1px 2px; color: red"></span>
                                </a>

                                <span v-if="expense.flow_stage_id === 2"> 
                                    <a class="pull-right" data-toggle="modal" data-target="#approveExpenceModal" title="Review Expence" 
                                        @click="approveExpense(expense)"><span class="la la-eye text-inverse m-r-10" style="margin :1px 2px; color: #396;"></span>
                                    </a> 
                                </span>
                                <span v-else-if="expense.flow_stage_id === 3"> 
                                    <a class="pull-right" data-toggle="modal" data-target="#approveExpenceModal" title="Approve Expence" 
                                        @click="approveExpense(expense)"><span class="la la-check text-inverse m-r-10" style="margin :1px 2px; color: #396;"></span>
                                    </a> 
                                </span>
                                <span v-else-if="expense.flow_stage_id === 1 || expense.flow_stage_id > 3">
                                    <a class="pull-right"> <span class="la la-registered text-inverse m-r-10" style="margin :1px 2px; color:#fff"></span>  </a> 
                                </span>

                                <a class="pull-right" data-toggle="modal" data-target="#addExpenseModal" 
                                    @click="editExpense(expense)"><span class="la la-pencil text-inverse m-r-10" style="margin :1px 2px; color: #396"></span>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
            

                    <nav aria-label="Page navigation example pull-right">
                        <ul class="pagination justify-content-end pagination-separate pagination-round mb-1" style="">
                            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                                <a class="page-link pagi-btn"aria-label="Previous" href="#" @click="fetchExpenses(pagination.prev_page_url)">
                                << Prev</i></a>
                            </li>
                            <li class="page-item disabled"><a class="page-link text-dark pagi-btn" href="#">Page {{pagination.current_page}} of {{pagination.last_page}} </a></li>
                            <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                                <a class="page-link pagi-btn"aria-label="Next" href="#" @click="fetchExpenses(pagination.next_page_url)">
                                Next >> </a>
                            </li>
                        </ul>
                    </nav>







                    <!-- Modal -->
                    <form @submit.prevent="addExpense">
                        <div class="modal animated rollin text-left" id="addExpenseModal" tabindex="-1" role="dialog" style="">
                            <div class="modal-dialog modal-lg" role="document" style="">
                                    <div class="modal-content" style="">

                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Add Expense</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color:red">X</span></button>
                                    </div>

                                    <div class="modal-body">

                                        <fieldset class="mb-1" style="margin-bottom:-30px">
                                            <h5>Expense Name</h5>
                                            <div class="form-group">
                                            <input type="text" class="form-control round" v-model="expense.name" required>
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px">
                                            <h5>Expense Purpose</h5>
                                            <div class="form-group">
                                            <textarea rows="2" class="form-control" v-model="expense.purpose" required></textarea>
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h5>Workflow</h5>
                                                    <select class="form-control round" v-model="expense.workflow_id" required>
                                                        <option value=""> </option>
                                                        <option v-for="workflow in workflows"  v-bind:key="workflow.id" v-bind:value="workflow.id">
                                                            {{ workflow.name }}
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                <h5>Imprest</h5>
                                                    <select class="form-control round" v-model="expense.imprest_id" required>
                                                        <option value=""> </option>
                                                        <option v-for="imprest in imprests"  v-bind:key="imprest.id" v-bind:value="imprest.id">
                                                            {{ imprest.name }}
                                                        </option>
                                                    </select>
                                                </div>  
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                <h5>Type</h5>
                                                    <select class="form-control round" v-model="expense.type_id" required>
                                                        <option value=""></option>
                                                        <option value="1">Personal</option>
                                                        <option value="2">Company</option>
                                                        <option value="3">Others</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5>Proposed Date</h5>
                                                    <input type="date" class="form-control round pull-left" id="dropBorder" v-model="expense.propose_date" required>
                                                </div>  
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h5>Amount</h5>
                                                    <input type="number" step="0.01" class="form-control round" v-model="expense.amount" required>
                                                </div>

                                                <div class="col-md-6">
                                                    <h5>Year</h5>
                                                    <input type="text" class="form-control round" v-model="expense.year" required>
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


                    

                    <!-- Approve Expense modal -->
                    <form @submit.prevent="approve">
                    <input type="hidden" name="token" id="token" value="">
                        <div class="modal animated rollin text-left" id="approveExpenceModal" tabindex="-1" role="dialog" style="">
                            <div class="modal-dialog modal-sm" role="document" style="">
                                    <div class="modal-content" style="">

                                    <div class="modal-header">
                                        <h4 class="modal-title text-danger" id="myModalLabel"> Budpress Info! </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color:red">X</span></button>
                                    </div>

                                    <div class="modal-body">

                                        

                                        <span v-if="expense.flow_stage_id === 2">
                                            <fieldset class="mb-1" style="">
                                                <div class="form-group">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        Are You Sure You Have Reviewed This Expense ?
                                                    </h4>
                                                </div>
                                            </fieldset>

                                            <fieldset class="mb-1">
                                                <h5>Review</h5>
                                                <div class="form-group">
                                                    <select class="form-control round" v-model="expense.actions" required>
                                                        <option value="2" selected="true">Reviewed</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </span>
                                        
                                        <span v-if="expense.flow_stage_id === 3">
                                            <fieldset class="mb-1" style="">
                                                <div class="form-group">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        Are You Sure You Want To Approve This Expense ?
                                                    </h4>
                                                </div>
                                            </fieldset>

                                            <fieldset class="mb-1">
                                                <h5>Approve</h5>
                                                <div class="form-group">
                                                    <select class="form-control round" v-model="expense.actions" required>
                                                        <option value="3" selected>Approve</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </span>






                                        <fieldset class="mb-1" style="margin-bottom:-30px; display: none; display: none">
                                            <h5>Expense Name</h5>
                                            <div class="form-group">
                                            <input type="text" class="form-control round" v-model="expense.name" required>
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px; display: none; display: none">
                                            <h5>Expense Purpose</h5>
                                            <div class="form-group">
                                            <textarea rows="2" class="form-control" v-model="expense.purpose" required></textarea>
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px; display: none; display: none">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h5>Workflow</h5>
                                                    <select class="form-control round" v-model="expense.workflow_id" required>
                                                        <option value=""> </option>
                                                        <option v-for="workflow in workflows"  v-bind:key="workflow.id" v-bind:value="workflow.id">
                                                            {{ workflow.name }}
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                <h5>Imprest</h5>
                                                    <select class="form-control round" v-model="expense.imprest_id" required>
                                                        <option value=""> </option>
                                                        <option v-for="imprest in imprests"  v-bind:key="imprest.id" v-bind:value="imprest.id">
                                                            {{ imprest.name }}
                                                        </option>
                                                    </select>
                                                </div>  
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px; display: none">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                <h5>Type</h5>
                                                    <select class="form-control round" v-model="expense.type_id" required>
                                                        <option value=""></option>
                                                        <option value="1">Personal</option>
                                                        <option value="2">Company</option>
                                                        <option value="3">Others</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5>Proposed Date</h5>
                                                    <input type="date" class="form-control round pull-left" id="dropBorder" v-model="expense.propose_date" required>
                                                </div>  
                                            </div>
                                        </fieldset>

                                        <fieldset class="mb-1" style="margin-top:-20px; display: none">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h5>Amount</h5>
                                                    <input type="number" step="0.01" class="form-control round" v-model="expense.amount" required>
                                                </div>

                                                <div class="col-md-6">
                                                    <h5>Year</h5>
                                                    <input type="text" class="form-control round" v-model="expense.year" required>
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
        data()
        {
            return{
                search: '',
                imprests: [], 
                workflows: [], 

                expenses: [], 
                expense: {
                    id: '',
                    name: '',
                    purpose: '',
                    workflow_id: '',
                    imprest_id: '',
                    type_id: '',
                    amount: '',
                    propose_date: '',
                    year: '',
                    status_id: '',
                    actions: ''
                },
                expense_id: '',
                pagination: {},
                edit: false
            }
        },


        computed: {
            filteredExpenses: function()
            {
                return this.expenses.filter((expense) => {
                    return expense.name.toLowerCase().match(this.search.toLowerCase()) ||
                           expense.purpose.toLowerCase().match(this.search.toLowerCase()) || 
                           // expense.workflow.name.toLowerCase().match(this.search.toLowerCase()) || 
                           expense.imprest.name.toLowerCase().match(this.search.toLowerCase()) || 
                           expense.year.toString().match(this.search.toString()) || 
                           expense.amount.toString().match(this.search.toString())  || 
                           expense.propose_date.toString().match(this.search.toString()) 
                });
            }

        },


        created()
        {
            this.fetchExpenses();
            this.fetchAllExpenses();
            this.fetchImprests();
            this.fetchWorkflows();
        },

        methods:{
            fetchImprests()
            {
                let imprests = '/api/imprests'
                fetch(imprests)
                .then(res => res.json())
                .then(res => {
                    this.imprests = res.data;
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




            fetchAllExpenses(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/expenses?all=1'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.expenses = res.data;
                })
                .catch(err => console.log(err));
            },




            fetchExpenses(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/expenses'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.expenses = res.data;
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

            deleteExpense(id)
            {
                if(confirm('Are You Sure You Want To Delete This Expense Details?'))
                {
                    fetch(`api/expense/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        toastr.success('The Expense Record Has Been Deleted');
                        this.fetchExpenses();
                        this.edit = false;
                    })
                    .catch(err => console.log(err));
                }
            },

            addExpense()
            {
                if(this.edit === false)
                {
                    fetch('api/expense', 
                    {
                        method: 'post',
                        body: JSON.stringify(this.expense),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm()
                        toastr.success('Expense Has Been created Successfully');
                        this.fetchExpenses();
                        this.edit = false;
                    })
                    .catch(err => console.log(err)); 
                    $('#addExpenseModal').trigger('click');

                }
                else
                {
                    fetch('api/expense', 
                    {
                        method: 'put',
                        body: JSON.stringify(this.expense),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm();
                        toastr.success('Expense Has Been Updated');
                        this.fetchExpenses();
                        this.edit = false;
                    }) 
                    .catch(err => console.log(err));
                    $('#addExpenseModal').trigger('click');
                }
            },

            editExpense(expense)
            {
                this.edit = true;
                this.expense.id = expense.id;
                this.expense.expense_id = expense.id;
                this.expense.name = expense.name;
                this.expense.purpose = expense.purpose;
                this.expense.workflow_id = expense.workflow_id;
                this.expense.imprest_id = expense.imprest_id;
                this.expense.type_id = expense.type_id;
                this.expense.amount = expense.amount;
                this.expense.propose_date = expense.propose_date;
                this.expense.year = expense.year;
                this.expense.status_id = expense.status_id;
            },



            clearForm()
            {
                this.expense.name = '';
                this.expense.purpose = '';
                this.expense.workflow_id = '';
                this.expense.imprest_id = '';
                this.expense.type_id = '';
                this.expense.amount = '';
                this.expense.propose_date = '';
                this.expense.year = '';
            },

            

            

            approveExpense(expense)
            {
                this.expense.actions = expense.actions;
                this.edit = true;
                this.expense.id = expense.id;
                this.expense.expense_id = expense.id;
                this.expense.name = expense.name;
                this.expense.purpose = expense.purpose;
                this.expense.workflow_id = expense.workflow_id;
                this.expense.imprest_id = expense.imprest_id;
                this.expense.type_id = expense.type_id;
                this.expense.amount = expense.amount;
                this.expense.propose_date = expense.propose_date;
                this.expense.year = expense.year;
                this.expense.status_id = expense.status_id;
                this.expense.flow_stage_id = expense.flow_stage_id;
            },


            approve()
            {
                fetch('api/expense', 
                {
                    method: 'put',
                    body: JSON.stringify(this.expense),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    
                    this.expense.actions = '';
                    toastr.success('Expense Has Been Reviewed / Approved');
                    this.fetchExpenses();
                    this.edit = false;
                }) 
                .catch(err => console.log(err));
                $('#approveExpenceModal').trigger('click');
            },

        }
    };
</script>