@extends('layout')

@section('title', 'About Us')

@section('content')
  <h2 class="mb-4">👥 About the Team</h2>
  <div class="row g-4">

    {{-- Bernardo --}}
    <div class="col-md-6">
      <div class="p-3 bg-white shadow rounded d-flex align-items-center">
        <img src="{{ asset('images/catriz.jpg') }}" alt="Bernardo Catriz JR" class="me-3 rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
        <div>
          <h5 class="fw-bold">Bernardo Catriz JR</h5>
          <p>Role: Team Leader — IoT & Backend Integration</p>
        </div>
      </div>
    </div>

    {{-- Revin --}}
    <div class="col-md-6">
      <div class="p-3 bg-white shadow rounded d-flex align-items-center">
        <img src="{{ asset('images/revin.jpg') }}" alt="Revin King Lorena" class="me-3 rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
        <div>
          <h5 class="fw-bold">Revin King Lorena</h5>
          <p>Role: Sensor Setup & Hardware Connectivity</p>
        </div>
      </div>
    </div>

    {{-- Nishren --}}
    <div class="col-md-6">
      <div class="p-3 bg-white shadow rounded d-flex align-items-center">
        <img src="{{ asset('images/nishren.jpg') }}" alt="Nishren Hernandez" class="me-3 rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
        <div>
          <h5 class="fw-bold">Nishren Hernandez</h5>
          <p>Role: Documentation & Backend Support</p>
        </div>
      </div>
    </div>

    {{-- Princess --}}
    <div class="col-md-6">
      <div class="p-3 bg-white shadow rounded d-flex align-items-center">
  <img src="{{ asset('images/princess.jpg') }}" alt="Princess Maylene Habon" class="me-3 rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
        <div>
          <h5 class="fw-bold">Princess Maylene Habon</h5>
          <p>Role: Frontend Developer & UI Design</p>
        </div>
      </div>
    </div>

  </div>

  <hr class="my-5">
  <h3>📌 Project Info</h3>
  <p>This project is focused on smart environmental monitoring for pechay growth using sensors like light, sound, humidity, and air quality data.</p>
@endsection
