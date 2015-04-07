// kontroleri za javne stranice

var publicpages = angular.module('publicPagesModule', []);


publicpages.controller('rasporedControler', function($scope, $http) {
  
  // poruka o uspesnosti i promenljiva za njen prikaz
  $scope.msg = "";
  $scope.showMsg = false;
  
  $scope.success = function() {
    return $scope.showMsg;
  }
  $scope.successSet = function(arg) {
    $scope.showMsg = arg;
  }
  
  // u slucaju greske
  $scope.err = false;
  
  $scope.error = function() {
    return $scope.err;
  }
  
  $scope.errorSet = function(arg) {
    $scope.err = arg;
  }
  
  // godine za koje postoje rasporedi aktivnosti
  $scope.godine = [2015, 2014];
  $scope.meseci = ['Јануар', 'Фебруар', 'Март', 'Април', 'Мај', 'Јун', 'Јул', 'Август', 'Септембар', 'Октобар', 'Новембар', 'Децембар'];
  $scope.nedelje = [];
  
  // TODO: ajax poziv
//   $http.get("aktivnegodine.php").success(function(data) {
//     $scope.godine = angular.fromJson(data);
//   });
    
  // trenutni datum
  var datum = new Date();
  
  // za ispis u select kontroli
  $scope.trenutniMesec = function() {
    return datum.getMonth();
  }
  
  // trenutni dan u mesecu
  $scope.trenutniDan = function() {
    return datum.getDay();
  }

  // podrazumevane vrednosti
  $scope.rasporedObaveza = {
    izabranaGodina: datum.getFullYear(),
    izabraniMesec: $scope.meseci[datum.getMonth()],
    izabranaNedelja: 1
  };  
  
  // TODO: da li je dobra logika oko broja nedelja u mesecu
  $scope.nedeljeUMesecu = function() {
    $scope.nedelje = [];
    
    var godina = $scope.rasporedObaveza.izabranaGodina;
    var mesec = $scope.meseci.indexOf(($scope.rasporedObaveza.izabraniMesec).trim());
    
    console.log("mesec: " +  (mesec + 1));
    
    //var prviUMesecu = new Date(godina, mesec, 1);
    var poslednjiUMesecu = new Date(godina, mesec + 1, 0);
    
    //var tmp = prviUMesecu.getDay() + poslednjiUMesecu.getDate();
    //var brojNedeljaUMesecu = Math.ceil(tmp/7);
    
    var brojNedeljaUMesecu = Math.ceil(poslednjiUMesecu.getDate() / 7);
    
    for(var i = 0; i < brojNedeljaUMesecu; i++)
      $scope.nedelje[i] = i + 1;
    
    //console.log("poslednjiUMesecu: " + poslednjiUMesecu.getDate());
    //console.log("brojNedeljaUMesecu: " + brojNedeljaUMesecu);
    //console.log("nedelje: " + $scope.nedelje);
  }
  
  $scope.nedeljeUMesecu();
  
  // prikaz rasporeda po danima
  $scope.prikazPoDanima = false;
  
  // koji dan smo izabrali u filteru rasporeda po danima
  // na pocetku je to trenutni dan
  $scope.izabranDan = $scope.trenutniDan();
  
  
  $scope.raspored = {};
 
  // citamo raspored iz .json fajla
  $http({
    method: 'post',
    url: 'json/raspored.json',
    data: angular.toJson($scope.rasporedObaveza),
    responseType: 'JSON',
    headers: {
      'Content-Type': 'application/json; charset=UFT-8'
    }
  })
  .success(function(data, status, headers, config) {
    // ...
    $scope.raspored = angular.fromJson(data);
  })
  .error(function(data, status, headers, config) {
    // ...
  });
  
  // raspored je aktivan ukoliko datum zakazane obaveze nije jos prosao
  // ukoliko je raspored aktivan i korisnik je ulogovan kao koordinator, korisnik ima na raspolaganju opciju da otkaze obavezu
  $scope.aktivanRaspored = function(d) {
    return ((new Date(d)).getTime() > (new Date()).getTime());
  }
  
  $scope.filtrirajRaspored = function() {
    console.log("filtrirajRaspored: " + angular.toJson($scope.rasporedObaveza));
    $http({
      method: 'post',
      url: 'json/raspored.json',
      data: angular.toJson($scope.rasporedObaveza),
      responseType: 'JSON',
      headers: {
	'Content-Type': 'application/json; charset=UFT-8'
      }
    })
    .success(function(data, status, headers, config) {
      $scope.raspored = angular.fromJson(data);
      // TODO: raspored je prazan za trazzeni termin - ispisi obavestenje
    })
    .error(function(data, status, headers, config) {
      // ...
    });
  } // filtrirajRaspored()
  
  $scope.otkaziObavezu = function(id) {
    
    var obaveza = angular.toJson(id);
    
    $http({
      method: 'post',
      url: 'test.php',
      data: obaveza,
      responseType: 'JSON',
      headers: {
	'Content-Type': 'application/json; charset=UTF-8'
      }
    })
    .success(function(data, status, headers, config) {
      // console.log(data);
      $scope.msg = "Успешно отказана обавеза!";
      $scope.successSet(true);
    })
    .error(function(data, status, headers, config) {
      // console.log("error");
      $scope.msg = "Дошло је до грешке приликом отказивања обавезе. Молимо вас покушајте поново.";
      $scope.errorSet(true);
    });

    if($scope.success()) {
      // trazimo ponovo spisak obaveza
      $http.get('json/raspored.json').success(function(data){
	$scope.raspored = angular.fromJson(data);
      });
    }
    
  } // otkaziObavezu()


  // ukoliko je datum zakazane obaveze nedelja, dodajemo odgovarajucu klasu za ispis
  $scope.isNedelja = function(dan) {
    if((new Date(dan)).getDay() == 0) {
      return true;
    
    }
    return false;
  }
    
});

// TODO: filtre za sortiranje i ispis rasporeda po danima u nedelji
publicpages.filter('filterRaspored', function() {
  
  return function(raspored, scope) {
    var rezultat = [];
    
    var danas = Date.now();
    for(var i = 0; i < raspored.length; i++) {
      var tmp = raspored[i].datum;
      
      if((new Date(tmp)).getDay() == scope.izabranDan) {
	rezultat.push(raspored[i]);
      }
    }
  
    return rezultat;
  }
  
});



publicpages.controller('HoursOnCallController', function($scope, $http){


	$scope.asTable = []; // tabela svih obaveza asistenta u tekucoj godini koje se nalaze u bazi [datum, vreme, opis_obaveze]
	$scope.asTableVisible = false; // vidljivost tabele 
	$scope.totalHoursOfDuty = []; 
	$scope.reverseSort = false;
	
	/*   			
	$http.get('sati_na_dezurstvu_svi.php?user='+$scope.user, {responseType: 'JSON'}).
		success(function(data, status, headers, config){
			if(data!=="null")
				$scope.totalHoursOfDuty = angular.fromJson(data);
			}).
		error(function(data, status, headers, config){
			console.log("error: " + status);
	});
*/

	$http.get('json/sati_na_dezurstvu_svi.json').success(function(data){
 	 $scope.totalHoursOfDuty = angular.fromJson(data);
	});

	$scope.dateSortFunc = function(a, b)
	{
		var parts1 = a.date.split('-');
		var parts2 = b.date.split('-');
		
		var dateA = new Date(parseInt(parts1[2]), parseInt(parts1[1]), parseInt(parts1[0]),0,0,0,0).getTime;
		var dateB = new Date(parseInt(parts2[2]), parseInt(parts2[1]), parseInt(parts2[0]),0,0,0,0).getTime;
		
		if(dateA < dateB)
			return -1;
		else if(dateA > dateB)
		  return 1;
		
		return 0;
	}

	$scope.showAsTable = function(id)
	{
		$scope.asTableVisible = true;
		
		var result = $.grep($scope.totalHoursOfDuty, function(e){ return e.id_assistant === id; });
		$scope.tableName = result[0].name;
		
	/*   			
	$http.get('sve_obaveze_asistenta.php?user='+$scope.user, {responseType: 'JSON'}).
		success(function(data, status, headers, config){
			if(data!=="null")
				$scope.asTable = angular.fromJson(data);
			}).
		error(function(data, status, headers, config){
			console.log("error: " + status);
	});
	*/

		$http.get('json/sve_obaveze_asistenta.json').success(function(data){
	 	 $scope.asTable = angular.fromJson(data);
		});
		 $scope.asTable.sort(dateSortFunc);
	}

	$scope.setVisible = function(value)
	{
		$scope.asTableVisible = value;
	}

	$scope.returnDutyTime = function(index)
	{
		var parts = $scope.asTable[index].date.split('-');		
		var newDate = new Date(parseInt(parts[2]), parseInt(parts[1]), parseInt(parts[0]),0,0,0,0).getTime;  
		var curDate = new Date().getTime();
	
		if(newDate >= curDate)
			return 'new';
		else 
			return 'old';
	}

	$scope.orderByHoursFunc = function(item)
	{
		return parseInt(item.hours);
	}
	
	$scope.orderByDateFunc = function(item)
	{
		var parts = item.date.split('-');
		var date = new Date(parseInt(parts[2]), parseInt(parts[1]), parseInt(parts[0]),0,0,0,0);

		return date.getTime();
	}

});

