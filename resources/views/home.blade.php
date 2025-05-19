@extends('layout')

@section('title', 'Home - Pechay Monitoring')

@section('content')
<div class="container py-5">
  <div class="text-center mb-5">
    <h1 class="display-5 fw-bold mb-3">🌱 Welcome to Pechay Monitoring</h1>
    <p class="lead text-secondary">An IoT-based smart monitoring system for greenhouse-grown pechay, designed to help farmers and agriculturists track vital growing conditions in real-time.</p>
  </div>

  <!-- Video Section -->
  <div class="mb-5 text-center">
    <div class="ratio ratio-16x9 mb-3 shadow rounded overflow-hidden">
      <iframe src="https://www.youtube.com/embed/VIDEO_ID" title="Project Video" allowfullscreen></iframe>
    </div>
    <p class="text-muted">Watch how our smart monitoring system works inside a greenhouse environment.</p>
  </div>

  <!-- Project Description -->
  <div class="row align-items-center mb-5">
    <div class="col-md-6">
      <h3 class="fw-bold">📌 Project Overview</h3>
      <p>This system provides real-time data collection from various environmental sensors installed in a greenhouse. It monitors and records light levels, humidity, temperature, air quality, and sound disturbances—factors that can significantly affect the growth of pechay (Chinese cabbage).</p>
      <p>Using this data, growers can make informed decisions on adjusting irrigation, ventilation, or lighting to optimize plant health and productivity.</p>
    </div>
    <div class="col-md-6">
      <img src="/images/pechay-greenhouse.jpg" alt="Pechay Greenhouse" class="img-fluid rounded shadow-sm">
    </div>
  </div>

  <!-- Features Section -->
  <div class="row text-center mb-5">
    <h3 class="fw-bold mb-4">🧩 Key Features</h3>
    <div class="col-md-3 mb-4">
      <div class="p-4 border rounded shadow-sm h-100">
        <h5 class="mb-2">📡 Real-Time Monitoring</h5>
        <p class="text-muted">Continuously tracks environmental data with live updates every 60 seconds.</p>
      </div>
    </div>
    <div class="col-md-3 mb-4">
      <div class="p-4 border rounded shadow-sm h-100">
        <h5 class="mb-2">📊 Data Visualization</h5>
        <p class="text-muted">Interactive charts to analyze sensor trends over time.</p>
      </div>
    </div>
    <div class="col-md-3 mb-4">
      <div class="p-4 border rounded shadow-sm h-100">
        <h5 class="mb-2">🗃️ Historical Logs</h5>
        <p class="text-muted">View archived sensor data and system activity for review or export.</p>
      </div>
    </div>
    <div class="col-md-3 mb-4">
      <div class="p-4 border rounded shadow-sm h-100">
        <h5 class="mb-2">🔔 Smart Alerts</h5>
        <p class="text-muted">Trigger notifications when values go beyond safe thresholds (coming soon).</p>
      </div>
    </div>
  </div>

  <!-- Tech Stack -->
  <div class="row mb-5">
    <div class="col-md-6">
      <h3 class="fw-bold">🛠️ Technologies Used</h3>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">💻 <strong>Frontend:</strong> Blade, Bootstrap 5, Chart.js</li>
        <li class="list-group-item">🌐 <strong>Backend:</strong> Laravel</li>
        <li class="list-group-item">📶 <strong>IoT Devices:</strong> NodeMCU ESP8266, DHT11, MQ135, KY-038</li>
        <li class="list-group-item">🗄️ <strong>Database:</strong> MySQL</li>
      </ul>
    </div>
    <div class="col-md-6">
      <img src="/images/tech-diagram.png" alt="System Architecture Diagram" class="img-fluid rounded shadow-sm">
    </div>
  </div>

  <!-- CTA -->
  <div class="text-center mt-5">
    <h4 class="fw-semibold">Ready to explore the data?</h4>
    <a href="{{ route('sensors.index') }}" class="btn btn-success btn-lg mt-3 px-4">
      Go to Dashboard &rarr;
    </a>
  </div>
</div>
@endsection
