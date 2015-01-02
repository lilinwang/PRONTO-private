<!DOCTYPE html>
<html lang="en" ng-app="store">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Radiology</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">
	<link rel="stylesheet" href="css/jquery-ui.css">
	
    <!-- Custom Fonts -->
    <link href="font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	 <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>	
	<!-- JQuery UI JavaScript-->	
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	
    <script type="text/javascript" src="js/bootstrap-filestyle.js"> </script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>	
	<script src="js/bootbox.min.js"></script>	
	
	<script type="text/javascript" src="js/angular.js"></script>
	<script type="text/javascript" src="js/protocol.js"></script>
	<script type="text/javascript">
	var opt={				
		height: 150,
        width: 250,
		autoOpen: false,		
	}
	function deleteprotocol(){
		bootbox.prompt("Password:", function(result) {                
		if (result === null) {                                             
			$('#result').html("Prompt dismissed!");                              
		} else {
			$.post("detailed_ajax/delete", 
			{								
				number:<?php echo $protocol_number;?>,
				password:result
            },function(data,status){	
				data = eval("(" + data + ")");				
				if (data===1){
					$('#result').html("Delete success!"); 
				}else{
					$('#result').html("Wrong password!");
				}
			});                         
		}
});
			

	}
	function upload(){						
		var file_data = $("#userfile").prop("files")[0];   		
		var fileName = $("#userfile").val();
		
		if(fileName.lastIndexOf("csv")===fileName.length-3){										
			$('#upload-icon').html('<i class="fa fa-spin fa-spinner"></i>');
			var form_data = new FormData();                  
			form_data.append("file", file_data);  
			//console.log($('input[name=optionsImport]:checked').val());
			//form_data.append("modality",$('input[name=optionsImport]:checked').val());
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
					$('#upload-icon').html('<i class="fa fa-upload"></i>');					
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

<body ng-controller="PanelController as panel" ng-init=<?php echo "init('".$protocol_number."')"?>>
	
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
                <a class="navbar-brand" href="index.html">Radiology</a>
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
					
            <!-- /.navbar-static-side -->
        </nav>
		
        <!-- Page Content -->
        <div id="page-wrapper" name="home" style="margin:0;">
							 
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
                            Protocol: <?php echo $protocol_number;?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
											<th>protocol ID</th>
                                            <th>protocol Name</th>
                                            <th>Code</th>
                                            <th>Description</th>
											<th>Modality</th>
                                            <th>General Body Part</th>
											<th>Body Part Code</th>
                                            <th>Detailed Body Part</th>
                                            <th>Approval_date</th>
                                            <th>Golive date</th>
                                            <th>Approved by</th>									
										</tr>
                                    </thead>
                                    <tbody>										 																			
                                        <tr class="odd gradeX" ng-repeat="protocol in protocols">										
											<td>		
												{{protocol.protocol_number}}
											</td>
                                            <td>{{protocol.protocol_name}}</td>											
                                            <td>{{protocol.code}}</td>
                                            <td>{{protocol.description}}</td>
											<td>{{protocol.modality}}</td>
                                            <td class="center">{{protocol.bodypart}}</td>
                                            <td class="center">{{protocol.bodypart_code}}</td>
											<td>{{protocol.bodypart_full}}</td>
                                            <td>{{protocol.approval_date}}</td>
                                            <td>{{protocol.golive_date}}</td>
											<td>{{protocol.approved_by}}</td>                                            									 
                                        </tr>                                       
                                    </tbody>
                                </table>
								 </div>
                            <!-- /.table-responsive -->                           
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
					<div class="panel panel-default">
                        <div class="panel-heading">
                            Series of Protocol <?php echo $protocol_number;?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
											<th>Series</th>
                                            <th>Indication</th>
                                            <th>Patient Orientation</th>
                                            <th>Landmark</th>
											<th>Intravenous Contrast</th>
                                            <th>Scout</th>
											<th>Scanning Mode</th>
                                            <th>Range/Direction</th>
                                            <th>Gantry Angle</th>
                                            <th>Algorithm</th>
                                            <th>Collimation</th>
											<th>Slice Thickness</th>
                                            <th>Interval</th>	
											<th>Table Speed (mm/rotation)</th>
                                            <th>Pitch</th>	
											<th>kVp</th>
                                            <th>mA</th>	
											<th>Rotation Time</th>
                                            <th>Scan FOV</th>
                                            <th>Display FOV</th>
                                            <th>Post Processing</th>
                                            <th>Transfer Images</th>
                                            <th>Notes</th>                                            										
										</tr>
                                    </thead>
                                    <tbody>										 																			
                                        <tr class="odd gradeX" ng-repeat="serie in series">										
											<td>{{serie.series_id}}</td>
                                            <td>{{serie.indication}}</td>											
                                            <td>{{serie.patient_orientation}}</td>
                                            <td>{{serie.landmark}}</td>
											<td>{{serie.intravenous_contrast}}</td>
                                            <td class="center">{{serie.scout}}</td>
                                            <td class="center">{{serie.scanning_mode}}</td>
											<td>{{serie.range_direction}}</td>
                                            <td>{{serie.gantry_angle}}</td>
                                            <td>{{serie.algorithm}}</td>
											<td>{{serie.collimation}}</td>    
											<td>{{serie.slice_thickness}}</td>
                                            <td>{{serie.interval}}</td>
                                            <td>{{serie.table_speed}}</td>
											<td>{{serie.pitch}}</td>  
											<td>{{serie.kvp}}</td>
                                            <td>{{serie.am}}</td>
                                            <td>{{serie.rotation_time}}</td>
											<td>{{serie.scan_fov}}</td>  
											<td>{{serie.display_fov}}</td>
                                            <td>{{serie.post_processing}}</td>
                                            <td>{{serie.transfer_images}}</td>
											<td>{{serie.notes}}</td>  											                                                                  								
                                        </tr>                                       
                                    </tbody>
                                </table>
								
                            </div>
                            <!-- /.table-responsive -->                           
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
			</div>
			
			<button class="btn btn-default" onclick="deleteprotocol()" type="button">
				Delete whole protocol
            </button>
			<p id='result'></p>
		</div>				
    </div>
    <!-- /#wrapper -->	
	<div id="dialog" title="Alerts">
</body>

</html>
