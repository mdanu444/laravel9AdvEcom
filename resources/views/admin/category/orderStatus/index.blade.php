@extends('templates.admin.master')

@section('main_content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title">Order Status List</h3>
            <a href="{{ route('admin.order_status.create') }}" class="btn btn-light float-right"
                style="color: black !important;">+ Add New</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Order Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->title }}</td>

                                <td>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input  type="checkbox" class="custom-control-input statuschanger"
                                                status="order_status" id="customSwitch{{ $item->id }}"
                                                {{ $item->status == 1 ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                for="customSwitch{{ $item->id }}"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <input type="hidden" class="status_id" name="status_id" value="{{ $item->id }}">
                                    <input class="form-control order_number" type="text" name="order_number" value="{{ $item->order_number }}">
                                </td>
                                <td class="d-flex">
                                    <form method="post"
                                        action="{{ route('admin.order_status.destroy', Crypt::encryptString($item->id)) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="delete border-0 bg-primary p-3" type="submit"><i
                                                class="fa fa-trash "></i></button>
                                    </form>
                                    <a class="bg-primary p-3 ml-2"
                                        href="{{ route('admin.order_status.edit', Crypt::encryptString($item->id)) }}"><i
                                            class="fa fa-pen"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th><input type="submit" onclick="updateStatusOrderNumber()" class="btn btn-primary" value="Update Order"></th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
        </div>
        <!-- /.card-body -->
    <script>

    function updateStatusOrderNumber(){
        let status_id_s = document.querySelectorAll('.status_id');
        let order_numbers = document.querySelectorAll('.order_number');
        let status_id_arr = "";
        let order_numbers_arr = "";
        for(let id of status_id_s){
            status_id_arr+=id.value+",";
        }
        for(let order_number of order_numbers){
            order_numbers_arr+=order_number.value+",";
        }
        let url = location.origin+"/admin/updateStatusOrder";
        let formData = new FormData();
        let ids = status_id_arr;
        let numbers = order_numbers_arr;

        formData.append('ids', ids);
        formData.append('numbers', numbers);

        fetch(url, {
            body: formData,
            method: 'post',
            headers:{
                "X-CSRF-Token": "{{ csrf_token() }}",
            },
        }).then((response) => response.json())
        .then((data) =>{
            if(data.status){
                alert("Order Updated !");
            }
        })
    }

    </script>
    </div>
@endsection
