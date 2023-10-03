<script>
  export const getReviewContent = (reviews, targetId) => {
    let targetReview = reviews.find((review) => review.id == targetId)
    return [
      {key: 'タイトル', value: targetReview.title},
      {key: '受講年度', value: targetReview.year},
      {key: '充実度評価', value: '☆ ' + targetReview.fulfillment_rate},
      {key: '楽単度評価', value: '☆ ' + targetReview.ease_rate},
      {key: '満足度評価', value: '☆ ' + targetReview.satisfaction_rate},
      {key: '講義内容', value: (targetReview.lecture_content) ? targetReview.lecture_content : 'なし'},
      {key: '良い点', value: (targetReview.good_point) ? targetReview.good_point : 'なし'},
      {key: '悪い点', value: (targetReview.bad_point) ? targetReview.bad_point : 'なし'},
    ]
  }
</script>