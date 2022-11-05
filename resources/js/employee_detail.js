const employee_no = document.getElementById('employee_no');

const orange = 'rgba(246, 173, 85, 1)';
const gray = 'rgb(99, 99, 99)';
const red = 'rgb(229, 48, 110)';

window.onload = function () {
    customer_working_time_chart();
}

function customer_working_time_chart(){
    CustomerWoringTimeChart = null;
    // 環境でパスを可変させる
    if(process.env.MIX_APP_ENV === 'local'){
        var ajax_url = '/customer_working_time_get_ajax';
    }
    if(process.env.MIX_APP_ENV === 'pro'){
        var ajax_url = '/touch/customer_working_time_get_ajax';
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },    
        url: ajax_url,
        type: 'POST',
        data: { 
            "employee_no" : employee_no.innerHTML
        },
        dataType: 'json',
        success: function(data){
            // チャートを表示
            let Context = document.querySelector("#customer_working_time_chart").getContext('2d');
            // 前回のチャートを破棄
            if (CustomerWoringTimeChart != null) {
                CustomerWoringTimeChart.destroy();
            }
            CustomerWoringTimeChart = new Chart(Context, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        // 
                        data: [data['first']['total_customer_working_time'], data['second']['total_customer_working_time'], data['third']['total_customer_working_time']],
                        backgroundColor: [orange, gray, red],
                        label: [data['first']['customer_name'], data['second']['customer_name'], data['third']['customer_name']]
                    }],
                },
                options: {
                    responsive: false,
                    title: {
                    },
                    tooltips: {
                        bodyFontSize  : 12,
                        bodyAlign : "right",
                        bodyFontColor : "black",
                        borderColor: 'black',
                        borderWidth: 1,
                        backgroundColor: 'white',
                        cornerRadius: "0",
                        xPadding: 10,
                        yPadding: 10,
                        callbacks: {
                            label: function(tooltipItem, data){
                                return data.datasets[0]['label'][tooltipItem.index] + "   " + (data.datasets[0]['data'][tooltipItem.index] / 60 ).toFixed(2) + '時間';
                            }
                        }
                    }
                }
            })
        },
        error: function(){
            alert('失敗');
        }
    });
}