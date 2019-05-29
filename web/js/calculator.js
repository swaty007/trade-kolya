document.addEventListener("DOMContentLoaded", function () {

// if (typeof rates_CoinPayments === 'undefined') {


// }

    $('#switchRateInit').on('click', function (e) {
        CoinPaymentsCalculator.init();
    });
    $('#switchRate').on('show.bs.modal', function (e) {
        CoinPaymentsCalculator.init();
    });
    var rates_CoinPayments = [];
    var CoinPaymentsCalculator = {
        init: function () {
            if (this.firstTime === false) {return;}
            this.firstTime = false;
            $.ajax({
                type: "POST",
                url: "/coins/calculator-rate",
                data: '',
                success: function (msg) {
                    rates_CoinPayments = msg.result;
                    CoinPaymentsCalculator.firstTime = false;
                }
            });

            $('#culture_main_switch1,#culture_main_switch2,#value_switch').on('input change', function () {
                var cur1 = $('#culture_main_switch1').val();
                var cur2 = $('#culture_main_switch2').val();
                var value = $('#value_switch').val();
                var val_to_cur = CoinPaymentsCalculator.check_rate(value,cur1,cur2);
                $('#switch_value').text(val_to_cur+" "+cur2);
                $('#switch_rate1').text(rates_CoinPayments[cur1].rate_btc+' to BTC');
                $('#switch_rate2').text(rates_CoinPayments[cur2].rate_btc+' to BTC');
            });
        },
        firstTime: true,
        check_rate: function (val,cur1,cur2) {
            return (val*rates_CoinPayments[cur1].rate_btc)
                /
                (rates_CoinPayments[cur2].rate_btc);
        }

    };

});


