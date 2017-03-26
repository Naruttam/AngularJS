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
?>
    <script type="text/javascript">
        var listdata = <?php echo json_encode($listarray)?>;
        var states  = <?php echo json_encode($statearray)?>;
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
    </head>
    <body ng-app="mdl">
        <div class='container' ng-controller="mdlContrlr">
           
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
                    <tr ng-repeat="x in records">
                        <td>{{ x.first_name}}</td>
                        <td>{{ x.last_name}}</td>
                        <td>{{ x.email}}</td>
                        <td>{{ x.sex}}</td>
                        <td>{{ x.state}}</td>
                        <td><a href="javascript:void(0);" ng-click="edit(x.id)">Edit</a></td>
                    </tr>

                </tbody>
            </table>

           <form class = "form-horizontal" role = "form" ng-submit="onSubmit(theFirstForm.$valid)" novalidate="novalidate" name="theFirstForm">
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
                        'has-error':!theFirstForm.tags.$valid && (!theFirstForm.tags.$pristine || theFirstForm.$submitted),
                        'has-success': theFirstForm.tags.$valid && (!theFirstForm.tags.$pristine || theFirstForm.$submitted)
                    }"
                >
                    <label for = "lastname" class = "col-sm-2 control-label">Tags</label>
                    <div class = "col-sm-10">
                        <tags-input 
                            name                    =   "tags"
                            ng-model                =   "formModel.tags" 
                            add-on-blur             =   "false"
                            ng-required             =   'true'
                            max-tags                =   "5"
                            allow-leftover-text     =   "false"
                            on-tag-adding           =   "foofunc($tag)" >
                        </tags-input>
                        <p class="help-block" ng-show="theFirstForm.tags.$error.minTags && (!theFirstForm.$pristine)">
                            Please enter at least three tags.
                        </p><p class="help-block" ng-show="showEmailError && (!theFirstForm.$pristine)">
                            Please enter a valid email.
                        </p>
                        <p>Model: {{formModel.tags}}</p>
                        <p>$pristine: {{theFirstForm.tags.$pristine}}</p>
                        <p>$dirty: {{theFirstForm.tags.$dirty}}</p>
                        <p>$valid: {{theFirstForm.tags.$valid}}</p>
                        <p>$error: {{theFirstForm.tags.$error}} </p>
                    </div>
                    
                </div>


                <div 
                    class       = "form-group" 
                    ng-class    ="{
                        'has-error':!theFirstForm.email.$valid && (!theFirstForm.$pristine || theFirstForm.$submitted),
                        'has-success': theFirstForm.email.$valid && (!theFirstForm.$pristine || theFirstForm.$submitted)
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
                            ng-show="theFirstForm.email.$error.required && (!theFirstForm.$pristine || theFirstForm.$submitted)">
                            This field is required.
                        </p>
                        <p  class="help-block" 
                            ng-show="theFirstForm.email.$error.email && (!theFirstForm.$pristine || theFirstForm.$submitted)">
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
                        <select ng-model  ="formModel.state" class = "form-control" 
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
                        <select ng-model="formModel.selCity" class = "form-control" 
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
            </form>
          <!--  <pre> {{ theFirstForm | json}} </pre> -->
        </div>
    </body>
</html>
