import axios from 'axios';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

const ctx = document.getElementById('myChart');

if (ctx) {
    const resolveData = async () => {
        try {
            await axios.get('/sanctum/csrf-cookie')
            const resp = await axios.get('/api/chart/refunds/bymonth');

            let xData = resp.data.expenseReportDates;
            let yData = resp.data.expenseReportTotals;
            let currentYear = resp.data.current_year;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: xData,
                    datasets: [{
                        label: 'Remboursements mensuels de l\'année ' + currentYear,
                        data: yData,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    locale: 'fr-FR',
                    scales: {
                        y: {
                            ticks: {
                                callback: (value, index, values) => {
                                    return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(value);
                                }
                            },
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
            
                                    if (label) {
                                        label += ': ';
                                    }

                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(context.parsed.y);
                                    }

                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        } catch (err) {
            console.error(err);
        }
    };
    
    resolveData();
}
