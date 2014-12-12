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

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
		
	<script type="text/javascript">
    $(function() {
// login & sign-up tab
        $("#get-list").click(function(){
			$.post("ajax/get_list", 
			{		
				user_id:<?php echo $this->session->userdata('user_id');?>
            },
			function(data,status){				
				data = eval("(" + data + ")");				
				//console.log(data);
				var innerHTML="<ul>";
				for (var i=0;i<data.length;i++){
					innerHTML+="<div class=\"thumbnail\">";
					innerHTML+="<img src=\""+data[i].thumbimg_dir+"\">";
					innerHTML+="<div class=\"caption\"><h4>"+data[i].description+"</h4></div>"
					innerHTML+="<p>"+data[i].dining_time;
					if (data[i].restaurant_name!="") innerHTML+=" @ "+data[i].restaurant_name;
					innerHTML+="</p></div>	<hr />";
				}
				innerHTML+="</ul>";
				document.getElementById("list").innerHTML = innerHTML;	
				//data.metadata.image_path_prefix+data.data.relationships.primary_image.items[0].path
				//var innerHTML="<a class=\"pull-left\" href=\"#\"> <img src=\""+data.metadata.image_path_prefix+data.data.relationships.primary_image.items[0].path+"\" class=\"media-object\" onclick=\"get_metrics(this)\" width=100px> </a>";			
				//innerHTML+="<h4 class=\"media-heading\">"+document.getElementById("company_name").value+"</h4>";
				//document.getElementById("focus").innerHTML += innerHTML;		   
			});
			$("#home").show();
			$("#add-protocal").hide();
			$("#import").hide();
			$("#search").hide();
			$("#api").hide();
		});		
		$("#get-home").click(function(){
            $("#home").show();
			$("#add-protocal").hide();
			$("#import").hide();
			$("#search").hide();
			$("#api").hide();
        });
        $("#get-add-protocal").click(function(){
            $("#home").show();
			$("#add-protocal").hide();
			$("#import").hide();
			$("#search").hide();
			$("#api").hide();
        });
		$("#get-import").click(function(){
            $("#home").show();
			$("#add-protocal").hide();
			$("#import").hide();
			$("#search").hide();
			$("#api").hide();
        });
		$("#get-search").click(function(){
            $("#home").show();
			$("#add-protocal").hide();
			$("#import").hide();
			$("#search").hide();
			$("#api").hide();
        });
		$("#get-api").click(function(){
            $("#home").show();
			$("#add-protocal").hide();
			$("#import").hide();
			$("#search").hide();
			$("#api").hide();
        });
		$("#get-home").trigger("click");
	});
	</script>
</head>

<body ng-controller="PanelController as panel">
	
    <div id="wrapper" ng-controller="">

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
						<li ng-class="{ active: panel.isSelected(1)}"> <a href ng-click="panel.select(1)">Home</a> </li>
						<li ng-class="{ active: panel.isSelected(2)}"> <a href ng-click="panel.select(2)">Add Protocal</a> </li>
						<li ng-class="{ active: panel.isSelected(3)}"> <a href ng-click="panel.select(3)">Import</a> </li>
						<li ng-class="{ active: panel.isSelected(4)}"> <a href ng-click="panel.select(4)">Advanced Search</a> </li>
						<li ng-class="{ active: panel.isSelected(5)}"> <a href ng-click="panel.select(5)">API</a> </li>
			</ul>
			<!--<ul class="nav navbar-top-links navbar-left">   												
							<li><a id="get-home" href="#">Home</a></li>
							<li><a id="get-add-protocal" href="#">Add Protocal</a></li>
							<li><a id="get-import" href="#">Import</a></li>							
							<li><a id="get-search" href="#">Advanced Search</a></li>
							<li><a id="get-api" href="#">API</a></li>							
						
			</ul>
			-->
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
							<h4 class="navbar-brand">Protocals</h4>
						</li>
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Neuro CT<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">head</a>
                                </li>
                                <li>
                                    <a href="#">neck</a>
                                </li>
                                <li>
                                    <a href="notifications.html"> Cervical Spine</a>
                                </li>
                                <li>
                                    <a href="#">Thoracic Spine</a>
                                </li>
                                <li>
                                    <a href="#">Lumbar Spine</a>
                                </li>
								<li>
                                    <a href="#">Lumbar Spinal Cord</a>
                                </li>
								<li>
                                    <a href="#">Brachial Plexus</a>
                                </li>
								<li>
                                    <a href="#">Facial Bones</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Musculoskeletal CT<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Ankle</a>
                                </li>
                                <li>
                                    <a href="#">Foot</a>
                                </li>
                                <li>
                                    <a href="notifications.html">Shoulder</a>
                                </li>
                                <li>
                                    <a href="#">Wrist</a>
                                </li>
                                <li>
                                    <a href="#">Hand</a>
                                </li>
								<li>
                                    <a href="#">Pelvis</a>
                                </li>
								<li>
                                    <a href="#">Hip</a>
                                </li>
								<li>
                                    <a href="#">Knee</a>
                                </li>
								<li>
                                    <a href="#">Variable</a>
                                </li>								
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						<li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Body CT<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Abdomen/Pelvis</a>
                                </li>
                                <li>
                                    <a href="#">Others</a>
                                </li>                                	
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						<li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Cardiac CT<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Heart</a>
                                </li>                                                          
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						<li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Body MR</a>                            
                        </li>
						<li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Neuro MR<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Head</a>
                                </li>                                                          
								<li>
                                    <a href="#">Neck</a>
                                </li> 
								<li>
                                    <a href="notifications.html"> Cervical Spine</a>
                                </li>
                                <li>
                                    <a href="#">Thoracic Spine</a>
                                </li>
                                <li>
                                    <a href="#">Lumbar Spine</a>
                                </li>
								<li>
                                    <a href="#">CTL Spine</a>
                                </li> 
								<li>
                                    <a href="#">Variable</a>
                                </li> 
								<li>
                                    <a href="#">others</a>
                                </li> 
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li class="active">
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="active" href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper" name="home">
			<div ng-show="panel.isSelected(1)">				 
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
			
			<div ng-show="panel.isSelected(2)">
			<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add a protocal</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div> 
			<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Protocal
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" name="protocalForm" ng-controller="ProtocalController as protocalCtrl" ng-submit="addProtocal()" novalidate>
                                        <div class="form-group">
                                            <label>Protocal Name</label>
                                            <input class="form-control" placeholder="Enter text" ng-model="cred.protocal_name" required>
                                            <p class="help-block">Example block-level help text here.</p>
                                        </div>                                                                              
                                        <div class="form-group">
                                            <label>Code</label>
                                            <input class="form-control" placeholder="Enter text" ng-model="cred.code">
                                            <p class="help-block">Example block-level help text here.</p>
                                        </div> 
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" rows="3" ng-model="cred.description"></textarea>
                                        </div>
                                                                                
                                        <div class="form-group">
                                            <label>Modality</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline1" value="CT" checked ng-model="cred.modality">CT
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline2" value="MR" ng-model="cred.modality">MR
                                            </label>                                            
                                        </div>
										<div class="form-group">
                                            <label>General Body Part</label>
                                            <input class="form-control" placeholder="Enter text" ng-model="cred.bodypart">
                                            <p class="help-block">Example block-level help text here.</p>
                                        </div> 
                                        <div class="form-group">
                                            <label>Select Detailed Body Part</label>
                                            <select class="form-control" ng-model="cred.bodypart_full">
												<option>Abdomen/Pelvis</option>
												<option>Ankle</option>
                                                <option>Brachial Plexus</option>											
                                                <option>Cervical Spine</option>
												<option>CTL Spine</option>
												<option>Facial Bones</option>                                                
												<option>Foot</option>												
                                                <option>Hand</option>																							
                                                <option>Head</option>
												<option>Heart</option>												
                                                <option>Hip</option>
												<option>Neck</option>                                               
                                                <option>Knee</option>
												<option>Lumbar Spine</option>
												<option>Lumbar Spinal Cord</option>                                                
												<option>Others</option>
												<option>Pelvis</option>   
												<option>Shoulder</option>
												<option>Thoracic Spine</option>
												<option>Variable</option>
												<option>Wrist</option>                                               												
                                            </select>
                                        </div>  
										<div class="form-group">
                                            <label>Approval Date</label>
                                            <input type="date" class="form-control" placeholder="YYYY-MM-DD" ng-model="cred.approval_date">
                                            <p class="help-block">Example block-level help text here.</p>
                                        </div> 										
										<div class="form-group">
                                            <label>Go live Date</label>
                                            <input type="date" class="form-control" placeholder="YYYY-MM-DD" ng-model="cred.golive_date">
                                            <p class="help-block">Example block-level help text here.</p>
                                        </div> 
										<div class="form-group">
                                            <label>Approved By (Person)</label>
                                            <input class="form-control" placeholder="Full Name" ng-model="cred.approved_by">
                                            <p class="help-block">Example block-level help text here.</p>
                                        </div> 
										<div class="form-group">
                                            <label>Series</label>
                                            <textarea class="form-control" rows="3" ng-model="cred.series"></textarea>
                                        </div>
										<div class="form-group">
                                            <label>Scan Position</label>
                                            <input class="form-control" placeholder="Enter text" ng-model="cred.scan_position">
                                            <p class="help-block">Example block-level help text here.</p>
                                        </div>
										<div class="form-group">
                                            <label>Notes</label>
                                            <textarea class="form-control" rows="3" ng-model="cred.notes"></textarea>
                                        </div>										
                                        <button type="submit" class="btn btn-default" ng-disabled="!protocalForm.$valid">Submit Button</button>
                                        <button type="reset" class="btn btn-default">Reset Button</button>
                                    </form>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
				<h1>{{product.name}}</h1>
				<h2>{{product.price|currency}}</h2>
				<button ng-show="product.canPurchase">Purchase</button>
				<blockquote ng-repeat="review in product.reviews">
				<b>Stars: {{review.stars}}</b>
				{{review.body}}
				<cite>by: {{review.author}}</cite>
				</blockquote>
 
		<!-- 	<div class="row" ng-controller="StoreController as store">
				<product-panels>
				</product-panels>			
			</div>
			-->
			</div>
        <!-- /#page-wrapper -->
			<div ng-show="panel.isSelected(6)">				 
			<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Protocal</h1>
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
    </div>
    <!-- /#wrapper -->

	<script type="text/javascript" src="js/angular.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
	
</body>

</html>
