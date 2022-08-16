<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/super-build/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.js"></script>
<script src="https://kit.fontawesome.com/9ccbf79087.js" crossorigin="anonymous"></script>
<script src="../js/ckeditor.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script>
    const data = {
        labels: [
            'ผู้ใช้งาน',
            'กระทู้ทั้งหมด',
            'หมวดหมู่',
            'ความคิดเห็น',
        ],
        datasets: [{
            label: 'ข้อมูล KaTooTip',
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
                'rgb(100, 255, 0)'
            ],
            borderColor: 'rgb(224, 224, 224)',
            data: [<?php echo $count_u ?>, <?php echo $count_bm ?>, <?php echo $count_tag ?>, <?php echo $count_bs ?>],
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };
</script>

<script>
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>

<script>
    $(document).ready(function() {
        $('#TagTable').DataTable();
    });
</script>

<script>
    $(document).ready(function() {
        $('#MemberTable').DataTable();
    });
</script>