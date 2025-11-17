<?php
function validateReview($review_rank, $comment_text) {

    if (empty($review_rank)) {
        return "星評価を選択してください。";
    }

    if (trim($comment_text) === "") {
        return "コメントを入力してください。";
    }

    return ""; // エラーなし
}
?>