<html>

<head>
    <title>Inline Table Add Edit Delete using AngularJS in PHP Mysql</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <br />
        <h3 align="center">Inline Table Add Edit Delete using AngularJS in PHP Mysql</h3><br />
        <div class="table-responsive" ng-app="liveApp" ng-controller="liveController" ng-init="fetchData()">
            <div class="alert alert-success alert-dismissible" ng-show="success">
                <a href="#" class="close" data-dismiss="alert" ng-click="closeMsg()" aria-label="close">&times;</a>
                {{successMessage}}
            </div>
            <form name="testform" ng-submit="insertData()">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Rate</th>
                            <th>USDT</th>
                            <th>Amount(INR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" id="usd_rate" ng-model="addData.usd_rate" class="form-control" placeholder="Enter USDT Rate" ng-required="true" value="" /></td>
                            <td><input type="text" id="usd_total" ng-model="addData.usd_total" class="form-control" placeholder="Enter Total USDT" ng-required="true" value="" /></td>
                            <td><input type="text" id="inr_total" ng-model="addData.inr_total" class="form-control" placeholder="INR" disabled /></td>
                            <td><button type="submit" class="btn btn-success btn-sm" ng-disabled="testform.$invalid">Add</button></td>
                        </tr>
                        <tr ng-repeat="data in namesData" ng-include="getTemplate(data)">
                        </tr>

                    </tbody>
                    <tr>
                        <td colspan="2">
                            Total Balance
                        </td>
                        <td>100</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Remaining Balance
                        </td>
                        <td>100</td>
                    </tr>
                </table>
            </form>
            <script type="text/ng-template" id="display">
                <td>{{data.usd_rate}}</td>
                    <td>{{data.usd_total}}</td>
                    <td>{{data.inr_total}}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" ng-click="showEdit(data)">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm" ng-click="deleteData(data.id)">Delete</button>
                    </td>
                </script>
            <script type="text/ng-template" id="edit">
                <td><input type="text" id="usd_rate_edit" ng-model="formData.usd_rate" class="form-control" value="" /></td>
                    <td><input type="text" id="usd_total_edit" ng-model="formData.usd_total" class="form-control" value=""/></td>
                    <td><input type="text" id="inr_total_edit" ng-model="formData.inr_total" class="form-control" disabled /></td>
                    <td>
                        <input type="hidden" ng-model="formData.data.id" />
                        <button type="button" class="btn btn-info btn-sm" ng-click="editData()">Save</button>
                        <button type="button" class="btn btn-default btn-sm" ng-click="reset()">Cancel</button>
                    </td>
                </script>
        </div>
    </div>
</body>

</html>
<script>
    var app = angular.module('liveApp', []);

    app.controller('liveController', function($scope, $http) {

        $scope.formData = {};
        $scope.addData = {};
        $scope.success = false;

        $scope.getTemplate = function(data) {
            if (data.id === $scope.formData.id) {
                return 'edit';
            } else {
                return 'display';
            }
        };

        $scope.fetchData = function() {
            $http.get('select.php').success(function(data) {
                $scope.namesData = data;
            });
        };

        $scope.insertData = function() {
            $http({
                method: "POST",
                url: "insert.php",
                data: $scope.addData,
            }).success(function(data) {
                $scope.success = true;
                $scope.successMessage = data.message;
                $scope.fetchData();
                $scope.addData = {};
            });
        };

        $scope.showEdit = function(data) {
            $scope.formData = angular.copy(data);
        };

        $scope.editData = function() {
            $http({
                method: "POST",
                url: "edit.php",
                data: $scope.formData,
            }).success(function(data) {
                $scope.success = true;
                $scope.successMessage = data.message;
                $scope.fetchData();
                $scope.formData = {};
            });
        };

        $scope.reset = function() {
            $scope.formData = {};
        };

        $scope.closeMsg = function() {
            $scope.success = false;
        };

        $scope.deleteData = function(id) {
            if (confirm("Are you sure you want to remove it?")) {
                $http({
                    method: "POST",
                    url: "delete.php",
                    data: {
                        'id': id
                    }
                }).success(function(data) {
                    $scope.success = true;
                    $scope.successMessage = data.message;
                    $scope.fetchData();
                });
            }
        };

    });

    $('#usd_rate, #usd_total').on('input', function() {
        var usd_rate = parseFloat($('#usd_rate').val()) || 0;
        var usd_total = parseFloat($('#usd_total').val()) || 0;

        $('#inr_total').val(usd_rate * usd_total);
    });
    $('#usd_rate_edit, #usd_total_edit').on('input', function() {
        var usd_rate_edit = parseFloat($('#usd_rate_edit').val1()) || 0;
        var usd_total_edit = parseFloat($('#usd_total_edit').val1()) || 0;

        $('#inr_total_edit').val1(usd_rate_edit * usd_total_edit);
    });
</script>