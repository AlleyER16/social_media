<?php

    require_once "classes/Users.class.php";

    $users_obj = new Users();

    $num_friend_requests = $users_obj->get_num_friend_requests($__user_details["UserID"]);

    $friend_requests = $users_obj->get_friend_requests($__user_details["UserID"]);

?>
<div class="friendrequest w3-margin-top">
    <div class="col-md-12">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Friend Request <span class="badge" id="__num_fr"><?= $num_friend_requests ?></span></div>
                <div class="panel-body">
                    <?php

                        if(count($friend_requests) >= 1){

                            foreach ($friend_requests as $user) {

                                $user_details = $users_obj->user_exists("UserID", $user["RequestedBy"])[1];

                                if($user_details["ProfilePicture"] == NULL){

                                    $user_details["ProfilePicture"] = ($user_details["Gender"] == "Male") ? "assets/images/img_avatar.png" : "assets/images/img_avatar2.png";

                                }else{

                                    $user_details["ProfilePicture"] = "users/".$user_details["UserID"]."/".$user_details["ProfilePicture"];

                                }

                                ?>
                                <div class="row w3-margin-bottom" id="fr__<?= $user_details["UserID"] ?>">
                                    <div class="col-md-3 col-sm-3 col-xs-4">
                                        <img src="<?= $user_details["ProfilePicture"] ?>" class="img-rounded" style="width: 100px; height: 100px"/>
                                    </div>
                                    <div class="col-md-9 col-sm-9 col-xs-8" style="padding-top: 10px;">
                                        <b><?= $user_details["FullName"] ?></b><br/>
                                        <span>@<?= $user_details["Username"] ?></span>
                                        <div class="row">
                                            <div class="col-xs-6" type="accept_request">
                                                <form class="accept_friend_request">
                                                    <input type="hidden" name="user_id" value="<?= $user_details["UserID"] ?>"/>
                                                    <button type="submit" class="btn btn-sm btn-success">ACCEPT</button>
                                                </form>
                                            </div>
                                            <div class="col-xs-6" type="decline_request">
                                                <form class="decline_friend_request">
                                                    <input type="hidden" name="user_id" value="<?= $user_details["UserID"] ?>"/>
                                                    <button type="submit" class="btn btn-sm btn-danger">DECLINE</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php

                            }

                        }else{

                            ?>
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    You have no friend requests
                                </div>
                            </div>
                            <?php

                        }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
