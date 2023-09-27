<script>
  import { required, maxLength, helpers } from '@vuelidate/validators';
  import { requiredM, maxLengthM } from '@/validationMessage.js';

  export const lectureRules = {
    lecture_name: {
      required: helpers.withMessage(requiredM("講義名"), required),
      maxLengthValue: helpers.withMessage(maxLengthM("講義名", 30), maxLength(30))
    },
    professor_name: {
      required: helpers.withMessage(requiredM("担当教員名"), required),
      maxLengthValue: helpers.withMessage(maxLengthM("担当教員名", 30), maxLength(30))
    },
    lecture_category_id: {
      required: helpers.withMessage(requiredM("講義区分"), required),
    },
    season: {
      required: helpers.withMessage(requiredM("開講時期"), required),
    }
  };
</script>