<div class="row shipping_input_field">
    <div class="col-md-6 mb-3">
        <label for="ship-fullname">Full Name</label>
        <input type="text" class="form-control" name="ship_fullname" id="ship_fullname" placeholder="Full Name" value="{{ muser()->fullname }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label for="ship_email">Email Address</label>
        <input type="email" class="form-control" name="ship_email" id="ship_email" placeholder="Email Address" value="{{ muser()->email }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="ship_phone_number">Phone Number</label>
        <input type="number" class="form-control" name="ship_phone_number"  id="ship_phone_number" min="0" value="{{ userPhone(muser()->phone_number)[0] }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="country">Country</label>
        <select class="custom-select d-block w-100 form-control" id="ship_country" name="ship_country">
            <option value="">--Select Country--</option>
            @foreach ($countries as $ship_country)
            <option value="{{ $ship_country->country }}" {{ (($ship_country->country == muser()->ship_to_country)? ' selected': '') }}>{{ $ship_country->country }}</option>
           @endforeach
        </select>
    </div>
    <div class="col-md-12 mb-3">
        <label for="ship_street_address">Street address</label>
        <input type="text" class="form-control" name="ship_street_address" id="ship_street_address" placeholder="Street Address" value="{{ muser()->ship_to_address }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="ship_apartment_suite">Apartment/Suite/Unit</label>
        <input type="text" class="form-control" name="ship_apartment_suite" id="ship_apartment_suite" placeholder="Apartment, suite, unit etc" value="{{ muser()->ship_to_apartment_suite_unit }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="ship_city">Town/City</label>
        <input type="text" class="form-control" name="ship_city" id="ship_city" placeholder="Town/City" value="{{ muser()->ship_to_city_town }}">
    </div>
    <div class="col-md-6">
        <label for="ship_state">State</label>
        <input type="text" class="form-control" name="ship_state" id="ship_state" placeholder="State" value="{{ muser()->ship_to_state}}">
    </div>
    <div class="col-md-6">
        <label for="ship_postcode">Postcode/Zip</label>
        <input type="text" class="form-control" id="ship_postcode" name
       ="ship_postcode" placeholder="Postcode / Zip" value="{{ muser()->ship_to_postcode_zip }}">
    </div>
</div>