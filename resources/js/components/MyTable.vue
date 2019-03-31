<script>
    export default {
      name   : 'MyTable',
      data() {
        return {
          busy: false
        }
      },
      methods: {
        removeItem(id, title) {
          this.busy = true
          if (confirm("Are you sure to delete " + title + "?")) {
            const uri = window.location.pathname + `/${id}`
            axios.delete(uri)
                 .then(() => {
                   window.location.reload()
                   this.busy = false
                 })
                 .catch(error => {
                   console.log(error.response)
                   this.busy = false
                 })
          } else {
            this.busy = false
          }
        }
      }
    }
</script>
