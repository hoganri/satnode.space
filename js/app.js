if (document.getElementById('payBroadcast')){
	payBroadcast = document.getElementById('payBroadcast');
	payBroadcast.addEventListener('click', function() {
		sendBroadcast();
	});
	clipboardCopy = document.getElementById('copyInvoice');
	clipboardCopy.addEventListener('click', function() {
		text = document.getElementById('paymentInvoice');
		text.select();
		document.execCommand("copy");
	});
}

if (document.URL.search('/view-data')) {
	getSent();
	getPending();
}

// Functions

// Send a new broadcast
function sendBroadcast() {	
	document.getElementById('qrcode').innerText='';
	document.getElementById('paymentResponse').style.display="none";
	document.getElementById('responseRow').style.display="none";
	
	message = document.getElementById('userMessage').value;
	bid = document.getElementById('bid').value;
	if (message == null || message == '' || bid == '' || bid == null) {
		return false;
	}
	url = "https://api.blockstream.space/order?bid="+bid+"&message="+message;
	console.log(url);
	var transmission = new XMLHttpRequest();
	transmission.open('POST', url);
	transmission.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
	transmission.onload = function() {
		renderData(JSON.parse(transmission.responseText));
	}
	transmission.send();
	
	document.getElementById('paymentResponse').style.display="block";
	document.getElementById('responseRow').style.display="block";
}
// Render HTML on homepage
function renderData(data){
	document.getElementById('paymentInvoice').innerText=data['lightning_invoice']['payreq'];
	jQuery('#qrcode').qrcode(data['lightning_invoice']['payreq']);
	document.getElementById('responseData').value=JSON.stringify(data);
	document.getElementById('status').innerText=data['lightning_invoice']['status'];
	document.getElementById('auth_token').innerText=data['auth_token'];
	document.getElementById('uuid').innerText=data['uuid'];
	document.getElementById('id').innerText=data['lightning_invoice']['id'];
	document.getElementById('msatoshi').innerText=data['lightning_invoice']['msatoshi'];
	document.getElementById('rhash').innerText=data['lightning_invoice']['rhash'];
	document.getElementById('payreq').innerText=data['lightning_invoice']['payreq'];
	document.getElementById('expires_at').innerText=data['lightning_invoice']['expires_at'];
	document.getElementById('created_at').innerText=data['lightning_invoice']['created_at'];
	document.getElementById('sha256_message').innerText=data['lightning_invoice']['metadata']['sha256_message_digest'];
}

// Get sent orders
function getSent() {
	url = 'https://api.blockstream.space/orders/sent';
	var transmission = new XMLHttpRequest();
	transmission.open('GET', url);
	transmission.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
	transmission.onload = function() {
		renderSent(JSON.parse(transmission.responseText));
	}
	transmission.send();
}
// Render sent info
function renderSent(data){
	var bidPerByte = [];
	var messageSize = [];
	var txSeq = [];
	for (var i in data){
		bidPerByte.push(data[i]['bid_per_byte']);
		messageSize.push(data[i]['message_size']);
		txSeq.push(data[i]['tx_seq_num']);
	}
	startChart(bidPerByte, messageSize, txSeq);
}

// Get pending orders
function getPending() {
	url = 'https://api.blockstream.space/orders/pending';
	var transmission = new XMLHttpRequest();
	transmission.open('GET', url);
	transmission.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
	transmission.onload = function() {
		renderPending(JSON.parse(transmission.responseText));
	}
	transmission.send();
}
// Render pending info
function renderPending(data){
	var messageSize = [];
	var bidPerByte = [];
	var unpaid = [];
	for (var i in data){
		messageSize.push(data[i]['message_size']);
		unpaid.push(data[i]['unpaid_bid']);
		bidByte = parseInt(data[i]['unpaid_bid'])/parseInt(data[i]['message_size']);
		bidPerByte.push(bidByte.toFixed(0));
	}
	console.log(bidPerByte);
	htmlString = '';
	var x = 0;
	while (x < unpaid.length) {
		htmlString += "<tr>";
		htmlString += "<td>"+messageSize[x]+"</td>";
		htmlString += "<td>"+bidPerByte[x]+"</td>";
		htmlString += "<td>"+unpaid[x]+"</td>";
		htmlString += "</tr>";
		x+=1;
	}
	document.getElementById('pending').insertAdjacentHTML('beforeend', htmlString);
}

// Display data in the chart
function startChart(bid, size, tx){
	var ctx = document.getElementById('sentChart').getContext('2d');
	var myChart = new Chart(ctx, {
		type: 'bar',
	    data: {
	        datasets: [{
	            label: 'Bid per Byte',
	            data: bid.reverse(),
				backgroundColor: 'rgba(75, 192, 192, 0.2)',
				borderColor: 'rgba(75, 192, 192, 0.2)',
				pointBackgroundColor: 'rgba(75, 192, 192, 0.2)',
				type: 'line',
				fill: false,
				yAxisID: 'left-y-axis'
	        },{
	        	label: 'Message Size',
				data: size.reverse(),
				backgroundColor: 'rgba(255, 99, 132, 0.2)',
				yAxisID: 'right-y-axis'
	        }],
	        labels: tx.reverse(),
	    },
	    options: {
	        scales: {
	            yAxes: [{
	                id: 'left-y-axis',
	                type: 'linear',
	                position: 'left',
	                gridLines: {
                        display:false
                    }
	            }, {
	                id: 'right-y-axis',
	                type: 'linear',
	                position: 'right',
	                gridLines: {
                        display:false
                    }
	            }],
	        },
	    }
	});
}