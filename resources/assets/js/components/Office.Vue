<template>
<div>
			<div class="office">
			<center>
			<div style="height:80px; width:250px; overflow-y:auto;">
				<h4>Office, {{'#' + this.id}}, {{this.name}}</h4>
			</div>	
				<span id="onStore" v-if="!storeOn">
			 <span style="color:#ddd; margin:7px;">Offline</span><button style="background:green;" @click="onStore()">Go Online</button>
			 </span>
			 
			 <span id="offStore" class="" v-if="storeOn">
			 <button style="background:red; color:#fff" @click="offStore()">Go Offline</button><span style="color:#ddd; margin:7px;">online</span>
			 </span>
				
			</center>
			
			</div>
			
			<div class="products" v-if="loadProducts">
			<span v-for="product in this.products">
			<product :id="product.id" :name="product.name" :description="product.description" :status="product.status" :store="this.id" :category="product.category_id" :image="product.image"></product>
			</span>
			</div>
	
</div>


</template>


<script>

export default {

props:['id', 'name', 'online'],

mounted() {
if (this.online==0) {

this.storeOn= false

}
this.getAuthDetails()
this.getStoreProducts()
setTimeout(this.startLoadingProducts, 5000)


},

data() {

return {

authDetails: [],
products: [],
storeOn: true,
loadProducts: false,




}


},


methods: {

startLoadingProducts() {

this.loadProducts=true

},

onStore() {

this.storeOn = true


axios.get('/on/store/' + this.id ).then(response=>{
		
		
	})
	
},

offStore() {

this.storeOn = false

axios.get('/off/store/' + this.id ).then(response=>{
		
		
	})		
	
},


getAuthDetails(){
	
	axios.get('/auth/details/').then(response=>{
		
		this.authDetails.push(response.data)
	})
	
},

getStoreProducts(){
	
	axios.get('/products/store/' + this.id).then(response=>{
		response.data.forEach((product)=> {
		this.products.push(product)
		})
	})
	
},

showProductPrice() {
	
var product = document.getElementById('product-price')

product.classList.remove('hidden')	
},

hideProductPrice() {
	
var product = document.getElementById('product-price')

product.classList.add('hidden')
		
	
},



}

}


</script>