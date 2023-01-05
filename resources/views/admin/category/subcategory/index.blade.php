@extends('templates.admin.master')


@section('main_content')


    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header bg-primary ">
              <h3 class="card-title">Product Sub Category List</h3>
              <div class="text-right float-right">
                <a href="{{route('admin.productsubcategory.create')}}" class="btn btn-light">+ Add New</a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Title</th>
                  <th>Category</th>
                  <th>Status</th>
                  <th class="w-25">Action</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data) == 0)
                        <tr><td colspan="5" class="text-center">No Data Found.</td></tr>
                    @endif
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ !empty($item->product_categories->title)?$item->product_categories->title:"Other" }}</td>
                            <td>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                      <input type="checkbox"  class="custom-control-input statuschanger" status="productsubcategory" id="customSwitch{{$item->id}}" {{ $item->status == 1? "checked":"" }}>
                                      <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                                    </div>
                                </div>
                            </td>
                            <td class="w-25">
                                <form class="d-inline" style="cursor: pointer" action="{{ route('admin.productsubcategory.destroy', Crypt::encryptString($item->id)) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="delete border-0" type="submit"><i class="fa fa-trash p-3 bg-primary"></i></button>
                                </form>
                                <a class="ml-3 bg-primary text-dark p-3" href="{{ route('admin.productsubcategory.edit', Crypt::encryptString($item->id)) }}"><i class="fa fa-pen"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th class="w-25">Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
@endsection
