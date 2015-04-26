/* kontroleri za administratora */

var administrator = angular.module('administratorModule', []);

administrator.controller('infoControler', function($scope, $http) {
  
  $scope.infoData = {};
  $scope.currentData = {};
  
  /* TODO: stvarni url */
  $scope.infoInit = function() {
    $http.get('json/info.json').success(function(data){
      $scope.currentData = angular.fromJson(data);
    });
  }
  $scope.infoInit();
  
  /* TODO: sredi ispis kad se zatvori prozor sa porukom...
   * poruka o uspesnosti i promenljiva za njen prikaz
   */ 
  $scope.msg = "";
  $scope.showMsg = false;
  
  /* TODO: sredi ispis kad se zatvori prozor sa porukom...
   * u slucaju greske
   */
  $scope.err = false;
  
  $scope.submitData = function() {
    
    var infoDataJson = angular.toJson($scope.infoData);
    
    $http({
	method: 'post',
	url: 'json/info.json', /* TODO: stvarna adresa... */
	data: infoDataJson,
	responseType: 'JSON',
	headers: {
	  'Content-Type': 'application/json; charset=utf-8'
	}
      }
    )
    .success(function(data, status, headers, config){
	$scope.currentData = angular.fromJson(data);
      
	$scope.msg = "Успешна промена!";
	$scope.showMsg = true;
	
	$scope.infoInit();
	
	$scope.resetData();
	 
    })
    .error(function(data, status, headers, config){
      $scope.err = true;
      console.log("error: " + status);
      /*
       * TODO: neki lepsi nacin za ispis greske
       */
    });
    
  }
  
  $scope.resetData = function() {
    $scope.infoData = {};
  }
  
});


  
administrator.controller('newUserControler', function($scope, $http) {
  
  /* katedre */
  $http.get('json/katedre.json').success(function(data){
    $scope.katedre = angular.fromJson(data);
  });
  
  /* poruka o uspesnosti i promenljiva za njen prikaz */
  $scope.msg = "";
  $scope.showMsg = false;
  
  /* u slucaju greske */
  $scope.err = false;

  $scope.formData = {};
  
  $scope.formData.dezurniAsistent = false;
  $scope.formData.administrator = false;
  $scope.formData.koordinator = false;
  
  $scope.submitData = function() {

    var formDataJson = angular.toJson($scope.formData);
        
    $http({
      method: 'post',
      url: 'test.php', /* TODO: stvarna adresa... */
      data: formDataJson,
      responseType: 'JSON',
      headers: {
	  'Content-type': 'application/json; charset=utf-8'
	}
      }
    )
    .success(function (data, status, headers, config){
      if (data != null) {
	$scope.msg = "Успешно је унет нови корисник!";
	$scope.showMsg = true;
      }
    })
    .error(function (data, status, headers, config){
      $scope.msg = "Дошло је до грешке приликом уноса новог корисника. Молимо вас покушајте поново.";
      $scope.err = true;
      /* console.log("error: " + status); */
    });
  }
  
  $scope.resetData = function() {
    $scope.formData = {};
  }
});



administrator.controller('deleteUserControler', function($scope, $http) {
  
  $scope.korisnici = {};
  $scope.ispisiKorisnike = function() {
    $http.get('json/korisnici.json').success(function(data) {
      $scope.korisnici = angular.fromJson(data);
    });
  }
  $scope.ispisiKorisnike();
  
  /* poruka o uspesnosti i promenljiva za njen prikaz */
  $scope.msg = "";
  $scope.showMsg = false;
  
  $scope.success = function() {
    return $scope.showMsg;
  }
  $scope.successSet = function(arg) {
    $scope.showMsg = arg;
  }
  
  /* u slucaju greske */
  $scope.err = false;
  
  $scope.error = function() {
    return $scope.err;
  }
  
  $scope.errorSet = function(arg) {
    $scope.err = arg;
  }
  
  /* menja status korisnika - aktivan u neaktivan i obrnuto */
  $scope.promeniStatus = function(user_id) {
    var user_idJson = angular.toJson(user_id);
    console.log(user_idJson);
    $http({
      method: 'post',
      url: 'test.php',
      data: user_idJson,
      responseType: 'JSON',
      headers: {
	'Content-Type': 'application/json; charset=UTF-8'
      }
    })
    .success(function(data, status, headers, config) {
      $scope.ispisiKorisnike();
      $scope.msg = "Успешна промена статуса корисника!";
      $scope.successSet(true);
    })
    .error(function(data, status, headers, config) {
      $scope.msg = "Дошло је до грешке приликом промене статуса корисника!";
      $scope.errorSet(true);
      console.log("error" + status);
    });
  }
  
});

administrator.controller('ucioniceControler', function($scope, $http) {

  $scope.ucionice = {};
  
  $scope.ispisiUcionice = function() {
    $http.get('json/ucionice.json').success(function(data){
      $scope.ucionice = angular.fromJson(data);
    });
  }
  
  $scope.ispisiUcionice();
  
  $scope.prikaziPromeniFormu = false;
  $scope.returnForm = function() {
    return $scope.prikaziPromeniFormu;
  }
  $scope.setForm = function(arg) {
    $scope.prikaziPromeniFormu = arg;
  }
  
  /* poruka o uspesnosti i promenljiva za njen prikaz */
  $scope.msg = "";
  $scope.showMsg = false;
  
  $scope.success = function() {
    return $scope.showMsg;
  }
  $scope.successSet = function(arg) {
    $scope.showMsg = arg;
  }
  
  /* u slucaju greske */
  $scope.err = false;
  
  $scope.error = function() {
    return $scope.err;
  }
  
  $scope.ucionica = {};
  
  /* otvara dijalog za promenu ucionice */
  $scope.promeni = function(id, ime, kapacitet, racunari) {
    $scope.ucionica.id = id;
    $scope.ucionica.ime = ime;
    $scope.ucionica.kapacitet = kapacitet;
    $scope.ucionica.racunari = racunari;
   
    $scope.setForm(true);
    
    $scope.showMsg = false;
    $scope.err = false;
  }
  
  
  $scope.submitData = function() {
   
    var dataToSubmit = angular.toJson($scope.ucionica);
    
    $http({
      method: 'post',
      url: 'test.php', /* TODO: stvarna adresa */
      data: dataToSubmit,
      responseType: 'JSON',
      headers: {
	  'Content-Type': 'application/json; charset=UTF-8'
	}
    })
    .success(function(data, status, headers, config){
      $scope.msg = "Успешно су промењени подаци за изабрану салу!";
      $scope.showMsg = true;
      $scope.ucionica = {};
      
      $scope.ispisiUcionice();
    })
    .error(function(data, status, headers, config){
      $scope.ucionica = {};
      $scope.msg = "Дошло је до грешке приликом промене информација о сали. Молимо вас покушајте поново.";
      $scope.err = true;
    });
  }
  
  $scope.resetData = function() {
    $scope.ucionica = {};
  }
  
});



administrator.controller('resetControler', function($scope, $http) {
 
  $scope.asistenti = {};
  
  $scope.init = function() {
    $http.get('json/reset.json').success(function(data) {
      $scope.asistenti = angular.fromJson(data);
    });
  }
  
  $scope.init();
  
  /* kad resetujemo cuvamo promene */
  $scope.forSave= false;
  
  /* da li smo resetovali podatke */
  $scope.resetovano = false;
  
  /* reset - kojim se vrednosti postavljaju na ocekivane u skladu sa uputstvom iz propozicija */
  $scope.reset = function() {
    
    console.log("reset()");
    
    $http({
      method: 'post',
      url: 'test.php',
      data: $scope.asistenti,
      responseType: 'JSON',
      headers: {
	'Content-Type': 'application/json; charset=UTF-8'
      }
    })
    .success(function(data, status, headers, config) {
      /* resetujemo podatke 
       * sada treba da se vrate podaci koji su resetovani
       */
      $scope.init();
      
      /* omoguci cuvanje izmena */
      $scope.forSave = true;
      
      /* resetovali smo podatke */
      $scope.resetovano = true;
    })
    .error(function(data, status, headers, config) {
      $scope.forSave = false;
    });
  }
  
  /* sacuvaj izmene - kojim se vrednosti dobijene u prethodnom koraku mogu sacuvati u bazi podataka */
  $scope.save = function() {
    /* TODO: ... */
    
    /* sad se ovaj json trajno upisuje u bazu */
    $http({
      method: 'post',
      url: 'test.php',
      data: $scope.asistenti,
      responseType: 'JSON',
      headers: {
	'Content-Type': 'application/json; charset=utf-8'
      }
    })
    .success(function(data, status, headers, config){
      if(data != null)
	$scope.asistenti = angular.fromJson(data);
    })
    .error(function(data, status, headers, config){
      /*...*/
    });
    
    console.log("save()");
  }
  
});