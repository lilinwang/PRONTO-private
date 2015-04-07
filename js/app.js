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
		$scope.detail_protocol_category="";
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
			CTChest_Adult:false,
			CTChest_Peds:false,
			CTBody_Adult:false,
			CTBody_Peds:false,
			CTChestbody_Adult:false,
			CTChestbody_Peds:false,
			CTMusculoskeletal:false,
			CTNeuro_Head_Adult:false,
			CTNeuro_Head_Peds:false,
			CTNeuro_Face_Adult:false,
			CTNeuro_Face_Peds:false,
			CTNeuro_Neck_Adult:false,
			CTNeuro_Neck_Peds:false,
			CTNeuro_Spine_Adult:false,
			CTNeuro_Spine_Peds:false
		};
		$scope.export_mr_options={			
			head:false,
			neck:false,		
			cervical_spine:false,
			thoracic_spine:false,			
			lumbar_spine:false,
			ctl_cord:false,			
			variable:false,			
			others:false
		};
		$scope.menus={
			1:{
				name:'CTNeuro',
				second_menus:{
					1:{
						name:'Head',
						third_menus:{
							1:{
								name:'Adult'								
							},
							2:{
								name:'Peds'								
							}
						}
					},
					2:{
						name:'Neck',
						third_menus:{
							1:{
								name:'Adult'								
							},
							2:{
								name:'Peds'								
							}
						}
					},
					3:{
						name:'Spine',
						third_menus:{
							1:{
								name:'Adult'								
							},
							2:{
								name:'Peds'								
							}
						}
					},
					4:{
						name:'Face',
						third_menus:{
							1:{
								name:'Adult'								
							},
							2:{
								name:'Peds'								
							}
						}
					}
				}
			},
			2:{
				name:'CTMusculoskeletal'				
			},
			3:{
				name:'CTChestBody',
				second_menus:{
					1:{
						name:'Adult'								
					},
					2:{
						name:'Peds'								
					}
				}
			},
			4:{
				name:'CTChest',
				second_menus:{
					1:{
						name:'Adult'								
					},
					2:{
						name:'Peds'								
					}
				}
			}
		}
		$scope.export_protocols=[];	
		$scope.check_all=function(modal,status){
			if (modal=='MR'){
				angular.forEach($scope.export_mr_options,function(value,key){
					$scope.export_mr_options[key]=status;
				});	
			}else{
				angular.forEach($scope.export_ct_options,function(value,key){
					$scope.export_ct_options[key]=status;
				});
			}
		};
		$scope.export_data=function(modal){
			var category=[];
			$scope.export_protocols=[];	
			if (modal=="MR"){
				angular.forEach($scope.export_mr_options,function(value,key){
					if (value){					
						category.push(key);	
					}
				});	
			}else{
				angular.forEach($scope.export_ct_options,function(value,key){
					if (value){					
						category.push(key);	
					}
				});			
			}
			//console.log(category);
			if (category.length<1){
				$("#dialog").html("<p>No data selected.</p>");
				var theDialog = $("#dialog").dialog(opt);					
				var dialog = theDialog.dialog("open");
				setTimeout(function() { dialog.dialog("close"); }, 1800);
				return;
			}
			$http({
				url: 'ajax/export_protocol',
				method: "POST",
				data : {modality:modal,category_full:category}
			}).success(function (data) {
				console.log(data);
				/*var one_protocol=[];				
				var len=$scope.series.length;
				for (var i=0;i<len;i++){				
					var tmp={};				
					angular.extend(tmp, $scope.protocols[0],$scope.series[i], true);
					delete tmp['id'];
					delete tmp['show'];
					one_protocol.push(tmp);
				}*/								
				
				if (modal=="MR"){
					for (var i=0;i<category.length;i++){
						$scope.export_mr_options[category[i]]=false;
					}								
				}else{
					for (var i=0;i<category.length;i++){
						$scope.export_ct_options[category[i]]=false;
					}	
				}
			
				if (angular.isObject(data)){										
					$scope.export_protocols=data.slice(0);						
					for (var i=0;i<$scope.export_protocols.length;i++){
						delete $scope.export_protocols[i]['id'];
					}
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
		this.selectprotocols=function(category_data){
			console.log(category_data);
			this.select('Protocols');
			//this.tab='Protocols';			
			$http({
				url: 'ajax/get_protocol',
				method: "POST",
				data : {category:category_data}
			}).success(function (data) {
				//console.log(data);
				if (angular.isObject(data)){					
					$scope.protocols=data.slice(0);
				}
				else{
					//console.log(data);
					$scope.protocols=[];
				}
				//console.log($scope.protocols[0]);
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
		this.showDetailedProtocol=function(protocol_number,protocol_category){
			//console.log(protocol_number);
			this.tab='DetailedProtocol';	
			$scope.detail_protocol=protocol_number;
			$scope.detail_protocol_category=protocol_category;
			$scope.all_series_button="Show All Series";
			
			$http({
				url: 'detailed_ajax/get_protocol',
				method: "POST",
				data : {number:protocol_number}
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
				data : {number:protocol_number,category:protocol_category}
			}).success(function (data) {
				console.log(data);
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
		this.export_one_protocol=function(){
			var one_protocol=[];	
			//console.log($scope.protocols);
			//console.log($scope.series);
			var len=$scope.series.length;
			for (var i=0;i<len;i++){				
				var tmp={};
				//tmp.concat($scope.protocols[0],$scope.series[i]);
				angular.extend(tmp, $scope.protocols[0],$scope.series[i], true);
				delete tmp['id'];
				delete tmp['show'];
				one_protocol.push(tmp);
			}								
			//console.log(one_protocol);
			alasql('SELECT * INTO CSV("export_one_protocol.csv",{headers:true}) FROM ?',[one_protocol]);				
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
								password:result,category:$scope.detail_protocol_category}
					}).success(function (data) {
					console.log(data);
						if (data==="1"){
							contro[0].selectprotocols($scope.detail_protocol_category);
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
	
	
	
	
	var base_url="radiology";
	
})();
