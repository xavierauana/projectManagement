<template>
    <div class="mb-3">
        <invoice-item v-for="(item,index) in items"
                      :key="JSON.stringify(item)"
                      :index="index"
                      :selected-item="isItem(item)"
                      :ref-key="getRefKey(item)"
                      :products="products"
                      :show-unit-price="showUnitPrice"
                      v-on:remove-item="removeItem"
                      v-on:update-subtotal="updateSubTotal"
        ></invoice-item>

        <div class="row">
            <div class="col-sm-6 ml-auto text-right">
                <span class="font-weight-bold mr-3">Total:</span><span
                    class=" mr-3">{{total | currency}}</span>
            </div>
        </div>

        <button class="btn btn-primary" type="button" @click.prevent="addItem">Add Item</button>
    </div>
</template>

<script>
    import util from "../utils"
    import InvoiceItem from "./InvoiceItem"

    export default {
      name      : "InvoiceItems",
      components: {
        InvoiceItem
      },
      props     : {
        products           : {
          type    : Array,
          required: true
        },
        initItems          : Array,
        showUnitPrice      : {
          type   : Boolean,
          default: true
        },
        preselectedProducts: {
          type: Array
        }
      },
      data() {
        return {
          items       : this.initItems || [_.random(0, 1000000).toString()],
          itemSubTotal: {},
          total       : 0
        }
      },
      filters   : {
        currency(value) {


          return "$ " + util.formatMoney(value)
        }
      },
      mounted() {
        this.getTotal()
      },
      methods   : {
        isItem(item) {
          return _.isObject(item) ? item : null
        },
        getRefKey(item) {
          return _.isObject(item) ? btoa(JSON.stringify(item)) : item
        },
        getTotal() {
          _.forEach(this.$children, child => this.itemSubTotal[child.$props.refKey] = (child.$data.unit_price * child.$data.quantity))

          this._calculateTotal()
        },
        updateSubTotal(payload) {
          const key = Object.keys(payload)[0]
          this.itemSubTotal[key] = payload[key]
          this._calculateTotal()
        },
        _calculateTotal() {
          this.total = _.reduce(Object.keys(this.itemSubTotal), (carry, key) => {
            carry = carry + this.itemSubTotal[key]
            return carry
          }, 0)
        },
        addItem() {
          this.items.push(_.random(0, 1000000).toString())
        },
        removeItem(key) {
          this.items = _.filter(this.items, k => this.getRefKey(k) !== key)
          delete (this.itemSubTotal[key])
          this._calculateTotal()
        },
      }
    }
</script>

<style scoped>

</style>