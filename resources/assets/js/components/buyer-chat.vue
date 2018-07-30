<template>

<div class="inactive-transactions" v-if="shopDetails.length>0" style="height:520px; overflow:hidden;">

		<div class="seller-details">
		
		<div style="height: 80px; overflow-y:auto">
		<img class="owner-avatar"  width="50px" height="50px" style="border-radius:50%; margin:10px;" :src="shopDetails[0].seller.avatar"/>
		
		<div style="margin-top:-50px; margin-left:80px;"><span class="user-name">{{shopDetails[0].seller.fname + ' ' + shopDetails[0].seller.lname }}</span> as Seller <span @click="displayChat" v-if="!showChat"><span class="unread-chat hidden">10</span><div class="chat-button" v-if="finished==false && accepted==false">Chat</div></span><span @click="hideChat" v-if="showChat"><div class="details-button">Show items</div></span></div>
		
		</div>
		
		<div class="hr"></div>
		<span v-if="!showChat">
		<div style="height:80px; overflow-y:auto;">
		<h4 style="margin-left:10px;">{{shopDetails[0].name + ', ' + shopDetails[0].location.location + ', ' + shopDetails[0].seller.phone }}</h4>
		
		</div>
		
		<div class="hr"></div>
		
		<div style="height:80px; overflow-y:auto;">
		<h4 style="margin-left:10px;">Available at the moment</h4>
		
		</div>
		
		
		
		<div style="height:150px; overflow-y:auto;">
		<span v-for="transaction in trackedTransactions">
		<img class="product-avatar"  width="50px" height="50px" style="border-radius:5px; margin:10px;" :src="transaction.price.product.image"/>
		<div style="width:180px; position:relative; top:-25px; left:70px;">
		<span v-if="transaction.quantity==1">
		<span class="pending-product-name">{{transaction.price.product.name}}({{'N' + transaction.price.price + 'x' + transaction.quantity + transaction.price.unit }})</span><br>
		</span>
		<span v-else>
		<span class="pending-product-name">{{transaction.price.product.name}}({{'N' + transaction.price.price + 'x' + transaction.quantity + transaction.price.unit +'s'}}) </span><br>
		</span>
		</div>
		</span>	
		
		
		</div>
		</span>
		
		<span :id="'chat-container' + this.id " class="hidden" v-if="finished==false && accepted==false">
		<div :id="'chat-message' + this.id" class="chat-content ">
		<span v-for="chat in trackedChat">
		<p v-if="chat.status==0" class="authChat">{{chat.body}}</p>
		<p v-else class="userChat">{{chat.body}}</p>
		</span>
		<p :id="'fake-message' + this.id" class="authChat hidden">{{chat}}</p>
		<p class="false-paragraph"></p>
		<p class="false-paragraph"></p>
		</div>
		<div class="chat-input">
		<input type="text" placeholder="Type your message" @keyup.enter="sendMessage" v-model="message"><span class="send-chat-icon"><img  @click="sendMessage" src="/storage/icons/right-arrow.png" width="20px" height="auto"></span>
		</div>
		</span>
		
		<div class="hr" style="border:none;"></div>
		
		<div style="height:100px; overflow-y:auto;">
		<h4 style="margin-left:10px;">Total= N {{total}} Delivery= N {{this.delivery}} <br>Total + Delivery = N {{total + this.delivery}}</h4>
		
		<span v-if="finished==false && accepted==false">
		<button style="margin-left:10px; cursor:default; border:none; color:green; background:#fff; font-weight:bold;">Accepted</button> <button style="margin-left:10px; border:1px solid #ddd; color:#000; background:yellow; font-weight:bold;" @click="finishTransaction">Received</button>  <button style="margin-left:10px; border:none; color:#fff; background:black; font-weight:bold;">Report</button>
		</span>
		
		<span v-if="finished" style="color:green; margin-left:10px;">
		Transaction Completed
		</span>
		
		<span v-if="accepted" style="color:green; margin-left:10px;">
		Request accepted
		</span>
		</div>
	
		</div>
		</div>
		
</template>

<script>

export default {

props: ['id', 'seller', 'buyer', 'auth', 'shop', 'delivery'],

mounted() {
this.getShopDetails()
this.getTrackedTransactions()
this.listen()

},

data() {

return {

shopDetails:[],
trackedTransactions: [],
total: 0,
finished: false,
accepted: false,
showChat: false,
message:"",
chat:"",
trackedChat:[],

}


},

methods: {


listen() {

	Echo.private('App.User.' + this.auth)
	.notification( (notification) => {
	
	if (notification.ntype==4 && notification.status==0){
	
	this.getTrackedTransactions()
	
	}
	document.getElementById('noty_audio').play();
	this.chatScroller();
	})

	
},

sendMessage() {

if(this.message.length==0) {

return
}

this.chat= this.message
this.message= ""

this.showFakeMessage()
this.chatScroller();


let data = JSON.stringify({
        body: this.chat,
        sender: this.buyer,
		receiver: this.buyer,
		tracker: this.id,
    })
				
				
				
				axios.post('/send/buyer/chat', data, {
					headers: {
						'Content-Type': 'application/json'
						
						}
						
					})
				.then( (response) => { 
				
				this.getRecentChat()
				
				})



},

getRecentChat() {

axios.get('/get/recent/buyer/chat/' + this.buyer + '/' + this.id).then(response=>{
		
		this.trackedChat.push(response.data)
		this.hideFakeMessage()
		
		})


},

showFakeMessage() {

var fake=document.getElementById('fake-message' + this.id)
fake.classList.remove("hidden")

},

hideFakeMessage() {

var fake=document.getElementById('fake-message' + this.id)
fake.classList.add("hidden")

},

displayChat() {
var chat=document.getElementById('chat-container' + this.id)
chat.classList.remove("hidden")
if (this.showChat=true)

this.chatScroller();

},

chatScroller() {

var chat= document.getElementById('chat-message' + this.id)
chat.scrollTop=5000

},

hideChat() {
var chat=document.getElementById('chat-container' + this.id)
chat.classList.add("hidden")
this.showChat=false
},

finishTransaction(){
this.finished = true

axios.get('/finish/transaction/' + this.id).then(response=>{

})
},

acceptRequest() {
this.accepted=  true
axios.get('/buyer/accept/transaction/' + this.id).then(response=>{


})

},

getTrackedTransactions(){
	
	axios.get('/get/tracked/transactions/' + this.id).then(response=>{
		response.data.forEach((tracked)=> {
		
		this.trackedTransactions =[]
		this.total= 0
		
		if(tracked.price && tracked.price.product && tracked.price.product.status==1) {
		this.trackedTransactions.push(tracked)
		this.total= this.total + tracked.price.price * tracked.quantity
		}
		})
		
		if(this.total==0) {
		
		this.cancelTransaction()
		
		}
		
		this.trackedChat = this.trackedTransactions[0].tracker.chats
		
	})
	
},

getShopDetails(){
	
	axios.get('/get/shop/details/' + this.shop).then(response=>{
		
		if(response.data.online==0 || response.data.seller.online==0) {
		
		this.cancelTransaction()
		}
		this.shopDetails.push(response.data)

		 
	})
	
},


}



}


</script>

<style>

.pending-product-name {
position: relative;
top: -30px;

}

</style>