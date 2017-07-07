<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
	  <!-- BOOTSTRAP STYLES-->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <!-- <link href="{{ asset('js/morris/morris-0.4.3.min.css') }}" rel="stylesheet" /> -->
    <link href="{{ asset('js/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet" />

</head>
<body>
    <div class="container-fluid">
      <!-- {{ bcrypt('munar123') }} -->
        <div class="row text-center upper-login">
            <div class="col-md-12">
                <br /><br />
                <h1 class="judul-login"> Bengkel </h1>
               
                <!-- <h5>( Login yourself to get access )</h5> -->
                 <br />
            </div>
        </div>
         <div class="row ">
               
                  <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                        <strong>   Silakan Masukan Username Dan Password </strong>  
                            </div>
                            <div class="panel-body">
                                <form role="form">
                                       <br />
                                     <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                            <input type="text" class="form-control" placeholder="Username " />
                                     </div>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input type="password" class="form-control"  placeholder="Password" />
                                        </div>
                                    <div class="form-group">
                                    </div>
                                     <div class="row text-center ">
                                    </div>    
                                     <a href="index.php" class="btn btn-primary btn-block">Login</a> 
                                </form>
                            </div>
                           
                        </div>
                    </div>
                          
        </div>
    </div>


     <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
   
</body>
</html>
