@extends('customer.templates.main')

@section('content')

<div class="row">
  <div class="col-md-6">

    <div class="card">
      <div class="card-body">
          <h2 id="card-title">Account</h2>
          This is some text within a card body.
      </div>
    </div>

  </div>
  <div class="col-md-6">

    <div class="card">
      <div class="card-body">
          <h2 id="card-title">Subscription</h2>
          This is some text within a card body.
      </div>
    </div>
    
  </div>
</div>

<div class="row mt-4">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h2 id="card-title">Statistics</h2>
      </div>
    </div>
  </div>
</div>

<a href="{{ route('auth.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Logout
</a>

<form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
    @csrf
</form>

@endsection




<!-- <a href="{{ route('customer.content.request.view') }}">Request New Content</a> -->
