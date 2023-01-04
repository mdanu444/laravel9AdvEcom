@extends('templates.admin.master')

@section('main_content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title">Banner List</h3>
            <a href="{{ route('admin.banner.create') }}" class="btn btn-light float-right" style="color: black !important;">+
                Add New</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td><img style="height: 70px" src={{ url('images/banner/' . $item->image) }}
                                    class="img-fluid rounded-top" alt=""></td>
                            <td>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input statuschanger" status="banner"
                                            id="customSwitch{{ $item->id }}" {{ $item->status == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customSwitch{{ $item->id }}"></label>
                                    </div>
                                </div>
                            </td>
                            <td class="d-flex">
                                <form method="post"
                                    action="{{ route('admin.banner.destroy', Crypt::encryptString($item->id)) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="delete border-0 bg-primary p-3" type="submit"><i
                                            class="fa fa-trash "></i></button>
                                </form>
                                <a class="bg-primary p-3 ml-2"
                                    href="{{ route('admin.banner.edit', Crypt::encryptString($item->id)) }}"><i
                                        class="fa fa-pen"></i></a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <style>
        #example1_filter,
        #example1_paginate {
            float: right;
        }
    </style>
@endsection
