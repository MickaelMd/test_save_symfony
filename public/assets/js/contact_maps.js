let map;
let marker = [];
let mapOptions = {
  scrollWheelZoom: false,
};

const id = "OSM-map";

const centerLatLng = [49.928640638465176, 2.273311614990235];
map = L.map(id, mapOptions).setView(centerLatLng, 20);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution: "",
}).addTo(map);

marker = L.marker(L.latLng(49.928640638465176, 2.273311614990235), {
  title: "The District",
});

marker.addTo(map);
marker.bindPopup(`
  <div style="text-align: center; ">
    <h3 style="margin: 0; color: #3b5998;">The District</h3>
    <p>30 Rue de Poulainville, 80000 Amiens</p>
    <img 
      src="/assets/img/the_district_brand/logo_svg.svg" 
      alt="The District" 
      style="border-radius: 8px; margin: 10px 0; width: 60px; height: auto;"
    />
  </div>
`);
