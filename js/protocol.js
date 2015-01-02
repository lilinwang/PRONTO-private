(function(){
	var app = angular.module('store',[]);
	app.controller("PanelController", ['$http','$scope',function($http,$scope){				
		$scope.protocols=[];
		$scope.series=[];
		$scope.init=function(numb){
			console.log(numb);
			$http({
				url: 'detailed_ajax/get_protocol',
				method: "POST",
				data : {number:numb}
			}).success(function (data) {
				console.log(data);
				if (angular.isObject(data)){					
					$scope.protocols=data.slice(0);
				}
				else{
					//console.log(data);
					$scope.protocols=[];
				}
			}).error(
				function (data) {
				console.log(data);				
			});				
			
			$http({
				url: 'detailed_ajax/get_series',
				method: "POST",
				data : {number:numb}
			}).success(function (data) {
				//console.log(data);
				if (angular.isObject(data)){					
					$scope.series=data.slice(0);
				}
				else{
					//console.log(data);
					$scope.series=[];
				}
			}).error(
				function (data) {
				console.log(data);				
			});	
		}		
	}]);			
	
})();
