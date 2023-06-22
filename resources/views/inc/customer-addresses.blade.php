<!-- Modal -->
{{-- billing address --}}
<div class="modal fade" id="billingAddressModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Edit  Billing Address</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="{{ route('user.customer.update.billing.address') }}" id="customerBillingForm" method="POST">
                        @csrf
                        @method('POST')

                        <div class="form-group col-md-12">
                            <label for="address">Address</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ $customer->address }}">
                            <span class="text-error text-danger address_error"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="apartment">Apartment/Suite/Unit</label>
                            <input type="text" name="apartment" id="apartment" class="form-control" value="{{ $customer->apartment_suite_unit }}">

                        </div>
                        <div class="form-group col-md-12">
                            <label for="country">Country</label>
                            <select name="country" id="country" class="d-block w-100 form-control">
                                <option value="">--Select County --</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->country }}" {{ (($country->country == $customer->country)?' selected':'') }}>{{ $country->country }}</option>
                                @endforeach
                            </select>
                            <span class="text-error text-danger country_error"></span>

                        </div>
                        <div class="form-group col-md-12">
                            <label for="state">State</label>
                            <input type="text" name="state" id="state" class="form-control" value="{{ $customer->state }}">
                            <span class="text-error text-danger state_error"></span>

                        </div>
                        <div class="form-group col-md-12">
                            <label for="town">Town/City</label>
                            <input type="text" name="town" id="town" class="form-control" value="{{ $customer->town_city }}">
                            <span class="text-error text-danger town_error"></span>

                        </div>
                        <div class="form-group col-md-12">
                            <label for="postcode">Postcode/Zip</label>
                            <input type="number" name="postcode" id="postcode" class="form-control" value="{{ $customer->postcode_zip }}">
                            <span class="text-error text-danger postcode_error"></span>

                        </div>

                        <div class="form-group">
                            <button class="btn btn-info" type="submit" id="updateBillingAddress">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
{{-- shipping address --}}
<div class="modal fade" id="shippingAddressModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Edit Shipping Address</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="{{ route('user.customer.update.shipping.address') }}" id="customerShippingForm" method="POST">
                        @csrf
                        @method('POST')

                        <div class="form-group col-md-12">
                            <label for="ship_address">Address</label>
                            <input type="text" name="ship_address" id="ship_address" class="form-control" value="{{ $customer->ship_to_address }}">
                            <span class="text-error text-danger ship_address_error"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="ship_apartment">Apartment/Suite/Unit</label>
                            <input type="text" name="ship_apartment" id="ship_apartment" class="form-control" value="{{ $customer->ship_to_apartment_suite_unit }}">

                        </div>
                        <div class="form-group col-md-12">
                            <label for="ship_country">Country</label>
                            <select name="ship_country" id="ship_country" class="d-block w-100 form-control">
                                <option value="">--Select County --</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->country }}" {{ (($country->country == $customer->ship_to_country)?' selected':'') }}>{{ $country->country }}</option>
                                @endforeach
                            </select>
                            <span class="text-error text-danger country_error"></span>

                        </div>
                        <div class="form-group col-md-12">
                            <label for="ship_state">State</label>
                            <input type="text" name="ship_state" id="ship_state" class="form-control" value="{{ $customer->ship_to_state }}">
                            <span class="text-error text-danger ship_state_error"></span>

                        </div>
                        <div class="form-group col-md-12">
                            <label for="ship_town">Town/City</label>
                            <input type="text" name="ship_town" id="ship_town" class="form-control" value="{{ $customer->ship_to_town_city }}">
                            <span class="text-error text-danger ship_town_error"></span>

                        </div>
                        <div class="form-group col-md-12">
                            <label for="ship_postcode">Postcode/Zip</label>
                            <input type="number" name="ship_postcode" id="ship_postcode" class="form-control" value="{{ $customer->ship_to_postcode_zip }}">
                            <span class="text-error text-danger ship_postcode_error"></span>

                        </div>

                        <div class="form-group">
                            <button class="btn btn-info" type="submit" id="updateShippingAddress">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              
            </div>
        </div>
    </div>
</div>
