<template>

<div class="shops">
		
		<div style="height: 93px; overflow-y:auto" v-if="shopOwner.length>0">
		<div class="big-online"  v-if="this.online==1 && this.status==1 "></div><div class="big-offline"  v-else></div>
		<img class="owner-avatar"  width="50px" height="50px" style="border-radius:50%; margin:10px;" :src="shopOwner[0].avatar"/>
		
		<div style="margin-top:-50px; margin-left:80px;"><span class="user-name">{{shopOwner[0].fname}} {{shopOwner[0].lname }}</span> is Owner</div>
		
		</div>
		<div class="hr"></div>
		
		<div style="height:80px; overflow-y:auto;" v-if="shopOwner.length>0 && shopLocation.length>0">
		<h4 style="margin-left:10px;">{{this.name}}, {{shopLocation[0].location}}, {{shopOwner[0].phone}} </h4>
		
		</div>
		
		
		
		<div style="height:200px; overflow-y:auto;" v-if="this.online==1 && this.status==1">
		<span v-for="item in shopItems">
		<div class="small-online"  v-if="item.status==1"></div><div class="small-offline"  v-else></div>
		<img class="product-avatar"  width="50px" height="50px" style="border-radius:5px; margin:10px;" :src="item.image"/>
		<span class="pending-product-name">{{item.name}}</span><br>
		</span>
		
		</div>
		
		<div style="height:200px; overflow-y:auto;" v-else>
		<span v-for="item in shopItems">
		<div class="small-offline"></div>
		<img class="product-avatar"  width="50px" height="50px" style="border-radius:5px; margin:10px;" :src="item.image"/>
		<span class="pending-product-name">{{item.name}}</span><br>
		</span>
		
		</div>
		
		
		<div class="hr"></div>
		
		<center>
		
		<button  v-if="this.online==1 && this.status==1 && this.shopItems.length>0" @click="displayShop()" style="background:green; color:#fff; border-radius:10px; border:none; margin-top:10px; padding:10px; font-weight:bold; cursor:pointer;">Enter Store</button>
		<button  v-else @click="displayShop()" style="background:green; visibility:hidden; color:#fff; border-radius:10px; border:none; margin-top:10px; padding:10px; font-weight:bold; cursor:pointer;">Enter Store</button>
		</center>
		<div class="items-modal"  v-if="showShop && this.online==1 && this.status==1" @click="hideShop()">
		<span class="items-close">X</span>
		<div class="items-wrapper" @click.stop>
		<span v-for="item in shopItems">
		<span v-if="item.status==1">
		<items :online="item.status" :image="item.image" :name="item.name" :store="item.store_id" :id="item.id"></items>
		</span>
		</span>
		</div>
		
		</div>
		</div>
</template>

<script>

export default {

props: ['id', 'location', 'online', 'owner', 'name'],

data() {

return {

showShop: false,

shopOwner: [],
shopLocation: [],
shopItems: [],
transactionTracker: [],
status:"",

}


},

mounted() {



this.getShopOwner()
this.getShopLocation()
this.getItems()




},

methods: {

checkAuth() {

	axios.get('/check/auth').then(response=>{
		
		if(response.data==0) {
		window.location= '/login'
		return
		} 
		
		else {
		this.createTracker()
		
		}
		
		 
	})

},

createTracker() {
if(this.transactionTracker.length>0 && this.transactionTracker.status) {

return 
}

axios.get('/create/transaction/tracker/' + this.id + '/' + this.owner ).then(response=>{
		
		this.transactionTracker.push(response.data)
		
		 
	})


},

getItems(){
	
	axios.get('/get/shop/items/' + this.id).then(response=>{
		
		
		 response.data.forEach((item) =>{

		if (this.shopItems.length==0) {
		
        this.shopItems.push(item)		
		return 1	
			
		}
		
		var verify = this.shopItems.find ( i => {
				return i.id === item.id
				
			})

		if(!verify) {	
		this.shopItems.push(item)
		
		}
		 })
	})
	
},


getShopLocation(){
	
	axios.get('/get/shop/location/' + this.location).then(response=>{
		
		this.shopLocation.push(response.data)
		 
	})
	
},

getShopOwner(){
	
	axios.get('/get/shop/owner/' + this.owner).then(response=>{
		
		/* I am making shop owner online status my status
		Status from algolia is unreliable */
		this.status=response.data.online
		this.shopOwner.push(response.data)
		 
	})
	
},



displayShop() {
var bodyScroll= document.getElementsByTagName("body")[0].style.overflow="hidden"
this.showShop = true
this.checkAuth();



},

hideShop() {
var bodyScroll= document.getElementsByTagName("body")[0].style.overflow="auto"
this.showShop = false



}



}



}


</script>

<style>

.pending-product-name {
position: relative;
top: -30px;

}

.items-wrapper {
border: 2px solid transparent;
width: 80%;
height: 500px;
overflow-y:auto;
margin: 20px;

}

.items-modal{

position: fixed;
top: 0px;
left:0px;
width: 100%;
height: 100%;
background: rgba(0,0,0,.8);
z-index:20;
}

.items-close {

position:fixed;
right:20px;
top:20px;
color:#fff;
cursor:pointer;
font-family: arial;


}

.items-close:hover {

color:rgba(255,255,255,0.5);

}

.items-container {

background: #fff;
height: 400px;
width: 300px;
overflow-y:auto;
margin: 100px 0px 0px 100px;

}

.item-name {

font-weight:bold;
margin-top: -100px;
margin-left: 130px;

}

.item-details{

height: 125px;
overflow-y: auto;

}


</style>