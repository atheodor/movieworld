<template>
  <div class="main-container">
    <h2>Movie World</h2>
    <button @click="counter++">Click me {{ counter }}</button>
  </div>
</template>

<script>
  export default {
    data: () => ({
      counter: 0
    })
  }
</script>