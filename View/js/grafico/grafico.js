const ctx = document.getElementById('myChart');
              
                new Chart(ctx, {
                  type: 'bar',
                  data: {
                    labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    datasets: [{
                      label: '# Quantidade de produtos vendidos a cada mês.',
                      data: [8, 15, 23, 35, 37, 28, 21, 33, 26, 20, 37, 36],
                      borderWidth: 1
                    }]
                  },
                  options: {
                    scales: {
                      y: {
                        beginAtZero: true
                      }
                    }
                  }
                });