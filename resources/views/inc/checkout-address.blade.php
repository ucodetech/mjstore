
    <form action="{{ route('shop.billing.submit') }}" method="post" id="submitBillingForm">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="fullname">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" value="{{ muser()->fullname }}" required>
                <span class="text-error text-danger fullname_error"></span>
            </div>
            
            <div class="col-md-6 mb-3">
                
                <label for="email_address">Email Address <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" value="{{ muser()->email }}" @readonly(true)>
                <span class="text-error text-danger email_error"></span>

            </div>
            <div class="col-md-12 mb-3">
                <div class="row">
                    <div class="col-sm-4">
                        <label><small>Chose Phone No. to use</small></label>
                        <select id="myNo">
                            <option value="{{ userPhone(muser()->phone_number)[0] }}">{{ userPhone(muser()->phone_number)[0] }}</option>
                            <option value="{{ count(userPhone(muser()->phone_number)) > 1 ? userPhone(muser()->phone_number)[1] : userPhone(muser()->phone_number)[0] }}">{{ count(userPhone(muser()->phone_number)) > 1 ? userPhone(muser()->phone_number)[1]: userPhone(muser()->phone_number)[0] }}</option>
                        </select>
                        
                    </div>
                    <div class="col-md-8">
                        <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="phone_number" id="phone_number" min="0" value="{{ userPhone(muser()->phone_number)[0] }}" @readonly(true)>   
                        <span class="text-error text-danger phone_number_error"></span>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="street_address">Deliver Address <span class="text-danger">*</span></label>
                <textarea name="address" id="address"  rows="5" class="form-control" placeholder="Street Name/Building/Apartment No">{{ muser()->address, muser()->apartment_suite_unit }}</textarea>
                <span class="text-error text-danger address_error"></span>

                
                
            </div>
        </div>
        
        <div class="row">
            
            <div class="form-group col-md-6 mb-3">
                <label for="state">State <span class="text-danger">*</span></label>
                <select name="state" id="state" class="custom-select d-block w-100 form-control">
                    <option value="">--Select State--</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->name }}">{{ $state->name }}</option>
                    @endforeach
                </select>
                <span class="text-error text-danger state_error"></span>

            </div>
            <div class="col-md-6 mb-3">
                <label for="city">Town/City <span class="text-danger">*</span></label>
                <select name="city" id="city" class="custom-select d-block w-100 form-control">
                    
                </select>
                <span class="text-error text-danger city_error"></span>

            </div>
            <div class="col-md-6 mb-3">
                <label for="postcode">Postcode/Zip</label>
                <input type="text" class="form-control" name="postcode" id="postcode" placeholder="Postcode / Zip" value="{{ muser()->postcode_zip }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="order-notes">Order Notes</label>
                <textarea class="form-control" id="order-notes" cols="30" rows="10" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
            </div>
        </div>
    
        <div class="col-12">
            <div class="checkout_pagination d-flex justify-content-end mt-50">
                <button type="submit" id="billingBtn" class="btn btn-block btn-primary mt-2 ml-2">Save and Continue</button>
            </div>
        </div>
    </form>
