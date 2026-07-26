   <?php include 'header.php'; ?>


    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">playlist_add_check</i>
                        </div>
                        <div class="content">
                            <div class="text">DIRECTORY</div>
                            <div class="text">
                                <?php
                                $this->db->where('trash','0');
                                $data = $this->db->get('files')->result();

                                echo count($data);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">help</i>
                        </div>
                        <div class="content">
                            <div class="text">SHARE</div>
                            <div class="text">
                                
                                <?php
                                $data = $this->db->get('share')->result();

                                echo count($data);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                                <i class="material-icons">person_add</i>
                        </div>
                        <div class="content">
                            <div class="text">USERS</div>
                    <div class="text">
                           <?php
                                $data = $this->db->get('user')->result();

                                echo count($data);
                                ?>
                    </div>
                            </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">forum</i>
                            
                        </div>
                        <div class="content">
                            <div class="text">TRASH</div>
                            <div class="text">
                               <?php
                                $this->db->where('trash','1');
                                $data = $this->db->get('files')->result();

                                echo count($data);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
          

            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-5 card">

<head>  
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    title:{
        text: "SPACE ON DIRECTORY",
        horizontalAlign: "left"
    },
    data: [{
        type: "doughnut",
        startAngle: 90,
        //innerRadius: 60,
        indexLabelFontSize: 17,
        indexLabel: "{label} - #percent%",
        toolTipContent: "<b>{label}:</b> {y} (#percent%)",
        dataPoints: [
            { y: 5, label: "Available" },
            { y:<?php
                    $this->db->where('type','img');
                   $data = $this->db->get('files')->result();
                   echo count($data); ?>, label: "Images" },
            { y: <?php
                    $this->db->where('type','audio');
                   $data = $this->db->get('files')->result();
                   echo count($data); ?>, label: "Recordings" },
            { y:  <?php
                    $this->db->where('trash','1');
                   $data = $this->db->get('files')->result();
                   echo count($data); ?>, label: "Trash"},
                    { y:  <?php
                    $this->db->where('type','folder');
                   $data = $this->db->get('files')->result();
                   echo count($data); ?>, label: "Folder"},
            { y:  <?php
                    $this->db->where('type','other');
                   $data = $this->db->get('files')->result();
                   echo count($data); ?>, label: "Documents"},
            { y: <?php
                    $this->db->where('type','video');
                   $data = $this->db->get('files')->result();
                   echo count($data); ?>, label: "Video Docments"}
        ]
    }]
});
chart.render();

}
</script>
</head>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>




        </div>
    </section>
<?php include 'footer.php'; ?>
</body>

</html>