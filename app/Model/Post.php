<?php
/**
 * CakePHP PostModel
 * @author Gustavo Cardoso
 */
class Post extends AppModel {
    
    public function isOwnedBy($post, $user) {
        return $this->field('id', array('id' => $post, 'user_id' => $user)) === $post;
    }
}
