@extends('panel-shared.templates.main')

@section('page_title', 'Customers')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card-style mb-30">
      <!-- <h6 class="mb-10"></h6>
      <p class="text-sm mb-20"> -->
      </p>
      <div class="table-wrapper table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th><h6>#</h6></th>
              <th><h6>Name</h6></th>
              <th><h6>Email</h6></th>
              <th><h6>Status</h6></th>
              <th><h6>Trial</h6></th>
              <th><h6>Action</h6></th>
            </tr>
            <!-- end table row-->
          </thead>
          <tbody>
            @foreach($customers as $customer)
            <tr>
              <td>
                <div class="employee-image">
                  <img src="/admin/images/lead/lead-1.png" alt="">
                </div>
              </td>
              <td class="min-width">
                <p>{{ $customer->name }}</p>
              </td>
              <td class="min-width">
                <p><a href="#0">{{ $customer->email }}</a></p>
              </td>
              <td class="min-width">
                <span class="status-btn active-btn">
                  @if( $customer->isSubscribing() )
                    Active
                  @endif
                </span>
              </td>
              <td class="min-width">
                @if( $customer->isOnTrial() )
                  <p>Ends in {{ $customer->present()->timeBeforeTrialEnds() }}</p>
                @endif
              </td>
              <td>
                <div class="action">
                  <button class="text-danger">
                    <i class="lni lni-trash-can"></i>
                  </button>
                </div>
              </td>
            </tr>
            @endforeach
            <!-- end table row -->
          </tbody>
        </table>
        <!-- end table -->
      </div>
    </div>
    <!-- end card -->
  </div>
  <!-- end col -->
</div>
@endsection()