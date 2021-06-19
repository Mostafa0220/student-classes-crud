var app = angular.module('myApp', [])

app.controller('studentController', function($scope, $http) {


    var url = 'http://localhost:8000/api';

    $scope.fetchAllStudents = function() {
        $http.get(url).then(function(response) {
            $scope.students = response.data;
        });
    };
    $scope.fetchAllClasses = function() {
        $http.get(url + '/classes').then(function(response) {
            $scope.classes = response.data;
        });
    };




    // set default birthday value
    $scope.birthday = "1990-07-15";

    // create function to get age
    $scope.calculateAge = function(birthday) {
        var birthday = new Date(birthday);
        var today = new Date();
        var age = ((today - birthday) / (31557600000));
        var age = Math.floor(age);
        return age;
    }


    // assign default value to date_of_birth
    if (!$scope.date_of_birth) {

        $scope.date_of_birth = $scope.birthday;

    }

    $scope.fetchAllStudents();
    $scope.fetchAllClasses();

    $scope.storeStudent = function() {


        // get the age and asign to age scope
        $scope.age = $scope.calculateAge($scope.date_of_birth);



        var dataObj = {
            first_name: $scope.first_name,
            last_name: $scope.last_name,
            date_of_birth: $scope.date_of_birth,
            class_id: $scope.class_id
        }

        $http.post(url + '/add', dataObj).then(function(response) {
            if (response.data.message) {
                $scope.storeStudentResponse = response.data;
            } else {
                $scope.first_name = "";
                $scope.last_name = "";
                $scope.date_of_birth = "";
                $scope.class_id = "";
                $scope.storeStudentResponse = "";
                $scope.fetchAllStudents();
            }

        });
    };

    $scope.showStudent = function(id) {
        $http.get(url + '/show/' + id).then(function(response) {
            $scope.showFirstName = response.data.first_name;
            $scope.showLastName = response.data.last_name;
            $scope.showClassId = response.data.class_id;
            $scope.showDateOfBirth = response.data.date_of_birth;
            $scope.showId = response.data.id;
        });
    };

    $scope.updateStudent = function(id) {


        var dataObj = {
            first_name: $scope.showFirstName,
            last_name: $scope.showLastName,
            date_of_birth: $scope.showDateOfBirth,
            class_id: $scope.showClassId
        }

        $http.post(url + '/edit/' + id, dataObj).then(function(response) {
            if (response.data.message) {
                $scope.updateStudentResponse = response.data;
            } else {
                $('#myModal').modal('hide');
                $scope.fetchAllStudents();
            }
        });
    };

    $scope.destroyStudent = function(id) {
        $http.get(url + '/remove/' + id).then(function(response) {
            $scope.destroyStudentResponse = response.data;
            console.log(response.data);
            $scope.fetchAllStudents();
        });
    };




});