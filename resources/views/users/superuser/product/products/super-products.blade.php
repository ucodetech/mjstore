@extends('layouts.superuserapp')
@section('content')

    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('inc.bread')
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <!-- Info boxes -->
               <div class="card">
                <div class="card-header">
                <h3 class="card-title">List of Products</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
               </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-condensed table-hover" id="productsTable">
                        <thead>
                            <th>#</th>
                            <th>Unique Key</th>
                            <th>Photo</th>
                            <th>Vendor</th>
                            <th>Title</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Offer Price</th>
                            <th>Discount</th>
                            <th>Size</th>
                            <th>Weights</th>
                            <th>Category</th>
                            <th>Child Category</th>
                            <th>Brand</th>
                            <th>Condition</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @if($product_count > 0)
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <th><span class="badge badge-pill badge-info">{{ $product->unique_key }}</span></th>
                                <td><img src="{{ public_path('uploads/products').'/'.$product->photo }}" alt="{{ $product->title }}"></td>
                                <td>
                                    @if ($product->vendor == '')
                                        <span class="badge badge-pill badge-danger">Home Shop</span>
                                    @else
                                        <span class="badge badge-pill badge-info">{{ $product->vendor }}</span>

                                    @endif
                                </td>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ Naira($product->price)}}</td>
                                <td>{{ Naira($product->offer_price) }}</td>
                                <td>{{ $product->discount }} %</td>
                                <td>{{ $product->size }}</td>
                                <td>{{ $product->weights }}</td>
                                <td>{{ App\Models\ProductCategory::where('id', $product->cat_id)->get()->first()->title; }}</td>
                                <td>
                                    @if($product->child_cat_id != '')
                                    {{ App\Models\ProductCategory::where('id', $product->child_cat_id)->get()->first()->title;}}
                                    @else
                                        <span class="badge badge-pill badge-danger">No Child Cat</span>
                                    @endif
                                </td>
                                <td>{{ $product->brand->title }}</td>
                                <td>
                                   @if ($product->condition === 'new')
                                       <span class="badge badge-info">{{ $product->condition }}</span>
                                   @else
                                   <span class="badge badge-info">{{ $product->condition }}</span>
                                   @endif
                                </td>
                                <td>
                                    <input type="checkbox" 
                                     class="productToggle"
                                     data-id="{{ $product->id }}"
                                     data-url="{{ route('superuser.super.toggle.status.product') }}"
                                     data-token="{{ csrf_token() }}"
                                     data-toggle="switchbutton"   
                                     data-onlabel="Active" 
                                     data-offlabel="In Active" 
                                     data-onstyle="success" 
                                     data-offstyle="danger"
                                     {{ (($product->status =='active')? ' checked':'') }}>
                                    
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-success" href="{{ url('/superuser/super-edit').'/'.$product->unique_key }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger" id="deleteProduct" data-id="{{ $product->id }}"
                                            data-url="{{ route('superuser.super.delete.product.image') }}"
                                            >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-muted">
                    <button class="btn">
                   Total Products Added  <span class="badge badge-info">{{ $product_count }}</span>
                    </button>
                </div>
               </div>   
                
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection



