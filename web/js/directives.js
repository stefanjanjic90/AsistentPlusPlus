/*
angular.module('moduleName')
    .directive('myDirective', function () {
    return {
        restrict: 'EA', //E = element, A = attribute, C = class, M = comment         
        scope: {
            //@ reads the attribute value, = provides two-way binding, & works with functions
            title: '@'         },
        template: '<div>{{ myVal }}</div>',
        templateUrl: 'mytemplate.html',
        controller: controllerFunction, //Embed a custom controller in the directive
        link: function ($scope, element, attrs) { } //DOM manipulation
    }
});
    
*/

var directives = angular.module('userDirectives', []);

directives.directive('fadeIn', function() {
  
  return function(scope, element, attrs) {
    
      angular.element('.login').hide();
      
      scope.$watch(attrs.fadeIn, function(val) {
	if(!val)
	  angular.element('.login').fadeIn(3000);
      })
  }
 
});