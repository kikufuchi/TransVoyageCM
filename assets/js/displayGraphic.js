document.addEventListener('DOMContentLoaded', () => {

    let graph = document.getElementById('caChart').getContext('2d');

    const labels = JSON.parse(document.getElementById('labels').value);
    const values = JSON.parse(document.getElementById('values').value);
    const colors = [
        '#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1', '#fd7e14', '#20c997'
    ];

    new Chart(graph,{
      type : 'bar',
      data : {
        labels : labels,
        datasets : [{
            label : "Chiffre d'affaires (FCFA)",
            data : values,
            backgroundColor : colors.splice(0,labels.length),
            borderWidth: 1,
            borderRadius: 4
         }
        ]
      },
      option : {
        responsive : true,
        maintainApecRatio : true,
        plugins : {
            legend : {display : true},
            tooltip : {
                callbacks : {
                    label : function(context){
                        return context.parsed.y.toLocalString() + ' FCFA';
                    }
                }
            }
        } 
      }
    });
    console.log(values);
    console.log(labels);

})