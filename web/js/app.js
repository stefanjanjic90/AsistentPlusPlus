var app = angular.module('Application', []);



app.controller('AppointmentsController', function($scope, $http){
	
		$scope.tableOfDuty = []; //tableOfDuty [datum, vreme, ucionice, kurs, opis_obaveze, glavni dezurni]
		$scope.msg = "";

		  $http.get('zakazane_obaveze.php', {responseType: 'JSON'}).success(function(data){
    		$scope.tableOfDuty = angular.fromJson(data);
   			}).error(function(data, status, headers, config){
							$scope.msg=status+": an error occured";	});
							
		$scope.tableOfDuty = [
		{date: '22-10-2014', time: '09:00-10:00', classrooms:['uci1, uci2'], course: 'Razvoj softvera',desc: 'Opis', assistant:'Neko Neko'},
		{date: '29-11-2013', time: '09:00-10:00', classrooms:['uci1, uci2'], course: 'Razvoj softvera',desc: 'Opis', assistant:'Neko Neko'}, 
		{date: '23-02-2016', time: '09:00-10:00', classrooms:['uci1, uci2'], course: 'Razvoj softvera',desc: 'Opis', assistant:'Neko Neko'}];
});

app.controller('HoursOnCallController', function($scope, $http, $filter){

	$scope.asTable = []; // tabela svih obaveza asistenta u tekucoj godini koje se nalaze u bazi [datum, vreme, opis_obaveze]
	$scope.asTableVisible = false; // vidljivost tabele 
	$scope.totalHoursOfDuty = []; //totalHoursOfDuty [ime asistenta, broj sati dezurstva]
	$scope.msg = "";
	
	  	$http.get('sati_dezuranja.php', {responseType: 'JSON'}).success(function(data){
    		$scope.totalHoursOfDuty = angular.fromJson(data);    		
	}).error(function(data, status, headers, config){
							$scope.msg=status+": an error occured";	});

 $scope.totalHoursOfDuty = [{assistant: 'Neko Neko',username: '...', hours:10},{assistant: 'Neko Neko',username: '...', hours:11},{assistant: 'Neko Neko ',username: '...', hours:2}];


$scope.showAsTable = function(index)
{
	$scope.asTableVisible = true; // tabela svih dezurstava asistenta iz baze (ako moze da se dobije sortirana hronoloski-po datumu)
	$scope.tableName = $scope.totalHoursOfDuty[index].assistant
	$http.get('sveObavezeAsistenta.php?user='+$scope.totalHoursOfDuty[index].username, {responseType: 'JSON'}).success(function(data){
		$scope.asTable = angular.fromJson(data);
   		}).error(function(data, status, headers, config){
					$scope.msg=status+": an error occured";	});
					
	$scope.asTable = [{date: '2014-01-29', time:'2h', typeOfDuty: 'kolokvijum iz Programiranja1'},
										{date: '2014-10-29', time:'2h', typeOfDuty: 'kolokvijum iz Programiranja1'},
										{date: '2014-11-29', time:'2h', typeOfDuty: 'kolokvijum iz Programiranja1'},
										{date: '2016-05-29', time:'2h', typeOfDuty: 'kolokvijum iz Programiranja1'}];
}

$scope.setVisible = function(value)
{
	$scope.asTableVisible = value;
}

$scope.returnDutyTime = function(index)
{
	var newDate = new Date($scope.asTable[index].date).getTime();  
	var curDate = new Date().getTime();
	
	if(newDate >= curDate)
		return 'new';
	else 
		return 'old';
}

});



