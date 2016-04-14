
var map;
var infowindow;
var wineArray=[];
var canArray=[];
var barrelArray=[];
var wineCluster;
var canCluster;
var barrelCluster;
	
function initialize() {

	// Create an array of map styles.
	var styles = [
		{stylers: [{ hue: "#d5b152" },{ saturation: -40 }]},
		{featureType:"road", elementType:"geometry", stylers: [{lightness:50}, {visibility:"simplified"}]},
		{featureType:"all", elementType:"labels", stylers: [{visibility:"off"}]},
		{featureType:"water", elementType:"geometry", stylers: [{ hue:'#beb28a'},{ saturation: -40}]}
	];
	
	// Create a new StyledMapType object, passing it the array of styles,
	// as well as the name to be displayed on the map type control.
	var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});
	
	var mapOptions = {
		center:{ lat: 24.795382, lng: 120.994648},
		zoom: 7,
		mapTypeControlOptions: {
			mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
		},
		minZoom: 3,
		streetViewControl: 0
		//mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("mapCanvas"),mapOptions);
	
	//Associate the styled map with the MapTypeId and set it to display.
	map.mapTypes.set('map_style', styledMap);
	map.setMapTypeId('map_style');
	infowindow = new google.maps.InfoWindow();	//create only one infowindow so it automatically closed 
	showMarker();
	
	//infowindow = new google.maps.InfoWindow();	//create only one infowindow so it automatically closed 
	/*
	legend = document.getElementById('panel');
	legend.style.fontFamily = "'Rancho', cursive";
	legend.style.fontSize = '25px';
	map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(document.getElementById('panel'));
	*/
	
}


function showMarker(){
	var marker;
	var bottle;
	var content;
	var image;
	var mcOptions;
	bottle = jsonString;
	content = jsonConStr;
	
	for(var i = 0; i < bottle.length; i++){	/*有多少個bottle*/
		var isfollow = bottle[i].follow;
		if(isfollow == '1'){
			var msg = '<div id="content"><font>'+content[i].content+'</font><br>'+'<font>BY '+content[i].nickname+'</font><br>'+'<font>'+content[i].time+'</font></br>'+'<input class="btn" type="button" value="Check It!" onclick="showBox()"></input></div>';
		}else{
			var msg = ''; 
		}
		
		switch(bottle[i].btype) {
			//alert(bottle[i].btype);
			case '1':	//bottle of mood
				image = {
					url: './img/wine.png',
					size: new google.maps.Size(20, 44),
					origin: new google.maps.Point(0,0)
				};
				marker=new google.maps.Marker({
					position: new google.maps.LatLng(bottle[i].lat,bottle[i].lng),
					map: map,
					draggable: false,
					icon: image
				});
				
				var b = bottle[i].bid;
				
				//todo : add PICK UP BOTTLE CODE here !!!!!		bottle[i].bid
				google.maps.event.addListener(marker,'click', (function(marker,msg,isfollow,b){ 
					return function() {
						document.getElementsByName("bid")[0].value=b;
						if(isfollow == '1'){
							infowindow.setContent(msg);
							infowindow.open(map,marker);
						}else{ 
							showBox();
						}
					};
				})(marker,msg,isfollow,b));
				 
				wineArray.push(marker);
				break;
			case '2':	//bottle of story
				image = {
					url: './img/barrel.png',
					size: new google.maps.Size(20, 24),
					origin: new google.maps.Point(0,0)
				}; 
				marker=new google.maps.Marker({
					position: new google.maps.LatLng(bottle[i].lat,bottle[i].lng),
					map: map,
					draggable: false,
					icon: image
				});
				 
				var b = bottle[i].bid;
				//todo : add PICK UP BOTTLE CODE here !!!!!		bottle[i].bid
				google.maps.event.addListener(marker,'click', (function(marker,msg,isfollow,b){ 
					return function() {
						document.getElementsByName("bid")[0].value=b;
						if(isfollow == '1'){
							infowindow.setContent(msg);
							infowindow.open(map,marker);
						}else{ 
							showBox();
						}
					};
				})(marker,msg,isfollow,b));
				
				barrelArray.push(marker);
				break;
			case '3':	//bottle of trash
				image = {
					url: './img/can.png',
					size: new google.maps.Size(20, 38),
					origin: new google.maps.Point(0,0)
				};
				marker=new google.maps.Marker({
					position: new google.maps.LatLng(bottle[i].lat,bottle[i].lng),
					map: map,
					draggable: false,
					icon: image
				});
				
				var b = bottle[i].bid;
				//todo : add PICK UP BOTTLE CODE here !!!!!		bottle[i].bid
				google.maps.event.addListener(marker,'click', (function(marker,msg,isfollow,b){ 
					return function() {
						document.getElementsByName("bid")[0].value=b;
						if(isfollow == '1'){
							infowindow.setContent(msg);
							infowindow.open(map,marker);
						}else{ 
							showBox();
						}
					};
				})(marker,msg,isfollow,b));
				
				canArray.push(marker);
				break;
			default:
				alert("something wrong");
		}	
	}
	mcOptions = {gridSize: 50, maxZoom: 12, styles: [{ url: './img/wine.png', height: 44, width: 20, anchor: [1, 18], textColor: '#000000', textSize: 13}]};
	wineCluster = new MarkerClusterer(map, wineArray, mcOptions);
	
	mcOptions = {gridSize: 50, maxZoom: 12, styles: [{ url: './img/barrel.png', height: 24, width: 20, anchor: [1, 19], textColor: '#000000', textSize: 13}]};
	barrelCluster = new MarkerClusterer(map, barrelArray, mcOptions);
	
	mcOptions = {gridSize: 50, maxZoom: 12, styles: [{ url: './img/can.png', height: 38, width: 20, anchor: [1, 19], textColor: '#000000', textSize: 13}]};
	canCluster = new MarkerClusterer(map, canCluster, mcOptions);
}

function showBox(){
	document.getElementById("submitBox").style.visibility = "visible";
	document.getElementById("submitBox").style.display = "block";
}

function hideBox(){
	document.getElementById("submitBox").style.visibility = "hidden";
	document.getElementById("submitBox").style.display = "none";
}

function showHow(){
	document.getElementById("howBox").style.visibility = "visible";
	document.getElementById("howBox").style.display = "block";
}

function hideHow(){
	document.getElementById("howBox").style.visibility = "hidden";
	document.getElementById("howBox").style.display = "none";
}