<template>
    <div class="row mb-2">
		<input type="hidden" :name="`items[${index}][product_type]`"
               value='App\Product' />
		<div class="col-sm-6">
			<div class="form-group">
				<select class="form-control" v-model="product_id"
                        :name="`items[${index}][product_id]`" required>
					<option :value="null">Select Product</option>
					<option v-for="product in products" :value="product.id"
                            :key="product.id" v-text="product.name"></option>
				</select>
			</div>
		</div>
		<div class="col" v-if="showUnitPrice">
			<div class="form-group">
				<input type="number" v-model='unit_price'
                       class="form-control"
                       min="0"
                       :name="`items[${index}][unit_price]`"
                       step="0.01"
                       placeholder="Unit Price" required />
			</div>
		</div>
		<div class="col">
			<div class="form-group mr-4">
				<input type="number" v-model='quantity'
                       class="form-control"
                       min="0"
                       :name="`items[${index}][quantity]`"
                       placeholder="Quantity" required />
				<button type="button"
                        @click.prevnet='$emit("remove-item",refKey)'
                        class="btn btn-sm btn-circle btn-danger position-absolute"
                        style="right: 0; top: 4px;"><i
                        class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="border-bottom-primary w-100 mx-2 mb-2"></div>
	</div>

</template>

<script>
export default {
  name : "InvoiceItem",
  props: {
    showUnitPrice: {
      type   : Boolean,
      default: true
    },
    index        : {
      type    : Number,
      required: true
    },
    selectedItem : {
      type: Object
    },
    refKey       : {
      type    : String,
      required: true
    },
    products     : {
      type: Array,
      default() {return []}
    },
  },
  data() {
    return {
      product_id: this.selectedItem ? this.selectedItem.product_id : null,
      unit_price: this.selectedItem ? this.selectedItem.unit_price : null,
      quantity  : this.selectedItem ? this.selectedItem.quantity : null,
    }
  },
  watch: {
    product_id(new_product_id) {
      this.unit_price = _.find(this.products, {id: new_product_id}).price
    },
    unit_price(new_unit_price) {
      this.$emit('update-subtotal', {[this.refKey]: (this.unit_price * this.quantity)})
    },
    quantity(new_quantity) {
      this.$emit('update-subtotal', {[this.refKey]: (this.unit_price * this.quantity)})
    },
  }
}
</script>