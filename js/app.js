(function(){
	var app = angular.module('store',[]);
	app.controller("PanelController", ['$http',function($http){
		var pdata=this;
		pdata.protocals=[];
		this.tab=1;
		this.selectProtocals=function(modal,bodypart){
			this.tab=6;
			$http({
				url: 'ajax/get_protocal',
				method: "POST",
				data : {modality:modal,bodypart_full:bodypart}
			}).success(function (data) {
				pdata.protocals=data;
				console.log(data);
			});	
		};		
		this.isSelected=function(selectTab){
			return this.tab===selectTab;
		};
		this.select=function(setTab){
			this.tab=setTab;
		};			
	}]);	
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
