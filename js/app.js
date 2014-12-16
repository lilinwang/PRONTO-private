(function(){
	var app = angular.module('store',[]);
	app.controller("PanelController", ['$http','$scope',function($http,$scope){
		//var pdata=this;
		$scope.protocols=[];
		this.tab=1;
		this.selectprotocols=function(modal,bodypart){
			console.log(bodypart);
			this.tab=6;			
			$http({
				url: 'ajax/get_protocol',
				method: "POST",
				data : {modality:modal,bodypart_full:bodypart}
			}).success(function (data) {
				console.log(data);
				$scope.protocols=data.slice(0);
				console.log($scope.protocols);
				//$scope.users = data;
			});	
		};		
		this.isSelected=function(selectTab){
			return this.tab===selectTab;
		};
		this.select=function(setTab){
			this.tab=setTab;
		};			
	}]);		
	app.controller("protocolController", ['$http','$scope',function($http,$scope){
		$scope.cred = {protocol_number:"",protocol_name: "",code: "",description: "",modality: "",bodypart: "",bodypart_full: "",approval_date: "",golive_date: "",approved_by: "",series: "",notes: "",indication:"",patient_orientation:"",landmark:"",intravenous_contrast:"",scout:""};
		
		$scope.addprotocol = function() {
			console.log($scope.cred);
			$http({
				url: 'ajax/add_protocol',
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
