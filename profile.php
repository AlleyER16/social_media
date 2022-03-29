<?php

    require_once "includes/__auth_check.php";

    $__page = $_GET["page"] ?? "fr";

?>
<!DOCTYPE html>
<html>
    <head>
    	 <title>Social Media -> <?= $__user_details["FullName"] ?></title>

        <?php require_once "includes/meta.php" ?>

        <?php require_once "includes/resources.php" ?>
    </head>
    <body>

        <nav class="custom_navbar">
            <?php require_once "views/navbar.php" ?>
        </nav>

        <nav class="mobile_navbar">
            <?php require_once "views/mobile_navbar.php" ?>
        </nav>

        <nav class="mobile_menu">
            <?php require_once "views/mobile_menu.php" ?>
        </nav>

        <?php require_once "views/feedback_divs.php" ?>

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-2 w3-padding-top left_bar">
                    <?php require_once "views/left_sidebar.php" ?>
                </div>

                <div class="col-md-2 left_fill"></div>

                <div class="col-md-5 col-sm-8 w3-padding-top main_content">

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <img src="<?= $__user_details["CoverPhoto"] ?>" class="img-rounded" style="width: 100%;"/>
                        </div>
                    </div>

                    <div class="row w3-margin-bottom">
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <img src="<?= $__user_details["ProfilePicture"] ?>" class="img-rounded" style="width: 100%; margin-top: -55px;"/>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8">
                            <h3><?= $__user_details["FullName"] ?></h3>
                            <div class="row">
                                <div class="col-md-12 w3-padding-bottom">
                                    <span class="w3-text-amber">@<?= $__user_details["Username"] ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6"><button class="btn btn-default btn-block">10 Posts</button></div>
                                <div class="col-md-6 col-sm-6 col-xs-6"><button class="btn btn-default btn-block">10 Friends</button></div>
                            </div>
                        </div>
                    </div>

                    <div class="row w3-padding">
                        <form id="create_post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <?= $__user_details["FullName"] ?> <span class="w3-text-amber">@<?= $__user_details["Username"] ?></span>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-2 col-sm-2 col-xs-3">
                                        <img src="<?= $__user_details["ProfilePicture"] ?>" class="img-circle" style="width: 50px; height: 50px;"/>
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-9 w3-padding-top">
                                        <textarea class="custom_text_area" name="post_body">What is on your Mind?</textarea>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <button type="submit" class="btn btn-success">Upload Post</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="btn-group btn-group-justified w3-margin-bottom">
                        <a href="profile.php?page=posts" class="btn btn-success">Posts</a>
                        <a href="profile.php?page=friends" class="btn btn-success">Friends</a>
                    </div>

                    <?php

                        if($__page == "posts"){

                            ?>
                            <div id="friend_requests">
                                <?php require_once "views/my_posts.php" ?>
                            </div>
                            <?php

                        }else if($__page == "friends"){

                            ?>
                            <div id="friend_requests_sent">
                                <?php require_once "views/friends.php" ?>
                            </div>
                            <?php

                        }

                    ?>

                </div>

                <div id="chatlist" class="col-md-2 col-sm-4 w3-padding-top w3-border-left w3-light-grey w3-padding-bottom chat_section">
                    <?php require_once "views/chat_list.php" ?>
                </div>

            </div>

        </div>

        <script type="text/javascript" src="controller/components_refresh.js"></script>

        <script type="text/javascript">

            setInterval(chatlist_refresh, 500);

            setInterval(friend_requests_count_refresh, 500);

            setInterval(num_unread_chat_refresh, 500);

        </script>

        <script type="text/javascript" src="controller/post_creating.js"></script>
	</body>
</html>
