var app = angular.module('App', ['ngRoute', 'userControllers', 'userDirectives']);

app.config(
  ['$routeProvider',

   function($routeProvider){
      $routeProvider.
	when('/', {
	  templateUrl: 'pages/public/raspored.html',
	  controller: 'rasporedControler'
	})
	.when('/p1', {
	  templateUrl: 'pages/public/raspored.html',
	  controller: 'rasporedControler'
	})
	.when('/p2', {
	  templateUrl: 'pages/public/zauzetost.html',
	  controller: 'HoursOnCallController'
	})
	.when('/p3', {
	  templateUrl: 'pages/asistent/obavestenja.html',
	  controllers: 'UserOfferController, CommentsController'
	})
	.when('/p4', {
	  templateUrl: 'pages/asistent/dezurstva.html',
	  controllers: 'PrimDutyController, SecDutyController'
	})
	.when('/p5', {
	  templateUrl: 'pages/asistent/najavljivanjeobaveze.html',
	  controller: 'NewDutyController'
	})
	.when('/p6', {
	  templateUrl: 'pages/asistent/prethodnadezurstva.html',
	  controller: 'CompletedDutyController'
	})
	.when('/p7', {
	  templateUrl: 'pages/asistent/podesavanjenaloga.html',
	  controller: 'SetUpController'
	})
	.when('/p8', {
	  templateUrl: 'pages/koordinator/pristigleobaveze.html',
	  controller: 'SecDutyController'
	})
	.when('/p9', {
	  templateUrl: 'pages/koordinator/zakazivanjeobaveza.html',
	  controller: 'NewDutyControllerCoordinator'
	})
	.when('/p10', {
	  templateUrl: 'pages/administrator/info.html',
	  controller: 'infoControler'
	})
	.when('/p11', {
	  templateUrl: 'pages/administrator/newuser.html',
	  controller: 'newUserControler'
	})
	.when('/p12', {
	  templateUrl: 'pages/administrator/deleteuser.html',
	  controller: 'deleteUserControler'
	})
	.when('/p13', {templateUrl: 'pages/administrator/reset.html'})
	.when('/p14', {
	  templateUrl: 'pages/administrator/ucionice.html',
	  controller: 'ucioniceControler'
	})
	.otherwise({redirectTo: '/'});
   }
  ]
);



app.controller('indexControler', function($scope, $http, $location) {

  /* tab promenljiva - za indeks trenutne stranice */
  if(!localStorage.tab)
    localStorage.setItem('tab', 1);

  $scope.setTab = function(t) {
    if(!isNaN(t) && t>0 && t < 14)
      localStorage.setItem('tab', t);
    else
      localStorage.setItem('tab', 1);
  }
  $scope.returnTab = function() {
    return parseInt(localStorage.getItem('tab')); /* $scope.tab; */
  }

  /* podaci koje cuvamo o korisniku kad se uloguje */
  var user = {
    username: '',
    ime_prezime: '',
    administrator: false,
    koordinator: false,
    asistent: false,
    logedin: false
  };

  /* cuvamo ih u localStorage-u */
  if(!localStorage.user)
    localStorage.setItem('user', angular.toJson(user));

  /* ng-show za log_out div */
  $scope.loged = function() {
    user = angular.fromJson(localStorage.getItem('user'));
    return Boolean(user.logedin);
  }

  /* funkcija vraca ime_prezime ulogovanog korisnika */
  $scope.whoAmI = function() {
    return user.ime_prezime;
  }

  /* id korisnika */
  $scope.user_identification = function() {
    return user.username;
  }

 /* vracamo mod za ulogovanog korisnika */
  $scope.asist = function() {
    /* user = angular.fromJson(localStorage.getItem('user')); */
    return user.asistent;
  }
  $scope.admin = function() {
    /* user = angular.fromJson(localStorage.getItem('user')); */
    return user.administrator;
  }
  $scope.koord = function() {
    /* user = angular.fromJson(localStorage.getItem('user')); */
    return user.koordinator;
  }

  /* za prikazivanje login forme */
  $scope.visible = false;

  $scope.setVisible = function(arg) {
    $scope.visible = arg;
  }

  $scope.returnVisible = function() {
    return $scope.visible;
  }

  /* username i password
   * ono sto se salje za login
   */
  $scope.loginData = {};

  /* reset u login formi */
  $scope.resetData = function() {
    $scope.loginData = {};
  }

  /* login */
  $scope.login = function() {
    var loginDataJson = $scope.loginData;

    $http({
	method: 'POST',
	url: '/AsistentPlusPlus/login',
	data: {"loginData":loginDataJson},
	responseType: 'JSON',
	headers: {
	  'Content-Type': 'application/json; charset=UTF-8'
	}
      }
    )
    .success(function(data, status, headers, config) {
      $scope.visible = false
      localStorage.setItem('user', angular.toJson(data));

      user = angular.fromJson(data);
    })
    .error(function(data, status, headers, config) {
      console.log("error: " + status);
      /* TODO: ispis greske */
    });
  } /* login() */

  /* logout - resetujemo podatke */
  $scope.logout = function() {
    user = {
      username: '',
      ime_prezime: '',
      administrator: false,
      koordinator: false,
      asistent: false,
      logedin: false
    };
    $scope.loginData = {};
    localStorage.setItem('user', angular.toJson(user));
    localStorage.setItem('tab', 1);

      $http({
              method: 'GET',
              url: '/AsistentPlusPlus/logout'
          }
      )
          .success(function(data, status, headers, config) {
              $scope.visible = false
              console.log(data);
              localStorage.setItem('user', angular.toJson(data));

              user = angular.fromJson(data);
          })
          .error(function(data, status, headers, config) {
              console.log("error: " + status);
              /* TODO: ispis greske */
          });


    /* vracamo korisnika na pocetnu stranu (raspored) */
    $location.path('/p1');

    $scope.visible = false;
  } /* logout() */

});
