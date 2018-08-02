<template>
<div class="seller-product-container">

			<!-- Begin Office Product Class -->

		<div class="seller-products">
		
		<img v-if="this.image" :src="this.image" height="150px" width="200px"  alt="" />
		
			<p>{{this.name}}</p>
			<span>{{this.description}}</span>
			 
			 <p class="grey-button" @click="showProductPrice()">Price Menu</p>
		
		<!--begin product details-->
		<div class="product-details">
			
			<span id="onproduct" v-if="!available">
			 <span style="color:#ddd; margin:7px;">off</span><button style="background:green;" @click="onProduct()">On</button>
			 </span>
			 
			 <span id="offproduct" class="" v-if="available">
			 <button style="background:red;" @click="offProduct()">Off</button><span style="color:#ddd; margin:7px;">on</span>
			</span>
		</div>
		   
		   <!-- End of Product details Class -->
		   
		   </div>
		
		<!-- End Product seller products Class -->
		
		
		
		
		<!--Begin product price menu class div-->
		
		<div id="product-price" class="product-price" v-if="showPrice">
		<div class="price-menu">
		<div class="hide-price" >
		<span @click="hideProductPrice()">x</span>
		</div>
		
		<div > <b>{{this.name}}</b></div>
		<p></p>
		<table>
		<tr>
		<td><b>Price(N)</b></td><td><b>Unit</b></td><td><b>Action</b></td>
		</tr>
		
		<tr>
		<td><input type="number" placeholder="price" style="width:60px;" v-model="pprice"/></td><td><input type="text" placeholder="unit" style="width:60px;" v-model="punit"/></td><td><a style="color:#fff; background:green; padding:5px; border-radius:10px;" @click="sendPrice">Add</a></td>
		</tr>
		
		<tr v-for="price in prices">
		<td>{{price.price}}</td><td>{{price.unit}}</td><td><a style="color:red;" @click="removePrice(price.id)">Remove</a></td>
		</tr>
		
		</table>
		</div>
		</div>
		
	<!--End of product price menu class div-->
			




</div>


</template>


<script>

export default {

props:['id', 'name', 'storeName', 'category', 'description', 'image', 'status', 'store'],

mounted() {
if(this.status==0) {

this.available = false

}
this.getPrices()
this.getAuthDetails()
this.getStoreProducts()


},

data() {

return {

authDetails: [],
products: [],
showPrice:false,
available: true,
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
root:'http://localhost',
=======
root:'https://jokesterbox.com',
>>>>>>> 08131f3750a8a173a8713d34e83c52bd26ef5ef2
=======
root:'http://jokesterbox.com',
>>>>>>> 2ca84d3aa0ee2839f863542aed349abb84212903
=======
root:'https://jokesterbox.com',
>>>>>>> e1e392baa3ffc85d2861e73812220121d32df375
=======
>>>>>>> 3f053b0649b2cdbedf5b4e225632c2e746a9c50a
pprice:'',
punit:'',
prices: []



}


},


methods: {

removePrice(pid) {

var price = this.prices.find ( p => {
				return p.id === pid
				
			})

			
	var index = this.prices.indexOf(price)
			
	this.prices.splice(index, 1)


axios.get('/remove/prices/' + pid).then(response=>{
	
     this.getPrices()	
		
	})

},

sendPrice() {

let data = JSON.stringify({
       price: this.pprice,
	   unit:this.punit,
       product_id: this.id,
		
	
    })
				
				
				axios.post('/send/price', data, {
					headers: {
						'Content-Type': 'application/json'
						
						}
						
					})
				.then( (response) => { 
				
				this.pprice = ''
				this.punit = ''
				
				this.getPrices()
				
				})


},

getPrices() {

axios.get('/get/prices/' + this.id).then(response=>{
		
		this.prices = []
		response.data.forEach((price) => {
			 this.prices.push(price)
			 
			 })
	})


},

getAuthDetails(){
	
	axios.get('/auth/details').then(response=>{
		
		this.authDetails.push(response.data)
	})
	
},

getStoreProducts(){
	
	
	
},

showProductPrice() {
	
this.showPrice= true	
},

hideProductPrice() {

this.showPrice= false	
		
	
},

onProduct() {
	
this.available = true

axios.get('/on/product/' + this.id ).then(response=>{
		
		
	})
	
},

offProduct() {
	
this.available = false

axios.get('/off/product/' + this.id ).then(response=>{
		
		
	})		
	
},



}

}


</script>