<?php
class HomePhoto extends AppController{
    protected $uses = array("Activity" ,"Album", "Photo", "Comment", "User", "Follow","Status");

  public function postInHome($entry,$key)
    {
        if($entry){
            $actor  =$entry->data->actor;
            $currentUser    = $this->getCurrentUser();
            $photoRC        = $this->Photo->load($entry->data->object);
            $activityID     = $entry->recordID;
            if($photoRC)
            {
                $photoID    = $photoRC->recordID;
                /*if($currentUser->recordID != $photoRC->data->actor)
                    $userRC = $this->User->findOne('@rid = ? ',array($photoRC->data->actor));
                else*/
                    $userRC = $this->User->findOne('@rid = ? ',array($photoRC->data->owner));
                $commentOfPhotosRC[$photoID]        = $this->Comment->findByCondition("post = ? LIMIT 4 ORDER BY published DESC",array($photoID));
                $numberCommentInPhotosRS[$photoID]  = $this->Comment->count("post = ? ",array($photoID));
                $followRC[$photoID]                 = $this->Follow->findOne("UserA = ? AND UserB = ? AND filterFollow = 'post' AND ID = ? ",array($currentUser->recordID,$actor,$photoID));
                $photoFollow[$photoID]              = ($followRC[$photoID]==null)? 'null':$followRC[$photoID]->data->follow;
                if($commentOfPhotosRC[$photoID])
                {
                    $comments  = $commentOfPhotosRC[$photoID];
                    $pos                = (count($comments)<4 ? count($comments) : 4);
                    for($i = $pos-1;$i>=0;$i--)
                    {
                        $userComment[$comments[$i]->data->actor] = $this->User->load($comments[$i]->data->actor);
                    }
                }
                else
                {
                    $userComment = null;
                }
                $entry = array(
                    'type'          => 'post',
                    'key'           => $key,
                    'actor_name'    =>$userRC->data->firstName . " "  . $userRC->data->lastName,
                    'id'    => $activityID,
                    'commentPhoto'       => $commentOfPhotosRC,
                    'numberComment'=> $numberCommentInPhotosRS,
                    'photoFollow'  => $photoFollow,
                    'actions'       => $photoRC,
                    'actor'         => $photoRC->data->owner,
                    'photo_id'      => $photoID,
                    'otherUser'     => $userRC,
                    'userComment'   => $userComment,
                    'path'          => '/photo/views/default/'
                );
                return $entry;

            }
        }
    }


   /* public function postInHome($entry,$key)
    {
        if($entry){
            $photo      = $this->Photo->load($entry->data->object);
            $actor      = $this->User->load($entry->data->actor);
            $photo_id   = $photo->recordID;
            $activityID = $entry->recordID;
            $profileID  = F3::get('profileID');
            $commentsOfPhoto[$photo_id]         = $this->Comment->findByCondition("post = ? LIMIT 4 ORDER BY published DESC", array($photo_id));
            $numberOfCommentsPhoto[$photo_id]   = $this->Comment->count("post = ?", array($photo_id));
            $getStatusPhotoFollow[$photo_id]    = $this->Follow->findOne("userA = ? AND userB = ? AND filterFollow = 'photo' AND ID = ?", array($profileID, $entry->data->actor,$photo_id));
            $photoFollow[$photo_id]             = ($getStatusPhotoFollow[$photo_id] == null) ? 'null' : $getStatusPhotoFollow[$photo_id]->data->follow;
            $entry      = array(
                'type'          =>'photo',
                'key'           => $key,
                'id'            => $activityID,
                "action"        => $photo,
                "actor_name"    => $actor->data->firstName . " "  . $actor->data->lastName,
                "photo_id"      => $photo_id,
                "actor_id"      => $photo->data->owner,
                "photoFollow"   => $photoFollow,
                "commentPhoto"  => $commentsOfPhoto,
                "numberComment" => $numberOfCommentsPhoto,
                'path'          => Register::getPathModule('photo'),
            );
            return $entry;
        }
    }*/

    public function moreInHome($entry,$key)
    {
        if($entry){
            $activityID = $entry->recordID;
            $photo      = $this->Photo->load($entry->data->object);
            $actor      = $this->User->load($entry->data->actor);
            $photo_id   = $photo->recordID;
            $profileID  = F3::get('profileID');
            $commentsOfPhoto[$photo_id]         = $this->Comment->findByCondition("post = ? LIMIT 4 ORDER BY published DESC", array($photo_id));
            $numberOfCommentsPhoto[$photo_id]   = $this->Comment->count("post = ?", array($photo_id));
            //get photo follow
            $getStatusPhotoFollow[$photo_id]    = $this->Follow->findOne("userA = ? AND userB = ? AND filterFollow = 'photo' AND ID = ?", array($profileID, $entry->data->actor,$photo_id));
            $photoFollow[$photo_id]             = ($getStatusPhotoFollow[$photo_id] == null) ? 'null' : $getStatusPhotoFollow[$photo_id]->data->follow;
            $entry = array(
                'type'          =>'photo',
                'key'           =>$key,
                'id'            => $activityID,
                "action"        => $photo,
                "actor_name"    => $actor->data->firstName . " "  . $actor->data->lastName,
                "photo_id"      => $photo_id,
                "actor_id"      => $photo->data->owner,
                "photoFollow"   => $photoFollow,
                "commentPhoto"  =>$commentsOfPhoto,
                "numberComment" => $numberOfCommentsPhoto
            );
            return $entry;
        }
    }


}
?>
