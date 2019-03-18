<html>
<head>
    {{--<link rel="stylesheet" href="{{ URL::asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">--}}
    <link rel="stylesheet" href="{{ URL::asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('bower_components/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/setting.css') }}">
</head>
<body>
<div class="container" id="discount-setting">
    <div class="row">
        <div class="col-md-3">
            General
        </div>
        <div class="next-card col-md-9">
            <div class="next-card-section">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="discount_title" class="form-control" id="discount_title"
                           placeholder="Name your discount" v-model="discountTitle">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            Discount codes
        </div>
        <div class="next-card col-md-9">
            <div class="next-card-section">
                <div class="form-group">
                    <div class="radio">
                        <label>
                            <input type="radio" value="prefix" name="discount-generate" v-model="discountGenerate.type">
                            <b class="discount-generate">Generate the discount codes using a prefix</b>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" value="import_codes" name="discount-generate" v-model="discountGenerate.type">
                            <b class="discount-generate">Import the discount codes</b>
                        </label>
                    </div>
                    <hr>
                </div>
                <div id="generate-code-form">
                    <div class="row" v-if="discountGenerate.type === 'prefix'">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="discount-generate-1">Discount Prefix</label>
                                <input type="text" name="discount-type-1" class="form-control" id="discount-generate-1" v-model="discountGenerate.discountPrefix">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="discount-generate-2">The number of discounts you want to generate</label>
                                <input type="text" name="discount-type-2" class="form-control" id="discount-generate-2" v-model="discountGenerate.numberDiscountGenerate">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <small class="discount-note">Example code based on your prefix: @{{ discountGenerate.discountPrefix }}-@{{ randomCode }}</small>
                        </div>
                    </div>
                    <div class="row" v-if="discountGenerate.type === 'import_codes'">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="discount-set-import-list-string">Type or paste each discount code</label>
                                <textarea class="form-control" rows="5" id="discount-set-import-list-string"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <small class="discount-note">For every line a discount will be created</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            Options
        </div>
        <div class="col-md-9 next-card">
            <div class="next-card-section">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="discount-type">Discount type</label>
                            <select name="discount-type" id="discount-type" class="form-control" v-model="discountType">
                                <option value="fixed_amount">Fixed amount</option>
                                <option value="percentage">Percentage discount</option>
                                <option value="free_shipping">Free shipping</option>
                                <option value="buy_x_get_y">Buy X get Y</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="discount-value">Discount value</label>
                            <div class="row">
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="discount-value" id="discount-value" v-model="discountValue">
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group-text">@{{ discountCurrency }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            Applies to
        </div>
        <div class="col-md-9 next-card">
            <div class="next-card-section">
                <div>
                    <label class="form-check-label">
                        <input type="radio" name="discount-applies" value="entire_order" v-model="discountApply"><b class="discount-apply">Entire order</b>
                    </label>
                </div>
                <div>
                    <label class="form-check-label">
                        <input type="radio" name="discount-applies" value="selected_collections" v-model="discountApply"><b class="discount-apply">Selected collections</b>
                    </label>
                </div>
                <div>
                    <label class="form-check-label">
                        <input type="radio" name="discount-applies" value="selected_products" v-model="discountApply"><b class="discount-apply">Selected products</b>
                    </label>
                </div>
                <hr>
                <div>
                    <label>
                        <input type="checkbox" v-model="discountOnePerOrder"><span class="discount-one-per-order">Only apply discount once per order</span>
                    </label>
                </div>
                <p class="discount-note">If unchecked, will be taken off each eligible product in an order.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            Minimum requirement
        </div>
        <div class="col-md-9 next-card">
            <div class="next-card-section">
                <div class="form-group">
                    <div>
                        <label class="form-check-label">
                            <input type="radio" name="discount-requirement" value="none" v-model="discountMinimumRequirement"><b class="discount-requirement">None</b>
                        </label>
                    </div>
                    <div>
                        <label class="form-check-label">
                            <input type="radio" name="discount-requirement" value="minimum_purchase_amount" v-model="discountMinimumRequirement"><b class="discount-requirement">Minimum purchase amount</b>
                        </label>
                    </div>
                    <div>
                        <label class="form-check-label">
                            <input type="radio" name="discount-requirement" value="minimum_quality_items" v-model="discountMinimumRequirement"><b class="discount-requirement">Minimum quantity of items</b>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            Customers
        </div>
        <div class="col-md-9 next-card">
            <div class="next-card-section">
                <div class="form-group">
                    <div>
                        <label class="form-check-label">
                            <input type="radio" name="discount-for-customer" value="every_one" v-model="discountCustomers"><b class="discount-for-customer">Everyone</b>
                        </label>
                    </div>
                    <div>
                        <label class="form-check-label">
                            <input type="radio" name="discount-for-customer" value="group_customers" v-model="discountCustomers"><b class="discount-for-customer">Selected groups of customers</b>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            Date
        </div>
        <div class="col-md-9 next-card">
            <div class="next-card-section">
                <div class="row">
                    <div class="col-md-6">
                        <div class="next-card-section">
                            <div class="form-group">
                                <label for="discount-start-date">Start</label>
                                <input type="text" name="discount-start-date" class="form-control" id="discount-start-date" v-model="discountStartDate">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="next-card-section">
                            <div class="form-group">
                                <label for="discount-valid-end-date">End</label>
                                <input type="text" name="discount-valid-end-date" id="discount-end-date" class="form-control" v-model="discountEndDate">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            Limits
        </div>
        <div class="col-md-9 next-card">
            <div class="next-card-section">
                <div class="form-group">
                    <div>
                        <label class="form-check-label">
                            <input type="checkbox" name="discount-limit" value="number_of_times_in_use" v-model="discountLimit">
                            <span class="discount-limit">Limit number of times this discount can be used in total</span>
                        </label>
                    </div>
                    <div>
                        <label class="form-check-label">
                            <input type="checkbox" name="discount-limit" value="one_per_customer" v-model="discountLimit">
                            <span class="discount-limit">Limit to one use per customer</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-9">
            <div class="save-discount-wrap">
                <button class="cancel-button btn btn-light">Cancel</button>
                <button class="save-button btn btn-primary" @click="saveDiscountCode()">Save</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::asset('bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('bower_components/bootstrap-3.3.5/dist/css/bootstrap.min.css') }}">
<script src="{{ URL::asset('bower_components/vue/dist/vue.min.js') }}"></script>
<script src="{{ URL::asset('js/setting.min.js') }}"></script>
</body>
</html>