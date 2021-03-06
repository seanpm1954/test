var app = angular.module('App',['ngResource']).
    config(function($routeProvider, $locationProvider){
        $locationProvider.html5Mode(true);

        $routeProvider.
            when('/',{templateUrl:'partials/list.html', controller:'MainCtrl'}).
            when('/new/:id',{templateUrl:'partials/edit.html', controller:'NewCtrl'}).
            when('/edit/:id',{templateUrl:'partials/edit.html', controller:'EditCtrl'}).
            when('/delete/:id',{templateUrl:'partials/edit.html', controller:'EditCtrl'}).
            when('/customers',{templateUrl:'partials/customer.html', controller:'CustCtrl'}).
            when('/users', {templateUrl:'partials/users.html', controller:'UserCtrl'}).
            when('/status', {templateUrl:'partials/status.html', controller:'StatusCtrl'})


    });

app.factory('Bid', function($resource){
   return $resource('api/bids/:bidID', {bidID: '@id'}, {update:{method: 'PUT'}, isArray:true});
});
app.factory('Cust', function($resource){
    return $resource('api/customers/:CustomerID', {CustomerID: '@id'}, {update:{method: 'PUT'}, isArray:true});
});

app.factory('User', function ($resource) {
    return $resource('api/users/:userID', {UserID:'@id'}, {update:{method:'PUT'}, isArray:true});
});

app.factory('Status', function ($resource) {
    return $resource('api/status/:statusID', {statusID:'@id'}, {update:{method:'PUT'}, isArray:true});
});

function NewCtrl($scope, $location, $routeParams, Bid){

    $scope.disableDelete = true;

    $scope.bid = Bid.get({bidID: $routeParams.id});

    $scope.save = function(){
        this.bid.$save();
        $location.path('/');
    }
    $scope.cancel=function(){
        $location.path('/');
    }

}

function EditCtrl($scope, $location, $routeParams, Bid){
    $scope.disableDelete = false;

    $scope.bid = Bid.get({bidID: $routeParams.id});

    $scope.save = function(){
        $scope.bid.$update({bidID:$routeParams.id});
        $location.path('/');
        }

    $scope.delete = function(){
        $scope.bid.$delete({bidID:$routeParams.id});
        $location.path('/');
    }

    $scope.cancel=function(){
        $location.path('/');
    }
}

function MainCtrl($scope, $location, Bid) {

    $scope.bids =Bid.query();

    }

function CustCtrl($scope,$location, Cust){

    $scope.custs =Cust.query();
    $scope.selectAction = function() {

    };
}

function UserCtrl($scope, $location, User) {

    $scope.users = User.query();
    $scope.selectAction = function () {

    };
}

function StatusCtrl($scope, $location, Status) {

    $scope.status = Status.query();
    $scope.selectAction = function () {

    };
}