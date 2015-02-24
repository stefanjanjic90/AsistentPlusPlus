// kontroleri za asistenta

var account = angular.module('accountModule', []);


account.controller('SecDutyController', function($scope, $http){
/*
    $scope.duty = []; // [course, assistant, date, time, classroom, remark]
  
    			$http.get('sporedna_dezurstva.php?user='+$scope.user, {responseType: 'JSON'}).
						success(function(data, status, headers, config){
							if(data!=="null")
								$scope.duty = angular.fromJson(data);
						}).
						error(function(data, status, headers, config){
							console.log("error: " + status);
						});
*/


  $scope.duty = [
    {	
			course: 'Тест из програмирања за веб', 
			assistant: 'Анђелка Зечевић', 
			date: '29.10.2014',
			time: '09:00',
			classroom: '704',
			remark: 'Искључити мрежу пре почетка испита'
		},
		{ 
			course: 'Колоквијум из развој софтвера', 
			assistant: 'Мирјана Маљковић', 
			date: '29.10.2014',
			time: '09:00',
			classroom: '704',
			remark: ''
		},
		{
			course: 'Тест из увода у организацију рачунара',
			assistant: 'Анђелка Зечевић',
			date: '29.10.2014',
			time: '09:00h',
			classroom: 'Јаг 1',
			remark: ''
		}	
];

   $scope.toggle = function(index) {
        $('#zamena_asistenti'+index).slideToggle(1000);
    }
   
   $scope.possibleRotate = ["Ивана Танасијевић", "Мирко Спасић"];
   $scope.checkedReplace = [];
   
	 $scope.sync = function(bool, item, mod){
			if(mod === 'r')
			{
				if(bool){
				  // add item
				  $scope.checkedReplace.push(item);
				} else {
				  // remove item
				  for(var i=0 ; i < $scope.checkedReplace.length; i++) {
				    if($scope.checkedReplace[i] === item){
				      $scope.checkedReplace.splice(i,1);
				    }
				  }      
				}
			}
		};
	
	  $scope.isChecked = function(item, mod){
      var match = false;
      if(mod === 'r')
		  {  
		  	for(var i=0 ; i < $scope.checkedClassrooms.length; i++) {
		      if($scope.checkedClassrooms[i] === item){
		        match = true;
		      }
		    }
		  }
      return match;
  };
  
  	$scope.sendRequest = function(index)
  	{
  		$scope.toggle(index);
  	}
  
/*

    $scope.possibleRotate = []; // [lista asistenata koji su slobodni]
  
    			$http.get('slobodni_dezurni.php' //TODO: kako pamtiti parametre za pojedinacne kartice? predmet sa obaveze?, {responseType: 'JSON'}).
						success(function(data, status, headers, config){
							if(data!=="null")
								$scope.possibleRotate = angular.fromJson(data);
						}).
						error(function(data, status, headers, config){
							console.log("error: " + status);
						});

  */


});

/*account.directive('toggle', function() {
    return function(scope, elem, attrs) {
        scope.$on('event:toggle', function() {
            elem.slideToggle(1000); 
                    });
    };
});
*/

account.controller('PrimDutyController', function($scope, $http){
/*
    $scope.duty = []; // [course, assistants, date, time, remark]

    			$http.get('glavna_dezurstva.php?user='+$scope.user, {responseType: 'JSON'}).
						success(function(data, status, headers, config){
							if(data!=="null")
								$scope.duty = angular.fromJson(data);
						}).
						error(function(data, status, headers, config){
							console.log("error: " + status);
						});
  
*/

    $scope.duty = [
				{	
				id: '1',
				course: 'Тест из програмирања за веб', 
				groups: [{name:'Група 1', start:'09', end:'10', assistans:['Мика', 'Пера'], classrooms:['718','716']},
								 {name:'Група 2', start:'10', end:'11', assistans:['Мика', 'Пера'], classrooms:['718','716']},
								 {name:'Група 3', start:'11', end:'12', assistans:['Мика', 'Пера'], classrooms:['718','716']}],
				date: '29.10.2014',
				timeSum: '09:00-12:00',
				remark: ''
			},
			{ 
				id: '2',
				course: 'Тест из Развоја софтвера', 
				groups: [{name:'Група 1', start:'09', end:'10', assistans:['Мика', 'Неко'], classrooms:['718','716']}],
				date: '29.10.2014',
				timeSum: '09:00-12:00',
				remark: ''
			},
			{
				id: '3',
				course: 'Тест из увода у организацију рачунара',
				groups: [{name:'Група 1', start:'09', end:'10', assistans:['Пера', 'Пера'], classrooms:['718','716']}],
				date: '29.10.2014',
				time: '09:00h-12:00',
				remark: '',
			}	
				];
		$scope.bgColors=['bg-success','bg-info','bg-warning'];
	
		$scope.saveComment = function(index)
		{
			$('#postaviKomentar'+index).attr('disabled','disabled'); // prebaciti u deo kada se izvrsi http
		
			$scope.msg="";
			post.comment = $('#postaviKomentar'+index).val();
			
			
			$http.post('test.php', {id: $scope.id}, 
			{
				responseType:'JSON',
				headers: {
							'content-type': 'application/json'
							}
			}).success(function(data, status, headers, config){
							if(data!=="null")	
							{
							}
			}).error(function(data, status, headers, config){
							$scope.msg="An error occured!";
						});
		}
});

account.controller('NewDutyController', function($scope, $http){
/*
  $http.get('json/smerovi.json', {responseType: 'JSON'}).success(function(data){  //TODO proslediti .php
    $scope.departure = angular.fromJson(data);
    
  
    // predmeti koje drzi asistent u tekucoj godini

    			$http.get('predmeti_asistenta.php?user='+$scope.user, {responseType: 'JSON'}).
						success(function(data, status, headers, config){
							if(data!=="null")
								$scope.course = angular.fromJson(data);
						}).
						error(function(data, status, headers, config){
							console.log("error: " + status);
						});

    
  $http.get('json/ucionice.json', {responseType: 'JSON'}).success(function(data){  //TODO proslediti .php
    $scope.classrooms = angular.fromJson(data);
  
    
  $http.get('json/assistants.json', {responseType: 'JSON'}).success(function(data){  //TODO proslediti .php
    $scope.assistants = angular.fromJson(data);

*/

$scope.grupa = {};

$scope.saveGroup = function(index)
{
	$('#grupa'+index).animate({height:40},1200);
	
	    var $tmp = $('#grupa'+index),
          $initHeight = 40; 
    
    $tmp.each(function() {
        $.data(this, "realHeight", $(this).height());  
        }).css({ overflow: "hidden", height: $initHeight + 'px' });

    $tmp.toggle(function() {
          $tmp.animate({ height: $tmp.data("realHeight") }, 00);
          $switch.html("-");
          
        }, function() {
            $dscr.animate({ height: $initHeight}, 600);
            $switch.html("+");
        });
}

$(function () {
		$('#datepicker').datetimepicker({
					pickTime: false
				});
			});


$scope.bgColors=['bg-success','bg-info','bg-warning'];

$scope.setSort = function(order)
{
	if(order === 1)
		$scope.orderByDate = true;
	else
		$scope.orderByDate = false;
}

	$scope.returnArray = function(n)
	{
		var array =[];
		for(var i = 1; i<=n; i++)
			array.push(i);
		return array;
	}


$scope.departure = [
	'Информатика',
	'Рачунарство и информатика',
	'Математика',
	'Професор математике и рачунарства',
	'Теоријска математика и примене',
	'Примењена математика',
	'Статистика, актуарска и финансијска математика',
	'Астрономија',
	'Рачунарска механика и астродинамика',
	'Астрофизика',
	'Астроинформатика'
];





$scope.classrooms = [
	'Учионица 1',
	'Учионица 2',
	'Учионица 3',
	'Учионица 4',
	'Учионица 5',
	'Учионица 6',
	'Учионица 7',
	'Учионица 8',
	'Учионица 9',
	'Учионица 10'		
];


$scope.assistants = [
	'Мирко Спасић',
	'Ана Спасић'
];




$scope.selectedAssistant = [];

$scope.addAssistant = function(assistant)
{
	  $scope.selectedAssistant.push(assistant);
	  var index = $scope.assistants.indexOf(assistant);
	  $scope.assistants.splice(index, 1);
}

$scope.removeAssistant = function(index)
{
	$scope.assistants.push($scope.selectedAssistant[index]);
	$scope.selectedAssistant.splice(index,1);
}




 $scope.preferedAssistant = [];

 $scope.checkedClassrooms = [];

  $scope.isChecked = function(item, mod){
      var match = false;
      if(mod === 'c')
		  {  
		  	for(var i=0 ; i < $scope.checkedClassrooms.length; i++) {
		      if($scope.checkedClassrooms[i] === item){
		        match = true;
		      }
		    }
		   }
		   else
		   {  
		  	for(var i=0 ; i < $scope.preferedAssistant.length; i++) {
		      if($scope.preferedAssistant[i] === item){
		        match = true;
		      }
		    }
		   }
		   
      return match;
  };

  $scope.sync = function(bool, item, mod){
		if(mod === 'c')
		{
		  if(bool){
		    // add item
		    $scope.checkedClassrooms.push(item);
		  } else {
		    // remove item
		    for(var i=0 ; i < $scope.checkedClassrooms.length; i++) {
		      if($scope.checkedClassrooms[i] === item){
		        $scope.checkedClassrooms.splice(i,1);
		      }
		    }      
		  }
		}
		else
		{
		  if(bool){
		    // add item
		    $scope.preferedAssistant.push(item);
		  } else {
		    // remove item
		    for(var i=0 ; i < $scope.preferedAssistant.length; i++) {
		      if($scope.preferedAssistant[i] === item){
		        $scope.preferedAssistant.splice(i,1);
		      }
		    }      
		  }
		}
	};

});




account.controller('CompletedDutyController', function($scope, $http){

/*
    $scope.compDuty = []; //[course, date, duration]
		  
    			$http.get('prethodna_dezurstva.php?user='+$scope.user, {responseType: 'JSON'}).  //dezurstva.php -> sva dezurstva korisnika
						success(function(data, status, headers, config){
							if(data!=="null")
								$scope.compDutytmp = angular.fromJson(data);
						}).
						error(function(data, status, headers, config){
							console.log("error: " + status);
						});
  
  	angular.forEach(compDutytmp, function(object){
  		var currDate = new Date();
  		if(object.date < currDate)
  			this.push(object);
  	}, compDuty);
  	
*/

$scope.compDuty = [
	{
		course: 'Програмирање за веб',
		date: '29.10.2104',
		duration: '10h'
	},
	{
		course: 'Развој софтвера', 
		date: '10.05.2014', 
		duration: '02h'
	},
	{
		course: 'Алгебра', 
		date: '10.05.2014', 
		duration: '02h'
	}
	];
	

});

account.controller('UserOfferController', function($scope, $http){
/*
	$scope.offer = []; // [asistent_koji_salje, predmet, datum, vreme]
		
	    			$http.get('ponude_dezurstava.php?user='+$scope.user, {responseType: 'JSON'}).
						success(function(data, status, headers, config){
							if(data!=="null")
								$scope.offer = angular.fromJson(data);
						}).
						error(function(data, status, headers, config){
							console.log("error: " + status);
						});
*/

$scope.offer = [
	{
		assistant: 'Анђелка Зечевић',
		course: 'Програмирање за веб',
		date: '29.10.2104',
		time: '09:00-10:00'
	},
	{
		assistant: 'Мирјана Маљковић',
		course: 'Развој софтвера', 
		date: '10.05.2014', 
		time: '09:00-10:00'
	},
	{
		assistant: 'Иван Чукић',
		course: 'Развој софтвера', 
		date: '10.05.2014', 
		time: '09:00-10:00'
	}
	];
});


account.controller('CommentsController', function($scope, $http){
/*
	$scope.comments = [];  //[komentar, asistent, predmet, datum]
	  
    			$http.get('komentari.php?user='+$scope.user, {responseType: 'JSON'}).
						success(function(data, status, headers, config){
							if(data!=="null")
								$scope.comments = angular.fromJson(data);
						}).
						error(function(data, status, headers, config){
							console.log("error: " + status);
						});
	  
*/

$scope.comments = [	
	{
		comment: '...',
		assistant: 'Неки Асистент',
		course: 'Neki kurs',
		date: '29.10.2014'	
	}

];

});

/*	 
  	
  $(function () {
		$('#selectDatum').datetimepicker({
					pickTime: false
				});
			});
			
  $(function () {
   $('#timepicker1').datetimepicker({
          pickDate: false
        });
      });

  $(function () {
   $('#timepicker2').datetimepicker({
          pickDate: false
        });
      });		
});


*/



	
