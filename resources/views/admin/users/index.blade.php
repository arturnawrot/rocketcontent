@extends('admin.templates.main')

@section('page_title', 'Users')

@section('content')
<div class="row">
              <div class="col-lg-12">
                <div class="card-style mb-30">
                  <h6 class="mb-10">Data Table</h6>
                  <p class="text-sm mb-20">
                    For basic styling—light padding and only horizontal
                    dividers—use the class table.
                  </p>
                  <div class="table-wrapper table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th><h6>#</h6></th>
                          <th><h6>Name</h6></th>
                          <th><h6>Email</h6></th>
                          <th><h6>Project</h6></th>
                          <th><h6>Status</h6></th>
                          <th><h6>Action</h6></th>
                        </tr>
                        <!-- end table row-->
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <div class="employee-image">
                              <img src="/admin/images/lead/lead-1.png" alt="">
                            </div>
                          </td>
                          <td class="min-width">
                            <p>Esther Howard</p>
                          </td>
                          <td class="min-width">
                            <p><a href="#0">yourmail@gmail.com</a></p>
                          </td>
                          <td class="min-width">
                            <p>Admin Dashboard Design</p>
                          </td>
                          <td class="min-width">
                            <span class="status-btn active-btn">Active</span>
                          </td>
                          <td>
                            <div class="action">
                              <button class="text-danger">
                                <i class="lni lni-trash-can"></i>
                              </button>
                            </div>
                          </td>
                        </tr>
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