import L from "leaflet";
const _map = L.map("map");
let currentLocate = [0, 0];

function setCurrentLocate() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(getCurrentPosition);
	} else {
		alert("Geolocalização não é suportada pelo seu navegador.");
		currentLocate = [0, 0];
	}
}

function getCurrentPosition(position) {
	const latitude = position.coords.latitude;
	const longitude = position.coords.longitude;
	currentLocate = [latitude, longitude];
	_map.setView(currentLocate, 13);
}

setCurrentLocate();

L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
	maxZoom: 19,
}).addTo(_map);
