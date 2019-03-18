new Vue({
    el: '#discount-setting',
    data: {
        discountTitle: '',
        discountGenerate: {
            type: 'prefix',
            discountPrefix: '',
            numberDiscountGenerate: ''
        },
        randomCode: '',
        discountType: '',
        discountValue: '',
        discountCurrency: 'VND',
        discountApply: 'entire_order',
        discountOnePerOrder: true,
        discountMinimumRequirement: 'none',
        discountCustomers: 'every_one',
        discountStartDate: '',
        discountEndDate: '',
        discountLimit: ''
    },
    created: function () {
        let _this = this;
        _this.discountGenerate.discountPrefix =  _this.generateDiscountCode();
        _this.randomCode= _this.generateDiscountCode();
    },
    mounted: function () {
        $('#discount-start-date').datetimepicker();
        $('#discount-end-date').datetimepicker();
    },
    methods: {
        saveDiscountCode: function () {
            let _this = this;
        },
        generateDiscountCode: function () {
            let code = "";
            let possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            for (let i = 0; i < 5; i++)
                code += possible.charAt(Math.floor(Math.random() * possible.length));

            return code;
        }
    }
})