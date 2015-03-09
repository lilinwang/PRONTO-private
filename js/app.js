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
		$scope.all_series_button="Show All Series";
		$scope.all_history_button="Show All History";
		$scope.search_key="";
		$scope.protocols=[];
		$scope.detail_protocol="";
		$scope.detail_protocol_modality="";
		$scope.detail_protocol_bodypart="";
		$scope.series=[];
		$scope.sections=[
			'Home',
			'Import',
			'Export',
			'History'		
		];
		$scope.records=[];
		$scope.history_start="";
		$scope.history_end="";
		$scope.export_ct_options={
			neuro_ct:false,
			head:false,
			neck:false,		
			cervical_spine:false,
			thoracic_spine:false,			
			lumbar_spine:false,
			lumbar_spine_cord:false,
			brachial_plexus:false,
			facial_bones:false,
			ankle:false,
			foot:false,
			shoulder:false,
			wrist:false,
			hand:false,
			pelvis:false,
			hip:false,
			knee:false,
			variable:false,
			abdomen_pelvis:false,
			others:false,
			heart:false
		};
		
		$scope.export_protocols=[];	
		$scope.export_data=function(modal){
			var bodypart=[];
			$scope.export_protocols=[];			
			angular.forEach($scope.export_ct_options,function(value,key){
				if (value){					
					bodypart.push(key);	
				}
			});			
			if (bodypart.length<1){
				$("#dialog").html("<p>No data selected.</p>");
				var theDialog = $("#dialog").dialog(opt);					
				var dialog = theDialog.dialog("open");
				setTimeout(function() { dialog.dialog("close"); }, 1800);
				return;
			}
			$http({
				url: 'ajax/export_protocol',
				method: "POST",
				data : {modality:modal,bodypart_full:bodypart}
			}).success(function (data) {
				console.log(data);
				if (angular.isObject(data)){										
					$scope.export_protocols=data.slice(0);						
					alasql('SELECT * INTO CSV("export_protocols.csv",{headers:true}) FROM ?',[$scope.export_protocols]);
				}else{
					$("#dialog").html("<p>No data exported. Try another one.</p>");
					var theDialog = $("#dialog").dialog(opt);					
					var dialog = theDialog.dialog("open");
					setTimeout(function() { dialog.dialog("close"); }, 1800);
				}
			}).error(function (data) {
				console.log(data);				
			});
		};
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
		this.showAllSeries=function(){
			if ($scope.all_series_button=="Show All Series"){
				$scope.all_series_button="Hide All Series";
				for (i = 0; i < $scope.series.length; i++) { 
					$scope.series[i].show=true;
				}			
			} else {
				$scope.all_series_button="Show All Series";
				for (i = 0; i < $scope.series.length; i++) { 
					$scope.series[i].show=false;
				}	
			}
		}
		this.showSeries=function(serie){
			serie.show=!serie.show;
		}
		
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
		this.showAllHistory=function(){		
			if ($scope.all_history_button=="Show All History"){
				$scope.all_history_button="Show New/Modified History";
				$http({
					url: 'ajax/get_all_record',
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
			} else {
				$scope.all_history_button="Show All History";
				this.showHistory();
			}			
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
					//console.log($scope.series);
					for (i = 0; i < $scope.series.length; i++) { 
						$scope.series[i].show=false;
					}
					//console.log($scope.series);
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
