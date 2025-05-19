@extends('layout')

@section('title', 'About Us')

@section('content')
  <h2 class="mb-4">👥 About the Team</h2>
  <div class="row g-4">
    <div class="col-md-6">
      <div class="p-3 bg-white shadow rounded">
        <h5 class="fw-bold">Developer 1</h5>
        <p>Role: Full Stack Developer</p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="p-3 bg-white shadow rounded">
        <h5 class="fw-bold">Developer 2</h5>
        <p>Role: IoT & Backend Integration</p>
      </div>
    </div>
  </div>
  <hr class="my-5">
  <h3>📌 Project Info</h3>
  <p>This project is focused on smart environmental monitoring for pechay growth using sensors like light, sound, humidity, and air quality data.</p>
@endsection
