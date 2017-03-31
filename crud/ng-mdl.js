var app = angular.module('mdl', ['ngTagsInput']);

app.controller('mdlContrlr', function($scope, $http){
	$scope.formModel 	= {};

	$scope.records 		= listdata;
	$scope.statedata 	= states;
	$scope.formModel.tags = ['Tag 1', 'Tag 2'];
	//$scope.formModel.state 		= states[3];
	//console.log(states[3].state);

	/*states.forEach(function(obj) { 
		console.log(obj.state); 
	});*/

	
	$scope.edit		=	function(id){
		var custid = id;
		

		$http.post("edit.php", {id:custid}).success(function(data){
				var arr = data[0].tags.split(' | ');
				$scope.formModel.tags = arr;
				$scope.formModel.id = data[0].id;
				$scope.formModel.firstname = data[0].first_name;
				$scope.formModel.lastname = data[0].last_name;
				$scope.formModel.email = data[0].email;
				$scope.formModel.sex = data[0].sex;
				for(var i = 0; i < $scope.statedata.length; i++) {
			    	var obj = states[i];
			    	if(obj.state == data[0].state)
			    	{
			    		var idx = i;
			    	}
				}
				$scope.formModel.state = $scope.statedata[idx];
				$scope.getCities();

			}).error(function(data){
				console.log(":-(")
			});
		/*$http.({
				method: "post",
				url :"edit.php", 
				data:{'id': custid},
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).
			success(function(data){
				console.log(data)
			}).error(function(data){
				console.log(":-(")
			});*/
	}

	$scope.getCities = function(){
		$http.post("cities.php", { state: $scope.formModel.state.state}).success(function(data){
			//console.log(data);
			$scope.cities = data;
		});
	}
	$scope.foofunc 	= function(tag){
		var patte = new RegExp(/^[A-Za-z0-9._%+-]+@(?:[A-Za-z0-9-]+.)+[A-Za-z]{2,}/);
		if(patte.test(tag.text)){
			$scope.showEmailError = false;
		}else{
			$scope.showEmailError = true;
		}
		return patte.test(tag.text);
	}
	$scope.tooltip	=	function(tag){
		console.log(tag);
		//$('span:contains(tag.text)').addClass('sponz');

		if ($('span:contains(tag.text)')){
			$('span').attr({
				"data-toggle" : "popover",
				"title" : "Popover title",
				"data-content" : "Default popover"
			});
			
			alert("Match Found");
		}
	}

	$scope.onSubmit = function(valid){
		if(valid){
			console.log($scope.statedata[3]);
			console.log("Submitted");
			console.log($scope.formModel);
			$http.post("submitform.php", $scope.formModel).
			success(function(data){
				console.log(":-)")
			}).error(function(data){
				console.log(":-(")
			});
		}
		else{
			console.log("invalid Form")
		}
	};
});