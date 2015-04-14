// kontroleri za asistenta

var account = angular.module('accountModule', []);
var user = angular.fromJson(window.localStorage.getItem('user.username'));  //ne znam da li radi


account.controller('SecDutyController', function($scope, $http, $timeout){

	$scope.duty = []; // [course, assistant, date, time, classroom, remark]
	$scope.possibleRotate = []; // [lista asistenata koji su slobodni]
	$scope.offeredDuty = [];

	$scope.separateDuty = function (element, index, array)
	{
		if(element.offered === "true")
		{
			$scope.offeredDuty.push(angular.copy(element));
		}
	}
  

	/*  
	$http.get('sporedna_dezurstva.php?user='+$scope.user, {responseType: 'JSON'}).
		success(function(data, status, headers, config){
			if(data!=="null")
				$scope.duty = angular.fromJson(data);
			}).
		error(function(data, status, headers, config){
			console.log("error: " + status);
	});
	*/
  
   $http.get('json/sporedna_dezurstva.json').success(function(data){ 
	 	 $scope.duty = angular.fromJson(data);
	 	 $scope.duty.forEach($scope.separateDuty);
	 	 $scope.duty = $scope.duty.filter(function (item) {
                     										return item.offered === "false";
                       							});
                       							
		});
			
	/*
  $http.get('moguce_zamene.php', {responseType: 'JSON'}).
		success(function(data, status, headers, config){
			if(data!=="null")
				$scope.possibleRotate = angular.fromJson(data);
			}).
		error(function(data, status, headers, config){
				console.log("error: " + status);
	});
	*/

	$http.get('json/moguce_zamene.json').success(function(data){
 	 $scope.possibleRotate = angular.fromJson(data);
	});


	$scope.toggle = function(index) {
 	 $('#zamena_asistenti'+index).slideToggle(1000);
	}
  
  $scope.toggleCard = function(index) {
 	 $('#sporedna_kartica'+index).slideToggle(1000);
	}
   
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
 		var offer = {};
 		offer.id_assistant = $scope.user;
 		offer.id_duty = $scope.duty[index].id_duty;
 		offer.date = $scope.duty[index].date;
 		offer.time = $scope.duty[index].time;
 		offer.toAssistants = angular.copy($scope.checkedReplace);
 		$scope.offeredDuty.push(angular.copy($scope.duty[index])); //ovo mozda ne treba zato sto se posle opet uradi ajax poziv
 		$scope.duty.splice(index, 1); 														// -||-

		 
 		var dataToSubmit = angular.toJson(offer); 			
  	
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
		 		$scope.toggle(index); 

				/*$timeout(function() {
				 $http.get('json/sporedna_dezurstva.json').success(function(data){  //sve radi, ostaje isto prikazano na stranici zato sto se ne promeni status offered na true
			 	 $scope.duty = angular.fromJson(data);
			 	 $scope.offeredDuty = [];
			 	 $scope.duty.forEach($scope.separateDuty);
			 	 $scope.duty = $scope.duty.filter(function (item) {
						               										return item.offered === "false";
						                 							});
													});
					},1000); */ 
		 	})
		  .error(function(data, status, headers, config){
		    console.log("error: " + status);
		  });
 
		offer.id_duty = "";
 		offer.date = "";
 		offer.time = "";
 		offer.toAssistants = [];
		$scope.checkedReplace = [];
  	}

});


account.controller('PrimDutyController', function($scope, $http){
   
	$scope.duty = []; // [course, assistants, number_of_student, date, time, remark]

/*   			
	$http.get('glavna_dezurstva.php?user='+$scope.user, {responseType: 'JSON'}).
		success(function(data, status, headers, config){
			if(data!=="null")
				$scope.duty = angular.fromJson(data);
			}).
		error(function(data, status, headers, config){
			console.log("error: " + status);
	});
*/

	$http.get('json/glavna_dezurstva.json').success(function(data){
 	 $scope.duty = angular.fromJson(data);
	});

			
		$scope.bgColors=['bg-success','bg-info','bg-warning'];
		$scope.comment =  {};
	  $scope.comment.public = "false";
		$scope.comment.text = "";
		$scope.comment.id_obaveze = "";

		
		$scope.saveComment = function(index) //kada se postavi komentar treba da se vise ne vraca ta obaveza kao aktivna
		{
			$scope.comment.id_obaveze = $scope.duty[index].id;
	   
	    var dataToSubmit = angular.toJson($scope.comment);  
	    var divSuccess = '<div class="alert alert-dismissable alert-success clear"><strong>Успешнo постављен коментар!</strong></div>';
	    var divError = '<div class="alert alert-dismissable alert-danger clear"><button type="button" class="close" data-dismiss="alert" ng-click="errorSet(false)">×</button><strong>Грешка!</strong> Дошло је до грешке. Молимо вас покушајте поново.</div>';
	   
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
		    $('#komentar'+index).empty();
		    $('#komentar'+index).append(divSuccess);
		  })
		  .error(function(data, status, headers, config){
		    console.log("error: " + status);
		    $('#komentar'+index).append(divError);
		  });
		  $scope.comment.text = "";
		}
		
		
		$scope.closeDuty = function(id)
		{
			bootbox.confirm("Да ли сте сигурни да желите да откажете обавезу?", function(result) {					
				if(result)
				{		
					$('#'+id).remove();
		
					var dataToDelete = angular.toJson(id);  

					// ne moze da se izvrsi pa je pod komentarom
					/*$http({
						method: 'delete',
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
					})
					.error(function(data, status, headers, config){
						console.log("error: " + status);
						alert("Отказивање обавезе није успело!");
					});*/			
			}		
			
			}); 	
		}

	
	$scope.recipientsString = "";
	$scope.emails = "";
	$scope.idForMsg = "";	

	$scope.showMsgModal = function(id, arg)
	{
		if(arg == 1)
		{
			/*$http.get('json/assistantsEmails.json?id='+id_obaveze, {responseType: 'JSON'}) //saljemo id obaveze, vraca mailove svih asistenata na toj obavezi kao niz
			.success(function(data, status, headers, config){
				if(data != "null")
						onJag = angular.fromJson(data);
				})
			.error(function(data, status, headers, config){
					 console.log("Error: " + status)
		});*/
				$http.get('json/assistantsEmails.json').success(function(data){ 
						$scope.recipientsString = angular.fromJson(data);
				});
		}
		else if(arg == 2)
		{

					$http.get('json/info.json').success(function(data){
						$scope.emails = angular.fromJson(data); 
						$scope.recipientsString = $scope.emails.emailss;
					});
		}
		else
		{
					$http.get('json/info.json').success(function(data){ 
						$scope.emails = angular.fromJson(data);
						$scope.recipientsString = $scope.emails.emailjag;
					});						
		}
		
		$scope.idForMsg = id;
	}


	$scope.singleComment =  {};
	$scope.singleComment.public = "false";
	$scope.singleComment.text = "";
	$scope.singleComment.id_assistant = "";
	$scope.singleComment.id_duty = "";

	$scope.showCommModal = function(id_obaveze, id_assistant)
	{
		$scope.singleComment.text = "";
		$scope.singleComment.id_assistant = id_assistant;
		$scope.singleComment.id_duty = id_obaveze;
	}


	$scope.saveSingleComment = function() //ostavljanje komentara za pojedinacnog asistenta
	{
		 var dataToSubmit = angular.toJson($scope.singleComment);  
				
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
		  })
		  .error(function(data, status, headers, config){
		    console.log("error: " + status);
		  });
	}
	
	$scope.sendMessage = function()
	{
		//treba poslati mailove onima koji se nalaze u $scope.recipientsString vezano za obavezu ciji je id $scope.idForMsg
		$scope.recipientsString = "";  
	}
	
});


account.controller('NewDutyController', function($scope, $http){

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




account.controller('CompletedDutyController', function($scope, $http){

  $scope.compDuty = []; //[course, date, duration]
	$scope.reverseSort = false;
	
/*		  
  $http.get('zavrsena_dezurstva.php?user='+$scope.user, {responseType: 'JSON'}).  
		success(function(data, status, headers, config){
			if(data!=="null")
				$scope.compDutytmp = angular.fromJson(data);
		}).
		error(function(data, status, headers, config){
			console.log("error: " + status);
		});
*/

	$http.get('json/zavrsena_dezurstva.json').success(function(data){
 	 $scope.compDuty = angular.fromJson(data);
	});


	$scope.orderByDateFunc = function(item)
	{
		var parts = item.date.split('-');
		var date = new Date(parseInt(parts[2]), parseInt(parts[1]), parseInt(parts[0]),0,0,0,0);

		return date.getTime();
	}

});

account.controller('UserOfferController', function($scope, $http){

	$scope.offer = []; // [asistent_koji_salje, predmet, id_obaveze, datum, vreme]
	$scope.dutyAccepted = [];
/*		
	    			$http.get('ponude_za_zamenu_dezurstva.php?user='+$scope.user, {responseType: 'JSON'}).
						success(function(data, status, headers, config){
							if(data!=="null")
								$scope.offer = angular.fromJson(data);
						}).
						error(function(data, status, headers, config){
							console.log("error: " + status);
						});
*/

	$http.get('json/ponude_za_zamenu_dezurstva.json').success(function(data){
 	 $scope.offer = angular.fromJson(data);
	});

/*		
	    			$http.get('prihvacena_dezurstva.php?user='+$scope.user, {responseType: 'JSON'}).
						success(function(data, status, headers, config){
							if(data!=="null")
								$scope.dutyAccepted = angular.fromJson(data);
						}).
						error(function(data, status, headers, config){
							console.log("error: " + status);
						});
*/

	$http.get('json/prihvacena_dezurstva.json').success(function(data){
 	 $scope.dutyAccepted = angular.fromJson(data);
	});
	

	$scope.tableVisible = false;
	
	$scope.setVisible = function(value)
	{
		$scope.tableVisible = value;
	}
	
	$scope.showTable = function(index) // za datog asistenta vraca broj ukupnih sati dezuranja, prosledjuje se id asistenta -> offer[index].id_assistant 
	{
	
		$http.get('json/sati_na_dezurstvu.json').success(function(data){
 	 		$scope.timeOfWork = angular.fromJson(data);
		});				
		$scope.setVisible(true);
	}

	$scope.acceptOffer = function(id_duty)	//salje se da je prihvacena ponuda i premesta se dezurstvo sa jednog na drugog asistenta
	{
		$("#ponude_dugmad"+id_duty).empty();
		$("#ponude_dugmad"+id_duty).html("<p class='text-info'><i>Прихваћено</i></p>");
		$("#ponuda"+id_duty).addClass("info text-muted");
		
			
		var acceptedOffer = {};
		acceptedOffer.id_who_accepted = user; // proveriti promenljivu user ??
		acceptedOffer.id_duty = id_duty;
		var dataToSubmit = angular.toJson(acceptedOffer);
		
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
		  })
		  .error(function(data, status, headers, config){
		    console.log("error: " + status); // kakva greska se vraca ukoliko je ponuda vec prihvacena u medjuvremenu, treba prikazati poruku
		  });
		
	}

	$scope.refuseOffer = function(id_duty)	
	{
		//salje se da je ponuda odbijena i obavestava se onaj ko je poslao ponudu
		$("#ponude_dugmad"+id_duty).empty();
		$("#ponude_dugmad"+id_duty).html("<p class='text-warning'><i>Послато извињење</i></p>");
		$("#ponuda"+id_duty).addClass("warning text-muted");
		
		var reffusedOffer = {};
		reffusedOffer.id_who_reffused = user; //proveriti promenljivu user
		reffusedOffer.id_duty = id_duty;
		
		var dataToDelete = angular.toJson(reffusedOffer);
				
 		$http({
			method: 'delete',
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
		})
			.error(function(data, status, headers, config){
			  console.log("error: " + status);
		});
	}
	
	$scope.seenNotice = function(index)
	{
		var seen = {};
		seen.id_user = user; // proveriti promenljivu user ??
		seen.id_duty = $scope.dutyAccepted[index].id_duty;
		var dataToSubmit = angular.toJson(seen);

		
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
		    	/*$http.get('json/prihvacena_dezurstva.json').success(function(data){  // da li treba da se ponovi ajax poziv ili ce pri refreshu to da se uradi
 					 $scope.dutyAccepted = angular.fromJson(data);
					});*/
		  })
		  .error(function(data, status, headers, config){
		    console.log("error: " + status);
		  });
		  
		$("#notice"+index).addClass("text-muted");
		$("#okBtn"+index).addClass("disabled");
	}
	
});




account.controller('CommentsController', function($scope, $http, $timeout){
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

	$http.get('json/komentari.json').success(function(data){
 	 $scope.comments = angular.fromJson(data);
	});


	$scope.markComment  = function(item)
	{
		for(var i=0 ; i < $scope.comments.length; i++) 
			if($scope.comments[i].id_duty === item)
				  {
				  	$("#komentar"+item).slideToggle(1000);
				   
				   	var markedComment = {};
				   	markedComment.id_duty = item;
				   	markedComment.id_assistant = user; // promenljiva u kojoj cuvamo id ulogovanog ??
				   	var dataToSubmit = angular.toJson(markedComment)
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
					})
					.error(function(data, status, headers, config){
						console.log("error: " + status);
					});
				    
				    $timeout(function() { $scope.comments.splice(i,1); }, 1000); // da li ovde treba da se opet pozove get metoda za komentare?
				  }
	};

});

account.controller('SetUpController', function($scope, $http){
	
		$scope.showSuccessMsg = false;
		$scope.showErrorMsg = false;
		$scope.showWarningMsg = false;
		$scope.newPassObject = {};
		$scope.newPassObject.id_assistant = $scope.user; //odakle uzimamo id ulogovanog usera
		$scope.newPassObject.oldPass = "";
		$scope.newPassObject.newPass = "";
		$scope.newPassAgain = "";
		$scope.msgText = "";
		
		$scope.showMsgSet = function(arg1, arg2)
		{
			if(arg1 == 1)
				$scope.showSuccessMsg = arg2;
			else if(arg1 == 2)
				$scope.showErrorMsg = arg2;
			else
				$scope.showWarningMsg = arg2;
		}
		
		$scope.success = function()
		{
			return $scope.showSuccessMsg;
		}
		
		$scope.error = function()
		{
			return $scope.showErrorMsg;
		}
		
		$scope.warning = function()
		{
			return $scope.showWarningMsg;
		}
		
		$scope.initFormPass = function()
		{
			$scope.newPassObject.oldPass = "";
			$scope.newPassObject.newPass = "";
			$scope.newPassAgain = "";
		}
		
		$scope.initMsgShow = function()
		{
				$scope.showMsgSet(1, false);				
				$scope.showMsgSet(2, false);
				$scope.showMsgSet(3, false);		
		}
		
		$scope.sendNewPass = function()
		{
				$scope.initMsgShow();
				
				if($scope.newPassObject.newPass === $scope.newPassAgain)
				{
						var dataToSubmit = angular.toJson($scope.newPassObject); 			
			
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
						$scope.msgText = "Успешнo промењена шифра!";
				 		$scope.showMsgSet(1, true);
					})
					.error(function(data, status, headers, config){
						console.log("error: " + status);
						$scope.msgText = "Дошло је до грешке. Молимо вас покушајте поново.";
						$scope.showMsgSet(2, true);
					});
					$scope.initFormPass();
				}
				else
				{
					$scope.msgText = "Нисте унели исте шифре.";
					$scope.showMsgSet(3, true);
					$scope.newPassObject.newPass = "";
					$scope.newPassAgain = "";
				}
		}
		
		$scope.newEmail = {};
		$scope.newEmail.email = "";
		$scope.newEmail.id_assistant = $scope.user; //odakle uzimamo id ulogovanog
		
		$scope.sendNewEmail = function()
		{
			$scope.initMsgShow();
			
			var dataToSubmit = angular.toJson($scope.newEmail); 			
			
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
						$scope.msgText = "Успешно промењена е-маил адреса!";
				 		$scope.showMsgSet(1, true);
					})
					.error(function(data, status, headers, config){
						console.log("error: " + status);
						$scope.msgText = "Дошло је до грешке. Молимо покушајте поново.";
						$scope.showMsgSet(2, true);
					});
					
					$scope.newEmail.email = "";
		}
});


account.controller('NewOrderController', function($scope, $http){

	$scope.duty = []; // [date, time, course, assistant]
	$scope.selected = 'orderByRecentFunc';
	$scope.sort;
	
	
	/*  
	$http.get('pristigle_obaveze.php?user='+$scope.user, {responseType: 'JSON'}).
		success(function(data, status, headers, config){
			if(data!=="null")
				$scope.duty = angular.fromJson(data);
			}).
		error(function(data, status, headers, config){
			console.log("error: " + status);
	});
	*/
  
	$http.get('json/pristigle_obaveze.json').success(function(data){ 
 	 $scope.duty = angular.fromJson(data);
	});
	
		$scope.setSort = function()
	{
		if($scope.selected.localeCompare('orderByRecentFunc') == 0)
			$scope.sort = function(item)
			{
				return 1;
			}
		else if($scope.selected.localeCompare('orderByDateFunc') == 0)
			$scope.sort = function(item) 
			{
				var parts = item.date.split('-');
				var date = new Date(parseInt(parts[2]), parseInt(parts[1]), parseInt(parts[0]),0,0,0,0);

				return date.getTime();
			}
	}
	
});


	
