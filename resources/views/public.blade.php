<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
       
        <title>Buy and Sell in Realtime on Panafri</title>
		 @extends('layouts.app2') 
		<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    </head>
<body>

<!--Begin Container class DIV-->
      
	<div id="app" class="container">

	
	<!--Begin header class DIV-->
	
	 <div  class="header">
	 
	 <!--Begin logo class DIV-->
			
			<div class="logo">
			
				  <img class="panafri-logo"  width="150px" height="auto" src="{{Storage::url('public/icons/panafri-logo.png')}}" alt="Panafri logo">
			</div>
			
		 <!--End logo class DIV-->	
		 
		  <!--Creating Menu Icon from scatch with Css-->
		  
			<div id="showmenu" class="menu-bar" @click="showMenu()">
			
			<div class="bar1"></div>
			<div class="bar2"></div>
			<div class="bar3"></div>
			
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
				
				
				<li>
				<a id="about-link" >About Us</a>
				</li>
				
				<!--
				<li @click="startSellingModal()">
				<a id="sell-link" >Start Selling</a>
				</li>
				
				<li @click="freeLanceModal()">
				<a id="delivery-link" >Start Freelance Delivery</a>
				</li>
				-->
				<li @click="welcomeLoginModal()">
				<a id="login-link" >Login</a>
				</li>
				<li @click="welcomeRegisterModal()">
				<a id="register-link" >Register</a>
				</li>
			</div>
			
			
			<!--End of navigation class DIV-->
			
			
			<!--Begin welcome-search class DIV-->
			<center>
			<div  class="welcome-search" @click="">
			
			
			<div class="fake-search-input">
			
			<span>Search Anything...Request Everything!</span>
			
			</div>
			
			<img class="search-icon"  width="20px" height="auto" src="{{Storage::url('public/icons/search-icon.png')}}" alt="Search Icon">
			
			</center>
			
			<!--End of welcome-search class DIV-->
			
			
			</div>
			
			<!--End of hidden class div-->
			
			
		</div>
		
		<!--End of header class div-->
		
		
		<!--Begin content-body class div-->
		
		<div id="content-body" class="content-body">
		
		
		<!--Begin main-categories class div-->
		<div class="main-categories">
		
		<div class="category-title">
		<h3> Online Shops . Everywhere <a class="learn-more" style="color:blue;">Edit</a> </h3>		
		</div>
		
		<div class="suggestions">
		<span v-for="shop in allShops" >
		<store  :id="shop.id" :location="shop.location_id" :name="shop.name" :owner="shop.seller.id"></store>
		</span>
		</div>
		
		</div>
		
	<!--End main-categories class div-->
			
		
		</div>
		
		<!--End of content-body class div-->
		
		<!--Begin transaction class button div-->
		@if (auth::check())
		<div class="pending-transaction-button" @click="pendingUrl()">
		
		<div>
		
		<img class="pending-transaction-avatar"  width="30px" height="auto" src="{{Storage::url('public/icons/cart.png')}}"/>
		
		</div>
		
		<span class="pending-transactions">@{{pendingTrans.length}}</span>
		
		</div>
		
		<div class="transaction-button" @click="transactionsUrl()">
		<div>
		
		<img class="transaction-avatar"  width="30px" height="auto" src="{{Storage::url('public/icons/transactions.png')}}"/>
		
		</div>
		<span class="transaction-count">100</span>
		</div>
		
		@endif
		<!--End transaction class button div-->
		
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
		
		<div class="categories" v-if="results.length>0">
			
			
			<!-- Begin Products Class -->
			
			<div class="products">
			 <div  v-for="product in results">
			
			 <img :src="product.image" height="200px" width="300px"  :alt="product.name" />
			
			 <div class="product-details" @click="authStore">
			 <h2> <b> @{{product.name}} </b></h2>
			 
			 <button v-if="product.category_id==3" @click="loginFirst()">Hire @{{product.name}}s Nearby</button>
			 <button v-else @click="loginFirst()">Buy @{{product.name}} Nearby</button>
			</div>
			
		</div>
		<!-- End Product Class -->
		</div>
		</div>
		<!-- End Search Category Class -->
		</div>
		
	<!--End of Search-page class div-->
	 
	 <!--Begin start-selling class div-->

	
	 <div id="start-selling" 
	 class="start-selling {{old('register') ? ' ' : 'hidden' }}" @click="hideStartSellingModal()">
	
	 
	 <!--Begin form-container class div-->	
	  <div class="close">
		x
	 </div>
	 
	 <div class="form-container" @click.stop >
	
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
	  </div>
	  
	
	  <form class="start-selling-form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
	 
	 <table>
	 
	 <tr>
	 <td>First Name</td>
	 <td><input type="text" name="fname" placeholder="First Name" value="{{ old('fname') }}" required autofocus /></td>
	 </tr>
	 @if ($errors->has('fname'))
     <tr>
       <td><strong>{{ $errors->first('fname') }}</strong></td>
     </tr>
     @endif
	 
	 <tr>
	 <td>Middle Name</td>
	 <td><input type="text" name="mname"  placeholder="Middle Name" value="{{ old('mname') }}"  /></td>
	 </tr>
	 @if ($errors->has('mname'))
     <tr>
      <td></td> <td><strong>{{ $errors->first('mname') }}</strong></td>
     </tr>
     @endif
	 
	 <tr>
	 <td>Last Name</td>
	 <td><input type="text" name="lname" placeholder="Last Name" value="{{ old('lname') }}" required /></td>
	 </tr>
	 @if ($errors->has('lname'))
     <tr>
       <td></td> <td><strong>{{ $errors->first('lname') }}</strong></td>
     </tr>
     @endif
	 
	<tr>
	 <td>Avatar</td>
	 <td>
	 <input type="file" ref="productimage"  style="display:none;" accept="image/*" v-on:change="imageChange">
				<span @click="showProductImagePicker" class="image-picker" title="Choose file"  ><img  id="" src="/storage/icons/photo_icon.png" width="15px" height="15px"  alt="" /><span class="photo_icon_text"><b> Select</b></span></span>
	 </td>
	 </tr>
	 
	 <tr>
	 <td>Email</td>
	 <td><input type="email" name="email"  placeholder="xyz@example.com"value="{{ old('email') }}" required /></td>
	 </tr>
	 @if ($errors->has('email'))
     <tr>
        <td></td><td><strong>{{ $errors->first('email') }}</strong></td>
     </tr>
     @endif
	 
	 <tr>
	 <td>Phone Number</td>
	 <td><input type="number" max="9999999999" name="phone" placeholder="Phone number"  value="{{ old('phone') }}" required /></td>
	 </tr>
	 @if ($errors->has('phone'))
     <tr>
       <td></td> <td><strong>{{ $errors->first('phone') }}</strong></td>
     </tr>
     @endif
	 
	
	 
	
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
	 
	  <strong><span><small>By clicking  "Register" you agree to our </small><a class="learn-more">Terms of Service</a> </strong></span>
	 
	 <tr>
	 <td></td>
	 <td><button type="submit">Register</button></td>
	 </tr>
	 
	 
	 </table>
	 
	  <input type="hidden" name="register" value="register">
	 </form>
	 
	 </div>
	 
	 <!--End of form-container class div-->
	 
	 </div>
	 
	  <!--End of start-selling class div-->
	  
	  
	  <!--Begin register class div-->

	
	 <div id="welcome-register" 
	 class="start-selling {{old('reg') ? ' ' : 'hidden' }}" @click="hideWelcomeRegisterModal()">
	
	 
	 <!--Begin form-container class div-->	
	  <div class="close">
		x
	 </div>
	 
	 <div class="form-container" @click.stop >
	
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
	  </div>
	  
	  <form class="start-selling-form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
	 
	 <table>
	 
	 <td>First Name</td>
	 <td><input type="text" name="fname"  placeholder="First Name" value="{{ old('fname') }}" required autofocus /></td>
	 </tr>
	 @if ($errors->has('fname'))
     <tr>
       <td><strong>{{ $errors->first('fname') }}</strong></td>
     </tr>
     @endif
	 
	 <tr>
	 <td>Middle Name</td>
	 <td><input type="text" name="mname"  value="{{ old('mname') }}" placeholder="Middle Name" /></td>
	 </tr>
	 @if ($errors->has('mname'))
     <tr>
      <td></td> <td><strong>{{ $errors->first('mname') }}</strong></td>
     </tr>
     @endif
	 
	 <tr>
	 <td>Last Name</td>
	 <td><input type="text" placeholder="Last Name" name="lname"  value="{{ old('lname') }}" required /></td>
	 </tr>
	 @if ($errors->has('lname'))
     <tr>
       <td></td> <td><strong>{{ $errors->first('lname') }}</strong></td>
     </tr>
     @endif
	 
	
	 <tr>
	 <td>Avatar</td>
	 <td>
	 <input type="file" ref="productimage"  style="display:none;" accept="image/*" v-on:change="imageChange">
				<span @click="showProductImagePicker" class="image-picker" title="Choose file"  ><img  id="" src="/storage/icons/photo_icon.png" width="15px" height="15px"  alt="" /><span class="photo_icon_text"><b> Select</b></span></span>
	 </td>
	 </tr>
	 
	 <div class="showUploaded" v-for="file in productImage">
	 <input type="text" name="avatar"  placeholder="" :value="file.URL"/>
	 </div>
	 
	 <tr>
	 <td>Email</td>
	 <td><input type="email" placeholder="xyz@example.com" name="email"  value="{{ old('email') }}" required /></td>
	 </tr>
	 @if ($errors->has('email'))
     <tr>
        <td></td><td><strong>{{ $errors->first('email') }}</strong></td>
     </tr>
     @endif
	 
	 <tr>
	 <td>Phone Number</td>
	 <td><input type="number" placeholder="Phone Number" max="9999999999" name="phone"  value="{{ old('phone') }}" required /></td>
	 </tr>
	 @if ($errors->has('phone'))
     <tr>
       <td></td> <td><strong>{{ $errors->first('phone') }}</strong></td>
     </tr>
     @endif
	 
	
	 
	
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
	 
	 <strong><span><small>By clicking  "Register" you agree to our </small><a class="learn-more">Terms of Service</a> </strong></span>
	 
	 <tr>
	 <td></td>
	 <td><button type="submit">Register</button></td>
	 </tr>
	 
	 
	 </table>
	 
	  <input type="hidden" name="reg" value="register">
	 </form>
	 
	 </div>
	 
	 <!--End of form-container class div-->
	 
	 </div>
	 
	  <!--End of register class div-->
	  
	 
	
	 
	 
	 
	  
	   <!--Begin freelance class div-->

	
	 <div id="freelance-delivery" 
	 class="start-selling {{old('freelance') ? ' ' : 'hidden' }}" @click="hideFreeLanceModal()">
	
	 
	 <!--Begin form-container class div-->	
	  <div class="close">
		x
	 </div>
	 
	 <div class="form-container" @click.stop >
	
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
	  </div>
	
	 
	  <form class="start-selling-form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
	 
	 <table>
	
	 <tr>
	 <td>First Name</td>
	 <td><input type="text" placeholder="First Name" name="fname"  value="{{ old('fname') }}" required autofocus /></td>
	 </tr>
	 @if ($errors->has('fname'))
     <tr>
       <td><strong>{{ $errors->first('fname') }}</strong></td>
     </tr>
     @endif
	 
	 <tr>
	 <td>Middle Name</td>
	 <td><input placeholder="Middle Name" type="text" name="mname"  value="{{ old('mname') }}"  /></td>
	 </tr>
	 @if ($errors->has('mname'))
     <tr>
      <td></td> <td><strong>{{ $errors->first('mname') }}</strong></td>
     </tr>
     @endif
	 
	 <tr>
	 <td>Last Name</td>
	 <td><input placeholder="Last Name" type="text" name="lname"  value="{{ old('lname') }}" required /></td>
	 </tr>
	 @if ($errors->has('lname'))
     <tr>
       <td></td> <td><strong>{{ $errors->first('lname') }}</strong></td>
     </tr>
     @endif
	 
	<tr>
	 <td>Avatar</td>
	 <td>
	 <input type="file" ref="productimage"  style="display:none;" accept="image/*" v-on:change="imageChange">
				<span @click="showProductImagePicker" class="image-picker" title="Choose file"  ><img  id="" src="/storage/icons/photo_icon.png" width="15px" height="15px"  alt="" /><span class="photo_icon_text"><b> Select</b></span></span>
	 </td>
	 </tr>
	 
	 <tr>
	 <td>Email</td>
	 <td><input type="email" placeholder="xyz@example.com" name="email"  value="{{ old('email') }}" required /></td>
	 </tr>
	 @if ($errors->has('email'))
     <tr>
        <td></td><td><strong>{{ $errors->first('email') }}</strong></td>
     </tr>
     @endif
	 
	 <tr>
	 <td>Phone Number</td>
	 <td><input type="number" placeholder="Phone Number" max="9999999999" name="phone"  value="{{ old('phone') }}" required /></td>
	 </tr>
	 @if ($errors->has('phone'))
     <tr>
       <td></td> <td><strong>{{ $errors->first('phone') }}</strong></td>
     </tr>
     @endif
	 
	
	
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
	 
	  <strong><span><small>By clicking  "Register" you agree to our </small><a class="learn-more">Terms of Service</a> </strong></span>
	 
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
	
	 
	  <form class="welcome-login-form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
	 
	 <table>
	 
	
	 
	 <tr>
	 <td>Email</td>
	 <td><input type="email" placeholder="xyz@example.com"name="email"  value="{{ old('email') }}" required /></td>
	 </tr>
	 @if ($errors->has('email'))
     <tr>
        <td></td><td><strong>{{ $errors->first('email') }}</strong></td>
     </tr>
     @endif

	 
	 
	
	 <tr>
	 <td>Password</td>
	 <td><input  type="password"  name="password"  value="{{ old('password') }}" required /></td>
	 </tr>
	 @if ($errors->has('password'))
     <tr>
        <td></td><td><strong>{{ $errors->first('password') }}</strong></td>
     </tr>
     @endif
	 
	 
	  <strong><span><small>By clicking  "Login" you agree to our </small><a class="learn-more">Terms of Service</a> </strong></span>
	 
	 <tr>
	 <td></td>
	 <td><button type="submit" >Login</button><a @click="showRecoverForm()" class="learn-more">Recover Lost Password</a></td>
	 </tr>
	 
	 
	 </table>
	 
	  <input type="hidden" name="login" value="login">
	 </form>
	 
	 </div>
	 
	 <!--End of form-container class div-->
	 
	 </div>
	 
	  <!--End of welcome-login class div-->
	  
	  <!--Begin recover form class div-->

	
	 <div id="recover-form" 
	 class="start-selling {{old('recover') ? ' ' : 'hidden' }}" @click="hideRecoverForm()">
	
	 
	 <!--Begin form-container class div-->	
	  <div class="close">
		x
	 </div>
	 
	 <div class="form-container" @click.stop >
	
	 
	  <form class="welcome-recover-form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}
	 
	 <table>
	 
	
	 
	 <tr>
	 <td>Email</td>
	 <td><input type="email" name="email" placeholder="xyz@example.com" value="{{ old('email') }}" required /></td>
	 </tr>
	 @if ($errors->has('email'))
     <tr>
        <td></td><td><strong>{{ $errors->first('email') }}</strong></td>
     </tr>
     @endif

	 
       <strong><span><small>By clicking  "Reset Password" you agree to our </small><a class="learn-more">Terms of Service</a> </strong></span>
     
	 
	 <tr>
	 <td></td>
	 <td><button type="submit">Reset Password</button></td>
	 </tr>
	 
	 
	 </table>
	 
	  <input type="hidden" name="recover" value="recover">
	 </form>
	 
	 </div>
	 
	 <!--End of form-container class div-->
	 
	 </div>
	 
	  <!--End of recover class div-->
	  
	 
	 
	  <!--Begin welcome-login class div-->

	
	 <div id="login-first" 
	 class="start-selling {{old('first') ? '' : 'hidden' }}" @click="hideLoginFirst()">
	
	 
	 <!--Begin form-container class div-->	
	  <div class="close">
		x
	 </div>
	 
	 <div class="form-container" @click.stop >
	
	 
	  <form class="welcome-login-form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
	 
	 <table>
	 
	
	 <tr>
	 
	 <tr>
	 <td>Email</td>
	 <td><input type="email" name="email"  value="{{ old('email') }}" placeholder="e.g john@example.com" required /></td>
	 </tr>
	 @if ($errors->has('email'))
     <tr>
        <td></td><td><strong>{{ $errors->first('email') }}</strong></td>
     </tr>
     @endif

	 
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
	 <td></td>
	 <td><button type="submit">Login</button><a @click="showRecoverForm()" class="learn-more">Recover Lost Password</a></td>
	 </tr>
	 
	 
	 </table>
	 
	 
	 
	  <input type="hidden" name="first" value="login-first">
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

