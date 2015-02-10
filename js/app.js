(function(){
	var app = angular.module('radiology_protocol',['angularUtils.directives.dirPagination']);	
	app.controller("OtherController",['$http','$scope',function($http,$scope){
		$scope.pageChangeHandler = function(num) {
			console.log('going to page ' + num);
		};	
	}]);
	
	app.controller("PanelController", ['$http','$scope',function($http,$scope){
		$scope.currentPage = 1;
		$scope.pageSize = 10;
		$scope.pageChangeHandler = function(num) {
			console.log('meals page changed to ' + num);
		};
		//var pdata=this;
		$scope.search_key="";
		$scope.protocols=[];
		$scope.detail_protocol="";
		$scope.detail_protocol_modality="";
		$scope.detail_protocol_bodypart="";
		$scope.series=[];
		$scope.sections=[
			'Home',
			'Import',
			'History'		
		];
		$scope.records=[];
		$scope.history_start="";
		$scope.history_end="";
		
		this.tab='Home';
		this.selectprotocols=function(modal,bodypart){
			//console.log(bodypart);
			this.select('Protocols');
			//this.tab='Protocols';			
			$http({
				url: 'ajax/get_protocol',
				method: "POST",
				data : {modality:modal,bodypart_full:bodypart}
			}).success(function (data) {
				//console.log(data);
				if (angular.isObject(data)){					
					$scope.protocols=data.slice(0);
				}
				else{
					//console.log(data);
					$scope.protocols=[];
				}
				//console.log($scope.protocols);
				//$scope.users = data;
			}).error(function (data) {
				console.log(data);				
			});
		};	
		this.showHistory=function(){
			//console.log($scope.history_start);
			//console.log($scope.history_end);
			$http({
				url: 'ajax/get_record',
				method: "POST",
				data : {time_start:$scope.history_start,time_end:$scope.history_end}
			}).success(function (data) {
				//console.log(data);
				if (angular.isObject(data)){					
					$scope.records=data.slice(0);
				}
				else{
					//console.log(data);
					$scope.records=[];
				}				
			}).error(function (data) {
				console.log(data);				
			});
		}
		this.showDetailedProtocol=function(protocol_number,modality,bodypart){
			//console.log(protocol_number);
			this.tab='DetailedProtocol';	
			$scope.detail_protocol=protocol_number;
			$scope.detail_protocol_modality=modality;
			$scope.detail_protocol_bodypart=bodypart;
			$http({
				url: 'detailed_ajax/get_protocol',
				method: "POST",
				data : {number:protocol_number}
			}).success(function (data) {
				//console.log(data);
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
				data : {number:protocol_number}
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
		};
		this.searchprotocols=function(){
			console.log($scope.search_key);
			this.tab='Protocols';			
			$http({
				url: 'ajax/search_protocol',
				method: "POST",
				data : {content:$scope.search_key}
			}).success(function (data) {
				console.log(data);
				$scope.protocols=data.slice(0);
				//console.log($scope.protocols);				
			}).error(function (data) {
				console.log(data);				
			});	
		};	
		this.isSelected=function(selectTab){
			return this.tab===selectTab;
		};
		this.select=function(setTab){			
			this.tab=setTab;
			if (setTab=='History'){
				var today=new Date();				
				var dd = today.getDate();
				var mm = today.getMonth()+1; //January is 0!

				var yyyy = today.getFullYear();
				
				var start_m=mm-6;
				var start_y;
				if (start_m<0){
					start_m=mm+6;
					start_y=yyyy-1;
				}
				
				if(dd<10){
					dd='0'+dd
				} 
				if(mm<10){
					mm='0'+mm
				} 
				if (start_m<10){
					start_m='0'+start_m
				}
				
				$scope.history_start=start_y+'-'+start_m+'-'+dd;			
				$scope.history_end=yyyy+'-'+mm+'-'+dd;
				this.showHistory();
			}
		};	
		this.deleteprotocol=function(){			
			var contro=$(this);			
			bootbox.prompt("Password:", function(result) {                
				if (result === null) {                                             
					$('#result').html("Prompt dismissed!");                              
				} else {
					$http({
						url: 'detailed_ajax/delete',
						method: "POST",
						data : {number:$scope.detail_protocol,
								password:result}
					}).success(function (data) {
					console.log(data);
						if (data==="1"){
							contro[0].selectprotocols($scope.detail_protocol_modality,$scope.detail_protocol_bodypart);
							//$('#result').html("Delete success!"); 
						}else{
							$('#result').html("Wrong password!");
						}			
					}).error(function (data) {
						console.log(data);				
					});				        
				}
			});			
		}
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
			}).error(function (data) {
				console.log(data);				
			});;			
		};
	}]);
	
	
	var base_url="radiology";
	
})();
