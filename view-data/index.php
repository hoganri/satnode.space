<?php
    //If the HTTPS is not found to be "on"
    if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on") {
    //Tell the browser to redirect to the HTTPS URL.
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
    //Prevent the rest of the script from executing.
    exit;
    }
?>
<!doctype html>
<html lang="en">
  <head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-66668414-7"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-66668414-7');
	</script>
	    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Send Blockstream satellite transmissions and view transmission data.">    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Blockstream Satellite | View Satellite Data</title>
    <!-- Bootstrap core CSS -->
	<link href="https://getbootstrap.com/docs/4.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
 	<script type="text/javascript" src="../js/qr.min.js"></script>
	 

    <style>
	  .row{
		  margin-right:0;
		  margin-left:0;
	  }
  	  #pending th {
  	    padding-top: 15px;
  	    padding-bottom: 15px;
  	    background-color: rgba(153, 102, 255, 0.05);
  	    border: 1px solid rgba(153, 102, 255, 0.2);
  	  }
  	  #table .col{
  		  font-weight:600;
  	  }
        @media (min-width: 768px) {
          .bd-placeholder-img-lg {
            font-size: 3.5rem;
          }
        }
    </style>
    <!-- Custom styles for this template -->
  </head>
  <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
      <h3 class="my-0 mr-md-auto font-weight-normal"><a href="https://satnode.space">satnode.space</a></h3>
	  <nav class="my-2 my-md-0 mr-md-3">
		  <a class="p-2 text-dark" href="https://satnode.space">New Broadcast</a>
	  </nav>
	  <a class="btn btn-outline-primary" href="https://satnode.space/view-data">View Satellite Data</a>
  </div>
    <div class="container">
	  <h2>Sent Transmissions</h2>
      <noscript>This site runs entirely on JavaScript, you'll need to enable it for the site to work.</noscript>
	  <div class="row">
		<canvas id="sentChart" width="800px" height="180px"></canvas>
	  </div>
	  <br />
	  <h2>Pending Transmissions</h2>
	  <div class="row">
		  <table class="table table-hover" id="pending">
		      <thead>
		        <tr>
		          <th>Message Size (Bytes)</th>
		          <th>Bid per Byte (Millisatoshi)</th>
		          <th>Unpaid Bid (Millisatoshi)</th>
		        </tr>
		      </thead>
		      <tbody>
		      </tbody>
		    </table>
	  </div>
	  <br />
	  <div class="row">
	  	
	  </div>
  </div>
  <div class="container" id="table">
  </div>
  <br />
  
  <div class="container">
	  <p>
		  This site uses the <a href="https://blockstream.com/satellite-api-documentation/?utm_source=satnode_space">Blockstream Satellite API</a> and <a href="https://www.chartjs.org/?utm_source=satnode_space">Chart.js</a>
		  <br />
		  <a href="https://github.com/hoganri/satnode.space">Fork on Github</a>
		  <br />
		  Made by <a href="https://twitter.com/irnagoh?utm_source=satnode_space">@irnagoh</a>
	  </p>

	</div> <!-- /container -->
	<script src="../js/app.js"></script>
</html>
