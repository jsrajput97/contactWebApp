<!DOCTYPE html>
<html>
   <header>
       <title>Not Found</title>
       <link rel="stylesheet" href="{{ URL::to('src/css/main.css') }}">
       <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
       <meta content="utf-8" http-equiv="encoding">
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
       <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">

       <nav class="navbar navbar-default">
           <div class="container-fluid">
               <!-- Brand and toggle get grouped for better mobile display -->
               <div class="navbar-header">
                   <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                       <span class="sr-only">Toggle navigation</span>
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>
                   </button>
                   <a class="navbar-brand" href="{{ route('dashboard') }}">Home</a>
               </div>
           </div><!-- /.container-fluid -->
       </nav>
   </header>
   <body>
      <div class="divnf">
         <h2>The page you are requesting is not found on this site</h2>
      </div>
   </body>

</html>
