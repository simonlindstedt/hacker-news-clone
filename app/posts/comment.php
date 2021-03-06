<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (userLoggedIn() && isset($_POST['post_id'])) {
    $userId = (int)filter_var($_SESSION['user']['id'], FILTER_SANITIZE_NUMBER_INT);
    $postId = (int)filter_var($_POST['post_id'], FILTER_SANITIZE_NUMBER_INT);

    if (isset($_POST['comment_id'])) {
        $commentId = (int)filter_var($_POST['comment_id'], FILTER_SANITIZE_NUMBER_INT);
    }

    if (isset($_POST['comment'])) {
        $comment = trim(filter_var($_POST['comment'], FILTER_SANITIZE_STRING));
        if (empty($comment)) {
            addMessage('Comment can not be empty');
            header("location: /../../view.php?view=post&post_id=$postId");
            exit;
        }
        addComment($userId, $postId, $comment, $db);
    }

    if (isset($_POST['edited_comment'])) {
        $editedComment = trim(filter_var($_POST['edited_comment'], FILTER_SANITIZE_STRING));
        if (empty($editedComment)) {
            addMessage('Comment can not be empty');
            header("location: /../../edit.php?edit=comment&comment_id=$commentId");
            exit;
        }
        editComment($userId, $commentId, $editedComment, $db);
        addMessage('Comment edited');
        header("location: /../../view.php?view=post&post_id=$postId");
        exit;
    }

    if (isset($_POST['reply'])) {
        $replyTo = $commentId;
        $reply = trim(filter_var($_POST['reply'], FILTER_SANITIZE_STRING));
        if (empty($reply)) {
            addMessage('Reply can not be empty');
            header("location: /../../view.php?view=post&post_id=$postId");
            exit;
        }
        addReply($userId, $postId, $replyTo, $reply, $db);
        header("location: /../../view.php?view=post&post_id=$postId");
        exit;
    }

    if (isset($_POST['delete'])) {
        deleteComment($userId, $commentId, $db);
        addMessage('Comment deleted');
    }
} else {
    header("location: /../../profile.php");
    addMessage('Incorrect URL');
    exit;
}

header("location: /../../view.php?view=post&post_id=$postId");
