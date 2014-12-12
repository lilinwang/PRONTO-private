(function(){
	var app = angular.module('store',[]);
	app.controller("PanelController", function(){
		this.tab=1;
		this.isSelected=function(selectTab){
			return this.tab===selectTab;
		};
		this.select=function(setTab){
			this.tab=setTab;
		};			
	});	
	app.controller("ProtocalController", ['$http','$scope',function($http,$scope){
		$scope.cred = {protocal_name: "",code: "",description: "",modality: "",bodypart: "",bodypart_full: "",approval_date: "",golive_date: "",approved_by: "",series: "",scan_position:"",notes: ""};
		
		$scope.addProtocal = function() {
			console.log($scope.cred);
			$http({
				url: 'ajax/add_protocal',
				method: "POST",
				data : $scope.cred
			}).success(function (data) {
				console.log(data);
				//$scope.users = data;
			});			
		};
	}]);
	
	
	var base_url="radiology";
	
})();
