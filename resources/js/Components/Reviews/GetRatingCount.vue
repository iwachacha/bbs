<script>
  //☆1~5それぞれの合計数を返す counts = [☆1の数, ☆2の数..., ☆5の数]
  export const fulfillmentRatingCount = (fulfillmentRatings) => {
    let counts = []
    for(let i = 1; i <= 5; i++){
      let target = fulfillmentRatings.find((value) => value.fulfillment_rate == i)
      target ? counts.push(target.count) : counts.push(0)
    }
    return counts
  }

  export  const easeRatingCount = (easeRatings) => {
    let counts = []
    for(let i = 1; i <= 5; i++){
      let target = easeRatings.find((value) => value.ease_rate == i)
      target ? counts.push(target.count) : counts.push(0)
    }
    return counts
  }

  export  const satisfactionRatingCount = (satisfactionRatings) => {
    let counts = []
    for(let i = 1; i <= 5; i++){
      let target = satisfactionRatings.find((value) => value.satisfaction_rate == i)
      target ? counts.push(target.count) : counts.push(0)
    }
    return counts
  }
</script>