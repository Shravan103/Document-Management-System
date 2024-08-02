<!DOCTYPE html>
<html>

<head>
  <!-- Include Leaflet CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <link rel="stylesheet" href="aboutFooter.css">
</head>

<body>
  <!-- FOOTER -->
  <div class="footer">
    <div class="footer-content">


      <!-- LEFT SECTION: PHONE AND EMAIL -->
      <div class="footer-section about">
        <h1 class="logo-text"><span>Doc</span>Stream</h1>
        <div class="contact">
          <p class="myText">For inquiries, please contact:</p>
          <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
            </svg> &nbsp;
            <a href="tel:+91123456789">+91123456789</a></span>
          <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
              <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z" />
            </svg> &nbsp;
            <a href="mailto:docstreamofficial@gmail.com">docstreamofficial@gmail.com</a></span>
            <p class="myText">Designed and Developed by DocStream Team, Committed to delivering excellence in every aspect of our work. If you have any questions or need support, don't hesitate to get in touch. Powered by HTML, CSS, JavaScript, Bootstrap, SQL & PHP.</p>
        </div>
      </div>


      <!-- GIS MAP SECTION -->
      <div class="footer-section links">
        <!-- Create a map container -->
        <div id="map" style="height: 300px; width:650px; border: 2px solid #303036; border-radius:5px; box-shadow: 0 0 10px black; position:relative; top: 18px;"></div>

        <!-- Include Leaflet JavaScript library -->
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

        <script>
          // Initialize a map
          var map = L.map('map').setView([15.4012550616, 73.8215633804], 13);

          // Add a tile layer (e.g., OpenStreetMap)
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
          }).addTo(map);

          // Add a marker to the map
          L.marker([15.4012550616, 73.8215633804]).addTo(map)
            .bindPopup("Find us at Goa Shipyard Limited, Vasco Da Gama.");
        </script>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>