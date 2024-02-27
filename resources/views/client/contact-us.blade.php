@extends('layouts.client')
@section('content')
             <!-- banner section  -->
    <section class="banner" style="text-align: center;
    background-color: #ffffff;
    margin: 0 auto;">
        <img src=
"https://media.geeksforgeeks.org/wp-content/uploads/20230822131732/images.png"
            alt="Welcome to our Contact Us page" style="max-width: 100%;
    height: auto;">
        <h1>Get in Touch With Us</h1>
        <p>
          We would love to responed to your queries and help you succced.
          </p>
    </section>
 
    <!-- Contact form -->
    <section class="contact-form" style="padding: 40px 0;
    margin: 0 10px">
        <div class="form-container" style="max-width: 40%;
    margin: 0 auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1)">
            <h2>Your Details</h2>
            <form  role="form"  action="{{ route('contact.us') }}" method="POST" style="margin-bottom: 20px"  enctype="multipart/form-data">
                @csrf
                <label for="name" style="display:block;
                    font-weight: bold">Name: </label>
                <input type="text" id="name" name="Name" style="
                width: 100%;
                        padding: 10px;
                         border: 1px solid #ccc;
                         border-radius: 4px;
                         margin-bottom: 1rem;
                        resize: vertical" >
 
                <label for="email" style="display:block;
                 font-weight: bold">Email: </label>
                <input type="email" id="email" name="Email" style="
                width: 100%;
                       padding: 10px;
                      border: 1px solid #ccc;
                       border-radius: 4px;
                      margin-bottom: 1rem;
                    resize: vertical" required>
 
                <label for="phone" style="display:block;
                      font-weight: bold">Phone: </label>
                <input type="tel" id="phone" name="Phone" style="
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                 border-radius: 4px;
                margin-bottom: 1rem;
                resize: vertical">
 
                <label for="message" style="display:block;
                        font-weight: bold">Message: </label>
                <textarea id="message" name="Message" rows="4" style="
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                 border-radius: 4px;
                  margin-bottom: 1rem;
                 resize: vertical"required></textarea>
                 <input type="number" value="{{auth()->id()}}" name="user_id" hidden>
 
          <button type="submit" class="submit-button" style="
          padding: 10px 20px;
                background-color: #0dac30;
                  border: none;
                 color: white;
                 border-radius: 4px;
                  font-size: 1rem;
                cursor: pointer;">Submit</button>
            </form>
        </div>
    </section>
        
        
        
        
        
        
        
        
        
        
        
        
    

@endsection



