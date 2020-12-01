<template>
    <div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row" style="margin-top-25px">
        <div class="content-header-left col-xl-9 col-md-7 col-sm-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Workflows</h3> 
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a>
                </li>
                <li class="breadcrumb-item active">Workflows
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
            <button class="btn btn-primary round btn-glow px-2" type="button" data-animation="pulse" data-toggle="modal" data-target="#addWorkflowModal" @click="clearForm()">New </button>
          </div>
        </div>
      </div>


      <div class="content-body" style="margin-top: -8px">
        <!-- Basic Tables start -->
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-header">
                <h4 class="card-title">Workflows</h4>
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
                          <th>#</th>
                          <th>Workflow</th>
                          <th>No of Flows</th>
                          <th>Status</th>
                          <th style="text-align:right">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="workflow in filteredWorkflows" v-bind:key="workflow.id" style="">
                            <td>{{workflow.id}}</td>
                            <td>{{workflow.name}}</td>
                            <td>{{workflow.no_of_flows}}</td>
                            <td>{{workflow.status_id}}</td>
                            <td>
                                <a class="pull-right" @click="deleteWorkflow(workflow.id)"><span class="la times-circle m-r-10" style="margin :1px 2px; color: red"></span>
                                </a>
                                <a class="pull-right" data-toggle="modal" data-target="#addWorkflowModal" 
                                    @click="editWorkflow(workflow)"><span class="la la-pencil m-r-10" style="margin :1px 2px; color: #396"></span>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
            

                    <nav aria-label="Page navigation example pull-right">
                        <ul class="pagination justify-content-end pagination-separate pagination-round mb-1">
                            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                                <a class="page-link"aria-label="Previous" style="" href="#" @click="fetchWorkflows(pagination.prev_page_url)">
                                << Prev</i></a>
                            </li>
                            <li class="page-item disabled"><a class="page-link text-dark" href="#" >Page {{pagination.current_page}} of {{pagination.last_page}} </a></li>
                            <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                                <a class="page-link"aria-label="Next" style="" href="#" @click="fetchWorkflows(pagination.next_page_url)">
                                 Next >> </a>
                            </li>
                        </ul>
                    </nav>



                    <!-- Modal -->
                    <form @submit.prevent="addWorkflow">
                        <div class="modal animated rollin text-left" id="addWorkflowModal" tabindex="-1" role="dialog" style="">
                            <div class="modal-dialog" role="document" style="">
                                    <div class="modal-content" style="">

                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Add Workflow</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color:red">X</span></button>
                                    </div>

                                    <div class="modal-body">

                                        <fieldset class="mb-1">
                                            <h5>Workflow Name</h5>
                                            <div class="form-group">
                                            <input type="text" class="form-control round" v-model="workflow.name" required>
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
                workflow: {
                    id: '',
                    name: '',
                    no_of_flows: '',
                    status_id: ''
                },
                workflow_id: '',
                pagination: {},
                edit: false
            }
        },


        computed: {
            filteredWorkflows: function()
            {
                return this.workflows.filter((workflow) => {
                    return workflow.name.toLowerCase().match(this.search.toLowerCase()) ||
                           workflow.no_of_flows.toString().match(this.search.toString()) 
                });
            }

        },


        created()
        {
            this.fetchAllWorkflows();
            this.fetchWorkflows();
        },

        methods:{



            fetchAllWorkflows(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/workflows?all=1'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.workflows = res.data;
                })
                .catch(err => console.log(err));
            },

            fetchWorkflows(page_url)
            {
                let vm = this;
                page_url = page_url || '/api/workflows'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.workflows = res.data;
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

            deleteWorkflow(id)
            {
                if(confirm('Are You Sure You Want To Delete This Workflow Details?'))
                {
                    fetch(`api/workflow/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        toastr.success('The Workflow Record Has Been Deleted');
                        this.fetchWorkflows();
                        this.edit = false;
                    })
                    .catch(err => console.log(err));
                }
            },

            addWorkflow()
            {
                if(this.edit === false)
                {
                    fetch('api/workflow', 
                    {
                        method: 'post',
                        body: JSON.stringify(this.workflow),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm()
                        toastr.success('Workflow Has Been created Successfully');
                        this.fetchWorkflows();
                        this.edit = false;
                    })
                    .catch(err => console.log(err)); 
                    $('#addWorkflowModal').trigger('click');

                }
                else
                {
                    fetch('api/workflow', 
                    {
                        method: 'put',
                        body: JSON.stringify(this.workflow),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.clearForm();
                        toastr.success('Workflow Has Been Updated');
                        this.fetchWorkflows();
                        this.edit = false;
                    }) 
                    .catch(err => console.log(err));
                    $('#addWorkflowModal').trigger('click');
                }
            },

            editWorkflow(workflow)
            {
                this.edit = true;
                this.workflow.id = workflow.id;
                this.workflow.workflow_id = workflow.id;
                this.workflow.name = workflow.name;
                this.workflow.no_of_flows = workflow.no_of_flows;
                this.workflow.status_id = workflow.status_id;
            },



            clearForm()
            {
                this.workflow.name = '';
                this.workflow.no_of_flows = '';
                this.workflow.status_id = '';
            }
        }
    };
</script>