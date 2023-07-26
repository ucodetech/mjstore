<!-- Currency Dropdown -->

<div class="language-dropdown">
    <div class="dropdown">
        @php
            currency_load();
            $currency_code = session('currency_code');
            $currency_symbol = session('currency_symbol');
            if ($currency_symbol == "") {
                $default_currency = session('default_currency');
                $currency_symbol = $default_currency->symbol;
                $currency_code = $default_currency->code;
            }
        @endphp
        <a class="btn btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenu2"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ $currency_symbol }}&nbsp;{{ $currency_code }}
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
            @foreach (\App\Models\Currency::where('status', 'active')->get() as $item)
                <a class="dropdown-item" href="javascript:0" onclick="currency_change('{{  $item->code }}')">{{ $item->symbol }} &nbsp; {{ $item->code }}</a>
            @endforeach
           
           
        </div>
    </div>
</div>