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
    <meta name="description" content="Send Blockstream satellite transmissions and view transmission data.">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Blockstream Satellite | Send Broadcast</title>
    <!-- Bootstrap core CSS -->
	<link href="https://getbootstrap.com/docs/4.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
 	<script type="text/javascript" src="js/qr.min.js"></script>
	 

    <style>
		.row{
			margin-right:0;
			margin-left:0;
		}
		#errorRow, #paymentResponse, #responseRow{
			display:none;
		}
		#paymentResponse{
			text-align:center;
		}
		#paymentInvoice{
			word-wrap:anywhere;
		}
		#paymentResponse .col-sm-4{
			display:inline-block;
			vertical-align:top;
		}
		.table td{
			word-wrap:anywhere;
		}
		#bid, #userMessage{
			margin-bottom:20px;
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
      <noscript>This site runs entirely on JavaScript, you'll need to enable it for the site to work.</noscript>
	  <div class="row">
		  <h3>New Broadcast</h3>
		  <form style="width:100%" onsubmit="return false">
		  	<textarea id="userMessage" class="form-control" rows="5" placeholder="Enter a message and send it to space" required=""></textarea>
			<p id="recBid"></p>
		  	<input type="number" class="form-control" id="bid" placeholder="Bid amount in millisatoshi" required="">
		  	<button id="payBroadcast" class="btn btn-primary">Pay Broadcast</button>
		</form>
	  </div>
	  <br />
	  <div class="row alert alert-danger" id="errorRow"></div>
	  <div class="row" id="paymentResponse">
		  <div class="alert alert-success" style="text-align:left;">
		  	<strong>Success!</strong> Order details below...
		  </div>
		  <h2>Pay with Lightning</h2><br />
		  <div class="col-sm-4">
		  	<p id="qrcode"></p>
		  </div>
		  <div class="col-sm-4">
		  	<textarea class="form-control" rows="8" id="paymentInvoice"></textarea>
			<br />
			<button id="copyInvoice" class="btn btn-info">Click to Copy</button>
		  </div>
	  </div>
	  <br />
	  <div class="row" id="responseRow">
		  <h4>Response</h4>
		  <table class="table table-hover">
			  <tr>
				  <td>status</td>
				  <td id="status">
				  </td>
			  </tr>
			  
			  <tr>
				  <td>auth token</td>
				  <td id="auth_token"></td>
			  </tr>
			  <tr>
				  <td>uuid</td>
				  <td id="uuid">
				  </td>
			  </tr>
			  <tr>
				  <td>id</td>
				  <td id="id">
				  </td>
			  </tr>
			  <tr>
				  <td>msatoshi</td>
				  <td id="msatoshi">
				  </td>
			  </tr>
			  <tr>
				  <td>rhash</td>
				  <td id="rhash">
				  </td>
			  </tr>
			  <tr>
				  <td>payreq</td>
				  <td id="payreq">
				  </td>
			  </tr>
			  <tr>
				  <td>expires at</td>
				  <td id="expires_at">
				  </td>
			  </tr>
			  <tr>
				  <td>created at</td>
				  <td id="created_at">
				  </td>
			  </tr>
			  <tr>
				  <td>sha256 message digest</td>
				  <td id="sha256_message">
				  </td>
			  </tr>
		  </table>
		  <h3>Raw JSON</h3>
		  <textarea id="responseData" class="form-control" rows="5"></textarea>
	  </div>
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
	<script src="js/app.js"></script>
</html>
