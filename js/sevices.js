/**
 * Created with JetBrains WebStorm.
 * User: smaloney
 * Date: 2/17/13
 * Time: 9:21 AM
 * To change this template use File | Settings | File Templates.
 */
angular.module('bidServices', ['ngResource']).
    factory('Bid', function($resource){
        return $resource('api/bids/:id');
        });
