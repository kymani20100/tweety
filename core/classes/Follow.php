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
                     echo "<button class='f-btn following-btn follow-btn' data-follow='".$profileID."'><i class='fa fa-user-plus'></i> Follow</button>";
                }
            }else{
                // Edit btn
                echo "<button class='f-btn' onclick=location.href='profileEdit.php'><i class='fa fa-edit'></i> Edit Profile</button>";
            }
        }else{
            echo "<button class='f-btn' onclick=location.href='index.php'><i class='fa fa-user-plus'></i> Follow</button>";
        }
     }
}

?>