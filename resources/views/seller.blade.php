<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
	 <title>Your Dashboard</title>
      @extends('layouts.app2') 
		<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    </head>
<body>



<!--Begin Container class DIV-->
      
<div id="app" class="container">

<div id="loader" class="loader">

			
	 <img class="panafri-logo"  width="50px" height="auto" src="{{Storage::url('public/icons/panafri-icon.jpg')}}" alt="Panafri icon"><span>Panafri Partner</span>
	 
	 <loader></loader>
	 
	
</div>	

<seller-not :id="{{auth::id()}}"></seller-not>
	<!--Begin header class DIV-->
	
	 <div  class="header">
	 
	 <!--Begin logo class DIV-->
			
			<div class="logo">
			
				<img class="panafri-logo"  width="150px" height="auto" src="{{Storage::url('public/icons/panafri-logo.png')}}" alt="Panafri logo">
				
				
			</div>
			
		 <!--End logo class DIV-->

		 <!--Begin User Avatar DIV-->
		 
		 			<div class="avatar" width="100px" height="auto" style="border-radius:50%; position:absolute; right:50px; top:5px;">
			
				<img class="user-avatar"  width="30px" height="30px" style="border-radius:50%;"src="{{auth::user()->avatar}}" alt="Panafri logo">
				
				<div class="user-name">
				<span style="color:#fff; font-weight:bold;  font-size:small; margin-left:-15px;">{{auth::user()->fname}} {{auth::user()->lname}}</span>
				</div>

				</div>

		 
		 
		 
		<!--End User Avatar DIV-->
		 
		  <!--Creating Menu Icon from scatch with Css-->
		  
			<div id="showmenu" class="plus-bar" @click="showMenu()">
			
			<div class="menu-add">+</div>
			
			</div>
			
			<div id="hidemenu" class="menu-bar hidden" @click="hideMenu()">
			
			<div class="bar1"></div>
			<div class="bar2"></div>
			<div class="bar3"></div>
			
			</div>
			
	 <!--End of Creating Menu Icon from scatch with Css-->
			
			
			 <!--Begin hidden class DIV-->
			
			<div id="hide" class="hidden">
			
			 <!--Begin navigation class DIV-->
			<div  class="navigation-links">
				
			
				<li @click="displayAdminCategory()">
				<a id="admin-link" >Add Products </a><span class="product-icon">+</span>
				</li>
				
				<span id="onApp" v-if="!appOn">
			 <span style="color:#ddd; margin:7px;">Offline</span><button style="background:green;" @click="onApp()">On App</button>
			 </span>
			 
			 <span id="offApp" class="" v-if="appOn">
			 <button style="background:#fff; color:red" @click="offApp()">Off App</button><span style="color:#ddd; margin:7px;">online</span>
			</span>
			
			
		
				
				
				
				<!--
				
					@if(auth::user()->role > 0)
				<li @click="displayAdminSeller()">
				<a id="admin-link" >Admin Sellers</a>
				</li>
				@endif
				
				<li @click="freeLanceModal()">
				<a id="delivery-link" >Start Freelance Delivery</a>
				</li>
				
				
				<li @click="welcomeLoginModal()">
				<a id="login-link" >Login</a>
				</li>
				
				<li >
				<form method="post" action="/logout">
				{{ csrf_field() }}
				<button>Logout</button>
				</form>
				</li>
				-->
			</div>
			
			
			<!--End of navigation class DIV-->
			
			
			
			
			
			</div>
			
			<!--End of hidden class div-->
			
			
		</div>
		
		<!--End of header class div-->
		
		
		<!--Begin content-body class div-->
		
		<div id="content-body" class="content-body">
		
		
		
		
		<!--Begin categories class div-->
		
		<div class="categories">
		
		<div class="big-add" @click="displayAdminCategory()"><center>+</center></div>
		
		
		
		<div v-for="office in authShops">
		
		<office :root="'{{ config('app.url') }}'" :id="office.id" :name="office.name" :online="office.online"></office>
		</div>	
		
		
			
		</div>
		<!-- End of Categories class-->
		
		
		<!--Begin transaction class button div-->
		@if (auth::check())
		
		<div class="transaction-button" @click="sellerTransactionsUrl()">
		<div>
		
		<img class="transaction-avatar"  width="30px" height="auto" src="{{Storage::url('public/icons/transactions.png')}}"/>
		
		</div>
		<span class="transaction-count" style="color:#000;">@{{sellerActiveTrans.length}}</span>
		</div>
		
		<div class="transaction-chat-button" @click="sellerTransactionsChatUrl()">
		<div>
		
		<img class="transaction-chat-avatar"  width="30px" height="auto" src="{{Storage::url('public/icons/chat.png')}}"/>
		
		</div>
		<span class="transaction-chat-count" style="color:#000;">@{{sellerChats.length}}</span>
		</div>
		
		@endif
		
		
		
		<!--Future Feature
		<div class="categories">
			<center>
				<h1>Top Sellers</h1>
			</center>
		</div>
		-->
		<div class="others">
		
			
		
		</div>
		</div>
		<!--End of content-body class div-->
		
		
		
		<!--Begin search-page class div-->
		
		<div id="search-page" class="welcome-search-page hidden" @click="hideSearchModal()">
		<div class="close">
		x
		</div>
		<div class="search-message">
		Search for goods and services nearby in realtime...
		</div>
		
		<div class="search-box" @click.stop>
		
		<input type="text" name="search"  placeholder="Search anything... Request Everything" autofocus v-model="query" @keyup="searchProducts">
		
		</div>
		
		<img class="main-search-icon"  width="50px" height="auto" src="{{Storage::url('public/icons/search-icon.png')}}" alt="Search Icon" @click.stop />
		
		<img class="panafri-icon"  width="50px" height="auto" src="{{Storage::url('public/icons/panafri-icon.jpg')}}" alt="Panafri Icon" @click.stop />
		
		<!-- Begin Search Category Class -->
		
		<div class="categories">
			
			
			<!-- Begin Products Class -->
			
			<div class="products" @click.stop>
			 <div  v-for="product in results">
			
			 <img :src="product.image" height="200px" width="300px"  :alt="product.name" />
			
			 <div class="product-details" @click="authStore">
			 <h2> <b> @{{product.name}} </b></h2>
			 @if(auth::user()->status == 5)
			<sell-button :pid="product.id" :pname="product.name" :cid="product.category_id"></sell-button>
			 @else
			 <button v-if="product.category_id==3" @click="findSeller(product.id, product.category_id)">Hire @{{product.name}}s Nearby</button>
			 <button v-else @click="findSeller(product.id, product.category_id)">Buy @{{product.name}} Nearby</button>
			 @endif
			</div>
			
		</div>
		<!-- End Product Class -->
		</div>
		</div>
		<!-- End Search Category Class -->
		</div>
		
	<!--End of Search-page class div-->
	
	
	<!--Begin active-page class div-->
		
		<div id="active-page" class="welcome-search-page hidden" @click="hideActivePage()">
		<div class="close">
		x
		</div>
		<div class="active-message" v-for="product in activeProduct">
		
		<h2 v-if="product.category_id== 3" style="margin:10px;">People who are @{{product.name}}s Nearby</h2>
		<h2 v-else style="margin:10px;">People selling @{{product.name}} Nearby</h2>
		</div>
		<div v-if="this.activeSellers.length==0" style="margin:10px;" >None nearby at the moment</div>
		
		<!-- Begin active Category Class -->
		
		<div class="categories">
			
			
			<!-- Begin Users Class -->
			
			<div class="products" >
			 <div  v-for="seller in activeSellers" @click.stop>
			
			 <img :src="seller.avatar" height="200px" width="300px"  :alt="seller.fname + ' ' + seller. lname" />
			
			 <div class="product-details">
			 <h2> <b> @{{seller.fname + ' ' + seller. lname}} </b></h2>

			 <button  @click="hireSeller(seller.id)">Patronise @{{seller.fname + ' ' + seller. lname}}</button>
			
			</div>
			
		</div>
		<!-- End Users Class -->
		</div>
		</div>
		<!-- End active Category Class -->
		</div>
		
	<!--End of active-page class div-->
	
	
	
	
	
	<!--Begin chat-box class div-->
		
		<div id="chat-box" class="chat-box hidden">
		<div class="close"  >
		<span @click="hideChatBox()">x</span>
		</div>
		

		<div id="chatBody" class="chatBody">
		<div class="chat-message" v-for="chat in activeChat">
		
		<chat-body :id="chat.sender_id" :body="chat.body"></chat-body>
		</div>
		</div>	
		
		<input type="text"@keyup.enter="sendTypedMessage(activeChat[0].transaction_id)" placeholder="Type message here and hit enter" v-model="typedChat" /> 
		</div>
		
	<!--End of chat-box class div-->
	 
	 
	 <!--Begin admin-category class div-->

	
	 <div id="admin-category" 
	 class="add-product start-selling {{old('admin') ? ' ' : 'hidden' }}" @click="hideAdminCategory()">
	
	 
	 <!--Begin form-container class div-->	
	 
	 
	 <div class="form-container product-container" @click.stop >
	
	 <div class="form-close" @click="hideAdminCategory()">
		x
	 </div>
	 
	 <div class="form">
	 <table >
	 
	 <h3>ADD PRODUCTS</h3>
	 
	 <tr>
	 <td>YOUR OFFICE</td>
	 </tr>
	 
	<tr>
	 
	 <td><select name="ostore"  v-model="activeShop">
	 <option value=''>Select</option>
	 <option v-for="shop in authShops" :value="shop.id">@{{shop.name}}</option>
	 </select><small><a v-if="!openNewShop"@click="openShop" class="learn-more">New office</a></small>
	 </td>
	 </tr> 
	 
	 <tr v-if="openNewShop">
	 <td>Open Office</td>
	 </tr>
	 
	 <tr v-if="openNewShop">
	 <td><input type="text" name="sname" placeholder="Enter office name" v-model="shopName"></td>
	 </tr>
	 
	 <tr v-if="openNewShop">
	 <td><input type="text" name="slocation" placeholder="Enter office location" v-model="shopLocation">
	 
	 <div @click="hideOpen" style="color:#fff; background:green; padding:5px; border-radius:10px; width:40px; cursor:pointer"> Open </div>
	 </td>
	 </tr>
	 
	 
	  <tr>
	 <td>PRODUCT NAME</td>
	 </tr>
	 
	 <tr>
	
	 <td><input type="text" name="product" placeholder="Enter product name" v-model="productName">
	 </td>
	 </tr>
	 
	 
	 
	 <tr>
	
	 <td><textarea name="description" placeholder="Describe product" v-model="pdescription"></textarea>
	 </td>
	 </tr>
	 
	 
	 <tr>
	  <td>CHOOSE CATEGORY</td>
	 </tr>
	
	 <tr>
	 
	 <td><select name="ocategory" v-model="ocategory">
	 <option value=''>Select</option>
	 <option v-for="category in categories" :value="category.id">@{{category.name}}</option>
	 </select><small><a v-if="!addNewCategory" @click="addCategory" class="learn-more">Add new category</a></small>
	 </td>
	 </tr>
	 
	  
	 <tr v-if="addNewCategory">
	  <td>ADD NEW CATEGORY</td>
	 </tr>
	 
	  <tr v-if="addNewCategory">
	 
	 <td><input type="text" name="ncategory" placeholder="Enter category name" v-model="ncategory"> <div @click="hideAddCategory" style="color:#fff; background:green; padding:5px; border-radius:10px; width:40px; cursor:pointer; margin:5px;"> Add </div>
	 </td>
	 </tr>
	 
	 <!-- Begin Adding image upload -->
	 
	 <div  id="uploadedContainer" v-if="productImage.length>0 || uploadDelay.length>0">
				 
				 <div class="showUploaded" v-for="file in productImage">
				 <div class="uploaded_file_container">
				 <img  v-if="file.type=='image'" class="uploadedFile" :src="file.URL" width="100" height="100"  alt="" />
				
				 <video v-if="file.type=='video'" class="uploadedFile" width="100" height="100" controls >
				 <source :src="file.URL" :type="file.mime">
				</video>
				 <div id="uploadInfo" ><span class="uploadDelete" @click="removeUploaded"><b>x</b></span></div>
			     </div>
				 <!-- Add Image Spinner -->
				 
				 <div class="spinner_wrapper" v-for=" file in uploadDelay">
				 <div class="spinner"></div>
				 </div>
	  </div>
				 
	 
	<tr>
	  <td>PRODUCT IMAGE</td>
	 </tr>
	
	 <tr>
	 
	 <td>
	 <input type="file" id="productimage"  style="display:none;" accept="image/*" v-on:change="imageChange">
				<span  @click="showProductImagePicker" class="image-picker" title="Choose file"  ><img  id="" src="/storage/icons/photo_icon.png" width="15px" height="15px"  alt="" /><span class="photo_icon_text"><b> Select</b></span></span>
	 </td>
	 </tr>
	  <!-- End Adding image upload -->
	 <tr>
	
	 <td><button v-if="!show_post_spinner" id="addProduct" class="addProductButton post_button" type="submit" @click="submitProduct()" :disabled="pdisabled">Add</button>
	<div class="post_spinner_wrapper" v-if="show_post_spinner">
	 <div class="post_spinner"></div>
	</div>
	 
	 
	 
	 </td>
	 </tr>
	 </table>
	
	  <input type="hidden" name="product" value="product">
	 
	  </div>
	  
	  <!--End of form class-->
	  
	 </div>
	 
	 <!--End of form-container class div-->
	 
	 </div>
	 
	 <!--End of admin-category class div-->
	  
	 
	 
	  <!--Begin admin-Seller class div-->

	
	 <div id="admin-seller" 
	 class="start-selling {{old('adminseller') ? ' ' : 'hidden' }}" @click="hideAdminSeller()">
	
	 
	 <!--Begin form-container class div-->	
	  <div class="close">
		x
	 </div>
	 
	 <div class="form-container" @click.stop >
	
	 
	 
	 <div class="form">
	 <table>
	 
	 <tr><td></td><th><h3>Enter email of sellers to add them</h3></th></tr>
	 
	 
	 
	 <tr>
	 <td>Seller Email</td>
	 <td><input type="email" name="product" placeholder="Enter seller Email" v-model="sellerEmail" >
	 </td>
	 </tr>
	 
	 <tr>
	 <td>Admin Email</td>
	 <td><input type="email" name="adminemail" placeholder="Enter your email" v-model="adminEmail" >
	 </td>
	 </tr>
	 
	 
	 
	
	 
	 <!-- Begin Adding image upload -->
	 
	 <div  id="uploadedContainer" v-if="sellerImage.length>0 || uploadDelay.length>0">
				 
				 <div class="showUploaded" v-for="file in sellerImage">
				 <div class="uploaded_file_container">
				 <img  v-if="file.type=='image'" class="uploadedFile" :src="file.URL" width="100" height="100"  alt="" />
				
				 <video v-if="file.type=='video'" class="uploadedFile" width="100" height="100" controls >
				 <source :src="file.URL" :type="file.mime">
				</video>
				 <div id="uploadInfo" ><span class="uploadDelete" @click="removeUploaded"><b>x</b></span></div>
			     </div>
				 <!-- Add Image Spinner -->
				 
				 <div class="spinner_wrapper" v-for=" file in uploadDelay">
				 <div class="spinner"></div>
				 </div>
	  </div>
				 
	 
	
	
	 <tr>
	 <td>Seller Photo</td>
	 <td>
	 <input type="file" ref="image"  style="display:none;" accept="image/*" v-on:change="sellerImageChange">
				<span @click="showImagePicker" class="image-picker" title="Choose file"  ><img  id="" src="/storage/icons/photo_icon.png" width="15px" height="15px"  alt="" /><span class="photo_icon_text"><b> Select</b></span></span>
	 </td>
	 </tr>
	  <!-- End Adding image upload -->
	 <tr>
	 <td></td>
	 <td><button v-if="!show_post_spinner" class="addProductButton post_button" type="submit" @click="submitSeller()" :disabled="sdisabled">Add Seller</button>
	<div class="post_spinner_wrapper" v-if="show_post_spinner">
	 <div class="post_spinner"></div>
	</div>
	 
	 
	 
	 </td>
	 </tr>
	 </table>
	
	  <input type="hidden" name="adminseller" value="admin seller">
	 
	  </div>
	  
	  <!--End of form class-->
	  
	 </div>
	 
	 <!--End of form-container class div-->
	 
	 </div>
	 
	 <!--End of admin-sellers class div-->
	  
	  
	   <!--Begin freelance class div-->

	
	 <div id="freelance-delivery" 
	 class="start-selling {{old('freelance') ? ' ' : 'hidden' }}" @click="hideFreeLanceModal()">
	
	 
	 <!--Begin form-container class div-->	
	  <div class="close">
		x
	 </div>
	 
	 <div class="form-container" @click.stop >
	
	 <div class="logo">
			
		<a href="http://panafri.com">  <img class="panafri-logo"  width="150px" height="auto" src="{{Storage::url('public/icons/panafri-logo.png')}}" alt="Panafri logo"></a>
	 </div>
	 <div class="form-message">
	You can make money by helping other sellers deliver their goods or services, Register to gain access to your personalised dashboard.
	 </div>
	  <form class="start-selling-form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
	 
	 <table>
	 <tr><td></td><th><h3>Personal Information (<a class="learn-more">Read Data Policy</a>)</h3></th></tr>
	 <tr>
	 <td>First Name</td>
	 <td><input type="text" name="fname"  value="{{ old('fname') }}" required autofocus /></td>
	 </tr>
	 @if ($errors->has('fname'))
     <tr>
       <td><strong>{{ $errors->first('fname') }}</strong></td>
     </tr>
     @endif
	 
	 <tr>
	 <td>Middle Name</td>
	 <td><input type="text" name="mname"  value="{{ old('mname') }}"  /></td>
	 </tr>
	 @if ($errors->has('mname'))
     <tr>
      <td></td> <td><strong>{{ $errors->first('mname') }}</strong></td>
     </tr>
     @endif
	 
	 <tr>
	 <td>Last Name</td>
	 <td><input type="text" name="lname"  value="{{ old('lname') }}" required /></td>
	 </tr>
	 @if ($errors->has('lname'))
     <tr>
       <td></td> <td><strong>{{ $errors->first('lname') }}</strong></td>
     </tr>
     @endif
	 
	 <tr><td></td><th><h3>Private Information (<a class="learn-more">Read Data Policy</a>)</h3></th></tr>
	 <tr>
	 
	 <tr>
	 <td>Email</td>
	 <td><input type="email" name="email"  value="{{ old('email') }}" required /></td>
	 </tr>
	 @if ($errors->has('email'))
     <tr>
        <td></td><td><strong>{{ $errors->first('email') }}</strong></td>
     </tr>
     @endif
	 
	 <tr>
	 <td>Phone Number</td>
	 <td><input type="number" max="9999999999" name="phone"  value="{{ old('phone') }}" required /></td>
	 </tr>
	 @if ($errors->has('phone'))
     <tr>
       <td></td> <td><strong>{{ $errors->first('phone') }}</strong></td>
     </tr>
     @endif
	 
	 <tr><td></td><th><h3>Sensitive Information (<a class="learn-more">Read Data Policy</a>)</h3></th></tr>
	 <tr>
	 
	
	 <tr>
	 <td>Password</td>
	 <td><input  type="password"  name="password"  value="{{ old('password') }}" required /></td>
	 </tr>
	 @if ($errors->has('password'))
     <tr>
        <td></td><td><strong>{{ $errors->first('password') }}</strong></td>
     </tr>
     @endif
	 
	  <tr>
	 <td>Confrirm Password </td>
	 <td><input type="password"  name=" password_confirmation"  value="{{ old('password_confirmation') }}" required /></td>
	 </tr>
	 @if ($errors->has('password_confirmation'))
     <tr>
        <td></td><td><strong>{{ $errors->first('password_confirmation') }}</strong></td>
     </tr>
     @endif
	 
	 <tr>
        <td></td><td><strong>By clicking "Register" you agree that you are over 13 years of age and you accept our <a class="learn-more">Terms of Service</a> </strong></td>
     </tr>
	 
	 <tr>
	 <td></td>
	 <td><button type="submit">Register and Deliver</button></td>
	 </tr>
	 
	 
	 </table>
	 
	  <input type="hidden" name="freelance" value="freelance">
	 </form>
	 
	 </div>
	 
	 <!--End of form-container class div-->
	 
	 </div>
	 
	  <!--End of freelance class div--> 
	  
	  
	
	 <!--Begin welcome-login class div-->

	
	 <div id="welcome-login" 
	 class="start-selling {{old('login') ? ' ' : 'hidden' }}" @click="hideWelcomeLoginModal()">
	
	 
	 <!--Begin form-container class div-->	
	  <div class="close">
		x
	 </div>
	 
	 <div class="form-container" @click.stop >
	
	 <div class="logo">
			
		<a href="http://panafri.com">  <img class="panafri-logo"  width="150px" height="auto" src="{{Storage::url('public/icons/panafri-logo.png')}}" alt="Panafri logo"></a>
	 </div>
	 <div class="form-message">
	 When you login, you can buy and sell goods and services with people nearby in realtime right from your dashboard. You can also earn extra money by doing freelance delivery.
	 </div>
	  <form class="welcome-login-form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
	 
	 <table>
	 
	 <tr><td></td><th><h3>Private Information (<a class="learn-more">Read Data Policy</a>)</h3></th></tr>
	 <tr>
	 
	 <tr>
	 <td>Email</td>
	 <td><input type="email" name="email"  value="{{ old('email') }}" required /></td>
	 </tr>
	 @if ($errors->has('email'))
     <tr>
        <td></td><td><strong>{{ $errors->first('email') }}</strong></td>
     </tr>
     @endif

	 <tr><td></td><th><h3>Sensitive Information (<a class="learn-more">Read Data Policy</a>)</h3></th></tr>
	 <tr>
	 
	
	 <tr>
	 <td>Password</td>
	 <td><input  type="password"  name="password"  value="{{ old('password') }}" required /></td>
	 </tr>
	 @if ($errors->has('password'))
     <tr>
        <td></td><td><strong>{{ $errors->first('password') }}</strong></td>
     </tr>
     @endif
	 
	 
	 <tr>
        <td></td><td><strong>By clicking "Login" you agree that you are over 13 years of age and you accept our <a class="learn-more">Terms of Service</a> </strong></td>
     </tr>
	 
	 <tr>
	 <td></td>
	 <td><button type="submit">Login</button></td>
	 </tr>
	 
	 
	 </table>
	 
	  <input type="hidden" name="login" value="login">
	 </form>
	 
	 </div>
	 
	 <!--End of form-container class div-->
	 
	 </div>
	 
	  <!--End of welcome-login class div-->
	  
</div>
</div>
	  
	 
	 <!--End of container class div-->
	
		
		@yield('content')
   
		
	<!-- Scripts -->
	 <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/welcome.js') }}"></script>
	
</body>
</html>
