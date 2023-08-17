 <div class="col-md-3">
            <div class="card border-0 shadow">
                    <div class="card-body border-0">
                        <!-- Single Widget -->
                        <div class="card bg-white border-0">
                            <div class="card-header text-uppercase bg-white border-0">
                                <a class="text-left">Category</a>
                            </div>
                            <div class="card-body" style="max-height:300px; overflow-y:scroll">
                                <!-- Single Checkbox -->
                                <div class="list-group bg-white" style="font-size:14px;">
                                    @if ($cat_child_parent)
                                         <a href="{{ route('category.product',$cat_child_parent->slug) }}" class="list-group-item list-group-item-action list-group-item-light text-primary border-0">{{ $cat_child_parent->title }}</a>
                                    @endif
                                    <a href="{{ route('category.product', $categories->slug) }}" class="list-group-item list-group-item-action list-group-item-light text-primary border-0">{{ $categories->title }}</a>

                                    @foreach ($cat_child as $cat_ch)
                                      <a href="{{ route('category.product', $cat_ch->slug) }}" class="list-group-item list-group-item-action list-group-item-light text-dark border-0 ml-3">{{ $cat_ch->title }}</a>
                                    @endforeach
                                 </div>
                            
                            </div>
                        </div>
                        <hr>

                        <!-- Single Widget -->
                        <div class="card bg-white border-0">
                            <div class="card-header text-uppercase bg-white border-0">
                                <a class="text-left">Filter By Price</a>
                            </div>
                            <div class="card-body">
                                <div class="slider-range">
                                    <div data-min="0" data-max="500000" data-unit="{{ ((session()->has('default_currency'))? currency_symbol() : "₦" ) }}" class="slider-range-price ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" data-value-min="0" data-value-max="500000" data-label-result="Price:">
                                        <div class="ui-slider-range ui-widget-header ui-corner-all"></div>
                                        <span class="ui-slider-handle ui-state-default ui-corner-all bg-primary rounded-circle" tabindex="0"></span>
                                        <span class="ui-slider-handle ui-state-default ui-corner-all bg-primary rounded-circle" tabindex="0"></span>
                                    </div>
                                    <div class="range-price">Price:</div>
                                </div>
                                <div class="clear-fix"></div>
                                <hr class="invisible">
                                <button type="button" class="btn btn-sm btn-info btn-block">Apply</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">test</label>
                            <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
                            <small id="helpId" class="text-muted">Help text</small>
                          </div>
                        <hr>
                         <!-- Single Widget -->
                         <div class="card bg-white border-0">
                           {{-- form --}}
                            {{-- <form action="{{ route("category.product", $categories->slug) }}" method="POST">
                                @csrf
                                @method("POST") --}}
                                <div class="card-header text-uppercase bg-white border-0">
                                    <a class="text-left">Color</a>
                                </div>
                                <div class="card-body" style="max-height:200px; overflow-y:scroll">
                                <!-- Single Checkbox -->
                                @if(count($colors)>0)
                                        
                                @foreach ($colors as $color)
                                
                                    <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                                        <input type="checkbox" name="product_color[]" class="custom-control-input color_product" id="product_color{{ $color->id }}" value="{{ $color->color }}" {{ ((!empty($_GET['color']) && $_GET['color'] == $color->color)? " checked" : "") }}
                                        >
                                        <label class="custom-control-label {{ strtolower($color->color) }}" for="product_color{{ $color->id }}">{{ $color->color }} 
                                        
                                    </div>
                                @endforeach
                            @else
                                <h4 class="text-muted text-center">No Color</h4>
                            @endif
                                </div>
                            {{-- </form> --}}
                             
                            {{-- end of form --}}
                        </div>
                        <hr>
                        <!-- Single Widget -->
                        <div class="card bg-white border-0">
                            <div class="card-header text-uppercase bg-white border-0">
                                <a class="text-left">Brand</a>
                                <input type="search" name="" id="" class="form-control form-control-sm rounded-10" placeholder="Search Brand">
                            </div>
                            <div class="card-body" style="max-height:200px; overflow-y:scroll">
                               <!-- Single Checkbox -->
                                <!-- Single Checkbox -->
                                @if(count($brands))
                                    @foreach ($brands as $brand)
                                        @php
                                            if(count($brand->product)==0){
                                                $text = 'text-danger';
                                            }elseif(count($brand->product) < 5){
                                                $text = 'text-warning';
                                            }else{
                                                $text = 'text-success';
                                            }
                                            
                                        @endphp
                                        <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                                            <input type="checkbox" class="custom-control-input" id="product_brand{{ $brand->id }}" name="product_brand[]">
                                            <label class="custom-control-label" for="product_brand{{ $brand->id }}">{{ $brand->title }} <span class="{{ $text }}">({{ count($brand->product) }})</span></label>
                                        </div>
                                    @endforeach
                                @else
                                    <h4 class="text-center-text-muted">No brand</h4>
                                @endif
                            
                            </div>
                        </div>
                        <hr>
                       
                          <!-- Single Widget -->
                          <div class="card bg-white border-0">
                            <div class="card-header text-uppercase bg-white border-0">
                                <a class="text-left">Product Rating</a>
                            </div>
                            <div class="card-body" style="max-height:auto;">
                               <!-- Single Checkbox -->
                                <ul class="m-rating"> 
                                    <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <span class="text-muted">(103)</span></a></li>

                                    <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <span class="text-muted">(78)</span></a></li>

                                    <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <span class="text-muted">(47)</span></a></li>

                                    <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <span class="text-muted">(9)</span></a></li>

                                    <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <span class="text-muted">(3)</span></a></li>
                                </ul>
                            
                            </div>
                        </div>
                        <hr>
                         <!-- Single Widget -->
                         <div class="card bg-white border-0">
                            <div class="card-header text-uppercase bg-white border-0">
                                <a class="text-left">Size</a>
                                <input type="search" name="" id="" class="form-control form-control-sm rounded-10" placeholder="Search Size">
                            </div>
                            <div class="card-body" style="max-height:200px; overflow-y:scroll">
                               <!-- Single Checkbox -->
                               @if(count($sizes))
                            <div class="widget size">
                               <div class="widget-desc bg-white">
                                   <ul>
                                       @foreach ($sizes as $size)
                                       @php
                                       if(is_numeric($size->size)){
                                               $color = 'bg-primary';
                                       }else{
                                               $color = '';
                                       }
                                       @endphp
                                           <li><a href="#" class="{{ $color }}">{{ $size->size }}</a></li>
                                       @endforeach                   
                                   </ul>
                               </div>
                            </div>
                               @else
                                   <h4 class="text-center text-muted">No sizes</h4>
                               @endif
   
                            
                            </div>
                        </div>
                        <hr>
                        
                    </div>
            </div>
        </div>