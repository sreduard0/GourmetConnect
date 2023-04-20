/* global Chart:false */

$(function () {
    'use strict'

    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //-------------
    // - AREAS DE ENTREGA -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    $.get(window.location.origin + "/administrator/get/control-panel/chart/areas-with-more-delivery", function (data) {
        var pieData = {
            labels: data.labels,
            datasets: [
                {
                    data: data.data,
                    backgroundColor: data.colors
                }
            ]
        }
        var pieOptions = {
            legend: {
                display: true,
                position: 'right'
            }
        }
        // Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        // eslint-disable-next-line no-unused-vars
        var pieChart = new Chart(pieChartCanvas, {
            type: 'doughnut',
            data: pieData,
            options: pieOptions
        })
    });

    //-----------------
    // - VENDAS -
    //-----------------
    var theme = '#000'
    const body = document.querySelector('body')
    body.classList.forEach(className => {
        if (className.startsWith('dark-mode')) {
            theme = '#fff'
        }
    });
    var ticksStyle = {
        fontColor: theme,
        fontStyle: 'bold'
    }

    var mode = 'index'
    var intersect = false


    var $sales = $('#sale-chart')
    $.get(window.location.origin + '/administrator/get/control-panel/chart/monthly-sales-chart', function (response) {
        var sales = new Chart($sales, {

            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                datasets: response
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    mode: mode,
                    intersect: intersect
                },
                hover: {
                    mode: mode,
                    intersect: intersect
                },
                legend: {
                    display: true,
                    position: 'bottom',
                },
                scales: {
                    yAxes: [{
                        // display: false,
                        gridLines: {
                            display: true,
                            lineWidth: '4px',
                            color: 'rgba(0, 0, 0, .2)',
                            zeroLineColor: 'rgba(0, 0, 0, .1)'
                        },
                        ticks: $.extend({
                            beginAtZero: true,
                            suggestedMax: 100
                        }, ticksStyle)
                    }],
                    xAxes: [{
                        display: true,
                        gridLines: {
                            display: false
                        },
                        ticks: ticksStyle
                    }]
                }
            }
        })
    });

})
