<script>
  export const getCategoryName = (categories, targetId) => {
    let targetCategory = categories.find(e => e.id == targetId)
    return targetCategory ? targetCategory.name : null
  }

  export const getFacultyName = (faculties, targetId) => {
    let targetFaculty = faculties.find(e => e.id == targetId)
    return targetFaculty ? targetFaculty.name : null
  }

  export const getDepartmentName = (departments, targetId) => {
    let targetDepartment = departments.find(e => e.id == targetId)
    return targetDepartment ? targetDepartment.name : null
  }

  export const getCourseName = (courses, targetId) => {
    let targetCourse = courses.find(e => e.id == targetId)
    return targetCourse ? targetCourse.name : null
  }
</script>