/* global Chart:false */

$(function () {
    'use strict'

    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //-------------
    // - PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData = {
        labels: [
            'Caju - Até cajuense',
            'Caju - Até depois cajuence',
            'Berto cirio - Até ferragem',
            'Morretes - Ate os trilos',
            'Morretes - la ',
            'Sanga funda - Todo bairro'
        ],
        datasets: [
            {
                data: [700, 500, 400, 600, 300, 100],
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de']
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
    var sales = new Chart($sales, {
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            datasets: [{
                type: 'line',
                data: [100, 120, 170, 167, 180, 177, 160],
                backgroundColor: 'transparent',
                borderColor: '#007bff',
                pointBorderColor: '#007bff',
                pointBackgroundColor: '#007bff',
                fill: false,
                label: 'Teste',
            }
            ]
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
                        suggestedMax: 350
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
})
