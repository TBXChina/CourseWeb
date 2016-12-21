<?php
    include_once "include/common/user.php";
    include_once "include/common/log.php";
    include_once "include/common/web.php";
    include_once "include/service/session_service.php";
    include_once "include/module/homework_list_module.php";
    include_once "include/service/download_service.php";
    include_once "include/module/assignments_module.php";

    /*
    $sessionService = new SessionService(Web::GetCurrentPage());
    $sessionService->Run();
    //if login, get user
    $user = $sessionService::GetLegalUser();
    if ( is_null($user) ) {
        Web::Jump2Web(Web::GetLoginPage());
    }
    */
    $user = UserFactory::Create("admin", 0);
    $user->SetName("testAdmin");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Console</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Probability Theory Submission System"/>

    <!-- stylesheets -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href="css/TW.css" rel="stylesheet" type='text/css'>
    <link href="css/OS.css" rel='stylesheet' type='text/css'>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/font_icon/css/pe-icon-7-stroke.css" rel="stylesheet"  type='text/css'/>
    <link href="css/font_icon/css/helper.css" rel="stylesheet" type='text/css'/>

    <!-- button style-->
    <link href="css/button.css" rel='stylesheet' type='text/css'>

    <!--webfonts-->
    <link href='css/googleapis.css' rel='stylesheet' type='text/css'>
    <link href='css/italic.css' rel='stylesheet' type='text/css'>

    <!--//webfonts-->
    <link href="css/about.css" rel='stylesheet' type='text/css' />
    <link href="css/style_about.css" rel='stylesheet' type='text/css' />

    <!-- scripts -->
    <script src="js/jquery-2.1.3.min.js" type="text/javascript"></script>
    <script src="js/addClassRoot.js" type="text/javascript"></script>
    <script src="js/ajax.js" type="text/javascript"></script>
    <script src="js/slow_move.js" type="text/javascript"></script>
</head>

<body>
    <div class="header">
        <div class="container">
            <div class="header-logo">
                <h1><a href="<?php Log::RawEcho(Web::GetLoginPage()); ?>">Visg</a></h1>
            </div>
            <div class="top-nav">
                <ul class="nav1">
                    <span><a href="<?php Log::RawEcho(Web::GetLoginPage()); ?>" class="house"> </a></span>
                    <li><a href="#distribute" id="askDistribute">DISTRIBUTE</a></li>
                    <li><a href="#addnews" id="askAddnews">ADDNEWS</a></li>
                    <li><a href="#export"  id="askExport">EXPORT</a></li>
                    <li><a href="#assignments" id="askAssignments">ASSIGNMENTS</a></li>
                    <li><a href="#extra" id="askExtra">EXTRA</a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="single">
        <div class="container">
            <div class="col-md-8 single-main">
                <div class="single-grid">
                    <img src="images/6.jpg" alt="cover image"/>
                </div>
                <ul class="comment-list comment-border"  id="distribute">
                    <h3 class="post-author_head">Distribute Assignment</h3>
                    <li>
                        <div class="desc">
                            <?php
                                include_once "include/module/distribute_module.php";
                                include_once "include/service/upload_service.php";
                                Log::RawEcho("<!-- Distribute Module -->\n");
                                //start up upload service
                                $saveDir = Configure::$ASSIGNMENTDIR;
                                $uploadService = new UploadService(DistributeModule::GetUploadButton(),
    DistributeModule::GetFileName(),
    DistributeModule::GetSaveFileName(),
    $saveDir);
                                if ( $uploadService->Run() ) {
                                    Log::Echo2Web("<p>Upload success</p>");
                                }
                                //display the form
                                $distributeModule = new DistributeModule(28);
                                $distributeModule->Display();

                            ?>

                            <div class = "man-info">
                                <?php
                                    include_once "include/module/notices_module.php";
                                    Log::RawEcho("<!-- Notices -->\n");
                                    $noticesModule = new NoticesModule(32);
                                    $noticesModule->Display();
                                ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </li>
                </ul>

                <ul class="comment-list comment-border"  id="addnews">
                    <h3 class="post-author_head">Add News in Login Page</h3>
                    <li>
                        <?php
                            include_once "include/module/add_news_module.php";
                            include_once "include/service/add_news_service.php";
                            Log::RawEcho("<!-- Add News Module -->\n");
                            $newsTextRows = 5;
                            $newsTextCols = 60;
                            $addNewsModule = new AddNewsModule(24, $newsTextRows, $newsTextCols);
                            $addNewsModule->Display();

                            //start up add news service
                            $addNewsService = new AddNewsService(AddNewsModule::GetAddButton(),
                                                                 AddNewsModule::GetNewsText());
                            $rs = $addNewsService->Run();
                            if ( !is_null($rs) ) {
                                if ( true == $rs ) {
                                    Log::Echo2Web("<p>Add News Success</p>");
                                } else {
                                    Log::Echo2Web("<p>Add News Fail</p>");
                                }
                            }
                        ?>
                    </li>
                </ul>

                <ul class="comment-list comment-border" id="export">
                    <h3 class="post-author_head">Export Submitted Homework</h3>
                    <li>
                        <div class="desc">
                            <?php
                                include_once "include/module/export_homework_module.php";
                                Log::RawEcho("<!-- Export Module -->\n");
                                $exportHomeworkModule = new ExportHomeworkModule(28);
                                $exportHomeworkModule->Display();
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </li>
                </ul>

                <ul class="comment-list comment-border"  id="assignments">
                    <h3>Assignments</h3><br/>
                    <div>
                        <?php
                            include_once "include/module/assignments_module.php";
                            Log::RawEcho("<!-- Assignments Module -->\n");
                            $assignmentDir = Configure::$ASSIGNMENTDIR;
                            $assignmentsModule = new AssignmentsModule(24, $assignmentDir, $user);
                            $assignmentsModule->Display();
                        ?>
                    </div>
                </ul>

                <ul class="comment-list comment-extra"  id="extra">
                    <?php
                        include_once "include/module/user_manager_module.php";
                        Log::RawEcho("<!-- user manager module -->\n");
                        $userManageModule = new UserManagerModule(20, $user);
                        $userManageModule->Display();
                    ?>
                </ul>
            </div><!-- col-md-8 single-main -->
            <!-- left part end -->

            <!-- right part start -->
            <div class="col-md-4 side-content">
                <div class="recent">
                    <?php
                        include_once "include/module/user_console_module.php";
                        Log::RawEcho("<!-- user console module -->\n");
                        $userConsoleModule = new UserConsoleModule(20, $user);
                        $userConsoleModule->Display();
                    ?>
                </div>

                <div class="archives">
                    <h3 style="color:#2ad2c9;font-size: 25pt;">Recent News</h3>
                    <?php
                        include_once "include/module/recent_news_module.php";
                        Log::RawEcho("<!-- recent news module -->\n");
                        $recentNewsModule = new RecentNewsModule(20);
                        $recentNewsModule->Display();
                    ?>
                </div>
            </div>
            <div class="clearfix"></div>
            <!-- right part end -->
        </div>
    </div>

    <!--footer-starts-->
    <div class="footer">
        <div class="container">
            <div class="footer-text">
                <div class="col-md-6 footer-left">
                    <p>Copyright &copy; 2016.Visg All rights reserved.</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!--footer-end-->
</body>
</html>