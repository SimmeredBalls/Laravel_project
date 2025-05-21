<!DOCTYPE html>
<html lang="en">
   <head>
    @include('home.head')
   </head>
   <!-- body -->
   <body class="main-layout">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#"/></div>
      </div>
      <!-- end loader -->
      <!-- header -->
    @include('home.header')
      <!-- end header inner -->
      <!-- end header -->
    @include('home.contact')
      <!-- end contact -->
      <!--  footer -->
    @include('home.footer')
      <!-- end footer -->
   </body>
</html>