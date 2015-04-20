// kontroleri za koordinatora

var koordinator = angular.module('koordinatorModule', []);


koordinator.controller('NewDutyControllerCoordinator', function($scope, $http){

		/*$http.get('json/ucionice.json', {responseType: 'JSON'})
			.success(function(data, status, headers, config){
				if(data != "null")
						$scope.classrooms = angular.fromJson(data);
				})
			.error(function(data, status, headers, config){
					 console.log("Error: " + status)
		});*/

  $http.get('json/ucionice.json').success(function(data){
    $scope.classrooms = angular.fromJson(data);
  });

		$scope.assistants = ["Анђелка Зечевић", "Иван Чукић"];
		$scope.id  = "tijana";

		$scope.bgColors=['bg-success','bg-info','bg-warning'];
		$scope.counter = 0;
		$scope.msg = "";
		$scope.showMsg = false;
		$scope.err = false;
		$scope.group = {};
		$scope.groups	= [];
		$scope.group.name = "";
		$scope.group.dateRadio = "false";
		$scope.group.startDuty = "";
		$scope.group.endDuty = "";
		$scope.group.startRes = "";
		$scope.group.endRes = "";
		$scope.group.classrooms = [];
		$scope.group.onComputer = "true";
		$scope.group.numStudent = "";
		$scope.group.numAssistants = "";
		$scope.group.remarkA = "";
		$scope.group.remarkK = "";
		$scope.group.date = ""; 	
		$scope.group.dateToShow = "";
		$scope.group.id_assistant = "";
		
		
		
	$scope.returnArray = function(n)
	{
		var array =[];
		for(var i = 1; i<=n; i++)
			array.push(i);
		return array;
	}


	$scope.initGroup = function()
	{

		$scope.group.name = "";
		$scope.group.dateRadio = "false";
		$scope.group.startDuty = "";
		$scope.group.endDuty = "";
		$scope.group.startRes = "";
		$scope.group.endRes = "";
		$scope.group.classrooms = [];
		$scope.group.onComputer = "true";
		$scope.group.numStudent = "";
		$scope.group.numAssistants = "";
		$scope.group.remarkA = "";
		$scope.group.remarkK = "";
		$scope.group.date = "";
		$scope.group.dateToShow = "";
	}

	$scope.setGroup = function(index)
	{
		$scope.group.name = $scope.groups[index].name;
		$scope.group.dateRadio = $scope.groups[index].dateRadio;
		$scope.group.startDuty = $scope.groups[index].startDuty;
		$scope.group.endDuty = $scope.groups[index].endDuty;
		$scope.group.startRes = $scope.groups[index].startRes;
		$scope.group.endRes = $scope.groups[index].endRes;
		$scope.group.classrooms = $scope.groups[index].classrooms;
		$scope.group.onComputer = $scope.groups[index].onComputer;
		$scope.group.numStudent = $scope.groups[index].numStudent;
		$scope.group.numAssistants = $scope.groups[index].numAssistants;
		$scope.group.remarkA = $scope.groups[index].remarkA;
		$scope.group.remarkK = $scope.groups[index].remarkK;
		$scope.group.date = $scope.groups[index].date;
		$scope.group.dateToShow = $scope.groups[index].dateToShow;
	}

	 $scope.isChecked = function(item, mod){
		var match = false;
		
		if(mod === 'c')
		{  
			for(var i=0 ; i < $scope.group.classrooms.length; i++)
				if($scope.group.classrooms[i] === item)
					match = true;
		} 
		else if(mod === 'g')
		{
			for(var i=0 ; i < $scope.groupsToRemove.length; i++)
				if($scope.groupsToRemove[i] === item)
					match = true;
		}
		return match;
	};

	$scope.sync = function(bool, item, mod){
		if(mod === 'c')
		{
			if(bool)
			 	$scope.group.classrooms.push(item); 
		 	else 
		 	{
				for(var i=0 ; i < $scope.group.classrooms.length; i++) 
					if($scope.group.classrooms[i] === item)
				  	$scope.group.classrooms.splice(i,1);
			}
		}
		else if(mod === 'g')
		{
			if(bool)
			 	$scope.groupsToRemove.push(item);
			
		 	else 
		 	{
				for(var i=0 ; i < $scope.groupsToRemove.length; i++) 
					if($scope.groupsToRemove[i] === item)
				  	$scope.groupsToRemove.splice(i,1);
			}
		}
	};


	$scope.saveGroup = function(index)
	{
		var tmp = angular.copy($scope.group);

		$scope.group.dateToShow = angular.equals(tmp.dateRadio, "false") ? "у колоквијумској недељи" : (tmp.date+' '+tmp.startDuty+"-"+tmp.endDuty);
		
		tmp = angular.copy($scope.group);
		$scope.groups.splice($scope.groups.length - ($scope.groups.length-index), 0,  tmp);
		
		if($scope.counter < $scope.brGrupa)		
			$scope.counter = $scope.counter + 1;
		$scope.initGroup();
	};

	$scope.setVisible = function(arg)
	{
		$scope.showRemGroupsModel = arg;
	}

  $scope.success = function() {
    return $scope.showMsg;
  }
  
  $scope.successSet = function(arg) {
    $scope.showMsg = arg;
  }
    
  $scope.error = function() {
    return $scope.err;
  }
  
  $scope.errorSet = function(arg) {
    $scope.err = arg;
  }

	$scope.submitData = function()
	{
		
    var dataToSubmit = angular.toJson($scope.groups);
    
    $http({
      method: 'post',
      url: 'test.php',
      data: dataToSubmit,
      responseType: 'JSON',
      headers: {
	  'Content-Type': 'application/json; charset=UTF-8'
	}
    })
    .success(function(data, status, headers, config){
      console.log("success: " + status);
      console.log(data);
      $scope.msg = "Успешно најављена обавезa!";
      $scope.showMsg = true;
      $scope.groups = [];
    })
    .error(function(data, status, headers, config){
      console.log("error: " + status);
      $scope.groups = [];
      $scope.msg = "Дошло је до грешке приликом најављивања обавезе. Молимо вас покушајте поново.";
      $scope.err = true;
    });

		$('#savedGroup').empty();
   	$scope.opisObaveze = "";
   	$scope.brGrupa = undefined;
   	$scope.counter = 0;
   	$scope.initGroup();
  	$scope.groups = []; 	

  };

	$scope.editGroup = function(index)
	{
		$scope.setGroup(index);
		$scope.groups.splice(index,1);
		$scope.counter = $scope.counter-1;
	}
	$scope.removeGroup = function(index)
	{
		$scope.groups.splice(index,1);
		$scope.counter = $scope.counter-1;
		//$scope.initGroup();
	}

	$scope.removeGroups = function()
	{
		$scope.groups = [];
		$scope.initGroup();
		$scope.counter = 0;
		$scope.opisObaveze = "";
		$scope.brGrupa = undefined;
	}
	
	
	$scope.validGroupForm = function(index)
	{
		if($scope.group.name.length === 0)
			return false;
		if($scope.group.dateRadio == "true")
		{
			if($scope.group.date == "")
				return false;
			if($scope.group.startDuty == "")
				return false;
			if($scope.group.endDuty == "")
				return false;
			if($scope.group.startRes == "")
				return false;
			if($scope.group.endRes == "")
				return false;
		}
		if($scope.group.numStudent.length === 0)
			return false;
		if($scope.group.numAssistants.length === 0)
			return false;
		
		return true;
	}
	
	
});

