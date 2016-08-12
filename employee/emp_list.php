<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header_angular.php');
?>
<link href="http://localhost/c/angular/css/bootstrap.min.css" rel="stylesheet">
<div ng-app="myApp" ng-app>
    <div ng-controller="customersCrtl">
        <div class="container">
        
            <div class="row">
                <div class="col-md-2">PageSize:
                    <select ng-model="entryLimit" class="form-control">
                        <option>5</option>
                        <option>10</option>
                        <option>20</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </div>
                <div class="col-md-3">Filter:
                    <input type="text" ng-model="search" ng-change="filter()" placeholder="Filter" class="form-control" />
                </div>
                <div class="col-md-4">
                    <h5>Filtered {{ filtered.length }} of {{ totalItems}} total customers</h5>
                </div>
                <div class="col-md-2 pull-right" style="padding-right: 30px;">
                    <div class="fixed-action-btn" style="bottom:45px; right:24px;">
                        <a class="waves-effect waves-light btn modal-trigger btn-floating btn-large red" href="#modal-product-form" ng-click="showCreateForm()"><i class="large material-icons">add</i></a>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-12" ng-show="filteredItems > 0">
                    <table class="table table-striped table-bordered">
                    <thead>
                    <th style="width: 40%">Customer Name&nbsp;<a ng-click="sort_by('emp_name');"><i class="glyphicon glyphicon-sort"></i></a></th>
                    <th style="width: 20%">Emp Cellnum&nbsp;<a ng-click="sort_by('emp_cellnum');"><i class="glyphicon glyphicon-sort"></i></a></th>
                    
                    <th style="width: 20%">Email&nbsp;<a ng-click="sort_by('emp_email');"><i class="glyphicon glyphicon-sort"></i></a></th>
                    
                    <th style="width: 20%">Action</th>
                    </thead>
                    <tbody>
                        <tr ng-repeat="data in filtered = (list | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit">
                            <td>{{data.emp_file}} - {{data.emp_name}}</td>
                            <td>{{data.emp_cellnum}}</td>
                            <td>{{data.emp_email}}</td>
                            
                            <td>
                                 <a ng-click="readOne(data.emp_file)" class="waves-effect waves-light btn margin-bottom-1em"><i class="material-icons left">edit</i>Edit</a>
                                 <a ng-click="deleteProduct(data.emp_file)" class="waves-effect waves-light btn margin-bottom-1em"><i class="material-icons left">delete</i>Delete</a>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
                <div class="col-md-12" ng-show="filteredItems == 0">
                    <div class="col-md-12">
                        <h4>No customers found</h4>
                    </div>
                </div>
                <div class="col-md-12" ng-show="filteredItems > 0">    
                    <div pagination="" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimit" class="pagination-small" previous-text="&laquo;" next-text="&raquo;"></div>


                </div>
            </div>
        </div>
        <div id="modal-product-form" class="modal">
            <div class="modal-content">
                <h4 id="modal-product-title">Create New Product</h4>
                <div class="row">
                    <div class="input-field col s12">
                        <input ng-model="emp_name"  type="text" class="validate" id="form-emp_name" placeholder="Type name here..." />
                        <label for="emp_name">Name</label>
                    </div>
                    <div class="input-field col s12">
                        <input ng-model="emp_file" type="text" class="validate" id="form-emp_file" placeholder="Type price here..." />
                        <label for="emp_file">File</label>
                    </div>


                    <div class="input-field col s12">
                        <a id="btn-create-product" class="waves-effect waves-light btn margin-bottom-1em" ng-click="createEmployee()"><i class="material-icons left">add</i>Create</a>

                        <a id="btn-update-product" class="waves-effect waves-light btn margin-bottom-1em" ng-click="updateEmployee()"><i class="material-icons left">edit</i>Save Changes</a>

                        <a class="modal-action modal-close waves-effect waves-light btn margin-bottom-1em"><i class="material-icons left">close</i>Close</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo SITE_ADDRESS; ?>angular/js/jquery.js"></script>
<script src="<?php echo SITE_ADDRESS; ?>angular/js/materialize.min.js"></script>
<script src="<?php echo SITE_ADDRESS; ?>angular/js/angular.min.js"></script>
<script src="<?php echo SITE_ADDRESS; ?>angular/js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<script src="<?php echo SITE_ADDRESS; ?>angular/app/app.js"></script>
<script>
    $(document).ready(function(){
         $('.modal-trigger').leanModal();
    
    });
</script> 
