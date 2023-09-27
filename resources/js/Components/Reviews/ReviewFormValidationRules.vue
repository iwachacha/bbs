<script>
  import { required, maxLength, helpers } from '@vuelidate/validators';
  import { requiredM, maxLengthM } from '@/validationMessage.js';

  export const reviewRules = {
    title: {
      required: helpers.withMessage(requiredM("タイトル"), required),
      maxLengthValue: helpers.withMessage(maxLengthM("タイトル", 50), maxLength(50))
    },
    year: {
      required: helpers.withMessage(requiredM("受講年度"), required),
    },
    fulfillment_rate: {
      required: helpers.withMessage(requiredM("充実度評価"), required),
    },
    ease_rate: {
      required: helpers.withMessage(requiredM("楽単度評価"), required),
    },
    satisfaction_rate: {
      required: helpers.withMessage(requiredM("満足度評価"), required),
    },
    lecture_content: {
      maxLengthValue: helpers.withMessage(maxLengthM("講義内容", 500), maxLength(500))
    },
    good_point: {
      maxLengthValue: helpers.withMessage(maxLengthM("良い点", 500), maxLength(500))
    },
    bad_point: {
      maxLengthValue: helpers.withMessage(maxLengthM("悪い点", 500), maxLength(500))
    },
  };
</script>