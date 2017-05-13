<?php
    include_once 'dbconfig.php';

    $listing_query  =   "SELECT * FROM customers";
    $listing_set=mysql_query($listing_query);
    if(mysql_num_rows($listing_set)>0)
    { 
        while($row=mysql_fetch_assoc($listing_set))
        {
            $listarray[] = $row;
        }
    }

    $state_query="SELECT distinct state FROM statelist";
    $result_set=mysql_query($state_query);
    if(mysql_num_rows($result_set)>0)
    {
        while($row=mysql_fetch_assoc($result_set))
        {
            $statearray[] = $row;
        }
    }


    $state_query = "SELECT id , name FROM `geo_locations` WHERE location_type = 'STATE' ";

    $state_list  =  mysql_query($state_query);
    if(mysql_num_rows($state_list)>0)
    { 
        
        while($row = mysql_fetch_assoc($state_list))
        {
            $state_list_array[] = $row;
        }
    }

    //echo json_encode($state_list_array);



    $text1 = "sample->text-1";
    $text2  = "sample->text-2";
    $text3  = "sample->text-3";

    $val1    = "Radiology";
    $val2    = "Radiology1";
    $val3    = "Radiology3";
    $val4    = "Radiology4";
    $val5    = "Radiology5";
    $val6    = "Radiology6";
    $val7    = "Radiology7";

   /* $butt[$text1][] = array($val1, "val1");
    $butt[$text1][] = array($val2, "val2");
    $butt[$text1][] = array($val3, "val3");*/
    //$arr[]  = $butt;

    /*$butt[$text2]['tech'] = $val5;
    $butt[$text2]['id']   = 1;
    $butt[$text2]['tech'] = $val6;
    $butt[$text2]['id'] = 6;
    $arr[]  = $butt;*/

    $textArray = array($text1, $text1,  $text2);

    $i = 1;
    foreach ($textArray as $key => $value) {
        $butt[$value]['tech'] = $value.$i;
        $butt[$value]['id']   = $i;
        $arr[]  = $butt;

        unset($butt);
        $i++;
        
    }
   /* echo "<pre>";
    echo json_encode($arr, JSON_PRETTY_PRINT);
    echo "</pre>";*/


?>
    <script type="text/javascript">
        var listdata = <?php echo json_encode($listarray)?>;
        var states  = <?php echo json_encode($state_list_array)?>;
        var tagsArray = <?php echo json_encode($arr)?>;
    </script>

<!DOCTYPE html>
<html>
    <head >
        <title>Angular CRUD</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="nginputtags/ng-tags-input.min.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <script src="nginputtags/ng-tags-input.min.js"></script>
        <script src="ng-mdl.js"></script>
        <style>
            tags-input .host {
                position: relative;
                margin-top: 5px;
                margin-bottom: 5px;
                /* height: 100%; */
            }
            tags-input .tags {
                -moz-appearance: textfield;
                -webkit-appearance: textfield;
                padding: 1px;
                overflow: hidden;
                word-wrap: break-word;
                cursor: text;
                background-color: #fff;
                border: 1px solid #a9a9a9;
                box-shadow: 1px 1px 1px 0 #d3d3d3 inset;
                /* height: 100%; */
            }
        </style>
    </head>
    <body ng-app="mdl">
        <div class='container' ng-controller="mdlContrlr">
            <button type="button" class="btn btn-success" id="Addbutton">ADD Template</button>

            <div id="listing">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Email</th>
                            <th>Sex</th>
                            <th>State</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr ng-repeat-start="x in records">
                            <td>{{ x.first_name}}</td>
                            <td>{{ x.last_name}}</td>
                            <td>{{ x.email}}</td>
                            <td>{{ x.sex}}</td>
                            <td>{{ x.state}}</td>
                            <td><a href="javascript:void(0);" ng-click="edit(x.id, 'theFirstFormtest')">Edit</a></td>
                        </tr>
                        <tr ng-repeat-end>
                            <td colspan=5>
                                <form class = "form-horizontal" role = "form" ng-submit="onSubmit(theFirstFormtest.$valid)" novalidate="novalidate" name="theFirstFormtest" ng-repeat="form in forms">
                                    <div ng-repeat="formModel in form.formData"><!-- testing -->   
                                        <div ng-if="formModel.id">
                                            <pre>{{ formModel.id | json}}</pre>
                                            <div class = "form-group">
                                                <label for = "firstname" class = "col-sm-2 control-label">First Name</label>

                                                <div class = "col-sm-10">
                                                    <input type = "text" class = "form-control" id = "firstname" placeholder = "Enter First Name" ng-model='formModel.firstname'>
                                                </div>
                                            </div>
                                            <div class = "form-group">
                                                <label for = "lastname" class = "col-sm-2 control-label">Last Name</label>
                                                <div class = "col-sm-10">
                                                    <input type = "text" class = "form-control" id = "lastname" placeholder = "Enter Last Name" ng-model='formModel.lastname'>
                                                </div>
                                            </div>

                                            <div 
                                                class = "form-group"
                                                ng-class    ="{
                                                    'has-error':!theFirstFormtest.tags.$valid && (!theFirstFormtest.tags.$pristine || theFirstFormtest.$submitted),
                                                    'has-success': theFirstFormtest.tags.$valid && (!theFirstFormtest.tags.$pristine || theFirstFormtest.$submitted)
                                                }"
                                            >
                                                <label for = "lastname" class = "col-sm-2 control-label">Tags</label>
                                                <div class = "col-sm-10">
                                                    <tags-input 
                                                        name                    =   "tags"
                                                        ng-model                =   "formModel.tags" 
                                                        add-on-blur             =   "false"
                                                        ng-required             =   'true'
                                                        
                                                        allow-leftover-text     =   "false"
                                                        on-tag-adding           =   "foofunc($tag)"
                                                        >
                                                    </tags-input>
                                                    <p class="help-block" ng-show="theFirstFormtest.tags.$error.minTags && (!theFirstFormtest.$pristine)">
                                                        Please enter at least three tags.
                                                    </p><p class="help-block" ng-show="showEmailError && (!theFirstFormtest.$pristine)">
                                                        Please enter a valid email.
                                                    </p>

                                                    <div class="alert alert-danger margintop10" role="alert" ng-show="addToGroupErrorDiv == true">
                                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> {{addToGroupErrorDivMsg}}
                                                    </div>
                                                    <p>Model: {{formModel.tags}}</p>
                                                    <p>$pristine: {{theFirstFormtest.tags.$pristine}}</p>
                                                    <p>$dirty: {theFirstFormtest.tags.$dirty}}</p>
                                                    <p>$valid: {{theFirstFormtest.tags.$valid}}</p>
                                                    <p>$error: {{theFirstFormtest.tags.$error}} </p>
                                                </div>
                                            </div>


                                            <div 
                                                class       = "form-group" 
                                                ng-class    ="{
                                                    'has-error':!theFirstFormtest.email.$valid && (!theFirstFormtest.$pristine || theFirstFormtest.$submitted),
                                                    'has-success': theFirstFormtest.email.$valid && (!theFirstFormtest.$pristine || theFirstFormtest.$submitted)
                                                }"
                                            >
                                                <label for = "email" class = "col-sm-2 control-label" >Email</label>
                                                <div class = "col-sm-10">
                                                    <input  type = "email" 
                                                            class = "form-control" 
                                                            id = "email" 
                                                            placeholder = "Enter your email" 
                                                            ng-model='formModel.email' 
                                                            required ="required"
                                                            name = 'email'
                                                    >
                                                    <p  class="help-block" 
                                                        ng-show="theFirstFormtest.email.$error.required && (!theFirstFormtest.$pristine || theFirstFormtest.$submitted)">
                                                        This field is required.
                                                    </p>
                                                    <p  class="help-block" 
                                                        ng-show="theFirstFormtest.email.$error.email && (!theFirstFormtest.$pristine || theFirstFormtest.$submitted)">
                                                        Please enter a valid email.
                                                    </p>
                                                    <!--  <pre>Validation ? {{ theFirstForm.email.$error | json }} </pre>
                                                    <pre>Field Valid ? {{ theFirstForm.email.$valid }} </pre>
                                                    <pre>Field pristine ? {{ theFirstForm.$pristine }} </pre>
                                                    <pre>Form Submitted ? {{ theFirstForm.$submitted }} </pre> -->
                                                </div>
                                            </div>
                                            <div class = "form-group">
                                                <label for = "sex" class = "col-sm-2 control-label">Choose Sex</label>
                                                <div class = "col-sm-10">
                                                    <select name='sex' id='sex' class = "form-control" ng-model="formModel.sex">
                                                       <option value="">Please choose </option>
                                                       <option value="male">Male</option>
                                                       <option value="female">Female</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class = "form-group">
                                                <label for = "sex" class = "col-sm-2 control-label">Choose state</label>
                                                <div class = "col-sm-10">
                                                    <select
                                                            ng-model  ="formModel.state" class = "form-control" 
                                                            ng-options="item.state for item in statedata"
                                                            ng-change ="getCities()" >
                                                        <option value="">Select</option>
                                                    </select>
                                                    
                                                    <!-- <pre>{{ formModel.state | json}} </pre> -->
                                                </div>
                                            </div>

                                            <div class = "form-group">
                                                <label for = "sex" class = "col-sm-2 control-label">Choose City</label>
                                                <div class = "col-sm-10">
                                                    <select multiple ng-model="formModel.selCity" class = "form-control" 
                                                            ng-options="item.city_name for item in cities">
                                                        <option value="">Select</option>
                                                    </select>
                                                    <!-- <pre>{{ formModel.state | json}} </pre> -->
                                                </div>
                                            </div>


                                            <div class = "form-group">
                                                <div class = "col-sm-offset-2 col-sm-10">
                                                    <div class = "checkbox">
                                                        <label><input type = "checkbox" ng-model='formModel.rememberme'> Remember me</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class = "form-group">
                                                <div class = "col-sm-offset-2 col-sm-10">
                                                    <button type = "submit" class = "btn btn-default" >Submit</button>
                                                </div>
                                            </div>
                                        </div><!-- ng if -->
                                    <div ><!-- testing -->
                                </form>
                                <!-- <pre> formModel.tags {{ forms.formModel.tags  }} </pre>
                                <pre> form {{ form }} | json}} </pre> -->
                            <td>
                        </tr>
                    </tbody>
                </table>

                
                 <!-- The Default Form -->

                <form class = "form-horizontal" role = "form" ng-submit="onSubmit(theFirstForm.$valid)" novalidate="novalidate" name="theFirstForm" id="DefaultForm">
                    <div class = "form-group">
                        <label for = "firstname" class = "col-sm-2 control-label">First Name</label>
                        <div class = "col-sm-10">
                            <input 
                                type = "text" 
                                class = "form-control" 
                                id = "firstname" 
                                placeholder = "Enter First Name" 
                                ng-model ='formModel.firstname' 
                                name = 'firstname'
                                required ="required"
                                
                            >
                            <div class="alert alert-danger margintop10" role="alert" 
                                ng-show="theFirstForm.email.$error.email && (!theFirstForm.$pristine || theFirstForm.$submitted)">
                                 <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>Please enter a valid Name.
                             </div>

                            <div class="alert alert-danger margintop10" role="alert" ng-show="theFirstForm.email.$error.required && (!theFirstForm.$pristine || theFirstForm.$submitted)">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> This field is required.
                            </div>
                            <!-- emailTagError == true ||   -->
                            <p>Model: {{formModel.firstname}}</p>
                            <p>$pristine: {{theFirstForm.firstname.$pristine}}</p>
                            <p>$dirty: {{theFirstForm.firstname.$dirty}}</p>
                            <p>$valid: {{theFirstForm.firstname.$valid}}</p>
                            <p>$invalid: {{theFirstForm.firstname.$error.firstname}}</p>
                            <pre>$error: {{theFirstForm.firstname | json}} </pre>


                        </div>
                    </div>
                    <div class = "form-group">
                        <label for = "lastname" class = "col-sm-2 control-label">Last Name</label>
                        <div class = "col-sm-10">
                            <input type = "text" class = "form-control" id = "lastname" placeholder = "Enter Last Name" ng-model='formModel.lastname'>
                        </div>
                    </div>

                    <div class = "form-group">
                        <label for = "lastname" class = "col-sm-2 control-label">Tags</label>
                        <div class = "col-sm-10">
                            <tags-input 
                                name                    =   "tags"
                                ng-model                =   "formModel.tags" 
                                add-on-blur             =   "true"
                                ng-required             =   'false'
                                allow-leftover-text     =   "false"
                                on-tag-adding           =   "foofunc($tag)"
                                template                =   "my-custom-template"
                                >
                            </tags-input>

                            <script type="text/ng-template" id="my-custom-template">
                                <div class="tag-template">
                                    <span class="has-tooltip-new">{{$getDisplayText()}}
                                        <span class="tooltip-wrapper"><span class="tooltip-newone">Hello</span></span>
                                    </span>
                                    <a class="remove-button" ng-click="$removeTag()">&#10006;</a>
                                </div>
                            </script>
                            
                            <div class="alert alert-danger margintop10" role="alert" ng-show="theFirstForm.tags.$invalid">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>{{emailTagErrorMsg}}
                            </div>
                            <!-- emailTagError == true ||   -->
                            <p>Model: {{formModel.tags}}</p>
                            <p>$pristine: {{theFirstForm.tags.$pristine}}</p>
                            <p>$dirty: {{theFirstForm.tags.$dirty}}</p>
                            <p>$valid: {{theFirstForm.tags.$valid}}</p>
                             <p>$invalid: {{theFirstForm.tags.$invalid}}</p>
                            <p>$error: {{theFirstForm.tags.$error}} </p>
                        </div>
                    </div>
                    <div class       = "form-group" >
                        <label for = "email" class = "col-sm-2 control-label" >Email</label>
                        <div class = "col-sm-10">
                            <input  type = "email" 
                                    class = "form-control" 
                                    id = "email" 
                                    placeholder = "Enter your email" 
                                    ng-model='formModel.email' 
                                    required ="required"
                                    name = 'email'
                            >
                            <div class="alert alert-danger margintop10" role="alert" 
                                ng-show="theFirstForm.email.$error.email && (!theFirstForm.$pristine || theFirstForm.$submitted)">
                                 <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>Please enter a valid email.
                             </div>
                            <div class="alert alert-danger margintop10" role="alert" ng-show="theFirstForm.email.$error.required && (!theFirstForm.$pristine || theFirstForm.$submitted)">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> This field is required.
                            </div>
                            
                            <pre>Validation ? {{ theFirstForm.email.$error | json }} </pre>
                            <pre>Field Valid ? {{ theFirstForm.email.$valid }} </pre>
                            <pre>Field pristine ? {{ theFirstForm.$pristine }} </pre>
                            <pre>Form Submitted ? {{ theFirstForm.$submitted }} </pre>
                        </div>
                    </div>
                    <div class = "form-group">
                        <label for = "sex" class = "col-sm-2 control-label">Choose Sex</label>
                        <div class = "col-sm-10">
                            <select name='sex' id='sex' class = "form-control" ng-model="formModel.sex">
                               <option value="">Please choose </option>
                               <option value="male">Male</option>
                               <option value="female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class = "form-group">
                        <label for = "sex" class = "col-sm-2 control-label">Choose state</label>
                        <div class = "col-sm-10">
                            <!-- <select
                                    ng-model  ="formModel.state" class = "form-control" 
                                    ng-options="item.state for item in statedata"
                                    ng-change ="getCities()" >
                                <option value="">Select</option>
                            </select> -->
                             <button type="button" class="btn btn-default dropdown-toggle " ng-class="(isDisableTypeofTest) ? 'error_border' : ''" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="init();" ng-disabled="isDisableTypeofTest">
                             {{ selectedState }}<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" ng-click="setAction('Select');">Select</a></li>
                                <li ng-repeat="statelist in statedata"><a href="javascript:void(0)" ng-click="getSelectedstate(statelist.name); cityDropdown()">{{ statelist.name }}</a></li>
                            </ul>

                            <input type="text" name="selectedState" ng-model="selectedState" hidden />

                            <div class="alert alert-danger margintop10" role="alert" ng-show="theFirstForm.selectedState.$modelValue == 'Select' && (!theFirstForm.$pristine || theFirstForm.$submitted)">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> 
                                Please select a state
                            </div>
                            
                        </div>
                    </div>

                    <div class = "form-group">
                        <label for = "sex" class = "col-sm-2 control-label">Choose City</label>
                        <div class = "col-sm-10">
                            
                            <button type="button" class="btn btn-default dropdown-toggle " ng-class="(isDisableCity) ? 'error_border' : ''" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="init();" ng-disabled="isDisableCity">
                             {{ selectedCity }}<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <!-- <li><a href="#" ng-click="setAction('Select');">Select</a></li> -->
                                <li ng-repeat="city in cities"><a href="javascript:void(0)" ng-click="getSelectedcity(city.name)">{{ city.name }}</a></li>
                            </ul>
                            <input type="text" name="selectedCity" ng-model="selectedCity" hidden />
                            
                            <div class="alert alert-danger margintop10" role="alert" ng-show="theFirstForm.selectedCity.$modelValue == 'Select' && (!theFirstForm.$pristine || theFirstForm.$submitted)">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> 
                                Please select a city
                            </div>
                        </div>
                        
                    </div>
                    <!-- for select all checkbox -->
                    <div class = "form-group">
                        <label for = "sex" class = "col-sm-2 control-label">Choose City</label>
                        <div class = "col-sm-10">
                            
                            <button type="button" class="btn btn-default dropdown-toggle " ng-class="(isDisableCity) ? 'error_border' : ''" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-init="init();" ng-disabled="isDisableCity">
                             {{ selectedCity }}<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" ng-click="$event.stopPropagation()">
                                <!-- <li><a href="#" ng-click="setAction('Select');">Select</a></li> -->
                                <!-- <li ng-repeat="city in cities">
                                    <a href="javascript:void(0)" ng-click="getSelectedcity(city.name)">{{ city.name }}</a>
                                </li> -->
                                <li>
                                    <div class="checkbox rfcdrpd">
                                    <input type="checkbox" ng-model="allSelected" ng-click="toggleAll()" />
                                     </div> <span ng-show="allSelected" >All Selected</span>
                                            <span ng-hide="allSelected" >Select All</span>
                                </li>
                                <li ng-repeat="city in cities" ng-model="addform.rfcf">
                                    <div class="checkbox rfcdrpd">
                                        <input type="checkbox" value={{city.name}} ng-model="city.selected" ng-click="cbChecked()">
                                        <label for=" "></label>
                                    </div>{{city.name}}
                                </li>

                            </ul>
                            
                        </div>
                        
                    </div>


                    <div class = "form-group">
                        <div class = "col-sm-offset-2 col-sm-10">
                            <div class = "checkbox">
                                <label><input type = "checkbox" ng-model='formModel.rememberme'> Remember me</label>
                            </div>
                        </div>
                    </div>

                    <div class = "form-group">
                        <div class = "col-sm-offset-2 col-sm-10">
                            <button type = "submit" class = "btn btn-default" >Submit</button>
                        </div>
                    </div>
                </form>
            </div>   
        </div>
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
    $('[data-toggle="popover"]').popover({
        placement : 'top',
        trigger : 'hover'
    });

    $("#Addbutton").click(function() {
        console.log('clicked');
    $('html, body').animate({
        scrollTop: $("#DefaultForm").offset().top
    }, 2000);
});

});
</script>