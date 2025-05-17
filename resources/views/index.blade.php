<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>🌸 Sensor Dashboard</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

  <style>
    body { font-family: 'Poppins', sans-serif; background: #fdf6f0; }
    .navbar { background: linear-gradient(90deg, #f6d365 0%, #fda085 100%); }
    .sensor-card { border-radius: 1rem; border: none; background: #fff8f0;
      transition: transform 0.3s, box-shadow 0.3s; }
    .sensor-card:hover { transform: translateY(-5px);
      box-shadow: 0 12px 25px rgba(0,0,0,0.08); background-color: #fff3ea; }
    .sensor-card h5 { font-weight: 600; color: #ff7e5f; }
    .back-button { color: #ff7e5f; font-weight: 600; cursor: pointer;
      transition: color 0.3s; }
    .back-button:hover { color: #eb5757; }
    .table { border-radius: 0.75rem; overflow: hidden; }
    canvas { background: #fff; border-radius: 1rem; padding: 1rem; }
    .metrics { font-style: italic; color: #888; font-size: 0.9rem; }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light mb-5 shadow-sm">
    <div class="container">
      <span class="navbar-brand fw-bold text-white">🌼 Sensor Dashboard</span>
    </div>
  </nav>

  <!-- Main Graph + Pagination -->
  <div class="container mb-5">
    <h3 class="fw-bold mb-4 text-secondary">📊 All Sensors Combined</h3>
    <canvas id="mainChart" class="mb-3 shadow-sm"></canvas>
    <div id="paginationControls" class="d-flex justify-content-center my-3"></div>
  </div>

  <!-- Preview Cards -->
  <div class="container mb-5">
    <div class="row g-4">
      <div class="col-md-3">
        <div class="card sensor-card text-center p-4" onclick="showSensor('light')">
          <h5>🌞 Light Sensor</h5>
          <p class="metrics">Units: Lux</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card sensor-card text-center p-4" onclick="showSensor('sound')">
          <h5>🔊 Sound Sensor</h5>
          <p class="metrics">Units: dB (Decibels)</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card sensor-card text-center p-4" onclick="showSensor('humidity')">
          <h5>💧 Humidity & Temp</h5>
          <p class="metrics">Units: Humidity (%), Temperature (°C)</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card sensor-card text-center p-4" onclick="showSensor('air')">
          <h5>🍃 Air Quality</h5>
          <p class="metrics">Units: CO₂ (ppm)</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Sensor Details -->
  <div id="sensorDetails" class="container mt-5 d-none">
    <div class="mb-4">
      <span class="back-button" onclick="hideSensor()">&larr; Back to Dashboard</span>
    </div>
    <h3 id="sensorTitle" class="fw-bold mb-4 text-secondary"></h3>
    <canvas id="sensorChart" class="mb-5 shadow-sm"></canvas>
    <div class="table-responsive">
      <table class="table table-bordered table-hover bg-white shadow-sm">
        <thead class="table-warning">
          <tr id="tableHeader"></tr>
        </thead>
        <tbody id="tableBody"></tbody>
      </table>
    </div>
  </div>

  <script>
    let sensorData = [], pagination = {}, currentPage = 1;

    // Initial fetch
    fetchSensorData();

    function fetchSensorData(page = 1) {
      fetch(`/api/sensor?page=${page}`)
        .then(res => res.json())
        .then(json => {
          sensorData  = json.data;
          pagination  = json;
          currentPage = json.current_page;
          showMainGraph();
          renderPaginationControls();
        })
        .catch(err => console.error('Fetch error:', err));
    }

    function renderPaginationControls() {
      const prevDisabled = !pagination.prev_page_url ? 'disabled' : '';
      const nextDisabled = !pagination.next_page_url ? 'disabled' : '';

      document.getElementById('paginationControls').innerHTML = `
        <button class="btn btn-outline-primary me-2" ${prevDisabled}
                onclick="fetchSensorData(${currentPage - 1})">← Previous</button>
        <span class="align-self-center">Page ${currentPage} of ${pagination.last_page}</span>
        <button class="btn btn-outline-primary ms-2" ${nextDisabled}
                onclick="fetchSensorData(${currentPage + 1})">Next →</button>
      `;
    }

    const formatDate = dateString => {
      const date = new Date(dateString);
      const hours = date.getHours();
      const minutes = String(date.getMinutes()).padStart(2, '0');
      const ampm = hours >= 12 ? 'PM' : 'AM';
      const h12 = hours % 12 || 12;
      return `${date.getMonth()+1}/${date.getDate()}/${date.getFullYear()} ${h12}:${minutes} ${ampm}`;
    };

    function showMainGraph() {
      const labels = sensorData.map(r => formatDate(r.created_at));
      const datasets = [
        { label:'Light (Lux)',    data: sensorData.map(r=>r.light) },
        { label:'Sound (dB)',     data: sensorData.map(r=>r.sound) },
        { label:'Temp (°C)',      data: sensorData.map(r=>r.temperature) },
        { label:'Air (CO₂ ppm)',  data: sensorData.map(r=>r.air_quality) },
      ].map(ds => ({
        ...ds,
        borderWidth:2, fill:true,
        backgroundColor: 'rgba(200,200,200,0.4)',
        borderColor:       'rgba(100,100,100,1)'
      }));

      const ctx = document.getElementById('mainChart').getContext('2d');
      if (window.mainChartInstance) window.mainChartInstance.destroy();
      window.mainChartInstance = new Chart(ctx, {
        type:'line',
        data:{ labels, datasets },
        options:{
          responsive:true,
          plugins:{ legend:{ labels:{ color:'#555' } } },
          scales:{ x:{ ticks:{ color:'#666' } }, y:{ beginAtZero:true, ticks:{ color:'#666' } } }
        }
      });
    }

    function showSensor(type) {
      document.getElementById('sensorDetails').classList.remove('d-none');
      const maps = {
        light:    ['🌞 Light Sensor','Units: Lux','Light Intensity'],
        sound:    ['🔊 Sound Sensor','Units: dB','Sound Level'],
        humidity: ['💧 Humidity & Temp','Units: °C','Temperature'],
        air:      ['🍃 Air Quality','Units: ppm','CO₂']
      };
      const [title, unit, colLabel] = maps[type];
      document.getElementById('sensorTitle').textContent = `${title} — ${unit}`;
      document.getElementById('tableHeader').innerHTML =
        `<th>${colLabel}</th><th>Status</th><th>Time</th>`;

      document.getElementById('tableBody').innerHTML =
        sensorData.map(r => {
          const val = ({ light:r.light, sound:r.sound,
                         humidity:r.temperature, air:r.air_quality })[type];
          const status = r.system_on? 'Active':'Inactive';
          return `<tr><td>${val}</td><td>${status}</td><td>${formatDate(r.created_at)}</td></tr>`;
        }).join('');

      // chart
      const vals = sensorData.map(r =>
        ({ light:r.light, sound:r.sound,
           humidity:r.temperature, air:r.air_quality })[type]
      );
      const ctx = document.getElementById('sensorChart').getContext('2d');
      if (window.sensorChartInstance) window.sensorChartInstance.destroy();
      window.sensorChartInstance = new Chart(ctx, {
        type:'line',
        data:{
          labels: sensorData.map(r=>formatDate(r.created_at)),
          datasets:[{
            label: colLabel,
            data: vals,
            borderWidth:2, fill:true,
            backgroundColor:'rgba(200,200,200,0.4)',
            borderColor: 'rgba(100,100,100,1)'
          }]
        },
        options:{
          responsive:true,
          plugins:{ legend:{ labels:{ color:'#555' } } },
          scales:{ x:{ ticks:{ color:'#666' } }, y:{ beginAtZero:true, ticks:{ color:'#666' } } }
        }
      });
    }

    function hideSensor() {
      document.getElementById('sensorDetails').classList.add('d-none');
    }

    // auto‐refresh every 60s
    setInterval(()=> fetchSensorData(currentPage), 60000);
  </script>
</body>
</html>
