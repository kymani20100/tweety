<?php
class Follow extends User {
    
     function __construct($pdo){
        $this->pdo = $pdo;
     }

     public function checkFollow($followerID, $user_id){
        $stmt = $this->pdo->prepare("SELECT * FROM `follow` WHERE `sender` = :user_id AND `receiver` = :followerID");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":followerID", $followerID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     public function followBtn($profileID, $user_id){
        $data = $this->checkFollow($profileID, $user_id);
        if($this->loggedIn() === true){
            if($profileID != $user_id){
                if($data['receiver'] == $profileID){
                    // Following btn
                    echo "<button class='f-btn following-btn follow-btn' data-follow='".$profileID."'><i class='fa fa-rss'></i> Following</button>";
                }else{
                    // Follow btn
                     echo "<button class='f-btn follow-btn' data-follow='".$profileID."'><i class='fa fa-rss'></i> Follow</button>";
                }
            }else{
                // Edit btn
                echo "<button class='f-btn' onclick=location.href='profileEdit.php'><i class='fa fa-edit'></i> Edit Profile</button>";
            }
        }else{
            echo "<button class='f-btn' onclick=location.href='index.php'><i class='fa fa-user-plus'></i> Follow</button>";
        }
     }

     public function follow($followID, $user_id){
        $this->create('follow', array('sender' => $user_id, 'receiver' => $followID, 'followOn' => date("Y:M:D H:i:s")));
        $this->addFollowCount($followID, $user_id);
        $stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `user_id` = :followID');
        $stmt->execute(array("followID" => $followID));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($data);
     }

      public function unfollow($followID, $user_id){
        $this->delete('follow', array('sender' => $user_id, 'receiver' => $followID));
        $this->removeFollowCount($followID, $user_id);
        $stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `user_id` = :followID');
        $stmt->execute(array("followID" => $followID));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($data);
     }

     public function addFollowCount($followID, $user_id){
        $stmt = $this->pdo->prepare("UPDATE `users` SET `following` = `following` + 1 WHERE `user_id` = :user_id; UPDATE `users` SET `followers` = `followers` + 1 WHERE `user_id` = :followID");
        $stmt->execute(array("user_id" => $user_id, "followID" => $followID));
     }

     public function removeFollowCount($followID, $user_id){
        $stmt = $this->pdo->prepare("UPDATE `users` SET `following` = `following` - 1 WHERE `user_id` = :user_id; UPDATE `users` SET `followers` = `followers` - 1 WHERE `user_id` = :followID");
        $stmt->execute(array("user_id" => $user_id, "followID" => $followID));
     }

}

?>