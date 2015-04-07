<!DOCTYPE html>
<html lang="en" ng-app="radiology_protocol">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Radiology Protocols</title>
	
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">    
    <link href="css/plugins/dataTables.bootstrap.css" rel="stylesheet">	
	<link href="font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="css/sb-admin-2.css" rel="stylesheet">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<link rel="stylesheet" href="css/datepicker.css">
	<link href="css/style.css" rel="stylesheet">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	 <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>		
	<script type="text/javascript" src="js/jquery-ui.js"></script>	
    <script type="text/javascript" src="js/bootstrap-filestyle.js"> </script>
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>
    <script src="js/sb-admin-2.js"></script>	
	<script src="js/bootbox.min.js"></script>	
	<script type="text/javascript" src="js/angular.js"></script>
	<script type="text/javascript" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.11.0.js"></script>
	<script src="js/dirPagination.js"></script>
	<script type="text/javascript" src="js/alasql.min.js"></script>
	<script type="text/javascript" src="js/xlsx.core.min.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script type="text/javascript">		   

	var opt={				
		height: 150,
        width: 250,
		autoOpen: false,		
	}
	function sentNotification(e){
		$(e).prop('disabled', true);
	}
	function upload(){						
		var file_data = $("#userfile").prop("files")[0];   		
		var fileName = $("#userfile").val();
		//var user_name = '@Session["user_name"]';
		
		if(fileName.lastIndexOf("csv")===fileName.length-3){										
			$('#upload-icon').html('<i class="fa fa-spin fa-spinner"></i>');
			var form_data = new FormData();                  
			form_data.append("file", file_data);  
			//form_data.append("username", user_name);  
			$.ajax({
                url: "ajax/upload",               
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
				enctype: 'multipart/form-data',
                complete: function(data){				
					console.log(data['responseText']);																                   									
					var response = JSON.parse(data['responseText']);
					//console.log(response);
					$('#upload-icon').html('<i class="fa fa-upload"></i>');					
					$("#dialog").html("<p>Import success!</p>");
					var theDialog = $("#dialog").dialog(opt);					
					var dialog = theDialog.dialog("open");
					setTimeout(function() { dialog.dialog("close"); }, 1000);
					//alert(response.length);
					//$('#import-result').html(response.length);
					$('#import-result').html("<h3>Imported protocols:</h3></br>");
					
					/*for (var i=0;i<response[0].length;i++){							
						
							$('#import-result').append("<div class='form-group row'><label class='col-md-3 control-label'>"+response[0][i]+"</label><label class='col-md-3 control-label'>"+response[1][i]+"</label><label class='col-sm-2'>"+response[2][i]+"</label><button class='btn btn-primary btn-sm' onclick='sentNotification(this)'>Send Notification</button></div>");						
					}*/
					var status=["new protocol","modified","no change"];
					for (var i=0;i<response[0].length;i++){							
						if (response[2][i]!=2){
							$('#import-result').append("<div class='form-group row'><label class='col-md-3 control-label'>"+response[0][i]+"</label><label class='col-md-3 control-label'>"+response[1][i]+"</label><label class='col-sm-2'>"+status[response[2][i]]+"</label><button class='btn btn-primary btn-sm' onclick='sentNotification(this)'>Send Notification</button></div>");
						}
					}	
					for (var i=0;i<response[0].length;i++){							
						if (response[2][i]==2){
							$('#import-result').append("<div class='form-group row'><label class='col-md-3 control-label'>"+response[0][i]+"</label><label class='col-md-3 control-label'>"+response[1][i]+"</label><label class='col-sm-2'>"+status[response[2][i]]+"</label></div>");
						}
					}
                }
			});				            			     	
		}else{
			$("#dialog").html("<p>Not csv file choosen!</p>");
			var theDialog = $("#dialog").dialog(opt);					
			var dialog = theDialog.dialog("open");
			setTimeout(function() { dialog.dialog("close"); }, 1000);
		}
	};			
	
	</script>
</head>

<body ng-controller="PanelController as panel">
<script>

</script>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home">Radiology Protocols</a>
            </div>
            <!-- /.navbar-header -->
			<ul class="nav navbar-top-links navbar-left">
				<li ng-repeat="section in sections" ng-class="{ active: panel.isSelected(section)}">
					<a href ng-click="panel.select(section)">{{section}}</a> 
				</li>					
			</ul>
			
            <ul class="nav navbar-top-links navbar-right">      
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="/radiology/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
					
            <div class="navbar-default sidebar" role="navigation">				
                <div class="sidebar-nav navbar-collapse">					
                    <ul class="nav" id="side-menu">
						<li>
							<h4 class="navbar-brand">protocols</h4>
						</li>
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" ng-model="search_key" ng-keyup="$event.keyCode == 13 && panel.searchprotocols()" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" ng-click="panel.searchprotocols()" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>						
                        
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> CTNeuro <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li> 
									<a href>Head<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li><a href ng-click="panel.selectprotocols('CTNeuro-Head-Adults')">Adults</a></li>
										<li><a href ng-click="panel.selectprotocols('CTNeuro-head-peds')">Peds</a></li>
									</ul>
								</li>						                               
                                <li> 
									<a href>Neck<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li><a href ng-click="panel.selectprotocols('CTNeuro-neck-adults')">Adults</a></li>
										<li><a href ng-click="panel.selectprotocols('CTNeuro-neck-peds')">Peds</a></li>
									</ul>
								</li>
								<li> 
									<a href="#">Spine<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li><a href ng-click="panel.selectprotocols('CTNeuro-spine-adults')">Adults</a></li>
										<li><a href ng-click="panel.selectprotocols('CTNeuro-spine-peds')">Peds</a></li>
									</ul>
								</li>
								<li> 
									<a href="#">Face<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li><a href ng-click="panel.selectprotocols('CTNeuro-face-adults')">Adults</a></li>
										<li><a href ng-click="panel.selectprotocols('CTNeuro-face-peds')">Peds</a></li>
									</ul>
								</li>
                            </ul>                           
                        </li>
						<li>
                            <a href ng-click="panel.selectprotocols('CTMusculoskeletal')"><i class="fa fa-wrench fa-fw"></i> CTMusculoskeletal </span></a>                                    
                        </li>
						<li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> CTChestBody <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li><a href ng-click="panel.selectprotocols('CTChestBody-adults')">Adults</a></li>
								<li><a href ng-click="panel.selectprotocols('CTChestBody-peds')">Peds</a></li>								
                            </ul>                           
                        </li>
						<li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> CTChest <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li><a href ng-click="panel.selectprotocols('CTChest-adults')">Adults</a></li>
								<li><a href ng-click="panel.selectprotocols('CTChest-peds')">Peds</a></li>								
                            </ul>                           
                        </li>
                       <!-- <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Musculoskeletal CT<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','Ankle')">Ankle</a>
                                </li>
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','Foot')">Foot</a>
                                </li>
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','neShoulderck')">Shoulder</a>
                                </li>
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','Wrist')">Wrist</a>
                                </li>
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','Hand')">Hand</a>
                                </li>
								<li>
                                    <a href ng-click="panel.selectprotocols('CT','Pelvis')">Pelvis</a>
                                </li>
								<li>
                                    <a href ng-click="panel.selectprotocols('CT','Hip')">Hip</a>
                                </li>
								<li>
                                    <a href ng-click="panel.selectprotocols('CT','Knee')">Knee</a>
                                </li>
								<li>
                                    <a href ng-click="panel.selectprotocols('CT','Variable')">Variable</a>
                                </li>								
                            </ul>
                           
                        </li>
						<li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Body CT<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','Abdomen/Pelvis')">Abdomen/Pelvis</a>
                                </li>
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','Others')">Others</a>
                                </li>                                	
                            </ul>
                           
                        </li>
						<li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Cardiac CT<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href ng-click="panel.selectprotocols('CT','Heart')">Heart</a>
                                </li>                                                          
                            </ul>
                        </li>
						<li>
                            <a href href ng-click="panel.selectprotocols('MR','')"><i class="fa fa-wrench fa-fw"></i> Body MR</a>                            
                        </li>
						<li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Neuro MR<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href ng-click="panel.selectprotocols('MR','Head')">Head</a>
                                </li>                                                          
								<li>
                                    <a href ng-click="panel.selectprotocols('MR','Neck')">Neck</a>
                                </li> 
								<li>
                                    <a href ng-click="panel.selectprotocols('MR','Cervical Spine')"> Cervical Spine</a>
                                </li>
                                <li>
                                    <a href ng-click="panel.selectprotocols('MR','Thoracic Spine')">Thoracic Spine</a>
                                </li>
                                <li>
                                    <a href ng-click="panel.selectprotocols('MR','Lumbar Spine')">Lumbar Spine</a>
                                </li>
								<li>
                                    <a href ng-click="panel.selectprotocols('MR','CTL Spine')">CTL Spine</a>
                                </li> 
								<li>
                                    <a href ng-click="panel.selectprotocols('MR','Variable')">Variable</a>
                                </li> 
								<li>
                                    <a href ng-click="panel.selectprotocols('MR','Others')">Others</a>
                                </li> 
                            </ul>
                            
                        </li>    
-->						
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper" name="home">
			<div ng-show="panel.isSelected('Home')">				 
			<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Home</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>            
            <!-- /.row -->
			<div class="row">
                <div class="col-lg-12">
				Welcome to the radiology.com web site. This is the world’s first site that can convert MR & CT scanning sequence parameters in machine language directly into an easily readable format, and allow you to download a file to import directly into your own scanner without the time consuming practice of entering every sequence manually. Please visit our about page for more information. We are currently adding new protocols to this site in every category.
				</div>
			</div>
			</div>
					
			
			<div ng-show="panel.isSelected('Import')">	
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">Import</h1>
					</div>
					<!-- /.col-lg-12 -->
				</div>            
				<!-- /.row -->
				
				<div class="row">
					<div class="col-lg-12">
						<div  class="input-group" style="width:500px;margin-left:15px;height:50px;">
							<span class="input-group-btn">
								<span class="input-group-btn">
								<input type="file" class="filestyle" data-buttonText="Choose csv file" id="userfile" name='userfile' >
								</span>
                                <span class="input-group-btn">
									
                                    <button class="btn btn-default" onclick="upload()" name="submit" type="button" id="upload-icon">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </span>
							</span>
                        </div>									
						<div id='import-result'></div>
					</div>
				</div>
			</div>
			
			
			<div ng-show="panel.isSelected('Export')">	
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">Export</h1>
					</div>
					<!-- /.col-lg-12 -->
				</div>            
				<!-- /.row -->
				
				<div class="row">
                <div class="col-lg-12 export">
				<p>Neuro CT </p>			
				<div class="checkbox exportbox">
					<label>
						<input type="checkbox" ng-model="export_ct_options.CTNeuro_Head_Adults"> Head-Adults
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.CTNeuro_Head_Peds"> Head-Peds
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.CTNeuro_Neck_Adults"> Neck-Adults
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.CTNeuro_Neck_Peds"> Neck-Peds
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.CTNeuro_Spine_Adults"> Spine-Adults
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.CTNeuro_Spine_Peds"> Spine-Peds
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.CTNeuro_Face_Adults"> Face-Adults
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.CTNeuro_Face_Peds"> Face-Peds
					</label>
				</div>	
				<p>Musculoskeletal CT <input type="checkbox" ng-model="export_ct_options.CTMusculoskeletal"></p>			
				
				<p>ChestBody CT </p>			
				<div class="checkbox exportbox">
					<label>
						<input type="checkbox" ng-model="export_ct_options.CTChestbody_Adults"> Adults
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.CTChestbody_Peds"> Peds
					</label>					
				</div>	
				<p> Chest CT </p>			
				<div class="checkbox exportbox">
					<label>
						<input type="checkbox" ng-model="export_ct_options.CTChest_Adults"> Adults
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.CTChest_Peds"> Peds
					</label>						
				</div>	
				<div id='export-result'></div>
				<button class="btn btn-default" type="button" ng-click="export_data('CT')">
					Export CT
				</button>	
				<button class="btn btn-default" type="button" ng-click="check_all('CT',true)">
					Check all CT
				</button>	
				<button class="btn btn-default" type="button" ng-click="check_all('CT',false)">
					Uncheck all CT
				</button>	
				</div>
				</div>				
				<!--
				<p>Neuro CT </p>			
				<div class="checkbox exportbox">
					<label>
						<input type="checkbox" ng-model="export_ct_options.head"> Head
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.neck"> Neck
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.cervical_spine"> Cervical Spine
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.thoracic_spine"> Thoracic Spine
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.lumbar_spine"> Lumbar Spine
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.lumbar_spine_cord"> Lumbar Spine Cord
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.brachial_plexus"> Brachial Plexus
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.facial_bones"> Facial Bones
					</label>
				</div>	
				<p>Musculoskeletal CT </p>			
				<div class="checkbox exportbox">
					<label>
						<input type="checkbox" ng-model="export_ct_options.ankle"> Ankle
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.foot"> Foot
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.shoulder"> Shoulder
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.wrist"> Wrist
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.hand"> Hand
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.pelvis"> Pelvis
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.hip"> Hip
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.knee"> Knee
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.variable"> Variable
					</label>
				</div>	
				<p>Body CT </p>			
				<div class="checkbox exportbox">
					<label>
						<input type="checkbox" ng-model="export_ct_options.abdomen_pelvis"> Abdomen/Pelvis
					</label>
					<label>
						<input type="checkbox" ng-model="export_ct_options.others"> Others
					</label>					
				</div>	
				<p>Cardiac CT </p>			
				<div class="checkbox exportbox">
					<label>
						<input type="checkbox" ng-model="export_ct_options.heart"> Heart
					</label>					
				</div>	
				<div id='export-result'></div>
				<button class="btn btn-default" type="button" ng-click="export_data('CT')">
					Export CT
				</button>	
				</div>
				</div>				
				
				<div class="row">
                <div class="col-lg-12 export">				
				<p>Body MR </p>			
				
				<p>Neuro MR </p>			
				<div class="checkbox exportbox">
					<label>
						<input type="checkbox" ng-model="export_mr_options.head"> Head
					</label>
					<label>
						<input type="checkbox" ng-model="export_mr_options.neck"> Neck
					</label>
					<label>
						<input type="checkbox" ng-model="export_mr_options.cervical_spine"> Cervical Spine
					</label>
					<label>
						<input type="checkbox" ng-model="export_mr_options.thoracic_spine"> Thoracic Spine
					</label>
					<label>
						<input type="checkbox" ng-model="export_mr_options.lumbar_spine"> Lumbar Spine
					</label>
					<label>
						<input type="checkbox" ng-model="export_mr_options.ctl_spine"> CTL Spine
					</label>
					<label>
						<input type="checkbox" ng-model="export_mr_options.variable"> Variable
					</label>
					<label>
						<input type="checkbox" ng-model="export_mr_options.others"> Others
					</label>
				</div>	
			
				<div id='export-result'></div>
				<button class="btn btn-default" type="button" ng-click="export_data('MR')">
					Export MR
				</button>	
				</div>				
				</div>
-->				
			</div>
			
			
			<div ng-show="panel.isSelected('Protocols')">				 
			<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Protocols</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>       
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            DataTables Advanced Tables
                        </div>
						<div class="form-group row" style="margin-top:15px;margin-left:15px;margin-bottom:-15px;">							
							<div >
								<div class="form-group row col-md-10" style="float:right;">
									<label class="col-md-1 control-label">Search:</label>
									<div class="col-md-3">
										<input ng-model="q" type="text" class="form-control" placeholder="Filter text">
									</div>
									
									<label class="col-md-2 control-label" >items per page:</label>
									<div class="col-md-2">
										<input type="number" min="1" max="100" type="text" class="form-control" ng-model="pageSize">
									</div>
								</div>
							</div>
						</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-protocol">
                                    <thead>
                                        <tr>											
                                            <th>protocol Name</th>
											<th>protocol Category</th>
											<th>Indication</th>																															
										</tr>
                                    </thead>
                                    <tbody>										 																			
                                        <tr class="odd gradeX" ng-repeat="protocol in protocols" ng-click="panel.showDetailedProtocol(protocol.protocol_number,protocol.protocol_category)" style="cursor: pointer">											
                                            <td>{{protocol.protocol_name}}</td>
											<td>{{protocol.protocol_category}}</td>                                            											
											<td>{{protocol.indication}}</td>
                                                                                								
                                        </tr>                                       
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->  							
                        </div>
						<div ng-controller="OtherController" >         
							<div class="text-center">
								<dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="dirPagination.tpl.html"></dir-pagination-controls>
							</div>
						</div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			</div>	
						
		 <div class="row" ng-show="panel.isSelected('DetailedProtocol')">
							 
			<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Detailed Protocol</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>       
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Protocol
                        </div>
						<div class="form-group row" style="margin-top:15px;margin-left:15px;margin-bottom:-15px;">							
							<div >
								<div class="form-group row col-md-10" style="float:right;">
									<label class="col-md-1 control-label">Search:</label>
									<div class="col-md-3">
										<input ng-model="q" type="text" class="form-control" placeholder="Filter text">
									</div>
									
									<label class="col-md-2 control-label" >items per page:</label>
									<div class="col-md-2">
										<input type="number" min="1" max="100" type="text" class="form-control" ng-model="pageSize">
									</div>
								</div>
							</div>
						</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="dataTables-detailed">
                                    <thead>
                                        <tr>
											<th>protocol Name</th>
											<th>protocol Category</th>
											<th>Indication</th>									
										</tr>
                                    </thead>
                                    <tbody>										 																			
                                        <tr class="odd gradeX" ng-repeat="protocol in protocols">										
											<td>{{protocol.protocol_name}}</td>
											<td>{{protocol.protocol_category}}</td>                                            											
											<td>{{protocol.indication}}</td>                                          									 
                                        </tr>                                       
                                    </tbody>
                                </table>
								</div>
                            <!-- /.table-responsive -->                           
                        </div>
						<div ng-controller="OtherController" >         
							<div class="text-center">
								<dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="dirPagination.tpl.html"></dir-pagination-controls>
							</div>
						</div>
                        <!-- /.panel-body -->
                    </div>
                    
						
					<div class="panel-body">					
						<p style="font-size:20px">Series
							<span class="btn btn-default" ng-click="panel.showAllSeries(this)" type="button">
								{{all_series_button}}
							</span>
						<p>
							<ul class="nav" >                                                                                            									 
								<li ng-repeat="serie in series">
									<a style="font-size:18px" ng-click="panel.showSeries(serie)"> {{serie.series_name}}<span class="fa arrow"></span></a>									
									<ul class="nav series" ng-show="serie.show && detail_protocol_category[0]=='C'" >																				                                                                                                                                                                                                                                                                    
										<li><h4>Patient Orientation</h4>{{serie.patient_orientation}}</li>																				
                                        										
										<li><h4>Intravenous Contrast</h4>{{serie.intravenous_contrast}}</li>
										
										<li><h4>Scout</h4>{{serie.scout}}</li>
										
										<li><h4>Scanning Mode</h4>{{serie.scanning_mode}}</li>
										
										<li><h4>Range/Direction</h4>{{serie.range_direction}}</li>
										
										<li><h4>Gantry Angle</h4>{{serie.gantry_angle}}</li>
										
										<li><h4>Algorithm</h4>{{serie.algorithm}}</li>
										
										<li><h4>Collimation</h4>{{serie.collimation}}</li>    
										
										<li><h4>Slice Thickness</h4>{{serie.slice_thickness}}</li>
										
										<li><h4>Interval</h4>{{serie.interval}}</li>
										
										<li><h4>Table Speed (mm/rotation)</h4>{{serie.table_speed}}</li>
										
										<li><h4>Pitch</h4>{{serie.pitch}}</li>  
										
										<li><h4>kVp</h4>{{serie.kvp}}</li>
										<li><h4>mA</h4>{{serie.ma}}</li>

<li><h4>Noise Index</h4>{{serie.noise_index}}</li>				
										<li><h4>Noise Reduction</h4>{{serie.noise_reduction}}</li>
										
										<li><h4>Rotation Time</h4>{{serie.rotation_time}}</li>
										
										<li><h4>Scan FOV</h4>{{serie.scan_fov}}</li>  
										
										<li><h4>Display FOV</h4>{{serie.display_fov}}</li>
										
										<li><h4>Post Processing</h4>{{serie.post_processing}}</li>
										
										<li><h4>Transfer Images</h4>{{serie.transfer_images}}</li>
										
										<li><h4>Notes</h4>{{serie.notes}}</li>  
									</ul>
									<ul class="nav series" ng-show="serie.show && detail_protocol_category[0]=='M'" >																				                                                                                                                                                                                                                                                                    
										<li><h4>Pulse Sequence</h4>{{serie.pulse_sequence}}</li>
										
										<li><h4>Plane</h4>{{serie.plane}}</li>
                                        										
										<li><h4>Imaging Mode</h4>{{serie.imaging_mode}}</li>
										
										<li><h4>Sequence Description</h4>{{serie.sequence_description}}</li>
										
										<li><h4>Fov</h4>{{serie.fov}}</li>
										
										<li><h4>Matrix 1.5t</h4>{{serie.matrix_15t}}</li>
										
										<li><h4>Matrix 3t</h4>{{serie.matrix_3t}}</li>
										
										<li><h4>Thk/Space</h4>{{serie.thk_space}}</li>
										
										<li><h4>Time</h4>{{serie.time}}</li>    										
									</ul>
                            <!-- /.nav-second-level -->
								</li>
							</ul>
					</div>
					<!--/.panel-body-->                   
                </div>
                <!-- /.col-lg-12 -->
			</div>
			
			<button class="btn btn-default" ng-click="panel.deleteprotocol()" type="button">
				DELETE PROTOCOL
            </button>
			<button class="btn btn-default" ng-click="panel.export_one_protocol()" type="button">
				EXPORT PROTOCOL
            </button>
			<p id='result'></p>
		</div>	
		
		
		<div class="row" ng-show="panel.isSelected('History')">
			<div class="row" style="margin-top:15px; margin-bottom:15px;">
                <div class="span5 col-md-5">
					<div class="input-daterange input-group" id="datepicker">
						<input id="datepicker_start" data-date-format="yyyy-mm-dd" ng-model="history_start" type="text" class="input-sm form-control" name="start" value="02/08/2015">
						<script>
						$("#datepicker_start").datepicker("setDate", new Date());
						</script>
						<span class="input-group-addon">to</span>
						<input id="datepicker_end" data-date-format="yyyy-mm-dd" ng-model="history_end" type="text" class="input-sm form-control" name="end" >
						<script>
						$("#datepicker_end").datepicker("setDate", new Date());
						</script>																	
					</div>					
				</div>
				<button class="btn btn-default"  type="button" ng-click="panel.showHistory()">Show History</button>
            </div>    
			
			<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            History of protocols
                        </div>
						<div class="form-group row" style="margin-top:15px;margin-left:15px;margin-bottom:-15px;">							
							<div >
								<div class="form-group row col-md-10" style="float:right;">
									<label class="col-md-1 control-label">Search:</label>
									<div class="col-md-3">
										<input ng-model="q" type="text" class="form-control" placeholder="Filter text">
									</div>
									
									<label class="col-md-2 control-label" >items per page:</label>
									<div class="col-md-2">
										<input type="number" min="1" max="100" type="text" class="form-control" ng-model="pageSize">
									</div>
									<button class="btn btn-default"  type="button" ng-click="panel.showAllHistory()">{{all_history_button}}</button>
								</div>
							</div>
						</div>
						
			
						<div class="panel-body">							
                            <div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="dataTables-history">
									<thead>
                                        <tr>
											<th>Status</th>
                                            <th>Protocol ID</th>
                                            <th>Protocol Name</th>
                                            <th>Created By</th>											                                          									
											<th>Created At</th>
										</tr>
									</thead>
									<tbody>										 																			
                                        <tr class="odd gradeX" dir-paginate="record in records | filter:q | itemsPerPage: pageSize" current-page="currentPage" >												
											<td>{{record.status}}</td>
                                            <td>{{record.protocol_number}}</td>											
                                            <td>{{record.protocol_name}}</td>
                                            <td>{{record.created_by}}</td>
											<td>{{record.created_at}}</td>                                                                                    							
                                        </tr>                                       
									</tbody>
								</table>								
							</div>							
						</div>
						              
						<div ng-controller="OtherController" >         
							<div class="text-center">
								<dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="dirPagination.tpl.html"></dir-pagination-controls>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
			
		</div>									
    </div>
    <!-- /#wrapper -->

	
	<div id="dialog" title="Alerts">
</body>

</html>
