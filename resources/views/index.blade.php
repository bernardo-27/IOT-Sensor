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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">


  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #fdf6f0;
    }
    .navbar {
      background: linear-gradient(90deg, #f6d365 0%, #fda085 100%);
    }
    .sensor-card {
      border-radius: 1rem;
      border: none;
      background: #fff8f0;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .sensor-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
      background-color: #fff3ea;
    }
    .sensor-card h5 {
      font-weight: 600;
      color: #ff7e5f;
    }
    .back-button {
      color: #ff7e5f;
      font-weight: 600;
      cursor: pointer;
      transition: color 0.3s ease;
    }
    .back-button:hover {
      color: #eb5757;
    }
    .table {
      border-radius: 0.75rem;
      overflow: hidden;
    }
    canvas {
      background: #fff;
      border-radius: 1rem;
      padding: 1rem;
    }
    .metrics {
      font-style: italic;
      color: #888;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light mb-5 shadow-sm">
    <div class="container">
      <span class="navbar-brand fw-bold text-white">🌼 Sensor Dashboard</span>
    </div>
  </nav>

  <!-- Main Graph -->
  <div class="container mb-5">
    <h3 class="fw-bold mb-4 text-secondary">📊 All Sensors Combined</h3>
    <canvas id="mainChart" class="mb-5 shadow-sm"></canvas>
  </div>

  <!-- Preview Cards -->
  <div class="container">
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
    let sensorData = [];

    fetchSensorData();

    function fetchSensorData() {
      fetch('/api/sensor')
        .then(res => res.json())
        .then(data => {
          sensorData = data;
          showMainGraph();
        })
        .catch(err => console.error('Fetch error:', err));
    }

    const formatDate = dateString => {
      const date = new Date(dateString);
      const hours = date.getHours();
      const minutes = String(date.getMinutes()).padStart(2, '0');
      const ampm = hours >= 12 ? 'PM' : 'AM';
      const formattedHours = hours % 12 || 12;
      return `${date.getMonth() + 1}/${date.getDate()}/${date.getFullYear()} ${formattedHours}:${minutes} ${ampm}`;
    };

    function showMainGraph() {
      const labels = sensorData.map(record => formatDate(record.created_at));
      const lightData = sensorData.map(record => record.light);
      const soundData = sensorData.map(record => record.sound);
      const temperatureData = sensorData.map(record => record.temperature);
      const airQualityData = sensorData.map(record => record.air_quality);

      const ctx = document.getElementById('mainChart').getContext('2d');
      if (window.mainChartInstance) window.mainChartInstance.destroy();

      window.mainChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [
            {
              label: 'Light Intensity (Lux)',
              data: lightData,
              backgroundColor: 'rgba(255, 182, 193, 0.4)',
              borderColor: 'rgba(255, 105, 180, 1)',
              borderWidth: 2,
              fill: true
            },
            {
              label: 'Sound Level (dB)',
              data: soundData,
              backgroundColor: 'rgba(173, 216, 230, 0.4)',
              borderColor: 'rgba(100, 149, 237, 1)',
              borderWidth: 2,
              fill: true
            },
            {
              label: 'Temperature (°C)',
              data: temperatureData,
              backgroundColor: 'rgba(144, 238, 144, 0.4)',
              borderColor: 'rgba(34, 139, 34, 1)',
              borderWidth: 2,
              fill: true
            },
            {
              label: 'Air Quality (CO₂ ppm)',
              data: airQualityData,
              backgroundColor: 'rgba(255, 228, 196, 0.4)',
              borderColor: 'rgba(255, 140, 0, 1)',
              borderWidth: 2,
              fill: true
            }
          ]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { labels: { color: '#555' } }
          },
          scales: {
            y: { beginAtZero: true, ticks: { color: '#666' } },
            x: { ticks: { color: '#666' } }
          }
        }
      });
    }

    function showSensor(type) {
      document.getElementById('sensorDetails').classList.remove('d-none');

      const titleMap = {
        light: '🌞 Light Sensor',
        sound: '🔊 Sound Sensor',
        humidity: '💧 Humidity & Temperature Sensor',
        air: '🍃 Air Quality Sensor'
      };

      const unitMap = {
        light: 'Units: Lux',
        sound: 'Units: dB (Decibels)',
        humidity: 'Units: Temperature (°C)',
        air: 'Units: CO₂ (ppm)'
      };

      document.getElementById('sensorTitle').textContent = `${titleMap[type]} - ${unitMap[type]}`;

      const headers = {
        light: ['Light Intensity', 'System On', 'Time'],
        sound: ['Sound Level', 'System On', 'Time'],
        humidity: ['Temperature', 'System On', 'Time'],
        air: ['CO2 (ppm)', 'System On', 'Time']
      };

      document.getElementById('tableHeader').innerHTML = headers[type].map(h => `<th>${h}</th>`).join('');

      document.getElementById('tableBody').innerHTML = sensorData.map(row => {
        const time = formatDate(row.created_at);
        const status = row.system_on ? 'Active' : 'Inactive';

        let value;
        switch(type) {
          case 'light':
            value = row.light;
            break;
          case 'sound':
            value = row.sound;
            break;
          case 'humidity':
            value = row.temperature;
            break;
          case 'air':
            value = row.air_quality;
            break;
        }

        return `<tr><td>${value}</td><td>${status}</td><td>${time}</td></tr>`;
      }).join('');

      const ctx = document.getElementById('sensorChart').getContext('2d');
      if (window.sensorChartInstance) window.sensorChartInstance.destroy();

      const labels = sensorData.map(record => formatDate(record.created_at));

      let values;
      switch(type) {
        case 'light':
          values = sensorData.map(record => record.light);
          break;
        case 'sound':
          values = sensorData.map(record => record.sound);
          break;
        case 'humidity':
          values = sensorData.map(record => record.temperature);
          break;
        case 'air':
          values = sensorData.map(record => record.air_quality);
          break;
      }

      window.sensorChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: headers[type][0],
            data: values,
            backgroundColor: 'rgba(255, 182, 193, 0.4)',
            borderColor: 'rgba(255, 105, 180, 1)',
            borderWidth: 2,
            fill: true
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { labels: { color: '#555' } }
          },
          scales: {
            y: { beginAtZero: true, ticks: { color: '#666' } },
            x: { ticks: { color: '#666' } }
          }
        }
      });
    }

    function hideSensor() {
      document.getElementById('sensorDetails').classList.add('d-none');
    }

    // Auto refresh data every 60 seconds
    setInterval(fetchSensorData, 60000);
  </script>


<footer class="bg-white text-center py-4 mt-5 shadow-sm border-top" style="font-family: 'Poppins', sans-serif;">
  <div class="container">
    <h5 class="mb-3 text-primary fw-semibold">
      Developed with care by:
    </h5>
    <p class="mb-1 text-secondary">Bernado F. Catriz Jr.</p>
    <p class="mb-1 text-secondary">Nishren V. Hernandez</p>
    <p class="mb-1 text-secondary">Princess Maylene Habon</p>
    <p class="mb-1 text-secondary">Revin King M. Lorena</p>
    <p class="mb-0 fw-semibold text-dark">BSIT 3A</p>
  </div>
</footer>
</body>
</html>
