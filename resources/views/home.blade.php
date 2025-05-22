@extends('layout')

@section('title', 'Home - Pechay Monitoring')

@section('content')
<div class="container py-5">
  <div class="text-center mb-5">
    <h1 class="display-5 fw-bold mb-3">🌱 Hydroponic Pechay Monitoring Using IoT</h1>
    <p class="lead text-secondary">
      A smart monitoring system for hydroponically grown pechay, powered by IoT and environmental sensors. Track noise, temperature, humidity, light, and air quality in real time to support efficient and data-driven plant care.
    </p>
  </div>


  <!-- Video Section -->
  <div class="mb-5 text-center">
<div>
  <div style="left: 0; width: 100%; height: 0; position: relative; padding-bottom: 56.25%;">
    <iframe src="https://cdn.iframe.ly/api/iframe?url=https%3A%2F%2Fyoutu.be%2FObF8xK3DYiM%3Fsi%3DA3xDcj1bKG5D64Bq&key=925108d922be940af814f71907a7df4b" 
    style="top: 0; left: 0; width: 100%; height: 100%; position: absolute; border: 0;" allowfullscreen scrolling="no" 
    allow="accelerometer *; clipboard-write *; encrypted-media *; gyroscope *; picture-in-picture *; web-share *;"></iframe>
  </div>
    <a href="https://embedcodesgenerator.com/tools/youtube-embed-code?gad_source=1&gad_campaignid=22458335448&gbraid=0AAAAA_LxlSgxvMwUjigse8MwarJSWXtmK&gclid=Cj0KCQjwlrvBBhDnARIsAHEQgOTBeodxhfUAogmBa8l-Re-eGPm0pjXe6_2XDuw5YcdC_OgmzwTyaskaAgPWEALw_wcB" 
    rel="noopener" target="_blank" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;">youtube embed code</a></div>
  <p class="text-muted">
    A walkthrough of the final hydroponic setup — showcasing components and how sensor data is transmitted from the ESP32 to the backend via a custom API.
  </p>
  </div>

  <!-- Project Description -->
  <div class="row align-items-center mb-5">
    <div class="col-md-6">
      <h3 class="fw-bold">📌 Project Overview</h3>
      <p>This system collects live environmental data using multiple sensors installed near the pechay plants. It records light intensity, humidity, temperature, air quality, and sound disturbances—factors that can impact plant growth and health.</p>
      <p>By accessing this data remotely, users can make informed decisions about plant care such as watering, shade placement, or noise exposure control.</p>
    </div>
    <div class="col-md-6">
      <img src="{{ asset('images/pechay.jpg') }}" alt="Pechay Setup" class="img-fluid rounded shadow-sm">
    </div>
  </div>

  <!-- Features Section -->
  <div class="row text-center mb-4 justify-content-center">
    <h3 class="fw-bold mb-4">🧩 Key Features</h3>
    <div class="col-md-3 mb-4">
      <div class="p-4 border rounded shadow-sm h-100">
        <h5 class="mb-2">📡 Real-Time Monitoring</h5>
        <p class="text-muted">Continuously tracks environmental data with live updates every 3 minutes.</p>
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
        <p class="text-muted">View archived sensor data and system activity for review.</p>
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
        <li class="list-group-item">📶 <strong>IoT Devices:</strong> ESP32, DHT11, MQ135, KY-038, BH1750</li>
        <li class="list-group-item">🔌 <strong>Power:</strong> 5V Solar Panel, TP4056, 1200mAh Battery</li>
        <li class="list-group-item">🗄️ <strong>Database:</strong> MySQL</li>
      </ul>
    </div>
    <div class="col-md-6">
      <h3 class="fw-bold">🔩 Components & Wiring</h3>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">📦 Junction Box – Waterproof housing for all electronics</li>
        <li class="list-group-item">🔋 Battery Holder with TP4056 charger</li>
        <li class="list-group-item">🔌 Type-C cable support</li>
        <li class="list-group-item">🟢 Green LED – System status indicator</li>
        <li class="list-group-item">🔊 Buzzer – Alerts on threshold breaches</li>
        <li class="list-group-item">🎛️ Manual Switch – Power toggle</li>
        <li class="list-group-item">🔗 4-Pin Wires – For organized wiring</li>
      </ul>
    </div>
  </div>

  <!-- Data Flow -->
  <div class="mb-5">
    <h3 class="fw-bold">🔁 Data Flow</h3>
    <p>The ESP32 runs Arduino code to read data from all connected sensors. The sensor data is then sent via an API to a cloud-based Laravel backend, which processes it and displays it on a web dashboard accessible through a custom domain.</p>
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
