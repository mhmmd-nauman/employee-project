var app = angular.module('myApp', ['ui.bootstrap']);

app.filter('startFrom', function() {
    return function(input, start) {
        if(input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
});
app.controller('customersCrtl', function ($scope, $http, $timeout) {
    $http.get('../ajax/employees/emp_list.php').success(function(data){
        //alert(data);
        $scope.list = data;
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.list.length; //Initially for no filter  
        $scope.totalItems = $scope.list.length;
    });
    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
    };
    $scope.filter = function() {
        $timeout(function() { 
            $scope.filteredItems = $scope.filtered.length;
        }, 10);
    };
    $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    };
    $scope.clearForm = function(){
        $scope.emp_file = "";
        $scope.emp_name = "";
    }
    $scope.getAll = function(){
        $http.get("../ajax/employees/emp_list.php").success(function(response){
            $scope.list = response;
        });
    }
    $scope.showCreateForm = function(){
        // clear form
        $scope.clearForm();

        // change modal title
        $('#modal-product-title').text("Create New Employee");

        // hide update product button
        $('#btn-update-product').hide();

        // show create product button
        $('#btn-create-product').show();

    }
    $scope.createEmployee = function(){
        // fields in key-value pairs
        $http.post('../ajax/employees/create_employee.php', {
                'emp_file' : $scope.emp_file, 
                'emp_name' : $scope.emp_name, 
                //'price' : $scope.price
            }
        ).success(function (data, status, headers, config) {
            console.log(data);
            // tell the user new product was created
            Materialize.toast(data);

            // close modal
            $('#modal-product-form').closeModal();

            // clear modal content
            $scope.clearForm();

            // refresh the list
            $scope.getAll();
        });
    }
    $scope.updateEmployee = function(){
        $http.post('../ajax/employees/update_employee.php', {
            'emp_file' : $scope.emp_file, 
            'emp_name' : $scope.emp_name, 
            
        })
        .success(function (data, status, headers, config){             
            // tell the user product record was updated
            Materialize.toast(data, 4000);

            // close modal
            $('#modal-product-form').closeModal();

            // clear modal content
            $scope.clearForm();

            // refresh the product list
            $scope.getAll();
        });
    }
    $scope.deleteProduct = function(emp_file){
        // ask the user if he is sure to delete the record
        if(confirm("Are you sure?")){
            // post the id of product to be deleted
            $http.post('../ajax/employees/delete_employee.php', {
                'emp_file' : emp_file
            }).success(function (data, status, headers, config){

                // tell the user product was deleted
                Materialize.toast(data, 4000);

                // refresh the list
                $scope.getAll();
            });
        }
    }
    $scope.readOne = function(id){
        
        // change modal title
        $('#modal-product-title').text("Edit Customer");

        // show udpate product button
        $('#btn-update-product').show();

        // show create product button
        $('#btn-create-product').hide();
        
        // post id of product to be edited
        $http.post('../ajax/employees/read_one.php', {
            'id' : id 
        })
        .success(function(data, status, headers, config){
            //alert(data[0]["emp_name"]);
            //return;
            // put the values in form
            $scope.emp_file = data[0]["emp_file"];
            $scope.emp_name = data[0]["emp_name"];
            //$scope.description = data[0]["description"];
            //$scope.price = data[0]["price"];
            //alert($scope.emp_name);
            // show modal
            $('#modal-product-form').openModal();
        })
        .error(function(data, status, headers, config){
            //alert("Ajax file not found");
            //return;
            Materialize.toast('Unable to retrieve record.', 4000);
        });
    }
    
});
