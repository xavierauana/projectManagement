<template>
<form :action="action" method="POST" @submit.prevent="createProjectInvoice">
					<legend>Invoice for project: {{projectTitle}}</legend>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="form-label">Client</label>
								<input type="text" class="form-control" disabled
                                       :value="clientName" />
					</div>
						</div>
						<div class="col-sm-6">
						<div class="form-group">
							<label class="form-label">Due Date</label>
								<input type="date"
                                       name="due_date"
                                       class="form-control"
                                       required
                                       :min="minDate"
                                       value="" />
					</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="form-label">Invoice Number</label>
								<input type="text"
                                       name="invoice_number"
                                       class="form-control"
                                       :value="invoiceNumber"
                                       required />
							</div>
						</div>
					</div>
					<fieldset>
						<legend class="">Items</legend>
						<invoice-items
                                :init-items="selectedProducts"
                                :products="products"></invoice-items>
					</fieldset>
					<fieldset>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="internal_note">Internal Note</label>
												<textarea id="internal_note"
                                                          class="form-control"
                                                          name="internal_note"></textarea>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="note">Note</label>
												<textarea id="note"
                                                          class="form-control"
                                                          name="note"></textarea>
											</div>
										</div>
									</div>
								</fieldset>

	<div class="form-group clearfix">
						<a class="btn btn-info btn-sm shadow-sm text-light"
                           :href="backUrl"><i
                                class="fas fa-sm fa-chevron-left"></i> Back</a>
						<button class="btn btn-sm btn-success shadow-sm float-right"
                                type="submit"><i class="fas fa-plus fa-sm"></i>
							Create</button>
					</div>
				</form>
</template>

<script>
	import InvoiceItems from "./InvoiceItems"

    export default {
      name      : "CreateProjectInvoiceForm",
      props     : {
        invoiceNumber   : {
          type   : String,
          default: ""
        },
        backUrl         : {
          type    : String,
          required: true
        },
        action          : {
          type    : String,
          required: true
        },
        clientName      : {
          type    : String,
          required: true
        },
        products        : {
          type    : Array,
          required: true
        },
        minDate         : {
          type    : String,
          required: true
        },
        project         : {
          type    : Object,
          required: true
        },
        selectedProducts: {
          type: Array
        },
      },
      data() {
        return {
          projectTitle: this.project.title
        }
      },
      components: {
        InvoiceItems
      },
      methods   : {
        createProjectInvoice(e) {
          const form = e.target
          axios.post(form.action, new FormData(form))
               .then(response => {
                 alert("New invoice created!")
                 window.location = this.backUrl
               })
               .catch(error => {
                 console.log(error)
                 console.log(error.response)
                 if (error.response.status === 422) {

                   const errors = error.response.data.errors

                   const msg = _.reduce(Object.keys(errors), (carry, key) => {
                     for (let i = 0; i < errors[key].length; i++) {

                       if (/^items.\d+/.test(key)) {
                         const array = key.split('.')
                         const newKwy = `${parseInt(array[1]) + 1} item ${array[2]}`
                         carry = carry + errors[key][i].replace(key, newKwy).replace("_", " ") + "\n"
                       } else {
                         carry = carry + errors[key][i].replace("_", " ") + "\n"
                       }

                     }

                     return carry
                   }, "")

                   alert(msg)
                 }

               })


        }
      }
    }

</script>

<style scoped>

</style>