<?php
/**
* 	Agenda file
*
* 	@ Author		spab
* 	@ Updated date 	08-08-2017
* 	@ Description	CIO CONVEX 2017. cioconvex.mampu.gov.my
*
**/
// Start a session
if (!isset($_SESSION)) {
    session_start();
}


// Require app/init
require_once __DIR__ . '/app/init.php';

if (isset($_GET['y']) && filter_var($_GET['y'], FILTER_VALIDATE_INT)) {
    $year = $_GET['y'];
} else {
    header("Location: index.php");
    exit('404, page not found');
}

?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>CIO Convex 2017 : Agenda</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="vendor/responsiveslides/responsiveslides.css" rel="stylesheet">
        <link href="vendor/responsiveslides/themes/themes.css" rel="stylesheet">
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Navbar -->
        <?php include 'navbar.php'; ?>

        <div class="container-fluid">
            <div class="container download">
                <div class="row">
                    <div class="col-md-12">
                        <h2><?php echo 'Agenda PSCC '.$year; ?></h2><br/>
                        <a href="agenda_pdf.php" target="_blank" class="btn btn-sm btn-primary">Download Agenda</a><br/><br/>
                        <?php
                            $agenda = new Pages\Agenda;
                            $res_agenda = json_decode($agenda->getAgendaDate($year), true);

                            if ($res_agenda) {
                        ?>
                        <div class="process">
                            <div class="process-row nav nav-tabs">
                                <div class="process">
                                    <div class="process-row nav nav-tabs">
                                        <?php if (array_key_exists(0, $res_agenda)) { ?>
                                        <div class="process-step">
                                            <button type="button" class="btn btn-info btn-circle" data-toggle="tab" href="#menu1"><i class="fa fa-calendar fa-3x"></i></button>
                                            <p><small>Day 1</small></p>
                                        </div>
                                        <?php } ?>
                                        <?php if (array_key_exists(1, $res_agenda)) { ?>
                                        <div class="process-step">
                                            <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#menu2"><i class="fa fa-calendar fa-3x"></i></button>
                                            <p><small>Day 2</small></p>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="tab-content tab-agenda">
                                    <?php if (array_key_exists(0, $res_agenda)) { ?>
                                    <div id="menu1" class="tab-pane fade active in">
                                        <h4>
                                            <?php
                                                echo date('l', strtotime($res_agenda[0]['event_date'])) .', '. date('d-m-Y', strtotime($res_agenda[0]['event_date']));
                                            ?>
                                        </h4>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <?php
                                                    $event = new Pages\Agenda;
                                                    $res_event = json_decode($event->getAgenda($res_agenda[0]['event_date']), true);

                                                    foreach ($res_event as $v) {

                                                        $events = new Pages\Agenda;
                                                        $res_events = json_decode($events->getEvent($v['ciosession_id'], $res_agenda[0]['event_date']), true);
                                                        
                                                ?>
                                                        <?php if ($v['ciosession_id'] != 0) { ?>
                                                        <tr>
                                                            <td colspan="2" style="text-align:center;vertical-align:middle;background-color: #7eb8d3;"><?php echo $v['ciosession_name']; ?></td>
                                                        </tr>
                                                        <?php } ?>

                                                    <?php foreach ($res_events as $val) { ?>
                                                <tr>
                                                    <td style="width: 8%;"><?php echo $val['event_time']; ?></td>
                                                    <td><?php echo $val['event_desc']; ?></td>
                                                </tr>
                                                <?php } } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php } ?>
                                    <?php if (array_key_exists(1, $res_agenda)) { ?>
                                    <div id="menu2" class="tab-pane fade">
                                        <h4>
                                            <?php
                                                echo date('l', strtotime($res_agenda[1]['event_date'])) .', '. date('d-m-Y', strtotime($res_agenda[1]['event_date']));
                                            ?>
                                        </h4>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <?php
                                                    $event2 = new Pages\Agenda;
                                                    $res_event2 = json_decode($event2->getAgenda($res_agenda[1]['event_date']), true);

                                                    foreach ($res_event2 as $v) {

                                                        $events2 = new Pages\Agenda;
                                                        $res_events2 = json_decode($events2->getEvent($v['ciosession_id'], $res_agenda[1]['event_date']), true);

                                                ?>
                                                        <?php if ($v['ciosession_id'] != 0) { ?>
                                                        <tr>
                                                            <td colspan="2" style="text-align:center;vertical-align:middle;background-color: #7eb8d3;"><?php echo $v['ciosession_name']; ?></td>
                                                        </tr>
                                                        <?php } ?>

                                                    <?php foreach ($res_events2 as $val) { ?>
                                                <tr>
                                                    <td style="width: 8%;"><?php echo $val['event_time']; ?></td>
                                                    <td><?php echo $val['event_desc']; ?></td>
                                                </tr>
                                                <?php } } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php } else { ?>
                        <h4><?php echo 'The agenda has not been updated.'; ?></h4>
                    <?php } ?>
                    </div>
                </div>
            </div>

            <hr class="featurette-divider">
            <!-- Footer -->
            <?php include 'footer.php'; ?>

        </div>

        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="vendor/responsiveslides/responsiveslides.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
        <script src="assets/js/cioconvex.js"></script>
    </body>
</html>
