var app = angular.module('mdl', ['ngTagsInput']);

app.controller('mdlContrlr', function($scope, $http){
	
	$scope.forms={};

	$scope.forms = [{
				 	name: '',
		      		formData:
		      		{ 
		      			tags: [], 
		      			id: '', 
		      			firstname: '',
		      			lastname : '',
		      			email : '',
		      			sex : '',
		      			state : ''
		      		}
		    	}]


	$scope.formModel 	= {};
	$scope.records 		= listdata;
	$scope.statedata 	= states;
	//$scope.formModel.tags = ['Tag 1', 'Tag 2'];
	//$scope.formModel.state 		= states[3];
	//console.log(states[3].state);

	/*states.forEach(function(obj) { 
		console.log(obj.state); 
	});*/
	var editTags = {};

	console.log(tagsArray);

	function PushIt(editTags,key,value)
	{
	    if(editTags[key])
	    {
	        editTags[key][editTags[key].length] = value;
	    }
	    else
	    {
	        editTags[key] = [value];
	    }
	}
	
	for(var i = 0; i < tagsArray.length; i ++){

		for(var key in tagsArray[i]){
			console.log(tagsArray[i][key]);
			//PushIt((editTags, key, tagsArray[i][key]));
			
			if(editTags[key])
			{
				editTags[key][editTags[key].length] = tagsArray[i][key];
			}else{
				editTags[key] = [tagsArray[i][key]];
			}
		}
	}

	console.log(editTags);


	$scope.edit		=	function(id, formName){
		var custid = id;
		console.log($scope.formModel);



		$http.post("edit.php", {id:custid}).success(function(data){
				var arr = data[0].tags.split(' | ');
				/*$scope.formModel.tags = arr;
				$scope.formModel.id = data[0].id;
				$scope.formModel.firstname = data[0].first_name;
				$scope.formModel.lastname = data[0].last_name;
				$scope.formModel.email = data[0].email;
				$scope.formModel.sex = data[0].sex;*/
				for(var i = 0; i < $scope.statedata.length; i++) {
			    	var obj = states[i];
			    	if(obj.state == data[0].state)
			    	{
			    		var idx = i;
			    	}
				}
				//$scope.formModel.state = $scope.statedata[idx];

				$scope.forms = [{
				 	name: formName,
		      		formData:
		      		[{ 
		      			tags: arr, 
		      			id: data[0].id, 
		      			firstname: data[0].first_name,
		      			lastname : data[0].last_name,
		      			email : data[0].email,
		      			sex : data[0].sex,
		      			state : $scope.statedata[idx]
		      		}]
		    	}]
		    	console.log($scope.forms);
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
		//console.log($scope.formModel.state);
		if(!angular.equals($scope.formModel, {})){
			var state = 	$scope.formModel.state.state;
		}
		else{
			var state = 	$scope.forms[0].formData[0].state.state;
		}
		
		$http.post("cities.php", { state: state}).success(function(data){
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

		/*'<span id="closeimgmain_'+uniquenumber+'" contenteditable="false" class= "'+imageClassName+' tooltip">
		<span id="tooltiptext_'+uniquenumber+'"" class="bottomtooltiptext bottom">
		<span class="arrow">&nbsp;</span><span class="title">Title test</span>
		<span class="content">sample text</span>
		</span>'; */
		

		if ($('span:contains(tag.text)')){
			$('span').attr({
				"data-toggle" : "popover",
				"title" : "Popover title",
				"data-content" : "Default popover"
			});
			
			//alert("Match Found");
		}
	}

	$scope.onSubmit = function(valid){
		if(valid){
			//console.log($scope.statedata[3]);
			console.log("Submitted");
			//$scope.forms.formData.push($scope.formModel);
			if(!angular.equals($scope.formModel, {})){
				$scope.forms = [{
		      		formData:
		      		[{ 
		      			tags: $scope.formModel.tags,
		      			firstname: $scope.formModel.firstname,
		      			lastname : $scope.formModel.lastname,
		      			email : $scope.formModel.email,
		      			sex : $scope.formModel.sex,
		      			state : $scope.formModel.state
		      		}]
		    	}]
			}
			/*console.log($scope.formModel);
			if($scope.formModel){
				
			}*/
		    console.log($scope.forms);
			$http.post("submitform.php", $scope.forms).
			success(function(data){
				
				console.log(":-)");
				location.reload(true);

			}).error(function(data){
				console.log(":-(")
			});
		}
		else{
			console.log("invalid Form")
		}
	};
});