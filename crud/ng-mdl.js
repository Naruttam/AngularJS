var app = angular.module('mdl', ['ngTagsInput', 'ui.validate']);

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
	var editTags 		= {};
	//$scope.formModel.tags = ['Tag 1', 'Tag 2'];
	//$scope.formModel.state 		= states[3];
	//console.log(states[3].state);

	/*states.forEach(function(obj) { 
		console.log(obj.state); 
	});*/

	$scope.selectedState 			= "Select";
	$scope.selectedCity 			= "Select";

	$scope.addToGroupErrorDiv 		= false;
	$scope.addToGroupErrorDivMsg 	= '';
	$scope.emailTagError 			= false;
	$scope.emailTagErrorMsg 		= '';

	$scope.isDisableCity    		= true;

	$scope.notBlackListed = function(value) {
        /*var blacklist = ['Select'];
        return blacklist.indexOf(value) === -1;*/
        if(value === 'Select'){
        	return false;
        }else{
        	return true;
        }

    };

	$scope.getSelectedstate 		= function(statename){
		$scope.selectedState 		= statename;
		$scope.addToGroupErrorDiv 	= false;
		$scope.selectedCity 		= "Select";
	}

	$scope.getSelectedcity 			= function(cityname){
		$scope.selectedCity 		= cityname;
		$scope.addToGroupErrorDiv 	= false;
	}

	$scope.setAction        = function(Select){
		$scope.addToGroupErrorDiv = true
		$scope.addToGroupErrorDivMsg = "This filed is required";
		$scope.selectedState 	= "Select";
		$scope.selectedCity 	= "Select";
		$scope.isDisableCity    = true;
	}


	$scope.cityDropdown = function(){
		$http({
	        method: 'POST',
	        url: 'cities.php',
	        data: {state : $scope.selectedState},
	        headers: {'Content-Type': 'application/json'}  // set the headers so angular passing info as form data (not request payload)
        }).success(function(data) {
            if(data.success){
                $scope.cities 						= 	data.citydata;
                $scope.selectedCity 				= 	"Select";
                $scope.isDisableCity           		= 	false;
            }else{
               /* $scope.subbodyPart                  =   "";
                $scope.issbBDisabled                =   true;*/
                $scope.isDisableCity           		= true;
            }
            console.log(data);
        });
	}

	//console.log(tagsArray);

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
			//console.log(tagsArray[i][key]);
			//PushIt((editTags, key, tagsArray[i][key]));
			
			if(editTags[key])
			{
				editTags[key][editTags[key].length] = tagsArray[i][key];
			}else{
				editTags[key] = [tagsArray[i][key]];
			}
		}
		//console.log()
	}

	//console.log(editTags);

	/*for (var i =0; i < someArray.length; i++){
		if (someArray[i].name === "Kristian") {
			someArray.splice(i,1);
			break;
		}
	}*/
	$scope.allSelected = false;

	$scope.cbChecked = function(){
	    $scope.allSelected = true;
		angular.forEach($scope.cities, function(v, k) {
			if(!v.selected){
				$scope.allSelected = false;
			}
		});
  	}

	$scope.toggleAll = function() {
		
	    var bool = true;
	    if ($scope.allSelected) {
	      	bool = false;
	    }
	    angular.forEach($scope.cities, function(v, k) {
	      	v.selected = !bool;
	      	$scope.allSelected = !bool;
	    });
  	}

  	

	$scope.edit		=	function(id, formName){
		
		
    	$scope.divShow = id;
		var custid = id;
		console.log($scope.formModel);

		$http.post("edit.php", {id:custid}).success(function(data){
				/*$scope.divShow  =   $scope.divShow ? false : true;*/
				var arr = data[0].tags.split(' | ');
				/*$scope.formModel.tags = arr;
				$scope.formModel.id = data[0].id;
				$scope.formModel.firstname = data[0].first_name;
				$scope.formModel.lastname = data[0].last_name;
				$scope.formModel.email = data[0].email;
				$scope.formModel.sex = data[0].sex;*/
				for(var i = 0; i < $scope.statedata.length; i++) {
			    	var obj = states[i];
			    	
			    	if(obj.name == data[0].state)
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
			var state = 	$scope.formModel.state.name;
		}
		else{
			var state = 	$scope.forms[0].formData[0].state.name;
		}
		
		$http.post("cities.php", { state: state}).success(function(data){
			//console.log(data);
			$scope.cities = data;
		});
	}
	$scope.foofunc 	= function(tag){
		var patte = new RegExp(/^[A-Za-z0-9._%+-]+@(?:[A-Za-z0-9-]+.)+[A-Za-z]{2,}/);
		
		if(patte.test(tag.text) || tag.text == ''){
			$scope.emailTagError = false;
		}else{
			$scope.emailTagError = true;
			$scope.emailTagErrorMsg = 'The Email should be a valid one';
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

	$scope.closeEditforms = function(){
		$scope.divShow = false;
	}
});