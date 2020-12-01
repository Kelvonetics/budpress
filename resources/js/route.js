
import Home from './components/Home.vue';
import Users from './components/Users.vue';
import Department from './components/Department.vue';
import Roles from './components/Roles.vue';
import Permissions from './components/Permissions.vue';
import Budgets from './components/Budgets.vue';
import BudgetDetails from './components/BudgetDetails.vue';
import Imprests from './components/Imprests.vue';
import ImprestDetails from './components/ImprestDetails.vue';
import Expenses from './components/Expenses.vue';
import Workflow from './components/Workflow.vue';
import Flow from './components/Flow.vue';

export default 
[

	{path: '/home', component: Home},
	{path: '/users', component: Users},
	{path: '/departments', component: Department},
	{path: '/roles', component: Roles},
	{path: '/permissions', component: Permissions},
	{path: '/budgets', component: Budgets},
	{path: '/budget-details/:id', component: BudgetDetails},
	{path: '/imprests', component: Imprests},
	{path: '/budget-imprest-expenses/:id', component: ImprestDetails},
	{path: '/expenses', component: Expenses},
	{path: '/workflows', component: Workflow},
	{path: '/flows', component: Flow}
]