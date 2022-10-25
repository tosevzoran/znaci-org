<script>
  const praviIkonicu = title => L.divIcon({
  className: '',
  html: `<div style="text-align:center">
      <span style="color:red;font-size:2em;display:inline-block;margin-bottom:-5px;">★</span><span style="white-space: nowrap;font-weight:bold;color:#fff">${title}</span>
    </div>`,
  iconSize: [30, 42],
  iconAnchor: [10, 20]
})

const praviMarker = data => {
  const url = '/odrednica.php?slug=' + data.slug;
  const slika_src = '/images/ustanak.jpg';

  const prozor = `<a href='${url}' target='_blank'>
    <h3>${data.naziv} u oslobodilačkom ratu</h3>
    <img src='${slika_src}' width='200'>
  </a>`

  return L
    .marker([data.lat, data.lon], { icon: praviIkonicu(data.naziv) })
    .bindPopup(prozor)
}

function postaviMapu(gradovi) {
  const jajce = [44.341667, 17.269444]
  const mostar = [43.333333, 17.8]
  const center = window.innerWidth < 768 ? mostar : jajce

  const konfigMape = {
    zoom: 8,
    minZoom: 6,
    maxZoom: 12,
    center,
    scrollWheelZoom: false,
    maxBounds: [
      [39, 10], // jug zapad
      [49, 26]  // sever istok
    ],
  }

  const mapa = L.map('mesto-za-mapu', konfigMape)

  L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
      attribution: 'Tiles &copy; Esri.'
  }).addTo(mapa)

  // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  //   attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  // }).addTo(mapa)

  const markeri = L.layerGroup().addTo(mapa)

  gradovi.forEach(grad => {
    markeri.addLayer(praviMarker(grad))
  })
}
</script>