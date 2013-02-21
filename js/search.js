var app = angular.module('App',['ngResource']).
    config(function($routeProvider, $locationProvider){
        $locationProvider.html5Mode(true);

        $routeProvider.
            when('/',{templateUrl:'partials/list.html', controller:'MainCtrl'}).
            when('/new/:id',{templateUrl:'partials/edit.html', controller:'NewCtrl'}).
            when('/edit/:id',{templateUrl:'partials/edit.html', controller:'EditCtrl'}).
            when('/delete/:id',{templateUrl:'partials/edit.html', controller:'EditCtrl'})


    });

app.factory('Bid', function($resource){
   return $resource('api/bids/:bidID', {bidID: '@id'}, {update:{method: 'PUT'}, isArray:true});
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
